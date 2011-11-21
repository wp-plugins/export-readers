<?php
class wv39v_mail extends bv39v_mail {
	protected function headercharset() {
		return "charset=\"" . get_option ( 'blog_charset' ) . "\"\n";
	}
	protected function sendit($to, $subject, $message, $headers = "") {
		wp_mail ( $to, $subject, $message, $headers );
	}
}