
<?php
	/* load environment
	* @config
	*@router
	*/
	//load config application
	if(!file_exists(APPPATH."config/database.config.php")){
		header('HTTP/1.1 503 Service Unavailable.', TRUE, 503);
		echo 'Your appication folder path does not appear to be set correctly. Please open the following file and correct this: '.SELF;
		exit(3); // EXIT_CONFIG
	}
	require_once(APPPATH."config/database.config.php");
	//load controller class
	if(!file_exists(SYSPATH."controller.class.php")){
		header('HTTP/1.1 503 Service Unavailable.', TRUE, 503);
		echo 'Your sys folder path does not appear to be set correctly. Please open the following file and correct this: '.SELF;
		exit(3); // EXIT_CONFIG
	}
	require_once(SYSPATH."controller.class.php");
	
	//load router class
	if(!file_exists(SYSPATH."router.class.php")){
		header('HTTP/1.1 503 Service Unavailable.', TRUE, 503);
		echo 'Your sys folder path does not appear to be set correctly. Please open the following file and correct this: '.SELF;
		exit(3); // EXIT_CONFIG
	}
	require_once(SYSPATH."router.class.php");
	
	//load router array class
	if(!file_exists(APPPATH."config/router.config.php")){
		header('HTTP/1.1 503 Service Unavailable.', TRUE, 503);
		echo 'Your sys folder path does not appear to be set correctly. Please open the following file and correct this: '.SELF;
		exit(3); // EXIT_CONFIG
	}
	require_once(APPPATH."config/router.config.php");
	?>
