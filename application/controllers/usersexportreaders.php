<?php
class usersexportreaders extends wv43v_action {
	public function initWPaction() {
		wp_register_style ( 'v43v_'.$this->application()->slug.'_css', $this->application ()->pluginuri () . '/application/public/css/style.css', null, $this->application ()->version () );
	}
	public function admin_enqueue_scriptsWPaction() {
		wp_enqueue_style ( 'v43v_'.$this->application()->slug.'_css' );
	}
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
		$comments = new wv43v_data_table ( 'comments' );
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
	LEFT OUTER JOIN `%s` ON `ID` = `user_id` AND `meta_key` = '%scapabilities'
WHERE
	`user_registered` >= '%s'
";
		global $table_prefix;
		$sql = sprintf ( $sql, $this->table('users')->name (), $this->table('usermeta')->name (),$table_prefix, $minDate );
		$results = $this->table()->execute ( $sql );
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
		$settings = $this->data ()->post ( 'options' );
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
	public function exportreadersWPmenuMeta($return) {
		$return ['menu'] = 'Users';
		$return ['title'] = $this->application()->name;
		return $return;
	}
	public function settingsActionMeta($return) {
		$return ['link_name'] = $return ['title'];
		$return ['classes'] [] = 'v43v_icon16x16';
		$return ['classes'] [] = 'v43v_icon16x16_settings';
		$return ['priority'] = - 1;
		return $return;
	}
	public function settingsAction() {
		$this->view->download_url = $this->control_url ( 'readers.csv' );
		$this->view->title = $this->help('settings')->render('Settings');
		$this->view->column_count=2;
		$this->view->table_type='exportreaders_list';
		$this->view->columns = $this->render_script('exportreaders/columns.phtml');
		$this->view->cnt=0;
		$options = $this->application ()->data()->post ( 'options' );
		foreach($options['roles'] as $key=>$value)
		{
			
			$this->view->key=$key;
			$this->view->value=$value;
			$this->view->rows[] = $this->render_script('exportreaders/row.phtml');
		}		
		$this->view->footer = $this->render_script('exportreaders/footer.phtml');
		return $this->render_table();
	}
}
		