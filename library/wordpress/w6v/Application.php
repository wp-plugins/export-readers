<?php
if (! class_exists ( 'b6v_Application' ))
:
	require_once dirname(dirname ( dirname ( __FILE__ ) )) . DIRECTORY_SEPARATOR . 'base/b6v/Application.php';
	class w6v_Application extends b6v_Application
	{

		protected function set_frontcontroller ()
		{
			parent::set_frontcontroller ( w6v_Controller_Front::getInstance ( $this->application () ) );
		}
		
		private $passed_classes = null;
		public function __construct ( $filename = "" ,  $classes = array())
		{
			$this->passed_classes = $classes;
			if (! function_exists ( "wp" ))
			{throw new Exception ( "WordPress has not loaded." );}
			add_action("plugins_loaded",array($this,"setup"));			
			parent::__construct ( $filename );
		}
		public function relative_path ( $uri = null )
		{
			global $current_blog;
			if (null === $uri)
			{
				$uri = $_SERVER ['REQUEST_URI'];
			}
			//$uri = substr ( $uri , strlen ( $current_blog->path ) );
			$uri = substr ( $uri , strlen ( get_option('site_url') ) );
			
			$uri = explode ( '?' , $uri );
			$uri = $uri [0];
			$uri = rtrim ( $uri , '/' );
			$uri = '/' . rtrim ( $uri , '/' );
			return $uri;
		}


		public static function WPload ()
		{
			$path = __FILE__;
			while ( ! empty ( $path ) )
			{
				$path = dirname ( $path );
				$file = $path . DIRECTORY_SEPARATOR . 'wp-load.php';
				if (file_exists ( $file ))
				{return $file;}
			}
		}
		private static $templateDirBase = null;

		private static function templateDirBase ()
		{
			if (is_null ( self::$templateDirBase ))
			{
				self::$templateDirBase = dirname ( dirname ( dirname ( dirname ( dirname ( dirname ( __FILE__ ) ) ) ) ) );
			}
			return self::$templateDirBase;
		}
		private static $templateDir = null;

		public static function templateDir ( $subfolder = null )
		{
			if (! is_null ( $subfolder ) || is_null ( self::$templateDir ))
			{
				self::$templateDir = self::templateDirBase () . DIRECTORY_SEPARATOR . $subfolder;
			}
			return self::$templateDir;
		}
		public function setup()
		{
			load_plugin_textdomain( get_class($this), false, dirname(plugin_basename($this->application()->filename()))."/languages/" );
			
		}
		
		public function preload_classes ( $classes = array() )
		{
			$classes = ( array ) $classes;
			
			array_unshift($classes, 
				 'w6v_Values'   , 'w6v_Table' , 'w6v_Table_Sites' , 'w6v_Table_Site' , 'w6v_Table_SiteMeta' , 'w6v_Table_Posts' , 'w6v_Table_Blogs' , 'w6v_Table_Blog' , 'w6v_Table_Options' , 'w6v_Table_Users' , 'w6v_Table_UserMeta','w6v_View' , 'w6v_Controller_Action_Abstract' , 'w6v_Controller_Action_Action' , 'w6v_Controller_Action_AdminMenu' , 'w6v_Controller_Action_Control' , 'w6v_Controller_Action_Filter' , 'w6v_Controller_Front' , 'w6v_Controller_Dispatcher','w6v_Table_Comments' 
			);
			foreach($this->passed_classes as $class)
			{
				$classes[] = $class;
			}
			parent::preload_classes ( $classes );
		}

		//--- MeetSpec
		public function showError ()
		{
			add_action ( 'init' , array ( 
				$this , 'errorInit' 
			) );
		}

		public function errorInit ()
		{
			add_action ( 'admin_notices' , array ( 
				$this , 'errorNotice' 
			) );
		}

		public function errorNotice ()
		{
			foreach ( ( array ) $this->errors as $errors )
			{
				echo "
				<div class='updated fade'><p>" . sprintf ( $errors , $this->get_name () ) . "</p></div>
				";
			}
		}
	}





endif;