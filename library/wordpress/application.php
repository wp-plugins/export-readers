<?php
if (! class_exists ( 'bv27v_application' )) :
	require_once dirname ( dirname ( __FILE__ ) ) . DIRECTORY_SEPARATOR . 'base/application.php';
	class wv27v_application extends bv27v_application {
		protected function set_frontcontroller() {
			parent::set_frontcontroller ( wv27v_controller_front::getInstance ( $this->application () ) );
		}
		protected $passed_classes = null;
		public function __construct($filename = "", $classes = array(), $handler = 'wv27v_settings') {
			$this->passed_classes = $classes;
			add_action ( "plugins_loaded", array ($this, "setup" ) );
			parent::__construct ( $filename, $handler );
			$this->info = new wv27v_info ( $this );
			add_action ( "admin_menu", array ($this, "pages" ) );
		}
		public function pages() {
			$obj = new wv27v_controller_action_sandboxsandbox ( $this );
			$obj->setup ();
			$obj = new wv27v_controller_action_pluginsandbox ( $this );
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
			array_unshift ( $classes, 'wv27v_info', 'wv27v_values', 'wv27v_table', 'wv27v_table_sitemeta', 'wv27v_table_sites', 'wv27v_table_site', 'wv27v_table_posts', 'wv27v_table_blogs', 'wv27v_table_blog', 'wv27v_table_options', 'wv27v_table_users', 'wv27v_table_usermeta', 'wv27v_view', 'wv27v_controller_action_abstract', 'wv27v_controller_action_action', 'wv27v_controller_action_adminmenu', 'wv27v_controller_action_control', 'wv27v_controller_action_filter', 'wv27v_controller_front', 'wv27v_controller_dispatcher', 'wv27v_table_comments', 'wv27v_settings', 'wv27v_controller_action_pluginsandbox', 'wv27v_controller_action_sandboxsandbox' );
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