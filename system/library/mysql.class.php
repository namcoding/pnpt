<?php 
	if(!file_exists(APPPATH."config/database.config.php")){
		echo "your website hacked";
		exit();
	}
	class Mysql{
		function __construct(){
			//$connect=mysql_connect($config['host'],$config['username'],$config['password']) or die("not connect");
		}
		function result(){
			return "library da thuc hien";
		}
	}
?>
