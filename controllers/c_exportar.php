<?php
class c_exportar extends CI_Controller{
   public function __construct(){
      parent::__construct();     
      $this->load->database();
      $this->load->library('grocery_CRUD','cart');
      $this->load->helper(array('cookie'));
	  $this->load->model('m_reporte','reporte');
	  $this->load->library('excel');
      // $this->output->enable_profiler(TRUE);
   }
    
    public function expediente_tic($puesto){
		$datos=$this->reporte->medios_informaticos($puesto)->result();
		$datos = json_decode(json_encode($datos), true);
       if(count($datos) > 0){
         $this->excel->getActiveSheet()->setTitle('Medios Informáticos');
		 $this->excel->getProperties()->setCreator("Poli_system"); 
        
		//Configurando el documento 
		$this->excel->getDefaultStyle()->getFont()->setName("Arial")->setSize(12)->setBold();
		$this->excel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
        $this->excel->getActiveSheet()->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_LETTER);
		
		//Alto de Filas
		$this->excel->getActiveSheet()->getRowDimension(1)->setRowHeight(25);
		$this->excel->getActiveSheet()->getRowDimension(2)->setRowHeight(25);
		$this->excel->getActiveSheet()->getRowDimension(3)->setRowHeight(25);
		$this->excel->getActiveSheet()->getRowDimension(4)->setRowHeight(25);
		$this->excel->getActiveSheet()->getRowDimension(5)->setRowHeight(25);
		$this->excel->getActiveSheet()->getRowDimension(6)->setRowHeight(25);
		$this->excel->getActiveSheet()->getRowDimension(7)->setRowHeight(25);
		$this->excel->getActiveSheet()->getRowDimension(8)->setRowHeight(25);
		$this->excel->getActiveSheet()->getRowDimension(9)->setRowHeight(25);
		$this->excel->getActiveSheet()->getRowDimension(10)->setRowHeight(25);
		$this->excel->getActiveSheet()->getRowDimension(11)->setRowHeight(25);
		$this->excel->getActiveSheet()->getRowDimension(12)->setRowHeight(25);
		$this->excel->getActiveSheet()->getRowDimension(13)->setRowHeight(25);
		$this->excel->getActiveSheet()->getRowDimension(14)->setRowHeight(25);
		$this->excel->getActiveSheet()->getRowDimension(15)->setRowHeight(25);
		$this->excel->getActiveSheet()->getRowDimension(16)->setRowHeight(25);
		$this->excel->getActiveSheet()->getRowDimension(17)->setRowHeight(25);
		$this->excel->getActiveSheet()->getRowDimension(18)->setRowHeight(25);
		$this->excel->getActiveSheet()->getRowDimension(19)->setRowHeight(25);
		$this->excel->getActiveSheet()->getRowDimension(20)->setRowHeight(25);
		$this->excel->getActiveSheet()->getRowDimension(21)->setRowHeight(25);
		$this->excel->getActiveSheet()->getRowDimension(22)->setRowHeight(25);
		$this->excel->getActiveSheet()->getRowDimension(23)->setRowHeight(25);
		$this->excel->getActiveSheet()->getRowDimension(24)->setRowHeight(25);
		$this->excel->getActiveSheet()->getRowDimension(25)->setRowHeight(25);
		$this->excel->getActiveSheet()->getRowDimension(26)->setRowHeight(25);
		
		
		//Bordes y fuente
        $bordes = new PHPExcel_Style();
        $bordes->applyFromArray(
        array('font' => array('size' => 12, 'name' => 'Arial')
		,'borders' => array(
        'top' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
        'right' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
        'bottom' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
        'left' => array('style' => PHPExcel_Style_Border::BORDER_THIN)
        )));
        $this->excel->getActiveSheet()->setSharedStyle($bordes, "A8:K10");
        $this->excel->getActiveSheet()->setSharedStyle($bordes, "A12:J13");
        $this->excel->getActiveSheet()->setSharedStyle($bordes, "A15:J16");
        $this->excel->getActiveSheet()->setSharedStyle($bordes, "A18:I19");
        $this->excel->getActiveSheet()->setSharedStyle($bordes, "A21:J22");
        $this->excel->getActiveSheet()->setSharedStyle($bordes, "A24:K26");

        $bordes2 = new PHPExcel_Style();
        $bordes2->applyFromArray(
        array('font' => array('size' => 18, 'name' => 'Arial')));
        $this->excel->getActiveSheet()->setSharedStyle($bordes2, "C1");


	    //establecer margenes
         $margin = 0.5 / 2.54; // 0.5 centimetros
         $margin2 = 0.8 / 2.54; // 0.5 centimetros
         $marginBottom = 2.0 / 2.54; //1.2 centimetros
         $this->excel->getActiveSheet()->getPageMargins()->setTop($marginBottom);
         $this->excel->getActiveSheet()->getPageMargins()->setBottom($marginBottom);
         $this->excel->getActiveSheet()->getPageMargins()->setLeft($margin);
         $this->excel->getActiveSheet()->getPageMargins()->setRight($margin2);
        
		//establecer impresion a pagina completa
         $this->excel->getActiveSheet()->getPageSetup()->setFitToPage(true);
         $this->excel->getActiveSheet()->getPageSetup()->setFitToWidth(1);
         $this->excel->getActiveSheet()->getPageSetup()->setFitToHeight(0);
         
		//Proteger datos
		$this->excel->getActiveSheet()->getProtection()->setPassword('PassPoli,Sistema');
        $this->excel->getActiveSheet()->getProtection()->setSheet(true); 
        $this->excel->getActiveSheet()->getProtection()->setSort(true);
        $this->excel->getActiveSheet()->getProtection()->setInsertRows(true);
        $this->excel->getActiveSheet()->getProtection()->setFormatCells(true);
        
		//Agrupar celdas
		 $this->excel->getActiveSheet()->mergeCells('A1:B3');$this->excel->getActiveSheet()->mergeCells('C1:K3');
		 $this->excel->getActiveSheet()->mergeCells('A4:B4');$this->excel->getActiveSheet()->mergeCells('C4:E4');$this->excel->getActiveSheet()->mergeCells('F4:G4');$this->excel->getActiveSheet()->mergeCells('H4:K4');
		 $this->excel->getActiveSheet()->mergeCells('A5:B5');$this->excel->getActiveSheet()->mergeCells('C5:E5');$this->excel->getActiveSheet()->mergeCells('F5:G5');$this->excel->getActiveSheet()->mergeCells('H5:K5');
		 $this->excel->getActiveSheet()->mergeCells('A6:B6');$this->excel->getActiveSheet()->mergeCells('C6:E6');$this->excel->getActiveSheet()->mergeCells('F6:G6');$this->excel->getActiveSheet()->mergeCells('H6:K6');
		 $this->excel->getActiveSheet()->mergeCells('A7:K7');
		 $this->excel->getActiveSheet()->mergeCells('A8:B9');
		 $this->excel->getActiveSheet()->mergeCells('A10:B10');
		 $this->excel->getActiveSheet()->mergeCells('C10:I10');
		 $this->excel->getActiveSheet()->mergeCells('A11:K11');
		 $this->excel->getActiveSheet()->mergeCells('E12:F12');$this->excel->getActiveSheet()->mergeCells('G12:H12');
		 $this->excel->getActiveSheet()->mergeCells('E13:F13');$this->excel->getActiveSheet()->mergeCells('G13:H13');
		 $this->excel->getActiveSheet()->mergeCells('E15:F15');$this->excel->getActiveSheet()->mergeCells('G15:H15');
		 $this->excel->getActiveSheet()->mergeCells('E16:F16');$this->excel->getActiveSheet()->mergeCells('G16:H16');
		 $this->excel->getActiveSheet()->mergeCells('A12:B13');
		 $this->excel->getActiveSheet()->mergeCells('A14:K14');
		 $this->excel->getActiveSheet()->mergeCells('A15:B16');
		 $this->excel->getActiveSheet()->mergeCells('A17:K17');
		 $this->excel->getActiveSheet()->mergeCells('A18:B19');$this->excel->getActiveSheet()->mergeCells('F18:F19');
		 $this->excel->getActiveSheet()->mergeCells('A20:K20');
		 $this->excel->getActiveSheet()->mergeCells('A21:B22');$this->excel->getActiveSheet()->mergeCells('E21:F21');$this->excel->getActiveSheet()->mergeCells('G21:H21');
		 $this->excel->getActiveSheet()->mergeCells('E22:F22');$this->excel->getActiveSheet()->mergeCells('G22:H22');
		 $this->excel->getActiveSheet()->mergeCells('A24:B25');
		 $this->excel->getActiveSheet()->mergeCells('A26:B26');$this->excel->getActiveSheet()->mergeCells('C26:I26');         

		//Insertar valores
		 $this->excel->getActiveSheet()->setCellValue("C1", 'Expediente técnico de equipos informáticos por puestos de trabajo');	        
		 $this->excel->getActiveSheet()->setCellValue("C4", 'UEB Salinera Joa');$this->excel->getActiveSheet()->setCellValue("F4", 'Área:');$this->excel->getActiveSheet()->setCellValue("H4", $datos[0]['nombre_area']);	        
		 $this->excel->getActiveSheet()->setCellValue("C5", 'Km 23 1/2 Carretera Guantánamo Baracoa');$this->excel->getActiveSheet()->setCellValue("F5", 'Local:');$this->excel->getActiveSheet()->setCellValue("H5", $datos[0]['nombre_local']);	        
		 $this->excel->getActiveSheet()->setCellValue("C6", $datos[0]['nombre_persona']);$this->excel->getActiveSheet()->setCellValue("F6", 'Nom. Puesto/Esp.:');$this->excel->getActiveSheet()->setCellValue("H6", $datos[0]['nombre_puesto_trabajo']);
		 //Datos estáticos	        
	     $this->excel->getActiveSheet()->setCellValue("A4", 'Unidad:');
	     $this->excel->getActiveSheet()->setCellValue("A5", 'Dirección:');
	     $this->excel->getActiveSheet()->setCellValue("A6", 'Responsable:');
	     //$this->excel->getActiveSheet()->setCellValue("A8", 'PC Escritorio');
	     $this->excel->getActiveSheet()->setCellValue("C8", 'Nombre');
	     $this->excel->getActiveSheet()->setCellValue("D8", 'Inventario');
	     $this->excel->getActiveSheet()->setCellValue("E8", 'Marca');
	     $this->excel->getActiveSheet()->setCellValue("F8", 'Lec-ópt');
	     $this->excel->getActiveSheet()->setCellValue("G8", 'RAM');
	     $this->excel->getActiveSheet()->setCellValue("H8", 'HDD');
	     $this->excel->getActiveSheet()->setCellValue("I8", 'Mother Board');
	     $this->excel->getActiveSheet()->setCellValue("J8", 'No Serie');
	     $this->excel->getActiveSheet()->setCellValue("K8", 'Micro');
	     $this->excel->getActiveSheet()->setCellValue("A10", 'Descripción:');
	     $this->excel->getActiveSheet()->setCellValue("J10", 'No Sello:');
	     $this->excel->getActiveSheet()->setCellValue("A12", 'Monitor');
	     $this->excel->getActiveSheet()->setCellValue("C12", 'Nombre');
	     $this->excel->getActiveSheet()->setCellValue("D12", 'Inventario');
	     $this->excel->getActiveSheet()->setCellValue("E12", 'Marca');
	     $this->excel->getActiveSheet()->setCellValue("G12", 'No Serie');
	     $this->excel->getActiveSheet()->setCellValue("I12", 'Modelo');
	     $this->excel->getActiveSheet()->setCellValue("J12", 'No Sello');
	     $this->excel->getActiveSheet()->setCellValue("A15", 'UPS');
	     $this->excel->getActiveSheet()->setCellValue("C15", 'Nombre');
	     $this->excel->getActiveSheet()->setCellValue("D15", 'Inventario');
	     $this->excel->getActiveSheet()->setCellValue("E15", 'Marca');
	     $this->excel->getActiveSheet()->setCellValue("G15", 'No Serie');
	     $this->excel->getActiveSheet()->setCellValue("I15", 'Modelo');
	     $this->excel->getActiveSheet()->setCellValue("J15", 'No Sello');
	     $this->excel->getActiveSheet()->setCellValue("C18", 'No Serie');
	     $this->excel->getActiveSheet()->setCellValue("D18", 'Marca');
	     $this->excel->getActiveSheet()->setCellValue("A18", 'Teclado');
	     $this->excel->getActiveSheet()->setCellValue("E18", 'Modelo');
	     $this->excel->getActiveSheet()->setCellValue("F18", 'Mouse');
	     $this->excel->getActiveSheet()->setCellValue("G18", 'Marca');
	     $this->excel->getActiveSheet()->setCellValue("H18", 'Modelo');
	     $this->excel->getActiveSheet()->setCellValue("I18", 'No Serie');
	     $this->excel->getActiveSheet()->setCellValue("A21", 'Impresora');
	     $this->excel->getActiveSheet()->setCellValue("C21", 'Nombre');
	     $this->excel->getActiveSheet()->setCellValue("D21", 'Inventario');
	     $this->excel->getActiveSheet()->setCellValue("E21", 'Marca');
	     $this->excel->getActiveSheet()->setCellValue("G21", 'No Serie');
	     $this->excel->getActiveSheet()->setCellValue("I21", 'Modelo');
	     $this->excel->getActiveSheet()->setCellValue("J21", 'No Sello');
	     $this->excel->getActiveSheet()->setCellValue("C24", 'Nombre');
	     $this->excel->getActiveSheet()->setCellValue("D24", 'Inventario');
	     $this->excel->getActiveSheet()->setCellValue("E24", 'Marca');
	     $this->excel->getActiveSheet()->setCellValue("F24", 'No Serie');
	     $this->excel->getActiveSheet()->setCellValue("G24", 'RAM');
	     $this->excel->getActiveSheet()->setCellValue("H24", 'HDD');
	     $this->excel->getActiveSheet()->setCellValue("I24", 'Mother Board');
	     $this->excel->getActiveSheet()->setCellValue("J24", 'Micro');
	     $this->excel->getActiveSheet()->setCellValue("K24", 'Lector óptico');
	     $this->excel->getActiveSheet()->setCellValue("A26", 'Descripción:');
	     $this->excel->getActiveSheet()->setCellValue("J26", 'No Sello:');
	    
	    //Datos dinámicos
	    $cont=0;  	        
	   for ($i=0; $i < count($datos); $i++) {
	     if ($datos[$i]['tipo_equipo']=='Desktop' || $datos[$i]['tipo_equipo']=='Laptop' && $cont==0){
	     	$cont=1;
	     if ($datos[$i]['tipo_equipo']=='Desktop'){$datos[$i]['tipo_equipo']='PC Escritorio';}
		 $this->excel->getActiveSheet()->setCellValue("A8", $datos[$i]['tipo_equipo']);	

		 $this->excel->getActiveSheet()->setCellValue("C9", $datos[$i]['nombre_equipos_informaticos']);		   
		 $this->excel->getActiveSheet()->setCellValue("D9", $datos[$i]['inventario']);		   
		 $this->excel->getActiveSheet()->setCellValue("E9", $datos[$i]['marca']);		   
		 $this->excel->getActiveSheet()->setCellValue("F9", $datos[$i]['lector_optico']);		   
		 $this->excel->getActiveSheet()->setCellValue("G9", $datos[$i]['ram']);		   
		 $this->excel->getActiveSheet()->setCellValue("H9", $datos[$i]['disco_duro']);		   
		 $this->excel->getActiveSheet()->setCellValue("I9", $datos[$i]['mother_board']);		   
		 $this->excel->getActiveSheet()->setCellValue("J9", $datos[$i]['no_serie']);		   
		 $this->excel->getActiveSheet()->setCellValue("K9", $datos[$i]['micro']);
		 $this->excel->getActiveSheet()->setCellValue("C10", $datos[$i]['descripcion']);
		 $this->excel->getActiveSheet()->setCellValue("K10", $datos[$i]['no_sello']);
		 }
		 if ($datos[$i]['tipo_equipo']=='Desktop'||$datos[$i]['tipo_equipo']=='Servidor') {
		 $datos[$i]['tipo_equipo']=='PC Escritorio';
		 $this->excel->getActiveSheet()->setCellValue("A24", $datos[$i]['tipo_equipo']);	   
		 $this->excel->getActiveSheet()->setCellValue("C25", $datos[$i]['nombre_equipos_informaticos']);		   
		 $this->excel->getActiveSheet()->setCellValue("D25", $datos[$i]['inventario']);		   
		 $this->excel->getActiveSheet()->setCellValue("E25", $datos[$i]['marca']);		   
		 $this->excel->getActiveSheet()->setCellValue("F25", $datos[$i]['no_serie']);		   
		 $this->excel->getActiveSheet()->setCellValue("G25", $datos[$i]['ram']);		   
		 $this->excel->getActiveSheet()->setCellValue("H25", $datos[$i]['disco_duro']);		   
		 $this->excel->getActiveSheet()->setCellValue("I25", $datos[$i]['mother_board']);		   
		 $this->excel->getActiveSheet()->setCellValue("J25", $datos[$i]['micro']);		   
		 $this->excel->getActiveSheet()->setCellValue("K25", $datos[$i]['lector_optico']);
		 $this->excel->getActiveSheet()->setCellValue("C26", $datos[$i]['descripcion']);
		 $this->excel->getActiveSheet()->setCellValue("K26", $datos[$i]['no_sello']);		   
		 }
		 if ($datos[$i]['tipo_equipo']=='Monitor') {
		 $this->excel->getActiveSheet()->setCellValue("C13", $datos[$i]['nombre_equipos_informaticos']);		   
		 $this->excel->getActiveSheet()->setCellValue("D13", $datos[$i]['inventario']);		   
		 $this->excel->getActiveSheet()->setCellValue("E13", $datos[$i]['marca']);		   
		 $this->excel->getActiveSheet()->setCellValue("G13", $datos[$i]['no_serie']);		   
		 $this->excel->getActiveSheet()->setCellValue("I13", $datos[$i]['modelo']);		   
		 $this->excel->getActiveSheet()->setCellValue("J13", $datos[$i]['no_sello']);		   
		 }
		 if ($datos[$i]['tipo_equipo']=='UPS') {
		 $this->excel->getActiveSheet()->setCellValue("C16", $datos[$i]['nombre_equipos_informaticos']);		   
		 $this->excel->getActiveSheet()->setCellValue("D16", $datos[$i]['inventario']);		   
		 $this->excel->getActiveSheet()->setCellValue("E16", $datos[$i]['marca']);		   
		 $this->excel->getActiveSheet()->setCellValue("G16", $datos[$i]['no_serie']);		   
		 $this->excel->getActiveSheet()->setCellValue("I16", $datos[$i]['modelo']);		   
		 $this->excel->getActiveSheet()->setCellValue("J16", $datos[$i]['no_sello']);		   
		 }
		 if ($datos[$i]['tipo_equipo']=='Impresora') {
		 $this->excel->getActiveSheet()->setCellValue("C22", $datos[$i]['nombre_equipos_informaticos']);		   
		 $this->excel->getActiveSheet()->setCellValue("D22", $datos[$i]['inventario']);		   
		 $this->excel->getActiveSheet()->setCellValue("E22", $datos[$i]['marca']);		   
		 $this->excel->getActiveSheet()->setCellValue("G22", $datos[$i]['no_serie']);		   
		 $this->excel->getActiveSheet()->setCellValue("I22", $datos[$i]['modelo']);		   
		 $this->excel->getActiveSheet()->setCellValue("J22", $datos[$i]['no_sello']);		   
		 }
		 if ($datos[$i]['tipo_equipo']=='Teclado') {
		 $this->excel->getActiveSheet()->setCellValue("A18", $datos[$i]['tipo_equipo']);		   
		 $this->excel->getActiveSheet()->setCellValue("D19", $datos[$i]['marca']);		   
		 $this->excel->getActiveSheet()->setCellValue("C19", $datos[$i]['no_serie']);		   
		 $this->excel->getActiveSheet()->setCellValue("E19", $datos[$i]['modelo']);		   
		 }
		 if ($datos[$i]['tipo_equipo']=='Mouse') {
		 $this->excel->getActiveSheet()->setCellValue("F18", $datos[$i]['tipo_equipo']);		   
		 $this->excel->getActiveSheet()->setCellValue("G19", $datos[$i]['marca']);		   
		 $this->excel->getActiveSheet()->setCellValue("I19", $datos[$i]['no_serie']);		   
		 $this->excel->getActiveSheet()->setCellValue("H19", $datos[$i]['modelo']);		   
		 }
		 }  	     
       //ancho de columnas.
       $this->excel->getActiveSheet()->getColumnDimension('A')->setWidth(6);
	   $this->excel->getActiveSheet()->getColumnDimension('B')->setWidth(6);
	   $this->excel->getActiveSheet()->getColumnDimension('C')->setWidth(15);
	   $this->excel->getActiveSheet()->getColumnDimension('D')->setWidth(10);
	   $this->excel->getActiveSheet()->getColumnDimension('E')->setWidth(10);
	   $this->excel->getActiveSheet()->getColumnDimension('F')->setWidth(8);
	   $this->excel->getActiveSheet()->getColumnDimension('G')->setWidth(12);
	   $this->excel->getActiveSheet()->getColumnDimension('H')->setWidth(12);
	   $this->excel->getActiveSheet()->getColumnDimension('I')->setWidth(18);
	   $this->excel->getActiveSheet()->getColumnDimension('J')->setWidth(25);
	   $this->excel->getActiveSheet()->getColumnDimension('K')->setWidth(25);
	   
	   /*foreach (range('A', 'K') as $columnID) {
       //autodimensionar las columnas
       $this->excel->getActiveSheet()->getColumnDimension($columnID)->setAutoSize(true);
       }*/
	   
	  
	     
	  //Formato de celdas, alineación
	    	
	    $this->excel->getActiveSheet()->getStyle("A1:K6")->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
	    $this->excel->getActiveSheet()->getStyle("C1:K3")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	    $this->excel->getActiveSheet()->getStyle("A4:A6")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
	    $this->excel->getActiveSheet()->getStyle("F4:F6")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
	    $this->excel->getActiveSheet()->getStyle("A8:K26")->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		$this->excel->getActiveSheet()->getStyle("A8:K9")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	    $this->excel->getActiveSheet()->getStyle("J10")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
	    $this->excel->getActiveSheet()->getStyle("K10")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
		$this->excel->getActiveSheet()->getStyle("A12:K13")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->getStyle("A15:K16")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->getStyle("A18:K19")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->getStyle("A21:K22")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->getStyle("A24:K25")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	    $this->excel->getActiveSheet()->getStyle("J26")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
	    $this->excel->getActiveSheet()->getStyle("K26")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
		$this->excel->getActiveSheet()->getStyle("C1")->getFont()->setBold(true);
		$this->excel->getActiveSheet()->getStyle("A1:A26")->getFont()->setBold(true);
		$this->excel->getActiveSheet()->getStyle("F4:F6")->getFont()->setBold(true);
		$this->excel->getActiveSheet()->getStyle("C8:K8")->getFont()->setBold(true);
		$this->excel->getActiveSheet()->getStyle("J10")->getFont()->setBold(true);
		$this->excel->getActiveSheet()->getStyle("C12:K12")->getFont()->setBold(true);
		$this->excel->getActiveSheet()->getStyle("C15:K15")->getFont()->setBold(true);
		$this->excel->getActiveSheet()->getStyle("C18:K18")->getFont()->setBold(true);
		$this->excel->getActiveSheet()->getStyle("C21:K21")->getFont()->setBold(true);
		$this->excel->getActiveSheet()->getStyle("C24:K24")->getFont()->setBold(true);
		$this->excel->getActiveSheet()->getStyle("J26")->getFont()->setBold(true);
				
	//Incertar imagen
      $objDrawing = new PHPExcel_Worksheet_Drawing();
				$objDrawing->setName('Logo');
				$objDrawing->setDescription('Logo');
				$qr = 'assets\poli_system\images\Logo_Empresa.png';
				$objDrawing->setPath($qr);
				$objDrawing->setOffsetX(8);
				$objDrawing->setOffsetY(300);
				$objDrawing->setCoordinates('B1');
				$objDrawing->setHeight(90);
				$objDrawing->setWorksheet($this->excel->getActiveSheet());        		 
		 
	//Le ponemos un nombre al archivo que se va a generar.
	        $archivo = "Expediente técnico por puesto de trabajo ({$datos[0]['nombre_puesto_trabajo']}).xls";
	        header('Content-Type: application/vnd.ms-excel');
	        header('Content-Disposition: attachment;filename="'.$archivo.'"');
	        header('Cache-Control: max-age=0');
	        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
            //Hacemos una salida al navegador con el archivo Excel.
        $objWriter->save('php://output');
	} 
}

    public function exportar_control_orden(){
		$user=$this->session->userdata('useralias');
		$datos=$this->reporte->temp_vales($user)->result();
		$dat = json_decode(json_encode($datos), true);
       if(count($datos) > 0){
         $this->excel->getActiveSheet()->setTitle('Control ordenes');
		 $this->excel->getProperties()->setCreator("Poli_system"); 
        
		//Configurando el documento 
		$this->excel->getDefaultStyle()->getFont()->setName("Arial")->setSize(12)->setBold();
		$this->excel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
        $this->excel->getActiveSheet()->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_LETTER);
		
		//Alto de Filas
		$this->excel->getActiveSheet()->getRowDimension(1)->setRowHeight(50);
		$this->excel->getActiveSheet()->getRowDimension(2)->setRowHeight(25);
		$this->excel->getActiveSheet()->getRowDimension(3)->setRowHeight(25);
		$this->excel->getActiveSheet()->getRowDimension(4)->setRowHeight(25);
		$this->excel->getActiveSheet()->getRowDimension(5)->setRowHeight(25);
		$this->excel->getActiveSheet()->getRowDimension(6)->setRowHeight(25);
		$this->excel->getActiveSheet()->getRowDimension(7)->setRowHeight(25);
		$this->excel->getActiveSheet()->getRowDimension(8)->setRowHeight(25);
		$this->excel->getActiveSheet()->getRowDimension(9)->setRowHeight(25);
		$this->excel->getActiveSheet()->getRowDimension(10)->setRowHeight(25);
		$this->excel->getActiveSheet()->getRowDimension(11)->setRowHeight(25);
		$this->excel->getActiveSheet()->getRowDimension(12)->setRowHeight(25);
		$this->excel->getActiveSheet()->getRowDimension(13)->setRowHeight(25);
		$this->excel->getActiveSheet()->getRowDimension(14)->setRowHeight(25);
		$this->excel->getActiveSheet()->getRowDimension(15)->setRowHeight(25);
		$this->excel->getActiveSheet()->getRowDimension(16)->setRowHeight(25);
		$this->excel->getActiveSheet()->getRowDimension(17)->setRowHeight(25);
		$this->excel->getActiveSheet()->getRowDimension(18)->setRowHeight(25);
		$this->excel->getActiveSheet()->getRowDimension(19)->setRowHeight(25);
		$this->excel->getActiveSheet()->getRowDimension(20)->setRowHeight(25);
		$this->excel->getActiveSheet()->getRowDimension(21)->setRowHeight(25);
		$this->excel->getActiveSheet()->getRowDimension(22)->setRowHeight(25);
		$this->excel->getActiveSheet()->getRowDimension(23)->setRowHeight(25);
		$this->excel->getActiveSheet()->getRowDimension(24)->setRowHeight(25);
		
		
		//Bordes y fuente
        $bordes = new PHPExcel_Style();
        $bordes->applyFromArray(
        array('font' => array('size' => 12, 'name' => 'Arial')
		,'borders' => array(
        'top' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
        'right' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
        'bottom' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
        'left' => array('style' => PHPExcel_Style_Border::BORDER_THIN)
        )));
        $this->excel->getActiveSheet()->setSharedStyle($bordes, "A2:K24");
               
	    //establecer margenes
         $margin = 0.5 / 2.54; // 0.5 centimetros
         $margin2 = 0.8 / 2.54; // 0.5 centimetros
         $marginBottom = 2.0 / 2.54; //1.2 centimetros
         $this->excel->getActiveSheet()->getPageMargins()->setTop($marginBottom);
         $this->excel->getActiveSheet()->getPageMargins()->setBottom($marginBottom);
         $this->excel->getActiveSheet()->getPageMargins()->setLeft($margin);
         $this->excel->getActiveSheet()->getPageMargins()->setRight($margin2);
        
		//establecer impresion a pagina completa
         $this->excel->getActiveSheet()->getPageSetup()->setFitToPage(true);
         $this->excel->getActiveSheet()->getPageSetup()->setFitToWidth(1);
         $this->excel->getActiveSheet()->getPageSetup()->setFitToHeight(0);
         
		//Proteger datos
		$this->excel->getActiveSheet()->getProtection()->setPassword('PassPoli,Sistema');
        $this->excel->getActiveSheet()->getProtection()->setSheet(true); 
        $this->excel->getActiveSheet()->getProtection()->setSort(true);
        $this->excel->getActiveSheet()->getProtection()->setInsertRows(true);
        $this->excel->getActiveSheet()->getProtection()->setFormatCells(true);
        
		//Agrupar celdas
		 $this->excel->getActiveSheet()->mergeCells('A1:K1');
		 $this->excel->getActiveSheet()->mergeCells('E2:F2');$this->excel->getActiveSheet()->mergeCells('I2:K2');
		 $this->excel->getActiveSheet()->mergeCells('A2:A3');$this->excel->getActiveSheet()->mergeCells('B2:B3');$this->excel->getActiveSheet()->mergeCells('C2:C3');$this->excel->getActiveSheet()->mergeCells('D2:D3');$this->excel->getActiveSheet()->mergeCells('G2:G3');$this->excel->getActiveSheet()->mergeCells('H2:H3');
		 
		//Insertar valores
		 $this->excel->getActiveSheet()->setCellValue("A1", 'Control de Orden de Trabajo');	        
	     $this->excel->getActiveSheet()->setCellValue("A2", 'No');$this->excel->getActiveSheet()->setCellValue("B2", 'Área');$this->excel->getActiveSheet()->setCellValue("C2", 'Equipo');$this->excel->getActiveSheet()->setCellValue("D2", 'No orden');$this->excel->getActiveSheet()->setCellValue("E2", 'Fecha');$this->excel->getActiveSheet()->setCellValue("G2", 'C. Costo');$this->excel->getActiveSheet()->setCellValue("H2", 'Tipo de reparación');$this->excel->getActiveSheet()->setCellValue("I2", 'Gastos directos');       
	     $this->excel->getActiveSheet()->setCellValue("E3", 'Inicio');$this->excel->getActiveSheet()->setCellValue("F3", 'Terminado');$this->excel->getActiveSheet()->setCellValue("I3", 'M. Obra');$this->excel->getActiveSheet()->setCellValue("J3", 'Materiales');$this->excel->getActiveSheet()->setCellValue("K3", 'Total');	        
	     	     
       //ancho de columnas.
       $this->excel->getActiveSheet()->getColumnDimension('A')->setWidth(4);
	   $this->excel->getActiveSheet()->getColumnDimension('B')->setWidth(25);
	   $this->excel->getActiveSheet()->getColumnDimension('C')->setWidth(25);
	   $this->excel->getActiveSheet()->getColumnDimension('D')->setWidth(8);
	   $this->excel->getActiveSheet()->getColumnDimension('E')->setWidth(10);
	   $this->excel->getActiveSheet()->getColumnDimension('F')->setWidth(10);
	   $this->excel->getActiveSheet()->getColumnDimension('G')->setWidth(8);
	   $this->excel->getActiveSheet()->getColumnDimension('H')->setWidth(30);
	   $this->excel->getActiveSheet()->getColumnDimension('I')->setWidth(8);
	   $this->excel->getActiveSheet()->getColumnDimension('J')->setWidth(8);
	   $this->excel->getActiveSheet()->getColumnDimension('K')->setWidth(8);
	   
	   /*foreach (range('A', 'K') as $columnID) {
       //autodimensionar las columnas
       $this->excel->getActiveSheet()->getColumnDimension($columnID)->setAutoSize(true);
       }*/
	   
	  
	     
	  //Formato de celdas, alineación
	    	
	    $this->excel->getActiveSheet()->getStyle("A1:K3")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	    $this->excel->getActiveSheet()->getStyle("A1")->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
	    $this->excel->getActiveSheet()->getStyle("B1:K24")->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		$this->excel->getActiveSheet()->getStyle("A4:A24")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->getStyle("D4:D24")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->getStyle("G4:G24")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->getStyle("I4:I24")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->getStyle("J4:J24")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->getStyle("K4:K24")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->getStyle("B4:C24")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
		$this->excel->getActiveSheet()->getStyle("H4:H24")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
		$this->excel->getActiveSheet()->getStyle("A1")->getFont()->setBold(true);
				
	    		 
	//Definimos la data del cuerpo.
	 $contador = 3;       
 foreach($datos as $v){ 	   
 	    	$contador++;
         $this->excel->getActiveSheet()->setCellValue("A{$contador}", $contador-3);
         $this->excel->getActiveSheet()->setCellValue("B{$contador}", $v->nombre_centro_costo);
         $this->excel->getActiveSheet()->setCellValue("C{$contador}", $v->receptor);
         $this->excel->getActiveSheet()->setCellValue("D{$contador}", $v->id_orden);
         $this->excel->getActiveSheet()->setCellValue("E{$contador}", $v->fecha1);
         $this->excel->getActiveSheet()->setCellValue("F{$contador}", $v->fecha2);
         $this->excel->getActiveSheet()->setCellValue("G{$contador}", $v->no_centro_costo);
         $this->excel->getActiveSheet()->setCellValue("H{$contador}", $v->descripcion);
         $this->excel->getActiveSheet()->setCellValue("I{$contador}", $v->importe_mlc);
         $this->excel->getActiveSheet()->setCellValue("J{$contador}", $v->importe_mn);
         $this->excel->getActiveSheet()->setCellValue("K{$contador}", $v->importe_mn+$v->importe_mlc);
 	}
        		 
		 
	//Le ponemos un nombre al archivo que se va a generar.
	        $archivo = "Orden_trabajo_Control({$dat[0]['fecha1']} al {$dat[0]['fecha2']}).xls";
	        header('Content-Type: application/vnd.ms-excel');
	        header('Content-Disposition: attachment;filename="'.$archivo.'"');
	        header('Cache-Control: max-age=0');
	        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
            //Hacemos una salida al navegador con el archivo Excel.
        $objWriter->save('php://output');
	} 
}

    public function exportar_resumen_orden(){
		$user=$this->session->userdata('useralias');
		$datos=$this->reporte->temp_vales($user)->result();
		$dat = json_decode(json_encode($datos), true);
       if(count($datos) > 0){
         $this->excel->getActiveSheet()->setTitle('Resumen orden');
		 $this->excel->getProperties()->setCreator("Poli_system"); 
        
		//Configurando el documento 
		$this->excel->getDefaultStyle()->getFont()->setName("Arial")->setSize(10)->setBold();
		$this->excel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_PORTRAIT);
        $this->excel->getActiveSheet()->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_LETTER);
		
		//Alto de Filas
		$this->excel->getActiveSheet()->getRowDimension(1)->setRowHeight(12,75);
		$this->excel->getActiveSheet()->getRowDimension(2)->setRowHeight(12,75);
		$this->excel->getActiveSheet()->getRowDimension(3)->setRowHeight(12,75);
		$this->excel->getActiveSheet()->getRowDimension(4)->setRowHeight(45);
		$this->excel->getActiveSheet()->getRowDimension(5)->setRowHeight(25);
		$this->excel->getActiveSheet()->getRowDimension(6)->setRowHeight(12,75);
		$this->excel->getActiveSheet()->getRowDimension(7)->setRowHeight(25);
		$this->excel->getActiveSheet()->getRowDimension(8)->setRowHeight(12,75);
		$this->excel->getActiveSheet()->getRowDimension(9)->setRowHeight(20);
		$this->excel->getActiveSheet()->getRowDimension(10)->setRowHeight(12,75);
		$this->excel->getActiveSheet()->getRowDimension(11)->setRowHeight(12,75);
		$this->excel->getActiveSheet()->getRowDimension(12)->setRowHeight(12,75);
		$this->excel->getActiveSheet()->getRowDimension(13)->setRowHeight(12,75);
		$this->excel->getActiveSheet()->getRowDimension(14)->setRowHeight(12,75);
		$this->excel->getActiveSheet()->getRowDimension(15)->setRowHeight(12,75);
		$this->excel->getActiveSheet()->getRowDimension(16)->setRowHeight(12,75);
		$this->excel->getActiveSheet()->getRowDimension(17)->setRowHeight(12,75);
		$this->excel->getActiveSheet()->getRowDimension(18)->setRowHeight(12,75);
		$this->excel->getActiveSheet()->getRowDimension(19)->setRowHeight(12,75);
		$this->excel->getActiveSheet()->getRowDimension(20)->setRowHeight(12,75);
		$this->excel->getActiveSheet()->getRowDimension(21)->setRowHeight(12,75);
		$this->excel->getActiveSheet()->getRowDimension(22)->setRowHeight(12,75);
		$this->excel->getActiveSheet()->getRowDimension(23)->setRowHeight(12,75);
		$this->excel->getActiveSheet()->getRowDimension(24)->setRowHeight(12,75);
		$this->excel->getActiveSheet()->getRowDimension(25)->setRowHeight(12,75);
		$this->excel->getActiveSheet()->getRowDimension(26)->setRowHeight(12,75);
		$this->excel->getActiveSheet()->getRowDimension(27)->setRowHeight(12,75);
		$this->excel->getActiveSheet()->getRowDimension(45)->setRowHeight(20);
		$this->excel->getActiveSheet()->getRowDimension(46)->setRowHeight(35);
		
		//Bordes y fuente
        $bordes = new PHPExcel_Style();
        $bordes->applyFromArray(
        array('font' => array('size' => 10, 'name' => 'Arial')
		,'borders' => array(
        'top' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
        'right' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
        'bottom' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
        'left' => array('style' => PHPExcel_Style_Border::BORDER_THIN)
        )));
        $this->excel->getActiveSheet()->setSharedStyle($bordes, "A13:I44");
               
	    /*$bordes3 = new PHPExcel_Style();
        $bordes3->applyFromArray(
        array('font' => array('size' => 14, 'name' => 'Arial')
		,'borders' => array(
        'top' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
        'right' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
        'bottom' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
        'left' => array('style' => PHPExcel_Style_Border::BORDER_THIN)
        )));
        $this->excel->getActiveSheet()->setSharedStyle($bordes3, "M27:N28");
        $this->excel->getActiveSheet()->setSharedStyle($bordes3, "L26");*/
		
        //establecer margenes
         $margin = 0.5 / 2.54; // 0.5 centimetros
         $margin2 = 0.8 / 2.54; // 0.5 centimetros
         $marginBottom = 2.0 / 2.54; //1.2 centimetros
         $this->excel->getActiveSheet()->getPageMargins()->setTop($marginBottom);
         $this->excel->getActiveSheet()->getPageMargins()->setBottom($marginBottom);
         $this->excel->getActiveSheet()->getPageMargins()->setLeft($margin);
         $this->excel->getActiveSheet()->getPageMargins()->setRight($margin2);
        
		//establecer impresion a pagina completa
         $this->excel->getActiveSheet()->getPageSetup()->setFitToPage(true);
         $this->excel->getActiveSheet()->getPageSetup()->setFitToWidth(1);
         $this->excel->getActiveSheet()->getPageSetup()->setFitToHeight(0);
         
		//Proteger datos
		$this->excel->getActiveSheet()->getProtection()->setPassword('PassPoli,Sistema');
        $this->excel->getActiveSheet()->getProtection()->setSheet(true); 
        $this->excel->getActiveSheet()->getProtection()->setSort(true);
        $this->excel->getActiveSheet()->getProtection()->setInsertRows(true);
        $this->excel->getActiveSheet()->getProtection()->setFormatCells(true);
        
		//Agrupar celdas
		 $this->excel->getActiveSheet()->mergeCells('A1:I1');
		 $this->excel->getActiveSheet()->mergeCells('A2:I2');
		 $this->excel->getActiveSheet()->mergeCells('A3:I3');
		 $this->excel->getActiveSheet()->mergeCells('A4:B4');$this->excel->getActiveSheet()->mergeCells('F4:G4');
		 $this->excel->getActiveSheet()->mergeCells('A5:C5');$this->excel->getActiveSheet()->mergeCells('D5:F5');$this->excel->getActiveSheet()->mergeCells('G5:I5');
		 $this->excel->getActiveSheet()->mergeCells('A6:C6');$this->excel->getActiveSheet()->mergeCells('D6:F6');$this->excel->getActiveSheet()->mergeCells('G6:I6');
		 $this->excel->getActiveSheet()->mergeCells('A7:C7');$this->excel->getActiveSheet()->mergeCells('D7:F7');$this->excel->getActiveSheet()->mergeCells('G7:I7');
		 $this->excel->getActiveSheet()->mergeCells('A8:C8');$this->excel->getActiveSheet()->mergeCells('D8:F8');$this->excel->getActiveSheet()->mergeCells('G8:I8');
		 $this->excel->getActiveSheet()->mergeCells('A9:C9');$this->excel->getActiveSheet()->mergeCells('D9:F9');$this->excel->getActiveSheet()->mergeCells('G9:I9');
         $this->excel->getActiveSheet()->mergeCells('A10:I12');		 
		 $this->excel->getActiveSheet()->mergeCells('A13:I13');
		 $this->excel->getActiveSheet()->mergeCells('B14:D14');
		 $this->excel->getActiveSheet()->mergeCells('B15:D15');
		 $this->excel->getActiveSheet()->mergeCells('B16:D16');
		 $this->excel->getActiveSheet()->mergeCells('B17:D17');
		 $this->excel->getActiveSheet()->mergeCells('B18:D18');
		 $this->excel->getActiveSheet()->mergeCells('B19:D19');
		 $this->excel->getActiveSheet()->mergeCells('B20:D20');
		 $this->excel->getActiveSheet()->mergeCells('B21:D21');
		 $this->excel->getActiveSheet()->mergeCells('B22:D22');
		 $this->excel->getActiveSheet()->mergeCells('B23:D23');
		 $this->excel->getActiveSheet()->mergeCells('B24:D24');
		 $this->excel->getActiveSheet()->mergeCells('A25:H25');
		 $this->excel->getActiveSheet()->mergeCells('A26:I26');
		 $this->excel->getActiveSheet()->mergeCells('B27:C27');
		 $this->excel->getActiveSheet()->mergeCells('B28:C28');
		 $this->excel->getActiveSheet()->mergeCells('B29:C29');
		 $this->excel->getActiveSheet()->mergeCells('B30:C30');
		 $this->excel->getActiveSheet()->mergeCells('B31:C31');
		 $this->excel->getActiveSheet()->mergeCells('B32:C32');
		 $this->excel->getActiveSheet()->mergeCells('B33:C33');
		 $this->excel->getActiveSheet()->mergeCells('B34:C34');
		 $this->excel->getActiveSheet()->mergeCells('B35:C35');
		 $this->excel->getActiveSheet()->mergeCells('B36:C36');
		 $this->excel->getActiveSheet()->mergeCells('B37:C37');
		 $this->excel->getActiveSheet()->mergeCells('A38:H38');
		 $this->excel->getActiveSheet()->mergeCells('A39:H39');
		 $this->excel->getActiveSheet()->mergeCells('A40:I40');
		 $this->excel->getActiveSheet()->mergeCells('A41:F44');
		 $this->excel->getActiveSheet()->mergeCells('G41:I41');
		 $this->excel->getActiveSheet()->mergeCells('G42:I42');
		 $this->excel->getActiveSheet()->mergeCells('G43:I43');
		 $this->excel->getActiveSheet()->mergeCells('G44:I44');
		 $this->excel->getActiveSheet()->mergeCells('A45:I45');
		 $this->excel->getActiveSheet()->mergeCells('A46:D46');$this->excel->getActiveSheet()->mergeCells('E46:G46');$this->excel->getActiveSheet()->mergeCells('H46:I46');
		 $this->excel->getActiveSheet()->mergeCells('A47:D47');$this->excel->getActiveSheet()->mergeCells('E47:G47');$this->excel->getActiveSheet()->mergeCells('H47:I47');
		 
		 
		//Insertar valores
		 $this->excel->getActiveSheet()->setCellValue("A1", 'MINISTERIO DE LA INDUSTRIA BÁSICA');	        
	     $this->excel->getActiveSheet()->setCellValue("A2", 'EMPRESA SALINERA JOA');	        
	     $this->excel->getActiveSheet()->setCellValue("A3", 'UNIDAD BÁSICA MANTENIMENTO');	        
	     $this->excel->getActiveSheet()->setCellValue("A4", 'Orden de trabajo:');
	     $this->excel->getActiveSheet()->setCellValue("C4", $dat[0]['id_orden']);	        
	     $this->excel->getActiveSheet()->setCellValue("F4", 'Centro Costo:');	     	        
	     $this->excel->getActiveSheet()->setCellValue("H4", $dat[0]['no_centro_costo']);	     	        
	     $this->excel->getActiveSheet()->setCellValue("A5", '____________________');	        
	     $this->excel->getActiveSheet()->setCellValue("A6", 'Área');	        
	     $this->excel->getActiveSheet()->setCellValue("A7", '____________________');	        
	     $this->excel->getActiveSheet()->setCellValue("A8", 'Ejecutante');	        
	     $this->excel->getActiveSheet()->setCellValue("A9", 'Descripción del trabajo:');	        
	     $this->excel->getActiveSheet()->setCellValue("A10", $dat[0]['descripcion']);	        
	     $this->excel->getActiveSheet()->setCellValue("D5", $dat[0]['nombre_centro_costo']);
		 $this->excel->getActiveSheet()->setCellValue("D6", 'Equipo');	        
	     $this->excel->getActiveSheet()->setCellValue("D7", $dat[0]['fecha2']);
		 $this->excel->getActiveSheet()->setCellValue("D8", 'Fecha de emisión');
		 $this->excel->getActiveSheet()->setCellValue("G5", '____________________');	        
	     $this->excel->getActiveSheet()->setCellValue("G6", 'Tipo de reparación');	        
	     $this->excel->getActiveSheet()->setCellValue("G7", '____________________');	        
	     $this->excel->getActiveSheet()->setCellValue("G8", 'Aprobado por');	        
	     $this->excel->getActiveSheet()->setCellValue("G5", '____________________');	
         $this->excel->getActiveSheet()->setCellValue("A13", 'Fuerza de trabajo utilizada');	        
	     $this->excel->getActiveSheet()->setCellValue("A14", 'No');$this->excel->getActiveSheet()->setCellValue("B14", 'Nombres y apellidos');$this->excel->getActiveSheet()->setCellValue("E14", 'Especialidad');$this->excel->getActiveSheet()->setCellValue("F14", 'Fecha');$this->excel->getActiveSheet()->setCellValue("G14", 'Hora(s)');$this->excel->getActiveSheet()->setCellValue("H14", 'Tarifa');$this->excel->getActiveSheet()->setCellValue("I14", 'Importe'); 	        
	     $this->excel->getActiveSheet()->setCellValue("A25",  'Subtotal');	        
	     $this->excel->getActiveSheet()->setCellValue("A26", 'Materiales utilizados');
		 $this->excel->getActiveSheet()->setCellValue("A27", 'No');$this->excel->getActiveSheet()->setCellValue("B27", 'Detalles de materiales');$this->excel->getActiveSheet()->setCellValue("D27", 'No vale');$this->excel->getActiveSheet()->setCellValue("E27", 'Fecha');$this->excel->getActiveSheet()->setCellValue("F27", 'U/M');$this->excel->getActiveSheet()->setCellValue("G27", 'Cantidad');$this->excel->getActiveSheet()->setCellValue("H27", 'Precio');$this->excel->getActiveSheet()->setCellValue("I27", 'Importe');	        
	     $this->excel->getActiveSheet()->setCellValue("A38", 'Subtotal');	        
	     $this->excel->getActiveSheet()->setCellValue("A39", 'Costo total de la orden de trabajo');	        
	     $this->excel->getActiveSheet()->setCellValue("G41", 'Fecha de inicio');	        
	     $this->excel->getActiveSheet()->setCellValue("G42", $dat[0]['fecha2']);	        
	     $this->excel->getActiveSheet()->setCellValue("G43", 'Fecha de terminación');	        
	     $this->excel->getActiveSheet()->setCellValue("G44", $dat[0]['fecha1']);	        
	     $this->excel->getActiveSheet()->setCellValue("A45", 'Trabajo aceptado por:');	        
	     $this->excel->getActiveSheet()->setCellValue("A46", '____________________');$this->excel->getActiveSheet()->setCellValue("E46", '____________________');$this->excel->getActiveSheet()->setCellValue("H46", '____________________');	        
         $this->excel->getActiveSheet()->setCellValue("A47", '   Nombre y Apellidos');$this->excel->getActiveSheet()->setCellValue("E47", '             Cargo');$this->excel->getActiveSheet()->setCellValue("H47", '            Firma');
	     
       //ancho de columnas.
       $this->excel->getActiveSheet()->getColumnDimension('A')->setWidth(4);
	   $this->excel->getActiveSheet()->getColumnDimension('B')->setWidth(14);
	   $this->excel->getActiveSheet()->getColumnDimension('C')->setWidth(14);
	   $this->excel->getActiveSheet()->getColumnDimension('D')->setWidth(8);
	   $this->excel->getActiveSheet()->getColumnDimension('E')->setWidth(20);
	   $this->excel->getActiveSheet()->getColumnDimension('F')->setWidth(10);
	   $this->excel->getActiveSheet()->getColumnDimension('G')->setWidth(10);
	   $this->excel->getActiveSheet()->getColumnDimension('H')->setWidth(10);
	   $this->excel->getActiveSheet()->getColumnDimension('I')->setWidth(10);
	   
	  /* foreach (range('E', 'K') as $columnID) {
       //autodimensionar las columnas
       $this->excel->getActiveSheet()->getColumnDimension($columnID)->setAutoSize(true);
       }*/
	   
	  //Aplicando negrita a los títulos de la cabecera.
	   // $this->excel->getActiveSheet()->getStyle("A{$contador}:L{$contador}")->getFont()->setBold(true);
	   
	   $contador = 14;  
	  //Formato de celdas, alineación
	    	
	    $this->excel->getActiveSheet()->getStyle("A1:A3")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->getStyle("A4")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
		$this->excel->getActiveSheet()->getStyle("C4")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
		$this->excel->getActiveSheet()->getStyle("F4")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
		$this->excel->getActiveSheet()->getStyle("H4")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
		$this->excel->getActiveSheet()->getStyle("A5:G8")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->getStyle("A13:I14")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->getStyle("A13:I14")->getFont()->setBold(true);
		$this->excel->getActiveSheet()->getStyle("A10")->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		$this->excel->getActiveSheet()->getStyle("A15:A24")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
		$this->excel->getActiveSheet()->getStyle("B15:E24")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
		$this->excel->getActiveSheet()->getStyle("G15:I24")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->getStyle("A25")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
		$this->excel->getActiveSheet()->getStyle("A26")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->getStyle("A27:I27")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->getStyle("A27:I27")->getFont()->setBold(true);
		$this->excel->getActiveSheet()->getStyle("I25")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->getStyle("A25:I26")->getFont()->setBold(true);
		$this->excel->getActiveSheet()->getStyle("A28:A37")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->getStyle("D28:E37")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->getStyle("F28:I37")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->getStyle("A38:H39")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
		$this->excel->getActiveSheet()->getStyle("A38:I39")->getFont()->setBold(true);
		$this->excel->getActiveSheet()->getStyle("I38:I39")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->getStyle("G41")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->getStyle("G42")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->getStyle("G43")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->getStyle("G44")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		
	    		 
	 //Definimos la data del cuerpo.
	 //Contador de filas       
 foreach($datos as $v){
 	    if ($v->nombre_producto==NULL) {
 	    	$contador++;
         $this->excel->getActiveSheet()->setCellValue("A{$contador}", $contador-14);
         $this->excel->getActiveSheet()->setCellValue("B{$contador}", $v->receptor);
         $this->excel->getActiveSheet()->setCellValue("E{$contador}", $v->despachador);
         $this->excel->getActiveSheet()->setCellValue("F{$contador}", $v->fecha3);
         $this->excel->getActiveSheet()->setCellValue("G{$contador}", $v->bultos);
         $this->excel->getActiveSheet()->setCellValue("H{$contador}", $v->importe_unitario);
         $this->excel->getActiveSheet()->setCellValue("I{$contador}", $v->importe_mlc);
 	    }
    }
        //Contador de filas
        $contador = 27;	
 foreach($datos as $v){
 	    if ($v->nombre_producto!==NULL) {
 	    	$contador++;
         $this->excel->getActiveSheet()->setCellValue("A{$contador}", $contador-27);
         $this->excel->getActiveSheet()->setCellValue("B{$contador}", $v->nombre_producto);
         $this->excel->getActiveSheet()->setCellValue("D{$contador}", $v->consecutivo);
         $this->excel->getActiveSheet()->setCellValue("E{$contador}", $v->fecha_vale);
         $this->excel->getActiveSheet()->setCellValue("F{$contador}", $v->unidad_medida);
         $this->excel->getActiveSheet()->setCellValue("G{$contador}", $v->cantidad);
         $this->excel->getActiveSheet()->setCellValue("H{$contador}", $v->precio_mn);
         $this->excel->getActiveSheet()->setCellValue("I{$contador}", $v->importe_mlc);
 	    }
    }		
	
		 
		// $this->excel->getActiveSheet()->getStyle("F21")->getFont()->setBold(true);
		 $this->excel->getActiveSheet()->setCellValue('I25', '=SUM(I15:I24)');
		 		 
		 $this->excel->getActiveSheet()->getStyle("F21")->getFont()->setBold(true);		 
		 $this->excel->getActiveSheet()->setCellValue('I38', '=SUM(I28:I37)');
		 $this->excel->getActiveSheet()->setCellValue('I39', '=SUM(I25+I38)');
		 
		 
		 //Le ponemos un nombre al archivo que se va a generar.
	        $archivo = "Orden_trabajo_Resumen_{$dat[0]['consecutivo']}.xls";
	        header('Content-Type: application/vnd.ms-excel');
	        header('Content-Disposition: attachment;filename="'.$archivo.'"');
	        header('Cache-Control: max-age=0');
	        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
            //Hacemos una salida al navegador con el archivo Excel.
        $objWriter->save('php://output');
	} 
}

    public function exportar_vale_entrega(){
		$user=$this->session->userdata('useralias');
		$datos=$this->reporte->temp_vales($user)->result();
		$dat = json_decode(json_encode($datos), true);
        
        if(count($datos) > 0){
         $this->excel->getActiveSheet()->setTitle('Vales');
		 $this->excel->getProperties()->setCreator("Poli_system"); 
        
		//Contador de filas
        $contador = 9;
		//Configurando el documento 
		$this->excel->getDefaultStyle()->getFont()->setName("Arial")->setSize(14)->setBold();
		$this->excel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
        $this->excel->getActiveSheet()->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_LETTER);
		
		//Alto de Filas
		$this->excel->getActiveSheet()->getRowDimension(1)->setRowHeight(23);
		$this->excel->getActiveSheet()->getRowDimension(2)->setRowHeight(23);
		$this->excel->getActiveSheet()->getRowDimension(3)->setRowHeight(23);
		$this->excel->getActiveSheet()->getRowDimension(4)->setRowHeight(23);
		$this->excel->getActiveSheet()->getRowDimension(5)->setRowHeight(23);
		$this->excel->getActiveSheet()->getRowDimension(6)->setRowHeight(23);
		$this->excel->getActiveSheet()->getRowDimension(7)->setRowHeight(23);
		$this->excel->getActiveSheet()->getRowDimension(8)->setRowHeight(23);
		$this->excel->getActiveSheet()->getRowDimension(9)->setRowHeight(23);
		$this->excel->getActiveSheet()->getRowDimension(10)->setRowHeight(23);
		$this->excel->getActiveSheet()->getRowDimension(11)->setRowHeight(23);
		$this->excel->getActiveSheet()->getRowDimension(12)->setRowHeight(23);
		$this->excel->getActiveSheet()->getRowDimension(13)->setRowHeight(23);
		$this->excel->getActiveSheet()->getRowDimension(14)->setRowHeight(23);
		$this->excel->getActiveSheet()->getRowDimension(15)->setRowHeight(23);
		$this->excel->getActiveSheet()->getRowDimension(16)->setRowHeight(23);
		$this->excel->getActiveSheet()->getRowDimension(17)->setRowHeight(23);
		$this->excel->getActiveSheet()->getRowDimension(18)->setRowHeight(23);
		$this->excel->getActiveSheet()->getRowDimension(19)->setRowHeight(23);
		$this->excel->getActiveSheet()->getRowDimension(20)->setRowHeight(23);
		$this->excel->getActiveSheet()->getRowDimension(21)->setRowHeight(23);
		$this->excel->getActiveSheet()->getRowDimension(22)->setRowHeight(2);
		$this->excel->getActiveSheet()->getRowDimension(23)->setRowHeight(2);
		$this->excel->getActiveSheet()->getRowDimension(24)->setRowHeight(2);
		$this->excel->getActiveSheet()->getRowDimension(25)->setRowHeight(23);
		$this->excel->getActiveSheet()->getRowDimension(26)->setRowHeight(23);
		$this->excel->getActiveSheet()->getRowDimension(27)->setRowHeight(23);
		$this->excel->getActiveSheet()->getRowDimension(28)->setRowHeight(23);
		$this->excel->getActiveSheet()->getRowDimension(29)->setRowHeight(23);
		
		//Bordes y fuente
        $bordes = new PHPExcel_Style();
        $bordes->applyFromArray(
        array('font' => array('size' => 12, 'name' => 'Arial')
		,'borders' => array(
        'top' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
        'right' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
        'bottom' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
        'left' => array('style' => PHPExcel_Style_Border::BORDER_THIN)
        )));
        $this->excel->getActiveSheet()->setSharedStyle($bordes, "A1:K4");
        $this->excel->getActiveSheet()->setSharedStyle($bordes, "L1:N2");
        $this->excel->getActiveSheet()->setSharedStyle($bordes, "A5:N6");
        $this->excel->getActiveSheet()->setSharedStyle($bordes, "D7:I7");
        $this->excel->getActiveSheet()->setSharedStyle($bordes, "A25:N29");
       
	    $bordes3 = new PHPExcel_Style();
        $bordes3->applyFromArray(
        array('font' => array('size' => 14, 'name' => 'Arial')
		,'borders' => array(
        'top' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
        'right' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
        'bottom' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
        'left' => array('style' => PHPExcel_Style_Border::BORDER_THIN)
        )));
        $this->excel->getActiveSheet()->setSharedStyle($bordes3, "M27:N28");
        $this->excel->getActiveSheet()->setSharedStyle($bordes3, "L26");
		
        //establecer margenes
         $margin = 0.5 / 2.54; // 0.5 centimetros
         $margin2 = 0.8 / 2.54; // 0.5 centimetros
         $marginBottom = 2.5 / 2.54; //1.2 centimetros
         $this->excel->getActiveSheet()->getPageMargins()->setTop($marginBottom);
         $this->excel->getActiveSheet()->getPageMargins()->setBottom($marginBottom);
         $this->excel->getActiveSheet()->getPageMargins()->setLeft($margin);
         $this->excel->getActiveSheet()->getPageMargins()->setRight($margin2);
        
		//establecer impresion a pagina completa
         $this->excel->getActiveSheet()->getPageSetup()->setFitToPage(true);
         $this->excel->getActiveSheet()->getPageSetup()->setFitToWidth(1);
         $this->excel->getActiveSheet()->getPageSetup()->setFitToHeight(0);
         
		//Proteger datos
		$this->excel->getActiveSheet()->getProtection()->setPassword('PassPoli,Sistema');
        $this->excel->getActiveSheet()->getProtection()->setSheet(true); 
        $this->excel->getActiveSheet()->getProtection()->setSort(true);
        $this->excel->getActiveSheet()->getProtection()->setInsertRows(true);
        $this->excel->getActiveSheet()->getProtection()->setFormatCells(true);
        $this->excel->getActiveSheet()->getProtection()->setObjects(true);
        
		//Agrupar celdas
		 $this->excel->getActiveSheet()->mergeCells('A1:F1');$this->excel->getActiveSheet()->mergeCells('G1:I1');$this->excel->getActiveSheet()->mergeCells('J1:K1');$this->excel->getActiveSheet()->mergeCells('L1:N1');
		 $this->excel->getActiveSheet()->mergeCells('A2:F2');$this->excel->getActiveSheet()->mergeCells('G2:H2');$this->excel->getActiveSheet()->mergeCells('I2:I4');$this->excel->getActiveSheet()->mergeCells('J2:K4');
		 $this->excel->getActiveSheet()->mergeCells('A3:F3');$this->excel->getActiveSheet()->mergeCells('G3:H3');$this->excel->getActiveSheet()->mergeCells('L3:N4');
		 $this->excel->getActiveSheet()->mergeCells('A4:F4');$this->excel->getActiveSheet()->mergeCells('G4:H4');
		 $this->excel->getActiveSheet()->mergeCells('A5:F5');$this->excel->getActiveSheet()->mergeCells('H5:I5');$this->excel->getActiveSheet()->mergeCells('J5:K5');$this->excel->getActiveSheet()->mergeCells('L5:M5');
		 $this->excel->getActiveSheet()->mergeCells('A6:C6');$this->excel->getActiveSheet()->mergeCells('D6:F6');$this->excel->getActiveSheet()->mergeCells('G6:I6');$this->excel->getActiveSheet()->mergeCells('J6:K6');$this->excel->getActiveSheet()->mergeCells('L6:N6');
		 $this->excel->getActiveSheet()->mergeCells('A7:C7');$this->excel->getActiveSheet()->mergeCells('G7:I7');$this->excel->getActiveSheet()->mergeCells('J7:K7');$this->excel->getActiveSheet()->mergeCells('L7:N7');
		 $this->excel->getActiveSheet()->mergeCells('A8:N8');$this->excel->getActiveSheet()->mergeCells('A21:H21');$this->excel->getActiveSheet()->mergeCells('A20:N20');
		 $this->excel->getActiveSheet()->mergeCells('L9:N9');$this->excel->getActiveSheet()->mergeCells('L10:N10');$this->excel->getActiveSheet()->mergeCells('L11:N11');$this->excel->getActiveSheet()->mergeCells('L12:N12');$this->excel->getActiveSheet()->mergeCells('L13:N13');$this->excel->getActiveSheet()->mergeCells('L14:N14');
         $this->excel->getActiveSheet()->mergeCells('L15:N15');$this->excel->getActiveSheet()->mergeCells('L16:N16');$this->excel->getActiveSheet()->mergeCells('L17:N17');$this->excel->getActiveSheet()->mergeCells('L18:N18');$this->excel->getActiveSheet()->mergeCells('L19:N19');		 
		 $this->excel->getActiveSheet()->mergeCells('A22:N24');$this->excel->getActiveSheet()->mergeCells('L21:N21');
		 $this->excel->getActiveSheet()->mergeCells('A25:C25');$this->excel->getActiveSheet()->mergeCells('E25:H25');$this->excel->getActiveSheet()->mergeCells('I25:J25');$this->excel->getActiveSheet()->mergeCells('L25:N25');
		 $this->excel->getActiveSheet()->mergeCells('A26:C26');$this->excel->getActiveSheet()->mergeCells('E26:H26');$this->excel->getActiveSheet()->mergeCells('I26:K26');$this->excel->getActiveSheet()->mergeCells('L26:N26');
		 $this->excel->getActiveSheet()->mergeCells('A27:C27');$this->excel->getActiveSheet()->mergeCells('E27:H27');$this->excel->getActiveSheet()->mergeCells('I27:K27');$this->excel->getActiveSheet()->mergeCells('M27:N27');
		 $this->excel->getActiveSheet()->mergeCells('A28:C28');$this->excel->getActiveSheet()->mergeCells('E28:H28');$this->excel->getActiveSheet()->mergeCells('I28:K28');$this->excel->getActiveSheet()->mergeCells('M28:N28');
		 $this->excel->getActiveSheet()->mergeCells('B29:C29');$this->excel->getActiveSheet()->mergeCells('E29:F29');$this->excel->getActiveSheet()->mergeCells('G29:H29');$this->excel->getActiveSheet()->mergeCells('I29:K29');$this->excel->getActiveSheet()->mergeCells('L29:N29');
		 
		//Insertar valores
		 $this->excel->getActiveSheet()->setCellValue("A1", 'Entidad: ENSAL');	        
	     $this->excel->getActiveSheet()->setCellValue("A2", 'Unidad: UEB Salina Joa');	        
	     $this->excel->getActiveSheet()->setCellValue("A3", 'Entidad o almacén que entrega: Materiales');	        
	     $this->excel->getActiveSheet()->setCellValue("A4", 'Entidad o almacén que recibe:');	        
	     $this->excel->getActiveSheet()->setCellValue("A5", 'Entidad suministradora(nombre-dirección)');	        
	     $this->excel->getActiveSheet()->setCellValue("A6", 'Orden de trabajo');	        
	     $this->excel->getActiveSheet()->setCellValue("A7", $dat[0]['id_orden']);	        
	     $this->excel->getActiveSheet()->setCellValue("A25", 'Despachado o Confeccionado:');	        
	     $this->excel->getActiveSheet()->setCellValue("A26", $dat[0]['despachador']);	        
	     $this->excel->getActiveSheet()->setCellValue("A27", 'Firma:');	        
	     $this->excel->getActiveSheet()->setCellValue("A28", 'Jefe-Almacén:');	        
	     $this->excel->getActiveSheet()->setCellValue("A29", 'Fecha:');	        
	     $this->excel->getActiveSheet()->setCellValue("B29", $dat[0]['fecha_vale']);	        
	     $this->excel->getActiveSheet()->setCellValue("D6", 'Producto');
		 $this->excel->getActiveSheet()->setCellValue("D7", $dat[0]['clasificacion_producto']);	        
	     $this->excel->getActiveSheet()->setCellValue("D25", 'Autorizado:');
		 $this->excel->getActiveSheet()->setCellValue("D27", 'Firma:');
		 $this->excel->getActiveSheet()->setCellValue("D28", 'Inf. reclam                         Act. Trasl.');
		 $this->excel->getActiveSheet()->setCellValue("D29", 'Fecha:                                 Fecha:');
		 $this->excel->getActiveSheet()->setCellValue("E7", 'Chapa:');
		 $this->excel->getActiveSheet()->setCellValue("E25", 'Recibido:');
		 $this->excel->getActiveSheet()->setCellValue("E26", $dat[0]['receptor']);
		 $this->excel->getActiveSheet()->setCellValue("E27", 'Firma:');
		 $this->excel->getActiveSheet()->setCellValue("E28", 'Recepcionado:');
		 $this->excel->getActiveSheet()->setCellValue("E29", 'Fecha:');
		 $this->excel->getActiveSheet()->setCellValue("F7", $dat[0]['chapa']);	        
	     $this->excel->getActiveSheet()->setCellValue("G1", 'Código: 104.0.14051');	        
	     $this->excel->getActiveSheet()->setCellValue("G2", 'Código: 49');	        
	     $this->excel->getActiveSheet()->setCellValue("G3", 'Código: 699');	        
	     $this->excel->getActiveSheet()->setCellValue("G4", 'Código:');	        
	     $this->excel->getActiveSheet()->setCellValue("G5", 'Código:');	
         $this->excel->getActiveSheet()->setCellValue("G6", 'Centro Costo(nombre)');	        
	     $this->excel->getActiveSheet()->setCellValue("G7",  $dat[0]['nombre_centro_costo']);	        
	     $this->excel->getActiveSheet()->setCellValue("G29", $dat[0]['fecha_vale']);
		 $this->excel->getActiveSheet()->setCellValue("H5", 'Contrato No:');	        
	     $this->excel->getActiveSheet()->setCellValue("I25", 'Anotado Control Inv.');	        
	     $this->excel->getActiveSheet()->setCellValue("I27", 'Firma:');	        
	     $this->excel->getActiveSheet()->setCellValue("I28", 'Contabilizado-Firma:');	        
	     $this->excel->getActiveSheet()->setCellValue("I29", 'Fecha:');	        
	     $this->excel->getActiveSheet()->setCellValue("K25", 'Fecha:');	        
	     $this->excel->getActiveSheet()->setCellValue("J1", 'Modelo múltiple');	        
	     $this->excel->getActiveSheet()->setCellValue("J2", 'Vale de entrega');		 
	     $this->excel->getActiveSheet()->setCellValue("J5", 'Factura No:');		 
	     $this->excel->getActiveSheet()->setCellValue("J6", 'Centro Costo(número)');		 
	     $this->excel->getActiveSheet()->setCellValue("J7", $dat[0]['no_centro_costo']);		 
	     $this->excel->getActiveSheet()->setCellValue("L1", 'Fecha');		 
	     $this->excel->getActiveSheet()->setCellValue("L2", 'A');		 
	     $this->excel->getActiveSheet()->setCellValue("L3", $dat[0]['fecha_vale']);		 
	     $this->excel->getActiveSheet()->setCellValue("L5", 'Conduce No:');		 
	     $this->excel->getActiveSheet()->setCellValue("L6", 'Bultos');		 
	     $this->excel->getActiveSheet()->setCellValue("L7", $dat[0]['bultos']);
         $this->excel->getActiveSheet()->setCellValue("L25", 'Consecutivo No.:');	        
	     $this->excel->getActiveSheet()->setCellValue("L27", 'Sol No.:');	        
	     $this->excel->getActiveSheet()->setCellValue("L28", 'Doc No.:');	        
	     $this->excel->getActiveSheet()->setCellValue("M2", 'M');		 
	     $this->excel->getActiveSheet()->setCellValue("M27", $dat[0]['no_solicitud_compra']);	        
	     $this->excel->getActiveSheet()->setCellValue("M28", $dat[0]['consecutivo']);	        
	     $this->excel->getActiveSheet()->setCellValue("N2", 'D');		 
	     $this->excel->getActiveSheet()->setCellValue("N5", $dat[0]['no_conduce']);		 
	     $this->excel->getActiveSheet()->setCellValue("L26", $dat[0]['consecutivo']);	        
	     
       //ancho de columnas.
       $this->excel->getActiveSheet()->getColumnDimension('A')->setWidth(17);
	   $this->excel->getActiveSheet()->getColumnDimension('B')->setWidth(5);
	   $this->excel->getActiveSheet()->getColumnDimension('C')->setWidth(4);
	   $this->excel->getActiveSheet()->getColumnDimension('D')->setWidth(32);
	   $this->excel->getActiveSheet()->getColumnDimension('E')->setWidth(6);
	   $this->excel->getActiveSheet()->getColumnDimension('F')->setWidth(14);
	   $this->excel->getActiveSheet()->getColumnDimension('G')->setWidth(11);
	   $this->excel->getActiveSheet()->getColumnDimension('H')->setWidth(4);
	   $this->excel->getActiveSheet()->getColumnDimension('I')->setWidth(12);
	   $this->excel->getActiveSheet()->getColumnDimension('J')->setWidth(3);
	   $this->excel->getActiveSheet()->getColumnDimension('K')->setWidth(11);
	   $this->excel->getActiveSheet()->getColumnDimension('L')->setWidth(5);
	   $this->excel->getActiveSheet()->getColumnDimension('M')->setWidth(4);
	   $this->excel->getActiveSheet()->getColumnDimension('N')->setWidth(4);
	   
	   
	  /* foreach (range('E', 'K') as $columnID) {
       //autodimensionar las columnas
       $this->excel->getActiveSheet()->getColumnDimension($columnID)->setAutoSize(true);
       }*/
	   
	  //Aplicando negrita a los títulos de la cabecera.
	   // $this->excel->getActiveSheet()->getStyle("A{$contador}:L{$contador}")->getFont()->setBold(true);
	     
	  //títulos de la cabecera.
	    $this->excel->getActiveSheet()->setCellValue("A{$contador}", 'Código');	        
	    $this->excel->getActiveSheet()->setCellValue("B{$contador}", 'Cta');
	    $this->excel->getActiveSheet()->setCellValue("C{$contador}", 'Sub-Cta');
	    $this->excel->getActiveSheet()->setCellValue("D{$contador}", 'Descripción');
	    $this->excel->getActiveSheet()->setCellValue("E{$contador}", 'UM');
	    $this->excel->getActiveSheet()->setCellValue("F{$contador}", 'Cant.');
	    $this->excel->getActiveSheet()->setCellValue("G{$contador}", 'Precio(MN)');
	    $this->excel->getActiveSheet()->setCellValue("H{$contador}", 'Prec(mlc)');
	    $this->excel->getActiveSheet()->setCellValue("I{$contador}", 'Importe(MN)');
	    $this->excel->getActiveSheet()->setCellValue("J{$contador}", 'Imp(mlc)');
	    $this->excel->getActiveSheet()->setCellValue("K{$contador}", 'Importe');
	    $this->excel->getActiveSheet()->setCellValue("L{$contador}", 'Saldo en existencia');
		
	 //Formato de celdas, alineación
	    $this->excel->getActiveSheet()->getStyle("A{$contador}:L{$contador}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->getStyle("A10:A19")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
		$this->excel->getActiveSheet()->getStyle("B10:C19")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->getStyle("E10:N21")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->getStyle("J1:N4")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->getStyle("A6:N7")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->getStyle("A21")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
		$this->excel->getActiveSheet()->getStyle("L26")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->getStyle("L3")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
		$this->excel->getActiveSheet()->getStyle("L27:N29")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
		$this->excel->getActiveSheet()->getStyle("A21:N29")->getFont()->setBold(true);
	    		 
	 //Definimos la data del cuerpo.    
 foreach($datos as $v){
         $contador++;
         $this->excel->getActiveSheet()->setCellValue("A{$contador}", $v->id_producto);
         $this->excel->getActiveSheet()->setCellValue("B{$contador}", $v->cta);
         $this->excel->getActiveSheet()->setCellValue("C{$contador}", $v->sub_cta);
         $this->excel->getActiveSheet()->setCellValue("D{$contador}", $v->nombre_producto);
         $this->excel->getActiveSheet()->setCellValue("E{$contador}", $v->unidad_medida);
         $this->excel->getActiveSheet()->setCellValue("F{$contador}", $v->cantidad);
         $this->excel->getActiveSheet()->setCellValue("G{$contador}", $v->precio_mn);
         $this->excel->getActiveSheet()->setCellValue("H{$contador}", $v->precio_mlc);
         $this->excel->getActiveSheet()->setCellValue("I{$contador}", $v->importe_mn);
         $this->excel->getActiveSheet()->setCellValue("J{$contador}", $v->importe_mlc);
         $this->excel->getActiveSheet()->setCellValue("K{$contador}", $v->importe_unitario);
         $this->excel->getActiveSheet()->setCellValue("L{$contador}", $v->resto);
         $this->excel->getActiveSheet()->getStyle("A{$contador}:N{$contador}")->getFont()->setBold(true);
	   }
		
	//rellenar con contenido
    if ($v->estado=='cancelado') {
       for ($i=$contador+1; $i<20; $i++) {
         $this->excel->getActiveSheet()->setCellValue("D{$i}", 'CANCELADO');$this->excel->getActiveSheet()->getStyle("D{$i}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
         $this->excel->getActiveSheet()->setCellValue("I{$i}", 'CANCELADO');$this->excel->getActiveSheet()->getStyle("I{$i}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
         }
    }

                      
                    		 
		 $this->excel->getActiveSheet()->setCellValue('A21', 'Importe Total de la Operación');
         $this->excel->getActiveSheet()->getStyle("F21")->getFont()->setBold(true);		 
		 $this->excel->getActiveSheet()->setCellValue('I21', '=SUM(I10:I19)');
		 $this->excel->getActiveSheet()->setCellValue('J21', '=SUM(J10:J19)');
		 $this->excel->getActiveSheet()->setCellValue('K21', '=SUM(K10:K19)');	
		 
		 $this->excel->getActiveSheet()->setCellValue('A21', 'Importe Total de la Operación');
         $this->excel->getActiveSheet()->getStyle("F21")->getFont()->setBold(true);		 
		 $this->excel->getActiveSheet()->setCellValue('I21', '=SUM(I10:I19)');
		 $this->excel->getActiveSheet()->setCellValue('J21', '=SUM(J10:J19)');
		 $this->excel->getActiveSheet()->setCellValue('K21', '=SUM(K10:K19)');

		 //Incertar imagen
      $objDrawing = new PHPExcel_Worksheet_Drawing();
				$objDrawing->setName('QR');
				$objDrawing->setDescription('QR');
				$qr = 'qr_code/'.$user.'/temp.png';
				$objDrawing->setPath($qr);
				$objDrawing->setOffsetX(8);
				$objDrawing->setOffsetY(300);
				$objDrawing->setCoordinates('I2');
				$objDrawing->setHeight(90);
				$objDrawing->setWorksheet($this->excel->getActiveSheet());

                   		 
		 //Le ponemos un nombre al archivo que se va a generar.
	        $archivo = "Vale entrega_{$dat[0]['consecutivo']}.xls";
	        header('Content-Type: application/vnd.ms-excel');
	        header('Content-Disposition: attachment;filename="'.$archivo.'"');
	        header('Cache-Control: max-age=0');
	        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
            //Hacemos una salida al navegador con el archivo Excel.
        $objWriter->save('php://output');
	} 
}

public function exportar_medios_basicos(){
		$user=$this->session->userdata('useralias');
		$datos=$this->reporte->temp_vales($user)->result();
		$dat = json_decode(json_encode($datos), true);
        
        if(count($datos) > 0){
         $this->excel->getActiveSheet()->setTitle('Vales');
		 $this->excel->getProperties()->setCreator("Poli_system"); 
        
		//Contador de filas
        $contador = 9;
		//Configurando el documento 
		$this->excel->getDefaultStyle()->getFont()->setName("Arial")->setSize(14)->setBold();
		$this->excel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
        $this->excel->getActiveSheet()->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_LETTER);
		
		//Alto de Filas
		$this->excel->getActiveSheet()->getRowDimension(1)->setRowHeight(23);
		$this->excel->getActiveSheet()->getRowDimension(2)->setRowHeight(23);
		$this->excel->getActiveSheet()->getRowDimension(3)->setRowHeight(23);
		$this->excel->getActiveSheet()->getRowDimension(4)->setRowHeight(23);
		$this->excel->getActiveSheet()->getRowDimension(5)->setRowHeight(23);
		$this->excel->getActiveSheet()->getRowDimension(6)->setRowHeight(23);
		$this->excel->getActiveSheet()->getRowDimension(7)->setRowHeight(23);
		$this->excel->getActiveSheet()->getRowDimension(8)->setRowHeight(23);
		$this->excel->getActiveSheet()->getRowDimension(9)->setRowHeight(23);
		$this->excel->getActiveSheet()->getRowDimension(10)->setRowHeight(23);
		$this->excel->getActiveSheet()->getRowDimension(11)->setRowHeight(23);
		$this->excel->getActiveSheet()->getRowDimension(12)->setRowHeight(23);
		$this->excel->getActiveSheet()->getRowDimension(13)->setRowHeight(23);
		$this->excel->getActiveSheet()->getRowDimension(14)->setRowHeight(23);
		$this->excel->getActiveSheet()->getRowDimension(15)->setRowHeight(23);
		$this->excel->getActiveSheet()->getRowDimension(16)->setRowHeight(23);
		$this->excel->getActiveSheet()->getRowDimension(17)->setRowHeight(23);
		$this->excel->getActiveSheet()->getRowDimension(18)->setRowHeight(23);
		$this->excel->getActiveSheet()->getRowDimension(19)->setRowHeight(23);
		$this->excel->getActiveSheet()->getRowDimension(20)->setRowHeight(23);
		$this->excel->getActiveSheet()->getRowDimension(21)->setRowHeight(23);
		$this->excel->getActiveSheet()->getRowDimension(22)->setRowHeight(2);
		$this->excel->getActiveSheet()->getRowDimension(23)->setRowHeight(2);
		$this->excel->getActiveSheet()->getRowDimension(24)->setRowHeight(2);
		$this->excel->getActiveSheet()->getRowDimension(25)->setRowHeight(23);
		$this->excel->getActiveSheet()->getRowDimension(26)->setRowHeight(23);
		$this->excel->getActiveSheet()->getRowDimension(27)->setRowHeight(23);
		$this->excel->getActiveSheet()->getRowDimension(28)->setRowHeight(23);
		$this->excel->getActiveSheet()->getRowDimension(29)->setRowHeight(23);
		
		//Bordes y fuente
        $bordes = new PHPExcel_Style();
        $bordes->applyFromArray(
        array('font' => array('size' => 12, 'name' => 'Arial')
		,'borders' => array(
        'top' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
        'right' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
        'bottom' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
        'left' => array('style' => PHPExcel_Style_Border::BORDER_THIN)
        )));
        $this->excel->getActiveSheet()->setSharedStyle($bordes, "A1:K4");
        $this->excel->getActiveSheet()->setSharedStyle($bordes, "L1:N2");
        $this->excel->getActiveSheet()->setSharedStyle($bordes, "A5:N6");
        $this->excel->getActiveSheet()->setSharedStyle($bordes, "D7:I7");
        $this->excel->getActiveSheet()->setSharedStyle($bordes, "A25:N29");
       
	    $bordes3 = new PHPExcel_Style();
        $bordes3->applyFromArray(
        array('font' => array('size' => 14, 'name' => 'Arial')
		,'borders' => array(
        'top' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
        'right' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
        'bottom' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
        'left' => array('style' => PHPExcel_Style_Border::BORDER_THIN)
        )));
        $this->excel->getActiveSheet()->setSharedStyle($bordes3, "M27:N28");
        $this->excel->getActiveSheet()->setSharedStyle($bordes3, "L26");
		
        //establecer margenes
         $margin = 0.5 / 2.54; // 0.5 centimetros
         $margin2 = 0.8 / 2.54; // 0.5 centimetros
         $marginBottom = 2.5 / 2.54; //1.2 centimetros
         $this->excel->getActiveSheet()->getPageMargins()->setTop($marginBottom);
         $this->excel->getActiveSheet()->getPageMargins()->setBottom($marginBottom);
         $this->excel->getActiveSheet()->getPageMargins()->setLeft($margin);
         $this->excel->getActiveSheet()->getPageMargins()->setRight($margin2);
        
		//establecer impresion a pagina completa
         $this->excel->getActiveSheet()->getPageSetup()->setFitToPage(true);
         $this->excel->getActiveSheet()->getPageSetup()->setFitToWidth(1);
         $this->excel->getActiveSheet()->getPageSetup()->setFitToHeight(0);
         
		//Proteger datos
		$this->excel->getActiveSheet()->getProtection()->setPassword('PassPoli,Sistema');
        $this->excel->getActiveSheet()->getProtection()->setSheet(true); 
        $this->excel->getActiveSheet()->getProtection()->setSort(true);
        $this->excel->getActiveSheet()->getProtection()->setInsertRows(true);
        $this->excel->getActiveSheet()->getProtection()->setFormatCells(true);
        $this->excel->getActiveSheet()->getProtection()->setObjects(true);
        
		//Agrupar celdas
		 $this->excel->getActiveSheet()->mergeCells('A1:F1');$this->excel->getActiveSheet()->mergeCells('G1:I1');$this->excel->getActiveSheet()->mergeCells('J1:K1');$this->excel->getActiveSheet()->mergeCells('L1:N1');
		 $this->excel->getActiveSheet()->mergeCells('A2:F2');$this->excel->getActiveSheet()->mergeCells('G2:H2');$this->excel->getActiveSheet()->mergeCells('I2:I4');$this->excel->getActiveSheet()->mergeCells('J2:K4');
		 $this->excel->getActiveSheet()->mergeCells('A3:F3');$this->excel->getActiveSheet()->mergeCells('G3:H3');$this->excel->getActiveSheet()->mergeCells('L3:N4');
		 $this->excel->getActiveSheet()->mergeCells('A4:F4');$this->excel->getActiveSheet()->mergeCells('G4:H4');
		 $this->excel->getActiveSheet()->mergeCells('A5:F5');$this->excel->getActiveSheet()->mergeCells('H5:I5');$this->excel->getActiveSheet()->mergeCells('J5:K5');$this->excel->getActiveSheet()->mergeCells('L5:M5');
		 $this->excel->getActiveSheet()->mergeCells('A6:C6');$this->excel->getActiveSheet()->mergeCells('D6:F6');$this->excel->getActiveSheet()->mergeCells('G6:I6');$this->excel->getActiveSheet()->mergeCells('J6:K6');$this->excel->getActiveSheet()->mergeCells('L6:N6');
		 $this->excel->getActiveSheet()->mergeCells('A7:C7');$this->excel->getActiveSheet()->mergeCells('D7:F7');$this->excel->getActiveSheet()->mergeCells('G7:I7');$this->excel->getActiveSheet()->mergeCells('J7:K7');$this->excel->getActiveSheet()->mergeCells('L7:N7');
		 $this->excel->getActiveSheet()->mergeCells('A8:N8');$this->excel->getActiveSheet()->mergeCells('A21:H21');$this->excel->getActiveSheet()->mergeCells('A20:N20');
		 $this->excel->getActiveSheet()->mergeCells('L9:N9');$this->excel->getActiveSheet()->mergeCells('L10:N10');$this->excel->getActiveSheet()->mergeCells('L11:N11');$this->excel->getActiveSheet()->mergeCells('L12:N12');$this->excel->getActiveSheet()->mergeCells('L13:N13');$this->excel->getActiveSheet()->mergeCells('L14:N14');
         $this->excel->getActiveSheet()->mergeCells('L15:N15');$this->excel->getActiveSheet()->mergeCells('L16:N16');$this->excel->getActiveSheet()->mergeCells('L17:N17');$this->excel->getActiveSheet()->mergeCells('L18:N18');$this->excel->getActiveSheet()->mergeCells('L19:N19');		 
		 $this->excel->getActiveSheet()->mergeCells('A22:N24');$this->excel->getActiveSheet()->mergeCells('L21:N21');
		 $this->excel->getActiveSheet()->mergeCells('A25:C25');$this->excel->getActiveSheet()->mergeCells('E25:H25');$this->excel->getActiveSheet()->mergeCells('I25:J25');$this->excel->getActiveSheet()->mergeCells('L25:N25');
		 $this->excel->getActiveSheet()->mergeCells('A26:C26');$this->excel->getActiveSheet()->mergeCells('E26:H26');$this->excel->getActiveSheet()->mergeCells('I26:K26');$this->excel->getActiveSheet()->mergeCells('L26:N26');
		 $this->excel->getActiveSheet()->mergeCells('A27:C27');$this->excel->getActiveSheet()->mergeCells('E27:H27');$this->excel->getActiveSheet()->mergeCells('I27:K27');$this->excel->getActiveSheet()->mergeCells('M27:N27');
		 $this->excel->getActiveSheet()->mergeCells('A28:C28');$this->excel->getActiveSheet()->mergeCells('E28:H28');$this->excel->getActiveSheet()->mergeCells('I28:K28');$this->excel->getActiveSheet()->mergeCells('M28:N28');
		 $this->excel->getActiveSheet()->mergeCells('B29:C29');$this->excel->getActiveSheet()->mergeCells('E29:F29');$this->excel->getActiveSheet()->mergeCells('G29:H29');$this->excel->getActiveSheet()->mergeCells('I29:K29');$this->excel->getActiveSheet()->mergeCells('L29:N29');
		 
		//Insertar valores
		 $this->excel->getActiveSheet()->setCellValue("A1", 'Entidad: ENSAL');	        
	     $this->excel->getActiveSheet()->setCellValue("A2", 'Unidad: UEB Salina Joa');	        
	     $this->excel->getActiveSheet()->setCellValue("A3", 'Entidad o almacén que entrega: Materiales');	        
	     $this->excel->getActiveSheet()->setCellValue("A4", 'Entidad o almacén que recibe:');	        
	     $this->excel->getActiveSheet()->setCellValue("A5", 'Entidad suministradora(nombre-dirección)');	        
	     $this->excel->getActiveSheet()->setCellValue("A6", 'Orden de trabajo');	        
	     $this->excel->getActiveSheet()->setCellValue("A7", $dat[0]['id_orden']);	        
	     $this->excel->getActiveSheet()->setCellValue("A25", 'Despachado o Confeccionado:');	        
	     $this->excel->getActiveSheet()->setCellValue("A26", $dat[0]['despachador']);	        
	     $this->excel->getActiveSheet()->setCellValue("A27", 'Firma:');	        
	     $this->excel->getActiveSheet()->setCellValue("A28", 'Jefe-Almacén:');	        
	     $this->excel->getActiveSheet()->setCellValue("A29", 'Fecha:');	        
	     $this->excel->getActiveSheet()->setCellValue("B29", $dat[0]['fecha_vale']);	        
	     $this->excel->getActiveSheet()->setCellValue("D6", 'Producto');
		 $this->excel->getActiveSheet()->setCellValue("D7", $dat[0]['clasificacion_producto']);	        
	     $this->excel->getActiveSheet()->setCellValue("D25", 'Autorizado:');
		 $this->excel->getActiveSheet()->setCellValue("D27", 'Firma:');
		 $this->excel->getActiveSheet()->setCellValue("D28", 'Inf. reclam                         Act. Trasl.');
		 $this->excel->getActiveSheet()->setCellValue("D29", 'Fecha:                                 Fecha:');
		 $this->excel->getActiveSheet()->setCellValue("E25", 'Recibido:');
		 $this->excel->getActiveSheet()->setCellValue("E26", $dat[0]['receptor']);
		 $this->excel->getActiveSheet()->setCellValue("E27", 'Firma:');
		 $this->excel->getActiveSheet()->setCellValue("E28", 'Recepcionado:');
		 $this->excel->getActiveSheet()->setCellValue("E29", 'Fecha:');
		 $this->excel->getActiveSheet()->setCellValue("G1", 'Código: 104.0.14051');	        
	     $this->excel->getActiveSheet()->setCellValue("G2", 'Código: 49');	        
	     $this->excel->getActiveSheet()->setCellValue("G3", 'Código: 699');	        
	     $this->excel->getActiveSheet()->setCellValue("G4", 'Código:');	        
	     $this->excel->getActiveSheet()->setCellValue("G5", 'Código:');	
         $this->excel->getActiveSheet()->setCellValue("G6", 'Centro Costo(nombre)');	        
	     $this->excel->getActiveSheet()->setCellValue("G7",  $dat[0]['nombre_centro_costo']);	        
	     $this->excel->getActiveSheet()->setCellValue("G29", $dat[0]['fecha_vale']);
		 $this->excel->getActiveSheet()->setCellValue("H5", 'Contrato No:');	        
	     $this->excel->getActiveSheet()->setCellValue("I25", 'Anotado Control Inv.');	        
	     $this->excel->getActiveSheet()->setCellValue("I27", 'Firma:');	        
	     $this->excel->getActiveSheet()->setCellValue("I28", 'Contabilizado-Firma:');	        
	     $this->excel->getActiveSheet()->setCellValue("I29", 'Fecha:');	        
	     $this->excel->getActiveSheet()->setCellValue("K25", 'Fecha:');	        
	     $this->excel->getActiveSheet()->setCellValue("J1", 'Modelo múltiple');	        
	     $this->excel->getActiveSheet()->setCellValue("J2", 'Vale medios/basico');		 
	     $this->excel->getActiveSheet()->setCellValue("J5", 'Factura No:');		 
	     $this->excel->getActiveSheet()->setCellValue("J6", 'Centro Costo(número)');		 
	     $this->excel->getActiveSheet()->setCellValue("J7", $dat[0]['no_centro_costo']);		 
	     $this->excel->getActiveSheet()->setCellValue("L1", 'Fecha');		 
	     $this->excel->getActiveSheet()->setCellValue("L2", 'A');		 
	     $this->excel->getActiveSheet()->setCellValue("L3", $dat[0]['fecha_vale']);		 
	     $this->excel->getActiveSheet()->setCellValue("L5", 'Conduce No:');		 
	     $this->excel->getActiveSheet()->setCellValue("L6", 'Bultos');		 
	     $this->excel->getActiveSheet()->setCellValue("L7", $dat[0]['bultos']);
         $this->excel->getActiveSheet()->setCellValue("L25", 'Consecutivo No.:');	        
	     $this->excel->getActiveSheet()->setCellValue("L27", 'Sol No.:');	        
	     $this->excel->getActiveSheet()->setCellValue("L28", 'Doc No.:');	        
	     $this->excel->getActiveSheet()->setCellValue("M2", 'M');		 
	     $this->excel->getActiveSheet()->setCellValue("M27", $dat[0]['no_solicitud_compra']);	        
	     $this->excel->getActiveSheet()->setCellValue("M28", $dat[0]['consecutivo']);	        
	     $this->excel->getActiveSheet()->setCellValue("N2", 'D');		 
	     $this->excel->getActiveSheet()->setCellValue("N5", $dat[0]['no_conduce']);		 
	     $this->excel->getActiveSheet()->setCellValue("L26", $dat[0]['consecutivo']);	        
	     
       //ancho de columnas.
       $this->excel->getActiveSheet()->getColumnDimension('A')->setWidth(17);
	   $this->excel->getActiveSheet()->getColumnDimension('B')->setWidth(5);
	   $this->excel->getActiveSheet()->getColumnDimension('C')->setWidth(4);
	   $this->excel->getActiveSheet()->getColumnDimension('D')->setWidth(32);
	   $this->excel->getActiveSheet()->getColumnDimension('E')->setWidth(6);
	   $this->excel->getActiveSheet()->getColumnDimension('F')->setWidth(14);
	   $this->excel->getActiveSheet()->getColumnDimension('G')->setWidth(11);
	   $this->excel->getActiveSheet()->getColumnDimension('H')->setWidth(4);
	   $this->excel->getActiveSheet()->getColumnDimension('I')->setWidth(12);
	   $this->excel->getActiveSheet()->getColumnDimension('J')->setWidth(3);
	   $this->excel->getActiveSheet()->getColumnDimension('K')->setWidth(11);
	   $this->excel->getActiveSheet()->getColumnDimension('L')->setWidth(5);
	   $this->excel->getActiveSheet()->getColumnDimension('M')->setWidth(4);
	   $this->excel->getActiveSheet()->getColumnDimension('N')->setWidth(4);
	   
	   
	  /* foreach (range('E', 'K') as $columnID) {
       //autodimensionar las columnas
       $this->excel->getActiveSheet()->getColumnDimension($columnID)->setAutoSize(true);
       }*/
	   
	  //Aplicando negrita a los títulos de la cabecera.
	   // $this->excel->getActiveSheet()->getStyle("A{$contador}:L{$contador}")->getFont()->setBold(true);
	     
	  //títulos de la cabecera.
	    $this->excel->getActiveSheet()->setCellValue("A{$contador}", 'Código');	        
	    $this->excel->getActiveSheet()->setCellValue("B{$contador}", 'Cta');
	    $this->excel->getActiveSheet()->setCellValue("C{$contador}", 'Sub-Cta');
	    $this->excel->getActiveSheet()->setCellValue("D{$contador}", 'Descripción');
	    $this->excel->getActiveSheet()->setCellValue("E{$contador}", 'UM');
	    $this->excel->getActiveSheet()->setCellValue("F{$contador}", 'Cant.');
	    $this->excel->getActiveSheet()->setCellValue("G{$contador}", 'Precio(MN)');
	    $this->excel->getActiveSheet()->setCellValue("H{$contador}", 'Prec(mlc)');
	    $this->excel->getActiveSheet()->setCellValue("I{$contador}", 'Importe(MN)');
	    $this->excel->getActiveSheet()->setCellValue("J{$contador}", 'Imp(mlc)');
	    $this->excel->getActiveSheet()->setCellValue("K{$contador}", 'Importe');
	    $this->excel->getActiveSheet()->setCellValue("L{$contador}", 'Saldo en existencia');
		
	 //Formato de celdas, alineación
	    $this->excel->getActiveSheet()->getStyle("A{$contador}:L{$contador}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->getStyle("A10:A19")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
		$this->excel->getActiveSheet()->getStyle("B10:C19")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->getStyle("E10:N21")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->getStyle("J1:N4")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->getStyle("A6:N7")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->getStyle("A21")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
		$this->excel->getActiveSheet()->getStyle("L26")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->getStyle("L3")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
		$this->excel->getActiveSheet()->getStyle("L27:N29")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
		$this->excel->getActiveSheet()->getStyle("A21:N29")->getFont()->setBold(true);
	    		 
	 //Definimos la data del cuerpo.    
 foreach($datos as $v){
         $contador++;
         $this->excel->getActiveSheet()->setCellValue("A{$contador}", $v->id_producto);
         $this->excel->getActiveSheet()->setCellValue("B{$contador}", $v->cta);
         $this->excel->getActiveSheet()->setCellValue("C{$contador}", $v->sub_cta);
         $this->excel->getActiveSheet()->setCellValue("D{$contador}", $v->nombre_producto);
         $this->excel->getActiveSheet()->setCellValue("E{$contador}", $v->unidad_medida);
         $this->excel->getActiveSheet()->setCellValue("F{$contador}", $v->cantidad);
         $this->excel->getActiveSheet()->setCellValue("G{$contador}", $v->precio_mn);
         $this->excel->getActiveSheet()->setCellValue("H{$contador}", $v->precio_mlc);
         $this->excel->getActiveSheet()->setCellValue("I{$contador}", $v->importe_mn);
         $this->excel->getActiveSheet()->setCellValue("J{$contador}", $v->importe_mlc);
         $this->excel->getActiveSheet()->setCellValue("K{$contador}", $v->importe_unitario);
         $this->excel->getActiveSheet()->setCellValue("L{$contador}", $v->resto);
         $this->excel->getActiveSheet()->getStyle("A{$contador}:N{$contador}")->getFont()->setBold(true);
	   }
		
	//rellenar con contenido
    if ($v->estado=='cancelado') {
       for ($i=$contador+1; $i<20; $i++) {
         $this->excel->getActiveSheet()->setCellValue("D{$i}", 'CANCELADO');$this->excel->getActiveSheet()->getStyle("D{$i}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
         $this->excel->getActiveSheet()->setCellValue("I{$i}", 'CANCELADO');$this->excel->getActiveSheet()->getStyle("I{$i}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
         }
    }

                      
                    		 
		 $this->excel->getActiveSheet()->setCellValue('A21', 'Importe Total de la Operación');
         $this->excel->getActiveSheet()->getStyle("F21")->getFont()->setBold(true);		 
		 $this->excel->getActiveSheet()->setCellValue('I21', '=SUM(I10:I19)');
		 $this->excel->getActiveSheet()->setCellValue('J21', '=SUM(J10:J19)');
		 $this->excel->getActiveSheet()->setCellValue('K21', '=SUM(K10:K19)');	
		 
		 $this->excel->getActiveSheet()->setCellValue('A21', 'Importe Total de la Operación');
         $this->excel->getActiveSheet()->getStyle("F21")->getFont()->setBold(true);		 
		 $this->excel->getActiveSheet()->setCellValue('I21', '=SUM(I10:I19)');
		 $this->excel->getActiveSheet()->setCellValue('J21', '=SUM(J10:J19)');
		 $this->excel->getActiveSheet()->setCellValue('K21', '=SUM(K10:K19)');

		 //Incertar imagen
      $objDrawing = new PHPExcel_Worksheet_Drawing();
				$objDrawing->setName('QR');
				$objDrawing->setDescription('QR');
				$qr = 'qr_code/'.$user.'/temp.png';
				$objDrawing->setPath($qr);
				$objDrawing->setOffsetX(8);
				$objDrawing->setOffsetY(300);
				$objDrawing->setCoordinates('I2');
				$objDrawing->setHeight(90);
				$objDrawing->setWorksheet($this->excel->getActiveSheet());

                   		 
		 //Le ponemos un nombre al archivo que se va a generar.
	        $archivo = "Vale entrega_{$dat[0]['consecutivo']}.xls";
	        header('Content-Type: application/vnd.ms-excel');
	        header('Content-Disposition: attachment;filename="'.$archivo.'"');
	        header('Cache-Control: max-age=0');
	        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
            //Hacemos una salida al navegador con el archivo Excel.
        $objWriter->save('php://output');
	} 
}
 
 public function exportar_vale_utiles(){
		$user=$this->session->userdata('useralias');
		$datos=$this->reporte->temp_vales($user)->result();
		$dat = json_decode(json_encode($datos), true);
       if(count($datos) > 0){
         $this->excel->getActiveSheet()->setTitle('Vales');
		 $this->excel->getProperties()->setCreator("Poli_system"); 
        
		//Contador de filas
        $contador = 9;
		//Configurando el documento 
		$this->excel->getDefaultStyle()->getFont()->setName("Arial")->setSize(14)->setBold();
		$this->excel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
        $this->excel->getActiveSheet()->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_LETTER);
		
		//Alto de Filas
		$this->excel->getActiveSheet()->getRowDimension(1)->setRowHeight(23);
		$this->excel->getActiveSheet()->getRowDimension(2)->setRowHeight(23);
		$this->excel->getActiveSheet()->getRowDimension(3)->setRowHeight(23);
		$this->excel->getActiveSheet()->getRowDimension(4)->setRowHeight(23);
		$this->excel->getActiveSheet()->getRowDimension(5)->setRowHeight(23);
		$this->excel->getActiveSheet()->getRowDimension(6)->setRowHeight(23);
		$this->excel->getActiveSheet()->getRowDimension(7)->setRowHeight(23);
		$this->excel->getActiveSheet()->getRowDimension(8)->setRowHeight(23);
		$this->excel->getActiveSheet()->getRowDimension(9)->setRowHeight(23);
		$this->excel->getActiveSheet()->getRowDimension(10)->setRowHeight(23);
		$this->excel->getActiveSheet()->getRowDimension(11)->setRowHeight(23);
		$this->excel->getActiveSheet()->getRowDimension(12)->setRowHeight(23);
		$this->excel->getActiveSheet()->getRowDimension(13)->setRowHeight(23);
		$this->excel->getActiveSheet()->getRowDimension(14)->setRowHeight(23);
		$this->excel->getActiveSheet()->getRowDimension(15)->setRowHeight(23);
		$this->excel->getActiveSheet()->getRowDimension(16)->setRowHeight(23);
		$this->excel->getActiveSheet()->getRowDimension(17)->setRowHeight(23);
		$this->excel->getActiveSheet()->getRowDimension(18)->setRowHeight(23);
		$this->excel->getActiveSheet()->getRowDimension(19)->setRowHeight(23);
		$this->excel->getActiveSheet()->getRowDimension(20)->setRowHeight(23);
		$this->excel->getActiveSheet()->getRowDimension(21)->setRowHeight(23);
		$this->excel->getActiveSheet()->getRowDimension(22)->setRowHeight(2);
		$this->excel->getActiveSheet()->getRowDimension(23)->setRowHeight(2);
		$this->excel->getActiveSheet()->getRowDimension(24)->setRowHeight(2);
		$this->excel->getActiveSheet()->getRowDimension(25)->setRowHeight(23);
		$this->excel->getActiveSheet()->getRowDimension(26)->setRowHeight(23);
		$this->excel->getActiveSheet()->getRowDimension(27)->setRowHeight(23);
		$this->excel->getActiveSheet()->getRowDimension(28)->setRowHeight(23);
		$this->excel->getActiveSheet()->getRowDimension(29)->setRowHeight(23);
		
		//Bordes y fuente
        $bordes = new PHPExcel_Style();
        $bordes->applyFromArray(
        array('font' => array('size' => 12, 'name' => 'Arial')
		,'borders' => array(
        'top' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
        'right' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
        'bottom' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
        'left' => array('style' => PHPExcel_Style_Border::BORDER_THIN)
        )));
        $this->excel->getActiveSheet()->setSharedStyle($bordes, "A1:N7");
        $this->excel->getActiveSheet()->setSharedStyle($bordes, "A25:N29");
       
	    $bordes3 = new PHPExcel_Style();
        $bordes3->applyFromArray(
        array('font' => array('size' => 14, 'name' => 'Arial')
		,'borders' => array(
        'top' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
        'right' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
        'bottom' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
        'left' => array('style' => PHPExcel_Style_Border::BORDER_THIN)
        )));
        $this->excel->getActiveSheet()->setSharedStyle($bordes3, "M27:N28");
        $this->excel->getActiveSheet()->setSharedStyle($bordes3, "L26");
		
        //establecer margenes
         $margin = 0.5 / 2.54; // 0.5 centimetros
         $margin2 = 0.8 / 2.54; // 0.5 centimetros
         $marginBottom = 2.5 / 2.54; //1.2 centimetros
         $this->excel->getActiveSheet()->getPageMargins()->setTop($marginBottom);
         $this->excel->getActiveSheet()->getPageMargins()->setBottom($marginBottom);
         $this->excel->getActiveSheet()->getPageMargins()->setLeft($margin);
         $this->excel->getActiveSheet()->getPageMargins()->setRight($margin2);
        
		//establecer impresion a pagina completa
         $this->excel->getActiveSheet()->getPageSetup()->setFitToPage(true);
         $this->excel->getActiveSheet()->getPageSetup()->setFitToWidth(1);
         $this->excel->getActiveSheet()->getPageSetup()->setFitToHeight(0);
         
		//Proteger datos
		$this->excel->getActiveSheet()->getProtection()->setPassword('PassPoli,Sistema');
        $this->excel->getActiveSheet()->getProtection()->setSheet(true); 
        $this->excel->getActiveSheet()->getProtection()->setSort(true);
        $this->excel->getActiveSheet()->getProtection()->setInsertRows(true);
        $this->excel->getActiveSheet()->getProtection()->setFormatCells(true);
        
		//Agrupar celdas
		 $this->excel->getActiveSheet()->mergeCells('A1:F1');$this->excel->getActiveSheet()->mergeCells('G1:I1');$this->excel->getActiveSheet()->mergeCells('J1:K1');$this->excel->getActiveSheet()->mergeCells('L1:N1');
		 $this->excel->getActiveSheet()->mergeCells('A2:F2');$this->excel->getActiveSheet()->mergeCells('G2:I2');$this->excel->getActiveSheet()->mergeCells('J2:K4');
		 $this->excel->getActiveSheet()->mergeCells('A3:F3');$this->excel->getActiveSheet()->mergeCells('G3:I3');$this->excel->getActiveSheet()->mergeCells('L3:N4');
		 $this->excel->getActiveSheet()->mergeCells('A4:F4');$this->excel->getActiveSheet()->mergeCells('G4:I4');
		 $this->excel->getActiveSheet()->mergeCells('A5:F5');$this->excel->getActiveSheet()->mergeCells('H5:I5');$this->excel->getActiveSheet()->mergeCells('J5:K5');$this->excel->getActiveSheet()->mergeCells('L5:M5');
		 $this->excel->getActiveSheet()->mergeCells('A6:C6');$this->excel->getActiveSheet()->mergeCells('D6:F6');$this->excel->getActiveSheet()->mergeCells('G6:I6');$this->excel->getActiveSheet()->mergeCells('J6:K6');$this->excel->getActiveSheet()->mergeCells('L6:N6');
		 $this->excel->getActiveSheet()->mergeCells('A7:C7');$this->excel->getActiveSheet()->mergeCells('D7:F7');$this->excel->getActiveSheet()->mergeCells('G7:I7');$this->excel->getActiveSheet()->mergeCells('J7:K7');$this->excel->getActiveSheet()->mergeCells('L7:N7');
		 $this->excel->getActiveSheet()->mergeCells('A8:N8');$this->excel->getActiveSheet()->mergeCells('A21:H21');$this->excel->getActiveSheet()->mergeCells('A20:N20');
		 $this->excel->getActiveSheet()->mergeCells('L9:N9');$this->excel->getActiveSheet()->mergeCells('L10:N10');$this->excel->getActiveSheet()->mergeCells('L11:N11');$this->excel->getActiveSheet()->mergeCells('L12:N12');$this->excel->getActiveSheet()->mergeCells('L13:N13');$this->excel->getActiveSheet()->mergeCells('L14:N14');
         $this->excel->getActiveSheet()->mergeCells('L15:N15');$this->excel->getActiveSheet()->mergeCells('L16:N16');$this->excel->getActiveSheet()->mergeCells('L17:N17');$this->excel->getActiveSheet()->mergeCells('L18:N18');$this->excel->getActiveSheet()->mergeCells('L19:N19');		 
		 $this->excel->getActiveSheet()->mergeCells('A22:N24');$this->excel->getActiveSheet()->mergeCells('L21:N21');
		 $this->excel->getActiveSheet()->mergeCells('A25:C25');$this->excel->getActiveSheet()->mergeCells('E25:H25');$this->excel->getActiveSheet()->mergeCells('I25:J25');$this->excel->getActiveSheet()->mergeCells('L25:N25');
		 $this->excel->getActiveSheet()->mergeCells('A26:C26');$this->excel->getActiveSheet()->mergeCells('E26:H26');$this->excel->getActiveSheet()->mergeCells('I26:K26');$this->excel->getActiveSheet()->mergeCells('L26:N26');
		 $this->excel->getActiveSheet()->mergeCells('A27:C27');$this->excel->getActiveSheet()->mergeCells('E27:H27');$this->excel->getActiveSheet()->mergeCells('I27:K27');$this->excel->getActiveSheet()->mergeCells('M27:N27');
		 $this->excel->getActiveSheet()->mergeCells('A28:C28');$this->excel->getActiveSheet()->mergeCells('E28:H28');$this->excel->getActiveSheet()->mergeCells('I28:K28');$this->excel->getActiveSheet()->mergeCells('M28:N28');
		 $this->excel->getActiveSheet()->mergeCells('B29:C29');$this->excel->getActiveSheet()->mergeCells('E29:F29');$this->excel->getActiveSheet()->mergeCells('G29:H29');$this->excel->getActiveSheet()->mergeCells('I29:K29');$this->excel->getActiveSheet()->mergeCells('L29:N29');
		 
		//Insertar valores
		 $this->excel->getActiveSheet()->setCellValue("A1", 'Entidad: ENSAL');	        
	     $this->excel->getActiveSheet()->setCellValue("A2", 'Unidad: UEB Salina Joa');	        
	     $this->excel->getActiveSheet()->setCellValue("A3", 'Entidad o almacén que entrega: Materiales');	        
	     $this->excel->getActiveSheet()->setCellValue("A4", 'Entidad o almacén que recibe:');	        
	     $this->excel->getActiveSheet()->setCellValue("A5", 'Entidad suministradora(nombre-dirección)');	        
	     $this->excel->getActiveSheet()->setCellValue("A6", 'Orden de trabajo');	        
	     $this->excel->getActiveSheet()->setCellValue("A7", $dat[0]['id_orden']);	        
	     $this->excel->getActiveSheet()->setCellValue("A20", 'Responsable:');	        
	     $this->excel->getActiveSheet()->setCellValue("A25", 'Despachado o Confeccionado:');	        
	     $this->excel->getActiveSheet()->setCellValue("A26", $dat[0]['despachador']);	        
	     $this->excel->getActiveSheet()->setCellValue("A27", 'Firma:');	        
	     $this->excel->getActiveSheet()->setCellValue("A28", 'Jefe-Almacén:');	        
	     $this->excel->getActiveSheet()->setCellValue("A29", 'Fecha:');	        
	     $this->excel->getActiveSheet()->setCellValue("B29", $dat[0]['fecha_vale']);	        
	     $this->excel->getActiveSheet()->setCellValue("D6", 'Producto');
		 $this->excel->getActiveSheet()->setCellValue("D7", 'Útiles y Herramientas');	        
	     $this->excel->getActiveSheet()->setCellValue("D25", 'Autorizado:');
		 $this->excel->getActiveSheet()->setCellValue("D27", 'Firma:');
		 $this->excel->getActiveSheet()->setCellValue("D28", 'Inf. reclam                         Act. Trasl.');
		 $this->excel->getActiveSheet()->setCellValue("D29", 'Fecha:                                 Fecha:');
		 $this->excel->getActiveSheet()->setCellValue("E25", 'Recibido:');
		 $this->excel->getActiveSheet()->setCellValue("E26", $dat[0]['receptor']);
		 $this->excel->getActiveSheet()->setCellValue("E27", 'Firma:');
		 $this->excel->getActiveSheet()->setCellValue("E28", 'Recepcionado:');
		 $this->excel->getActiveSheet()->setCellValue("E29", 'Fecha:');
		 $this->excel->getActiveSheet()->setCellValue("G1", 'Código: 104.0.14051');	        
	     $this->excel->getActiveSheet()->setCellValue("G2", 'Código: 49');	        
	     $this->excel->getActiveSheet()->setCellValue("G3", 'Código: 699');	        
	     $this->excel->getActiveSheet()->setCellValue("G4", 'Código:');	        
	     $this->excel->getActiveSheet()->setCellValue("G5", 'Código:');	
         $this->excel->getActiveSheet()->setCellValue("G6", 'Centro Costo(nombre)');	        
	     $this->excel->getActiveSheet()->setCellValue("G7",  $dat[0]['nombre_centro_costo']);	        
	     $this->excel->getActiveSheet()->setCellValue("G29", $dat[0]['fecha_vale']);
		 $this->excel->getActiveSheet()->setCellValue("H5", 'Contrato No:');	        
	     $this->excel->getActiveSheet()->setCellValue("I25", 'Anotado Control Inv.');	        
	     $this->excel->getActiveSheet()->setCellValue("I27", 'Firma:');	        
	     $this->excel->getActiveSheet()->setCellValue("I28", 'Contabilizado-Firma:');	        
	     $this->excel->getActiveSheet()->setCellValue("I29", 'Fecha:');	        
	     $this->excel->getActiveSheet()->setCellValue("K25", 'Fecha:');	        
	     $this->excel->getActiveSheet()->setCellValue("J1", 'Modelo múltiple');	        
	     $this->excel->getActiveSheet()->setCellValue("J2", 'Vale de utiles');		 
	     $this->excel->getActiveSheet()->setCellValue("J5", 'Factura No:');		 
	     $this->excel->getActiveSheet()->setCellValue("J6", 'Centro Costo(número)');		 
	     $this->excel->getActiveSheet()->setCellValue("J7", $dat[0]['no_centro_costo']);		 
	     $this->excel->getActiveSheet()->setCellValue("L1", 'Fecha');		 
	     $this->excel->getActiveSheet()->setCellValue("L2", 'A');		 
	     $this->excel->getActiveSheet()->setCellValue("L3", $dat[0]['fecha_vale']);		 
	     $this->excel->getActiveSheet()->setCellValue("L5", 'Conduce No:');		 
	     $this->excel->getActiveSheet()->setCellValue("L6", 'Bultos');		 
	     $this->excel->getActiveSheet()->setCellValue("L7", $dat[0]['bultos']);
         $this->excel->getActiveSheet()->setCellValue("L25", 'Consecutivo No.:');	        
	     $this->excel->getActiveSheet()->setCellValue("L27", 'Sol No.:');	        
	     $this->excel->getActiveSheet()->setCellValue("L28", 'Doc No.:');	        
	     $this->excel->getActiveSheet()->setCellValue("M2", 'M');		 
	     $this->excel->getActiveSheet()->setCellValue("M27", $dat[0]['no_solicitud_compra']);	        
	     $this->excel->getActiveSheet()->setCellValue("M28", $dat[0]['consecutivo']);	        
	     $this->excel->getActiveSheet()->setCellValue("N2", 'D');		 
	     $this->excel->getActiveSheet()->setCellValue("N5", $dat[0]['no_conduce']);		 
	     $this->excel->getActiveSheet()->setCellValue("L26", $dat[0]['consecutivo']);	        
	     
       //ancho de columnas.
       $this->excel->getActiveSheet()->getColumnDimension('A')->setWidth(17);
	   $this->excel->getActiveSheet()->getColumnDimension('B')->setWidth(5);
	   $this->excel->getActiveSheet()->getColumnDimension('C')->setWidth(4);
	   $this->excel->getActiveSheet()->getColumnDimension('D')->setWidth(32);
	   $this->excel->getActiveSheet()->getColumnDimension('E')->setWidth(6);
	   $this->excel->getActiveSheet()->getColumnDimension('F')->setWidth(14);
	   $this->excel->getActiveSheet()->getColumnDimension('G')->setWidth(11);
	   $this->excel->getActiveSheet()->getColumnDimension('H')->setWidth(4);
	   $this->excel->getActiveSheet()->getColumnDimension('I')->setWidth(12);
	   $this->excel->getActiveSheet()->getColumnDimension('J')->setWidth(3);
	   $this->excel->getActiveSheet()->getColumnDimension('K')->setWidth(11);
	   $this->excel->getActiveSheet()->getColumnDimension('L')->setWidth(5);
	   $this->excel->getActiveSheet()->getColumnDimension('M')->setWidth(4);
	   $this->excel->getActiveSheet()->getColumnDimension('N')->setWidth(4);
	   
	   
	  /* foreach (range('E', 'K') as $columnID) {
       //autodimensionar las columnas
       $this->excel->getActiveSheet()->getColumnDimension($columnID)->setAutoSize(true);
       }*/
	   
	  //Aplicando negrita a los títulos de la cabecera.
	   // $this->excel->getActiveSheet()->getStyle("A{$contador}:L{$contador}")->getFont()->setBold(true);
	     
	  //títulos de la cabecera.
	    $this->excel->getActiveSheet()->setCellValue("A{$contador}", 'Código');	        
	    $this->excel->getActiveSheet()->setCellValue("B{$contador}", 'Cta');
	    $this->excel->getActiveSheet()->setCellValue("C{$contador}", 'Sub-Cta');
	    $this->excel->getActiveSheet()->setCellValue("D{$contador}", 'Descripción');
	    $this->excel->getActiveSheet()->setCellValue("E{$contador}", 'UM');
	    $this->excel->getActiveSheet()->setCellValue("F{$contador}", 'Cant.');
	    $this->excel->getActiveSheet()->setCellValue("G{$contador}", 'Precio(MN)');
	    $this->excel->getActiveSheet()->setCellValue("H{$contador}", 'Prec(mlc)');
	    $this->excel->getActiveSheet()->setCellValue("I{$contador}", 'Importe(MN)');
	    $this->excel->getActiveSheet()->setCellValue("J{$contador}", 'Imp(mlc)');
	    $this->excel->getActiveSheet()->setCellValue("K{$contador}", 'Importe');
	    $this->excel->getActiveSheet()->setCellValue("L{$contador}", 'Saldo en existencia');
		
	 //Formato de celdas, alineación
	    $this->excel->getActiveSheet()->getStyle("A{$contador}:L{$contador}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->getStyle("A10:A19")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
		$this->excel->getActiveSheet()->getStyle("B10:C19")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->getStyle("E10:N21")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->getStyle("J1:N4")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->getStyle("A6:N7")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->getStyle("A21")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
		$this->excel->getActiveSheet()->getStyle("L26")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->getStyle("L27:N29")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
		$this->excel->getActiveSheet()->getStyle("A21:N29")->getFont()->setBold(true);
	    		 
	 //Definimos la data del cuerpo.    
 foreach($datos as $v){
         $contador++;
         $this->excel->getActiveSheet()->setCellValue("A{$contador}", $v->id_producto);
         $this->excel->getActiveSheet()->setCellValue("B{$contador}", $v->cta);
         $this->excel->getActiveSheet()->setCellValue("C{$contador}", $v->sub_cta);
         $this->excel->getActiveSheet()->setCellValue("D{$contador}", $v->nombre_producto);
         $this->excel->getActiveSheet()->setCellValue("E{$contador}", $v->unidad_medida);
         $this->excel->getActiveSheet()->setCellValue("F{$contador}", $v->cantidad);
         $this->excel->getActiveSheet()->setCellValue("G{$contador}", $v->precio_mn);
         $this->excel->getActiveSheet()->setCellValue("H{$contador}", $v->precio_mlc);
         $this->excel->getActiveSheet()->setCellValue("I{$contador}", $v->importe_mn);
         $this->excel->getActiveSheet()->setCellValue("J{$contador}", $v->importe_mlc);
         $this->excel->getActiveSheet()->setCellValue("K{$contador}", $v->importe_unitario);
         $this->excel->getActiveSheet()->setCellValue("L{$contador}", $v->resto);
         $this->excel->getActiveSheet()->getStyle("A{$contador}:N{$contador}")->getFont()->setBold(true);
	   }
		
	//rellenar con contenido
    if ($v->estado=='cancelado') {
       for ($i=$contador+1; $i<20; $i++) {
         $this->excel->getActiveSheet()->setCellValue("D{$i}", 'CANCELADO');$this->excel->getActiveSheet()->getStyle("D{$i}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
         $this->excel->getActiveSheet()->setCellValue("I{$i}", 'CANCELADO');$this->excel->getActiveSheet()->getStyle("I{$i}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
         }
    }
		
		 $this->excel->getActiveSheet()->setCellValue('A21', 'Importe Total de la Operación');
         $this->excel->getActiveSheet()->getStyle("F21")->getFont()->setBold(true);		 
		 $this->excel->getActiveSheet()->setCellValue('I21', '=SUM(I10:I19)');
		 $this->excel->getActiveSheet()->setCellValue('J21', '=SUM(J10:J19)');
		 $this->excel->getActiveSheet()->setCellValue('K21', '=SUM(K10:K19)');
		 
		 //Le ponemos un nombre al archivo que se va a generar.
	        $archivo = "Vale utiles_{$dat[0]['consecutivo']}.xls";
	        header('Content-Type: application/vnd.ms-excel');
	        header('Content-Disposition: attachment;filename="'.$archivo.'"');
	        header('Cache-Control: max-age=0');
	        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
            //Hacemos una salida al navegador con el archivo Excel.
        $objWriter->save('php://output');
	} 
}

public function exportar_vale_devolucion(){
		$user=$this->session->userdata('useralias');
		$datos=$this->reporte->temp_vales($user)->result();
		$dat = json_decode(json_encode($datos), true);
       if(count($datos) > 0){
         $this->excel->getActiveSheet()->setTitle('Vales');
		 $this->excel->getProperties()->setCreator("Poli_system"); 
        
		//Contador de filas
        $contador = 9;
		//Configurando el documento 
		$this->excel->getDefaultStyle()->getFont()->setName("Arial")->setSize(14)->setBold();
		$this->excel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
        $this->excel->getActiveSheet()->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_LETTER);
		
		//Alto de Filas
		$this->excel->getActiveSheet()->getRowDimension(1)->setRowHeight(23);
		$this->excel->getActiveSheet()->getRowDimension(2)->setRowHeight(23);
		$this->excel->getActiveSheet()->getRowDimension(3)->setRowHeight(23);
		$this->excel->getActiveSheet()->getRowDimension(4)->setRowHeight(23);
		$this->excel->getActiveSheet()->getRowDimension(5)->setRowHeight(23);
		$this->excel->getActiveSheet()->getRowDimension(6)->setRowHeight(23);
		$this->excel->getActiveSheet()->getRowDimension(7)->setRowHeight(23);
		$this->excel->getActiveSheet()->getRowDimension(8)->setRowHeight(23);
		$this->excel->getActiveSheet()->getRowDimension(9)->setRowHeight(23);
		$this->excel->getActiveSheet()->getRowDimension(10)->setRowHeight(23);
		$this->excel->getActiveSheet()->getRowDimension(11)->setRowHeight(23);
		$this->excel->getActiveSheet()->getRowDimension(12)->setRowHeight(23);
		$this->excel->getActiveSheet()->getRowDimension(13)->setRowHeight(23);
		$this->excel->getActiveSheet()->getRowDimension(14)->setRowHeight(23);
		$this->excel->getActiveSheet()->getRowDimension(15)->setRowHeight(23);
		$this->excel->getActiveSheet()->getRowDimension(16)->setRowHeight(23);
		$this->excel->getActiveSheet()->getRowDimension(17)->setRowHeight(23);
		$this->excel->getActiveSheet()->getRowDimension(18)->setRowHeight(23);
		$this->excel->getActiveSheet()->getRowDimension(19)->setRowHeight(23);
		$this->excel->getActiveSheet()->getRowDimension(20)->setRowHeight(23);
		$this->excel->getActiveSheet()->getRowDimension(21)->setRowHeight(23);
		$this->excel->getActiveSheet()->getRowDimension(22)->setRowHeight(2);
		$this->excel->getActiveSheet()->getRowDimension(23)->setRowHeight(2);
		$this->excel->getActiveSheet()->getRowDimension(24)->setRowHeight(2);
		$this->excel->getActiveSheet()->getRowDimension(25)->setRowHeight(23);
		$this->excel->getActiveSheet()->getRowDimension(26)->setRowHeight(23);
		$this->excel->getActiveSheet()->getRowDimension(27)->setRowHeight(23);
		$this->excel->getActiveSheet()->getRowDimension(28)->setRowHeight(23);
		$this->excel->getActiveSheet()->getRowDimension(29)->setRowHeight(23);
		
		//Bordes y fuente
        $bordes = new PHPExcel_Style();
        $bordes->applyFromArray(
        array('font' => array('size' => 12, 'name' => 'Arial')
		,'borders' => array(
        'top' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
        'right' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
        'bottom' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
        'left' => array('style' => PHPExcel_Style_Border::BORDER_THIN)
        )));
        $this->excel->getActiveSheet()->setSharedStyle($bordes, "A1:N7");
        $this->excel->getActiveSheet()->setSharedStyle($bordes, "A25:N29");
       
	   $bordes3 = new PHPExcel_Style();
        $bordes3->applyFromArray(
        array('font' => array('size' => 14, 'name' => 'Arial')
		,'borders' => array(
        'top' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
        'right' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
        'bottom' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
        'left' => array('style' => PHPExcel_Style_Border::BORDER_THIN)
        )));
        $this->excel->getActiveSheet()->setSharedStyle($bordes3, "M27:N28");
        $this->excel->getActiveSheet()->setSharedStyle($bordes3, "L26");
		
        //establecer margenes
         $margin = 0.5 / 2.54; // 0.5 centimetros
         $margin2 = 0.8 / 2.54; // 0.5 centimetros
         $marginBottom = 2.5 / 2.54; //1.2 centimetros
         $this->excel->getActiveSheet()->getPageMargins()->setTop($marginBottom);
         $this->excel->getActiveSheet()->getPageMargins()->setBottom($marginBottom);
         $this->excel->getActiveSheet()->getPageMargins()->setLeft($margin);
         $this->excel->getActiveSheet()->getPageMargins()->setRight($margin2);
        
		//establecer impresion a pagina completa
         $this->excel->getActiveSheet()->getPageSetup()->setFitToPage(true);
         $this->excel->getActiveSheet()->getPageSetup()->setFitToWidth(1);
         $this->excel->getActiveSheet()->getPageSetup()->setFitToHeight(0);
         
		//Proteger datos
		$this->excel->getActiveSheet()->getProtection()->setPassword('PassPoli,Sistema');
        $this->excel->getActiveSheet()->getProtection()->setSheet(true); 
        $this->excel->getActiveSheet()->getProtection()->setSort(true);
        $this->excel->getActiveSheet()->getProtection()->setInsertRows(true);
        $this->excel->getActiveSheet()->getProtection()->setFormatCells(true);
        
		//Agrupar celdas
		 $this->excel->getActiveSheet()->mergeCells('A1:F1');$this->excel->getActiveSheet()->mergeCells('G1:I1');$this->excel->getActiveSheet()->mergeCells('J1:K1');$this->excel->getActiveSheet()->mergeCells('L1:N1');
		 $this->excel->getActiveSheet()->mergeCells('A2:F2');$this->excel->getActiveSheet()->mergeCells('G2:I2');$this->excel->getActiveSheet()->mergeCells('J2:K4');
		 $this->excel->getActiveSheet()->mergeCells('A3:F3');$this->excel->getActiveSheet()->mergeCells('G3:I3');$this->excel->getActiveSheet()->mergeCells('L3:N4');
		 $this->excel->getActiveSheet()->mergeCells('A4:F4');$this->excel->getActiveSheet()->mergeCells('G4:I4');
		 $this->excel->getActiveSheet()->mergeCells('A5:F5');$this->excel->getActiveSheet()->mergeCells('H5:I5');$this->excel->getActiveSheet()->mergeCells('J5:K5');$this->excel->getActiveSheet()->mergeCells('L5:M5');
		 $this->excel->getActiveSheet()->mergeCells('A6:C6');$this->excel->getActiveSheet()->mergeCells('D6:F6');$this->excel->getActiveSheet()->mergeCells('G6:I6');$this->excel->getActiveSheet()->mergeCells('J6:K6');$this->excel->getActiveSheet()->mergeCells('L6:N6');
		 $this->excel->getActiveSheet()->mergeCells('A7:C7');$this->excel->getActiveSheet()->mergeCells('D7:F7');$this->excel->getActiveSheet()->mergeCells('G7:I7');$this->excel->getActiveSheet()->mergeCells('J7:K7');$this->excel->getActiveSheet()->mergeCells('L7:N7');
		 $this->excel->getActiveSheet()->mergeCells('A8:E8');$this->excel->getActiveSheet()->mergeCells('F8:N8');$this->excel->getActiveSheet()->mergeCells('A21:H21');$this->excel->getActiveSheet()->mergeCells('A20:N20');
		 $this->excel->getActiveSheet()->mergeCells('L9:N9');$this->excel->getActiveSheet()->mergeCells('L10:N10');$this->excel->getActiveSheet()->mergeCells('L11:N11');$this->excel->getActiveSheet()->mergeCells('L12:N12');$this->excel->getActiveSheet()->mergeCells('L13:N13');$this->excel->getActiveSheet()->mergeCells('L14:N14');
         $this->excel->getActiveSheet()->mergeCells('L15:N15');$this->excel->getActiveSheet()->mergeCells('L16:N16');$this->excel->getActiveSheet()->mergeCells('L17:N17');$this->excel->getActiveSheet()->mergeCells('L18:N18');$this->excel->getActiveSheet()->mergeCells('L19:N19');		 
		 $this->excel->getActiveSheet()->mergeCells('A22:N24');$this->excel->getActiveSheet()->mergeCells('L21:N21');
		 $this->excel->getActiveSheet()->mergeCells('A25:C25');$this->excel->getActiveSheet()->mergeCells('E25:H25');$this->excel->getActiveSheet()->mergeCells('I25:J25');$this->excel->getActiveSheet()->mergeCells('L25:N25');
		 $this->excel->getActiveSheet()->mergeCells('A26:C26');$this->excel->getActiveSheet()->mergeCells('E26:H26');$this->excel->getActiveSheet()->mergeCells('I26:K26');$this->excel->getActiveSheet()->mergeCells('L26:N26');
		 $this->excel->getActiveSheet()->mergeCells('A27:C27');$this->excel->getActiveSheet()->mergeCells('E27:H27');$this->excel->getActiveSheet()->mergeCells('I27:K27');$this->excel->getActiveSheet()->mergeCells('M27:N27');
		 $this->excel->getActiveSheet()->mergeCells('A28:C28');$this->excel->getActiveSheet()->mergeCells('E28:H28');$this->excel->getActiveSheet()->mergeCells('I28:K28');$this->excel->getActiveSheet()->mergeCells('M28:N28');
		 $this->excel->getActiveSheet()->mergeCells('B29:C29');$this->excel->getActiveSheet()->mergeCells('E29:F29');$this->excel->getActiveSheet()->mergeCells('G29:H29');$this->excel->getActiveSheet()->mergeCells('I29:K29');$this->excel->getActiveSheet()->mergeCells('L29:N29');
		 
		//Insertar valores
		 $this->excel->getActiveSheet()->setCellValue("A1", 'Entidad: ENSAL');	        
	     $this->excel->getActiveSheet()->setCellValue("A2", 'Unidad: UEB Salina Joa');	        
	     $this->excel->getActiveSheet()->setCellValue("A3", 'Entidad o almacén que entrega: Materiales');	        
	     $this->excel->getActiveSheet()->setCellValue("A4", 'Entidad o almacén que recibe:');	        
	     $this->excel->getActiveSheet()->setCellValue("A5", 'Entidad suministradora(nombre-dirección)');	        
	     $this->excel->getActiveSheet()->setCellValue("A6", 'Orden de trabajo');	        
	     $this->excel->getActiveSheet()->setCellValue("A7", $dat[0]['id_orden']);	        
	     $this->excel->getActiveSheet()->setCellValue("A8", 'VR:');	        
	     $this->excel->getActiveSheet()->setCellValue("A25", 'Despachado o Confeccionado:');	        
	     $this->excel->getActiveSheet()->setCellValue("A26", $dat[0]['despachador']);	        
	     $this->excel->getActiveSheet()->setCellValue("A27", 'Firma:');	        
	     $this->excel->getActiveSheet()->setCellValue("A28", 'Jefe-Almacén:');	        
	     $this->excel->getActiveSheet()->setCellValue("A29", 'Fecha:');	        
	     $this->excel->getActiveSheet()->setCellValue("B29", $dat[0]['fecha_vale']);	        
	     $this->excel->getActiveSheet()->setCellValue("D6", 'Producto');
		 $this->excel->getActiveSheet()->setCellValue("D7", $dat[0]['clasificacion_producto']);	        
	     $this->excel->getActiveSheet()->setCellValue("D25", 'Autorizado:');
		 $this->excel->getActiveSheet()->setCellValue("D27", 'Firma:');
		 $this->excel->getActiveSheet()->setCellValue("D28", 'Inf. reclam                         Act. Trasl.');
		 $this->excel->getActiveSheet()->setCellValue("D29", 'Fecha:                                 Fecha:');
		 $this->excel->getActiveSheet()->setCellValue("E25", 'Recibido:');
		 $this->excel->getActiveSheet()->setCellValue("E26", $dat[0]['receptor']);
		 $this->excel->getActiveSheet()->setCellValue("E27", 'Firma:');
		 $this->excel->getActiveSheet()->setCellValue("E28", 'Recepcionado:');
		 $this->excel->getActiveSheet()->setCellValue("E29", 'Fecha:');
		 $this->excel->getActiveSheet()->setCellValue("F8", $dat[0]['vale_referencia']);	        
	     $this->excel->getActiveSheet()->setCellValue("G1", 'Código: 104.0.14051');	        
	     $this->excel->getActiveSheet()->setCellValue("G2", 'Código: 49');	        
	     $this->excel->getActiveSheet()->setCellValue("G3", 'Código: 699');	        
	     $this->excel->getActiveSheet()->setCellValue("G4", 'Código:');	        
	     $this->excel->getActiveSheet()->setCellValue("G5", 'Código:');	
         $this->excel->getActiveSheet()->setCellValue("G6", 'Centro Costo(nombre)');	        
	     $this->excel->getActiveSheet()->setCellValue("G7",  $dat[0]['nombre_centro_costo']);	        
	     $this->excel->getActiveSheet()->setCellValue("G29", $dat[0]['fecha_vale']);
		 $this->excel->getActiveSheet()->setCellValue("H5", 'Contrato No:');	        
	     $this->excel->getActiveSheet()->setCellValue("I25", 'Anotado Control Inv.');	        
	     $this->excel->getActiveSheet()->setCellValue("I27", 'Firma:');	        
	     $this->excel->getActiveSheet()->setCellValue("I28", 'Contabilizado-Firma:');	        
	     $this->excel->getActiveSheet()->setCellValue("I29", 'Fecha:');	        
	     $this->excel->getActiveSheet()->setCellValue("K25", 'Fecha:');	        
	     $this->excel->getActiveSheet()->setCellValue("J1", 'Modelo múltiple');	        
	     $this->excel->getActiveSheet()->setCellValue("J2", 'Vale de devolución');		 
	     $this->excel->getActiveSheet()->setCellValue("J5", 'Factura No:');		 
	     $this->excel->getActiveSheet()->setCellValue("J6", 'Centro Costo(número)');		 
	     $this->excel->getActiveSheet()->setCellValue("J7", $dat[0]['no_centro_costo']);		 
	     $this->excel->getActiveSheet()->setCellValue("L1", 'Fecha');		 
	     $this->excel->getActiveSheet()->setCellValue("L2", 'A');		 
	     $this->excel->getActiveSheet()->setCellValue("L3", $dat[0]['fecha_vale']);		 
	     $this->excel->getActiveSheet()->setCellValue("L5", 'Conduce No:');		 
	     $this->excel->getActiveSheet()->setCellValue("L6", 'Bultos');		 
	     $this->excel->getActiveSheet()->setCellValue("L7", $dat[0]['bultos']);
         $this->excel->getActiveSheet()->setCellValue("L25", 'Consecutivo No.:');	        
	     $this->excel->getActiveSheet()->setCellValue("L27", 'Sol No.:');	        
	     $this->excel->getActiveSheet()->setCellValue("L28", 'Doc No.:');	        
	     $this->excel->getActiveSheet()->setCellValue("M2", 'M');		 
	     $this->excel->getActiveSheet()->setCellValue("M27", $dat[0]['no_solicitud_compra']);	        
	     $this->excel->getActiveSheet()->setCellValue("M28", $dat[0]['consecutivo']);	        
	     $this->excel->getActiveSheet()->setCellValue("N2", 'D');		 
	     $this->excel->getActiveSheet()->setCellValue("N5", $dat[0]['no_conduce']);		 
	     $this->excel->getActiveSheet()->setCellValue("L26", $dat[0]['consecutivo']);	        
	     
       //ancho de columnas.
       $this->excel->getActiveSheet()->getColumnDimension('A')->setWidth(17);
	   $this->excel->getActiveSheet()->getColumnDimension('B')->setWidth(5);
	   $this->excel->getActiveSheet()->getColumnDimension('C')->setWidth(4);
	   $this->excel->getActiveSheet()->getColumnDimension('D')->setWidth(32);
	   $this->excel->getActiveSheet()->getColumnDimension('E')->setWidth(6);
	   $this->excel->getActiveSheet()->getColumnDimension('F')->setWidth(14);
	   $this->excel->getActiveSheet()->getColumnDimension('G')->setWidth(11);
	   $this->excel->getActiveSheet()->getColumnDimension('H')->setWidth(4);
	   $this->excel->getActiveSheet()->getColumnDimension('I')->setWidth(12);
	   $this->excel->getActiveSheet()->getColumnDimension('J')->setWidth(3);
	   $this->excel->getActiveSheet()->getColumnDimension('K')->setWidth(11);
	   $this->excel->getActiveSheet()->getColumnDimension('L')->setWidth(5);
	   $this->excel->getActiveSheet()->getColumnDimension('M')->setWidth(4);
	   $this->excel->getActiveSheet()->getColumnDimension('N')->setWidth(4);
	   
	     
	  //títulos de la cabecera.
	    $this->excel->getActiveSheet()->setCellValue("A{$contador}", 'Código');	        
	    $this->excel->getActiveSheet()->setCellValue("B{$contador}", 'Cta');
	    $this->excel->getActiveSheet()->setCellValue("C{$contador}", 'Sub-Cta');
	    $this->excel->getActiveSheet()->setCellValue("D{$contador}", 'Descripción');
	    $this->excel->getActiveSheet()->setCellValue("E{$contador}", 'UM');
	    $this->excel->getActiveSheet()->setCellValue("F{$contador}", 'Cant.');
	    $this->excel->getActiveSheet()->setCellValue("G{$contador}", 'Precio(MN)');
	    $this->excel->getActiveSheet()->setCellValue("H{$contador}", 'Prec(mlc)');
	    $this->excel->getActiveSheet()->setCellValue("I{$contador}", 'Importe(MN)');
	    $this->excel->getActiveSheet()->setCellValue("J{$contador}", 'Imp(mlc)');
	    $this->excel->getActiveSheet()->setCellValue("K{$contador}", 'Importe');
	    $this->excel->getActiveSheet()->setCellValue("L{$contador}", 'Saldo en existencia');
		
	 //Formato de celdas, alineación
	    $this->excel->getActiveSheet()->getStyle("A{$contador}:L{$contador}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->getStyle("A8")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
		$this->excel->getActiveSheet()->getStyle("A10:A19")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
		$this->excel->getActiveSheet()->getStyle("B10:C19")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->getStyle("E10:N21")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->getStyle("f8")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
		$this->excel->getActiveSheet()->getStyle("J1:N4")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->getStyle("A6:N7")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->getStyle("A21")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
		$this->excel->getActiveSheet()->getStyle("L26")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->getStyle("L27:N29")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
		$this->excel->getActiveSheet()->getStyle("A21:N29")->getFont()->setBold(true);
	    		 
	 //Definimos la data del cuerpo.    
 foreach($datos as $v){
         $contador++;
         $this->excel->getActiveSheet()->setCellValue("A{$contador}", $v->id_producto);
         $this->excel->getActiveSheet()->setCellValue("B{$contador}", $v->cta);
         $this->excel->getActiveSheet()->setCellValue("C{$contador}", $v->sub_cta);
         $this->excel->getActiveSheet()->setCellValue("D{$contador}", $v->nombre_producto);
         $this->excel->getActiveSheet()->setCellValue("E{$contador}", $v->unidad_medida);
         $this->excel->getActiveSheet()->setCellValue("F{$contador}", $v->cantidad);
         $this->excel->getActiveSheet()->setCellValue("G{$contador}", $v->precio_mn);
         $this->excel->getActiveSheet()->setCellValue("H{$contador}", $v->precio_mlc);
         $this->excel->getActiveSheet()->setCellValue("I{$contador}", $v->importe_mn);
         $this->excel->getActiveSheet()->setCellValue("J{$contador}", $v->importe_mlc);
         $this->excel->getActiveSheet()->setCellValue("K{$contador}", $v->importe_unitario);
         $this->excel->getActiveSheet()->setCellValue("L{$contador}", $v->resto);
         $this->excel->getActiveSheet()->getStyle("A{$contador}:N{$contador}")->getFont()->setBold(true);
	   }
		
		//rellenar con contenido
    if ($v->estado=='cancelado') {
       for ($i=$contador+1; $i<20; $i++) {
         $this->excel->getActiveSheet()->setCellValue("D{$i}", 'CANCELADO');$this->excel->getActiveSheet()->getStyle("D{$i}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
         $this->excel->getActiveSheet()->setCellValue("I{$i}", 'CANCELADO');$this->excel->getActiveSheet()->getStyle("I{$i}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
         }
    }

		 $this->excel->getActiveSheet()->setCellValue('A21', 'Importe Total de la Operación');
         $this->excel->getActiveSheet()->getStyle("F21")->getFont()->setBold(true);		 
		 $this->excel->getActiveSheet()->setCellValue('I21', '=SUM(I10:I19)');
		 $this->excel->getActiveSheet()->setCellValue('J21', '=SUM(J10:J19)');
		 $this->excel->getActiveSheet()->setCellValue('K21', '=SUM(K10:K19)');
		 
		 //Le ponemos un nombre al archivo que se va a generar.
	        $archivo = "Vale devolucion_{$dat[0]['consecutivo']}.xls";
	        header('Content-Type: application/vnd.ms-excel');
	        header('Content-Disposition: attachment;filename="'.$archivo.'"');
	        header('Cache-Control: max-age=0');
	        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
            //Hacemos una salida al navegador con el archivo Excel.
        $objWriter->save('php://output');
	} 
}
 
public function exportar_vale_transferencia(){
		$user=$this->session->userdata('useralias');
		$datos=$this->reporte->temp_vales($user)->result();
		$dat = json_decode(json_encode($datos), true);
       if(count($datos) > 0){
         $this->excel->getActiveSheet()->setTitle('Vales');
		 $this->excel->getProperties()->setCreator("Poli_system"); 
        
		//Contador de filas
        $contador = 11;
		//Configurando el documento 
		$this->excel->getDefaultStyle()->getFont()->setName("Arial")->setSize(12)->setBold();
		$this->excel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
        $this->excel->getActiveSheet()->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_LETTER);
		
		//Alto de Filas
		$this->excel->getActiveSheet()->getRowDimension(1)->setRowHeight(20);
		$this->excel->getActiveSheet()->getRowDimension(2)->setRowHeight(20);
		$this->excel->getActiveSheet()->getRowDimension(3)->setRowHeight(20);
		$this->excel->getActiveSheet()->getRowDimension(4)->setRowHeight(20);
		$this->excel->getActiveSheet()->getRowDimension(5)->setRowHeight(20);
		$this->excel->getActiveSheet()->getRowDimension(6)->setRowHeight(20);
		$this->excel->getActiveSheet()->getRowDimension(7)->setRowHeight(20);
		$this->excel->getActiveSheet()->getRowDimension(8)->setRowHeight(10);
		$this->excel->getActiveSheet()->getRowDimension(9)->setRowHeight(20);
		$this->excel->getActiveSheet()->getRowDimension(10)->setRowHeight(23);
		$this->excel->getActiveSheet()->getRowDimension(11)->setRowHeight(20);
		$this->excel->getActiveSheet()->getRowDimension(12)->setRowHeight(20);
		$this->excel->getActiveSheet()->getRowDimension(13)->setRowHeight(20);
		$this->excel->getActiveSheet()->getRowDimension(14)->setRowHeight(20);
		$this->excel->getActiveSheet()->getRowDimension(15)->setRowHeight(20);
		$this->excel->getActiveSheet()->getRowDimension(16)->setRowHeight(20);
		$this->excel->getActiveSheet()->getRowDimension(17)->setRowHeight(20);
		$this->excel->getActiveSheet()->getRowDimension(18)->setRowHeight(20);
		$this->excel->getActiveSheet()->getRowDimension(19)->setRowHeight(20);
		$this->excel->getActiveSheet()->getRowDimension(20)->setRowHeight(20);
		$this->excel->getActiveSheet()->getRowDimension(21)->setRowHeight(20);
		$this->excel->getActiveSheet()->getRowDimension(22)->setRowHeight(15);
		$this->excel->getActiveSheet()->getRowDimension(23)->setRowHeight(23);
		$this->excel->getActiveSheet()->getRowDimension(24)->setRowHeight(2);
		$this->excel->getActiveSheet()->getRowDimension(25)->setRowHeight(2);
		$this->excel->getActiveSheet()->getRowDimension(26)->setRowHeight(2);
		$this->excel->getActiveSheet()->getRowDimension(27)->setRowHeight(20);
		$this->excel->getActiveSheet()->getRowDimension(28)->setRowHeight(20);
		$this->excel->getActiveSheet()->getRowDimension(29)->setRowHeight(20);
		$this->excel->getActiveSheet()->getRowDimension(30)->setRowHeight(20);
		$this->excel->getActiveSheet()->getRowDimension(31)->setRowHeight(20);
		
		//Bordes y fuente
        $bordes = new PHPExcel_Style();
        $bordes->applyFromArray(
        array('font' => array('size' => 12, 'name' => 'Arial')
		,'borders' => array(
        'top' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
        'right' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
        'bottom' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
        'left' => array('style' => PHPExcel_Style_Border::BORDER_THIN)
        )));
        $this->excel->getActiveSheet()->setSharedStyle($bordes, "A1:N10");
        $this->excel->getActiveSheet()->setSharedStyle($bordes, "A27:N31");
		
		$bordes2 = new PHPExcel_Style();
        $bordes2->applyFromArray(
        array('font' => array('size' => 11, 'name' => 'Arial')
		,'borders' => array(
        'top' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
        'right' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
        'bottom' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
        'left' => array('style' => PHPExcel_Style_Border::BORDER_THIN)
        )));
        $this->excel->getActiveSheet()->setSharedStyle($bordes2, "A1:N10");
		
		$bordes3 = new PHPExcel_Style();
        $bordes3->applyFromArray(
        array('font' => array('size' => 14, 'name' => 'Arial')
		,'borders' => array(
        'top' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
        'right' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
        'bottom' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
        'left' => array('style' => PHPExcel_Style_Border::BORDER_THIN)
        )));
        $this->excel->getActiveSheet()->setSharedStyle($bordes3, "M29:N30");
        $this->excel->getActiveSheet()->setSharedStyle($bordes3, "L28");
        
        //establecer margenes
         $margin = 0.5 / 2.54; // 0.5 centimetros
         $marginBottom = 1.0 / 2.54; //1.2 centimetros
         $this->excel->getActiveSheet()->getPageMargins()->setTop($marginBottom);
         $this->excel->getActiveSheet()->getPageMargins()->setBottom($marginBottom);
         $this->excel->getActiveSheet()->getPageMargins()->setLeft($margin);
         $this->excel->getActiveSheet()->getPageMargins()->setRight($margin);
        
		//establecer impresion a pagina completa
         $this->excel->getActiveSheet()->getPageSetup()->setFitToPage(true);
         $this->excel->getActiveSheet()->getPageSetup()->setFitToWidth(1);
         $this->excel->getActiveSheet()->getPageSetup()->setFitToHeight(0);
         
		//Proteger datos
		$this->excel->getActiveSheet()->getProtection()->setPassword('PassPoli,Sistema');
        $this->excel->getActiveSheet()->getProtection()->setSheet(true); 
        $this->excel->getActiveSheet()->getProtection()->setSort(true);
        $this->excel->getActiveSheet()->getProtection()->setInsertRows(true);
        $this->excel->getActiveSheet()->getProtection()->setFormatCells(true);
        
		//Agrupar celdas
		 $this->excel->getActiveSheet()->mergeCells('A1:F1');$this->excel->getActiveSheet()->mergeCells('G1:I1');$this->excel->getActiveSheet()->mergeCells('J1:K1');$this->excel->getActiveSheet()->mergeCells('L1:N1');
		 $this->excel->getActiveSheet()->mergeCells('A2:F2');$this->excel->getActiveSheet()->mergeCells('G2:I2');$this->excel->getActiveSheet()->mergeCells('J2:K4');
		 $this->excel->getActiveSheet()->mergeCells('A3:C3');$this->excel->getActiveSheet()->mergeCells('D3:F3');$this->excel->getActiveSheet()->mergeCells('L3:N4');
		 $this->excel->getActiveSheet()->mergeCells('A4:C4');$this->excel->getActiveSheet()->mergeCells('D4:F4');
		 $this->excel->getActiveSheet()->mergeCells('A5:C5');$this->excel->getActiveSheet()->mergeCells('D5:F5');$this->excel->getActiveSheet()->mergeCells('J5:K5');$this->excel->getActiveSheet()->mergeCells('L5:M5');
		 $this->excel->getActiveSheet()->mergeCells('A6:C6');$this->excel->getActiveSheet()->mergeCells('D6:F6');$this->excel->getActiveSheet()->mergeCells('G6:I6');$this->excel->getActiveSheet()->mergeCells('J6:K6');$this->excel->getActiveSheet()->mergeCells('L6:N6');
		 $this->excel->getActiveSheet()->mergeCells('A7:C7');$this->excel->getActiveSheet()->mergeCells('D7:F7');$this->excel->getActiveSheet()->mergeCells('G7:I7');$this->excel->getActiveSheet()->mergeCells('J7:K7');$this->excel->getActiveSheet()->mergeCells('L7:N7');
		 $this->excel->getActiveSheet()->mergeCells('A8:N8');
		 $this->excel->getActiveSheet()->mergeCells('A9:C9');$this->excel->getActiveSheet()->mergeCells('D9:F9');$this->excel->getActiveSheet()->mergeCells('G9:I9');$this->excel->getActiveSheet()->mergeCells('J9:K9');$this->excel->getActiveSheet()->mergeCells('L9:N9');
		 $this->excel->getActiveSheet()->mergeCells('A10:C10');$this->excel->getActiveSheet()->mergeCells('D10:F10');$this->excel->getActiveSheet()->mergeCells('G10:I10');$this->excel->getActiveSheet()->mergeCells('J10:K10');$this->excel->getActiveSheet()->mergeCells('L10:N10');
		 $this->excel->getActiveSheet()->mergeCells('A23:H23');$this->excel->getActiveSheet()->mergeCells('A22:N22');
		 $this->excel->getActiveSheet()->mergeCells('L11:N11');$this->excel->getActiveSheet()->mergeCells('L12:N12');$this->excel->getActiveSheet()->mergeCells('L13:N13');$this->excel->getActiveSheet()->mergeCells('L14:N14');$this->excel->getActiveSheet()->mergeCells('L15:N15');$this->excel->getActiveSheet()->mergeCells('L16:N16');
         $this->excel->getActiveSheet()->mergeCells('L17:N17');$this->excel->getActiveSheet()->mergeCells('L18:N18');$this->excel->getActiveSheet()->mergeCells('L19:N19');$this->excel->getActiveSheet()->mergeCells('L20:N20');$this->excel->getActiveSheet()->mergeCells('L21:N21');		 
		 $this->excel->getActiveSheet()->mergeCells('A24:N26');$this->excel->getActiveSheet()->mergeCells('L23:N23');
		 $this->excel->getActiveSheet()->mergeCells('A27:C27');$this->excel->getActiveSheet()->mergeCells('E27:H27');$this->excel->getActiveSheet()->mergeCells('I27:J27');$this->excel->getActiveSheet()->mergeCells('L27:N27');
		 $this->excel->getActiveSheet()->mergeCells('A28:C28');$this->excel->getActiveSheet()->mergeCells('E28:H28');$this->excel->getActiveSheet()->mergeCells('I28:K28');$this->excel->getActiveSheet()->mergeCells('L28:N28');
		 $this->excel->getActiveSheet()->mergeCells('A29:C29');$this->excel->getActiveSheet()->mergeCells('E29:H29');$this->excel->getActiveSheet()->mergeCells('I29:K29');$this->excel->getActiveSheet()->mergeCells('M29:N29');
		 $this->excel->getActiveSheet()->mergeCells('A30:C30');$this->excel->getActiveSheet()->mergeCells('E30:H30');$this->excel->getActiveSheet()->mergeCells('I30:K30');$this->excel->getActiveSheet()->mergeCells('M30:N30');
		 $this->excel->getActiveSheet()->mergeCells('B31:C31');$this->excel->getActiveSheet()->mergeCells('E31:F31');$this->excel->getActiveSheet()->mergeCells('G31:H31');$this->excel->getActiveSheet()->mergeCells('I31:K31');$this->excel->getActiveSheet()->mergeCells('L31:N31');
		 
		//Insertar valores
		 $this->excel->getActiveSheet()->setCellValue("A1", 'Entidad: ENSAL');	        
	     $this->excel->getActiveSheet()->setCellValue("A2", 'Unidad: UEB Salina Joa');	        
	     $this->excel->getActiveSheet()->setCellValue("A3", 'Entidad o almacén que entrega:');	        
	     $this->excel->getActiveSheet()->setCellValue("A4", 'Entidad o almacén que recibe:');	        
	     $this->excel->getActiveSheet()->setCellValue("A5", 'Entidad suministradora(nombre-dirección)');	        
	     $this->excel->getActiveSheet()->setCellValue("A6", 'Orden de trabajo');	        
	     $this->excel->getActiveSheet()->setCellValue("A9", 'Transportador');	        
	     $this->excel->getActiveSheet()->setCellValue("A10", $dat[0]['nombre_transportador']);	        
	     $this->excel->getActiveSheet()->setCellValue("A27", 'Despachado o Confeccionado:');	        
	     $this->excel->getActiveSheet()->setCellValue("A28", $dat[0]['despachador']);	        
	     $this->excel->getActiveSheet()->setCellValue("A29", 'Firma:');	        
	     $this->excel->getActiveSheet()->setCellValue("A30", 'Jefe-Almacén:');	        
	     $this->excel->getActiveSheet()->setCellValue("A31", 'Fecha:');	        
	     $this->excel->getActiveSheet()->setCellValue("B31", $dat[0]['fecha_vale']);	        
	     $this->excel->getActiveSheet()->setCellValue("D3", $dat[0]['nombre_entidad_despacha'] );	        
	     $this->excel->getActiveSheet()->setCellValue("D4", $dat[0]['nombre_entidad_recibe'] );	        
	     $this->excel->getActiveSheet()->setCellValue("D5", $dat[0]['nombre_entidad_despacha']);	        
	     $this->excel->getActiveSheet()->setCellValue("D6", 'Solicitud de compra No.');
		 $this->excel->getActiveSheet()->setCellValue("D7", $dat[0]['no_solicitud_compra']);	        
	     $this->excel->getActiveSheet()->setCellValue("D9", 'Carnet Identidad No.');
		 $this->excel->getActiveSheet()->setCellValue("D10", $dat[0]['no_carnet']);	        
	     $this->excel->getActiveSheet()->setCellValue("D27", 'Autorizado:');
		 $this->excel->getActiveSheet()->setCellValue("D28", 'Firma:');
		 $this->excel->getActiveSheet()->setCellValue("D29", 'Inf. reclam                         Act. Trasl.');
		 $this->excel->getActiveSheet()->setCellValue("D30", 'Fecha:                                 Fecha:');
		 $this->excel->getActiveSheet()->setCellValue("E27", 'Recibido:');
		 $this->excel->getActiveSheet()->setCellValue("E28", $dat[0]['receptor']);
		 $this->excel->getActiveSheet()->setCellValue("E29", 'Firma:');
		 $this->excel->getActiveSheet()->setCellValue("E30", 'Recepcionado:');
		 $this->excel->getActiveSheet()->setCellValue("E31", 'Fecha:');
		 $this->excel->getActiveSheet()->setCellValue("G1", 'Código: 104.0.14051');	        
	     $this->excel->getActiveSheet()->setCellValue("G2", 'Código: 49');	        
	     $this->excel->getActiveSheet()->setCellValue("G3", 'Código:');	        
	     $this->excel->getActiveSheet()->setCellValue("G4", 'Código:');	        
	     $this->excel->getActiveSheet()->setCellValue("G5", 'Código:');	
         $this->excel->getActiveSheet()->setCellValue("G6", 'Centro Costo(nombre)');	        
	     $this->excel->getActiveSheet()->setCellValue("G7",  $dat[0]['nombre_centro_costo']);	        
	     $this->excel->getActiveSheet()->setCellValue("G9", 'Chapa No.');	        
	     $this->excel->getActiveSheet()->setCellValue("G10",  $dat[0]['chapa']);	        
	     $this->excel->getActiveSheet()->setCellValue("G31", $dat[0]['fecha_vale']);
		 $this->excel->getActiveSheet()->setCellValue("H3", $dat[0]['no_entidad_despacha']);	        
		 $this->excel->getActiveSheet()->setCellValue("H4", $dat[0]['no_entidad_recibe']);	        
		 $this->excel->getActiveSheet()->setCellValue("H5", $dat[0]['no_entidad_despacha']);	        
		 $this->excel->getActiveSheet()->setCellValue("I5", 'Contrato No:');	        
	     $this->excel->getActiveSheet()->setCellValue("I27", 'Anotado Control Inv.');	        
	     $this->excel->getActiveSheet()->setCellValue("I29", 'Firma:');	        
	     $this->excel->getActiveSheet()->setCellValue("I30", 'Contabilizado-Firma:');	        
	     $this->excel->getActiveSheet()->setCellValue("I31", 'Fecha:');	        
	     $this->excel->getActiveSheet()->setCellValue("K27", 'Fecha:');	        
	     $this->excel->getActiveSheet()->setCellValue("J1", 'Modelo múltiple');	        
	     $this->excel->getActiveSheet()->setCellValue("J2", 'Vale de transferencia');		 
	     $this->excel->getActiveSheet()->setCellValue("J5", 'Factura No:');		 
	     $this->excel->getActiveSheet()->setCellValue("J6", 'Centro Costo(número)');		 
	     $this->excel->getActiveSheet()->setCellValue("J7", $dat[0]['no_centro_costo']);		 
	     $this->excel->getActiveSheet()->setCellValue("J9", 'Licencia Conducción');		 
	     $this->excel->getActiveSheet()->setCellValue("J10", $dat[0]['licencia_conduccion']);		 
	     $this->excel->getActiveSheet()->setCellValue("L1", 'Fecha');		 
	     $this->excel->getActiveSheet()->setCellValue("L2", 'A');		 
	     $this->excel->getActiveSheet()->setCellValue("L3", $dat[0]['fecha_vale']);		 
	     $this->excel->getActiveSheet()->setCellValue("L5", 'Conduce No:');		 
	     $this->excel->getActiveSheet()->setCellValue("L6", 'Bultos');		 
	     $this->excel->getActiveSheet()->setCellValue("L7", $dat[0]['bultos']);
         $this->excel->getActiveSheet()->setCellValue("L27", 'Consecutivo No.:');	        
	     $this->excel->getActiveSheet()->setCellValue("L29", 'Sol No.:');	        
	     $this->excel->getActiveSheet()->setCellValue("L30", 'Doc No.:');	        
	     $this->excel->getActiveSheet()->setCellValue("M2", 'M');		 
	     $this->excel->getActiveSheet()->setCellValue("M29", $dat[0]['no_solicitud_compra']);	        
	     $this->excel->getActiveSheet()->setCellValue("M30", $dat[0]['consecutivo']);
         $this->excel->getActiveSheet()->setCellValue("N2", 'D');		 
	     $this->excel->getActiveSheet()->setCellValue("N5", $dat[0]['no_conduce']);		 
	     $this->excel->getActiveSheet()->setCellValue("L28", $dat[0]['consecutivo']);	        
	     
         	     
       //ancho de columnas.
       $this->excel->getActiveSheet()->getColumnDimension('A')->setWidth(17);
	   $this->excel->getActiveSheet()->getColumnDimension('B')->setWidth(5);
	   $this->excel->getActiveSheet()->getColumnDimension('C')->setWidth(4);
	   $this->excel->getActiveSheet()->getColumnDimension('D')->setWidth(32);
	   $this->excel->getActiveSheet()->getColumnDimension('E')->setWidth(6);
	   $this->excel->getActiveSheet()->getColumnDimension('F')->setWidth(14);
	   $this->excel->getActiveSheet()->getColumnDimension('G')->setWidth(11);
	   $this->excel->getActiveSheet()->getColumnDimension('H')->setWidth(4);
	   $this->excel->getActiveSheet()->getColumnDimension('I')->setWidth(12);
	   $this->excel->getActiveSheet()->getColumnDimension('J')->setWidth(3);
	   $this->excel->getActiveSheet()->getColumnDimension('K')->setWidth(11);
	   $this->excel->getActiveSheet()->getColumnDimension('L')->setWidth(5);
	   $this->excel->getActiveSheet()->getColumnDimension('M')->setWidth(4);
	   $this->excel->getActiveSheet()->getColumnDimension('N')->setWidth(4);
	  	     
	  //títulos de la cabecera.
	    $this->excel->getActiveSheet()->setCellValue("A{$contador}", 'Código');	        
	    $this->excel->getActiveSheet()->setCellValue("B{$contador}", 'Cta');
	    $this->excel->getActiveSheet()->setCellValue("C{$contador}", 'Sub-Cta');
	    $this->excel->getActiveSheet()->setCellValue("D{$contador}", 'Descripción');
	    $this->excel->getActiveSheet()->setCellValue("E{$contador}", 'UM');
	    $this->excel->getActiveSheet()->setCellValue("F{$contador}", 'Cant.');
	    $this->excel->getActiveSheet()->setCellValue("G{$contador}", 'Precio(MN)');
	    $this->excel->getActiveSheet()->setCellValue("H{$contador}", 'Prec(mlc)');
	    $this->excel->getActiveSheet()->setCellValue("I{$contador}", 'Importe(MN)');
	    $this->excel->getActiveSheet()->setCellValue("J{$contador}", 'Imp(mlc)');
	    $this->excel->getActiveSheet()->setCellValue("K{$contador}", 'Importe');
	    $this->excel->getActiveSheet()->setCellValue("L{$contador}", 'Saldo en existencia');
		
	 //Formato de celdas, alineación
	    $this->excel->getActiveSheet()->getStyle("A{$contador}:L{$contador}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->getStyle("J2")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
		$this->excel->getActiveSheet()->getStyle("L3")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
		$this->excel->getActiveSheet()->getStyle("A12:A21")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
		$this->excel->getActiveSheet()->getStyle("B12:C31")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->getStyle("E12:N23")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->getStyle("J1:N4")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->getStyle("A6:N7")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->getStyle("A23")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
		$this->excel->getActiveSheet()->getStyle("L28")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->getStyle("L29:N31")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
		$this->excel->getActiveSheet()->getStyle("A23:N31")->getFont()->setBold(true);
	    $this->excel->getActiveSheet()->getStyle("B31")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
				 
	 //Definimos la data del cuerpo.    
 foreach($datos as $v){
         $contador++;
         $this->excel->getActiveSheet()->setCellValue("A{$contador}", $v->id_producto);
         $this->excel->getActiveSheet()->setCellValue("B{$contador}", $v->cta);
         $this->excel->getActiveSheet()->setCellValue("C{$contador}", $v->sub_cta);
         $this->excel->getActiveSheet()->setCellValue("D{$contador}", $v->nombre_producto);
         $this->excel->getActiveSheet()->setCellValue("E{$contador}", $v->unidad_medida);
         $this->excel->getActiveSheet()->setCellValue("F{$contador}", $v->cantidad);
         $this->excel->getActiveSheet()->setCellValue("G{$contador}", $v->precio_mn);
         $this->excel->getActiveSheet()->setCellValue("H{$contador}", $v->precio_mlc);
         $this->excel->getActiveSheet()->setCellValue("I{$contador}", $v->importe_mn);
         $this->excel->getActiveSheet()->setCellValue("J{$contador}", $v->importe_mlc);
         $this->excel->getActiveSheet()->setCellValue("K{$contador}", $v->importe_unitario);
         $this->excel->getActiveSheet()->setCellValue("L{$contador}", $v->resto);
         $this->excel->getActiveSheet()->getStyle("A{$contador}:N{$contador}")->getFont()->setBold(true);
	   }
		
		//rellenar con contenido
    if ($v->estado=='cancelado') {
       for ($i=$contador+1; $i<20; $i++) {
         $this->excel->getActiveSheet()->setCellValue("D{$i}", 'CANCELADO');$this->excel->getActiveSheet()->getStyle("D{$i}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
         $this->excel->getActiveSheet()->setCellValue("I{$i}", 'CANCELADO');$this->excel->getActiveSheet()->getStyle("I{$i}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
         }
    }
    
		 $this->excel->getActiveSheet()->setCellValue('A23', 'Importe Total de la Operación');
         $this->excel->getActiveSheet()->getStyle("F23")->getFont()->setBold(true);		 
		 $this->excel->getActiveSheet()->setCellValue('I23', '=SUM(I12:I21)');
		 $this->excel->getActiveSheet()->setCellValue('J23', '=SUM(J12:J21)');
		 $this->excel->getActiveSheet()->setCellValue('K23', '=SUM(K12:K21)');	
		 
		 //Le ponemos un nombre al archivo que se va a generar.
	        $archivo = "Vales transferencia_{$dat[0]['consecutivo']}.xls";
	        header('Content-Type: application/vnd.ms-excel');
	        header('Content-Disposition: attachment;filename="'.$archivo.'"');
	        header('Cache-Control: max-age=0');
	        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
            //Hacemos una salida al navegador con el archivo Excel.
        $objWriter->save('php://output');
	} 
}

public function exportar_factura_transferencia(){
		$user=$this->session->userdata('useralias');
		$datos=$this->reporte->temp_vales($user)->result();
		$dat = json_decode(json_encode($datos), true);
       if(count($datos) > 0){
         $this->excel->getActiveSheet()->setTitle('Factura');
		 $this->excel->getProperties()->setCreator("Poli_system"); 
        
		//Contador de filas
        $contador = 11;
		//Configurando el documento 
		$this->excel->getDefaultStyle()->getFont()->setName("Arial")->setSize(12)->setBold();
		$this->excel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
        $this->excel->getActiveSheet()->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_LETTER);
		
		//Alto de Filas
		$this->excel->getActiveSheet()->getRowDimension(1)->setRowHeight(20);
		$this->excel->getActiveSheet()->getRowDimension(2)->setRowHeight(20);
		$this->excel->getActiveSheet()->getRowDimension(3)->setRowHeight(20);
		$this->excel->getActiveSheet()->getRowDimension(4)->setRowHeight(20);
		$this->excel->getActiveSheet()->getRowDimension(5)->setRowHeight(20);
		$this->excel->getActiveSheet()->getRowDimension(6)->setRowHeight(20);
		$this->excel->getActiveSheet()->getRowDimension(7)->setRowHeight(20);
		$this->excel->getActiveSheet()->getRowDimension(8)->setRowHeight(10);
		$this->excel->getActiveSheet()->getRowDimension(9)->setRowHeight(20);
		$this->excel->getActiveSheet()->getRowDimension(10)->setRowHeight(23);
		$this->excel->getActiveSheet()->getRowDimension(11)->setRowHeight(20);
		$this->excel->getActiveSheet()->getRowDimension(12)->setRowHeight(20);
		$this->excel->getActiveSheet()->getRowDimension(13)->setRowHeight(20);
		$this->excel->getActiveSheet()->getRowDimension(14)->setRowHeight(20);
		$this->excel->getActiveSheet()->getRowDimension(15)->setRowHeight(20);
		$this->excel->getActiveSheet()->getRowDimension(16)->setRowHeight(20);
		$this->excel->getActiveSheet()->getRowDimension(17)->setRowHeight(20);
		$this->excel->getActiveSheet()->getRowDimension(18)->setRowHeight(20);
		$this->excel->getActiveSheet()->getRowDimension(19)->setRowHeight(20);
		$this->excel->getActiveSheet()->getRowDimension(20)->setRowHeight(20);
		$this->excel->getActiveSheet()->getRowDimension(21)->setRowHeight(20);
		$this->excel->getActiveSheet()->getRowDimension(22)->setRowHeight(15);
		$this->excel->getActiveSheet()->getRowDimension(23)->setRowHeight(23);
		$this->excel->getActiveSheet()->getRowDimension(24)->setRowHeight(2);
		$this->excel->getActiveSheet()->getRowDimension(25)->setRowHeight(2);
		$this->excel->getActiveSheet()->getRowDimension(26)->setRowHeight(2);
		$this->excel->getActiveSheet()->getRowDimension(27)->setRowHeight(20);
		$this->excel->getActiveSheet()->getRowDimension(28)->setRowHeight(20);
		$this->excel->getActiveSheet()->getRowDimension(29)->setRowHeight(20);
		$this->excel->getActiveSheet()->getRowDimension(30)->setRowHeight(20);
		$this->excel->getActiveSheet()->getRowDimension(31)->setRowHeight(20);
		
		//Bordes y fuente
        $bordes = new PHPExcel_Style();
        $bordes->applyFromArray(
        array('font' => array('size' => 12, 'name' => 'Arial')
		,'borders' => array(
        'top' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
        'right' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
        'bottom' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
        'left' => array('style' => PHPExcel_Style_Border::BORDER_THIN)
        )));
        $this->excel->getActiveSheet()->setSharedStyle($bordes, "A1:N10");
        $this->excel->getActiveSheet()->setSharedStyle($bordes, "A27:N31");
		
		$bordes2 = new PHPExcel_Style();
        $bordes2->applyFromArray(
        array('font' => array('size' => 11, 'name' => 'Arial')
		,'borders' => array(
        'top' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
        'right' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
        'bottom' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
        'left' => array('style' => PHPExcel_Style_Border::BORDER_THIN)
        )));
        $this->excel->getActiveSheet()->setSharedStyle($bordes2, "A1:N10");
		
		$bordes3 = new PHPExcel_Style();
        $bordes3->applyFromArray(
        array('font' => array('size' => 14, 'name' => 'Arial')
		,'borders' => array(
        'top' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
        'right' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
        'bottom' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
        'left' => array('style' => PHPExcel_Style_Border::BORDER_THIN)
        )));
        $this->excel->getActiveSheet()->setSharedStyle($bordes3, "M29:N30");
        $this->excel->getActiveSheet()->setSharedStyle($bordes3, "L28");
        
        //establecer margenes
         $margin = 0.5 / 2.54; // 0.5 centimetros
         $marginBottom = 1.0 / 2.54; //1.2 centimetros
         $this->excel->getActiveSheet()->getPageMargins()->setTop($marginBottom);
         $this->excel->getActiveSheet()->getPageMargins()->setBottom($marginBottom);
         $this->excel->getActiveSheet()->getPageMargins()->setLeft($margin);
         $this->excel->getActiveSheet()->getPageMargins()->setRight($margin);
        
		//establecer impresion a pagina completa
         $this->excel->getActiveSheet()->getPageSetup()->setFitToPage(true);
         $this->excel->getActiveSheet()->getPageSetup()->setFitToWidth(1);
         $this->excel->getActiveSheet()->getPageSetup()->setFitToHeight(0);
         
		//Proteger datos
		$this->excel->getActiveSheet()->getProtection()->setPassword('PassPoli,Sistema');
        $this->excel->getActiveSheet()->getProtection()->setSheet(true); 
        $this->excel->getActiveSheet()->getProtection()->setSort(true);
        $this->excel->getActiveSheet()->getProtection()->setInsertRows(true);
        $this->excel->getActiveSheet()->getProtection()->setFormatCells(true);
        
		//Agrupar celdas
		 $this->excel->getActiveSheet()->mergeCells('A1:F1');$this->excel->getActiveSheet()->mergeCells('G1:I1');$this->excel->getActiveSheet()->mergeCells('J1:K1');$this->excel->getActiveSheet()->mergeCells('L1:N1');
		 $this->excel->getActiveSheet()->mergeCells('A2:F2');$this->excel->getActiveSheet()->mergeCells('G2:I2');$this->excel->getActiveSheet()->mergeCells('J2:K4');
		 $this->excel->getActiveSheet()->mergeCells('A3:C3');$this->excel->getActiveSheet()->mergeCells('D3:F3');$this->excel->getActiveSheet()->mergeCells('L3:N4');
		 $this->excel->getActiveSheet()->mergeCells('A4:C4');$this->excel->getActiveSheet()->mergeCells('D4:F4');$this->excel->getActiveSheet()->mergeCells('H4:I4');
		 $this->excel->getActiveSheet()->mergeCells('A5:C5');$this->excel->getActiveSheet()->mergeCells('D5:F5');$this->excel->getActiveSheet()->mergeCells('J5:K5');$this->excel->getActiveSheet()->mergeCells('L5:M5');
		 $this->excel->getActiveSheet()->mergeCells('A6:C6');$this->excel->getActiveSheet()->mergeCells('D6:F6');$this->excel->getActiveSheet()->mergeCells('G6:I6');$this->excel->getActiveSheet()->mergeCells('J6:K6');$this->excel->getActiveSheet()->mergeCells('L6:N6');
		 $this->excel->getActiveSheet()->mergeCells('A7:C7');$this->excel->getActiveSheet()->mergeCells('D7:F7');$this->excel->getActiveSheet()->mergeCells('G7:I7');$this->excel->getActiveSheet()->mergeCells('J7:K7');$this->excel->getActiveSheet()->mergeCells('L7:N7');
		 $this->excel->getActiveSheet()->mergeCells('A8:N8');
		 $this->excel->getActiveSheet()->mergeCells('A9:C9');$this->excel->getActiveSheet()->mergeCells('D9:F9');$this->excel->getActiveSheet()->mergeCells('G9:I9');$this->excel->getActiveSheet()->mergeCells('J9:K9');$this->excel->getActiveSheet()->mergeCells('L9:N9');
		 $this->excel->getActiveSheet()->mergeCells('A10:C10');$this->excel->getActiveSheet()->mergeCells('D10:F10');$this->excel->getActiveSheet()->mergeCells('G10:I10');$this->excel->getActiveSheet()->mergeCells('J10:K10');$this->excel->getActiveSheet()->mergeCells('L10:N10');
		 $this->excel->getActiveSheet()->mergeCells('A23:H23');$this->excel->getActiveSheet()->mergeCells('A22:N22');
		 $this->excel->getActiveSheet()->mergeCells('L11:N11');$this->excel->getActiveSheet()->mergeCells('L12:N12');$this->excel->getActiveSheet()->mergeCells('L13:N13');$this->excel->getActiveSheet()->mergeCells('L14:N14');$this->excel->getActiveSheet()->mergeCells('L15:N15');$this->excel->getActiveSheet()->mergeCells('L16:N16');
         $this->excel->getActiveSheet()->mergeCells('L17:N17');$this->excel->getActiveSheet()->mergeCells('L18:N18');$this->excel->getActiveSheet()->mergeCells('L19:N19');$this->excel->getActiveSheet()->mergeCells('L20:N20');$this->excel->getActiveSheet()->mergeCells('L21:N21');		 
		 $this->excel->getActiveSheet()->mergeCells('A24:N26');$this->excel->getActiveSheet()->mergeCells('L23:N23');
		 $this->excel->getActiveSheet()->mergeCells('A27:C27');$this->excel->getActiveSheet()->mergeCells('E27:H27');$this->excel->getActiveSheet()->mergeCells('I27:J27');$this->excel->getActiveSheet()->mergeCells('L27:N27');
		 $this->excel->getActiveSheet()->mergeCells('A28:C28');$this->excel->getActiveSheet()->mergeCells('E28:H28');$this->excel->getActiveSheet()->mergeCells('I28:K28');$this->excel->getActiveSheet()->mergeCells('L28:N28');
		 $this->excel->getActiveSheet()->mergeCells('A29:C29');$this->excel->getActiveSheet()->mergeCells('E29:H29');$this->excel->getActiveSheet()->mergeCells('I29:K29');$this->excel->getActiveSheet()->mergeCells('M29:N29');
		 $this->excel->getActiveSheet()->mergeCells('A30:C30');$this->excel->getActiveSheet()->mergeCells('E30:H30');$this->excel->getActiveSheet()->mergeCells('I30:K30');$this->excel->getActiveSheet()->mergeCells('M30:N30');
		 $this->excel->getActiveSheet()->mergeCells('B31:C31');$this->excel->getActiveSheet()->mergeCells('E31:F31');$this->excel->getActiveSheet()->mergeCells('G31:H31');$this->excel->getActiveSheet()->mergeCells('I31:K31');$this->excel->getActiveSheet()->mergeCells('L31:N31');
		 
		//Insertar valores
		 $this->excel->getActiveSheet()->setCellValue("A1", 'Entidad: ENSAL');	        
	     $this->excel->getActiveSheet()->setCellValue("A2", 'Unidad: UEB Salina Joa');	        
	     $this->excel->getActiveSheet()->setCellValue("A3", 'Entidad o almacén que entrega:');	        
	     $this->excel->getActiveSheet()->setCellValue("A4", 'Entidad o almacén que recibe:');	        
	     $this->excel->getActiveSheet()->setCellValue("A5", 'Entidad suministradora(nombre-dirección)');	        
	     $this->excel->getActiveSheet()->setCellValue("A6", 'Orden de trabajo');	        
	     $this->excel->getActiveSheet()->setCellValue("A9", 'Transportador');	        
	     $this->excel->getActiveSheet()->setCellValue("A10", $dat[0]['nombre_transportador']);	        
	     $this->excel->getActiveSheet()->setCellValue("A27", 'Despachado o Confeccionado:');	        
	     $this->excel->getActiveSheet()->setCellValue("A28", $dat[0]['despachador']);	        
	     $this->excel->getActiveSheet()->setCellValue("A29", 'Firma:');	        
	     $this->excel->getActiveSheet()->setCellValue("A30", 'Jefe-Almacén:');	        
	     $this->excel->getActiveSheet()->setCellValue("A31", 'Fecha:');	        
	     $this->excel->getActiveSheet()->setCellValue("B31", $dat[0]['fecha_vale']);	        
	     $this->excel->getActiveSheet()->setCellValue("D3", $dat[0]['nombre_entidad_despacha'] );	        
	     $this->excel->getActiveSheet()->setCellValue("D4", $dat[0]['nombre_entidad_recibe'] );	        
	     $this->excel->getActiveSheet()->setCellValue("D5", $dat[0]['nombre_entidad_despacha']);	        
	     $this->excel->getActiveSheet()->setCellValue("D6", 'Solicitud de compra No.');
		 $this->excel->getActiveSheet()->setCellValue("D7", $dat[0]['no_solicitud_compra']);	        
	     $this->excel->getActiveSheet()->setCellValue("D9", 'Carnet Identidad No.');
		 $this->excel->getActiveSheet()->setCellValue("D10", $dat[0]['no_carnet']);	        
	     $this->excel->getActiveSheet()->setCellValue("D27", 'Autorizado:');
		 $this->excel->getActiveSheet()->setCellValue("D28", 'Firma:');
		 $this->excel->getActiveSheet()->setCellValue("D29", 'Inf. reclam                         Act. Trasl.');
		 $this->excel->getActiveSheet()->setCellValue("D30", 'Fecha:                                 Fecha:');
		 $this->excel->getActiveSheet()->setCellValue("E27", 'Recibido:');
		 $this->excel->getActiveSheet()->setCellValue("E28", $dat[0]['receptor']);
		 $this->excel->getActiveSheet()->setCellValue("E29", 'Firma:');
		 $this->excel->getActiveSheet()->setCellValue("E30", 'Recepcionado:');
		 $this->excel->getActiveSheet()->setCellValue("E31", 'Fecha:');
		 $this->excel->getActiveSheet()->setCellValue("G1", 'Código: 104.0.14051');	        
	     $this->excel->getActiveSheet()->setCellValue("G2", 'Código: 49');	        
	     $this->excel->getActiveSheet()->setCellValue("G3", 'Código:');	        
	     $this->excel->getActiveSheet()->setCellValue("G4", 'Código:');	        
	     $this->excel->getActiveSheet()->setCellValue("G5", 'Código:');	
         $this->excel->getActiveSheet()->setCellValue("G6", 'Centro Costo(nombre)');	        
	     $this->excel->getActiveSheet()->setCellValue("G7",  $dat[0]['nombre_centro_costo']);	        
	     $this->excel->getActiveSheet()->setCellValue("G9", 'Chapa No.');	        
	     $this->excel->getActiveSheet()->setCellValue("G10",  $dat[0]['chapa']);	        
	     $this->excel->getActiveSheet()->setCellValue("G31", $dat[0]['fecha_vale']);
		 $this->excel->getActiveSheet()->setCellValue("H3", $dat[0]['no_entidad_despacha']);	        
		 $this->excel->getActiveSheet()->setCellValue("H4", $dat[0]['no_entidad_recibe']);	        
		 $this->excel->getActiveSheet()->setCellValue("H5", $dat[0]['no_entidad_despacha']);	        
		 $this->excel->getActiveSheet()->setCellValue("I5", 'Contrato No:');	        
	     $this->excel->getActiveSheet()->setCellValue("I27", 'Anotado Control Inv.');	        
	     $this->excel->getActiveSheet()->setCellValue("I29", 'Firma:');	        
	     $this->excel->getActiveSheet()->setCellValue("I30", 'Contabilizado-Firma:');	        
	     $this->excel->getActiveSheet()->setCellValue("I31", 'Fecha:');	        
	     $this->excel->getActiveSheet()->setCellValue("K27", 'Fecha:');	        
	     $this->excel->getActiveSheet()->setCellValue("J1", 'Modelo múltiple');	        
	     $this->excel->getActiveSheet()->setCellValue("J2", 'Factura');		 
	     $this->excel->getActiveSheet()->setCellValue("J5", 'Factura No:');		 
	     $this->excel->getActiveSheet()->setCellValue("J6", 'Centro Costo(número)');		 
	     $this->excel->getActiveSheet()->setCellValue("J7", $dat[0]['no_centro_costo']);		 
	     $this->excel->getActiveSheet()->setCellValue("J9", 'Licencia Conducción');		 
	     $this->excel->getActiveSheet()->setCellValue("J10", $dat[0]['licencia_conduccion']);		 
	     $this->excel->getActiveSheet()->setCellValue("L1", 'Fecha');		 
	     $this->excel->getActiveSheet()->setCellValue("L2", 'A');		 
	     $this->excel->getActiveSheet()->setCellValue("L3", $dat[0]['fecha_vale']);		 
	     $this->excel->getActiveSheet()->setCellValue("L5", 'Conduce No:');		 
	     $this->excel->getActiveSheet()->setCellValue("L6", 'Bultos');		 
	     $this->excel->getActiveSheet()->setCellValue("L7", $dat[0]['bultos']);
         $this->excel->getActiveSheet()->setCellValue("L27", 'Consecutivo No.:');	        
	     $this->excel->getActiveSheet()->setCellValue("L29", 'Sol No.:');	        
	     $this->excel->getActiveSheet()->setCellValue("L30", 'Doc No.:');	        
	     $this->excel->getActiveSheet()->setCellValue("M2", 'M');		 
	     $this->excel->getActiveSheet()->setCellValue("M29", $dat[0]['no_solicitud_compra']);	        
	     $this->excel->getActiveSheet()->setCellValue("M30", $dat[0]['consecutivo']);
         $this->excel->getActiveSheet()->setCellValue("N2", 'D');		 
	     $this->excel->getActiveSheet()->setCellValue("N5", $dat[0]['no_conduce']);		 
	     $this->excel->getActiveSheet()->setCellValue("L28", $dat[0]['consecutivo']);	        
	     
         	     
       //ancho de columnas.
       $this->excel->getActiveSheet()->getColumnDimension('A')->setWidth(17);
	   $this->excel->getActiveSheet()->getColumnDimension('B')->setWidth(5);
	   $this->excel->getActiveSheet()->getColumnDimension('C')->setWidth(4);
	   $this->excel->getActiveSheet()->getColumnDimension('D')->setWidth(32);
	   $this->excel->getActiveSheet()->getColumnDimension('E')->setWidth(6);
	   $this->excel->getActiveSheet()->getColumnDimension('F')->setWidth(14);
	   $this->excel->getActiveSheet()->getColumnDimension('G')->setWidth(11);
	   $this->excel->getActiveSheet()->getColumnDimension('H')->setWidth(4);
	   $this->excel->getActiveSheet()->getColumnDimension('I')->setWidth(12);
	   $this->excel->getActiveSheet()->getColumnDimension('J')->setWidth(3);
	   $this->excel->getActiveSheet()->getColumnDimension('K')->setWidth(11);
	   $this->excel->getActiveSheet()->getColumnDimension('L')->setWidth(5);
	   $this->excel->getActiveSheet()->getColumnDimension('M')->setWidth(4);
	   $this->excel->getActiveSheet()->getColumnDimension('N')->setWidth(4);
	  	     
	  //títulos de la cabecera.
	    $this->excel->getActiveSheet()->setCellValue("A{$contador}", 'Código');	        
	    $this->excel->getActiveSheet()->setCellValue("B{$contador}", 'Cta');
	    $this->excel->getActiveSheet()->setCellValue("C{$contador}", 'Sub-Cta');
	    $this->excel->getActiveSheet()->setCellValue("D{$contador}", 'Descripción');
	    $this->excel->getActiveSheet()->setCellValue("E{$contador}", 'UM');
	    $this->excel->getActiveSheet()->setCellValue("F{$contador}", 'Cant.');
	    $this->excel->getActiveSheet()->setCellValue("G{$contador}", 'Precio(MN)');
	    $this->excel->getActiveSheet()->setCellValue("H{$contador}", 'Prec(mlc)');
	    $this->excel->getActiveSheet()->setCellValue("I{$contador}", 'Importe(MN)');
	    $this->excel->getActiveSheet()->setCellValue("J{$contador}", 'Imp(mlc)');
	    $this->excel->getActiveSheet()->setCellValue("K{$contador}", 'Importe');
	    $this->excel->getActiveSheet()->setCellValue("L{$contador}", 'Saldo en existencia');
		
	 //Formato de celdas, alineación
	    $this->excel->getActiveSheet()->getStyle("A{$contador}:L{$contador}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->getStyle("J2")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
		$this->excel->getActiveSheet()->getStyle("L3")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
		$this->excel->getActiveSheet()->getStyle("A12:A21")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
		$this->excel->getActiveSheet()->getStyle("B12:C31")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->getStyle("E12:N23")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->getStyle("J1:N4")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->getStyle("A6:N7")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->getStyle("A23")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
		$this->excel->getActiveSheet()->getStyle("L28")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->getStyle("L29:N31")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
		$this->excel->getActiveSheet()->getStyle("A23:N31")->getFont()->setBold(true);
	    $this->excel->getActiveSheet()->getStyle("B31")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
				 
	 //Definimos la data del cuerpo.    
 foreach($datos as $v){
         $contador++;
         $this->excel->getActiveSheet()->setCellValue("A{$contador}", $v->id_producto);
         $this->excel->getActiveSheet()->setCellValue("B{$contador}", $v->cta);
         $this->excel->getActiveSheet()->setCellValue("C{$contador}", $v->sub_cta);
         $this->excel->getActiveSheet()->setCellValue("D{$contador}", $v->nombre_producto);
         $this->excel->getActiveSheet()->setCellValue("E{$contador}", $v->unidad_medida);
         $this->excel->getActiveSheet()->setCellValue("F{$contador}", $v->cantidad);
         $this->excel->getActiveSheet()->setCellValue("G{$contador}", $v->precio_mn);
         $this->excel->getActiveSheet()->setCellValue("H{$contador}", $v->precio_mlc);
         $this->excel->getActiveSheet()->setCellValue("I{$contador}", $v->importe_mn);
         $this->excel->getActiveSheet()->setCellValue("J{$contador}", $v->importe_mlc);
         $this->excel->getActiveSheet()->setCellValue("K{$contador}", $v->importe_unitario);
         $this->excel->getActiveSheet()->setCellValue("L{$contador}", $v->resto);
         $this->excel->getActiveSheet()->getStyle("A{$contador}:N{$contador}")->getFont()->setBold(true);
	   }
		
		//rellenar con contenido
    if ($v->estado=='cancelado') {
       for ($i=$contador+1; $i<20; $i++) {
         $this->excel->getActiveSheet()->setCellValue("D{$i}", 'CANCELADO');$this->excel->getActiveSheet()->getStyle("D{$i}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
         $this->excel->getActiveSheet()->setCellValue("I{$i}", 'CANCELADO');$this->excel->getActiveSheet()->getStyle("I{$i}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
         }
    }
    
		 $this->excel->getActiveSheet()->setCellValue('A23', 'Importe Total de la Operación');
         $this->excel->getActiveSheet()->getStyle("F23")->getFont()->setBold(true);		 
		 $this->excel->getActiveSheet()->setCellValue('I23', '=SUM(I12:I21)');
		 $this->excel->getActiveSheet()->setCellValue('J23', '=SUM(J12:J21)');
		 $this->excel->getActiveSheet()->setCellValue('K23', '=SUM(K12:K21)');	
		 
		 //Le ponemos un nombre al archivo que se va a generar.
	        $archivo = "Factura transferencia_{$dat[0]['consecutivo']}.xls";
	        header('Content-Type: application/vnd.ms-excel');
	        header('Content-Disposition: attachment;filename="'.$archivo.'"');
	        header('Cache-Control: max-age=0');
	        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
            //Hacemos una salida al navegador con el archivo Excel.
        $objWriter->save('php://output');
	} 
}

 public function exportar_combustible_tecnologico(){
        $llamadas=$this->reporte->existencia_tecnologico()->result();
		if(count($llamadas) > 0){
        //Cargamos la librería de excel.
        $this->excel->getActiveSheet()->setTitle('combustible tecnológico');
        //Contador de filas
        $contador = 1;
		//Agrupa celdas
		 $this->excel->getActiveSheet()->mergeCells('A20:E30');
		 $this->excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_JUSTIFY);
         $this->excel->getActiveSheet()->getStyle('E1')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        //Le aplicamos ancho las columnas.
       $this->excel->getActiveSheet()->getColumnDimension('A')->setWidth(17);
	   $this->excel->getActiveSheet()->getColumnDimension('B')->setWidth(34);
	   $this->excel->getActiveSheet()->getColumnDimension('C')->setWidth(12);
	   $this->excel->getActiveSheet()->getColumnDimension('D')->setWidth(12);
	   $this->excel->getActiveSheet()->getColumnDimension('E')->setWidth(12);
	   //Le aplicamos negrita a los títulos de la cabecera.
	    $this->excel->getActiveSheet()->getStyle("A{$contador}")->getFont()->setBold(true);
	    $this->excel->getActiveSheet()->getStyle("B{$contador}")->getFont()->setBold(true);
	    $this->excel->getActiveSheet()->getStyle("C{$contador}")->getFont()->setBold(true);
	    $this->excel->getActiveSheet()->getStyle("D{$contador}")->getFont()->setBold(true);
	    $this->excel->getActiveSheet()->getStyle("E{$contador}")->getFont()->setBold(true);
	   //Definimos los títulos de la cabecera.
	    $this->excel->getActiveSheet()->setCellValue("A{$contador}", 'No. Producto');	        
	    $this->excel->getActiveSheet()->setCellValue("B{$contador}", 'Nombre producto');
	    $this->excel->getActiveSheet()->setCellValue("C{$contador}", 'Precio MN');
	    $this->excel->getActiveSheet()->setCellValue("D{$contador}", 'Precio MLC');
	    $this->excel->getActiveSheet()->setCellValue("E{$contador}", 'Existencia');
	   //Definimos la data del cuerpo.    
 foreach($llamadas as $v){
         //Incrementamos una fila más, para ir a la siguiente.
         $contador++;
         //Informacion de las filas de la consulta.
		 $this->excel->getActiveSheet()->setCellValue("A{$contador}", $v->id_producto);
         $this->excel->getActiveSheet()->setCellValue("B{$contador}", $v->nombre_producto);
         $this->excel->getActiveSheet()->setCellValue("C{$contador}", $v->precio_mn);
         $this->excel->getActiveSheet()->setCellValue("D{$contador}", $v->precio_mlc);
         $this->excel->getActiveSheet()->setCellValue("E{$contador}", $v->existencia);
         }
		 //Le ponemos un nombre al archivo que se va a generar.
	        $archivo = "Combustible.xls";
	        header('Content-Type: application/vnd.ms-excel');
	        header('Content-Disposition: attachment;filename="'.$archivo.'"');
	        header('Cache-Control: max-age=0');
	        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel7'); 
        //Hacemos una salida al navegador con el archivo Excel.
        $objWriter->save('php://output');
     	
}  
}

}

/*
End of file c_gestionar.php
Location: ./application/controllers/c_gestionar.php
*/ 
?>
