<?php
class exportreadersfilters extends wv26v_controller_action_filter {
	protected function plugin_links()
	{
		$return = parent::plugin_links();
		$return['settings'] = array('url'=>$this->dashboard_url('Users',$this->settings()->application['name']),'text'=>'Settings');
		return $return;
	}
}
		