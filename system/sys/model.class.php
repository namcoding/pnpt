<?php 
	class Pnpt_model{
		private static $instance;
		protected $load;
	    public function __construct(){
			self::$instance =& $this;
		}
		public static function &get_instance(){
			return self::$instance;
		}
		function get_method($method){
			$obj= new $this;
			//var_dump($obj);
			return function() use($obj,$method){
			$args = func_get_args();
			return call_user_func_array(array($obj, $method), $args);          
			};
		}
		public function load(){
			if(!file_exists(SYSPATH."load_class.php")){
				header('HTTP/1.1 503 Service Unavailable.', TRUE, 503);
				echo 'Your appication folder path does not appear to be set correctly. Please open the following file and correct this: '.SELF;
				exit(3); // EXIT_CONFIG
			}
			require_once(SYSPATH."load_class.php");
			return new Auto_load;
		}
	}
	
?>
