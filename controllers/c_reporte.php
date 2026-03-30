<?php
class c_reporte extends CI_Controller {
   public function __construct(){
      parent::__construct();     
      $this->load->database();
      $this->load->model('m_reporte','reporte');
      $this->load->library('table','grocery_CRUD');
	  $this->load->library('excel');
      $this->load->library('ciqrcode');
      // $this->output->enable_profiler(TRUE);
   }

     function prueba(){
        $valor='1235,145';
        round($valor, 2);
        echo "<pre>";       
        print_r($valor);
        echo "</pre>";}
    
		function control_combustible($date_start='0000-00-00',$date_end='0000-00-00'){
				$permiso='consumo_diesel';
				$this->permisos($permiso);
				  $date_start=$this->input->post('date_start');
				  if(!$date_start)$date_start='CURRENT_TIMESTAMP';
				  $equipo=$this->input->post('producto');
				  $date_end=$this->input->post('date_end');   
				  if(!$date_end)$date_end='CURRENT_TIMESTAMP';
				  
				  $this->input->post('date_end');
				  $existencia=$this->reporte->combustible_tecnol($date_start,$date_end)->result();
				  $existencia= json_decode(json_encode($existencia), true);
                  $existencia2=$this->reporte->combustible_tecnol2($date_start,$date_end)->result();
				  $existencia2= json_decode(json_encode($existencia2), true);
				  $existencia3=$this->reporte->combustible_tecnol3($date_start,$date_end)->result();
				  $existencia3= json_decode(json_encode($existencia3), true);
				  $existencia4=$this->reporte->combustible_tecnol4($date_start,$date_end)->result();
				  $existencia4= json_decode(json_encode($existencia4), true);
				  $existencia=array_merge($existencia,$existencia2,$existencia3,$existencia4);
			      unset($existencia2,$existencia3,$existencia4);
               //organizando datos     
			  $j=0;$nuevo=[];$contador=0;$cantidad='';
				  for($i=0;$i<count($existencia);$i++){
					  if($i>0){if($existencia[$i]['id_vale']!=$existencia[$i-1]['id_vale']){$j++;$contador=0;}}
					  if($contador==0){
							$nuevo[$j]['id_vale']= $existencia[$i]['id_vale'];								
							$nuevo[$j]['fecha_vale']=$existencia[$i]['fecha_vale'];
						    if($existencia[$i]['entrada']==''){
								$nuevo[$j]['entrada']='';
						        $nuevo[$j]['salida']='X';
								$cantidad='salida';
							  }
							else{$nuevo[$j]['entrada']='X';
						         $nuevo[$j]['salida']='';
								 $cantidad='entrada';
								}
						    $nuevo[$j]['nombre_equipo']=$existencia[$i]['nombre_equipo'];
						    $nuevo[$j]['no_centro_costo']=$existencia[$i]['no_centro_costo'];
						    $nuevo[$j]['no_solicitud_compra']=$existencia[$i]['no_solicitud_compra'];
							$contador++;
					  }
					//Buscar elementos específicos por nombre
					$name='DIES';$name2='MOTOR';$name3='HID';$name4='TRANSMI';$name5='GUIJO';$name6='GRASA';$name7='SUPER';
					//$dies= strpos()
					
					if(strpos($existencia[$i]['nombre_producto'], $name)!==FALSE){$nuevo[$j]['diesel']=$existencia[$i][$cantidad];}
					if(strpos($existencia[$i]['nombre_producto'], $name2)!==FALSE || strpos($existencia[$i]['nombre_producto'], $name7)!==FALSE)
					{$nuevo[$j]['ac_motor']=$existencia[$i][$cantidad];}
					if(strpos($existencia[$i]['nombre_producto'], $name3)!==FALSE){$nuevo[$j]['ac_hidraulico']=$existencia[$i][$cantidad];}
					if(strpos($existencia[$i]['nombre_producto'], $name4)!==FALSE){$nuevo[$j]['ac_transmicion']=$existencia[$i][$cantidad];}
					if(strpos($existencia[$i]['nombre_producto'], $name5)!==FALSE){$nuevo[$j]['ac_guijo']=$existencia[$i][$cantidad];}
					if(strpos($existencia[$i]['nombre_producto'], $name6)!==FALSE){$nuevo[$j]['grasa']=$existencia[$i][$cantidad];}
				  }
				  //$nombre_producto=$existencia[0]['nombre_producto'];
				  foreach ($nuevo as $key => $row){
					 $aux[$key] = $row['fecha_vale'];
				  }
				  array_multisort($aux, SORT_ASC, $nuevo);
				  $existencia= json_decode(json_encode($nuevo), false);
				  		  
				  $this->table->set_heading('Fecha',utf8('Equipo'),'Entrada','Salida','Diesel','AC Motor','AC Hidraulico','AC Transmisión','AC Guijo','Grasa','Centro Costo','Solicitud Materiales','No Vale');
			   
				  $this->table->set_empty("-");
				  foreach ($existencia as $v)
				  { 
				   $this->table->add_row($v->fecha_vale,$v->nombre_equipo,$v->entrada,$v->salida,$v->diesel,$v->ac_motor,$v->ac_hidraulico,$v->ac_transmicion,$v->ac_guijo,$v->grasa,$v->no_centro_costo,$v->no_solicitud_compra,$v->id_vale);  
				  }   
					 
				  $data_form['action']=base_url('index.php/c_reporte/control_combustible');
				  $data_form['value_date_start']=$date_start;
				  $data_form['value_date_end']=$date_end;
				  $data['title_report']="CONTROL DE ENTRADA Y SALIDA DE COMBUSTIBLE:";
				  $data['head']=$this->load->view('form_periodo_control_producto', $data_form,true);  
				  $data['table']=$this->table->generate();
				  $data['footer']="<div><strong>Este reporte es generado por Yolexis_system</strong>";
				  $this->load->view('v_report_template', $data);
			  }
			  
    function crear_qr(){
        $valores=$this->input->post('valores');
        //$this->input->post('valores');
        
        if ($valores!=''){
        $user=$this->session->userdata('useralias');
        
        $params['data'] = $valores;
        $params['level'] = 'H';
        $params['size'] = 10;
        $dir="C:/Users/Public/Pictures/";

        if (!file_exists($dir)) {mkdir($dir);}

        $params['savename'] = $dir."codigo_generado.png";
        $this->ciqrcode->generate($params);

        echo "<script>alert('Código QR creado en C:/Users/Public/Pictures/codigo_generado.png, cámbiele el nombre para que no sea sobrescrito.')</script>";
        redirect('c_reporte/crear_qr', 'refresh');
        //domxml_open_file('C:/Users/Public/Pictures/codigo_generado.png');
        }
        
        $data_form['action']=base_url('index.php/c_reporte/crear_qr');
        $data_form['value_valores']=$valores;
        $data['title_report']=utf8('Crear codigos QR');
        $data['head']=$this->load->view('form_qr', $data_form,true);  
        $data['table']=$valores;
        $data['footer']="<div><strong>Nota:</strong> Escriba el texto que desea guardar en el código QR, tenga en cuenta que si el texto es demasiado extenso puede ser ilegible el código. ";
        $this->load->view('v_report_template_qr', $data);
    }

   function escaner(){
        $this->load->view('escaner');
        }
    //Realizar solicitud de materiales
    function solicitud_mat(){
            $this->load->view('escaner_seg');
        }

    function escaner_seg(){
            $user=$this->session->userdata('useralias');
            $permiso='vale_entrega_detallar';
            $this->permisos($permiso);
            $codigo=$this->input->post('codigoqr');
         
           $this->db->select('codigoqr');
        $this->db->where('alias_usuario', $user); 
        $valor=$this->db->get('usuarios')->row();
        if ($valor->codigoqr!=$codigo){
             echo "<script>alert('Su codigo QR no es correcto');</script>";
            redirect('/c_global/home/', 'refresh');}
         else{
            $this->control_ordenes();
           }   
        }

    //Ordenes de trabajo
  function control_ordenes($date_start='0000-00-00',$date_end='0000-00-00'){
  $permiso='ordenes_ver';
        $this->permisos($permiso);
        $date_start=$this->input->post('date_start');
        if(!$date_start)$date_start='CURRENT_TIMESTAMP';
        $date_end=$this->input->post('date_end');   
        if(!$date_end)$date_end='CURRENT_TIMESTAMP';
        //Borra tabla temp
        $user=$this->session->userdata('useralias');
        $this->db->delete('temp_vales', array('alias' => $user));

        $this->input->post('date_end');
        $ordenes=$this->reporte->resumen_ordenes3($date_start,$date_end)->result();
        $ordenes= json_decode(json_encode($ordenes), true);
        $ordenes2=$this->reporte->resumen_ordenes4($date_start,$date_end)->result();
        $ordenes2= json_decode(json_encode($ordenes2), true);
        $equipo=$this->reporte->equipos_zona3($date_start,$date_end)->result();

        $original=array_merge($ordenes,$ordenes2,$equipo);
        $original = json_decode(json_encode($original), true);
        $result = array();
        foreach($original as $t) {
        $repeat=false;
        for($i=0;$i<count($result);$i++)
        {
        if($result[$i]['no_orden']==$t['no_orden'])
        {
         $result[$i]['importe2']+=$t['importe2'];
         $result[$i]['equipo']=$t['equipo'];
         $repeat=true;
        break;
        }
        }
         if($repeat==false)
         $result[] = array('no_centro_costo' => $t['no_centro_costo'], 'nombre_centro_costo' => $t['nombre_centro_costo'], 'emision' => $t['emision'], 'estado' => $t['estado'], 'fecha_final' => $t['fecha_final'], 'descripcion_ordenes' => $t['descripcion_ordenes'], 'no_orden' => $t['no_orden'], 'importe' => $t['importe'], 'importe2' => $t['importe2'], 'equipo' => $t['equipo']);
        }
   
        
        //ordenar
        foreach ($result as $key => $row){
           $aux[$key] = $row['emision'];
        }
        array_multisort($aux, SORT_DESC, $result);
        $result= json_decode(json_encode($result), false);
                
        $this->table->set_heading('# orden',utf8('Area'),'Equipo','Fecha inicio','Fecha terminado','Centro Costo','Tipo de reparacion','Mano obra','Materiales','Total','Estado');
        $this->table->set_empty("-");
        
        foreach ($result as $v)
        { 
        $this->table->add_row($v->no_orden,$v->nombre_centro_costo,$v->equipo,$v->emision,$v->fecha_final,$v->no_centro_costo,$v->descripcion_ordenes,$v->importe,$v->importe2,$v->importe+$v->importe2,$v->estado);
        }

         //Actualizar tabla temporal
         foreach ($result as $v)
            { 
          $datos = array( 'alias' => $user, 'importe_mlc' => $v->importe,'importe_mn' => $v->importe2,'nombre_centro_costo' => $v->nombre_centro_costo,'no_centro_costo' => $v->no_centro_costo,'id_orden' => $v->no_orden,'fecha2' => $v->fecha_final,'fecha1' => $v->emision,'descripcion'=>$v->descripcion_ordenes,'receptor'=>$v->equipo);
          $this->db->insert('temp_vales', $datos,''); 
            }
               
        $data_form['action']=base_url('index.php/c_reporte/control_ordenes');
        $data_form['value_date_start']=$date_start;
        $data_form['value_date_end']=$date_end;
        $data['title_report']=utf8('Control de Orden de Trabajo');
        $data['head']=$this->load->view('form_periodo', $data_form,true);  
        $data['table']=$this->table->generate();
        $data['footer']="<div><strong>Este reporte es generado por Yolexis_system</strong>";
        $this->load->view('v_report_template_ordenes2', $data);
    }
	
	function relacion_ordenes(){
  $permiso='ordenes_ver';
        $this->permisos($permiso);
        $centro_costo=$this->input->post('centro_costo');
        
        $ordenes=$this->reporte->relacion_ordenes($centro_costo)->result();        

        $this->table->set_heading('No Orden','Fecha','Descripción','Estado');
       
        foreach ($ordenes as $v)
        { 
        $this->table->add_row($v->no_orden,$v->fecha_orden,$v->descripcion_ordenes,$v->estado,
		"<td><a href='../c_gestionar/ordenes/add/'><button type='button' class='btn btn-success'>Añadir Orden</button></a></td>");
        }
                     
        $data_form['action']=base_url('index.php/c_reporte/relacion_ordenes');
        $data_form['value_centro_costo']=$centro_costo;
        $data['title_report']=('Relación de Ordenes de Trabajo ');
        $data['head']=$this->load->view('form_ordenes_trabajo', $data_form,true);  
        $data['table']=$this->table->generate();
        $data['footer']="<div><strong>Este reporte es generado por Yolexis_system</strong>";
        $this->load->view('v_report_template_ordenes2', $data);
    }
    
  function resumen_ordenes($id_orden){
  $permiso='ordenes_ver';
    $this->permisos($permiso);
    
    $user=$this->session->userdata('useralias');
    $this->db->delete('temp_vales', array('alias' => $user));

    $ordenes=$this->reporte->resumen_ordenes($id_orden)->result();
    $equipo=$this->reporte->equipos_zona2($id_orden)->result();
    $ordenes=json_decode(json_encode($ordenes), true);
    $equipo=json_decode(json_encode($equipo), true);
    
    $ordenes[0]['equipo']=$equipo[0]['nombre_equipo'];
   
   
    $ordenes=json_decode(json_encode($ordenes));
    foreach ($ordenes as $v)
            { 
          $datos = array( 'alias' => $user, 'importe_mlc' => $v->importe,'importe_unitario' => $v->tarifa,'no_centro_costo' => $v->no_centro_costo,'id_orden' => $v->no_orden,'receptor' => $v->nombre_persona,'despachador' => $v->nombre_cargo, 'fecha3' => $v->fecha3,'fecha1' => $v->fecha_final,'fecha2' => $v->emision,'descripcion' => $v->descripcion_ordenes,'bultos' => $v->hora, 'nombre_centro_costo' => $v->equipo);
          $this->db->insert('temp_vales', $datos,''); 
            }

    $ordenes= json_decode(json_encode($ordenes), true);
    $subtotal=0;$subtotal2=0;

    for ($i=0; $i < count($ordenes); $i++) { 
      $subtotal+=$ordenes[$i]['importe'];
    }
    $q=count($ordenes);
    $ordenes2=$this->reporte->resumen_ordenes2($id_orden)->result();
    $ordenes2=json_decode(json_encode($ordenes2), true);
    for ($i=0; $i < count($ordenes2); $i++) { 
       round($ordenes2[$i]['importe']=$ordenes2[$i]['cantidad']*$ordenes2[$i]['precio_mn'], 3);
    }
    $ordenes2=json_decode(json_encode($ordenes2));
    foreach ($ordenes2 as $v)
            { 
          $datos = array( 'alias' => $user, 'nombre_producto'=>$v->nombre_producto,'cantidad' => $v->cantidad, 'precio_mn' => $v->precio_mn,'fecha_vale' => $v->fecha_vale, 'importe_mlc' => $v->importe, 'consecutivo' => $v->consecutivo, 'unidad_medida' => $v->unidad_medida);
          $this->db->insert('temp_vales', $datos,''); 
            }
    $ordenes2= json_decode(json_encode($ordenes2), true);
    
    for ($i=0; $i < count($ordenes2); $i++) { 
      $subtotal2+=$ordenes2[$i]['importe'];
    }
    $total=$subtotal+$subtotal2; 
    
    $ordenes=array_merge($ordenes,$ordenes2);
    
    $this->table->set_heading('No',utf8('Nombre'),'Espec./No. vale','Fecha','Horas/Cantidad','Tarifa/Precio','Importe');
      $this->table->set_empty("-");
    $i=0; $no_orden=$ordenes[0]['no_orden'];
    $ordenes= json_decode(json_encode($ordenes), false);

    //Actualizar tabla temporal
    
    foreach ($ordenes as $v)
    { $i++;
    if ($i<=$q) {$this->table->add_row( $i,$v->nombre_persona,$v->nombre_cargo,$v->fecha,$v->hora,$v->tarifa,$v->importe);}
    else{$this->table->add_row( $i,$v->nombre_producto,$v->consecutivo,$v->fecha_vale,$v->cantidad,$v->precio_mn,$v->importe);}
    }
     $this->table->add_row('','','','','','<strong>Subtotal MO</strong>','<div style="text-align:left"><strong>'.$subtotal.'</strong></div>','<div style="text-align:left"><strong>');          
     $this->table->add_row('','','','','','<strong>Subtotal Pro</strong>','<div style="text-align:left"><strong>'.$subtotal2.'</strong></div>','<div style="text-align:left"><strong>');
     $this->table->add_row('','','','','','<strong>Total</strong>','<div style="text-align:left"><strong>'.$total.'</strong></div>','<div style="text-align:left"><strong>');  
    $data['title_report']="Resumen de orden de trabajo $no_orden";
     $data['head']="Fuerza de trabajo y materiales utilizados";  
    $data['table']=$this->table->generate();
    $data['footer']="<div><strong>Este reporte es generado por Yolexis_system</strong>";
    $this->load->view('v_report_template_ordenes', $data);
  }

  
    //Rotación y otros movimientos
   function preparar_rotacion($id_rotacion){
	$permiso='rotacion';
		$this->permisos($permiso);
		$array=$this->reporte->rotacion($id_rotacion)->result();
		$productos=$this->reporte->todos_productos()->result();
        $this->table->set_heading('Almacén','Destino','No Producto','No prod. destino','Nombre producto','Precio MN','Precio MLC','Cantidad a rotar','Existencia');	   	
		$this->table->set_empty("-");
		foreach ($array as $v)
        { 
		 $this->table->add_row($v->almacen,$v->destino,$v->id_producto,$v->numero_en_destino,$v->nombre_producto,$v->precio_mn,$v->precio_mlc,$v->cantidad,$v->existencia);	
        }	
		
		$array=json_decode(json_encode($array), true);
        $productos=json_decode(json_encode($productos), true);

        for ($i=0; $i < count($array); $i++) {
            for ($j=0; $j < count($productos); $j++) { 
             	if ($array[$i]['numero_en_destino']==$productos[$j]['id_producto']) {
             		$array[$i]['bandera']=1;
             	}
             } 
        }

        for ($i=0; $i < count($array); $i++) { 
        	if ($array[$i]['bandera']!==1) {
        		if ($array[$i]['numero_en_destino']!=='') {
        		$prod=$array[$i]['numero_en_destino'];
                echo "<script>alert('!!!ERROR!!! El producto ($prod) no existe. Revise los números de destino o cree el nuevo producto');</script>";
                redirect('c_gestionar/rotacion', 'refresh');	
        		}
               	}
            }

        $data['title_report']=utf8('Otros movimientos de productos');
		$data['head']= "Fecha del movimiento: $v->fecha";  
		$data['table']=$this->table->generate();
		$data['footer']="<td><a href='../../c_gestionar/rotacion/edit/$id_rotacion'><button type='button' class='fa fa-sign-in'>Editar</button></a> <a href='../ejecutar_rotacion/$id_rotacion'><button type='button' class='btn btn-success'>Ejecutar</button></a></td>";
		$this->load->view('v_report_template', $data);	
	}	
	
