<?php
class Routes {
  protected $routes = array();
  protected $_default_controller=null;
  protected $_default_model="index";
  protected $_default_id=array();
  function __construct($src){
	if (is_array($src)) {
      foreach ($src as $key => $val) {
        $this->routes[$key] = $val;
		if($key=="default") {
			$this->_default_controller=$val;
		}
      }
    }  
  }
  function full_path(){
    $s = &$_SERVER;
    $ssl = (!empty($s['HTTPS']) && $s['HTTPS'] == 'on') ? true:false;
    $sp = strtolower($s['SERVER_PROTOCOL']);
    $protocol = substr($sp, 0, strpos($sp, '/')) . (($ssl) ? 's' : '');
    $port = $s['SERVER_PORT'];
    $port = ((!$ssl && $port=='80') || ($ssl && $port=='443')) ? '' : ':'.$port;
    $host = isset($s['HTTP_X_FORWARDED_HOST']) ? $s['HTTP_X_FORWARDED_HOST'] : (isset($s['HTTP_HOST']) ? $s['HTTP_HOST'] : null);
    $host = isset($host) ? $host : $s['SERVER_NAME'] . $port;
    $uri = $protocol . '://' . $host . $s['REQUEST_URI'];
    $segments = explode('?', $uri, 2);
    $url = $segments[0];
	if(strpos($url,'.'.EXTENSION)){
		$url=str_replace('.'.EXTENSION,"",$url);
	}
    //return ltrim ($str,'h
	//$url=parse_url($url,PHP_URL_PATH);
	return ltrim (parse_url($url,PHP_URL_PATH),'/');
  }
	function fetch_uri(){
		$url=$this->full_path();
		foreach ($this->routes as $key=>$value){
			$key = str_replace(':any', '.+', $key);
			$key = str_replace(':num', '[0-9]+', $key);
			if (preg_match('#^' . $key . '$#', $url)) {
			// Do we have a back-reference?
				if (strpos($value, '$') !== false && strpos($key, '(') !== false) {
					$value = preg_replace('#^' . $key . '$#', $value, $url);
					return $value; 
				}
			}
		}
		return $url;
	}
	public function explode_url(){
		$url=$this->fetch_uri();
		if($url!==""){
			$array_path=explode("/",$url);
			$num=count($array_path);
			if($num==1){
				$this->_default_controller=$array_path[0];
			}
			else if($num==2){
				$this->_default_controller=$array_path[0];
				$this->_default_model=$array_path[1];
			}
			else if($num>=3){
				$this->_default_controller=$array_path[0];
				$this->_default_model=$array_path[1];
				for($i=2;$i<$num;$i++){
					$key='var'.($i-1);
					$this->_default_id[$key]=$array_path[$i];
				}
				
			}
		}
		return array(
				'controller'=>$this->_default_controller,
				'method'=>$this->_default_model,
				'id'=>$this->_default_id
			);
	}
	public function run(){
		return $this->explode_url();
	}
}
?>
