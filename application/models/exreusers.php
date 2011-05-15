<?php
class exreusers extends wv28v_table_users
{
	public function Users($minDate='1970-01-01 00:00:00')
	{
		$sql = 
"
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
		$sql = sprintf($sql,$this->name(),$this->meta->name(),$minDate);
		$results = $this->wpdb ()->get_results ( $sql , ARRAY_A );
		foreach($results as $key=>$value)
		{
			$results[$key]['role'] = implode(' ',array_keys((array)unserialize($value['role'])));
		}
		return $results;
	}
	
}