	function ejecutar_rotacion($id_rotacion){
	$permiso='rotacion';
		$this->permisos($permiso);
		$array=$this->reporte->rotacion($id_rotacion)->result();		
		$productos=$this->reporte->todos_productos()->result();
       
        //Validando datos		
        foreach ($array as $v) {
        	if ($v->destino!=='otros' and $v->numero_en_destino=='') {
        		echo "<script>alert('!!!Error!!! En el producto $v->nombre_producto con código $v->id_producto tiene un destino asignado pero no un número de producto o dejó el escaque destino vacío');</script>";
        		redirect('c_gestionar/rotacion', 'refresh');
        	}

        	if ($v->existencia<$v->cantidad) {
        		echo "<script>alert('!!!Error!!! En el producto $v->nombre_producto con código $v->id_producto la cantidad a procesar es mayor que la existencia');</script>";
        		redirect('c_gestionar/rotacion', 'refresh');
        	}

        	if ($v->estado=='rotado') {
        		echo "<script>alert('!!!Error!!! Esta rotación se ha hecho anteriormente');</script>";
        		redirect('c_gestionar/rotacion', 'refresh');
        	}
        	
        	if ($v->almacen==$v->destino) {
        		echo "<script>alert('!!!Error!!! En el producto $v->nombre_producto con código $v->id_producto el origen y el destino son los mismos');</script>";
        		redirect('c_gestionar/rotacion', 'refresh');
        	}

        	if ($v->id_producto==$v->numero_en_destino) {
        		echo "<script>alert('!!!Error!!! En el producto $v->nombre_producto con número $v->id_producto los códigos de origen y destino son los mismos');</script>";
        		redirect('c_gestionar/rotacion', 'refresh');
        	}
        }

        $array=json_decode(json_encode($array), true);
        $productos=json_decode(json_encode($productos), true);
        //update data base
        //Deduce de almacén del INRE
        $p=0;
        for ($i=0; $i < count($array); $i++){
            for ($j=0; $j < count($productos); $j++) {
               	if ($array[$i]['id_producto']==$productos[$j]['id_producto'] and $array[$i]['almacen']=='698' || $array[$i]['almacen']=='700') {
               		
               		$query[$p]['id_producto']=$productos[$j]['id_producto'];
             		$query[$p]['existencia']=$productos[$j]['existencia']-$array[$i]['cantidad'];
             		$query[$p]['precio_mn']=$productos[$j]['precio_mn'];
             		$query[$p]['precio_mlc']=$productos[$j]['precio_mlc'];
             		$productos[$j]['existencia']=$query[$p]['existencia'];
             		$p++;
               	}
			}
        }
       for ($p=0; $p < count($query); $p++) { 
        	 $data2 = array('existencia' => $query[$p]['existencia'],'precio_mn' => $query[$p]['precio_mn'],'precio_mlc' => $query[$p]['precio_mlc']);
			        $this->db->update('productos', $data2, array('id_producto' => $query[$p]['id_producto']));
		}
		unset($query,$data2);

        //Ingresa a almacenes corrientes
		$p=0;
        for ($i=0; $i < count($array); $i++){
            for ($j=0; $j < count($productos); $j++) {
               	if ($array[$i]['numero_en_destino']==$productos[$j]['id_producto'] and $array[$i]['destino']=='695' || $array[$i]['destino']=='699') {
             	    $query[$p]['id_producto']=$productos[$j]['id_producto'];
             		$query[$p]['existencia']=$productos[$j]['existencia']+$array[$i]['cantidad'];
             		$query[$p]['precio_mn']=(($productos[$j]['precio_mn']*$productos[$j]['existencia'])+($array[$i]['cantidad']*$array[$i]['precio_mn']))/($productos[$j]['existencia']+$array[$i]['cantidad']);
             		$query[$p]['precio_mlc']=(($productos[$j]['precio_mlc']*$productos[$j]['existencia'])+($array[$i]['cantidad']*$array[$i]['precio_mlc']))/($productos[$j]['existencia']+$array[$i]['cantidad']);
             		$productos[$j]['existencia']=$query[$p]['existencia'];
             		$productos[$j]['precio_mn']=$query[$p]['precio_mn'];
             		$productos[$j]['precio_mlc']=$query[$p]['precio_mlc'];
             		$p++;
             	}
            }
        }

       for ($p=0; $p < count($query); $p++) { 
        	 $data2 = array('existencia' => $query[$p]['existencia'],'precio_mn' => $query[$p]['precio_mn'],'precio_mlc' => $query[$p]['precio_mlc']);
			        $this->db->update('productos', $data2, array('id_producto' => $query[$p]['id_producto']));
		}
		unset($query,$data2);
		 
        //Deduce de almacén corriente
        $p=0;
        for ($i=0; $i < count($array); $i++){
            for ($j=0; $j < count($productos); $j++) {
               	if ($array[$i]['id_producto']==$productos[$j]['id_producto'] and $array[$i]['almacen']=='695' || $array[$i]['almacen']=='699') {
               		
               		$query[$p]['id_producto']=$productos[$j]['id_producto'];
             		$query[$p]['existencia']=$productos[$j]['existencia']-$array[$i]['cantidad'];
             		$query[$p]['precio_mn']=$productos[$j]['precio_mn'];
             		$query[$p]['precio_mlc']=$productos[$j]['precio_mlc'];
             		$productos[$j]['existencia']=$query[$p]['existencia'];
             		$p++;
               	}
			}
        }
       for ($p=0; $p < count($query); $p++) { 
        	 $data2 = array('existencia' => $query[$p]['existencia'],'precio_mn' => $query[$p]['precio_mn'],'precio_mlc' => $query[$p]['precio_mlc']);
			        $this->db->update('productos', $data2, array('id_producto' => $query[$p]['id_producto']));
		}
		unset($query,$data2);

       //Ingresa a almacenes INRE
		$p=0;
        for ($i=0; $i < count($array); $i++){
            for ($j=0; $j < count($productos); $j++) {
               	if ($array[$i]['numero_en_destino']==$productos[$j]['id_producto'] and $array[$i]['destino']=='698' || $array[$i]['destino']=='700') {
             	    $query[$p]['id_producto']=$productos[$j]['id_producto'];
             		$query[$p]['existencia']=$productos[$j]['existencia']+$array[$i]['cantidad'];
             		$query[$p]['precio_mn']=(($productos[$j]['precio_mn']*$productos[$j]['existencia'])+($array[$i]['cantidad']*$array[$i]['precio_mn']))/($productos[$j]['existencia']+$array[$i]['cantidad']);
             		$query[$p]['precio_mlc']=(($productos[$j]['precio_mlc']*$productos[$j]['existencia'])+($array[$i]['cantidad']*$array[$i]['precio_mlc']))/($productos[$j]['existencia']+$array[$i]['cantidad']);
             		$productos[$j]['existencia']=$query[$p]['existencia'];
             		$productos[$j]['precio_mn']=$query[$p]['precio_mn'];
             		$productos[$j]['precio_mlc']=$query[$p]['precio_mlc'];
             		$p++;
             	}
            }
        }

       for ($p=0; $p < count($query); $p++) { 
        	 $data2 = array('existencia' => $query[$p]['existencia'],'precio_mn' => $query[$p]['precio_mn'],'precio_mlc' => $query[$p]['precio_mlc']);
			        $this->db->update('productos', $data2, array('id_producto' => $query[$p]['id_producto']));
		}
		unset($query,$data2);
         
        $k=0;
        for ($i=0; $i < count($array); $i++) { 
			for ($p=0; $p < count($productos); $p++) { 
				if ($array[$i]['id_producto']==$productos[$p]['id_producto']) {
                    $query2[$k]['id_rotacion']=$array[$i]['id_rotacion'];
				    $query2[$k]['no_producto']=$productos[$p]['no_producto'];
             	    $query2[$k]['existencia']=$productos[$p]['existencia']-$array[$i]['cantidad'];
             	    $query2[$k]['precio_mn']=$productos[$p]['precio_mn'];
             	    $query2[$k]['precio_mlc']=$productos[$p]['precio_mlc'];
             	
				if ($array[$i]['numero_en_destino']!=='') {
					$prod=$array[$i]['numero_en_destino'];
				    $producto_dest=$this->reporte->producto_dest($prod)->result();
					$producto_dest=json_decode(json_encode($producto_dest), true);

               	    $query2[$k]['existencia_d']=$producto_dest[0]['existencia']+$array[$i]['cantidad'];
             	    $query2[$k]['precio_mn_d']=(($producto_dest[0]['precio_mn']*$producto_dest[0]['existencia'])+($array[$i]['cantidad']*$array[$i]['precio_mn']))/($producto_dest[0]['existencia']+$array[$i]['cantidad']);
             		$query2[$k]['precio_mlc_d']=(($producto_dest[0]['precio_mlc']*$producto_dest[0]['existencia'])+($array[$i]['cantidad']*$array[$i]['precio_mlc']))/($producto_dest[0]['existencia']+$array[$i]['cantidad']);
                }
                $k++;
              }
			}
		}
        
		for ($p=0; $p < count($query2); $p++) { 
			$data = array('existencia' => $query2[$p]['existencia'],'precio_mn' => $query2[$p]['precio_mn'],'precio_mlc' => $query2[$p]['precio_mlc'],'existencia_d' => $query2[$p]['existencia_d'],'precio_mn_d' => $query2[$p]['precio_mn_d'],'precio_mlc_d' => $query2[$p]['precio_mlc_d']);
			 $this->db->update('rotacion_producto', $data, array('id_rotacion' => $array[$p]['id_rotacion'],'no_producto' => $query2[$p]['no_producto']));
		}
      
		     $data2 = array('estado' => 'rotado');
			 $this->db->update('rotacion', $data2, array('id_rotacion' => $array[0]['id_rotacion']));

			 echo "<script>alert('Se a efectuado la rotación satisfactoriamente');</script>";
			 redirect('c_gestionar/rotacion', 'refresh');
    }
	
	
   //Consultas
    function trazabilidad_productos($date_start='0000-00-00',$date_end='0000-00-00'){
  $permiso='consultor';
        $this->permisos($permiso);
        $centro_costo=$this->input->post('centro_costo');
        $centro=$centro_costo;
        $producto=$this->input->post('producto');
        $date_start=$this->input->post('date_start');
        if(!$date_start)$date_start='CURRENT_TIMESTAMP';
        $date_end=$this->input->post('date_end');   
        if(!$date_end)$date_end='CURRENT_TIMESTAMP';
        
        if ($centro_costo!='') {
            $cc=$this->reporte->centro_costo($centro_costo)->result();
            $cc= json_decode(json_encode($cc), true);
            if ($cc[0]['id_centro_costo']=='') {
              echo "<script>alert('El centro de costo $centro_costo no existe')</script>";
              $cc[0]['id_centro_costo']=999999;
            }
            $centro_costo=$cc[0]['id_centro_costo'];
        }

        $this->input->post('date_end');
        if ($centro_costo=='') {
        $existencia=$this->reporte->trazabilidad_productos($date_start,$date_end,$producto)->result();
        $existencia= json_decode(json_encode($existencia), true);
        
        $existencia2=$this->reporte->trazabilidad_productos2($date_start,$date_end,$producto)->result();
        $existencia2= json_decode(json_encode($existencia2), true);
        
        $existencia3=$this->reporte->trazabilidad_productos3($date_start,$date_end,$producto)->result();
        $existencia3= json_decode(json_encode($existencia3), true);
        
        $existencia4=$this->reporte->trazabilidad_productos4($date_start,$date_end,$producto)->result();
        $existencia4= json_decode(json_encode($existencia4), true);
        
        $existencia5=$this->reporte->trazabilidad_productos5($date_start,$date_end,$producto)->result();
        $existencia5= json_decode(json_encode($existencia5), true);
        
        $existencia6=$this->reporte->trazabilidad_productos6($date_start,$date_end,$producto)->result();
        $existencia6= json_decode(json_encode($existencia6), true);

		$existencia7=$this->reporte->trazabilidad_productos7($date_start,$date_end,$producto)->result();
        $existencia7= json_decode(json_encode($existencia7), true);
		
        for($i=0;$i<count($existencia);$i++){$existencia[$i]['tipo_vale']='Entrega';$existencia[$i]['direccion']='report_00';}
        for($i=0;$i<count($existencia2);$i++){$existencia2[$i]['tipo_vale']='Devolución';$existencia2[$i]['direccion']='report_02';}
        for($i=0;$i<count($existencia3);$i++){$existencia3[$i]['tipo_vale']='Transferencia';$existencia3[$i]['direccion']='report_03';}
        for($i=0;$i<count($existencia4);$i++){$existencia4[$i]['tipo_vale']='Recepción';$existencia4[$i]['direccion']='report_01';}
        for($i=0;$i<count($existencia5);$i++){$existencia5[$i]['tipo_vale']='Útiles';$existencia5[$i]['direccion']='report_u';}
        for($i=0;$i<count($existencia6);$i++){$existencia6[$i]['tipo_vale']='Medios básicos';$existencia6[$i]['direccion']='report_m';}
        for($i=0;$i<count($existencia7);$i++){$existencia7[$i]['tipo_vale']='Fact. Transf.';$existencia7[$i]['direccion']='detallar_factura_transferencia';
		                                      $existencia7[$i]['fecha_vale']=$existencia7[$i]['fecha_factura'];}
        $existencia=array_merge($existencia,$existencia2,$existencia3,$existencia4,$existencia5,$existencia6,$existencia7);
        }
        else
        {$existencia=$this->reporte->trazabilidad_productos0($date_start,$date_end,$producto,$centro_costo)->result();
        $existencia= json_decode(json_encode($existencia), true);
                
        $existencia5=$this->reporte->trazabilidad_productos05($date_start,$date_end,$producto,$centro_costo)->result();
        $existencia5= json_decode(json_encode($existencia5), true);
        
        $existencia6=$this->reporte->trazabilidad_productos06($date_start,$date_end,$producto,$centro_costo)->result();
        $existencia6= json_decode(json_encode($existencia6), true);

		for($i=0;$i<count($existencia);$i++){$existencia[$i]['tipo_vale']='Entrega';$existencia[$i]['direccion']='report_00';}
        for($i=0;$i<count($existencia5);$i++){$existencia5[$i]['tipo_vale']='Útiles';$existencia5[$i]['direccion']='report_u';}
        for($i=0;$i<count($existencia6);$i++){$existencia6[$i]['tipo_vale']='Medios básicos';$existencia6[$i]['direccion']='report_m';}
		$existencia=array_merge($existencia,$existencia5,$existencia6);
        }
        
        
        //ordenar
        foreach ($existencia as $key => $row){
           $aux[$key] = $row['fecha_vale'];
        }
        array_multisort($aux, SORT_DESC, $existencia);

        if (count($existencia)==0 and $centro_costo!=999999 and $centro!='') {echo "<script>alert('El centro de costo $centro no tiene consumo del producto $producto en el intervalo de tiempo dado.')</script>";}

        $existencia= json_decode(json_encode($existencia), false);
                
        $this->table->set_heading('No producto',utf8('Nombre producto'),'Fecha','Tipo Vale','Consecutivo','Cantidad','Existencia');
        $this->table->set_empty("-");
        foreach ($existencia as $v)
        { 
        $this->table->add_row($v->id_producto,$v->nombre_producto,$v->fecha_vale,$v->tipo_vale,$v->consecutivo,$v->cantidad,$v->existencia,
        "<td><a href='$v->direccion/$v->id_vale'><button type='button' class='btn btn-success'>Ver vale</button></a></td>");
        }
               
        $data_form['action']=base_url('index.php/c_reporte/trazabilidad_productos');
        $data_form['value_producto']=$producto;
        $data_form['value_centro_costo']=$centro;
        $data_form['value_date_start']=$date_start;
        $data_form['value_date_end']=$date_end;
        $data['title_report']=utf8('Para ver los movimientos realizados de un producto determinado ingrese el numero del producto y el intervalo de tiempo deseado, estos datos son obligatorios, además puede ingresar un número de Centro de Costo para ver el consumo de este producto en el Centro de Costo.');
        $data['head']=$this->load->view('form_trazabilidad_producto', $data_form,true);  
        $data['table']=$this->table->generate();
        $data['footer']="<div><strong>Este reporte es generado por Yolexis_system</strong>";
        $this->load->view('v_report_template', $data);
    }
    
    function trazabilidad_equipo_e($date_start='0000-00-00',$date_end='0000-00-00'){
  $permiso='consultor';
        $this->permisos($permiso);
        $producto=$this->input->post('producto');
        $equipo=$this->input->post('equipo');
        $date_start=$this->input->post('date_start');
        if(!$date_start)$date_start='CURRENT_TIMESTAMP';
        $date_end=$this->input->post('date_end');   
        if(!$date_end)$date_end='CURRENT_TIMESTAMP';
        
        $this->input->post('date_end');
        if ($producto=='') {
        $existencia=$this->reporte->trazabilidad_equipos_e($date_start,$date_end,$equipo)->result();
        }
        else{$existencia=$this->reporte->trazabilidad_equipos_e2($date_start,$date_end,$equipo,$producto)->result();
        }
        $existencia= json_decode(json_encode($existencia), true);
        
        //ordenar
        foreach ($existencia as $key => $row){
           $aux[$key] = $row['fecha_vale'];
        }
        array_multisort($aux, SORT_DESC, $existencia);
        $existencia= json_decode(json_encode($existencia), false);
        
        $this->table->set_heading(utf8('Nombre Equipo'),'Fecha', 'Consecutivo','Cantidad','U/M','No Producto','Nombre Producto','Centro Costo');
     
        $this->table->set_empty("-");
        foreach ($existencia as $v)
        { 
         $this->table->add_row($v->nombre_equipo,$v->fecha_vale,$v->consecutivo,$v->cantidad,$v->unidad_medida,$v->id_producto,$v->nombre_producto,$v->no_centro_costo);    
        }   
           
        $data_form['action']=base_url('index.php/c_reporte/trazabilidad_equipo_e');
        $data_form['value_equipo']=$equipo;
        $data_form['value_producto']=$producto;
        $data_form['value_date_start']=$date_start;
        $data_form['value_date_end']=$date_end;
        $data['title_report']=utf8('Trazabilidad de consumo de equipos por intervalo de fecha');
        $data['head']=$this->load->view('form_consumo_equipo', $data_form,true);  
        $data['table']=$this->table->generate();
        $data['footer']="<div><strong>Este reporte es generado por Yolexis_system</strong>";
        $this->load->view('v_report_template', $data);
    }
    
    function trazabilidad_equipo_d($date_start='0000-00-00',$date_end='0000-00-00'){
  $permiso='consultor';
        $this->permisos($permiso);
        $producto=$this->input->post('producto');
        $equipo=$this->input->post('equipo');
        $date_start=$this->input->post('date_start');
        if(!$date_start)$date_start='CURRENT_TIMESTAMP';
        $date_end=$this->input->post('date_end');   
        if(!$date_end)$date_end='CURRENT_TIMESTAMP';
        
        $this->input->post('date_end');
        if ($producto=='') {
        $existencia=$this->reporte->trazabilidad_equipos_d($date_start,$date_end,$equipo)->result();
        }
        else{$existencia=$this->reporte->trazabilidad_equipos_d2($date_start,$date_end,$equipo,$producto)->result();
        }$existencia= json_decode(json_encode($existencia), true);
        
        //ordenar
        foreach ($existencia as $key => $row){
           $aux[$key] = $row['fecha_vale'];
        }
        array_multisort($aux, SORT_DESC, $existencia);
        $existencia= json_decode(json_encode($existencia), false);
        
        $this->table->set_heading(utf8('Nombre Equipo'),'Fecha', 'Consecutivo','Cantidad','U/M','No Producto','Nombre Producto','Centro Costo');
     
        $this->table->set_empty("-");
        foreach ($existencia as $v)
        { 
         $this->table->add_row($v->nombre_equipo,$v->fecha_vale,$v->consecutivo,$v->cantidad,$v->unidad_medida,$v->id_producto,$v->nombre_producto,$v->no_centro_costo);    
        }   
           
        $data_form['action']=base_url('index.php/c_reporte/trazabilidad_equipo_d');
        $data_form['value_equipo']=$equipo;
        $data_form['value_producto']=$producto;
        $data_form['value_date_start']=$date_start;
        $data_form['value_date_end']=$date_end;
        $data['title_report']=utf8('Trazabilidad de devolucion de equipos por intervalo de fecha');
        $data['head']=$this->load->view('form_consumo_equipo', $data_form,true);  
        $data['table']=$this->table->generate();
        $data['footer']="<div><strong>Este reporte es generado por Yolexis_system</strong>";
        $this->load->view('v_report_template', $data);
    }
    
    //Consultas end
	
  //vales entrega detallar
  function report_00($id_vale){
  $permiso='vale_entrega_detallar';
    $this->permisos($permiso);
    //Borra tabla temporal
    $user=$this->session->userdata('useralias');
    $this->db->delete('temp_vales', array('alias' => $user));
    
    $query=$this->reporte->vales_entrega($id_vale);
      $vales=$query->row(); 
      $desglose=$query->result();
    
    if ($vales->id_producto==''){
      echo "<script>alert('Agrege productos a este vale');</script>";
          redirect('c_gestionar/vales_entrega', 'refresh');     
      }
    
  
    $desglose=json_decode(json_encode($desglose), true);
    $this->table->set_heading('Código','Cta','Sub Cta','Descripción','UM','Cant','Precio(MN)','Precio(MLC)','Importe(MN)','Importe(MLC)','Importe','Saldo en existencia');
      
    //Cambia los valores id por nombres
    $this->db->select('id_persona,nombre_persona');
    $valor=$this->db->get('personas')->result();
    $valor=json_decode(json_encode($valor), true);
    
    for($j=0;$j<count($desglose);$j++){
        for($i=0;$i<count($valor);$i++)
        {
        if ($desglose[$j]['receptor']==$valor[$i]['id_persona'])
        {
    $desglose[$j]['receptor']=$valor[$i]['nombre_persona'];
    }
    if ($desglose[$j]['despachador']==$valor[$i]['id_persona'])
        {
    $desglose[$j]['despachador']=$valor[$i]['nombre_persona'];
    }
    }
    }
    //Seleccionar valor para clasificacion productos
    
    $valor=$this->reporte->buscar_equipo($id_vale)->result();
    $valor=json_decode(json_encode($valor), true);
    
    for($i=0;$i<count($valor);$i++){$valor[0]['nombre_equipo']=$valor[$i]['nombre_equipo'];$desglose[0]['id_equipo']=$valor[$i]['id_vale'];$desglose[0]['chapa']=$valor[$i]['chapa'];}
        
    $valor2=$this->reporte->buscar_clasificar($id_vale)->result();
    $valor2=json_decode(json_encode($valor2), true);
    
    $valor3=$this->reporte->buscar_descripcion($id_vale)->result();
    $valor3=json_decode(json_encode($valor3), true);
    
    if ($desglose[0]['id_orden2']=='0') {
        for($j=0;$j<count($desglose);$j++){
        if($desglose[0]['id_equipo']==0){$desglose[$j]['nombre_clasificar']=$valor2[0]['nombre_clasificar'];}
    else{$desglose[$j]['nombre_clasificar']=$valor[0]['nombre_equipo'];}
    }
    }
    else {
      $desglose[0]['nombre_clasificar']=$valor3[0]['descripcion_ordenes'];
    }
   /* else{
     $desglose[0]['nombre_clasificar']=$valor[0]['nombre_equipo'];  
    }*/
        
    //Genera codigo QR
    $valores=$desglose[0]['consecutivo'].'/'.$desglose[0]['id_orden'].'/'.$desglose[0]['no_solicitud_compra'];
    $this->generar_qr($valores,$user);
    
    $desglose=json_decode(json_encode($desglose));
      
    $i=0;$importe_totalmn=0;$importe_totalmlc=0;$importe_final=0;
        foreach ($desglose as $v) {
          $importe_totalmn+=$v->importe_mn;
        $importe_totalmlc+=$v->importe_mlc;++$i;
        //$importe_unitario=$V->importe_mn+$v->importe_mlc;
        $this->table->add_row($v->id_producto,$v->cta,$v->sub_cta,$v->nombre_producto,$v->unidad_medida,$v->cantidad,$v->precio_mn,$v->precio_mlc,$v->importe_mn,$v->importe_mlc,$v->importe_unitario,$v->resto);
             }
           
    $i=count($desglose);  
     if($vales->estado=='cancelado')
    {
     
      while ($i<10)
     {
     $this->table->add_row('CANCELADO','','CANCELADO','','CANCELADO','','CANCELADO','','CANCELADO','','CANCELADO',''); 
     $i++;
     }
    } 
       while ($i<10)
     {
    $this->table->add_row('-','-','-','-','-','-','-','-','-','-','-'); 
     $i++;
     }
            $importe_final=$importe_totalmn+$importe_totalmlc;      
      if(substr($importe_final,-3,1)!='.')$importe_final.='.00';
      $this->table->add_row('','','','','<strong>IMPORTE</strong>','<strong>TOTAL</strong>','<strong>DE LA</strong>','<strong>OPERACIÓN</strong>','<div style="text-align:left"><strong>'.$importe_totalmn.'</strong></div>','<div style="text-align:left"><strong>'.$importe_totalmlc.'</strong></div>','<div style="text-align:center"><strong>'.$importe_final.'</strong></div>'); 
     //Actualizar tabla temporal
    foreach ($desglose as $v)
            { 
          $datos = array( 'alias' => $user, 'id_producto' => $v->id_producto, 'nombre_producto'=>$v->nombre_producto
          ,'cantidad' => $v->cantidad, 'precio_mn' => $v->precio_mn,'precio_mlc' => $v->precio_mlc
        ,'importe_mn' => $v->importe_mn,'importe_mlc' => $v->importe_mlc,'importe_unitario' => $v->importe_unitario
        ,'unidad_medida' => $v->unidad_medida,'cta' => $v->cta,'sub_cta' => $v->sub_cta,'nombre_centro_costo' => $v->nombre_centro_costo
        ,'no_centro_costo' => $v->no_centro_costo,'fecha_vale' => $v->fecha_vale,'id_orden' => $v->id_orden,'no_solicitud_compra' => $v->no_solicitud_compra
        ,'receptor' => $v->receptor, 'resto' => $v->resto, 'despachador' => $v->despachador, 'consecutivo' => $v->consecutivo, 'clasificacion_producto' => $v->nombre_clasificar, 'chapa' => $v->chapa,'estado' => $v->estado);
          $this->db->insert('temp_vales', $datos,''); 
            }
        
    
    $data_template['vales']=$vales;   
      $data_template['table_vales']=$this->table->generate();
    
      $data['title_report']='';
    $data['head']="";    
    $data['table']=$this->load->view('vale_entrega', $data_template, true);
    $data['footer']='';
    $this->load->view('v_report_template', $data);
          
   }
   
