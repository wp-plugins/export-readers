<?php
class exreapp extends wv30v_settings {
	public function __construct($application)
	{
		parent::__construct($application);
		$this->legacy_move('exreader','options');
	}
}
