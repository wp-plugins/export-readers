<?php
class wv39v_blogs extends bv39v_base {
	private $_old_id = array();
	public function swap($id = null) {
		global $wpdb;
		if (null !== $id) {
			array_push($this->_old_id,$wpdb->set_blog_id ( $id ));
		} else {
			if(count($this->_old_id)>0)
			{
				$wpdb->set_blog_id ( array_pop($this->_old_id) );
			}
		}
		wp_cache_reset ();
	}
}