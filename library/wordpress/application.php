<?php
if (! class_exists ( 'bv26v_application' )) :
	require_once dirname ( dirname ( __FILE__ ) ) . DIRECTORY_SEPARATOR . 'base/application.php';
	class wv26v_application extends bv26v_application {
		protected function set_frontcontroller() {
			parent::set_frontcontroller ( wv26v_controller_front::getInstance ( $this->application () ) );
		}
		protected $passed_classes = null;
		public function __construct($filename = "", $classes = array(), $handler = 'wv26v_settings') {
			$this->passed_classes = $classes;
			add_action ( "plugins_loaded", array ($this, "setup" ) );
			parent::__construct ( $filename, $handler );
			$this->info = new wv26v_info ( $this );
			add_action ( "admin_menu", array ($this, "pages" ) );
		}
		public function pages() {
			$obj = new wv26v_controller_action_sandboxsandbox ( $this );
			$obj->setup ();
			$obj = new wv26v_controller_action_pluginsandbox ( $this );
			$obj->setup ();
		}
		public function relative_path($uri = null) {
			global $current_blog;
			if (null === $uri) {
				$uri = $_SERVER ['REQUEST_URI'];
			}
			//$uri = substr ( $uri , strlen ( $current_blog->path ) );
			$uri = substr ( $uri, strlen ( get_option ( 'site_url' ) ) );
			
			$uri = explode ( '?', $uri );
			$uri = $uri [0];
			$uri = rtrim ( $uri, '/' );
			$uri = '/' . rtrim ( $uri, '/' );
			return $uri;
		}
		public function setup() {
			load_plugin_textdomain ( get_class ( $this ), false, dirname ( plugin_basename ( $this->application ()->filename () ) ) . "/languages/" );
		}
		public function preload_classes($classes = array()) {
			$classes = ( array ) $classes;
			array_unshift ( $classes, 'wv26v_info', 'wv26v_values', 'wv26v_table', 'wv26v_table_sitemeta', 'wv26v_table_sites', 'wv26v_table_site', 'wv26v_table_posts', 'wv26v_table_blogs', 'wv26v_table_blog', 'wv26v_table_options', 'wv26v_table_users', 'wv26v_table_usermeta', 'wv26v_view', 'wv26v_controller_action_abstract', 'wv26v_controller_action_action', 'wv26v_controller_action_adminmenu', 'wv26v_controller_action_control', 'wv26v_controller_action_filter', 'wv26v_controller_front', 'wv26v_controller_dispatcher', 'wv26v_table_comments', 'wv26v_settings', 'wv26v_controller_action_pluginsandbox', 'wv26v_controller_action_sandboxsandbox' );
			foreach ( $this->passed_classes as $class ) {
				$classes [] = $class;
			}
			parent::preload_classes ( $classes );
		}
		private $info = null;
		public function info() {
			return $this->info;
		}
	}


endif;