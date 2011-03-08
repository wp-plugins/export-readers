<?php
if (! class_exists ( 'bv19v_application' )) :
	require_once dirname ( dirname ( __FILE__ ) ) . DIRECTORY_SEPARATOR . 'base/application.php';
	class wv19v_application extends bv19v_application {
		protected function set_frontcontroller() {
			parent::set_frontcontroller ( wv19v_controller_front::getInstance ( $this->application () ) );
		}
		protected $passed_classes = null;
		public function __construct($filename = "", $classes = array(), $handler = 'wv19v_settings') {
			$this->passed_classes = $classes;
			add_action ( "plugins_loaded", array ($this, "setup" ) );
			parent::__construct ( $filename, $handler );
			$this->info = new wv19v_info ( $this );
			add_action ( "admin_menu", array ($this, "pages" ) );
		}
		public function pages() {
			$obj = new wv19v_controller_action_sandboxsandbox ( $this );
			$obj->setup ();
			$obj = new wv19v_controller_action_pluginsandbox ( $this );
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
			array_unshift ( $classes, 'wv19v_info', 'wv19v_values', 'wv19v_table', 'wv19v_table_sitemeta', 'wv19v_table_sites', 'wv19v_table_site', 'wv19v_table_posts', 'wv19v_table_blogs', 'wv19v_table_blog', 'wv19v_table_options', 'wv19v_table_users', 'wv19v_table_usermeta', 'wv19v_view', 'wv19v_controller_action_abstract', 'wv19v_controller_action_action', 'wv19v_controller_action_adminmenu', 'wv19v_controller_action_control', 'wv19v_controller_action_filter', 'wv19v_controller_front', 'wv19v_controller_dispatcher', 'wv19v_table_comments', 'wv19v_settings', 'wv19v_controller_action_pluginsandbox', 'wv19v_controller_action_sandboxsandbox' );
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