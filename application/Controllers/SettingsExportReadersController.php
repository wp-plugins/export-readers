<?php
class SettingsExportReadersController extends wv15v_Controller_Action_AdminMenu {
	public function SettingsAction($content)
	{
		$setObj = new ExReSettings($this->application());
		$this->view->settings = $setObj->post('options');
		$this->view->download_url=$this->control_url('readers.csv');
		return $content.$this->updated();
	}
}
		