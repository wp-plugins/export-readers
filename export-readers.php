<?php /*
Plugin Name: ExportReaders
Plugin URI: http://wordpress.org/extend/plugins/export-readers/
Description: Selectively export all your reader details ( users and commenters )
Author: dcoda
Author URI: http://dcoda.co.uk
Version: 1.1.0
 */ 
require_once  dirname ( __FILE__ ) . '/library/wordpress/application.php';

new wv25v_application ( __FILE__,array('exrecomments','exreusers'),'exresettings' );
