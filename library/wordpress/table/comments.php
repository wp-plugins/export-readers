<?php
class wv19v_table_comments extends wv19v_table {
	public function name() {
		return $this->wpdb ()->comments;
	}
}