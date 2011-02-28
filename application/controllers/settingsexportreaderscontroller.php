<?php
class settingsexportreaderscontroller extends wv15v_controller_action_adminmenu {
	public function ControllerMeta() {
//		if(null!==$this->settings())
//		{
//			return 'settings' . $this->settings ()->application['name'];
//		}
		return null;
	}
	public function settingsAction($content)
	{
		$this->view->settings = $this->settings()->post('options');
		$this->view->download_url=$this->control_url('readers.csv');
		return $content.$this->updated();
	}
}
		