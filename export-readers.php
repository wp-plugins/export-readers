<?php /*
Plugin Name: &nbsp;ExportReaders
Plugin URI: http://wordpress.org/extend/plugins/export-readers/
Description: Selectively export all your reader details ( users and commenters )
Author: dcoda
Author URI: http://dcoda.co.uk
Version: 1.2.0.26
 */ 
require_once  dirname ( __FILE__ ) . '/library/wordpress/application.php';
@include_once (ABSPATH.'wp-admin/includes/plugin-install.php');
	
new wv26v_application ( __FILE__,array('exrecomments','exreusers'),'exresettings' );
