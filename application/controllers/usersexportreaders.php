<?php
class usersexportreaders extends wv30v_controller_action_wphooks {
	public function readers_csvWPpage() {
		if($this->get_user_role()!='administrator')
		{
			return;
		}
		$this->send_headers ('readers.csv');
		//$this->txt_headers ();
		$settings = $this->settings()->post ('options');
		$comments = new ExReComments ( );
		$com = $comments->Commenters ( $settings ['comment_count'] );
		$users = new ExReUsers ( );
		$us = $users->Users ();
		$roles = array ();
		foreach ( $settings ['roles'] as $key => $value ) {
			$roles [] = strtolower ( $key );
		}
		$data = array ();
		foreach ( $us as $value ) {
			if (in_array ( $value ['role'], $roles )) {
				$data [] = $value;
			}
		}
		foreach ( $com as $value ) {
			if (in_array ( $value ['role'], $roles )) {
				$data [] = $value;
			}
		}
		if (count ( $data ) > 0) {
			echo implode ( ',', array_keys ( $data [0] ) ) . "\n";
		}
		foreach ( $data as $datum ) {
			echo implode ( ',', $datum ) . "\n";
		}
	}
	private function get_user_role() {
		global $current_user;
		
		$user_roles = $current_user->roles;
		$user_role = array_shift ( $user_roles );
		
		return $user_role;
	}
	public function exportWPmenuMeta($return)
	{
		$return['menu'] = 'Users';
		$return['title'] = $this->settings()->application['name'];
		return $return;
	}
	public function settingsActionMeta($return)
	{
		$return ['link_name'] = $return ['title'];
		$return ['classes'] [] = 'v30v_settings';
		$return['priority'] = -1;
		return $return;
	}
	public function settingsAction()
	{
		$this->view->settings = $this->settings()->post('options');
		$this->view->download_url=$this->control_url('readers.csv');
		//return $content.$this->updated();
	}
	public function getting_startedActionMeta($return)
	{
		$return ['link_name'] = $return ['title'];
		$return ['classes'] [] = 'v30v_info';
		return $return;
	}
}
		