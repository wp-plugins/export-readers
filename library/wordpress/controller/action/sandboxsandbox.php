<?php
class wv19v_controller_action_sandboxsandbox extends wv19v_controller_action_adminmenu {
	public function controller_meta() {
		$return = parent::controller_meta ();
		$return ['menu'] = 'Sandbox';
		$return ['title'] = 'Sandbox';
		return $return;
	}
	public function ApplicationsAction($content) {
		$page = '';
		foreach ( $this->application ()->applications () as $application ) {
			$page .= $application->settings ()->application ['name'] . "<br/>";
		}
		$page .= "<br><b>Controlling library is: </b>" . $this->application ()->settings ()->application ['name'];
		return $content . $page;
	}
	public function pagesAction($content) {
		global $submenu;
		global $menu;
		global $_wp_real_parent_file;
		global $_wp_submenu_nopriv;
		global $_registered_pages;
		global $_parent_pages;

	$menu_slug = plugin_basename( 'Settings' );
	$parent_slug = plugin_basename( 'Settings');
		
		$this->debug ( '$menu_slug', $menu_slug, '<br>' );
		$this->debug ( '$parent_slug', $parent_slug, '<br>' );
		$this->debug ( '$submenu', $submenu, '<br>' );
		$this->debug ( '$menu', $menu, '<br>' );
		$this->debug ( '$_wp_real_parent_file', $_wp_real_parent_file, '<br>' );
		$this->debug ( '$_wp_submenu_nopriv', $_wp_submenu_nopriv, '<br>' );
		$this->debug ( '$_registered_pages', $_registered_pages, '<br>' );
		$this->debug ( '$_parent_pages', $_parent_pages, '<br>' );
		return $content;
	}
	public function pathsAction($content) {
		$this->debug ( $this->application ()->loader ()->subfolders (), $this->application ()->loader ()->includepath () );
		return $content;
	}
	public function reWritesAction($content) {
		global $wp_rewrite;
		if ($_SERVER ['REQUEST_METHOD'] == 'POST') {
			$wp_rewrite->flush_rules ();
		}
		$rules = $wp_rewrite->wp_rewrite_rules ();
		$return = "<pre>";
		$return .= print_r ( $rules, true );
		$return .= "</pre>";
		$return .= "<form method='post'><input type=submit value=Flush /></form>";
		return $content . $return;
	}
	public function TestingAction() {
		$this->Debug ( $this->settings ()->all () );
		return;
		$array = array ();
		$array ['one'] ['two'] = 'test';
		$array ['one'] ['three'] = 'test';
		$array ['four'] = 'test';
		$this->Debug ( 'here', $this->convert ( $array ) );
	}
	private function convert($array, $working = null, $keys = null) {
		$return = array ();
		foreach ( $this->map_array ( $array ) as $work ) {
			$key = array_shift ( $work ['keys'] );
			$post = implode ( '][', $work ['keys'] );
			if (! empty ( $post )) {
				$key .= "[$post]";
			}
			$return [$key] = $work ['value'];
		}
		return $return;
	}
	private function map_array($array, $working = null, $keys = null) {
		if ($working === null) {
			$this->working = array ();
		}
		foreach ( $array as $key => $value ) {
			$keys [] = $key;
			if (is_array ( $value )) {
				$working = $this->map_array ( $value, $working, $keys );
			} else {
				$working [] = array ('keys' => $keys, 'value' => $value );
			}
			array_pop ( $keys );
		}
		return $working;
	}
	private function TestingOptGroupAction($content) {
		$string = "option1\ncat1/option2\ncat2/option3\ncat2/scat1/option4\ncat2/scat1/option5\ncat3/option6\ncat2/scat2/option 7";
		$tmpa = explode ( "\n", $string );
		$array = $this->make_opt_array ( $tmpa, '' );
		$options = $this->options ( $array, '' );
		$this->debug ( $_POST );
		echo "<form method='post'>";
		echo "<select name='test'>{$options}</select>";
		echo "<input type=submit></form>";
	}
	
	public function make_opt_array($array, $sep = '/', $base = '') {
		$return = array ();
		foreach ( ( array ) $array as $value ) {
			$key = $base . $value;
			if (! empty ( $sep ) && strpos ( $value, $sep ) !== false) {
				$value = explode ( $sep, $value, 2 );
				$key = $base . $value [0];
				$value = $this->make_opt_array ( $value [1], $sep, $key . $sep );
			}
			if (isset ( $return [$key] )) {
				$return [$key] = array_merge_recursive ( ( array ) $return [$key], ( array ) $value );
			} else {
				$return [$key] = $value;
			}
		}
		return $return;
	}
	public function options($array, $sep = '/', $depth = 0) {
		$return = '';
		$lspaces = str_pad ( '', ($depth) * 4 * 6, '&nbsp;' );
		$ospaces = str_pad ( '', ($depth - 1) * 4 * 6, '&nbsp;' );
		$depth ++;
		$tabs = str_pad ( '', $depth, "\t" );
		foreach ( ( array ) $array as $key => $value ) {
			if (is_array ( $value )) {
				$label = explode ( $sep, $key );
				$label = $label [count ( $label ) - 1];
				$return .= "{$tabs}<optgroup label='{$lspaces}{$label}'>\n";
				$return .= $this->options ( $value, $sep, $depth );
				$return .= "{$tabs}</optgroup>\n";
			} else {
				$return .= "{$tabs}<option value='{$key}'>{$ospaces}{$value}</option>\n";
			}
		}
		return $return;
	}
	public function post_array($array) {
		$key = '';
		$first = true;
		foreach ( $array as $value ) {
			if ($first) {
				$key = $value;
				$first = false;
			} else {
				$key .= "[{$value}]";
			}
		}
		return $key;
	}
}