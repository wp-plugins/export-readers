<?php
class SettingsExportReadersController extends w8v_Controller_Action_AdminMenu {
	public function SettingsAction($content)
	{
		$setObj = new ExReSettings();
		$this->view->settings = $setObj->post();
		$this->view->download_url=$this->control_url('readers.csv');
		return $content.$this->updated();
	}
}
		