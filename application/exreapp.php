<?php
if (! class_exists ( 'wv30v_application' )) :
	require_once dirname ( dirname ( __FILE__ ) ) . '/library/wordpress/application.php';
endif;
class exreapp extends wv30v_application {
	public function __construct($application)
	{
		parent::__construct($application);
		$this->legacy_move('exreader','options');
	}
}
