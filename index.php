<?php 
	$application_folder="application";
	$system_folder="system";
	$view_folder="";
	$model_folder="";
	$function_folder="";
	chdir(dirname(__FILE__));
	if (($_temp = realpath($system_path)) !== FALSE){
		$system_path = $_temp.'/';
	}
	else{
		$system_path = rtrim($system_path, '/').'/';
	}
	if ( ! is_dir($system_path)){
		header('HTTP/1.1 503 Service Unavailable.', TRUE, 503);
		echo 'Your system folder path does not appear to be set correctly. Please open the following file and correct this: '.pathinfo(__FILE__, PATHINFO_BASENAME);
		exit(3);
	}
// The name of THIS file
	define('SELF', pathinfo(__FILE__, PATHINFO_BASENAME));
// Path to the system folder
	define('BASEPATH', str_replace('\\', '/', $system_path));
// Path to the sys folder
	define('SYSPATH', BASEPATH.$system_folder."/sys".DIRECTORY_SEPARATOR);
// Path to the front controller (this file)
	define('FCPATH', dirname(__FILE__).'/');
// Name of the "system folder"
	define('SYSDIR', trim(strrchr(trim(BASEPATH, '/'), '/'), '/'));
// The path to the "application" folder
	if (is_dir($application_folder)){
		if (($_temp = realpath($application_folder)) !== FALSE){
			$application_folder = $_temp;
		}
		define('APPPATH', $application_folder.DIRECTORY_SEPARATOR);
	}
	else{
		if ( ! is_dir(BASEPATH.$application_folder.DIRECTORY_SEPARATOR)){
			header('HTTP/1.1 503 Service Unavailable.', TRUE, 503);
			echo 'Your application folder path does not appear to be set correctly. Please open the following file and correct this: '.SELF;
			exit(3); // EXIT_CONFIG
		}
		define('APPPATH', BASEPATH.$application_folder.DIRECTORY_SEPARATOR);
	}
// The path to the "views" folder
	if ( ! is_dir($view_folder)){
		if ( ! empty($view_folder) && is_dir(APPPATH.$view_folder.DIRECTORY_SEPARATOR)){
			$view_folder = APPPATH.$view_folder;
		}
		elseif ( ! is_dir(APPPATH.'view'.DIRECTORY_SEPARATOR)){
			header('HTTP/1.1 503 Service Unavailable.', TRUE, 503);
			echo 'Your view folder path does not appear to be set correctly. Please open the following file and correct this: '.SELF;
			exit(3); // EXIT_CONFIG
		}
		else{
			$view_folder = APPPATH.'view';
		}
	}
	if (($_temp = realpath($view_folder)) !== FALSE){
		$view_folder = $_temp.DIRECTORY_SEPARATOR;
	}
	else{
		$view_folder = rtrim($view_folder, '/\\').DIRECTORY_SEPARATOR;
	}
	define('VIEWPATH', $view_folder);
	
	
//the model path
	if ( ! is_dir($model_folder)){
		if ( ! empty($model_folder) && is_dir(APPPATH.$model_folder.DIRECTORY_SEPARATOR)){
			$model_folder = APPPATH.$model_folder;
		}
		elseif ( ! is_dir(APPPATH.'model'.DIRECTORY_SEPARATOR)){
			header('HTTP/1.1 503 Service Unavailable.', TRUE, 503);
			echo 'Your view folder path does not appear to be set correctly. Please open the following file and correct this: '.SELF;
			exit(3); // EXIT_CONFIG
		}
		else{
			$model_folder = APPPATH.'model';
		}
	}
	if (($_temp = realpath($model_folder)) !== FALSE){
		$model_folder = $_temp.DIRECTORY_SEPARATOR;
	}
	else{
		$model_folder = rtrim($model_folder, '/\\').DIRECTORY_SEPARATOR;
	}
	define('MODELPATH', $model_folder);
	
	
	
		if ( ! is_dir($function_folder)){
		if ( ! empty($function_folder) && is_dir(APPPATH.$function_folder.DIRECTORY_SEPARATOR)){
			$function_folder = APPPATH.$function_folder;
		}
		elseif ( ! is_dir(APPPATH.'function'.DIRECTORY_SEPARATOR)){
			header('HTTP/1.1 503 Service Unavailable.', TRUE, 503);
			echo 'Your function folder path does not appear to be set correctly. Please open the following file and correct this: '.SELF;
			exit(3); // EXIT_CONFIG
		}
		else{
			$function_folder = APPPATH.'function';
		}
	}
	if (($_temp = realpath($function_folder)) !== FALSE){
		$function_folder = $_temp.DIRECTORY_SEPARATOR;
	}
	else{
		$function_folder = rtrim($function_folder, '/\\').DIRECTORY_SEPARATOR;
	}
	define('FUNCTIONPATH', $function_folder);
	
	
	//load environment
	if(!file_exists(SYSPATH."load_environment.php")){
		header('HTTP/1.1 503 Service Unavailable.', TRUE, 503);
		echo 'Your appication folder path does not appear to be set correctly. Please open the following file and correct this: '.SELF;
		exit(3); // EXIT_CONFIG
	}
	require_once(SYSPATH."load_environment.php");

	//router
	
	$router = new Routes($router_config);
	extract($router->run());
	$class_control= strtolower($controller);
	if(!file_exists(APPPATH.'controller/'.$class_control.".php")){
		echo "Your controller $class_control not exit";
		exit(3); // EXIT_CONFIG
	}
	
	//load controller
	
	
	require_once(APPPATH.'controller/'.$class_control.".php");
	$controller = new $controller();
	$controller->run($method,$id);
	
	//load function 
	
	foreach($controller::$function as $value){
		require_once($value);
	}
	?>
