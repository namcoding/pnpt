<?php
class Auto_load{
	public function model($model_name){
		if($this->check_exists('model',$model_name)){
			require_once(SYSPATH."model.class.php");
			require_once(MODELPATH.$model_name.".php");
			$model=ucfirst($model_name);
			return new $model();
		}
	}
	public function library($library_name){
		if($this->check_exists('library',$library_name)){
			require_once(SYSPATH."library.class.php");
			if(file_exists(BASEPATH.'system/library/'.$library_name.".class.php")){
				require_once(BASEPATH.'system/library/'.$library_name.".class.php");
			}
			else if(file_exists(APPPATH.'library/'.$library_name.".class.php")){
				require_once(APPPATH.'library/'.$library_name.".class.php");
			}
			$library=ucfirst($library_name);
			return new $library();
		}
	}
	function check_exists($type,$name){
		if($type=="model"){
			if(!file_exists(MODELPATH.$name.".php")){
				echo "Your model $name exists. Please open the following file and correct this: ".SELF;
				exit(3); // EXIT_CONFIG
			}
			else return true;
		}
		else if($type=="library"){
			if(!file_exists(BASEPATH.'/system/library/'.$name.".class.php") && !file_exists(APPPATH.'library/'.$name.".class.php")){
				echo "Your library <b>$name.class.php</b> not exists. Please open the following file and correct this: ".SELF;
				exit(3); // EXIT_CONFIG
			}
			else return true;
		}
		else if($type=="function"){
			if(!file_exists(APPPATH.'function/'.$name.".php") && !file_exists(SYSPATH.'funcction/'.$name.".php")){
				echo "Your function $name not exists. Please open the following file and correct this: ".SELF;
				exit(3); // EXIT_CONFIG
			}
			else return true;
		}
	}
 }
?>
