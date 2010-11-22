<?php
class ExReSettings extends w7v_Table_Options {
	public function defaults() {
		return array ('roles' => array ('Administrator'=>'checked', 'Author'=>'checked', 'Commenter'=>'checked', 'Contributor'=>'checked', 'Editor'=>'checked', 'Subscriber'=>'checked' ), 'comment_count' => 1 );
	}
	public function __construct($key = null) {
		parent::__construct ();
		$this->set_key ( array ('exreader') );
	}
	public function prepare_value($values)
	{
		global $wp_roles;
		$roles = $wp_roles->get_names();
		$roles['commenter'] = 'Commenter';
		$setObj = new ExReSettings();
		foreach($values['roles'] as $key=>$value)
		{
			if(!in_array($key,$roles,true))
			{
				unset($values['roles'][$key]);
			}			
		}
		foreach($roles as $key=>$value)
		{
			if(!isset($values['roles'][$value]))
			{
				$values['roles'][$value]='';
			}			
		}
		ksort($values['roles']);	
		return $values;
	}
}
