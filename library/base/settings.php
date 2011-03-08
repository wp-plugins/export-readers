<?php
class bv19v_settings extends bv19v_controller_action {
		protected $_settings = null;
		public function __get($name) {
			$method = '_' . $name;
			if (method_exists ( $this, $method )) {
				return $this->$method ();
			}
			if(isset($this->_settings[$name]))
			{
				return $this->_settings [$name];
			}
		}
		public function __set($name,$value) {
			$method = '_' . $name;
			if (method_exists ( $this, $method )) {
				$this->$method ($value);
			}
			else
			{
				if(!is_array($this->_settings))
				{
					$this->_settings=(array)$this->_settings;
				}
				$this->_settings [$name] = $value;
			}
		}
		public function __isset($name) {
			return isset ( $this->_settings [$name] );
		}
		public function __unset($name) {
			unset ( $this->_settings [$name] );
		}
	protected function set_lib_settings_locations()
	{
		$array = array();
		$array[]='/library/base/base.xml';
		return $array;
	}
	public function all()
	{
		if(null===$this->_settings)
		{
			$array = $this->set_lib_settings_locations();
			$dir = dirname ( $this->application ()->filename () );
			$combined_settings=array();
			$array[]='/application/application.xml';
			foreach($array as $setting)
			{
				$xml = $this->render_script($dir.$setting);
				$combined_settings=bv19v_type_array::merge_replace_recursive($combined_settings,$xml);
			}
			if(isset($combined_settings['xml']))
			{
				foreach((array)$combined_settings['xml'] as $setting)
				{
					$xml = $this->render_script($dir.$setting);
					$combined_settings=bv19v_type_array::merge_replace_recursive($xml,$combined_settings);
				}
			}
			$this->_settings = $combined_settings;
		}
		return $this->_settings;
	}
	public function refresh()
	{
		$this->_settings=null;
		$this->all();
	}
	
	
	public function __construct($application) {
		parent::__construct($application);
		$this->all();
		$this->config_files ();
	}
	public function config_files() {
		if (! $this->dodebug () || basename($this->application()->filename())=='application') {
			return;
		}
		$this->view->options = $this->all ();
		$this->view->options=$this->view->options['application'];
		$this->view->version = $this->view->options['version'];
		$this->view->name = $this->view->options['name'];
		$color='';
		if(strpos($this->view->version,'a'))
		{
			$this->view->version=str_replace('a','&alpha;',$this->view->version);
			$this->view->name = '&raquo;&raquo;&raquo;&nbsp;'.$this->view->name.'&nbsp;&alpha;';
		}
		if(strpos($this->view->version,'b'))
		{
			$this->view->version=str_replace('b','&beta;',$this->view->version);
			$this->view->name = '&raquo;&raquo;&nbsp;'.$this->view->name.'&nbsp;&beta;';
		}
		if(strpos($this->view->version,'c'))
		{
			$this->view->version=str_replace('c','&gamma;',$this->view->version);
			$this->view->name = '&raquo;&nbsp;'.$this->view->name.'&nbsp;&gamma;';
		}
		$this->view->handler='';
		if(isset($this->view->options['handler']))
		{
			$this->view->handler= ",'".$this->view->options['handler']."'";
		}
		foreach($this->view->options['tags'] as $key=>$value)
		{
			if(empty($value))
			{
				unset($this->view->options['tags'][$key]);
			}
		}
		array_unique($this->view->options['tags']);
		sort($this->view->options['tags']);
		$this->view->preloads = trim ( implode ( "','", (array)$this->view->options ['preload']  ) );
		if ($this->view->preloads != '') {
			$this->view->preloads = "'" . $this->view->preloads . "'";
		}
		$page2 = '<?php ' . $this->render_script ( 'common/plugin.phtml',false,false );
		if(isset($this->view->options['sections']['Changelog']))
		{
			unset($this->view->options['sections']['Changelog']);
		}
		$page = $this->render_script ( 'common/readme.phtml',false,false );
		$plugin = $this->application ()->filename ();
		$readme = dirname ( $plugin ) . '/readme/readme.txt';
		$oldpage=file_get_contents ( $readme );
		$newpage=explode('== Description ==',$oldpage);
		$newpage[0]=$page;
		$newpage=implode('== Description ==',$newpage);
		if ($oldpage != $newpage) {
			@file_put_contents ( $readme, $newpage );
		}
		$oldpage2=file_get_contents ( $plugin );
		if ($oldpage2 != $page2) {
			@file_put_contents ( $plugin, $page2 );
		}
		return $page;
	}
	public function cmp($a, $b) {
		if (( int ) $a ['priority'] == $b ['priority']) {
			return 0;
		}
		return (( int ) $a ['priority'] < ( int ) $b ['priority']) ? - 1 : 1;
	}
}