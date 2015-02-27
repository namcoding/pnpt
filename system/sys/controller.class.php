<?php 
	class Pnpt_controller{
		private static $instance;
		protected $model=array();
		protected $library=array();
		public static $function=array();
		protected static $view;
	    public function __construct(){
			self::$instance =& $this;
			global $nam1;
			$nam1=200;
		}
		public static function &get_instance(){
			return self::$instance;
		}
		public function load_model($model_name){
			$this->model[$model_name]=$this->load('model')->model($model_name);
			return $this->load('model')->model($model_name);
		}
		public function load_function($function_name){
			if(is_array($function_name)){
				foreach ($function_name as $key=>$value){
					if(file_exists(BASEPATH.'system/function/'.$value.".php")){
						$path=BASEPATH.'system/function/'.$value.".php";
					}
					else if(file_exists(FUNCTIONPATH.$value.".php")){
						$path=FUNCTIONPATH.$value.".php";
					}
					else {
						echo "the function $value not exists";
						exit();
					}
					
						static::$function[]=$path;
				}
			}
			else{
				if(file_exists(BASEPATH.'system/function/'.$function_name.".php")){
						$path=BASEPATH.'system/function/'.$function_name.".php";
					}
					else if(file_exists(FUNCTIONPATH.$function_name.".php")){
						$path=FUNCTIONPATH.$function_name.".php";
					}
					else {
						echo "the function $function_name not exists";
						exit();
					}
					
						static::$function[]=$path;
			}
		}
		public function load_library($library_name){
			$this->library[$library_name]=$this->load('library')->library($library_name);
			return $this->load('library')->library($library_name);
		}
		public function load_view($view_name,$data){
			if(file_exists(VIEWPATH.$view_name)){
				if(is_array($data))extract($data);
				ob_start();
				require(VIEWPATH.$view_name);
				$output = ob_get_contents();
				static::$view .=$output;
				@ob_end_clean();
			}
		}
		function get_method($method,$id){
			$obj= new $this;
			return function($id) use($obj,$method){
			$args = func_get_args();
			return call_user_func_array(array($obj, $method), $args);          
			};
		}
		protected function load($type){
			if(!file_exists(SYSPATH."load_class.php")){
				header('HTTP/1.1 503 Service Unavailable.', TRUE, 503);
				echo 'Your acation folder path does not appear to be set correctly. Please open the following file and correct this: '.SELF;
				exit(3); // EXIT_CONFIG
			}
			require_once(SYSPATH."load_class.php");
			return new Auto_load;
		}
		function run($method,$id){
			$function=$this->get_method($method,$id);
			echo $function($id);
			echo static::$view;
		}
	}
	
?>