   function contabilizar_vale_entrega($id_vale){
	    $permiso='vale_entrega_contabilizar';
		$this->permisos($permiso);	   	   
		$query=$this->reporte->existencia_entrega($id_vale);
	  	$vales=$query->row(); 
	    $desglose=$query->result();
        $year = date("Y-M-D");
		$estad=$this->reporte->consecutivo_e($year)->result();
		$estad=json_decode(json_encode($estad), true);
        $consecutivo=$estad[0]['consecutivo']+1;
		if ($vales->no_producto!== NULL){
		if ($vales->estado=='sin contabilizar' || $vales->estado==''){
		$consulta=$this->reporte->validar_vale($id_vale)->row();
		if($consulta->no_producto!==NULL){
			echo "<script>alert('!!!ERROR!!! El vale de combustible no tiene un equipo asignado.');</script>";
	        redirect('c_gestionar/vales_entrega', 'refresh');
		}
        
		//verifica que el centro de costo y el equipo sean los de la orden de trabajo
		$desglose=json_decode(json_encode($desglose), true); 
	    if ($desglose[0][id_orden]!= 0) {
			$equipo=$this->reporte->comprobar_equipo($id_vale)->result();
			$equipo=json_decode(json_encode($equipo), true);
			
			if($equipo[0][id_equipo]!=$equipo[0][id_equipo2]){
				echo "<script>alert('!!!ERROR!!! No se puede procesar el vale. El equipo asignado al vale no coincide con el de la orden de trabajo.');</script>";
				redirect('c_gestionar/vales_entrega', 'refresh', 'order by vales_entrega.estado');
			  }
			  if($equipo[0][id_centro_costo]!=$equipo[0][id_centro_costo2]){
				echo "<script>alert('!!!ERROR!!! No se puede procesar el vale. El centro de costo asignado al vale no coincide con el de la orden de trabajo.');</script>";
				redirect('c_gestionar/vales_entrega', 'refresh', 'order by vales_entrega.estado');
			  }

			}
			$desglose=json_decode(json_encode($desglose));

		$bloqueo=$this->reporte->validar_vale_2($id_vale)->result();
				
		foreach ($desglose as $p)
		{
			if ($p->importe<0 ){echo "<script>alert('¡¡¡ERROR!!! Existe un défisis en el pedido de $p->importe para el producto $p->id_producto.');</script>";
	    redirect('c_gestionar/vales_entrega', 'refresh');}		
		}
		
		foreach($bloqueo as $q){
		if($q->existencia-$q->cantidad<$q->cantidad_bloqueada){
			echo "<script>alert('!!!ERROR!!! No se puede procesar el vale. El producto $q->id_producto nombrado $q->nombre_producto está protegido y la extracción afecta el límite impuesto.');</script>";
	        redirect('c_gestionar/vales_entrega', 'refresh', 'order by vales_entrega.estado');}
		}
		
		foreach ($desglose as $v)
		{
			$query = array( 'existencia' => $v->importe);
			$this->db->update('productos', $query, array('no_producto' => $v->no_producto));
			$datos = array( 'existencia' => $v->importe, 'precio_mn'=>$v->precio_mn, 'precio_mlc'=>$v->precio_mlc);
			$this->db->update('produccion_entrega', $datos, array('no_producto' => $v->no_producto,'id_vale'=>$v->id_vale));			
		}
		$data = array('estado' => 'contabilizado','consecutivo'=>$consecutivo);
		
		$this->db->update('vales_entrega', $data, array('id_vale' => $id_vale));
		echo "<script>alert('Vale $consecutivo contabilizado');</script>";
		redirect('c_gestionar/vales_entrega', 'refresh');
	}false;
	if ($vales->estado=='contabilizado' || $vales->estado=='cancelado'){$consecutivo--; echo "<script>alert('¡¡¡ERROR!!! El vale ya está contabilizado o cancelado');</script>";
	redirect('c_gestionar/vales_entrega', 'refresh');
	}	
	}false;
	
	if ($vales->no_producto== NULL){
	echo "<script>alert('Agrege productos a este vale');</script>";
	redirect('c_gestionar/vales_entrega', 'refresh');
	}    	
   }
   
   //vales útiles detallar
	function report_u($id_vale){
	$permiso='vale_utiles_detallar';
		$this->permisos($permiso);
		//Borra tabla temporal
		$user=$this->session->userdata('useralias');
		$this->db->delete('temp_vales', array('alias' => $user));
		
		$query=$this->reporte->vales_utiles($id_vale);
	  	$vales=$query->row(); 
	    $desglose=$query->result();
		
		if ($vales->id_producto==''){
			echo "<script>alert('Agrege productos a este vale');</script>";
	        redirect('c_gestionar/vales_utiles', 'refresh');			
	   	}
		if($vales->estado=='cancelado')
		{
			$this->table->add_row('CANCELADO','','CANCELADO','','CANCELADO','','CANCELADO','','CANCELADO','','CANCELADO','');
		  $i=1;
		  while ($i<=10)
		 {
		$this->table->add_row('-','-','-','-','-','-','-','-','-','-','-');	
		 $i++;
		 }
		}
		else{
		$desglose=json_decode(json_encode($desglose), true);
		if($desglose[0]['id_orden']=='-'){$desglose[0]['receptor']=$desglose[0]['responsable'];}
		$this->table->set_heading('Código','Cta','Sub Cta','Descripción','UM','Cant','Precio(MN)','Precio(MLC)','Importe(MN)','Importe(MLC)','Importe','Saldo en existencia');
	    
		//Cambia los valores id por nombres
		$this->db->select('id_persona,nombre_persona');
		$valor=$this->db->get('personas')->result();
		$valor=json_decode(json_encode($valor), true);
		
		for($j=0;$j<count($desglose);$j++){
        for($i=0;$i<count($valor);$i++)
        {
        if ($desglose[$j]['receptor']==$valor[$i]['id_persona'])
        {
		$desglose[$j]['receptor']=$valor[$i]['nombre_persona'];
		}
		if ($desglose[$j]['despachador']==$valor[$i]['id_persona'])
        {
		$desglose[$j]['despachador']=$valor[$i]['nombre_persona'];
		}
		}
		}
        
		$desglose=json_decode(json_encode($desglose));
			
		$i=0;$importe_totalmn=0;$importe_totalmlc=0;$importe_final=0;
		   	foreach ($desglose as $v) {
			   	$importe_totalmn+=$v->importe_mn;
				$importe_totalmlc+=$v->importe_mlc;++$i;
				//$importe_unitario=$V->importe_mn+$v->importe_mlc;
				$this->table->add_row($v->id_producto,$v->cta,$v->sub_cta,$v->nombre_producto,$v->unidad_medida,$v->cantidad,$v->precio_mn,$v->precio_mlc,$v->importe_mn,$v->importe_mlc,$v->importe_unitario,$v->resto);
             }
	    
			 while ($i<=10)
		 {
		$this->table->add_row('-','-','-','-','-','-','-','-','-','-','-');	
		 $i++;
		 }
            $importe_final=$importe_totalmn+$importe_totalmlc;			
			if(substr($importe_final,-3,1)!='.')$importe_final.='.00';
			$this->table->add_row('','','','','<strong>IMPORTE</strong>','<strong>TOTAL</strong>','<strong>DE LA</strong>','<strong>OPERACIÓN</strong>','<div style="text-align:left"><strong>'.$importe_totalmn.'</strong></div>','<div style="text-align:left"><strong>'.$importe_totalmlc.'</strong></div>','<div style="text-align:center"><strong>'.$importe_final.'</strong></div>');	
		 //Actualizar tabla temporal
		foreach ($desglose as $v)
            { 
		      $datos = array( 'alias' => $user, 'id_producto' => $v->id_producto, 'nombre_producto'=>$v->nombre_producto
		      ,'cantidad' => $v->cantidad, 'precio_mn' => $v->precio_mn,'precio_mlc' => $v->precio_mlc
			  ,'importe_mn' => $v->importe_mn,'importe_mlc' => $v->importe_mlc,'importe_unitario' => $v->importe_unitario
			  ,'unidad_medida' => $v->unidad_medida,'cta' => $v->cta,'sub_cta' => $v->sub_cta,'nombre_centro_costo' => $v->nombre_centro_costo
			  ,'no_centro_costo' => $v->no_centro_costo,'fecha_vale' => $v->fecha_vale,'id_orden' => $v->id_orden,'no_solicitud_compra' => $v->no_solicitud_compra
			  ,'receptor' => $v->receptor, 'resto' => $v->resto, 'despachador' => $v->despachador, 'consecutivo' => $v->consecutivo);
		      $this->db->insert('temp_vales', $datos,'');	
            }
       	}
		
		$data_template['vales']=$vales;		
   		$data_template['table_vales']=$this->table->generate();
		
   		$data['title_report']='';
		$data['head']="";	   
		$data['table']=$this->load->view('vale_utiles', $data_template, true);
		$data['footer']='';
		$this->load->view('v_report_template', $data);
        	
   }
   
   function contabilizar_vale_utiles($id_vale){
	    $permiso='vale_utiles_contabilizar';
		$this->permisos($permiso);	   	   
		$query=$this->reporte->existencia_utiles($id_vale);
	  	$vales=$query->row(); 
	    $desglose=$query->result();
        $year = date("Y");
		$estad=$this->reporte->consecutivo_u($year)->result();
		$estad=json_decode(json_encode($estad), true);
		$consecutivo=$estad[0]['consecutivo']+1;
		if ($vales->no_producto!== NULL){
		if ($vales->estado=='sin contabilizar' || $vales->estado==''){
		if($consulta->no_producto!==NULL){
			echo "<script>alert('!!!ERROR!!! El vale de combustible no tiene un equipo asignado.');</script>";
	        redirect('c_gestionar/vales_utiles', 'refresh');
		}
		$bloqueo=$this->reporte->validar_vale_3($id_vale)->result();
		
		foreach($bloqueo as $q){
		if($q->existencia-$q->cantidad<$q->cantidad_bloqueada){
			echo "<script>alert('!!!ERROR!!! No se puede procesar el vale. El producto $q->id_producto nombrado $q->nombre_producto está protegido y la extracción afecta el límite impuesto.');</script>";
	        redirect('c_gestionar/vales_utiles', 'refresh', 'order by vales_entrega.estado');}
		}
		
		foreach ($desglose as $p)
		{
			if ($p->importe<0 ){echo "<script>alert('¡¡¡ERROR!!! Existe un défisis en el pedido de $p->importe para el producto $p->id_producto.');</script>";
	redirect('c_gestionar/vales_utiles', 'refresh');}		
		}
		foreach ($desglose as $v)
		{
			$query = array( 'existencia' => $v->importe);
			$this->db->update('productos', $query, array('no_producto' => $v->no_producto));
			$datos = array( 'existencia' => $v->importe, 'precio_mn'=>$v->precio_mn, 'precio_mlc'=>$v->precio_mlc);
			$this->db->update('produccion_utiles', $datos, array('no_producto' => $v->no_producto,'id_vale'=>$v->id_vale));			
		}
		$data = array('estado' => 'contabilizado','consecutivo'=>$consecutivo);
		$this->db->update('vales_utiles', $data, array('id_vale' => $id_vale));
		
		echo "<script>alert('Vale $consecutivo contabilizado');</script>";
		redirect('c_gestionar/vales_utiles', 'refresh');
	}false;
	if ($vales->estado=='contabilizado' || $vales->estado=='cancelado'){$consecutivo--; echo "<script>alert('¡¡¡ERROR!!! El vale ya está contabilizado o cancelado');</script>";
	redirect('c_gestionar/vales_utiles', 'refresh');
	}	
	}false;
	
	if ($vales->no_producto== NULL){
	echo "<script>alert('Agrege productos a este vale');</script>";
	redirect('c_gestionar/vales_utiles', 'refresh');
	}    	
   }
   
   //vales medios básicos detallar
	function report_m($id_vale){
	$permiso='vale_medios_basicos_det';
		$this->permisos($permiso);
		//Borra tabla temporal
		$user=$this->session->userdata('useralias');
		$this->db->delete('temp_vales', array('alias' => $user));
		
		$query=$this->reporte->vales_medios_basicos($id_vale);
	  	$vales=$query->row(); 
	    $desglose=$query->result();
		
		if ($vales->id_producto==''){
			echo "<script>alert('Agrege productos a este vale');</script>";
	        redirect('c_gestionar/vales_medios_basicos', 'refresh');			
	   	}
		if($vales->estado=='cancelado')
		{
			$this->table->add_row('CANCELADO','','CANCELADO','','CANCELADO','','CANCELADO','','CANCELADO','','CANCELADO','');
		  $i=1;
		  while ($i<=10)
		 {
		$this->table->add_row('-','-','-','-','-','-','-','-','-','-','-');	
		 $i++;
		 }
		}
		else{
		$desglose=json_decode(json_encode($desglose), true);
		if($desglose[0]['id_orden']=='-'){$desglose[0]['receptor']=$desglose[0]['responsable'];}
		$this->table->set_heading('Código','Cta','Sub Cta','Descripción','UM','Cant','Precio(MN)','Precio(MLC)','Importe(MN)','Importe(MLC)','Importe','Saldo en existencia');
	    
		//Cambia los valores id por nombres
		$this->db->select('id_persona,nombre_persona');
		$valor=$this->db->get('personas')->result();
		$valor=json_decode(json_encode($valor), true);
		
		for($j=0;$j<count($desglose);$j++){
        for($i=0;$i<count($valor);$i++)
        {
        if ($desglose[$j]['receptor']==$valor[$i]['id_persona'])
        {
		$desglose[$j]['receptor']=$valor[$i]['nombre_persona'];
		}
		if ($desglose[$j]['despachador']==$valor[$i]['id_persona'])
        {
		$desglose[$j]['despachador']=$valor[$i]['nombre_persona'];
		}
		}
		}
        
		$desglose=json_decode(json_encode($desglose));
			
		$i=0;$importe_totalmn=0;$importe_totalmlc=0;$importe_final=0;
		   	foreach ($desglose as $v) {
			   	$importe_totalmn+=$v->importe_mn;
				$importe_totalmlc+=$v->importe_mlc;++$i;
				//$importe_unitario=$V->importe_mn+$v->importe_mlc;
				$this->table->add_row($v->id_producto,$v->cta,$v->sub_cta,$v->nombre_producto,$v->unidad_medida,$v->cantidad,$v->precio_mn,$v->precio_mlc,$v->importe_mn,$v->importe_mlc,$v->importe_unitario,$v->resto);
             }
	    
			 while ($i<=10)
		 {
		$this->table->add_row('-','-','-','-','-','-','-','-','-','-','-');	
		 $i++;
		 }
            $importe_final=$importe_totalmn+$importe_totalmlc;			
			if(substr($importe_final,-3,1)!='.')$importe_final.='.00';
			$this->table->add_row('','','','','<strong>IMPORTE</strong>','<strong>TOTAL</strong>','<strong>DE LA</strong>','<strong>OPERACIÓN</strong>','<div style="text-align:left"><strong>'.$importe_totalmn.'</strong></div>','<div style="text-align:left"><strong>'.$importe_totalmlc.'</strong></div>','<div style="text-align:center"><strong>'.$importe_final.'</strong></div>');	
		 //Actualizar tabla temporal
		foreach ($desglose as $v)
            { 
		      $datos = array( 'alias' => $user, 'id_producto' => $v->id_producto, 'nombre_producto'=>$v->nombre_producto
		      ,'cantidad' => $v->cantidad, 'precio_mn' => $v->precio_mn,'precio_mlc' => $v->precio_mlc
			  ,'importe_mn' => $v->importe_mn,'importe_mlc' => $v->importe_mlc,'importe_unitario' => $v->importe_unitario
			  ,'unidad_medida' => $v->unidad_medida,'cta' => $v->cta,'sub_cta' => $v->sub_cta,'nombre_centro_costo' => $v->nombre_centro_costo
			  ,'no_centro_costo' => $v->no_centro_costo,'fecha_vale' => $v->fecha_vale,'id_orden' => $v->id_orden,'no_solicitud_compra' => $v->no_solicitud_compra
			  ,'receptor' => $v->receptor, 'resto' => $v->resto, 'despachador' => $v->despachador, 'consecutivo' => $v->consecutivo);
		      $this->db->insert('temp_vales', $datos,'');	
            }
       	}
		
		$data_template['vales']=$vales;		
   		$data_template['table_vales']=$this->table->generate();
		
   		$data['title_report']='';
		$data['head']="";	   
		$data['table']=$this->load->view('vale_medios_basicos', $data_template, true);
		$data['footer']='';
		$this->load->view('v_report_template', $data);
        	
   }
   
   function contabilizar_vale_medios_basicos($id_vale){
	    $permiso='vale_medios_basicos_cont';
		$this->permisos($permiso);	   	   
		$query=$this->reporte->existencia_medios_basicos($id_vale);
	  	$vales=$query->row(); 
	    $desglose=$query->result();
        $year = date("Y");
		$estad=$this->reporte->consecutivo_m($year)->result();
		$estad=json_decode(json_encode($estad), true);
		$consecutivo=$estad[0]['consecutivo']+1;
		if ($vales->no_producto!== NULL){
		if ($vales->estado=='sin contabilizar' || $vales->estado==''){
		
		$bloqueo=$this->reporte->validar_vale_4($id_vale)->result();
		
		foreach($bloqueo as $q){
		if($q->existencia-$q->cantidad<$q->cantidad_bloqueada){
			echo "<script>alert('!!!ERROR!!! No se puede procesar el vale. El producto $q->id_producto nombrado $q->nombre_producto está protegido y la extracción afecta el límite impuesto.');</script>";
	        redirect('c_gestionar/vales_medios_basicos', 'refresh', 'order by vales_entrega.estado');}
		}
		
		foreach ($desglose as $p)
		{
			if ($p->importe<0 ){echo "<script>alert('¡¡¡ERROR!!! Existe un défisis en el pedido de $p->importe para el producto $p->id_producto.');</script>";
	redirect('c_gestionar/vales_medios_basicos', 'refresh');}		
		}
		foreach ($desglose as $v)
		{
			$query = array( 'existencia' => $v->importe);
			$this->db->update('productos', $query, array('no_producto' => $v->no_producto));
			$datos = array( 'existencia' => $v->importe, 'precio_mn'=>$v->precio_mn, 'precio_mlc'=>$v->precio_mlc);
			$this->db->update('produccion_medios_basicos', $datos, array('no_producto' => $v->no_producto,'id_vale'=>$v->id_vale));			
		}
		$data = array('estado' => 'contabilizado','consecutivo'=>$consecutivo);
		
		$this->db->update('vales_medios_basicos', $data, array('id_vale' => $id_vale));
		echo "<script>alert('Vale $consecutivo contabilizado');</script>";
		redirect('c_gestionar/vales_medios_basicos', 'refresh');
	}false;
	if ($vales->estado=='contabilizado' || $vales->estado=='cancelado'){$consecutivo--; echo "<script>alert('¡¡¡ERROR!!! El vale ya está contabilizado o cancelado');</script>";
	redirect('c_gestionar/vales_medios_basicos', 'refresh');
	}	
	}false;
	
	if ($vales->no_producto== NULL){
	echo "<script>alert('Agrege productos a este vale');</script>";
	redirect('c_gestionar/vales_medios_basicos', 'refresh');
	}    	
   }
   
