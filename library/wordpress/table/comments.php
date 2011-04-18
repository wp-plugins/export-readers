<?php
class wv26v_table_comments extends wv26v_table {
	public function name() {
		return $this->wpdb ()->comments;
	}
}