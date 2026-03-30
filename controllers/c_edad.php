<?php
class c_edad extends CI_Controller {
   public function __construct(){
      parent::__construct();     
      $this->load->database();
      $this->load->library('grocery_CRUD');
      $this->load->helper(array('cookie','date'));
	  $this->load->model('m_reporte','reporte');
      // $this->output->enable_profiler(TRUE);
   }
   
   function prueba(){
   	echo invert_date('2004-01-02','*');
   }
function timespan (){
$post_date = '2006112409';
$now = time();
$this->load->view('edadview');
}
   
	function load_interfaz($output = null){ $this->load->view('v_interfaz',$output); }
	
}

		return true;
/*
End of file c_gestionar.php
Location: ./application/controllers/c_gestionar.php
*/ 
?>
