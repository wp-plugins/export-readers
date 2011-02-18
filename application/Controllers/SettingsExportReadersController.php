<?php
class SettingsExportReadersController extends wv15v_Controller_Action_AdminMenu {
	public function SettingsAction($content)
	{
		$this->view->settings = $this->settings()->post('options');
		$this->view->download_url=$this->control_url('readers.csv');
		return $content.$this->updated();
	}
}
		