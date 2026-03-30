<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class c_global extends CI_Controller {
	    public function __construct(){
	      parent::__construct();
	      // $this->output->enable_profiler(TRUE);
	    }
	function prueba(){
		echo md5('admin');
	}

	function load_interfaz($output = null){ $this->load->view('v_interfaz',$output); }
	function home(){
		$system_name=config_item('system_name');
		$bootstrap_css=base_url("assets/$system_name/css/bootstrap.min.css");
		$bootstrap_responsive=base_url("assets/$system_name/css/bootstrap-responsive.min.css");
		$jquery=base_url("assets/$system_name/js/jquery.js");
		$bootstrap_js=base_url("assets/$system_name/js/bootstrap.min.js");
		$bootstrap_dropdown=base_url("assets/$system_name/js/bootstrap-dropdown.js");
		$bootstrap_dropdown=base_url("assets/$system_name/js/bootstrap-scrollspy.js");
		$breadcrumb=breadcrumb('Inicio',$this->session->userdata('username'));
		$output=$this->load->view('v_home','',true);	
		$this->load_interfaz((object)array('output' => $output,'position' => $breadcrumb, 'js_files' => array($jquery,$bootstrap_js,$bootstrap_dropdown), 'css_files' => array($bootstrap_css,$bootstrap_responsive)));
	}

	function logout(){
		$user=$this->session->userdata('useralias');		
		$this->session->sess_destroy($user);
		$data['action']=config_item('base_url').'index.php/c_admin/autenticar';		
	   $data['msg'] =msg('info',utf8('{Info!!!} SECCIÓN CERRADA.'));
	   $this->load->view('form_login', $data);
	}
	
	function help(){
		 $this->load->view('ayuda.mht');
	}

}	
/* End of file c_global.php */
/* Location: ./application/controllers/c_global.php */