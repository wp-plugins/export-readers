<?php
class usersexportreaders extends wv19v_controller_action_adminmenu {
	public function controller_meta()
	{
		$return = parent::controller_meta();
		$return['menu'] = 'Users';
		return $return;
	}
	public function settingsAction($content)
	{
		$this->view->settings = $this->settings()->post();
		$this->view->download_url=$this->control_url('readers.csv');
		return $content.$this->updated();
	}
}
		