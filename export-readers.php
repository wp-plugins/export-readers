<?php /*
Plugin Name: ExportReaders
Plugin URI: http://wordpress.org/extend/plugins/export-readers/
Description: Selectively export all your reader details ( users & commenters )
Author: dcoda
Author URI: http://dcoda.co.uk
Version: 1.0.2
 */ 
$lib = dirname ( __FILE__ ) . '/library/wordpress/wv15v/Application.php';
if (! file_exists ( $lib )) {
	require_once dirname ( __FILE__ ) . '/' . basename ( __FILE__, '.php' ) . '/' . basename ( __FILE__ );
} else {
	require_once $lib;


	new wv15v_Application ( __FILE__,array('ExReComments','ExReUsers','ExReSettings') );
}
