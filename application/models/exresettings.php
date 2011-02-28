<?php
class exresettings extends wv15v_settings {
	public function __construct($application)
	{
		parent::__construct($application);
		$this->legacy_move('exreader','options');
	}
/*	public function prepare_value($values)
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
*/}
