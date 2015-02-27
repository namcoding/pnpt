<?php 
	class Test extends Pnpt_controller{
		public function __construct(){
			parent::__construct();
			$this->load_model('Mget');
			$this->load_library('mysql');
		}
		function nam($id){
			extract($id);
			$data1['nam']=200;
			$data['nam']=$this->model['Mget']->nam();
			$this->load_view('nam.php',$data);
			//$this->load_view('nam1.php',$data1);
			echo ($this->library['mysql']->result());
			$this->load_function(array('url','uri'));
			$this->load_function('url1');
		}
		function thuy(){
			var_dump($this->model['Mget']->thuy());
		}
		function index($id){
			extract($id);
			$data1['nam']=200;
			$data['nam']=$this->model['Mget']->nam();
			$this->load_view('nam.php',$data);
			//$this->load_view('nam1.php',$data1);
			$this->load_function(array('url','uri'));
			$this->load_function('url1');
		}
	}
?>