   //vales devolucion detallar
	function report_02($id_vale){
	$permiso='vale_devol_detallar';
		$this->permisos($permiso);
		//Borra tabla temporal
		$user=$this->session->userdata('useralias');
		$this->db->delete('temp_vales', array('alias' => $user));		
	   	
		$query=$this->reporte->vales_devolucion($id_vale);
	  	$vales=$query->row(); 
	    $desglose=$query->result();
       
		$this->table->set_heading('Código','Cta','Sub Cta','Descripción','UM','Cant','Precio(MN)','Precio(MLC)','Importe(MN)','Importe(MLC)','Importe','Saldo en existencia');
	    if ($vales->id_producto=='') {
			echo "<script>alert('Agrege productos a este vale');</script>";
	redirect('c_gestionar/vales_devolucion', 'refresh');			
	   	}
		if($vales->estado=='cancelado')
		{
			$this->table->add_row('CANCELADO','','CANCELADO','','CANCELADO','','CANCELADO','','CANCELADO','','CANCELADO','');
		  $i=1;
		  while ($i<=10)
		 {
		$this->table->add_row('-','-','-','-','-','-','-','-','-','-','-');	
		 $i++;
		 }
		}
		else{
		$desglose=json_decode(json_encode($desglose), true);
        $id=$desglose[0]['vale_referencia'];
		$vale_referencia=$this->reporte->vale_referencia($id)->result();
		$vale_referencia=json_decode(json_encode($vale_referencia), true);
		
		for($j=0;$j<count($desglose);$j++)
		{for($i=0;$i<count($vale_referencia);$i++)
			{
			 if($vale_referencia[$i]['no_producto']==$desglose[$j]['no_producto'])
			 {
			  $desglose[$j]['no_solicitud_compra']=$vale_referencia[$i]['no_solicitud_compra'];
			  $desglose[$j]['no_centro_costo']=$vale_referencia[$i]['no_centro_costo'];
			  $desglose[$j]['nombre_centro_costo']=$vale_referencia[$i]['nombre_centro_costo'];
			  $desglose[$j]['vale_referencia']=$vale_referencia[$i]['consecutivo'];
			  if($vale_referencia[$i]['nombre_equipo']=='')
			    {
				 $desglose[$j]['nombre_equipo']=$vale_referencia[$j]['nombre_clasificar'];
			    }
			  else{$desglose[$j]['nombre_equipo']=$vale_referencia[$j]['nombre_equipo'];}
			 }				 
			}		 	
		}
		
		//Cambia los valores id por nombres
		$this->db->select('id_persona,nombre_persona');
		$valor=$this->db->get('personas')->result();
		$valor=json_decode(json_encode($valor), true);
		$desglose=json_decode(json_encode($desglose), true);
		
		for($j=0;$j<count($desglose);$j++){
        for($i=0;$i<count($valor);$i++)
        {
        if ($desglose[$j]['receptor']==$valor[$i]['id_persona'])
        {
		$desglose[$j]['receptor']=$valor[$i]['nombre_persona'];
		}
		if ($desglose[$j]['despachador']==$valor[$i]['id_persona'])
        {
		$desglose[$j]['despachador']=$valor[$i]['nombre_persona'];
		}
		}
		}
		
		$i=0;$importe_totalmn=0;$importe_totalmlc=0;$importe_final=0;
		$desglose=json_decode(json_encode($desglose));
		$this->table->set_empty("-");
		    foreach ($desglose as $v) {
			   	$importe_totalmn+=$v->importe_mn;
				$importe_totalmlc+=$v->importe_mlc;++$i;
			   	$this->table->add_row($v->id_producto,$v->cta,$v->sub_cta,$v->nombre_producto,$v->unidad_medida,$v->cantidad,$v->precio_mn,$v->precio_mlc,$v->importe_mn,$v->importe_mlc,$v->importe_unitario,$v->resto);
             }
			while ($i<=10)
		 {
		$this->table->add_row('-','-','-','-','-','-','-','-','-','-','-');	
		 $i++;
		 }
            $importe_final=$importe_totalmn+$importe_totalmlc;			
			if(substr($importe_final,-3,1)!='.')$importe_final.='.00';
			$this->table->add_row('','','','','<strong>IMPORTE</strong>','<strong>TOTAL</strong>','<strong>DE LA</strong>','<strong>OPERACIÓN</strong>','<div style="text-align:left"><strong>'.$importe_totalmn.'</strong></div>','<div style="text-align:left"><strong>'.$importe_totalmlc.'</strong></div>','<div style="text-align:center"><strong>'.$importe_final.'</strong></div>');	
		foreach ($desglose as $v)
            { 
		      $datos = array( 'alias' => $user, 'id_producto' => $v->id_producto, 'nombre_producto'=>$v->nombre_producto
		      ,'cantidad' => $v->cantidad, 'precio_mn' => $v->precio_mn,'precio_mlc' => $v->precio_mlc
			  ,'importe_mn' => $v->importe_mn,'importe_mlc' => $v->importe_mlc,'importe_unitario' => $v->importe_unitario
			  ,'unidad_medida' => $v->unidad_medida,'cta' => $v->cta,'sub_cta' => $v->sub_cta,'nombre_centro_costo' => $v->nombre_centro_costo, 'clasificacion_producto' => $v->nombre_equipo
			  ,'no_centro_costo' => $v->no_centro_costo,'fecha_vale' => $v->fecha_vale,'id_orden' => $v->id_orden,'no_solicitud_compra' => $v->no_solicitud_compra
			  ,'receptor' => $v->receptor, 'resto' => $v->resto, 'despachador' => $v->despachador, 'consecutivo' => $v->consecutivo, 'vale_referencia' => $v->vale_referencia);
		      $this->db->insert('temp_vales', $datos,'');	
            }
		
		}
		 
	    		
		$data_template['vales']=$vales;		
   		$data_template['table_vales']=$this->table->generate();
		
   		$data['title_report']='';
		$data['head']="";	   
		$data['table']=$this->load->view('vale_devolucion', $data_template, true);
		$data['footer']='';
		$this->load->view('v_report_template', $data);
		}
   
   
   function contabilizar_vale_devolucion($id_vale){
	   $permiso='vale_devol_contabilizar';
		$this->permisos($permiso);
	   	$query=$this->reporte->existencia_devolucion($id_vale);
	  	$vales=$query->row(); 
	    $desglose=$query->result();
        $year = date("Y");
		$estad=$this->reporte->consecutivo_d($year)->result();
		$estad=json_decode(json_encode($estad), true);
		$consecutivo=$estad[0]['consecutivo']+1;
		
		if ($vales->no_producto!== NULL){
		
		if ($vales->estado=='sin contabilizar' || $vales->estado==''){
		$desglose=json_decode(json_encode($desglose), true);
		$id=$desglose[0]['vale_referencia'];
		$vale_referencia=$this->reporte->vale_referencia($id)->result();
		$vale_referencia_equipo=$this->reporte->vale_referencia_equipos($id)->result();
		$vale_referencia_clasificador=$this->reporte->vale_referencia_clasificador($id)->result();
		$devolucion_anterior=$this->reporte->vale_devolucion_anterior($id,$id_vale)->result();
		
		
		$vale_referencia=json_decode(json_encode($vale_referencia), true);
		$vale_referencia_equipo=json_decode(json_encode($vale_referencia_equipo), true);
		$vale_referencia_clasificador=json_decode(json_encode($vale_referencia_clasificador), true);
		$devolucion_anterior=json_decode(json_encode($devolucion_anterior), true);
		
		
		for($j=0;$j<count($devolucion_anterior);$j++)
		{for($i=0;$i<count($vale_referencia);$i++)
			{
			 if($vale_referencia[$i]['no_producto']==$devolucion_anterior[$j]['no_producto'])
			 {
			  $vale_referencia[$i]['cantidad']-=$devolucion_anterior[$j]['cantidad'];
			  }				 
			}		 	
		}
		
			 if($vale_referencia_equipo[0]['nombre_equipo']=='')
			    {
				$desglose[0]['nombre_equipo']=$vale_referencia_clasificador[0]['nombre_clasificar'];
			    }
			  else{$desglose[0]['nombre_equipo']=$vale_referencia_equipo[0]['nombre_equipo'];}			 
			
		
		for($i=0;$i<count($vale_referencia);$i++)
		{for($j=0;$j<count($desglose);$j++)
			{
			 if($vale_referencia[$i]['no_producto']==$desglose[$j]['no_producto'])
			 {
			  $devolucion=$vale_referencia[$i]['cantidad']-$desglose[$j]['cantidad'];
			  if($devolucion<0)
			  {
				$devolucion=$devolucion*-1; $id_producto=$desglose[$j]['id_producto'];
				echo "<script>alert('Está procesando $devolucion unidad(es) superior a la disponible  para el producto $id_producto en el vale de referencia.');</script>";
		        redirect('c_gestionar/vales_devolucion', 'refresh');  
			  }
			  $desglose[$j]['precio_mn']=$vale_referencia[$i]['precio_mn'];
			  $desglose[$j]['precio_mlc']=$vale_referencia[$i]['precio_mlc'];
			  $desglose[$j]['control']=1;
			  $desglose[$j]['existencia_mn']=(($desglose[$j]['existencia_mn']*$desglose[$j]['existencia'])+($vale_referencia[$i]['precio_mn']*$desglose[$j]['cantidad']))/($desglose[$j]['cantidad']+$desglose[$j]['existencia']);
			  $desglose[$j]['existencia_mlc']=(($desglose[$j]['existencia_mlc']*$desglose[$j]['existencia'])+($vale_referencia[$i]['precio_mlc']*$desglose[$j]['cantidad']))/($desglose[$j]['cantidad']+$desglose[$j]['existencia']);
			 }				 
			}		 	
		}
		
        for($j=0;$j<count($desglose);$j++)
		{
		  if($desglose[$j]['control']!==1)
		  {
			 $desglose=$desglose[$j]['id_producto'];
			echo "<script>alert('El producto $desglose no existe en el vale de referencia');</script>";
		    redirect('c_gestionar/vales_devolucion', 'refresh');  
		  }
        }
        		
	  	$desglose=json_decode(json_encode($desglose));
	  	
		foreach ($desglose as $v)		
		{
			$query = array( 'existencia' => $v->importe,'precio_mn' => $v->existencia_mn,'precio_mlc' => $v->existencia_mlc);
			$this->db->update('productos', $query, array('no_producto' => $v->no_producto));
			$datos = array( 'existencia' => $v->importe,'precio_mn' => $v->precio_mn,'precio_mlc' => $v->precio_mlc);
			$this->db->update('produccion_devolucion', $datos, array('no_producto' => $v->no_producto,'id_vale'=>$v->id_vale));
		}
		$data = array( 'estado' => 'contabilizado','consecutivo'=>$consecutivo);
		$this->db->update('vales_devolucion', $data, array('id_vale' => $id_vale));
		
		echo "<script>alert('Vale $consecutivo contabilizado');</script>";
		redirect('c_gestionar/vales_devolucion', 'refresh');
	}false;
		if ($vales->estado=='contabilizado' || $vales->estado=='cancelado' ){echo "<script>alert('¡¡¡ERROR!!! El vale $id_vale ya está contabilizado o cancelado');</script>";
	    redirect('c_gestionar/vales_devolucion', 'refresh');}
	}false;
	if ($vales->no_producto== NULL){
	echo "<script>alert('Agrege productos a este vale');</script>";
	redirect('c_gestionar/vales_devolucion', 'refresh');
	}
 }
 
  //vales transferencia de materiales detallar
  function report_03($id_vale){
    $permiso='vale_transf_detallar';
    $this->permisos($permiso);
    //Borra tabla temporal
    $user=$this->session->userdata('useralias');
    $this->db->delete('temp_vales', array('alias' => $user));
    
    $query=$this->reporte->vales_transferencia($id_vale);
      $vales=$query->row(); 
      $desglose=$query->result();
        
    $this->table->set_heading('Código','Cta','Sub Cta','Descripción','UM','Cant','Precio(MN)','Precio(MLC)','Importe(MN)','Importe(MLC)','Importe','Saldo en existencia');
      if ($vales->id_producto=='') {
      echo "<script>alert('Agrege productos a este vale');</script>";
  redirect('c_gestionar/vales_transferencia', 'refresh');     
      }
        if($vales->estado=='cancelado')
    {
      $this->table->add_row('CANCELADO','','CANCELADO','','CANCELADO','','CANCELADO','','CANCELADO','','CANCELADO','');
      $i=1;
      while ($i<=10)
     {
    $this->table->add_row('-','-','-','-','-','-','-','-','-','-','-'); 
     $i++;
     }
    }
    else{
        $desglose=json_decode(json_encode($desglose), true);      
    $i=0;$importe_totalmn=0;$importe_totalmlc=0;$importe_final=0;
    $this->table->set_empty("-");
    //cambiando datos
    $this->db->select('id_persona,nombre_persona');
    $valor=$this->db->get('personas_externas')->result();
    $valor=json_decode(json_encode($valor), true);
        
    for($j=0;$j<count($desglose);$j++){
        for($i=0;$i<count($valor);$i++)
        {
        if ($desglose[$j]['receptor']==$valor[$i]['id_persona'])
        {
    $desglose[$j]['receptor']=$valor[$i]['nombre_persona'];
    }
    if ($desglose[$j]['transportador']==$valor[$i]['id_persona'])
        {
    $desglose[$j]['transportador']=$valor[$i]['nombre_persona'];
    }
    }
    }
    
    $this->db->select('id_entidad,nombre_entidad,no_entidad,direccion_entidad');
    $valor=$this->db->get('entidades')->result();
    $valor=json_decode(json_encode($valor), true);
    
    for($j=0;$j<count($desglose);$j++){
        for($i=0;$i<count($valor);$i++)
        {
        if ($desglose[$j]['id_entidad_despacha']==$valor[$i]['id_entidad'])
        {
    $desglose[$j]['no_entidad_suministra']=$valor[$i]['no_entidad']; $desglose[$j]['nombre_entidad_suministra']=$valor[$i]['nombre_entidad'].', '.$valor[$i]['direccion_entidad'];
    }
    if ($desglose[$j]['id_entidad']==$valor[$i]['id_entidad'])
        {
    $desglose[$j]['no_entidad_recibe']=$valor[$i]['no_entidad']; $desglose[$j]['nombre_entidad_recibe']=$valor[$i]['nombre_entidad'].', '.$valor[$i]['direccion_entidad'];
    }
    }
    }
    
    $desglose=json_decode(json_encode($desglose));      
    
    
        foreach ($desglose as $v) {
          $importe_totalmn+=$v->importe_mn;
        $importe_totalmlc+=$v->importe_mlc;++$i;
          $this->table->add_row($v->id_producto,$v->cta,$v->sub_cta,$v->nombre_producto,$v->unidad_medida,$v->cantidad,$v->precio_mn,$v->precio_mlc,$v->importe_mn,$v->importe_mlc,$v->importe_unitario,$v->resto);
             }
    while ($i<=10)
     {
    $this->table->add_row('-','-','-','-','-','-','-','-','-','-','-'); 
     $i++;
     }
            $importe_final=$importe_totalmn+$importe_totalmlc;      
      if(substr($importe_final,-3,1)!='.')$importe_final.='.00';
      $this->table->add_row('','','','','<strong>IMPORTE</strong>','<strong>TOTAL</strong>','<strong>DE LA</strong>','<strong>OPERACIÓN</strong>','<div style="text-align:left"><strong>'.$importe_totalmn.'</strong></div>','<div style="text-align:left"><strong>'.$importe_totalmlc.'</strong></div>','<div style="text-align:center"><strong>'.$importe_final.'</strong></div>'); 
    foreach ($desglose as $v)
            { 
          $datos = array( 'alias' => $user, 'id_producto' => $v->id_producto, 'nombre_producto'=>$v->nombre_producto
          ,'cantidad' => $v->cantidad, 'precio_mn' => $v->precio_mn,'precio_mlc' => $v->precio_mlc
        ,'importe_mn' => $v->importe_mn,'importe_mlc' => $v->importe_mlc,'importe_unitario' => $v->importe_unitario
        ,'unidad_medida' => $v->unidad_medida,'cta' => $v->cta,'sub_cta' => $v->sub_cta,'chapa' => $v->chapa,'no_carnet' => $v->no_carnet
        ,'fecha_vale' => $v->fecha_vale,'no_solicitud_compra' => $v->no_solicitud_compra,'licencia_conduccion' => $v->licencia_conduccion,'nombre_transportador' => $v->transportador
        ,'receptor' => $v->receptor, 'resto' => $v->resto, 'despachador' => $v->despachador, 'consecutivo' => $v->consecutivo
        ,'no_entidad_recibe' => $v->no_entidad_recibe, 'nombre_entidad_recibe' => $v->nombre_entidad_recibe, 'no_entidad_despacha' => $v->no_entidad_suministra, 'nombre_entidad_despacha' => $v->nombre_entidad_suministra);
          $this->db->insert('temp_vales', $datos,''); 
            } 
    }
    $data_template['vales']=$vales;   
      $data_template['table_vales']=$this->table->generate();
    
      $data['title_report']='';
    $data['head']="";    
    $data['table']=$this->load->view('vale_transferencia', $data_template, true);
    $data['footer']='';
    $this->load->view('v_report_template', $data);
    
   }

   //Factura transferencia de materiales detallar
	function detallar_factura_transferencia($id_factura){
		$permiso='factura_venta';
		$this->permisos($permiso);
		//Borra tabla temporal
		$user=$this->session->userdata('useralias');
		$this->db->delete('temp_vales', array('alias' => $user));
		
		$query=$this->reporte->factura_transferencia($id_factura);
	  	$vales=$query->row(); 
	    $desglose=$query->result();
        
		$this->table->set_heading('Código','Cta','Sub Cta','Descripción','UM','Cant','Precio(MN)','Precio(MLC)','Importe(MN)','Importe(MLC)','Importe','Saldo en existencia');
	    if ($vales->id_producto=='') {
			echo "<script>alert('Agrege productos a esta factura');</script>";
	redirect('c_gestionar/factura_transferencia', 'refresh');			
	   	}
        if($vales->estado=='cancelado')
		{
			$this->table->add_row('CANCELADO','','CANCELADO','','CANCELADO','','CANCELADO','','CANCELADO','','CANCELADO','');
		  $i=1;
		  while ($i<=10)
		 {
		$this->table->add_row('-','-','-','-','-','-','-','-','-','-','-');	
		 $i++;
		 }
		}
		else{
        $desglose=json_decode(json_encode($desglose), true);			
		$i=0;$importe_totalmn=0;$importe_totalmlc=0;$importe_final=0;
		$this->table->set_empty("-");
		//cambiando datos
		$this->db->select('id_persona,nombre_persona');
		$valor=$this->db->get('personas_externas')->result();
		$valor=json_decode(json_encode($valor), true);
				
		for($j=0;$j<count($desglose);$j++){
        for($i=0;$i<count($valor);$i++)
        {
        if ($desglose[$j]['receptor']==$valor[$i]['id_persona'])
        {
		$desglose[$j]['receptor']=$valor[$i]['nombre_persona'];
		}
		if ($desglose[$j]['transportador']==$valor[$i]['id_persona'])
        {
		$desglose[$j]['transportador']=$valor[$i]['nombre_persona'];
		}
		}
		}
		
		$this->db->select('id_entidad,nombre_entidad,no_entidad,direccion_entidad');
		$valor=$this->db->get('entidades')->result();
		$valor=json_decode(json_encode($valor), true);
		
		for($j=0;$j<count($desglose);$j++){
        for($i=0;$i<count($valor);$i++)
        {
        if ($desglose[$j]['id_entidad_despacha']==$valor[$i]['id_entidad'])
        {
		$desglose[$j]['no_entidad_suministra']=$valor[$i]['no_entidad']; $desglose[$j]['nombre_entidad_suministra']=$valor[$i]['nombre_entidad'].', '.$valor[$i]['direccion_entidad'];
		}
		if ($desglose[$j]['id_entidad']==$valor[$i]['id_entidad'])
        {
		$desglose[$j]['no_entidad_recibe']=$valor[$i]['no_entidad']; $desglose[$j]['nombre_entidad_recibe']=$valor[$i]['nombre_entidad'].', '.$valor[$i]['direccion_entidad'];
		}
		}
		}
		
		$desglose=json_decode(json_encode($desglose));			
		
		
		    foreach ($desglose as $v) {
			   	$importe_totalmn+=$v->importe_mn;
				$importe_totalmlc+=$v->importe_mlc;++$i;
			   	$this->table->add_row($v->id_producto,$v->cta,$v->sub_cta,$v->nombre_producto,$v->unidad_medida,$v->cantidad,$v->precio_mn,$v->precio_mlc,$v->importe_mn,$v->importe_mlc,$v->importe_unitario,$v->resto);
             }
		while ($i<=10)
		 {
		$this->table->add_row('-','-','-','-','-','-','-','-','-','-','-');	
		 $i++;
		 }
            $importe_final=$importe_totalmn+$importe_totalmlc;			
			if(substr($importe_final,-3,1)!='.')$importe_final.='.00';
			$this->table->add_row('','','','','<strong>IMPORTE</strong>','<strong>TOTAL</strong>','<strong>DE LA</strong>','<strong>OPERACIÓN</strong>','<div style="text-align:left"><strong>'.$importe_totalmn.'</strong></div>','<div style="text-align:left"><strong>'.$importe_totalmlc.'</strong></div>','<div style="text-align:center"><strong>'.$importe_final.'</strong></div>');	
		foreach ($desglose as $v)
            { 
		      $datos = array( 'alias' => $user, 'id_producto' => $v->id_producto, 'nombre_producto'=>$v->nombre_producto
		      ,'cantidad' => $v->cantidad, 'precio_mn' => $v->precio_mn,'precio_mlc' => $v->precio_mlc
			  ,'importe_mn' => $v->importe_mn,'importe_mlc' => $v->importe_mlc,'importe_unitario' => $v->importe_unitario
			  ,'unidad_medida' => $v->unidad_medida,'cta' => $v->cta,'sub_cta' => $v->sub_cta,'chapa' => $v->chapa,'no_carnet' => $v->no_carnet
			  ,'fecha_vale' => $v->fecha_factura,'no_solicitud_compra' => $v->no_solicitud_compra,'licencia_conduccion' => $v->licencia_conduccion,'nombre_transportador' => $v->transportador
			  ,'receptor' => $v->receptor, 'resto' => $v->resto, 'despachador' => $v->despachador, 'consecutivo' => $v->consecutivo
			  ,'no_entidad_recibe' => $v->no_entidad_recibe, 'nombre_entidad_recibe' => $v->nombre_entidad_recibe, 'no_entidad_despacha' => $v->no_entidad_suministra, 'nombre_entidad_despacha' => $v->nombre_entidad_suministra);
		      $this->db->insert('temp_vales', $datos,'');	
            }	
		}
		$data_template['vales']=$vales;		
   		$data_template['table_vales']=$this->table->generate();
		
   		$data['title_report']='';
		$data['head']="";	   
		$data['table']=$this->load->view('detallar_factura_transferencia', $data_template, true);
		$data['footer']='';
		$this->load->view('v_report_template', $data);
		
   }
   
