<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); 
/**
 * Classloader CodeIgniter library
 * 
 * @author Are Nybakk <are[at]arenybakk.com>
 * @copyright Copyright 2011, Are Nybakk
 * @license http://www.opensource.org/licenses/mit-license.php MIT license
 */
class Classloader {
  private $classLoader;
  public function __construct() {
    //We need the ClassLoader file
    if(!file_exists(SYSPATH."load_class.php")){
			header('HTTP/1.1 503 Service Unavailable.', TRUE, 503);
			echo 'Your appication folder path does not appear to be set correctly. Please open the following file and correct this: '.SELF;
			exit(3); // EXIT_CONFIG
		}
		require_once(SYSPATH."load_class.php");
    //Enable auto loading from the classes and libraries folders
    $classLoader = new ClassLoader(Array(APPPATH.'classes', APPPATH.'libraries'));
    $classLoader->register();
    $this->classLoader = $classLoader;
  }
}
