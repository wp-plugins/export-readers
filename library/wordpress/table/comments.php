<?php
class wv27v_table_comments extends wv27v_table {
	public function name() {
		return $this->wpdb ()->comments;
	}
}