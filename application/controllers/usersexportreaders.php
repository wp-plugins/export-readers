<?php
class usersexportreaders extends wv25v_controller_action_adminmenu {
	public function controller_meta()
	{
		$return = parent::controller_meta();
		$return['menu'] = 'Users';
		return $return;
	}
	public function settingsAction($content)
	{
		$this->view->settings = $this->settings()->post('options');
		$this->view->download_url=$this->control_url('readers.csv');
		return $content.$this->updated();
	}
}
		