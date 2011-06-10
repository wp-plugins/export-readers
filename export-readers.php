<?php /*
Plugin Name: ExportReaders
Plugin URI: http://wordpress.org/extend/plugins/export-readers/
Description: Selectively export all your reader details ( users and commenters )
Author: dcoda
Author URI: http://dcoda.co.uk
Version: 1.2.30
 */ 
require_once  dirname ( __FILE__ ) . '/application/exreapp.php';
new exreapp ( __FILE__);
