<?php
class bv39v_request extends bv39v_base {
	public function is_post()
	{
		return ($_SERVER ['REQUEST_METHOD'] == 'POST');
	}
}