<?php
class exportreadersfilters extends wv28v_controller_action_filter {
	protected function plugin_links()
	{
		$return = parent::plugin_links();
		$menu = $this->find_submenu('Users',$this->settings()->application['name']);
		$return['settings'] = array('url'=>$menu['menu'][2].'?page='.$menu[2],'text'=>'Settings');
		$return['gettingstarted'] = array('url'=>$menu['menu'][2].'?page='.$menu[2].'&page2=getting_started','text'=>'Getting Started');
		return $return;
	}
}
		