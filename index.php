<?php /*
Plugin Name: ExportReaders
Plugin URI: http://exportreaders.dcoda.co.uk/
Description: Selectively export all your reader details ( users and commenters )
Author: dcoda
Author URI: 
Version: 1.3.43
License: GPLv2 or later
*/
@require_once  dirname ( __FILE__ ) . '/library/wordpress/application.php';
if (class_exists("wv46v_application"))
{
	new wv46v_application ( __FILE__);
}