    function contabilizar_factura_transferencia($id_factura){
  $permiso='factura_venta';
    $this->permisos($permiso);
      $query=$this->reporte->existencia_factura_transferencia($id_factura);
      $vales=$query->row(); 
      $desglose=$query->result();
        $year = date("Y");
    $estad=$this->reporte->consecutivo_factura_t($year)->result();
    $estad=json_decode(json_encode($estad), true);
    $consecutivo=$estad[0]['consecutivo']+1;
    
    if ($vales->no_producto!== NULL){     
    if ($vales->estado=='sin contabilizar' || $vales->estado==''){
      
    foreach ($desglose as $p)
    {
      if ($p->importe<0 ){echo "<script>alert('¡¡¡ERROR!!! Existe un défisis de $p->importe en el pedido para el producto $p->id_producto');</script>";
  redirect('c_gestionar/factura_transferencia', 'refresh');}    
    } 
    foreach ($desglose as $v)
    {
      $query = array( 'existencia' => $v->importe);
      $this->db->update('productos', $query, array('no_producto' => $v->no_producto));
      $datos = array( 'existencia' => $v->importe, 'precio_mn'=>$v->precio_mn, 'precio_mlc'=>$v->precio_mlc);
      $this->db->update('produccion_factura_transferencia', $datos, array('no_producto' => $v->no_producto,'id_factura'=>$v->id_factura));      
    }
    
    $data = array('estado' => 'contabilizado','consecutivo'=>$consecutivo);
    $this->db->update('factura_transferencia', $data, array('id_factura' => $id_factura));
      echo "<script>alert('Factura $consecutivo contabilizada');</script>";
    redirect('c_gestionar/factura_transferencia', 'refresh');
  }false;
    if ($vales->estado=='contabilizado' || $vales->estado=='cancelado' ){$consecutivo--; echo "<script>alert('¡¡¡ERROR!!! La factura $consecutivo ya está contabilizada o cancelada');</script>";
       redirect('c_gestionar/factura_transferencia', 'refresh');}
  }false;
  if ($vales->no_producto== NULL){
  echo "<script>alert('Agrege productos a esta factura');</script>";
  redirect('c_gestionar/factura_transferencia', 'refresh');
  }
}

	
	//vales recepcion detallar
	function report_01($id_vale){
	$permiso='vale_recep_detallar';
		$this->permisos($permiso);
		$query=$this->reporte->vales_recepcion($id_vale);
	  	$vales=$query->row(); 
	    $desglose=$query->result(); 
	   	$this->table->set_heading('Código','Cta','Sub Cta','Descripción','UM','Cant','Precio(MN)','Precio(MLC)','Importe(MN)','Importe(MLC)','Importe','Saldo en existencia');
	    if ($vales->id_producto=='') {
			echo "<script>alert('Agrege productos a este vale');</script>";
	redirect('c_gestionar/vales_recepcion', 'refresh');			
	   	}
		if($vales->estado=='cancelado')
		{
			$this->table->add_row('CANCELADO','','CANCELADO','','CANCELADO','','CANCELADO','','CANCELADO','','CANCELADO','');
		  $i=1;
		  while ($i<=10)
		 {
		$this->table->add_row('-','-','-','-','-','-','-','-','-','-','-');	
		 $i++;
		 }
		}
		else{		
		$i=0;$importe_totalmn=0;$importe_totalmlc=0;$importe_final=0;
		   	$this->table->set_empty("-");
		    foreach ($desglose as $v) {
			   	$importe_totalmn+=$v->importe_mn;
				$importe_totalmlc+=$v->importe_mlc;++$i;
			   	$this->table->add_row($v->id_producto,$v->cta,$v->sub_cta,$v->nombre_producto,$v->unidad_medida,$v->cantidad,$v->precio_mn,$v->precio_mlc,$v->importe_mn,$v->importe_mlc,$v->importe_unitario,$v->resto);
             }
			 while ($i<=10)
		 {
		$this->table->add_row('-','-','-','-','-','-','-','-','-','-','-');	
		 $i++;
		 }
            $importe_final=$importe_totalmn+$importe_totalmlc;			
			if(substr($importe_final,-3,1)!='.')$importe_final.='.00';
			$this->table->add_row('','','','','<strong>IMPORTE</strong>','<strong>TOTAL</strong>','<strong>DE LA</strong>','<strong>OPERACIÓN</strong>','<div style="text-align:left"><strong>'.$importe_totalmn.'</strong></div>','<div style="text-align:left"><strong>'.$importe_totalmlc.'</strong></div>','<div style="text-align:center"><strong>'.$importe_final.'</strong></div>');	
		 }
		$data_template['vales']=$vales;		
   		$data_template['table_vales']=$this->table->generate();
		
   		$data['title_report']='';
		$data['head']="";	   
		$data['table']=$this->load->view('vale_recepcion', $data_template, true);
		$data['footer']='';
		$this->load->view('v_report_template', $data);
		
   }
   
   function contabilizar_vale_recepcion($id_vale){
	   $permiso='vale_recep_contabilizar';
		$this->permisos($permiso);  
		$query=$this->reporte->existencia_recepcion($id_vale);
	  	$vales=$query->row(); 
	    $desglose=$query->result();
		if ($vales->no_producto!== NULL){
		if ($vales->estado=='sin contabilizar' || $vales->estado==''){
		foreach ($desglose as $v)
		{
			$query = array( 'existencia' => $v->importe,'precio_mn' => $v->precio_mn,'precio_mlc' => $v->precio_mlc);
			$this->db->update('productos', $query, array('no_producto' => $v->no_producto));
			$datos = array( 'existencia' => $v->importe);
			$this->db->update('produccion_recepcion', $datos, array('no_producto' => $v->no_producto,'id_vale'=>$v->id_vale));
		}
		
		$data = array( 'estado' => 'contabilizado');
		$this->db->update('vales_recepcion', $data, array('id_vale' => $id_vale));
		echo "<script>alert('Vale $id_vale contabilizado');</script>";
		redirect('c_gestionar/vales_recepcion', 'refresh');
	}false;
		if ($vales->estado=='contabilizado' || $vales->estado=='cancelado' ){echo "<script>alert('¡¡¡ERROR!!! El vale $id_vale ya está contabilizado o cancelado');</script>";
	    redirect('c_gestionar/vales_recepcion', 'refresh');
	}
	}false;
	if ($vales->no_producto== NULL){
	echo "<script>alert('Agrege productos a este vale');</script>";
	redirect('c_gestionar/vales_recepcion', 'refresh');
	}
 }
 
   
   
   function contabilizar_vale_transferencia($id_vale){
	$permiso='vale_transf_contabilizar';
		$this->permisos($permiso);
        $query=$this->reporte->existencia_transferencia($id_vale);
	  	$vales=$query->row(); 
	    $desglose=$query->result();
        $year = date("Y");
		$estad=$this->reporte->consecutivo_t($year)->result();
		$estad=json_decode(json_encode($estad), true);
		$consecutivo=$estad[0]['consecutivo']+1;
		
		if ($vales->no_producto!== NULL){			
		if ($vales->estado=='sin contabilizar' || $vales->estado==''){
			
		foreach ($desglose as $p)
		{
			if ($p->importe<0 ){echo "<script>alert('¡¡¡ERROR!!! Existe un défisis de $p->importe en el pedido para el producto $p->id_producto');</script>";
	redirect('c_gestionar/vales_transferencia', 'refresh');}		
		}	
		foreach ($desglose as $v)
		{
			$query = array( 'existencia' => $v->importe);
			$this->db->update('productos', $query, array('no_producto' => $v->no_producto));
			$datos = array( 'existencia' => $v->importe, 'precio_mn'=>$v->precio_mn, 'precio_mlc'=>$v->precio_mlc);
			$this->db->update('produccion_transferencia', $datos, array('no_producto' => $v->no_producto,'id_vale'=>$v->id_vale));			
		}
		
		$data = array('estado' => 'contabilizado','consecutivo'=>$consecutivo);
		$this->db->update('vales_transferencia', $data, array('id_vale' => $id_vale));
			echo "<script>alert('Vale $consecutivo contabilizado');</script>";
		redirect('c_gestionar/vales_transferencia', 'refresh');
	}false;
		if ($vales->estado=='contabilizado' || $vales->estado=='cancelado' ){$consecutivo--; echo "<script>alert('¡¡¡ERROR!!! El vale $consecutivo ya está contabilizado o cancelado');</script>";
	     redirect('c_gestionar/vales_transferencia', 'refresh');}
	}false;
	if ($vales->no_producto== NULL){
	echo "<script>alert('Agrege productos a este vale');</script>";
	redirect('c_gestionar/vales_transferencia', 'refresh');
	}
}
   
    
   //existencia de productos star
   //inventario completo
   function report_04(){
    $permiso='inventario_completo';
        $this->permisos($permiso);
        $busqueda=$this->input->post('busqueda');
        $busqueda2=$this->input->post('busqueda2');
        if(!$busqueda2)$busqueda2='con_existencia';

        if($busqueda2=='completa'){$array=$this->reporte->inventario_completo($busqueda)->result();}
        if($busqueda2=='cero'){$array=$this->reporte->inventario_completo2($busqueda)->result();}
       if($busqueda2=='con_existencia'){$array=$this->reporte->inventario_completo3($busqueda)->result();}      

        $this->table->set_heading('No producto',utf8('Nombre producto'),'Existencia','U/M','Precio MN','Sección','Estante','Casilla');      
        $this->table->set_empty("-");
        foreach ($array as $v)
        { 
         $this->table->add_row($v->id_producto,$v->nombre_producto,$v->existencia,$v->unidad_medida,$v->precio_mn,$v->seccion,$v->estante,$v->casilla,"<td><a href='../c_gestionar/productos/edit/$v->no_producto'><button type='button' class='btn btn-success'>Editar</button></a></td>");    
        }   
        
        
        $data_form['action']=base_url('index.php/c_reporte/report_04');
        $data_form['value_busqueda']=$busqueda;
        $data_form['value_busqueda2']=$busqueda2;
        $data['title_report']=utf8('Inventario Almacen de materiales');
        $data['head']=$this->load->view('form_busqueda_completa', $data_form,true);  
        $data['table']=$this->table->generate();
        $data['footer']="<div><strong>Este reporte es generado por Yolexis_system</strong>";
        $this->load->view('v_report_template', $data);
    }
   
   //insumos directos
   function insumos(){
   $permiso='materiales_directos';
		$this->permisos($permiso);
       	$array=$this->reporte->inventario_insumos_produccion()->result();		
		$this->table->set_heading('No producto',utf8('Nombre producto'),'Existencia','U/M','Precio MN','Precio MLC');	   	
		$this->table->set_empty("-");
		
		foreach ($array as $v)
        { 
		 $this->table->add_row($v->id_producto,$v->nombre_producto,$v->existencia,$v->unidad_medida,$v->precio_mn,$v->precio_mlc);	
        }	
		
        $data['head']="";
		$data_form['action']=base_url('index.php/c_reporte/insumos');
		$data['title_report']=utf8('Materiales directos para la producción');
		$data['table']=$this->table->generate();
		$data['footer']='Este reporte es generado por Yolexis_system';
		$this->load->view('v_report_template', $data);		
   }
   
   //insumos auxiliares
   function insumos2(){
   $permiso='materiales_auxiliares';
		$this->permisos($permiso);
       	$array=$this->reporte->inventario_insumos_produccion2()->result();		
		$this->table->set_heading('No producto',utf8('Nombre producto'),'Existencia','U/M','Precio MN','Precio MLC');	   	
		$this->table->set_empty("-");
		foreach ($array as $v)
        { 
		 $this->table->add_row($v->id_producto,$v->nombre_producto,$v->existencia,$v->unidad_medida,$v->precio_mn,$v->precio_mlc);	
        }	
		
        $data['head']="";
		$data_form['action']=base_url('index.php/c_reporte/insumos2');
		$data['title_report']=utf8('Materiales auxiliares');
		$data['table']=$this->table->generate();
		$data['footer']='Este reporte es generado por Yolexis_system';
		$this->load->view('v_report_template', $data);
		
   }
   
   function insumos3(){
   $permiso='reserva_movilizativa';
		$this->permisos($permiso);
       	$array=$this->reporte->inventario_insumos_produccion3()->result();		
		$this->table->set_heading('No producto',utf8('Nombre producto'),'Existencia','U/M','Precio MN','Precio MLC');	   	
		$this->table->set_empty("-");
		foreach ($array as $v)
        { 
		 $this->table->add_row($v->id_producto,$v->nombre_producto,$v->existencia,$v->unidad_medida,$v->precio_mn,$v->precio_mlc);	
        }	
		
        $data['head']="";
		$data_form['action']=base_url('index.php/c_reporte/insumos3');
		$data['title_report']=utf8('Materiales Reserva Movilizativa');
		$data['table']=$this->table->generate();
		$data['footer']='Este reporte es generado por Yolexis_system';
		$this->load->view('v_report_template', $data);
		
   }
   
   function insumos4(){
  $permiso='materiales_combustible';
		$this->permisos($permiso);
       	$array=$this->reporte->inventario_insumos_produccion4()->result();		
		$this->table->set_heading('No producto',utf8('Nombre producto'),'Existencia','U/M','Precio MN','Precio MLC');	   	
		$this->table->set_empty("-");
		foreach ($array as $v)
        { 
		 $this->table->add_row($v->id_producto,$v->nombre_producto,$v->existencia,$v->unidad_medida,$v->precio_mn,$v->precio_mlc);	
        }	
		
        $data['head']="";
		$data_form['action']=base_url('index.php/c_reporte/insumos4');
		$data['title_report']=utf8('Materiales Comb.');
		$data['table']=$this->table->generate();
		$data['footer']='Este reporte es generado por Yolexis_system';
		$this->load->view('v_report_template', $data);
	
   }
   
   function insumos5(){
   $permiso='partes_piezas';
		$this->permisos($permiso);
       	$array=$this->reporte->inventario_insumos_produccion5()->result();		
		$this->table->set_heading('No producto',utf8('Nombre producto'),'Existencia','U/M','Precio MN','Precio MLC');	   	
		$this->table->set_empty("-");
		foreach ($array as $v)
        { 
		 $this->table->add_row($v->id_producto,$v->nombre_producto,$v->existencia,$v->unidad_medida,$v->precio_mn,$v->precio_mlc);	
        }	
		
        $data['head']="";
		$data_form['action']=base_url('index.php/c_reporte/insumos5');
		$data['title_report']=utf8('Materiales Partes y Piezas');
		$data['table']=$this->table->generate();
		$data['footer']='Este reporte es generado por Yolexis_system';
		$this->load->view('v_report_template', $data);
		
   }
   
   function insumos6(){
   $permiso='utiles_herramientas';
		$this->permisos($permiso);
       	$array=$this->reporte->inventario_insumos_produccion6()->result();		
		$this->table->set_heading('No producto',utf8('Nombre producto'),'Existencia','U/M','Precio MN','Precio MLC');	   	
		$this->table->set_empty("-");
		foreach ($array as $v)
        { 
		 $this->table->add_row($v->id_producto,$v->nombre_producto,$v->existencia,$v->unidad_medida,$v->precio_mn,$v->precio_mlc);	
        }	
		
        $data['head']="";
		$data_form['action']=base_url('index.php/c_reporte/insumos6');
		$data['title_report']=utf8('Materiales Útiles y Herramientas');
		$data['table']=$this->table->generate();
		$data['footer']='Este reporte es generado por Yolexis_system';
		$this->load->view('v_report_template', $data);
		
   }
   
   function insumos7(){
   $permiso='lento_movimiento';
		$this->permisos($permiso);
       	$array=$this->reporte->inventario_insumos_produccion7()->result();		
		$this->table->set_heading('No producto',utf8('Nombre producto'),'Existencia','U/M','Precio MN','Precio MLC');	   	
		$this->table->set_empty("-");
		foreach ($array as $v)
        { 
		 $this->table->add_row($v->id_producto,$v->nombre_producto,$v->existencia,$v->unidad_medida,$v->precio_mn,$v->precio_mlc);	
        }	
		
        $data['head']="";
		$data_form['action']=base_url('index.php/c_reporte/insumos7');
		$data['title_report']=utf8('Materiales Lento Movimiento');
		$data['table']=$this->table->generate();
		$data['footer']='Este reporte es generado por Yolexis_system';
		$this->load->view('v_report_template', $data);
		
   }
   
   function insumos8(){
   $permiso='inversiones';
		$this->permisos($permiso);
       	$array=$this->reporte->inventario_insumos_produccion8()->result();		
		$this->table->set_heading('No producto',utf8('Nombre producto'),'Existencia','U/M','Precio MN','Precio MLC');	   	
		$this->table->set_empty("-");
		foreach ($array as $v)
        { 
		 $this->table->add_row($v->id_producto,$v->nombre_producto,$v->existencia,$v->unidad_medida,$v->precio_mn,$v->precio_mlc);	
        }	
		
        $data['head']="";
		$data_form['action']=base_url('index.php/c_reporte/insumos8');
		$data['title_report']=utf8('Materiales auxiliares');
		$data['table']=$this->table->generate();
		$data['footer']='Este reporte es generado por Yolexis_system';
		$this->load->view('v_report_template', $data);
		
   }
   
   function insumos9(){
   $permiso='productos_quimicos';
		$this->permisos($permiso);
       	$array=$this->reporte->inventario_insumos_produccion9()->result();		
		$this->table->set_heading('No producto',utf8('Nombre producto'),'Existencia','U/M','Precio MN','Precio MLC');	   	
		$this->table->set_empty("-");
		foreach ($array as $v)
        { 
		 $this->table->add_row($v->id_producto,$v->nombre_producto,$v->existencia,$v->unidad_medida,$v->precio_mn,$v->precio_mlc);	
        }	
		
        $data['head']="";
		$data_form['action']=base_url('index.php/c_reporte/insumos9');
		$data['title_report']=utf8('Productos Químicos');
		$data['table']=$this->table->generate();
		$data['footer']='Este reporte es generado por Yolexis_system';
		$this->load->view('v_report_template', $data);
		
   }

   function medios_proteccion(){
   $permiso='medios_proteccion';
        $this->permisos($permiso);
        $array=$this->reporte->inventario_medios_proteccion()->result();      
        $this->table->set_heading('No producto',utf8('Nombre producto'),'Existencia','U/M','Precio MN','Precio MLC');       
        $this->table->set_empty("-");
        foreach ($array as $v)
        { 
         $this->table->add_row($v->id_producto,$v->nombre_producto,$v->existencia,$v->unidad_medida,$v->precio_mn,$v->precio_mlc);  
        }   
        
        $data['head']="";
        $data_form['action']=base_url('index.php/c_reporte/medios_proteccion');
        $data['title_report']=utf8('Medios de Protección');
        $data['table']=$this->table->generate();
        $data['footer']='Este reporte es generado por Yolexis_system';
        $this->load->view('v_report_template', $data);
   }
   
  function consecutivo($date_start='0000-00-00',$date_end='0000-00-00'){
    $permiso='relacion_vales';
    $this->permisos($permiso);
    $date_start=$this->input->post('date_start');
    if(!$date_start)$date_start='2021-02-01';
        $date_end=$this->input->post('date_end');   
    if(!$date_end)$date_end='CURRENT_TIMESTAMP';
    
    $this->input->post('date_end');
      $existencia=$this->reporte->consecutivo($date_start,$date_end)->result();
      $existencia= json_decode(json_encode($existencia), true);
      $existencia2=$this->reporte->consecutivo2($date_start,$date_end)->result();
      $existencia2= json_decode(json_encode($existencia2), true);
      $existencia3=$this->reporte->consecutivo3($date_start,$date_end)->result();
      $existencia3= json_decode(json_encode($existencia3), true);
      $existencia4=$this->reporte->consecutivo4($date_start,$date_end)->result();
      $existencia4= json_decode(json_encode($existencia4), true);
      $existencia5=$this->reporte->consecutivo5($date_start,$date_end)->result();
      $existencia5= json_decode(json_encode($existencia5), true);
      $existencia6=$this->reporte->consecutivo6($date_start,$date_end)->result();
      $existencia6= json_decode(json_encode($existencia6), true);

    for($i=0;$i<count($existencia);$i++){$existencia[$i]['tipo_vale']='Entrega';$existencia[$i]['direccion']='report_00';}
    for($i=0;$i<count($existencia2);$i++){$existencia2[$i]['tipo_vale']='Transferencia';$existencia2[$i]['direccion']='report_03';}
    for($i=0;$i<count($existencia3);$i++){$existencia3[$i]['tipo_vale']='Recepción';$existencia3[$i]['direccion']='report_01';}
    for($i=0;$i<count($existencia4);$i++){$existencia4[$i]['tipo_vale']='Devolución';$existencia4[$i]['direccion']='report_02';}
    for($i=0;$i<count($existencia5);$i++){$existencia5[$i]['tipo_vale']='Medios básicos';$existencia5[$i]['direccion']='report_m';}
    for($i=0;$i<count($existencia6);$i++){$existencia6[$i]['tipo_vale']='Útiles';$existencia6[$i]['direccion']='report_u';}
    
    $existencia=array_merge($existencia,$existencia2,$existencia3,$existencia4,$existencia5,$existencia6);
    
    unset($existencia2,$existencia3,$existencia4,$existencia5,$existencia6);
    
    //ordenar
    foreach ($existencia as $key => $row){
           $aux[$key] = $row['fecha_vale'];
    }
    array_multisort($aux, SORT_DESC, $existencia);
    
    $existencia=json_decode(json_encode($existencia), false);
    
    $this->table->set_heading('Fecha','Tipo vale','Número vale','Centro Costo','Equipo','Orden','Referencia');     
    $this->table->set_empty("-");
    foreach ($existencia as $v)
     { 
     $this->table->add_row($v->fecha_vale,$v->tipo_vale,$v->consecutivo,$v->nombre_centro_costo,$v->no_orden,$v->lugar,"<td><a href='$v->direccion/$v->id_vale'><button type='button' class='btn btn-success'>Ver vale</button></a></td>"); 
        } 
         
           
    $data_form['action']=base_url('index.php/c_reporte/consecutivo');
    $data_form['value_date_start']=$date_start;
    $data_form['value_date_end']=$date_end;
    $data['title_report']=utf8('Listado de vales ordenados por fecha en que se contabiliza');
    $data['head']=$this->load->view('form_periodo', $data_form,true);  
    $data['table']=$this->table->generate();
    $data['footer']="<div><strong>Este reporte es generado por Yolexis_system</strong>";
    $this->load->view('v_report_template', $data);
     }
   
   
   //existencia de productos end
   
