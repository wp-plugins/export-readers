<?php
class exrecomments extends wv30v_table_comments
{
	public function Commenters($minComments=1,$minDate='1970-01-01 00:00:00')
	{
		$sql = 
"
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
		$sql = sprintf($sql,$this->name(),$minDate,$minComments);
		$results = $this->wpdb ()->get_results ( $sql , ARRAY_A );
		return $results;
	}
}
