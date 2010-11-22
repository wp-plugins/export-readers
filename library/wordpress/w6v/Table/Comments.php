<?php
class w6v_Table_Comments extends w6v_Table
{

	public function name ()
	{
		return $this->wpdb ()->comments;
	}
}
