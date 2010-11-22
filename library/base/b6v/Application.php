<?php
if (! class_exists ( 'b6v_Application' )) :
	require dirname ( __FILE__ ) . '/Base.php';
	class b6v_Application extends b6v_Base {
		private $_page = null;
		
		public function page() {
			if (null === $this->_page) {
				$this->set_page ();
			}
			return $this->_page;
		}
		
		public function set_page($page = null) {
			if (null === $page) {
				$this->_page = $this->relative_path ();
			} else {
				$this->_page = '/' . ltrim ( rtrim ( $page, '/' ), '/' );
			}
		}
		
		public function relative_path($uri = null) {
			if (null === $uri) {
				$uri = $_SERVER ['REQUEST_URI'];
			}
			$uri = explode ( '?', $uri );
			$uri = $uri [0];
			$uri = rtrim ( $uri, '/' );
			$project = dirname ( $this->filename () );
			$root_uri = $uri;
			while ( strpos ( $project, $root_uri ) === false ) {
				$root_uri = substr ( $root_uri, 0, strrpos ( $root_uri, '/' ) );
			}
			$uri = '/' . ltrim ( rtrim ( substr ( $uri, strlen ( $root_uri ) ), '/' ), '/' );
			return $uri;
		}
		//--- filename
		private $_filename = null;
		
		public function filename() {
			return $this->_filename;
		}
		//--- applications
		private static $_applications = array ();
		
		public function applications() {
			return self::$_applications;
		}
		
		private function add_application() {
			self::$_applications [] = $this;
		}
		
		//--- contructor
		public function __construct($filename = "") {
			if ($this->MeetsSpec ()) {
				$this->set_loaded ();
				parent::__construct ( $this );
				$this->_filename = $filename;
				$this->preload_classes ();
				$this->set_frontcontroller ();
				$this->add_application ();
			}
		}
		private $settings = null;
		public function settings() {
			if (null == $this->settings) {
				$this->settings = new b6v_Settings ( $this );
			}
			return $this->settings;
		}
		//---
		private $_frontController;
		
		public function frontcontroller() {
			$this->set_frontcontroller ();
			return $this->_frontcontroller;
		}
		
		protected function set_frontcontroller($controller = null) {
			if (null === $controller) {
				$this->_frontcontroller = b6v_Controller_Front::getInstance ( $this->application () );
			} else {
				$this->_frontcontroller = $controller;
			}
		}
		//--- loader
		private $_loader = null;
		
		public function loader() {
			return $this->_loader;
		}
		
		protected function set_loader() {
			if (! class_exists ( 'b6v_Loader' )) {
				require_once dirname ( dirname ( __FILE__ ) ) . DIRECTORY_SEPARATOR . 'b6v/Loader.php';
			}
			$this->_loader = new b6v_Loader ( $this );
			$this->_loader->add_subfolder ( 'application' );
			$this->_loader->add_subfolder ( 'application/Models' );
		}
		
		//--- meet spec
		protected function phpmin() {
			return '5.2.0';
		}
		protected $errors = null;
		
		protected function MeetsSpec() {
			$this->errors = array ();
			if (version_compare ( phpversion (), $this->phpmin () ) >= 0) {
				$this->set_loader ();
				if (! class_exists ( 'b6v_Loader' )) {
					require_once dirname ( dirname ( __FILE__ ) ) . DIRECTORY_SEPARATOR . 'b6v/Loader.php';
				}
				$db = debug_backtrace ();
				$file = $db ['1'] ['file'];
				b6v_Loader::addRoot ( $file );
				return true;
			}
			$this->errors [] = "%s requires a minimum of PHP " . $this->phpmin ();
			$this->showError ();
			return false;
		}
		
		protected function showError() {
			foreach ( ( array ) self::$errors as $error ) {
				printf ( $error, $this->name () );
			}
		}
		
		//--- autoload
		protected function preload_classes($classes = array()) {
			$classes = ( array ) $classes;
			$loader = $this->loader ();
			array_unshift ( $classes, 'b6v_Controller_Action', 'b6v_Type_Abstract', 'b6v_Type_String', 'b6v_Type_Array', 'b6v_Debug', 'b6v_FS', 'b6v_View', 'b6v_Http', 'b6v_Tag', 'b6v_Data_Abstract', 'b6v_Data_INI', 'b6v_Data_CSV', 'b6v_Data_XML', 'b6v_FS', 'b6v_Http', 'b6v_Controller_Front', 'b6v_Controller_Dispatcher', 'b6v_Table', 'b6v_Controller_Action_Direct', 'b6v_Settings' );
			foreach ( $classes as $class ) {
				$loader->load_class ( $class );		
			}
		}
		//--- app loaded
		private $_apploaded = false;
		
		protected function apploaded() {
			return $this->apploaded;
		}
		
		protected function set_apploaded() {
			$this->_apploaded = true;
		}
		//--- name
		private $_loaded = false;
		
		protected function set_loaded() {
			$this->_loaded = true;
		}
	}


endif;