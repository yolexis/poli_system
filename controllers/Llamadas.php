<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Llamadas extends CI_Controller {
public function __construct(){
parent::__construct();
$this->load->model('llamada_model');
}
public function buscar_llamadas_get(){
$this->load->view('llamadas/buscar_llamadas',
array('buscando' => false, 'id_cliente' => null
));
}
public function buscar_llamadas_post(){
$id_cliente = $this->input->post('id_cliente');
$llamadas = $this->llamada_model->listarPorCliente($id_cliente);
$this->load->view('llamadas/buscar_llamadas',
array('buscando' => true, 'id_cliente' => $id_cliente, 'llamadas'
}
public function generar_excel($id_cliente=null){
 $llamadas = $this->llamada_model->listarPorCliente($id_cliente);
  if(count($llamadas) > 0){
    //Cargamos la librería de excel.
    $this->load->library('excel'); $this->excel->setActiveSheetInde
    $this->excel->getActiveSheet()->setTitle('Llamadas');
    //Contador de filas
    $contador = 1;
    //Le aplicamos ancho las columnas.
    $this->excel->getActiveSheet()->getColumnDimension('A')->setWid
    $this->excel->getActiveSheet()->getColumnDimension('B')->setWid
    $this->excel->getActiveSheet()->getColumnDimension('C')->setWid
    //Le aplicamos negrita a los títulos de la cabecera.
    $this->excel->getActiveSheet()->getStyle("A{$contador}")->getFo
    $this->excel->getActiveSheet()->getStyle("B{$contador}")->getFo
    $this->excel->getActiveSheet()->getStyle("C{$contador}")->getFo
    //Definimos los títulos de la cabecera.
    $this->excel->getActiveSheet()->setCellValue("A{$contador}", 'N
    $this->excel->getActiveSheet()->setCellValue("B{$contador}", 'F
    $this->excel->getActiveSheet()->setCellValue("C{$contador}", 'M
    //Definimos la data del cuerpo.    
foreach($llamadas as $l){
    //Incrementamos una fila más, para ir a la siguiente.
    $contador++;
    //Informacion de las filas de la consulta.
$this->excel->getActiveSheet()->setCellValue("A{$contador}",
    $this->excel->getActiveSheet()->setCellValue("B{$contador}",
    $this->excel->getActiveSheet()->setCellValue("C{$contador}",
    }
    //Le ponemos un nombre al archivo que se va a generar.
    $archivo = "llamadas_cliente_{$id_cliente}.xls";
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="'.$archivo.'"
    header('Cache-Control: max-age=0');
    $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Ex
    //Hacemos una salida al navegador con el archivo Excel.
    $objWriter->save('php://output');
   }else{
    echo 'No se han encontrado llamadas';
    exit;   
}
}
}
/*
End of file c_fire_creator.php
Location: ./application/controllers/c_fire_creator.php
*/ 
?>
