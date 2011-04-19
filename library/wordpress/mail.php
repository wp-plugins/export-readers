<?php
class wv27v_mail extends bv27v_mail {
	protected function headercharset() {
		return "charset=\"" . get_option ( 'blog_charset' ) . "\"\n";
	}
	protected function sendit($to, $subject, $message, $headers = "") {
		wp_mail ( $to, $subject, $message, $headers );
	}
}