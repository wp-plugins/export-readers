<?php
class readersCSVController extends w6v_Controller_Action_Control {
	public function indexAction() {
		if($this->get_user_role()!='administrator')
		{
			return;
		}
		$this->csv_headers ('readers.csv');
		$setObj = new ExReSettings ( );
		$settings = $setObj->post ();
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
}
