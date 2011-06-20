<?php
class usersexportreaders extends wv30v_action {
	public function readers_csvWPpageMeta($return) {
		$return ['slug'] = 'readers.csv';
		return $return;
	}
	public function Commenters($minComments = 1, $minDate = '1970-01-01 00:00:00') {
		$sql = "
SELECT
	`comment_author` 'name',
	`comment_author_email` 'email',
	`comment_author_url` 'url',
	min(`comment_date`) 'date',
	'commenter' AS 'role'
FROM
	`%s`
WHERE
	`comment_approved` = 1 AND
	`user_id` = 0 AND 
	`comment_date` >= '%s'
GROUP BY
	`comment_author`,
	`comment_author_email`,
	`comment_author_url`,
	`comment_date`
HAVING
	count(*) >= %d
";
		$comments = new wv30v_data_table ( 'comments' );
		$sql = sprintf ( $sql, $comments->name (), $minDate, $minComments );
		$results = $comments->execute ( $sql );
		return $results;
	}
	public function Users($minDate = '1970-01-01 00:00:00') {
		$sql = "
SELECT
	`display_name` 'name',
	`user_email` 'email',
	`user_url` 'url',
	`user_registered` 'date', 
	`meta_value` 'role'
FROM
	`%s`
	LEFT OUTER JOIN `%s` ON `ID` = `user_id` AND `meta_key` = 'wp_capabilities'
WHERE
	`user_registered` >= '%s'
";
		$users = new wv30v_data_table ( 'users' );
		$usermeta = new wv30v_data_table ( 'usermeta' );
		$sql = sprintf ( $sql, $users->name (), $usermeta->name (), $minDate );
		$results = $users->execute ( $sql );
		foreach ( $results as $key => $value ) {
			$results [$key] ['role'] = implode ( ' ', array_keys ( ( array ) unserialize ( $value ['role'] ) ) );
		}
		return $results;
	}
	public function readers_csvWPpage() {
		if ($this->get_user_role () != 'administrator') {
			return;
		}
		$this->send_headers ( 'readers.csv' );
		//$this->txt_headers ();
		$settings = $this->settings ()->post ( 'options' );
		$com = $this->Commenters ( $settings ['comment_count'] );
		$us = $this->Users ();
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
	public function exportWPmenuMeta($return) {
		$return ['menu'] = 'Users';
		$return ['title'] = $this->settings ()->application ['name'];
		return $return;
	}
	public function settingsActionMeta($return) {
		$return ['link_name'] = $return ['title'];
		$return ['classes'] [] = 'v30v_settings';
		$return ['priority'] = - 1;
		return $return;
	}
	public function settingsAction() {
		$this->view->settings = $this->settings ()->post ( 'options' );
		$this->view->download_url = $this->control_url ( 'readers.csv' );
	}
	public function getting_startedActionMeta($return) {
		$return ['link_name'] = $return ['title'];
		$return ['classes'] [] = 'v30v_info';
		return $return;
	}
}
		