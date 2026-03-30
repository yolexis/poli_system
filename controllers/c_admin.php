<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class c_admin extends CI_Controller {
	    private $limit = 10;
	    public function __construct(){
	      parent::__construct();
	      // $this->output->enable_profiler(TRUE);
	    }
	
	function login($segurity=''){
		$data['msg']='';
		if($segurity!='')$data['msg']=$segurity;
		$data['action']=config_item('base_url').'index.php/c_admin/autenticar';
		$this->load->view('form_login',$data);
	}    

	function autenticar(){	  
	   $this->load->model('m_security');

	   $root=config_item('base_url'); 
	   $data['action']=$root.'index.php/c_admin/autenticar';
	   $data['msg'] ='';	 
	   $usuario= $this->input->post('alias_usuario');
	   $password_captured= $this->input->post('contrasena');      	  
	   $password_encode=md5($password_captured);
	   $account=$this->m_security->get_account($usuario,$password_encode);
		
   	if($account){              
           $alias=$account->alias_usuario;
           $nombre=$account->nombre_usuario;
           $password=$account->contrasena;		
           $rol=$account->id_rol;		
      	switch ($rol) {        		
           	case '1':
           	$account = array('username'=>$nombre,'useralias'=>$alias,'rol'=>$rol,'logged_in'=>TRUE);
				$this->session->set_userdata($account);
           	break;
           	
           	case '3':
           	$account = array('username'=>$nombre,'useralias'=>$alias,'rol'=>$rol,'logged_in'=>TRUE);
				$this->session->set_userdata($account);
           	break;
           	
           	case '2':
           	$account = array('username'=>$nombre,'useralias'=>$alias,'rol'=>$rol,'logged_in' => TRUE);
				$this->session->set_userdata($account);
           	break;
			
			case '4':
           	$account = array('username'=>$nombre,'useralias'=>$alias,'rol'=>$rol,'logged_in' => TRUE);
				$this->session->set_userdata($account);
           	break;
			
			case '5':
           	$account = array('username'=>$nombre,'useralias'=>$alias,'rol'=>$rol,'logged_in' => TRUE);
				$this->session->set_userdata($account);
           	break;
			
			case '6':
           	$account = array('username'=>$nombre,'useralias'=>$alias,'rol'=>$rol,'logged_in' => TRUE);
				$this->session->set_userdata($account);
           	break;
			
			case '7':
           	$account = array('username'=>$nombre,'useralias'=>$alias,'rol'=>$rol,'logged_in' => TRUE);
				$this->session->set_userdata($account);
           	break;
			}
			
			redirect('c_global/home');
		}

	   else{
	   		$data['msg'] =msg('error',utf8('{{Error!!!}} Usuario o contraseña incorrecta'));
	   		$data['action']=$root.'index.php/c_admin/autenticar';
	   		$this->load->view('form_login', $data);		
	    }
	}	
	
	function backup(){
	     $this->load->dbutil();
	     $name_file = date('d-m-Y').'_salva_'.config_item('system_name').'.txt';
         $prefs = array(
                'tables'      => array(),           // Array of tables to backup.
                'ignore'      => array(),           // List of tables to omit from the backup
                'format'      => 'txt',             // gzip, zip, txt
                'filename'    => $name_file,        // File name - NEEDED ONLY WITH ZIP FILES
                'add_drop'    => TRUE,              // Whether to add DROP TABLE statements to backup file
                'add_insert'  => TRUE,              // Whether to add INSERT data to backup file
                'newline'     => "\n"               // Newline character used in backup file
              );
	     $backup =& $this->dbutil->backup($prefs); 
	     $this->load->helper('file'); write_file('salvas/'.$name_file, $backup); 
        $this->load->helper('download'); force_download($name_file, $backup);         
	}

}	
/* End of file c_admin.php */
/* Location: ./application/controllers/c_admin.php */