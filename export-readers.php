<?php /*
Plugin Name: ExportReaders
Plugin URI: http://wordpress.org/extend/plugins/export-readers/
Description: Selectively export all your reader details ( users and commenters )
Author: dcoda
Author URI: http://dcoda.co.uk
Version: 1.1.0&beta;
 */ 
require_once  dirname ( __FILE__ ) . '/library/wordpress/wv15v/application.php';

new wv15v_Application ( __FILE__,array('ExReComments','ExReUsers'),'ExReSettings' );
