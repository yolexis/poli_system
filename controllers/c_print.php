<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class C_print extends CI_Controller {
  public function __construct(){
    parent::__construct();
    session_start();
    if(!isset($_SESSION["admin"])) { redirect('common/c_global','refresh'); } else{      
     $this->load->model('admin/m_reporte','',TRUE);
     //$this->load->model('admin/m_codificador','',TRUE);
     //$this->output->enable_profiler(TRUE);
    }           
  }
    
  function print_exped($exped){
    $root=config_item('base_url');
    $this->load->library(array('table'));    
    $data['data_exp']= $this->m_reporte->data_expediente($exped);
    $data['componentes']= $this->m_reporte->componentXexped($exped);
    $this->load->view('common/v_expediente',$data);
  }

  function export_total_componente($entidad,$type){
    $entidad=clear_ascii($entidad);     
    $root=config_item('base_url');
    $this->load->library(array('table'));    
    $resultado = $this->m_reporte->all_componentsXentidad($entidad);       
    $this->table->set_heading('no','Componentes', '<div id="cell_center">Cantidad</div>');      
    $i=0;
    foreach ($resultado as $key){
      $this->table->add_row(++$i, $key->componente,'<div id="cell_center">'.$key->cantidad.'</div>');
    }      
    //data del template
    if($type=='print')$data['head']= css('css/print');
    if($type=='word')$data['head']= css('css/print').$this->export_to('word');
    if($type=='excel')$data['head']= css('css/print').$this->export_to('excel');
     
    $data['title_report']= 'Cantidad de Componentes en la Entidad: '.$entidad;    
    $data['content']= $this->table->generate();
    $this->load->view('common/v_print',$data);
  } 

  function export_to($type_document=''){
    if ($type_document!=''){
      if($type_document=='word')header("Content-Disposition: attachment;filename=result.doc ");
      if($type_document=='excel')header("Content-Disposition: attachment;filename=result.xls ");
      header("Pragma: public");
      header("Expires: 0");
      header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
      header("Content-Type: application/force-download");
      header("Content-Type: application/octet-stream");
      header("Content-Type: application/download");    
      header("Content-Transfer-Encoding: binary ");
    }else echo '<spam style="color:red;">La funcción <b>export_to</b> no se le ha pasado su parámetro(word/excel/html)!!!</spam>';
  }   
  
}

/* End of file c_print.php */
/* Location: ./application/controllers/admin/c_print.php */