   //Exportar
    function export_to($type_document='excel'){
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
   
   //combustible START 
   //tecnológico
 function report_05($date_start='0000-00-00',$date_end='0000-00-00'){
  $permiso='consumo_diesel';
        $this->permisos($permiso);
        $date_start=$this->input->post('date_start');
        if(!$date_start)$date_start='2021-01-01';
        $producto=$this->input->post('producto');
        $date_end=$this->input->post('date_end');   
        if(!$date_end)$date_end='CURRENT_TIMESTAMP';
        
        $this->input->post('date_end');
        $existencia=$this->reporte->combustible_tecnologico($date_start,$date_end,$producto)->result();
        $existencia= json_decode(json_encode($existencia), true);
        $existencia2=$this->reporte->combustible_tecnologico2($date_start,$date_end,$producto)->result();
        $existencia2= json_decode(json_encode($existencia2), true);
        $existencia3=$this->reporte->combustible_tecnologico3($date_start,$date_end,$producto)->result();
        $existencia3= json_decode(json_encode($existencia3), true);
        $existencia4=$this->reporte->combustible_tecnologico4($date_start,$date_end,$producto)->result();
        $existencia4= json_decode(json_encode($existencia4), true);
       
     

    for($i=0;$i<count($existencia);$i++){$existencia[$i]['direccion']='report_00';}
    for($i=0;$i<count($existencia2);$i++){$existencia2[$i]['direccion']='report_03';}
    for($i=0;$i<count($existencia3);$i++){$existencia3[$i]['direccion']='report_01';}
    for($i=0;$i<count($existencia4);$i++){$existencia4[$i]['direccion']='report_02';}
    
    $existencia=array_merge($existencia,$existencia2,$existencia3,$existencia4);
    
    unset($existencia2,$existencia3,$existencia4);
        $nombre_producto=$existencia[0]['nombre_producto'];
        foreach ($existencia as $key => $row){
           $aux[$key] = $row['fecha_vale'];
        }
        array_multisort($aux, SORT_DESC, $existencia);
        $existencia= json_decode(json_encode($existencia), false);
        
        $this->table->set_heading('No Vale','Fecha',utf8('Equipo'),'No Centro Costo','Nombre Centro Costo','Precio MN','Entrada','Salida','Valor','Total Físico','Total Valor');
     
        $this->table->set_empty("-");
        foreach ($existencia as $v)
        { 
         $this->table->add_row($v->id_vale,$v->fecha_vale,$v->nombre_equipo,$v->no_centro_costo,$v->nombre_centro_costo,$v->precio_mn,$v->entrada,$v->salida,$v->precio,$v->existencia,$v->resto,"<td><a href='$v->direccion/$v->id_vale2'><button type='button' class='btn btn-success'>Vale</button></a></td>");  
        }   
           
        $data_form['action']=base_url('index.php/c_reporte/report_05');
        $data_form['value_producto']=$producto;
        $data_form['value_date_start']=$date_start;
        $data_form['value_date_end']=$date_end;
        $data['title_report']="RESUMEN DE ENTRADA Y SALIDA DEL COMBUSTIBLE: $nombre_producto";
        $data['head']=$this->load->view('form_periodo_producto', $data_form,true);  
        $data['table']=$this->table->generate();
        $data['footer']="<div><strong>Este reporte es generado por Yolexis_system</strong>";
        $this->load->view('v_report_template', $data);
    }
	 
	 function report_06(){
	 $permiso='combustible_tecnol';
		$this->permisos($permiso);
       	$array=$this->reporte->existencia_tecnologico()->result();
		
		$this->table->set_heading('No producto',utf8('Nombre producto'),'Precio MN','Precio MLC','Existencia','Valor');
	   			
		$this->table->set_empty("-");
		foreach ($array as $v)
        { 
		 $this->table->add_row($v->id_producto,$v->nombre_producto,$v->precio_mn,$v->precio_mlc,$v->existencia,$v->valor);	
        }	
		
        $data['head']="";
		$data_form['action']=base_url('index.php/c_reporte/report_06');
		$data['title_report']=utf8('Inventario productos tecnológicos');
		$data['table']=$this->table->generate();
		$data['footer']='Este reporte es generado por Yolexis_system';
		$this->load->view('v_report_template_excel', $data);
		$datos=$this->load->view('v_report_template_excel', $data, TRUE);
		
	}
   
   
  function resumen_combustible_s($date_start='0000-00-00',$date_end='0000-00-00'){
  $permiso='resumen_salida_comb';
		$this->permisos($permiso);
        $date_start=$this->input->post('date_start');
		if(!$date_start)$date_start='2021-01-01';
        $date_end=$this->input->post('date_end');   
		if(!$date_end)$date_end='CURRENT_TIMESTAMP';
		
		$this->input->post('date_end');
		$original=$this->reporte->resumen_combustible_s($date_start,$date_end)->result();
		$this->table->set_heading('Número',utf8('Nombre'),'Cantidad','Valor MLC','Valor MN');
	   
	   $original = json_decode(json_encode($original), true);
		$result = array();
        foreach($original as $t) {
        $repeat=false;
        for($i=0;$i<count($result);$i++)
        {
        if($result[$i]['id_producto']==$t['id_producto'])
        {
        $result[$i]['cantidad']+=$t['cantidad'];
		$result[$i]['valormlc']+=$t['valormlc'];
		$result[$i]['valormn']+=$t['valormn'];
        $repeat=true;
        break;
        }
        }
         if($repeat==false)
         $result[] = array('id_producto' => $t['id_producto'], 'nombre_producto' => $t['nombre_producto'], 'cantidad' => $t['cantidad'], 'valormlc' => $t['valormlc'], 'valormn' => $t['valormn']);
        }
		$result = json_decode(json_encode($result));
        		
	    $this->table->set_empty("-");
		foreach ($result as $v)
	   { 
		 $this->table->add_row($v->id_producto,$v->nombre_producto,$v->cantidad,$v->valormlc,$v->valormn);	
        }	
	       
		$data_form['action']=base_url('index.php/c_reporte/resumen_combustible_s');
		$data_form['value_date_start']=$date_start;
	   	$data_form['value_date_end']=$date_end;
		$data['title_report']=utf8('Resumen salida de Combustible por periodo de tiempo');
		$data['head']=$this->load->view('form_periodo', $data_form,true);  
		$data['table']=$this->table->generate();
		$data['footer']="<div><strong>Este reporte es generado por Yolexis_system</strong>";
		$this->load->view('v_report_template', $data);
       
     }
	 
	 function resumen_combustible_e($date_start='0000-00-00',$date_end='0000-00-00'){
	 $permiso='resumen_entrada_comb';
		$this->permisos($permiso);
        $date_start=$this->input->post('date_start');
		if(!$date_start)$date_start='2021-01-01';
        $date_end=$this->input->post('date_end');   
		if(!$date_end)$date_end='CURRENT_TIMESTAMP';
		
		$this->input->post('date_end');
		$original=$this->reporte->resumen_combustible_e($date_start,$date_end)->result();
		$this->table->set_heading('Número',utf8('Nombre'),'Cantidad','Valor MLC','Valor MN');
	   
	   $original = json_decode(json_encode($original), true);
		$result = array();
        foreach($original as $t) {
        $repeat=false;
        for($i=0;$i<count($result);$i++)
        {
        if($result[$i]['id_producto']==$t['id_producto'])
        {
        $result[$i]['cantidad']+=$t['cantidad'];
		$result[$i]['valormlc']+=$t['valormlc'];
		$result[$i]['valormn']+=$t['valormn'];
        $repeat=true;
        break;
        }
        }
         if($repeat==false)
         $result[] = array('id_producto' => $t['id_producto'], 'nombre_producto' => $t['nombre_producto'], 'cantidad' => $t['cantidad'], 'valormlc' => $t['valormlc'], 'valormn' => $t['valormn']);
        }
		$result = json_decode(json_encode($result));
        		
	    $this->table->set_empty("-");
		foreach ($result as $v)
	   { 
		 $this->table->add_row($v->id_producto,$v->nombre_producto,$v->cantidad,$v->valormlc,$v->valormn);	
        }	
	       
		$data_form['action']=base_url('index.php/c_reporte/resumen_combustible_e');
		$data_form['value_date_start']=$date_start;
	   	$data_form['value_date_end']=$date_end;
		$data['title_report']="<div><strong>Resumen entrada de Combustible por periodo de tiempo</strong></div>";
		$data['head']=$this->load->view('form_periodo', $data_form,true);  
		$data['table']=$this->table->generate();
		$data['footer']="<div><strong>Este reporte es generado por Yolexis_system</strong>";
		$this->load->view('v_report_template', $data);
    
     }
	  //combustible END
	  
	  //Recursos Humanos
	  //reporte bolsitos
   function reporte_prod($id_reporte){
		$permiso='reporte_detallar';
		$this->permisos($permiso);
		$query=$this->reporte->reporte_3($id_reporte)->result();
		$que=$this->reporte->reporte_2($id_reporte)->result();
		$quer=$this->reporte->reporte_4($id_reporte)->result();
	  	$doble=$this->reporte->reporte_5($id_reporte)->result();
		$doble2=$this->reporte->reporte_6($id_reporte)->result();
	  	 
		$query = json_decode(json_encode($query), true);
		$que = json_decode(json_encode($que), true);
		$doble = json_decode(json_encode($doble), true);
		$doble2 = json_decode(json_encode($doble2), true);
		$quer = json_decode(json_encode($quer), true);
		$divisor=count($quer);
		
		if(count($doble2)!=''){
		for($i=0;$i<count($doble2);$i++)
		{
		$doble2[$i]['cantidad']=$doble2[$i]['tiempo']*$doble2[$i]['tarifa'];
		}
		}
		$doble2 = json_decode(json_encode($doble2));
		//aumenta el divisor pq hay trab con mas de 4 horas en trabajo extra
		if(count($doble)!=''){
		for($i=0;$i<count($doble);$i++)
		{
		$doble[$i]['extra']=($doble[$i]['monte']+$doble[$i]['remonte']+$doble[$i]['desmonte'])*2;
		if($doble[$i]['tiempo']>4){$divisor++;}
		}
		}
		
		//calculo prod bolsito
		if($query[0]['no_centro_costo']=='100081')
		{
		$cant=$query[0]['cantidad']/(count($query)-$divisor);
		$extra=(($query[0]['monte']+$query[0]['remonte']+$query[0]['desmonte'])/(count($query)-$divisor))*2;
		for($j=0;$j<count($query);$j++){
        $query[$j]['cantidad']=$cant;
		$query[$j]['extra']=$extra;
		}
						
		for($j=0;$j<count($query);$j++)
		{for($i=0;$i<count($doble);$i++)
			{
			 if($doble[$i]['id_persona']==$query[$j]['id_persona'])
			 {
			  if($doble[$i]['tiempo']<=4){
			  $query[$j]['cantidad']+=$doble[$i]['cantidad'];
			  $query[$j]['extra']+=$doble[$i]['extra'];
			  $query[$j]['tiempo']+=$doble[$i]['tiempo'];
			  }
			  else{
			  $query[$j]['cantidad']=$doble[$i]['cantidad'];
			  $query[$j]['extra']=$doble[$i]['extra'];
			  $query[$j]['tiempo']=$doble[$i]['tiempo'];
			  }
			 }				 
			}		 	
		}
		
		for($j=0;$j<count($query);$j++)
		{    $query[$j]['produccion']=$query[$j]['cantidad'];  
			 if($query[$j]['cantidad']<=1019){$query[$j]['cantidad']=($query[$j]['cantidad']*0.125)+($query[$j]['extra']);}
		     if($query[$j]['cantidad']>1019 AND $query[$j]['cantidad']<=1099){$query[$j]['cantidad']=($query[$j]['cantidad']*0.125)+($query[$j]['extra']);}
		     if($query[$j]['cantidad']>1099 AND $query[$j]['cantidad']<=1279){$query[$j]['cantidad']=($query[$j]['cantidad']*0.125)+($query[$j]['extra']);}
		     if($query[$j]['cantidad']>1279 AND $query[$j]['cantidad']<=1599){$query[$j]['cantidad']=($query[$j]['cantidad']*0.125)+($query[$j]['extra']);}
		     if($query[$j]['cantidad']>1599){$query[$j]['cantidad']=($query[$j]['cantidad']*0.125)+($query[$j]['extra']);}
			 $query[$j]['salario_fijo']='0.00';
		}
		}
				
		else if($query[0]['no_centro_costo']=='400274'){
        for($p=0;$p<count($query);$p++)
			{
			 $query[$p]['salario_fijo']=$query[$p]['tiempo']*$query[$p]['tarifa']*0.769231;	
			}
		}
		else{
			for($p=0;$p<count($query);$p++)
			{
			 $query[$p]['salario_fijo']=$query[$p]['tiempo']*$query[$p]['tarifa'];	
			} 
			
			for($j=0;$j<count($query);$j++)
		{for($i=0;$i<count($doble);$i++)
			{
			 if($doble[$i]['id_persona']==$query[$j]['id_persona'])
			 {
			  if($doble[$i]['tiempo']<=4){
			  $query[$j]['cantidad']=$doble[$i]['cantidad'];
			  $query[$j]['extra']=$doble[$i]['extra'];
			  $query[$j]['tiempo']+=$doble[$i]['tiempo'];
			  $query[$j]['salario_fijo']=$query[$j]['salario_fijo']+$doble[$i]['tiempo']*$query[$j]['tarifa'];
			  }
			  else{
			  $query[$j]['cantidad']=$doble[$i]['cantidad'];
			  $query[$j]['extra']=$doble[$i]['extra'];
			  $query[$j]['tiempo']=$doble[$i]['tiempo'];
			  $query[$j]['salario_fijo']=$doble[$i]['tiempo']*$query[$j]['tarifa'];
			 }
			 }				 
			}		 	
		}
		
		for($j=0;$j<count($query);$j++)
		{    $query[$j]['produccion']=$query[$j]['cantidad'];  
			 if($query[$j]['cantidad']<=1019){$query[$j]['cantidad']=($query[$j]['cantidad']*0.125)+($query[$j]['extra']);}
		     if($query[$j]['cantidad']>1019 AND $query[$j]['cantidad']<=1099){$query[$j]['cantidad']=($query[$j]['cantidad']*0.125)+($query[$j]['extra']);}
		     if($query[$j]['cantidad']>1099 AND $query[$j]['cantidad']<=1279){$query[$j]['cantidad']=($query[$j]['cantidad']*0.125)+($query[$j]['extra']);}
		     if($query[$j]['cantidad']>1279 AND $query[$j]['cantidad']<=1599){$query[$j]['cantidad']=($query[$j]['cantidad']*0.125)+($query[$j]['extra']);}
		     if($query[$j]['cantidad']>1599){$query[$j]['cantidad']=($query[$j]['cantidad']*0.125)+($query[$j]['extra']);}
			 
		}
			}
			
					
		for($j=0;$j<count($query);$j++){$query[$j]['total_horas']=$query[$j]['tiempo'];}
        for($j=0;$j<count($query);$j++){
        for($i=0;$i<count($que);$i++)
        {
        if ($que[$i]['id_persona']==$query[$j]['id_persona'])
        {
		if($que[$i]['clave']!='')
        {
		$query[$j]['trab_real']='-'; $query[$j]['tiempo']='-'; $query[$j]['no_centro_costo']='-'; $query[$j]['clave']=$que[$i]['clave'];$query[$j]['total_horas']='';$query[$j]['cantidad']='';		
		}
		else if($que[$i]['salario_promedio']=='si'){$query[$j]['cantidad']='';}
		else{$query[$j]['horas']=$que[$i]['horas']; $query[$j]['tiempo']='0.00'; $query[$j]['centro_costo']=$que[$i]['centro_costo'];
		    if($que[$i]['horas']>4)
			{$query[$j]['total_horas']=$que[$i]['horas'];$query[$j]['tiempo']='-';$query[$j]['no_centro_costo']='-';}else{$query[$j]['total_horas']+=$que[$i]['horas'];}}
		}
		}
		}
		$query = array_values($query);
        $result = json_decode(json_encode($query));
		
		$this->table->set_heading('No','Nombre y Apellidos','Cargo','Trab. Realiz','Horas','C.Costo','Horas','C.Costo','Total Hor','Clave','Importe');
	   	$this->table->set_empty("-");
		$i=0;
		foreach ($result as $v) {
			 $this->table->add_row(++$i,$v->nombre_persona,$v->nombre_cargo,$v->trab_real,$v->tiempo,$v->no_centro_costo,$v->horas,$v->centro_costo,$v->total_horas,$v->clave,$v->cantidad);
             }
		            
		$data_form['action']=base_url('index.php/c_reporte/reporte_prod');
		$data['title_report']="<div><strong>Reporte de producción</strong></div>";
        $data['head']='';	   
		$data['table']=$this->table->generate();
		$data['footer']="<div><strong>Este reporte es generado por Yolexis_system</strong>";
		$this->load->view('v_report_template', $data);
	}
	
		
	function procesar_reporte_prod($id_reporte){
		$permiso='procesar_reporte_prod';
		$this->permisos($permiso);
		$estado=$this->reporte->reporte_7($id_reporte)->result();
		$estado = json_decode(json_encode($estado), true);
		
		if($estado[0]['estado']!='procesado' and $estado[0]['estado']!='cancelado' ){
		$query=$this->reporte->reporte_3($id_reporte)->result();
		$quer=$this->reporte->reporte_4($id_reporte)->result();
	  	$doble=$this->reporte->reporte_5($id_reporte)->result();
		$doble2=$this->reporte->reporte_6($id_reporte)->result();
		$salario_prom=$this->reporte->reporte_8($id_reporte)->result();
		
		$query = json_decode(json_encode($query), true);
		$doble = json_decode(json_encode($doble), true);
		$doble2 = json_decode(json_encode($doble2), true);
		$quer = json_decode(json_encode($quer), true);
		$salario_prom = json_decode(json_encode($salario_prom), true);
		$divisor=count($quer);
		
		//insertar trab a salario prom
		if(count($salario_prom)!=''){
		  for($i=0;$i<count($salario_prom);$i++)
		{
		$salario_prom[$i]['cantidad']=$salario_prom[$i]['tiempo']*$salario_prom[$i]['tarifa'];
		}
		$salario_prom = json_decode(json_encode($salario_prom));
				
		foreach ($salario_prom as $v)
		{ 		    
			$datos = array( 'id_persona' => $v->id_persona, 'id_reporte' => $v->id_reporte, 'fecha_reporte'=>$v->fecha_reporte, 
			'id_brigada' => '0', 'no_centro_costo' => $v->centro_costo, 'cantidad' => '0','tiempo' => $v->tiempo, 'salario_fijo' => $v->cantidad,'salario_promedio'=> $v->salario_promedio);
			$this->db->insert('reporte_prod_proceso', $datos,'');
        }
		}
				
		if(count($doble2)!=''){
		for($i=0;$i<count($doble2);$i++)
		{
		$doble2[$i]['cantidad']=$doble2[$i]['tiempo']*$doble2[$i]['tarifa'];
		}
		}
		$doble2 = json_decode(json_encode($doble2));
		//aumenta el divisor pq hay trab con mas de 4 horas en trabajo extra
		if(count($doble)!=''){
		for($i=0;$i<count($doble);$i++)
		{
		$doble[$i]['extra']=($doble[$i]['monte']+$doble[$i]['remonte']+$doble[$i]['desmonte'])*2;
		if($doble[$i]['tiempo']>4){$divisor++;}
		}
		}
		
		//calculo prod bolsito
		if($query[0]['no_centro_costo']=='100081'){
		$cant=$query[0]['cantidad']/(count($query)-$divisor);
		$extra=(($query[0]['monte']+$query[0]['remonte']+$query[0]['desmonte'])/(count($query)-$divisor))*2;
		for($j=0;$j<count($query);$j++){
        $query[$j]['cantidad']=$cant;
		$query[$j]['extra']=$extra;
		}
						
		for($j=0;$j<count($query);$j++)
		{for($i=0;$i<count($doble);$i++)
			{
			 if($doble[$i]['id_persona']==$query[$j]['id_persona'])
			 {
			  if($doble[$i]['tiempo']<=4){
			  $query[$j]['cantidad']+=$doble[$i]['cantidad'];
			  $query[$j]['extra']+=$doble[$i]['extra'];
			  $query[$j]['tiempo']+=$doble[$i]['tiempo'];
			  }
			  else{
			  $query[$j]['cantidad']=$doble[$i]['cantidad'];
			  $query[$j]['extra']=$doble[$i]['extra'];
			  $query[$j]['tiempo']=$doble[$i]['tiempo'];
			  }
			 }				 
			}		 	
		}
		
		for($j=0;$j<count($query);$j++)
		{    $query[$j]['produccion']=$query[$j]['cantidad'];  
			 if($query[$j]['cantidad']<=1019){$query[$j]['cantidad']=($query[$j]['cantidad']*0.125)+($query[$j]['extra']);}
		     if($query[$j]['cantidad']>1019 AND $query[$j]['cantidad']<=1099){$query[$j]['cantidad']=($query[$j]['cantidad']*0.125)+($query[$j]['extra']);}
		     if($query[$j]['cantidad']>1099 AND $query[$j]['cantidad']<=1279){$query[$j]['cantidad']=($query[$j]['cantidad']*0.125)+($query[$j]['extra']);}
		     if($query[$j]['cantidad']>1279 AND $query[$j]['cantidad']<=1599){$query[$j]['cantidad']=($query[$j]['cantidad']*0.125)+($query[$j]['extra']);}
		     if($query[$j]['cantidad']>1599){$query[$j]['cantidad']=($query[$j]['cantidad']*0.125)+($query[$j]['extra']);}
			 $query[$j]['salario_fijo']='0.00';
		}
		
		
        foreach ($doble2 as $v)
		{   
		    if($v->id_persona!=''){
			$datos = array( 'id_persona' => $v->id_persona, 'id_reporte' => $v->id_reporte, 'fecha_reporte'=>$v->fecha_reporte, 
			'id_brigada' => $v->id_brigada, 'no_centro_costo' => $v->centro_costo, 'cantidad' => '0','tiempo' => $v->tiempo, 'salario_fijo' => $v->cantidad, 'produccion' => '0');
			$this->db->insert('reporte_prod_proceso', $datos,'');
            }
        }	
        }
		else if($query[0]['no_centro_costo']=='100081'){
        for($p=0;$p<count($query);$p++)
			{
			 $query[$p]['salario_fijo']=$query[$p]['tiempo']*$query[$p]['tarifa']*0.769231;	
			}
		}
		else{
			for($p=0;$p<count($query);$p++)
			{
			 $query[$p]['salario_fijo']=$query[$p]['tiempo']*$query[$p]['tarifa'];	
			} 
			
			for($j=0;$j<count($query);$j++)
		{for($i=0;$i<count($doble);$i++)
			{
			 if($doble[$i]['id_persona']==$query[$j]['id_persona'])
			 {
			  if($doble[$i]['tiempo']<=4){
			  $query[$j]['cantidad']=$doble[$i]['cantidad'];
			  $query[$j]['extra']=$doble[$i]['extra'];
			  $query[$j]['tiempo']+=$doble[$i]['tiempo'];
			  $query[$j]['salario_fijo']=$query[$j]['salario_fijo']+$doble[$i]['tiempo']*$query[$j]['tarifa'];
			  }
			  else{
			  $query[$j]['cantidad']=$doble[$i]['cantidad'];
			  $query[$j]['extra']=$doble[$i]['extra'];
			  $query[$j]['tiempo']=$doble[$i]['tiempo'];
			  $query[$j]['salario_fijo']=$doble[$i]['tiempo']*$query[$j]['tarifa'];
			 }
			 }				 
			}		 	
		}
		
		for($j=0;$j<count($query);$j++)
		{    $query[$j]['produccion']=$query[$j]['cantidad'];  
			 if($query[$j]['cantidad']<=1019){$query[$j]['cantidad']=($query[$j]['cantidad']*0.125)+($query[$j]['extra']);}
		     if($query[$j]['cantidad']>1019 AND $query[$j]['cantidad']<=1099){$query[$j]['cantidad']=($query[$j]['cantidad']*0.125)+($query[$j]['extra']);}
		     if($query[$j]['cantidad']>1099 AND $query[$j]['cantidad']<=1279){$query[$j]['cantidad']=($query[$j]['cantidad']*0.125)+($query[$j]['extra']);}
		     if($query[$j]['cantidad']>1279 AND $query[$j]['cantidad']<=1599){$query[$j]['cantidad']=($query[$j]['cantidad']*0.125)+($query[$j]['extra']);}
		     if($query[$j]['cantidad']>1599){$query[$j]['cantidad']=($query[$j]['cantidad']*0.125)+($query[$j]['extra']);}
			 
		}
			
			
        foreach ($doble2 as $v)
		{
			if($v->id_persona!=''){
			$datos = array( 'id_persona' => $v->id_persona, 'id_reporte' => $v->id_reporte, 'fecha_reporte'=>$v->fecha_reporte, 
			'id_brigada' => $v->id_brigada, 'no_centro_costo' => $v->centro_costo, 'cantidad' =>'0', 'tiempo' => $v->tiempo, 'salario_fijo' => $v->cantidad, 'produccion' => '0');
			$this->db->insert('reporte_prod_proceso', $datos,'');
        }
        }			
			}	
			
		for($j=0;$j<count($query);$j++){
        for($i=0;$i<count($quer);$i++)
        {
        if ($quer[$i]['id_persona']==$query[$j]['id_persona'])
        {
		array_splice($query[$j],  0 ,  13);
		}
		}
		}
		
		$query = json_decode(json_encode($query));
		foreach ($query as $v)
		{
			if($v->id_persona!=''){
			$datos = array( 'id_persona' => $v->id_persona, 'id_reporte' => $v->id_reporte, 'fecha_reporte'=>$v->fecha_reporte, 
			'id_brigada' => $v->id_brigada, 'no_centro_costo' => $v->no_centro_costo, 'cantidad' => $v->cantidad, 
			'tiempo' => $v->tiempo, 'salario_fijo' => $v->salario_fijo, 'produccion' => $v->produccion);
			$this->db->insert('reporte_prod_proceso', $datos,'');
            }			
		}
		
		$act = array( 'estado' => 'procesado');
		$this->db->update('reporte', $act, array('id_reporte' => $id_reporte));
		    
	    echo "<script>alert('Reporte $id_reporte procesado');</script>";
	    redirect('c_gestionar/reportes', 'refresh');
	}
	else{ echo "<script>alert('El reporte $id_reporte ya estaba procesado o cancelado');</script>";
	     redirect('c_gestionar/reportes', 'refresh');}
	}
	
	//reporte embarque
	function reporte_prod_e($id_reporte){
		$permiso='reporte_detallar';
		$this->permisos($permiso);
		$query=$this->reporte->reporte_3_e($id_reporte)->result();
		$que=$this->reporte->reporte_2_e($id_reporte)->result();
		$quer=$this->reporte->reporte_4_e($id_reporte)->result();
	  	$doble=$this->reporte->reporte_5_e($id_reporte)->result();
		$doble2=$this->reporte->reporte_6_e($id_reporte)->result();
	  	 
		$query = json_decode(json_encode($query), true);
		$que = json_decode(json_encode($que), true);
		$doble = json_decode(json_encode($doble), true);
		$doble2 = json_decode(json_encode($doble2), true);
		$quer = json_decode(json_encode($quer), true);
		$divisor=count($quer);
		
		if(count($doble2)!=''){
		for($i=0;$i<count($doble2);$i++)
		{
		$doble2[$i]['cantidad']=$doble2[$i]['tiempo']*$doble2[$i]['tarifa'];
		}
		}
		$doble2 = json_decode(json_encode($doble2));
		//aumenta el divisor pq hay trab con mas de 4 horas en trabajo extra
		if(count($doble)!=''){
		for($i=0;$i<count($doble);$i++)
		{
		$doble[$i]['extra']=($doble[$i]['monte']+$doble[$i]['remonte']+$doble[$i]['desmonte'])*2;
		if($doble[$i]['tiempo']>4){$divisor++;}
		}
		}
		//disminuye el divisor pq hay trab reportados a promedio de prod
		if(count($que)!=''){
		for($i=0;$i<count($que);$i++)
		{
		if($que[$i]['salario_promedio']=='si'){$divisor--;}
		}
		}
		
		//calculo prod embarque
		if($query[0]['no_centro_costo']=='400252')
		{
		$cant=$query[0]['sacos']/(count($query)-$divisor);
		$cant2=$query[0]['bolsitos']/(count($query)-$divisor);
		$cant3=$query[0]['camiones']/(count($query)-$divisor);
		$extra=(($query[0]['monte']+$query[0]['remonte']+$query[0]['desmonte'])/(count($query)-$divisor))*2;
		for($j=0;$j<count($query);$j++){
        $query[$j]['sacos']=$cant;
		$query[$j]['bolsitos']=$cant2;
		$query[$j]['camiones']=$cant3;
		$query[$j]['extra']=$extra;
		}
						
		for($j=0;$j<count($query);$j++)
		{for($i=0;$i<count($doble);$i++)
			{
			 if($doble[$i]['id_persona']==$query[$j]['id_persona'])
			 {
			  if($doble[$i]['tiempo']<=4){
			  $query[$j]['sacos']+=$doble[$i]['sacos'];
			  $query[$j]['bolsitos']+=$doble[$i]['bolsitos'];
			  $query[$j]['camiones']+=$doble[$i]['camiones'];
			  $query[$j]['extra']+=$doble[$i]['extra'];
			  $query[$j]['tiempo']+=$doble[$i]['tiempo'];
			  }
			  else{
			  $query[$j]['sacos']=$doble[$i]['sacos'];
			  $query[$j]['bolsitos']=$doble[$i]['bolsitos'];
			  $query[$j]['camiones']=$doble[$i]['camiones'];
			  $query[$j]['extra']=$doble[$i]['extra'];
			  $query[$j]['tiempo']=$doble[$i]['tiempo'];
			  }
			 }				 
			}		 	
		}
				
		for($j=0;$j<count($query);$j++)
		{    $query[$j]['produccion']=$query[$j]['sacos']+$query[$j]['bolsitos']+$query[$j]['camiones'];  
			 $query[$j]['cantidad']=($query[$j]['sacos']*2.4117)+($query[$j]['bolsitos']*3.2156)+($query[$j]['camiones']*4.0731)+($query[$j]['extra']);
		     $query[$j]['salario_fijo']='0.00';
		}
		
		for($j=0;$j<count($query);$j++)
		{for($i=0;$i<count($quer);$i++)
			{
			 if($quer[$i]['id_persona']==$query[$j]['id_persona'])
			 {			 
			  $query[$j]['cantidad']=0;
			 }				 
			}		 	
		}
		}
		
		else if($query[0]['no_centro_costo']=='400274'){
        for($p=0;$p<count($query);$p++)
			{
			 $query[$p]['salario_fijo']=$query[$p]['tiempo']*$query[$p]['tarifa']*0.769231;	
			}
		}
		else{
			for($p=0;$p<count($query);$p++)
			{
			 $query[$p]['salario_fijo']=$query[$p]['tiempo']*$query[$p]['tarifa'];	
			} 
			
			for($j=0;$j<count($query);$j++)
		{for($i=0;$i<count($doble);$i++)
			{
			 if($doble[$i]['id_persona']==$query[$j]['id_persona'])
			 {
			  if($doble[$i]['tiempo']<=4){
			  $query[$j]['sacos']+=$doble[$i]['sacos'];
			  $query[$j]['bolsitos']+=$doble[$i]['bolsitos'];
			  $query[$j]['camiones']+=$doble[$i]['camiones'];
			  $query[$j]['extra']+=$doble[$i]['extra'];
			  $query[$j]['tiempo']+=$doble[$i]['tiempo'];
			  }
			  else{
			  $query[$j]['sacos']=$doble[$i]['sacos'];
			  $query[$j]['bolsitos']=$doble[$i]['bolsitos'];
			  $query[$j]['camiones']=$doble[$i]['camiones'];
			  $query[$j]['extra']=$doble[$i]['extra'];
			  $query[$j]['tiempo']=$doble[$i]['tiempo'];
			  }
			 }				 
			}		 	
		}
		
		for($j=0;$j<count($query);$j++)
		{    $query[$j]['produccion']=$query[$j]['sacos']+$query[$j]['bolsitos']+$query[$j]['camiones'];  
			 $query[$j]['cantidad']=($query[$j]['sacos']*2.4117)+($query[$j]['bolsitos']*3.2156)+($query[$j]['camiones']*4.0731)+($query[$j]['extra']);
		     $query[$j]['salario_fijo']='0.00';
		}
			}
			
					
		for($j=0;$j<count($query);$j++){$query[$j]['total_horas']=$query[$j]['tiempo'];}
        for($j=0;$j<count($query);$j++){
        for($i=0;$i<count($que);$i++)
        {
        if ($que[$i]['id_persona']==$query[$j]['id_persona'])
        {
		if($que[$i]['clave']!='')
        {
		$query[$j]['trab_real']='-'; $query[$j]['tiempo']='-'; $query[$j]['no_centro_costo']='-'; $query[$j]['clave']=$que[$i]['clave'];$query[$j]['total_horas']='';$query[$j]['cantidad']='';		
		}
		else if($que[$i]['salario_promedio']=='si'){$query[$j]['cantidad']='';}
		else{$query[$j]['horas']=$que[$i]['horas']; $query[$j]['tiempo']='0.00'; $query[$j]['centro_costo']=$que[$i]['centro_costo'];
		    if($que[$i]['horas']>4)
			{$query[$j]['total_horas']=$que[$i]['horas'];$query[$j]['tiempo']='-';$query[$j]['no_centro_costo']='-';}else{$query[$j]['total_horas']+=$que[$i]['horas'];}}
		}
		}
		}
		$query = array_values($query);
        $result = json_decode(json_encode($query));
		
		$this->table->set_heading('No','Nombre y Apellidos','Cargo','Trab. Realiz','Horas','C.Costo','Horas','C.Costo','Total Hor','Clave','Imp/prod');
	   	$this->table->set_empty("-");
		$i=0;
		foreach ($result as $v) {
			 $this->table->add_row(++$i,$v->nombre_persona,$v->nombre_cargo,$v->trab_real,$v->tiempo,$v->no_centro_costo,$v->horas,$v->centro_costo,$v->total_horas,$v->clave,$v->cantidad);
             }
		            
		$data_form['action']=base_url('index.php/c_reporte/reporte_prod_e');
		$data['title_report']="<div><strong>Reporte de producción</strong></div>";
        $data['head']='';	   
		$data['table']=$this->table->generate();
		$data['footer']="<div><strong>Este reporte es generado por Yolexis_system</strong>";
		$this->load->view('v_report_template', $data);
	}
	
		
	function procesar_reporte_prod_e($id_reporte){
		$permiso='procesar_reporte_prod';
		$this->permisos($permiso);
		$estado=$this->reporte->reporte_7_e($id_reporte)->result();
		$estado = json_decode(json_encode($estado), true);
		
		if($estado[0]['estado']!='procesado' and $estado[0]['estado']!='cancelado' ){
		$query=$this->reporte->reporte_3_e($id_reporte)->result();
		$quer=$this->reporte->reporte_4_e($id_reporte)->result();
	  	$doble=$this->reporte->reporte_5_e($id_reporte)->result();
		$doble2=$this->reporte->reporte_6_e($id_reporte)->result();
		$salario_prom=$this->reporte->reporte_8_e($id_reporte)->result();
		
		
		$query = json_decode(json_encode($query), true);
		$doble = json_decode(json_encode($doble), true);
		$doble2 = json_decode(json_encode($doble2), true);
		$quer = json_decode(json_encode($quer), true);
		$salario_prom = json_decode(json_encode($salario_prom), true);
		$divisor=count($quer);
		
		//insertar trab a salario prom
		if(count($salario_prom)!=''){
		  for($i=0;$i<count($salario_prom);$i++)
		{
		$salario_prom[$i]['cantidad']=$salario_prom[$i]['tiempo']*$salario_prom[$i]['tarifa'];
		}
		$salario_prom = json_decode(json_encode($salario_prom));
				
		foreach ($salario_prom as $v)
		{ 		    
			$datos = array( 'id_persona' => $v->id_persona, 'id_reporte' => $v->id_reporte, 'fecha_reporte'=>$v->fecha_reporte, 
			'id_brigada' => '0', 'no_centro_costo' => $v->centro_costo, 'cantidad' => '0','tiempo' => $v->tiempo, 'salario_fijo' => $v->cantidad,'salario_promedio'=> $v->salario_promedio);
			$this->db->insert('reporte_prod_proceso_embarque', $datos,'');
        }
		}
				
		if(count($doble2)!=''){
		for($i=0;$i<count($doble2);$i++)
		{
		$doble2[$i]['cantidad']=$doble2[$i]['tiempo']*$doble2[$i]['tarifa'];
		}
		}
		$doble2 = json_decode(json_encode($doble2));
		//aumenta el divisor pq hay trab con mas de 4 horas en trabajo extra
		if(count($doble)!=''){
		for($i=0;$i<count($doble);$i++)
		{
		$doble[$i]['extra']=($doble[$i]['monte']+$doble[$i]['remonte']+$doble[$i]['desmonte'])*2;
		if($doble[$i]['tiempo']>4){$divisor++;}
		}
		}
		//disminuye el divisor pq hay trab reportados a promedio de prod
		if(count($salario_prom)!=''){
		for($i=0;$i<count($salario_prom);$i++)
		{
		$divisor--;
		}
		}
		
		//calculo prod embarque
		if($query[0]['no_centro_costo']=='400252')
		{
		$cant=$query[0]['sacos']/(count($query)-$divisor);
		$cant2=$query[0]['bolsitos']/(count($query)-$divisor);
		$cant3=$query[0]['camiones']/(count($query)-$divisor);
		$extra=(($query[0]['monte']+$query[0]['remonte']+$query[0]['desmonte'])/(count($query)-$divisor))*2;
		for($j=0;$j<count($query);$j++){
        $query[$j]['sacos']=$cant;
		$query[$j]['bolsitos']=$cant2;
		$query[$j]['camiones']=$cant3;
		$query[$j]['extra']=$extra;
		}
					
		for($j=0;$j<count($query);$j++)
		{for($i=0;$i<count($doble);$i++)
			{
			 if($doble[$i]['id_persona']==$query[$j]['id_persona'])
			 {
			  if($doble[$i]['tiempo']<=4){
			  $query[$j]['sacos']+=$doble[$i]['sacos'];
			  $query[$j]['bolsitos']+=$doble[$i]['bolsitos'];
			  $query[$j]['camiones']+=$doble[$i]['camiones'];
			  $query[$j]['extra']+=$doble[$i]['extra'];
			  $query[$j]['tiempo']+=$doble[$i]['tiempo'];
			  }
			  else{
			  $query[$j]['sacos']=$doble[$i]['sacos'];
			  $query[$j]['bolsitos']=$doble[$i]['bolsitos'];
			  $query[$j]['camiones']=$doble[$i]['camiones'];
			  $query[$j]['extra']=$doble[$i]['extra'];
			  $query[$j]['tiempo']=$doble[$i]['tiempo'];
			  }
			 }				 
			}		 	
		}
		
		for($j=0;$j<count($query);$j++)
		{    $query[$j]['produccion']=$query[$j]['sacos']+$query[$j]['bolsitos']+$query[$j]['camiones'];  
			 $query[$j]['cantidad']=($query[$j]['sacos']*2.4117)+($query[$j]['bolsitos']*3.2156)+($query[$j]['camiones']*4.0731)+($query[$j]['extra']);
		     $query[$j]['salario_fijo']='0.00';
		}
		
		foreach ($doble2 as $v)
		{   
		    if($v->id_persona!=''){
			$datos = array( 'id_persona' => $v->id_persona, 'id_reporte' => $v->id_reporte, 'fecha_reporte'=>$v->fecha_reporte, 
			'id_brigada' => $v->id_brigada, 'no_centro_costo' => $v->centro_costo, 'cantidad' => '0','tiempo' => $v->tiempo, 'salario_fijo' => $v->cantidad, 'produccion' => '0');
			$this->db->insert('reporte_prod_proceso_embarque', $datos,'');
            }
        }
		}        	
        
		else if($query[0]['no_centro_costo']=='400274'){
        for($p=0;$p<count($query);$p++)
			{
			 $query[$p]['salario_fijo']=$query[$p]['tiempo']*$query[$p]['tarifa']*0.769231;	
			}
		}
		else{
			for($p=0;$p<count($query);$p++)
			{
			 $query[$p]['salario_fijo']=$query[$p]['tiempo']*$query[$p]['tarifa'];	
			} 
			
			for($j=0;$j<count($query);$j++)
		{for($i=0;$i<count($doble);$i++)
			{
			 if($doble[$i]['id_persona']==$query[$j]['id_persona'])
			 {
			  if($doble[$i]['tiempo']<=4){
			  $query[$j]['cantidad']=$doble[$i]['cantidad'];
			  $query[$j]['extra']=$doble[$i]['extra'];
			  $query[$j]['tiempo']+=$doble[$i]['tiempo'];
			  $query[$j]['salario_fijo']=$query[$j]['salario_fijo']+$doble[$i]['tiempo']*$query[$j]['tarifa'];
			  }
			  else{
			  $query[$j]['cantidad']=$doble[$i]['cantidad'];
			  $query[$j]['extra']=$doble[$i]['extra'];
			  $query[$j]['tiempo']=$doble[$i]['tiempo'];
			  $query[$j]['salario_fijo']=$doble[$i]['tiempo']*$query[$j]['tarifa'];
			 }
			 }				 
			}		 	
		}
		
		for($j=0;$j<count($query);$j++)
		{    $query[$j]['produccion']=$query[$j]['sacos']+$query[$j]['bolsitos']+$query[$j]['camiones'];  
			 $query[$j]['cantidad']=($query[$j]['sacos']*2.4117)+($query[$j]['bolsitos']*3.2156)+($query[$j]['camiones']*4.0731)+($query[$j]['extra']);
		}
			
			
        foreach ($doble2 as $v)
		{
			if($v->id_persona!=''){
			$datos = array( 'id_persona' => $v->id_persona, 'id_reporte' => $v->id_reporte, 'fecha_reporte'=>$v->fecha_reporte, 
			'id_brigada' => $v->id_brigada, 'no_centro_costo' => $v->centro_costo, 'cantidad' =>'0', 'tiempo' => $v->tiempo, 'salario_fijo' => $v->cantidad, 'produccion' => '0');
			$this->db->insert('reporte_prod_proceso_embarque', $datos,'');
        }
        }			
			}	
			
		for($j=0;$j<count($query);$j++){
        for($i=0;$i<count($quer);$i++)
        {
        if ($quer[$i]['id_persona']==$query[$j]['id_persona'])
        {
		array_splice($query[$j],  0 ,  13);
		}
		}
		}
		
		$query = json_decode(json_encode($query));
		foreach ($query as $v)
		{
			if($v->id_persona!=''){
			$datos = array( 'id_persona' => $v->id_persona, 'id_reporte' => $v->id_reporte, 'fecha_reporte'=>$v->fecha_reporte, 
			'id_brigada' => $v->id_brigada, 'no_centro_costo' => $v->no_centro_costo, 'cantidad' => $v->cantidad, 
			'tiempo' => $v->tiempo, 'salario_fijo' => $v->salario_fijo, 'produccion' => $v->produccion);
			$this->db->insert('reporte_prod_proceso_embarque', $datos,'');
            }			
		}
		
		$act = array( 'estado' => 'procesado');
		$this->db->update('reporte_embarque', $act, array('id_reporte' => $id_reporte));
		    
	    echo "<script>alert('Reporte $id_reporte procesado');</script>";
	    redirect('c_gestionar/reportes_embarque', 'refresh');
	}
	else{ echo "<script>alert('El reporte $id_reporte ya estaba procesado o cancelado');</script>";
	     redirect('c_gestionar/reportes_embarque', 'refresh');}
	}
/*function cancelar_reportes_forzar(){
	    $permiso='reporte_editar2';
		$this->permisos($permiso);
        $id_reporte=$this->input->post('id_reporte');
		if(!$id_reporte)$id_reporte='';
	    
		$estado=$this->reporte->cancelar_reportes_forzar($id_reporte)->result();		
		
		
		$this->db->delete('reporte_prod_proceso', array('id_reporte' => $id_reporte));
		$data = array('estado' => '');
        $this->db->update('reporte', $data, array('id_reporte' => $id_reporte));
		echo "<script>alert('Reporte $id_reporte debe ser editado y procesado nuevamente');</script>";
		redirect('c_gestionar/reportes', 'refresh');
        		
	    
        $data_form['action']=base_url('index.php/c_reporte/cancelar_reportes_forzar');
		$data_form['value_id_reporte']=$id_reporte;
		$data['title_report']="<div><strong>UEB Salinera Joa</strong><font color='#FFFFFF' align='left'>..............</font><strong>Prenómina de producción</strong></div>";
		$data['head']="<div><strong>Área: </strong><strong><font color='#FFFFFF' align='left'>.................</font>Fecha: </strong>".invert_date($date_start,'/')." - ".invert_date($date_end,'/')."</div>"; 
		$data['table']=$this->table->generate();
		$data['footer']=$this->load->view('form_periodo5', $data_form,true);
		$this->load->view('v_report_template', $data);
	}*/

	
function pre_nomina($date_start='0000-00-00',$date_end='0000-00-00'){
	 $permiso='procesar_reporte_prod';
		$this->permisos($permiso);
        $date_start=$this->input->post('date_start');
		if(!$date_start)$date_start='CURRENT_TIMESTAMP';
		$nombre_brigada=$this->input->post('nombre_brigada');
		$date_end=$this->input->post('date_end');   
		if(!$date_end)$date_end='CURRENT_TIMESTAMP';
		//Selecciona la consulta segun la brigada que se busque
		if($nombre_brigada==''){$query=$this->reporte->pre_nomina($date_start,$date_end)->result();
		$query = json_decode(json_encode($query), true);
		$brigada='Multiples';
		}
		
		else{$query=$this->reporte->resumen_salario($nombre_brigada,$date_start,$date_end)->result();
		$query = json_decode(json_encode($query), true);
		$brigada=$query[0]['nombre_brigada'];
		}
		
		for($i=0;$i<count($query);$i++){
			if($query[$i]['no_centro_costo']!='400209'){
			$query[$i]['salario_fijo_prod']=$query[$i]['tiempo']*$query[$i]['tarifa'];}
        }	
    	
		$result = array();
		foreach($query as $t) {
        $repeat=false;
        for($i=0;$i<count($result);$i++)
        {
        if($result[$i]['id_persona']==$t['id_persona'])
        {
        $result[$i]['produccion']+=$t['produccion'];
		$result[$i]['salario_fijo']+=$t['salario_fijo'];
		$result[$i]['salario_fijo_prod']+=$t['salario_fijo_prod'];
		$result[$i]['tiempo']+=$t['tiempo'];
		$repeat=true;
        break;
        }
		}
         if($repeat==false)
         $result[] = array('id_persona' => $t['id_persona'], 'nombre_persona' => $t['nombre_persona'], 'fecha_reporte' => $t['fecha_reporte'], 'produccion' => $t['produccion'],
	     'tiempo' => $t['tiempo'], 'nombre_brigada' => $t['nombre_brigada'], 'no_centro_costo' => $t['no_centro_costo'], 'salario_fijo' => $t['salario_fijo'], 'salario_fijo_prod' => $t['salario_fijo_prod']);
        }
						   	 		
		$result = json_decode(json_encode($result));
	    $this->table->set_heading('No',utf8('Nombre'),'Horas','S/B (100081)','S/B (5409)','Total SF','Pago X resul','Producción','Total');
	    $this->table->set_empty("-");
		$i=1;
		foreach ($result as $v)
	   { 
		 $this->table->add_row($i++,$v->nombre_persona,$v->tiempo,$v->salario_fijo_prod,$v->salario_fijo,($v->salario_fijo+$v->salario_fijo_prod),($v->produccion-$v->salario_fijo_prod),$v->produccion,$v->produccion+$v->salario_fijo);	
        }	
	       
		$data_form['action']=base_url('index.php/c_reporte/pre_nomina');
		$data_form['value_date_start']=$date_start;
	   	$data_form['value_date_end']=$date_end;
		$data_form['value_nombre_brigada']=$nombre_brigada;
		$data['title_report']="<div><strong>UEB Salinera Joa</strong><font color='#FFFFFF' align='left'>..............</font><strong>Prenómina de producción</strong></div>";
		$data['head']="<div><strong>Casif:O </strong><font color='#FFFFFF' align='left'>........</font><strong>Grupo:III </strong><font color='#FFFFFF' align='left'>..........</font><strong>Área: </strong>$brigada <strong><font color='#FFFFFF' align='left'>.................</font>Fecha: </strong>".invert_date($date_start,'/')." - ".invert_date($date_end,'/')."</div>"; 
		$data['table']=$this->table->generate();
		$data['footer']=$this->load->view('form_periodo2', $data_form,true);
		$this->load->view('v_report_template', $data);
    }

function resumen_salario($date_start='0000-00-00',$date_end='0000-00-00'){
	 $permiso='procesar_reporte_prod';
		$this->permisos($permiso);
        $date_start=$this->input->post('date_start');
		if(!$date_start)$date_start='CURRENT_TIMESTAMP';
		$nombre_brigada=$this->input->post('nombre_brigada');
		$date_end=$this->input->post('date_end');   
		if(!$date_end)$date_end='CURRENT_TIMESTAMP';
		//Selecciona la consulta segun la brigada que se busque
		if($nombre_brigada==''){$query=$this->reporte->pre_nomina($date_start,$date_end)->result();
		$query = json_decode(json_encode($query), true);
		$brigada='Multiples';
		}
		
		else{$query=$this->reporte->resumen_salario($nombre_brigada,$date_start,$date_end)->result();
		$query = json_decode(json_encode($query), true);
		$brigada=$query[0]['nombre_brigada'];
		}
		
		for($i=0;$i<count($query);$i++){
			if($query[$i]['no_centro_costo']!='400209'){
			$query[$i]['salario_fijo_prod']=$query[$i]['tiempo']*$query[$i]['tarifa'];}
        }	
    	
		$result = array();
		foreach($query as $t) {
        $repeat=false;
        for($i=0;$i<count($result);$i++)
        {
        if($result[$i]['id_persona']==$t['id_persona'])
        {
        $result[$i]['produccion']+=$t['produccion'];
		$result[$i]['salario_fijo']+=$t['salario_fijo'];
		$result[$i]['salario_fijo_prod']+=$t['salario_fijo_prod'];
		$result[$i]['tiempo']+=$t['tiempo'];
		$repeat=true;
        break;
        }
		}
         if($repeat==false)
         $result[] = array('id_persona' => $t['id_persona'], 'nombre_persona' => $t['nombre_persona'], 'nombre_cargo' => $t['nombre_cargo'], 'tarifa' => $t['tarifa'], 'fecha_reporte' => $t['fecha_reporte'], 'produccion' => $t['produccion'],
	     'tiempo' => $t['tiempo'], 'nombre_brigada' => $t['nombre_brigada'], 'no_centro_costo' => $t['no_centro_costo'], 'salario_fijo' => $t['salario_fijo'], 'salario_fijo_prod' => $t['salario_fijo_prod']);
        }
		
						   	 		
		$result = json_decode(json_encode($result));
	    $this->table->set_heading('No',utf8('Nombre'),'Cargo','Tarifa','Horas','S/B/P','S/B/F','Total SB','Pago adic.','PR X T H','%30','T A Pagar' );
	    $this->table->set_empty("-");
		$i=1;
		foreach ($result as $v)
	   { 
		 $this->table->add_row($i++,$v->nombre_persona,$v->nombre_cargo,$v->tarifa,$v->tiempo,$v->salario_fijo_prod,$v->salario_fijo,($v->salario_fijo+$v->salario_fijo_prod),($v->produccion-$v->salario_fijo_prod),($v->produccion+$v->salario_fijo),($v->produccion+$v->salario_fijo)*0.3,($v->produccion+$v->salario_fijo)*1.3);	
        }	
	    
		$data_form['action']=base_url('index.php/c_reporte/resumen_salario');
		$data_form['value_date_start']=$date_start;
	   	$data_form['value_date_end']=$date_end;
		$data_form['value_nombre_brigada']=$nombre_brigada;
		$data['title_report']="<div><strong>UEB Salinera Joa</strong><font color='#FFFFFF' align='left'>..............</font><strong>Resumen Salario(Prenómina)</strong></div>";
		$data['head']="<div><strong>Casif:O </strong><font color='#FFFFFF' align='left'>........</font><strong>Grupo:III </strong><font color='#FFFFFF' align='left'>..........</font><strong>Área: </strong>$brigada <strong><font color='#FFFFFF' align='left'>.................</font>Fecha: </strong>".invert_date($date_start,'/')." - ".invert_date($date_end,'/')."</div>"; 
		$data['table']=$this->table->generate();
		$data['footer']=$this->load->view('form_periodo2', $data_form,true);
		$this->load->view('v_report_template', $data);
    
     }
	 
	 function salario_promedio_bolsito($date_start='0000-00-00',$date_end='0000-00-00'){
	 $permiso='procesar_reporte_prod';
		$this->permisos($permiso);
        $date_start=$this->input->post('date_start');
		if(!$date_start)$date_start='CURRENT_TIMESTAMP';
		$id_persona=$this->input->post('id_persona');
		if(!$id_persona)$id_persona='';
		$date_end=$this->input->post('date_end');   
		if(!$date_end)$date_end='CURRENT_TIMESTAMP';
		
		//Selecciona la consulta según trab que se busque
		if($id_persona==''){$query=$this->reporte->trab_promedio2($date_start,$date_end)->result();
		$query = json_decode(json_encode($query), true);
		}
		
		else{$query=$this->reporte->trab_promedio($id_persona,$date_start,$date_end)->result();
		$query = json_decode(json_encode($query), true);
		}
		
		$cumpl=$this->reporte->sobrecumplimiento($date_start,$date_end)->result();
		$cumpl = json_decode(json_encode($cumpl), true);
		for($i=0;$i<count($cumpl);$i++){$cumpl[$i]['cant_trab']='1';}		
		//Agrupa por fecha y suma la produccion y los trabajadores
		$result = array();
		foreach($cumpl as $t){
        $repeat=false;
        for($i=0;$i<count($result);$i++)
        {
        if($result[$i]['fecha_reporte']==$t['fecha_reporte'])
        {
        $result[$i]['produccion']+=$t['produccion'];
		$result[$i]['cant_trab']++;
		//$result[$i]['tiempo']+=$t['tiempo'];
		$repeat=true;
        break;
        }
		}
         if($repeat==false)
         $result[] = array('produccion' => $t['produccion'], 'fecha_reporte' => $t['fecha_reporte'], 'cant_trab' => $t['cant_trab']);
        }
		
		for($j=0;$j<count($query);$j++)
		{for($i=0;$i<count($result);$i++)
			{
			 if($result[$i]['fecha_reporte']==$query[$j]['fecha_reporte'])
			 {
				 if($result[$i]['produccion']!='0')
				 {
			  $query[$j]['valor']=$result[$i]['produccion']/($result[$i]['cant_trab']*900);
			  if($query[$j]['valor']>1){$query[$j]['valor']=$query[$j]['valor']*$query[$j]['salario_fijo'];}
			  else{$query[$j]['valor']='0';}
			     }else{$query[$j]['valor']='0';}
      		 }				 
			}		 	
		}
		//agrupar valores y sumar 
		$result = array();
		foreach($query as $t){
        $repeat=false;
        for($i=0;$i<count($result);$i++)
        {
        if($result[$i]['id_persona']==$t['id_persona'])
        {
        $result[$i]['valor']+=$t['valor'];
		$result[$i]['tiempo']+=$t['tiempo'];
		$result[$i]['salario_fijo']+=$t['salario_fijo'];
		$repeat=true;
        break;
        }
		}
         if($repeat==false)
         $result[] = array('id_persona' => $t['id_persona'], 'nombre_persona' => $t['nombre_persona'], 'nombre_cargo' => $t['nombre_cargo'], 'tarifa' => $t['tarifa'], 'salario_fijo' => $t['salario_fijo'], 'tiempo' => $t['tiempo'], 'fecha_reporte' => $t['fecha_reporte'], 'valor' => $t['valor']);
        }
		
		$result = json_decode(json_encode($result));
		$this->table->set_heading('No',utf8('Nombre'),'Cargo','Tarifa','Horas','Salario Fijo','Pago adic.','Total','%30','T A Pagar' );
	    $this->table->set_empty("-");
		$i=1;
		foreach ($result as $v)
	    { 
		 $this->table->add_row($i++,$v->nombre_persona,$v->nombre_cargo,$v->tarifa,$v->tiempo,$v->salario_fijo,$v->valor,($v->salario_fijo+$v->valor),($v->salario_fijo+$v->valor)*0.3,($v->salario_fijo+$v->valor)*1.3);	
        }	
	    
		$data_form['action']=base_url('index.php/c_reporte/salario_promedio_bolsito');
		$data_form['value_date_start']=$date_start;
	   	$data_form['value_date_end']=$date_end;
		$data_form['value_id_persona']=$id_persona;
		$data['title_report']="<div><strong>UEB Salinera Joa</strong><font color='#FFFFFF' align='left'>..............</font><strong>Resumen Salario(Prenómina)</strong></div>";
		$data['head']="<div><strong>Casif:O </strong><font color='#FFFFFF' align='left'>.........................................................................</font><strong>Salario por promedio de producción </strong><font color='#FFFFFF' align='left'>.................</font>Fecha: </strong>".invert_date($date_start,'/')." - ".invert_date($date_end,'/')."</div>"; 
		$data['table']=$this->table->generate();
		$data['footer']=$this->load->view('form_periodo3', $data_form,true);
		$this->load->view('v_report_template', $data);
    
     }
	 
	 function resumen_salario_embarque($date_start='0000-00-00',$date_end='0000-00-00'){
	 $permiso='procesar_reporte_prod';
		$this->permisos($permiso);
        $date_start=$this->input->post('date_start');
		if(!$date_start)$date_start='CURRENT_TIMESTAMP';
		$date_end=$this->input->post('date_end');   
		if(!$date_end)$date_end='CURRENT_TIMESTAMP';
		
		$query=$this->reporte->pre_nomina_e($date_start,$date_end)->result();
		$query = json_decode(json_encode($query), true);
		$brigada='Embarque';
		
		
		for($i=0;$i<count($query);$i++){
			if($query[$i]['no_centro_costo']!='400215'){
			$query[$i]['salario_fijo_prod']=$query[$i]['tiempo']*$query[$i]['tarifa'];}
        }	
    	
		$result = array();
		foreach($query as $t) {
        $repeat=false;
        for($i=0;$i<count($result);$i++)
        {
        if($result[$i]['id_persona']==$t['id_persona'])
        {
        $result[$i]['produccion']+=$t['produccion'];
		$result[$i]['salario_fijo']+=$t['salario_fijo'];
		$result[$i]['salario_fijo_prod']+=$t['salario_fijo_prod'];
		$result[$i]['tiempo']+=$t['tiempo'];
		$repeat=true;
        break;
        }
		}
         if($repeat==false)
         $result[] = array('id_persona' => $t['id_persona'], 'nombre_persona' => $t['nombre_persona'], 'nombre_cargo' => $t['nombre_cargo'], 'tarifa' => $t['tarifa'], 'fecha_reporte' => $t['fecha_reporte'], 'produccion' => $t['produccion'],
	     'tiempo' => $t['tiempo'], 'nombre_brigada' => $t['nombre_brigada'], 'no_centro_costo' => $t['no_centro_costo'], 'salario_fijo' => $t['salario_fijo'], 'salario_fijo_prod' => $t['salario_fijo_prod']);
        }
		
						   	 		
		$result = json_decode(json_encode($result));
	    $this->table->set_heading('No',utf8('Nombre'),'Cargo','Tarifa','Horas','S/B/P','S/B/F','Total SB','Pago adic.','PR X T H','%30','T A Pagar' );
	    $this->table->set_empty("-");
		$i=1;
		foreach ($result as $v)
	   { 
		 $this->table->add_row($i++,$v->nombre_persona,$v->nombre_cargo,$v->tarifa,$v->tiempo,$v->salario_fijo_prod,$v->salario_fijo,($v->salario_fijo+$v->salario_fijo_prod),($v->produccion-$v->salario_fijo_prod),($v->produccion+$v->salario_fijo),($v->produccion+$v->salario_fijo)*0.3,($v->produccion+$v->salario_fijo)*1.3);	
        }	
	    
		$data_form['action']=base_url('index.php/c_reporte/resumen_salario_embarque');
		$data_form['value_date_start']=$date_start;
	   	$data_form['value_date_end']=$date_end;
		$data['title_report']="<div><strong>UEB Salinera Joa</strong><font color='#FFFFFF' align='left'>..............</font><strong>Resumen Salario(Prenómina)</strong></div>";
		$data['head']="<div><strong>Casif:O </strong><font color='#FFFFFF' align='left'>........</font><strong>Grupo:III </strong><font color='#FFFFFF' align='left'>..........</font><strong>Área: </strong>$brigada <strong><font color='#FFFFFF' align='left'>.................</font>Fecha: </strong>".invert_date($date_start,'/')." - ".invert_date($date_end,'/')."</div>"; 
		$data['table']=$this->table->generate();
		$data['footer']=$this->load->view('form_periodo_embarque', $data_form,true);
		$this->load->view('v_report_template', $data);
    
     }
	 //En desuso
	 function salario_promedio_embarque($date_start='0000-00-00',$date_end='0000-00-00'){
	 $permiso='procesar_reporte_prod';
		$this->permisos($permiso);
        $date_start=$this->input->post('date_start');
		if(!$date_start)$date_start='CURRENT_TIMESTAMP';
		$date_end=$this->input->post('date_end');   
		if(!$date_end)$date_end='CURRENT_TIMESTAMP';
		
		$query=$this->reporte->trab_promedio_e($date_start,$date_end)->result();
		$query = json_decode(json_encode($query), true);
		
		$cumpl=$this->reporte->sobrecumplimiento_e($date_start,$date_end)->result();
		$cumpl = json_decode(json_encode($cumpl), true);
		for($i=0;$i<count($cumpl);$i++){$cumpl[$i]['cant_trab']='1';}		
		
		$result = array();
		foreach($cumpl as $t){
        $repeat=false;
        for($i=0;$i<count($result);$i++)
        {
        if($result[$i]['fecha_reporte']==$t['fecha_reporte'])
        {
        $result[$i]['produccion']+=$t['produccion'];
		$result[$i]['cant_trab']++;
		//$result[$i]['tiempo']+=$t['tiempo'];
		$repeat=true;
        break;
        }
		}
         if($repeat==false)
         $result[] = array('produccion' => $t['produccion'], 'fecha_reporte' => $t['fecha_reporte'], 'cant_trab' => $t['cant_trab']);
        }
		
		for($j=0;$j<count($query);$j++)
		{for($i=0;$i<count($result);$i++)
			{
			 if($result[$i]['fecha_reporte']==$query[$j]['fecha_reporte'])
			 {
				 if($result[$i]['produccion']!='0')
				 {
			  $query[$j]['valor']=$result[$i]['produccion']/($result[$i]['cant_trab']*900);
			  if($query[$j]['valor']>1){$query[$j]['valor']=$query[$j]['valor']*$query[$j]['salario_fijo'];}
			  else{$query[$j]['valor']='0';}
			     }else{$query[$j]['valor']='0';}
      		 }				 
			}		 	
		}
		//agrupar valores y sumar 
		$result = array();
		foreach($query as $t){
        $repeat=false;
        for($i=0;$i<count($result);$i++)
        {
        if($result[$i]['id_persona']==$t['id_persona'])
        {
        $result[$i]['valor']+=$t['valor'];
		$result[$i]['tiempo']+=$t['tiempo'];
		$result[$i]['salario_fijo']+=$t['salario_fijo'];
		$repeat=true;
        break;
        }
		}
         if($repeat==false)
         $result[] = array('id_persona' => $t['id_persona'], 'nombre_persona' => $t['nombre_persona'], 'nombre_cargo' => $t['nombre_cargo'], 'tarifa' => $t['tarifa'], 'salario_fijo' => $t['salario_fijo'], 'tiempo' => $t['tiempo'], 'fecha_reporte' => $t['fecha_reporte'], 'valor' => $t['valor']);
        }
		
		$result = json_decode(json_encode($result));
		$this->table->set_heading('No',utf8('Nombre'),'Cargo','Tarifa','Horas','Salario Fijo','Pago adic.','Total','%30','T A Pagar' );
	    $this->table->set_empty("-");
		$i=1;
		foreach ($result as $v)
	    { 
		 $this->table->add_row($i++,$v->nombre_persona,$v->nombre_cargo,$v->tarifa,$v->tiempo,$v->salario_fijo,$v->valor,($v->salario_fijo+$v->valor),($v->salario_fijo+$v->valor)*0.3,($v->salario_fijo+$v->valor)*1.3);	
        }	
	    
		$data_form['action']=base_url('index.php/c_reporte/salario_promedio_embarque');
		$data_form['value_date_start']=$date_start;
	   	$data_form['value_date_end']=$date_end;
		$data['title_report']="<div><strong>UEB Salinera Joa</strong><font color='#FFFFFF' align='left'>..............</font><strong>Resumen Salario(Prenómina)</strong></div>";
		$data['head']="<div><strong>Casif:O </strong><font color='#FFFFFF' align='left'>.........................................................................</font><strong>Salario por promedio de producción </strong><font color='#FFFFFF' align='left'>.................</font>Fecha: </strong>".invert_date($date_start,'/')." - ".invert_date($date_end,'/')."</div>"; 
		$data['table']=$this->table->generate();
		$data['footer']=$this->load->view('form_periodo3', $data_form,true);
		$this->load->view('v_report_template', $data);
    }
	 
	  function relacion(){
		$permiso='trabajador_ver';
		$this->permisos($permiso);
		$raza=$this->input->post('raza');
		if(!$raza)$raza='';
		$sexo=$this->input->post('sexo');
		if(!$sexo)$sexo='';
		$area=$this->input->post('area');
		if(!$area)$area='';
		
		if($raza!='' and $sexo!='' and $area!=''){$query=$this->reporte->trab_raza1($raza, $sexo, $area)->result();}
		else if($sexo!='' and $raza=='' and $area==''){$query=$this->reporte->trab_raza2($sexo)->result();}
		else if($raza!='' and $sexo=='' and $area==''){$query=$this->reporte->trab_raza3($raza)->result();}
		else if($area!='' and $sexo=='' and $raza==''){$query=$this->reporte->trab_raza4($area)->result();}
		else if($area=='' and $sexo!='' and $raza!=''){$query=$this->reporte->trab_raza5($raza, $sexo)->result();}
		else if($raza!='' and $sexo=='' and $area!=''){$query=$this->reporte->trab_raza6($raza, $area)->result();}
		else if($raza=='' and $sexo!='' and $area!=''){$query=$this->reporte->trab_raza7($sexo, $area)->result();}
		
		else{$query=$this->reporte->trab_raza()->result();}
		
		$this->table->set_heading('No','Nombre y Apellidos','Carnet Identidad','Sexo','Estado','Raza');
	    
		$this->table->set_empty("-");
		$i=0;
		//$j=0;
		foreach ($query as $v) {
			//$j++;
			//if($j=='21'){$this->table->add_row('NO','NOMBRE Y APELLIDOS','CARNET IDENTIDAD','SEXO','ESTADO','RAZA');$j=1;}
			 $this->table->add_row(++$i,$v->nombre_persona,$v->no_persona,$v->sexo,$v->estado,$v->raza);
             }
		            
		$data_form['action']=base_url('index.php/c_reporte/relacion');
		$data_form['value_raza']=$raza;
		$data_form['value_sexo']=$sexo;
		$data_form['value_area']=$area;
		$data['title_report']="<div><strong>Relación de trabajadores</strong></div>";
        $data['head']=$this->load->view('form_periodo4', $data_form,true);;	   
		$data['table']=$this->table->generate();
		$data['footer']='';
		$this->load->view('v_report_template', $data);
	}
	 
   
//Recursos humanos end

//Búsqueda de errores
/*function error_vale_estado(){
       	$array=$this->reporte->error_vale_estado()->result();
		
		$this->table->set_heading('No producto',utf8('Nombre producto'),'Fecha del vale','Estado');
	   	
		foreach ($array as $v)
        { 
		 $this->table->add_row($v->id_producto,$v->nombre_producto,$v->fecha_vale,$v->estado);	
        }	
		
        $data['head']="";
		$data_form['action']=base_url('index.php/c_reporte/error_vale_entrada');
		$data['title_report']=utf8('Vales de combustible sin asignar a un equipo');
		$data['table']=$this->table->generate();
		$data['footer']='Este reporte es generado por Yolexis_system';
		$this->load->view('v_report_template', $data);
   }*/
   
function generar_qr($valores,$user){
        $params['data'] = $valores;
        $params['level'] = 'H';
        $params['size'] = 10;
        $dir="qr_code/$user/";

        if (!file_exists($dir)) {mkdir($dir);}

        $params['savename'] = FCPATH.$dir."temp.png";
        $this->ciqrcode->generate($params);
}

function permisos($permiso){
		$user=$this->session->userdata('useralias');
	$flag=0;
	    $query=$this->reporte->rol($user)->result();
		foreach ($query as $v)
		{
		$rol=$v->rol;
		}
		$query=$this->reporte->permiso($user)->result();
		foreach ($query as $v)
		{
		if($v->permiso==$permiso){$flag=1;}
		}
		if ($flag!==1 and $rol!=='administrador'){
			echo "<script>alert('No tiene autorización para realizar esta operación.');</script>";
		redirect('/c_global/home/', 'refresh');}
	}
}
/*
End of file c_fire_creator.php
Location: ./application/controllers/c_fire_creator.php
*/ 
?>
