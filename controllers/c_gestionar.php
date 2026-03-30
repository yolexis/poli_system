<?php
class c_gestionar extends CI_Controller {
   public function __construct(){
      parent::__construct();     
      $this->load->database();
      $this->load->library('grocery_CRUD','cart');
      $this->load->helper(array('cookie'));
	  $this->load->model('m_reporte','reporte');
      // $this->output->enable_profiler(TRUE);
   }
   
   function prueba(){
   	echo invert_date('2003-01-02','/');
	echo "<pre>";	    
        print_r($id_producto);
        echo "</pre>";
   }
   
	function load_interfaz($output = null){ $this->load->view('v_interfaz',$output); }
		
	function equipos_informaticos(){
	$permiso='admin';
		$this->permisos($permiso);
		$this->load_cookie('equipos_informaticos','id_equipos_informaticos','inventario');		
		$crud = new grocery_CRUD();
		$crud->set_theme('twitter-bootstrap');
		$crud->set_table('equipos_informaticos');
		$crud->set_relation('responsable','personas','{nombre_persona}');
		$crud->set_relation('id_puesto_trabajo','puesto_trabajo','{nombre_puesto_trabajo}');
		$crud->columns('id_puesto_trabajo','responsable','tipo_equipo','inventario','no_sello','no_serie','mother_board');
		//$crud->set_relation_n_n('Productos', 'rotacion_producto', 'productos', 'id_rotacion', 'no_producto', '{id_producto}({nombre_producto})',null,null, true);
		//$crud->display_as('no_sello','Puesto Trab');
		$crud->display_as('id_puesto_trabajo','Puesto Trab');
		$crud->display_as('nombre_equipos_informaticos','Nombre');
		$crud->required_fields('responsable','inventario','area');
		$crud->set_rules('inventario','Inventario','required|callback_unique');
		//$crud->add_action(utf8('Rotar producto'),'#49afcd', 'c_reporte/preparar_rotacion','fa fa-thumbs-up');
		
		
	 	$output = $crud->render();
		$operation = $this->get_operation();
		$output->position=breadcrumb('Operaciones','equipos_informaticos',$operation);
		$this->load_interfaz($output);
	}

	function puesto_trabajo(){
	$permiso='admin';
		$this->permisos($permiso);
		$this->load_cookie('puesto_trabajo','id_puesto_trabajo','nombre_puesto_trabajo');		
		$crud = new grocery_CRUD();
		$crud->set_theme('twitter-bootstrap');
		$crud->set_table('puesto_trabajo');
		$crud->set_relation('id_area','areas','{nombre_area}');
		$crud->set_relation('no_local','locales','{nombre_local}');
		$crud->display_as('area','Área');
		$crud->required_fields('area');
		$crud->add_action(utf8('Crear expediente'),'#49afcd', 'c_exportar/expediente_tic','fa fa-thumbs-up');
		
		
	 	$output = $crud->render();
		$operation = $this->get_operation();
		$output->position=breadcrumb('Operaciones','puesto_trabajo',$operation);
		$this->load_interfaz($output);
	}

	function rotacion(){
	$permiso='rotacion';
		$this->permisos($permiso);
		$this->load_cookie('rotacion','id_rotacion','id_rotador');		
		$crud = new grocery_CRUD();
		$crud->set_theme('twitter-bootstrap');
		$crud->set_table('rotacion');
		$crud->field_type('id_rotacion', 'hidden', '');
		$crud->field_type('estado', 'hidden', '');
		//$crud->field_type('fecha', 'hidden', '');
		$crud->set_relation('id_rotador','personas','{nombre_persona}',array('permiso_almacen'=>'despachador'));
		$crud->set_relation_n_n('Productos', 'rotacion_producto', 'productos', 'id_rotacion', 'no_producto', '{id_producto}({nombre_producto})',null,null, true);
		$crud->display_as('id_rotador','Ejecuta');
		$crud->required_fields('id_rotador','fecha');
		$crud->add_action(utf8('Rotar producto'),'#49afcd', 'c_reporte/preparar_rotacion','fa fa-thumbs-up');
		/*$crud->add_action(utf8('Detallar Vale'),'', 'c_reporte/report_00/','fa fa-eye');
		$crud->callback_before_insert(array($this,'validate_insert_vales_e'));
		$crud->callback_before_update(array($this,'validate_update_vales_e'));
		$crud->add_action(utf8('Cancelar Vale'),'#BB0000', 'c_gestionar/validate_cancelar_vales_e','fa fa-undo');*/
		
	 	$output = $crud->render();
		$operation = $this->get_operation();
		$output->position=breadcrumb('Operaciones','rotacion',$operation);
		$this->load_interfaz($output);
	}			
	
	function usuario(){
		$permiso='adm_usuarios';
		$this->permisos($permiso);
		$this->load_cookie('usuarios','id_usuario','alias_usuario');
		$crud = new grocery_CRUD();
		$crud->set_theme('twitter-bootstrap');
		$crud->set_table('usuarios');
		$crud->set_relation('id_rol','roles','rol','id_rol!=1');
		$crud->set_relation_n_n('Permisos', 'usuarios_permisos', 'permisos', 'id_usuario', 'id_permiso', 'permiso', null, null, true);
		$crud->set_rules('alias_usuario','Alias','required|callback_unique');
		$crud->set_rules('password',utf8('Contraseña'),'required');
		$crud->set_rules('nombre_usuario','Nombre','required');
		$crud->set_rules('id_rol','Rol','required');
	 	$crud->columns('nombre_usuario','alias_usuario','id_rol');
	 	$crud->field_type('contrasena', 'password');
	 	$crud->callback_before_insert(array($this,'encrypt_password_callback'));
    	$crud->callback_before_update(array($this,'encrypt_password_callback'));
    	$crud->callback_edit_field('contrasena',array($this,'clear_password_callback'));
	 	$crud->add_action(utf8('Eliminar usuario'),'#BB0000', 'c_gestionar/eliminar_usuario','fa fa-thumbs-down');
		$crud->required_fields('nombre_usuario','contrasena','id_rol','alias_usuario');
	 	$operation = $this->get_operation();
		$output = $crud->render();

		$output ->position=breadcrumb('Administrar','Usuario',$operation);
		$this->load_interfaz($output);
	}
	
	function eliminar_usuario($id){
		$permiso='adm_usuarios';
		$this->permisos($permiso);
        $query="DELETE FROM `usuarios` WHERE`id_usuario`=$id";
		$this->db->query($query);
		echo "<script>alert('Se ha eliminado el usuario');</script>";
		redirect('/c_gestionar/usuarios/', 'refresh');	 
	}	
	//Recursos Humanos
	function personas(){
	$permiso='trabajador_ver';
		$this->permisos($permiso);
		$this->load_cookie('personas','id_persona','no_persona');		
		$crud = new grocery_CRUD();
		$crud->set_theme('twitter-bootstrap');
		$crud->set_table('personas');
		$crud->field_type('permiso_almacen', 'hidden', '');
		$crud->set_relation('id_area','areas','nombre_area');
		$crud->set_relation('id_categ_ocup','categ_ocup','nombre_categ_ocup');
		$crud->set_relation('id_nivel_prep','nivel_prep','nombre_nivel_prep');
		$crud->set_relation('id_grupo_escala','grupo_escala','nombre_grupo_escala');
		$crud->set_relation('id_brigada','brigada','nombre_brigada');
		$crud->set_relation('id_cargo','cargos','nombre_cargo');
		$crud->required_fields('no_persona','nombre_persona','sexo','estado_civil','vinculo_empresarial','id_cargo','nivel_preparacion');
		$crud->set_rules('no_persona',utf8('Número de CI'),'required|callback_unique|numeric|exact_length[11]');
		$crud->set_rules('nombre_persona','Nombre','required');
		$crud->set_rules('id_area','Área','required');
	 	$crud->columns('no_persona','nombre_persona','id_cargo','sexo','id_area','id_categ_ocup','id_nivel_prep','id_grupo_escala','estado');
	 	$crud->display_as('no_persona',utf8('Número CI'));
	 	$crud->display_as('nombre_persona','Nombre');
	 	$crud->display_as('id_cargo',utf8('Cargo'));
	 	$crud->display_as('id_categ_ocup',utf8('Categ Ocup'));
		$crud->display_as('id_grupo_escala',utf8('G. Esc'));
	 	$crud->display_as('id_nivel_prep',utf8('N. Prep'));
		$crud->display_as('id_area',utf8('Área'));
		$crud->display_as('id_brigada',utf8('Brig'));
		$crud->callback_before_insert(array($this,'validate_insert_personas'));
		$crud->add_action(utf8('Cambiar estado contrato, fijo, baja'),'#49afcd', 'c_gestionar/alta_trabajador','fa fa-undo');
		$crud->add_action(utf8('Dar o quitar permiso en el almacén'),'#49afff', 'c_gestionar/extraer_productos','fa fa-sign-in');
		$crud->callback_before_update(array($this,'validate_update_personas'));
		$output = $crud->render();
		$operation = $this->get_operation();
		$output->position=breadcrumb('Gestionar','Personas',$operation);
		$this->load_interfaz($output);
		$this->output->enable_profiler(FALSE);		
	}
			
	function validate_insert_personas($primary_key){
        $permiso='trab_add';
		$this->permisos($permiso);
	}
	
	function validate_update_personas($primary_key){
        $permiso='trab_editar';
		$this->permisos($permiso);
	}
	
	function alta_trabajador($id){
        $permiso='trab_dar_baja';
		$this->permisos($permiso);
		$this->db->select('estado');
		$this->db->where('id_persona', $id); 
		$estado=$this->db->get('personas')->row();
		if ($estado->estado=='contrato'){
		$data = array('estado' => 'fijo');}
		else if ($estado->estado=='fijo'){
		$data = array('estado' => 'baja');}
		else {$data = array('estado' => 'contrato');}
		$this->db->update('personas', $data, array('id_persona' => $id));
		echo "<script>alert('La acción  se ha efectuado correctamente');</script>";
		redirect('/c_gestionar/personas/', 'refresh');	 
	}
	
	function extraer_productos($id){
        $permiso='permisos_almacen';
		$this->permisos($permiso);
		$this->db->select('permiso_almacen,nombre_persona');
		$this->db->where('id_persona', $id);
		$estado=$this->db->get('personas')->row();
		if ($estado->permiso_almacen=='no'){		
		$data = array('permiso_almacen' => 'receptor');
		$this->db->update('personas', $data, array('id_persona' => $id));
		echo "<script>alert('A $estado->nombre_persona se le concedió permiso para extraer productos del almacén.');</script>";
		redirect('/c_gestionar/personas/', 'refresh');
        }
		if ($estado->permiso_almacen=='receptor'){		
		$data = array('permiso_almacen' => 'despachador');
		$this->db->update('personas', $data, array('id_persona' => $id));
		echo "<script>alert('A $estado->nombre_persona se le concedió permiso para despachar productos del almacén.');</script>";
		redirect('/c_gestionar/personas/', 'refresh');
        }
        else{
		$data = array('permiso_almacen' => 'no');
		$this->db->update('personas', $data, array('id_persona' => $id));
		echo "<script>alert('A $estado->nombre_persona se le eliminó el permiso para despachar productos del almacén.');</script>";
		redirect('/c_gestionar/personas/', 'refresh');
        }		
	}
		
	function reportes(){
	$permiso='reporte_ver';
		$this->permisos($permiso);
		$this->load_cookie('reporte','id_reporte','fecha_reporte');		
		$crud = new grocery_CRUD();
		$crud->set_theme('twitter-bootstrap');
		$crud->field_type('estado', 'hidden', '');
		$crud->set_table('reporte');
		$crud->set_relation('id_brigada','brigada','nombre_brigada');
		$crud->set_relation('id_centro_costo','centro_costo','nombre_centro_costo');
		$crud->set_relation_n_n('Trabajador', 'reporte_personas', 'personas', 'id_reporte', 'id_persona', 'nombre_persona', null, null, true);
		$crud->columns('id_reporte','fecha_reporte','id_brigada','cantidad','tiempo','estado');
		//$crud->set_rules('id_reporte','Número reporte','callback_unique');
		$crud->display_as('id_brigada',utf8('Brigada'));
	 	$crud->display_as('id_centro_costo','Trabajo realizado');
	 	//$crud->set_rules('id_centro_costo','Centro costo','required|callback_validate_cant_precio');
		$crud->callback_before_insert(array($this,'validate_insert_reportes'));
		$crud->add_action(utf8('Procesar Reporte'),'#49afcd', 'c_reporte/procesar_reporte_prod','fa fa-thumbs-up');
		$crud->add_action(utf8('Detallar reporte'),'', 'c_reporte/reporte_prod/','fa fa-eye');
		$crud->add_action(utf8('Cancelar'),'#BB0000', 'c_gestionar/cancelar_reportes','fa fa-thumbs-down');
		$crud->callback_before_update(array($this,'validate_update_reportes'));
		$output = $crud->render();
		$operation = $this->get_operation();
		$output->position=breadcrumb('Gestionar','Reportes',$operation);
		$this->load_interfaz($output);
		$this->output->enable_profiler(FALSE);		
	}
	
	function reportes_embarque(){
	$permiso='reporte_ver';
		$this->permisos($permiso);
		$this->load_cookie('reporte_embarque','id_reporte','fecha_reporte');
        $crud = new grocery_CRUD();
		$crud->set_theme('twitter-bootstrap');
		$crud->field_type('estado', 'hidden', '');
		$crud->set_table('reporte_embarque');
		$crud->set_relation('id_brigada','brigada','nombre_brigada');
		$crud->set_relation('id_centro_costo','centro_costo','nombre_centro_costo');
		$crud->set_relation_n_n('Trabajador', 'reporte_personas_embarque', 'personas', 'id_reporte', 'id_persona', 'nombre_persona', null, null, true);
		$crud->columns('id_reporte','fecha_reporte','id_brigada','tiempo','estado');
		//$crud->set_rules('id_reporte','Número reporte','callback_unique');
		$crud->display_as('id_brigada',utf8('Brigada'));
	 	$crud->display_as('id_centro_costo','Trabajo realizado');
		$crud->display_as('sacos','Toneladas de sal');
	 	$crud->display_as('bolsitos','Toneladas de bolsitos');
	 	$crud->display_as('camiones','Toneladas en camiones');
	 	//$crud->set_rules('id_centro_costo','Centro costo','required|callback_validate_cant_precio');
		$crud->callback_before_insert(array($this,'validate_insert_reportes'));
		$crud->add_action(utf8('Procesar Reporte'),'#49afcd', 'c_reporte/procesar_reporte_prod_e','fa fa-thumbs-up');
		$crud->add_action(utf8('Detallar reporte'),'', 'c_reporte/reporte_prod_e/','fa fa-eye');
		$crud->add_action(utf8('Cancelar'),'#BB0000', 'c_gestionar/cancelar_reportes_embarque','fa fa-thumbs-down');
		$crud->callback_before_update(array($this,'validate_update_reportes'));
		$output = $crud->render();
		$operation = $this->get_operation();
		$output->position=breadcrumb('Gestionar','Reportes',$operation);
		$this->load_interfaz($output);
		$this->output->enable_profiler(FALSE);		
	}
	
	function validate_insert_reportes($primary_key){
        $permiso='reporte_add';
		$this->permisos($permiso);
	}
	
	function validate_update_reportes($primary_key){
        $permiso='reporte_editar';
		$this->permisos($permiso);
		}
	
	function cancelar_reportes($primary_key){
        $permiso='reporte_cancelar';
		$this->permisos($permiso);
		$this->db->delete('reporte_prod_proceso', array('id_reporte' => $primary_key));
		$data = array('estado' => '');
        $this->db->update('reporte', $data, array('id_reporte' => $primary_key));
		echo "<script>alert('El reporte $primary_key debe ser editado y procesado nuevamente');</script>";
		redirect('c_gestionar/reportes', 'refresh');
	}
	
	function cancelar_reportes_embarque($primary_key){
        $permiso='reporte_cancelar';
		$this->permisos($permiso);
		$this->db->delete('reporte_prod_proceso_embarque', array('id_reporte' => $primary_key));
		$data = array('estado' => '');
        $this->db->update('reporte_embarque', $data, array('id_reporte' => $primary_key));
		echo "<script>alert('El reporte $primary_key debe ser editado y procesado nuevamente');</script>";
		redirect('c_gestionar/reportes_embarque', 'refresh');
	}
	
	 /*function cancelar_reportes($primary_key){
        $permiso='reporte_cancelar';
		$this->permisos($permiso);
		$this->db->select('estado','id_reporte');
		$this->db->where('id_reporte', $primary_key); 
		$estado=$this->db->get('reporte')->row();
		if ($estado->estado=='procesado'){
        echo "<script>alert('Un reporte procesado no puede ser cancelado.');</script>";
		redirect('/c_gestionar/reportes/', 'refresh');			
		}
		else{
		$this->db->select('estado','id_reporte');
		$this->db->where('id_reporte', $primary_key); 
		$data = array('estado' => 'cancelado');
		$this->db->update('reporte', $data, array('id_reporte' => $primary_key));
		echo "<script>alert('Reporte $primary_key cancelado');</script>";
		redirect('c_gestionar/reportes', 'refresh');
		}
	}
	//actualiza datos en la base de datos
	function actualizar(){
      	$this->db->select('produccion');
		$this->db->where('id_reporte', '3'); 
		$data = array('produccion' => '2560');
		$this->db->update('reporte_prod_proceso', $data, array('id_reporte' => '49','id_persona' => '129'));
	}*/
	
	function personas_externas(){
	$permiso='personas_externas';
		$this->permisos($permiso);
		$this->load_cookie('personas_externas','id_persona','no_carnet');		
		$crud = new grocery_CRUD();
		$crud->set_theme('twitter-bootstrap');
		$crud->set_table('personas_externas');
		$crud->required_fields('no_carnet','nombre_persona');
		$crud->set_rules('no_carnet',utf8('Número de CI'),'required|callback_unique|numeric|exact_length[11]');
		$crud->set_rules('nombre_persona','Nombre','required');
		$crud->display_as('nombre_persona','Nombre');
	 	$output = $crud->render();
		$operation = $this->get_operation();
		$output->position=breadcrumb('Gestionar','Personas',$operation);
		$this->load_interfaz($output);
		$this->output->enable_profiler(FALSE);		
	}
	
	//Vales de entrega
	function vales_entrega(){
	$permiso='vale_entrega';
		$this->permisos($permiso);
		$this->load_cookie('vales_entrega','id_vale','no_factura');		
		$crud = new grocery_CRUD();
		$crud->set_theme('twitter-bootstrap');
		$crud->set_table('vales_entrega');
		$crud->field_type('estado', 'hidden', '');
		$crud->field_type('consecutivo', 'hidden', '');
		$crud->field_type('fecha_vale', 'hidden', '');
		$crud->set_relation('id_centro_costo','centro_costo','{no_centro_costo} ({nombre_centro_costo})');
		$crud->set_relation('receptor','personas','{nombre_persona}',array('permiso_almacen'=>'receptor'));
		$crud->set_relation('despachador','personas','{nombre_persona}',array('permiso_almacen'=>'despachador'));
		$crud->set_relation('id_equipo','equipos','{id_equipo} ({nombre_equipo})');
		$crud->set_relation('id_orden','ordenes','{no_orden} ({descripcion_ordenes})',array('estado'=>'abierta'));
		$crud->set_relation('id_clasificar','clasificar_productos','{nombre_clasificar}');
		$crud->set_relation_n_n('Productos', 'produccion_entrega', 'productos', 'id_vale', 'no_producto', '{id_producto}({nombre_producto})', null, 'existencia!=0', true);
		$crud->columns('consecutivo','fecha_vale','estado','Productos');
		$crud->required_fields('id_centro_costo','id_orden','despachador','no_solicitud_compra');
		$crud->set_rules('id_centro_costo','Centro costo','required|callback_validate_cant_precio');
		$crud->display_as('id_orden','Ordenes','required');
		$crud->display_as('id_clasificar','Clasificar producto');
		$crud->display_as('id_centro_costo','Centro Costo');
		$crud->display_as('id_equipo','Equipos con uso de combustibles');
		$crud->display_as('despachador','Despacha','required');
		$crud->display_as('receptor','Recibe');
		$crud->add_action(utf8('Contabilizar vale'),'#49afcd', 'c_reporte/contabilizar_vale_entrega','fa fa-thumbs-up');
		$crud->add_action(utf8('Detallar Vale'),'', 'c_reporte/report_00/','fa fa-eye');
		$crud->callback_before_insert(array($this,'validate_insert_vales_e'));
		$crud->callback_before_update(array($this,'validate_update_vales_e'));
		$crud->add_action(utf8('Cancelar Vale'),'#BB0000', 'c_gestionar/validate_cancelar_vales_e','fa fa-undo');
		
	 	$output = $crud->render();
		$operation = $this->get_operation();
		$output->position=breadcrumb('Operaciones','Vales entrega',$operation);
		$this->load_interfaz($output);
		
	}
	
	
	function validate_cancelar_vales_e($primary_key){
		$permiso='vale_entrega_cancelar';
		$this->permisos($permiso);
		$this->db->select('estado','no_producto');
		$this->db->where('id_vale', $primary_key); 
		$estado=$this->db->get('vales_entrega')->row();
		if ($estado->estado=='contabilizado'){
        $desglose=$this->reporte->cancelar_vales_e($primary_key)->result();
		foreach ($desglose as $v)
            { 
		      $datos = array('existencia' => $v->existencia, 'precio_mn'=>$v->precio_mn,'precio_mlc' => $v->precio_mlc);
		      $this->db->update('productos', $datos, array('no_producto' => $v->no_producto));
			}
		  $data = array('estado' => 'cancelado');
		  $this->db->update('vales_entrega', $data, array('id_vale' => $primary_key));
        $this->db->select('consecutivo');
		$this->db->where('id_vale', $primary_key); 
		$consecutivo=$this->db->get('vales_entrega')->row();
		echo "<script>alert('Vale $consecutivo->consecutivo cancelado.');</script>";
		redirect('/c_gestionar/vales_entrega/', 'refresh');		  
		}
		if ($estado->estado=='cancelado'){
        echo "<script>alert('Este vale ya estaba cancelado.');</script>";
		redirect('/c_gestionar/vales_entrega/', 'refresh');			
		}
		else
			{
			$data = array('estado' => 'cancelado');
		$this->db->update('vales_entrega', $data, array('id_vale' => $primary_key));
		echo "<script>alert('Vale cancelado');</script>";
		redirect('c_gestionar/vales_entrega', 'refresh');
		}
		
	}
	
	function validate_insert_vales_e($primary_key){
       	$permiso='vale_entrega_add';
		$this->permisos($permiso);
	}
	
	function validate_update_vales_e($post_data, $primary_key)
	{	
        $permiso='vale_entrega_editar';
		$this->permisos($permiso);	
		$this->db->select('estado');
		$this->db->where('id_vale', $primary_key); 
		$estado=$this->db->get('vales_entrega')->row();
		if ($estado->estado=='contabilizado') {
		echo "<script>alert('Un vale contabilizado no puede ser editado');</script>";
		redirect('c_gestionar/vales_entrega', 'refresh');
		return false;
		}else return true;
        		
	}
	
	//Vales de utiles
	function vales_utiles(){
	$permiso='vale_utiles';
		$this->permisos($permiso);
		$this->load_cookie('vales_utiles','id_vale','no_factura');		
		$crud = new grocery_CRUD();
		$crud->set_theme('twitter-bootstrap');
		$crud->set_table('vales_utiles');
		$crud->field_type('estado', 'hidden', '');
		$crud->field_type('consecutivo', 'hidden', '');
		$crud->field_type('fecha_vale', 'hidden', '');
		$crud->set_relation('id_centro_costo','centro_costo','{no_centro_costo} ({nombre_centro_costo})');
		$crud->set_relation('receptor','personas','{nombre_persona}',array('permiso_almacen'=>'receptor'));
		$crud->set_relation('despachador','personas','{nombre_persona}',array('permiso_almacen'=>'despachador'));
		$crud->set_relation('id_equipo','equipos','{id_equipo} ({nombre_equipo})');
		$crud->set_relation('id_orden','ordenes','{id_orden} ({descripcion_ordenes})',array('estado'=>'abierta'));
		$crud->set_relation_n_n('Productos', 'produccion_utiles', 'productos', 'id_vale', 'no_producto', '{id_producto}({nombre_producto})', null, null, true);
		$crud->columns('consecutivo','fecha_vale','estado','Productos');
		$crud->required_fields('id_centro_costo','id_orden','despachador','no_solicitud_compra');
		$crud->set_rules('id_centro_costo','Centro costo','required|callback_validate_cant_precio');
		$crud->display_as('id_orden','Ordenes','required');
		$crud->display_as('id_centro_costo','Centro Costo');
		$crud->display_as('despachador','Despacha','required');
		$crud->display_as('receptor','Recibe');
		$crud->add_action(utf8('Contabilizar vale'),'#49afcd', 'c_reporte/contabilizar_vale_utiles','fa fa-thumbs-up');
		$crud->add_action(utf8('Detallar Vale'),'', 'c_reporte/report_u/','fa fa-eye');
		$crud->callback_before_insert(array($this,'validate_insert_vales_u'));
		$crud->callback_before_update(array($this,'validate_update_vales_u'));
		$crud->add_action(utf8('Cancelar Vale'),'#BB0000', 'c_gestionar/validate_cancelar_vales_u','fa fa-undo');
		
	 	$output = $crud->render();
		$operation = $this->get_operation();
		$output->position=breadcrumb('Operaciones','Vales utiles',$operation);
		$this->load_interfaz($output);
	}
	
	
	function validate_cancelar_vales_u($primary_key){
		$permiso='vale_utiles_cancelar';
		$this->permisos($permiso);
		$this->db->select('estado');
		$this->db->where('id_vale', $primary_key); 
		$estado=$this->db->get('vales_utiles')->row();
		if ($estado->estado=='contabilizado'){
        $desglose=$this->reporte->cancelar_vales_u($primary_key)->result();
		foreach ($desglose as $v)
            { 
		      $datos = array('existencia' => $v->existencia, 'precio_mn'=>$v->precio_mn,'precio_mlc' => $v->precio_mlc);
		      $this->db->update('productos', $datos, array('no_producto' => $v->no_producto));
			}
		  $data = array('estado' => 'cancelado');
		  $this->db->update('vales_utiles', $data, array('id_vale' => $primary_key));
        $this->db->select('consecutivo');
		$this->db->where('id_vale', $primary_key); 
		$consecutivo=$this->db->get('vales_utiles')->row();
		echo "<script>alert('Vale $consecutivo->consecutivo cancelado.');</script>";
		redirect('/c_gestionar/vales_utiles/', 'refresh');		  
		}
		if ($estado->estado=='cancelado'){
        echo "<script>alert('Este vale ya estaba cancelado.');</script>";
		redirect('/c_gestionar/vales_utiles/', 'refresh');			
		}
		else
			{
			$data = array('estado' => 'cancelado');
		$this->db->update('vales_utiles', $data, array('id_vale' => $primary_key));
		echo "<script>alert('Vale cancelado');</script>";
		redirect('c_gestionar/vales_utiles', 'refresh');
		}
		
	}
	
	function validate_insert_vales_u($primary_key){
       	$permiso='vale_utiles_add';
		$this->permisos($permiso);
	}
	
	function validate_update_vales_u($post_data, $primary_key)
	{	
        $permiso='vale_utiles_editar';
		$this->permisos($permiso);	
		$this->db->select('estado');
		$this->db->where('id_vale', $primary_key); 
		$estado=$this->db->get('vales_utiles')->row();
		if ($estado->estado=='contabilizado') {
		echo "<script>alert('Un vale contabilizado no puede ser editado');</script>";
		redirect('c_gestionar/vales_utiles', 'refresh');
		return false;
		}else return true;
        		
	}
	
	//Vales de medios basicos
	function vales_medios_basicos(){
	$permiso='vale_medios_basicos';
		$this->permisos($permiso);
		$this->load_cookie('vales_medios_basicos','id_vale','no_factura');		
		$crud = new grocery_CRUD();
		$crud->set_theme('twitter-bootstrap');
		$crud->set_table('vales_medios_basicos');
		$crud->field_type('estado', 'hidden', '');
		$crud->field_type('consecutivo', 'hidden', '');
		$crud->field_type('fecha_vale', 'hidden', '');
		$crud->set_relation('id_centro_costo','centro_costo','{no_centro_costo} ({nombre_centro_costo})');
		$crud->set_relation('receptor','personas','{nombre_persona}',array('permiso_almacen'=>'receptor'));
		$crud->set_relation('despachador','personas','{nombre_persona}',array('permiso_almacen'=>'despachador'));
		$crud->set_relation('id_equipo','equipos','{id_equipo} ({nombre_equipo})');
		$crud->set_relation('id_orden','ordenes','{id_orden} ({descripcion_ordenes})',array('estado'=>'abierta'));
		$crud->set_relation_n_n('Productos', 'produccion_medios_basicos', 'productos', 'id_vale', 'no_producto', '{id_producto}({nombre_producto})', null, null, true);
		$crud->columns('consecutivo','fecha_vale','estado','Productos');
		$crud->required_fields('id_centro_costo','id_orden','despachador','no_solicitud_compra');
		$crud->set_rules('id_centro_costo','Centro costo','required|callback_validate_cant_precio');
		$crud->display_as('id_orden','Ordenes','required');
		$crud->display_as('id_centro_costo','Centro Costo');
		$crud->display_as('despachador','Despacha','required');
		$crud->display_as('receptor','Recibe');
		$crud->add_action(utf8('Contabilizar vale'),'#49afcd', 'c_reporte/contabilizar_vale_medios_basicos','fa fa-thumbs-up');
		$crud->add_action(utf8('Detallar Vale'),'', 'c_reporte/report_m/','fa fa-eye');
		$crud->callback_before_insert(array($this,'validate_insert_vales_m'));
		$crud->callback_before_update(array($this,'validate_update_vales_m'));
		$crud->add_action(utf8('Cancelar Vale'),'#BB0000', 'c_gestionar/validate_cancelar_vales_e','fa fa-undo');
		
	 	$output = $crud->render();
		$operation = $this->get_operation();
		$output->position=breadcrumb('Operaciones','Vales medios basicos',$operation);
		$this->load_interfaz($output);
		
	}
	
	
	function validate_cancelar_vales_m($primary_key){
		$permiso='vale_medios_basicos_canc';
		$this->permisos($permiso);
		$this->db->select('estado');
		$this->db->where('id_vale', $primary_key); 
		$estado=$this->db->get('vales_medios_basicos')->row();
		if ($estado->estado=='contabilizado'){
        $desglose=$this->reporte->cancelar_vales_m($primary_key)->result();
		foreach ($desglose as $v)
            { 
		      $datos = array('existencia' => $v->existencia, 'precio_mn'=>$v->precio_mn,'precio_mlc' => $v->precio_mlc);
		      $this->db->update('productos', $datos, array('no_producto' => $v->no_producto));
			}
		  $data = array('estado' => 'cancelado');
		  $this->db->update('vales_medios_basicos', $data, array('id_vale' => $primary_key));
        $this->db->select('consecutivo');
		$this->db->where('id_vale', $primary_key); 
		$consecutivo=$this->db->get('vales_medios_basicos')->row();
		echo "<script>alert('Vale $consecutivo->consecutivo cancelado.');</script>";
		redirect('/c_gestionar/vales_medios_basicos/', 'refresh');		  
		}
		if ($estado->estado=='cancelado'){
        echo "<script>alert('Este vale ya estaba cancelado.');</script>";
		redirect('/c_gestionar/vales_medios_basicos/', 'refresh');			
		}
		else
			{
			$data = array('estado' => 'cancelado');
		$this->db->update('vales_medios_basicos', $data, array('id_vale' => $primary_key));
		echo "<script>alert('Vale cancelado');</script>";
		redirect('c_gestionar/vales_medios_basicos', 'refresh');
		}
		
	}
	
	function validate_insert_vales_m($primary_key){
       	$permiso='vale_medios_basicos_add';
		$this->permisos($permiso);
	}
	
	function validate_update_vales_m($post_data, $primary_key)
	{	
        $permiso='vale_medios_basicos_edit';
		$this->permisos($permiso);	
		$this->db->select('estado');
		$this->db->where('id_vale', $primary_key); 
		$estado=$this->db->get('vales_medios_basicos')->row();
		if ($estado->estado=='contabilizado') {
		echo "<script>alert('Un vale contabilizado no puede ser editado');</script>";
		redirect('c_gestionar/vales_medios_basicos', 'refresh');
		return false;
		}else return true;
        		
	}
		
	//Vales de recepcion
	function vales_recepcion(){
	$permiso='vale_recepcion';
		$this->permisos($permiso);
		$this->load_cookie('vales_recepcion','id_vale','no_factura');		
		$crud = new grocery_CRUD();
		$crud->set_theme('twitter-bootstrap');
		$crud->set_table('vales_recepcion');
		$crud->field_type('estado', 'hidden', '');
		$crud->field_type('fecha_vale', 'hidden', '');
		$crud->set_relation_n_n('Productos', 'produccion_recepcion', 'productos', 'id_vale', 'no_producto', '{id_producto}({nombre_producto})', null, null, true);
		$crud->columns('consecutivo','fecha_vale','estado','Productos');
		$crud->set_rules('consecutivo','Consecutivo','required|callback_unique|callback_validate_cant_precio2');
		$crud->display_as('no_centro_costo','Centro Costo');
		$crud->add_action(utf8('Contabilizar vale'),'#49afcd', 'c_reporte/contabilizar_vale_recepcion','fa fa-thumbs-up');
		$crud->add_action(utf8('Detallar Vale'),'', 'c_reporte/report_01/','fa fa-eye');
		$crud->callback_before_insert(array($this,'validate_insert_vales_r'));
		$crud->callback_before_update(array($this,'validate_update_vales_r'));
		$crud->add_action(utf8('Cancelar vale'),'#BB0000', 'c_gestionar/validate_cancelar_vales_r','fa fa-undo');
						
	 	$output = $crud->render();
		$operation = $this->get_operation();
		$output->position=breadcrumb('Operaciones','Vales recepcion',$operation);
		$this->load_interfaz($output);
			
	}
	
	function validate_cancelar_vales_r($primary_key){
		$permiso='vale_recep_cancelar';
		$this->permisos($permiso);
        $this->db->select('estado');
		$this->db->where('id_vale', $primary_key); 
		$estado=$this->db->get('vales_recepcion')->row();
		if ($estado->estado=='contabilizado'){
        $desglose=$this->reporte->cancelar_vales_r($primary_key)->result();
		foreach ($desglose as $v)
            { 
		      $datos = array('existencia' => $v->existencia, 'precio_mn'=>$v->precio_mn,'precio_mlc' => $v->precio_mlc);
		      $this->db->update('productos', $datos, array('no_producto' => $v->no_producto));
			}
		  $data = array('estado' => 'cancelado');
		  $this->db->update('vales_recepcion', $data, array('id_vale' => $primary_key));
        $this->db->select('consecutivo');
		$this->db->where('id_vale', $primary_key); 
		$consecutivo=$this->db->get('vales_recepcion')->row();
		echo "<script>alert('Vale $consecutivo->consecutivo cancelado.');</script>";
		redirect('/c_gestionar/vales_recepcion/', 'refresh');
		}
		if ($estado->estado=='cancelado'){
        echo "<script>alert('Este vale ya estaba cancelado.');</script>";
		redirect('/c_gestionar/vales_entrega/', 'refresh');			
		}
		else
			{
			$data = array('estado' => 'cancelado');
		$this->db->update('vales_recepcion', $data, array('id_vale' => $primary_key));
		echo "<script>alert('Vale cancelado');</script>";
		redirect('c_gestionar/vales_recepcion', 'refresh');
		}
	}
	
	
	function validate_update_vales_r($post_data, $primary_key)
	{
		$permiso='vale_recep_editar';
		$this->permisos($permiso);
		$this->db->select('estado');
		$this->db->where('id_vale', $primary_key); 
		$estado=$this->db->get('vales_recepcion')->row();
		if ($estado->estado=='contabilizado') {
		echo "<script>alert('Un vale contabilizado no puede ser editado');</script>";
		redirect('c_gestionar/vales_recepcion', 'refresh');
			return false;
		}else return true;	
	}
	
	function validate_insert_vales_r($primary_key){
       	$permiso='vale_recep_add';
		$this->permisos($permiso);
	}
	
	//Vales de devolucion
	function vales_devolucion(){
	$permiso='vale_devolucion';
		$this->permisos($permiso);
		$this->load_cookie('vales_devolucion','id_vale','no_factura');		
		$crud = new grocery_CRUD();
		$crud->set_theme('twitter-bootstrap');
		$crud->set_table('vales_devolucion');
		$crud->field_type('estado', 'hidden', '');
		$crud->field_type('fecha_vale', 'hidden', '');
		$crud->field_type('consecutivo', 'hidden', '');
		$crud->set_relation('despachador','personas','{nombre_persona}',array('permiso_almacen'=>'receptor'));
		$crud->set_relation('receptor','personas','{nombre_persona}',array('permiso_almacen'=>'despachador'));
		$crud->set_relation('vale_referencia','vales_entrega','{consecutivo} ({fecha_vale})',array('estado'=>'contabilizado'));
		$crud->set_relation_n_n('Productos', 'produccion_devolucion', 'productos', 'id_vale', 'no_producto', '{id_producto}({nombre_producto})', null, null, true);
		$crud->columns('consecutivo','fecha_vale','estado','Productos');
		$crud->display_as('despachador','Despacha');
		$crud->display_as('receptor','Recibe');
		$crud->set_rules('receptor','Recibe','required|callback_validate_cant_precio');
		$crud->required_fields('vale_referencia','despachador');
		$crud->add_action(utf8('Contabilizar vale'),'#49afcd', 'c_reporte/contabilizar_vale_devolucion','fa fa-thumbs-up');
		$crud->add_action(utf8('Detallar Vale'),'', 'c_reporte/report_02/','fa fa-eye');
		$crud->callback_before_insert(array($this,'validate_insert_vales_d'));
		$crud->callback_before_update(array($this,'validate_update_vales_d'));
		$crud->add_action(utf8('Cancelar vale'),'#BB0000', 'c_gestionar/validate_cancelar_vales_d','fa fa-undo');
		
	 	$output = $crud->render();
		$operation = $this->get_operation();
		$output->position=breadcrumb('Operaciones','Vales devolucion',$operation);
		$this->load_interfaz($output);
	}
	
	function validate_cancelar_vales_d($primary_key){
		$permiso='vale_devol_cancelar';
		$this->permisos($permiso);
		$this->db->select('estado');
		$this->db->where('id_vale', $primary_key); 
		$estado=$this->db->get('vales_devolucion')->row();
		if ($estado->estado=='contabilizado'){
        $desglose=$this->reporte->cancelar_vales_d($primary_key)->result();
		foreach ($desglose as $v)
            { 
		      $datos = array('existencia' => $v->existencia, 'precio_mn'=>$v->precio_mn,'precio_mlc' => $v->precio_mlc);
		      $this->db->update('productos', $datos, array('no_producto' => $v->no_producto));
			}
		  $data = array('estado' => 'cancelado');
		  $this->db->update('vales_devolucion', $data, array('id_vale' => $primary_key));
        $this->db->select('consecutivo');
		$this->db->where('id_vale', $primary_key); 
		$consecutivo=$this->db->get('vales_devolucion')->row();
		echo "<script>alert('Vale $consecutivo->consecutivo cancelado.');</script>";
		redirect('/c_gestionar/vales_devolucion/', 'refresh');		  
		}
		if ($estado->estado=='cancelado'){
        echo "<script>alert('Este vale ya estaba cancelado.');</script>";
		redirect('/c_gestionar/vales_devolucion/', 'refresh');			
		}
		else
			{
			$data = array('estado' => 'cancelado');
		$this->db->update('vales_devolucion', $data, array('id_vale' => $primary_key));
		echo "<script>alert('Vale cancelado');</script>";
		redirect('c_gestionar/vales_devolucion', 'refresh');
		}
		
	}
	
	function validate_update_vales_d($post_data, $primary_key)
	{
		$permiso='vale_devol_editar';
		$this->permisos($permiso);
		$this->db->select('estado');
		$this->db->where('id_vale', $primary_key); 
		$estado=$this->db->get('vales_devolucion')->row();
		if ($estado->estado=='contabilizado') {
		echo "<script>alert('Un vale contabilizado no puede ser editado');</script>";
		redirect('c_gestionar/vales_devolucion', 'refresh');
			return false;
		}else return true;	
	}
	
	function validate_insert_vales_d($primary_key){
       	$permiso='vale_devol_add';
		$this->permisos($permiso);
	}
	

	//Vales transferencia materiales
	function vales_transferencia(){
	$permiso='vale_transferencia';
		$this->permisos($permiso);
		$this->load_cookie('vales_transferencia','id_vale','no_factura');		
		$crud = new grocery_CRUD();
		$crud->set_theme('twitter-bootstrap');
		$crud->set_table('vales_transferencia');
		$crud->field_type('estado', 'hidden', '');
		$crud->field_type('consecutivo', 'hidden', '');
		$crud->field_type('fecha_vale', 'hidden', '');
		$crud->set_relation('id_entidad','entidades','{no_entidad} ({nombre_entidad})');
		$crud->set_relation('id_entidad_despacha','entidades','{no_entidad} ({nombre_entidad})');
		$crud->set_relation('despachador','personas','{nombre_persona}',array('permiso_almacen'=>'despachador'));
		$crud->set_relation('receptor','personas_externas','{nombre_persona}');
		$crud->set_relation('id_persona','personas_externas','{nombre_persona}');
		$crud->set_relation_n_n('Productos', 'produccion_transferencia', 'productos', 'id_vale', 'no_producto', '{id_producto}({nombre_producto})', null, null, true);
		$crud->columns('consecutivo','fecha_vale','estado','Productos');
		$crud->required_fields('id_entidad','id_entidad_despacha','despachador','receptor','id_persona');
		$crud->set_rules('id_entidad','Entidad recectora','required');
		$crud->display_as('id_entidad','Entidad Receptora');
		$crud->display_as('id_entidad_despacha','Entidad que Transfiere');
		$crud->display_as('receptor','Nombre de quien recibe');
		$crud->display_as('id_persona','Nombre de quien trasporta');
		$crud->add_action(utf8('Contabilizar vale'),'#49afcd', 'c_reporte/contabilizar_vale_transferencia','fa fa-thumbs-up');
		$crud->add_action(utf8('Detallar Vale'),'', 'c_reporte/report_03/','fa fa-eye');
		$crud->callback_before_insert(array($this,'validate_insert_vales_t'));
		$crud->callback_before_update(array($this,'validate_update_vales_t'));
		$crud->add_action(utf8('Cancelar vale'),'#BB0000', 'c_gestionar/validate_cancelar_vales_t','fa fa-undo');
				
	 	$output = $crud->render();
		$operation = $this->get_operation();
		$output->position=breadcrumb('Operaciones','Vales transferencia',$operation);
		$this->load_interfaz($output);
	}
	
	function validate_insert_vales_t($primary_key){
       	$permiso='vale_transf_add';
		$this->permisos($permiso);
	}
	
	function validate_cancelar_vales_t($primary_key){
		$permiso='vale_transf_cancelar';
		$this->permisos($permiso);
        $this->db->select('estado');
		$this->db->where('id_vale', $primary_key); 
		$estado=$this->db->get('vales_transferencia')->row();
		if ($estado->estado=='contabilizado'){
        $desglose=$this->reporte->cancelar_vales_t($primary_key)->result();
		foreach ($desglose as $v)
            { 
		      $datos = array('existencia' => $v->existencia, 'precio_mn'=>$v->precio_mn,'precio_mlc' => $v->precio_mlc);
		      $this->db->update('productos', $datos, array('no_producto' => $v->no_producto));
			}
		$data = array('estado' => 'cancelado');
		$this->db->update('vales_transferencia', $data, array('id_vale' => $primary_key));
        $this->db->select('consecutivo');
		$this->db->where('id_vale', $primary_key); 
		$consecutivo=$this->db->get('vales_transferencia')->row();
		echo "<script>alert('Vale $consecutivo->consecutivo cancelado.');</script>";
		redirect('/c_gestionar/vales_transferencia/', 'refresh');		  
		}
		if ($estado->estado=='cancelado'){
        echo "<script>alert('Este vale ya estaba cancelado.');</script>";
		redirect('/c_gestionar/vales_transferencia/', 'refresh');			
		}
		else
			{
			$data = array('estado' => 'cancelado');
		$this->db->update('vales_transferencia', $data, array('id_vale' => $primary_key));
		echo "<script>alert('Vale cancelado');</script>";
		redirect('c_gestionar/vales_transferencia', 'refresh');
		}
	}
	
	function validate_update_vales_t($post_data, $primary_key)
	{
		$permiso='vale_transf_editar';
		$this->permisos($permiso);
		$this->db->select('estado');
		$this->db->where('id_vale', $primary_key); 
		$estado=$this->db->get('vales_transferencia')->row();
		if ($estado->estado=='contabilizado') {
		echo "<script>alert('Un vale contabilizado no puede ser editado');</script>";
		redirect('c_gestionar/vales_transferencia', 'refresh');
			return false;
		}else return true;	
	}
	
	//Factura transferencia materiales
	function factura_transferencia(){
	$permiso='factura_venta';
		$this->permisos($permiso);
		$this->load_cookie('factura_transferencia','id_factura','consecutivo');		
		$crud = new grocery_CRUD();
		$crud->set_theme('twitter-bootstrap');
		$crud->set_table('factura_transferencia');
		$crud->field_type('estado', 'hidden', '');
		$crud->field_type('consecutivo', 'hidden', '');
		$crud->field_type('fecha_factura', 'hidden', '');
		$crud->set_relation('id_entidad','entidades','{no_entidad} ({nombre_entidad})');
		$crud->set_relation('id_entidad_despacha','entidades','{no_entidad} ({nombre_entidad})');
		$crud->set_relation('despachador','personas','{nombre_persona}',array('permiso_almacen'=>'despachador'));
		$crud->set_relation('receptor','personas_externas','{nombre_persona}');
		$crud->set_relation('id_persona','personas_externas','{nombre_persona}');
		$crud->set_relation_n_n('Productos', 'produccion_factura_transferencia', 'productos', 'id_factura', 'no_producto', '{id_producto}({nombre_producto})', null, null, true);
		$crud->columns('consecutivo','fecha_factura','estado','Productos');
		$crud->required_fields('id_entidad','id_entidad_despacha','despachador','receptor','id_persona');
		$crud->set_rules('id_entidad','Entidad recectora','required');
		$crud->display_as('id_entidad','Entidad Receptora');
		$crud->display_as('id_entidad_despacha','Entidad que Transfiere');
		$crud->display_as('receptor','Nombre de quien recibe');
		$crud->display_as('id_persona','Nombre de quien trasporta');
		$crud->add_action(utf8('Contabilizar factura'),'#49afcd', 'c_reporte/contabilizar_factura_transferencia','fa fa-thumbs-up');
		$crud->add_action(utf8('Detallar factura'),'', 'c_reporte/detallar_factura_transferencia/','fa fa-eye');
		$crud->callback_before_insert(array($this,'validate_insert_factura_t'));
		$crud->callback_before_update(array($this,'validate_update_factura_t'));
		$crud->add_action(utf8('Cancelar factura'),'#BB0000', 'c_gestionar/validate_cancelar_factura_t','fa fa-undo');
				
	 	$output = $crud->render();
		$operation = $this->get_operation();
		$output->position=breadcrumb('Operaciones','Factura transferencia',$operation);
		$this->load_interfaz($output);
	}

	function validate_insert_factura_t($primary_key){
       	$permiso='factura_venta';
		$this->permisos($permiso);
	}
	
	function validate_cancelar_factura_t($primary_key){
		$permiso='factura_venta';
		$this->permisos($permiso);
        $this->db->select('estado');
		$this->db->where('id_factura', $primary_key); 
		$estado=$this->db->get('factura_transferencia')->row();
		if ($estado->estado=='contabilizado'){
        $desglose=$this->reporte->cancelar_factura_t($primary_key)->result();
		foreach ($desglose as $v)
            { 
		      $datos = array('existencia' => $v->existencia, 'precio_mn'=>$v->precio_mn,'precio_mlc' => $v->precio_mlc);
		      $this->db->update('productos', $datos, array('no_producto' => $v->no_producto));
			}
		$data = array('estado' => 'cancelado');
		$this->db->update('factura_transferencia', $data, array('id_factura' => $primary_key));
        $this->db->select('consecutivo');
		$this->db->where('id_factura', $primary_key); 
		$consecutivo=$this->db->get('factura_transferencia')->row();
		echo "<script>alert('Factura $consecutivo->consecutivo cancelado.');</script>";
		redirect('/c_gestionar/factura_transferencia/', 'refresh');		  
		}
		if ($estado->estado=='cancelado'){
        echo "<script>alert('Esta factura ya estaba cancelada.');</script>";
		redirect('/c_gestionar/factura_transferencia/', 'refresh');			
		}
		else
			{
			$data = array('estado' => 'cancelado');
		$this->db->update('factura_transferencia', $data, array('id_factura' => $primary_key));
		echo "<script>alert('Factura cancelada');</script>";
		redirect('c_gestionar/factura_transferencia', 'refresh');
		}
	}
	
	function validate_update_factura_t($post_data, $primary_key)
	{
		$permiso='factura_venta';
		$this->permisos($permiso);
		$this->db->select('estado');
		$this->db->where('id_factura', $primary_key); 
		$estado=$this->db->get('factura_transferencia')->row();
		if ($estado->estado=='contabilizado') {
		echo "<script>alert('Una factura contabilizada no puede ser editada');</script>";
		redirect('c_gestionar/factura_transferencia', 'refresh');
			return false;
		}else return true;	
	}

	function ordenes(){
	$permiso='ordenes_ver';
		$this->permisos($permiso);
		$this->load_cookie('ordenes','id_orden','no_orden');		
		$crud = new grocery_CRUD();
		$crud->set_theme('twitter-bootstrap');
		$crud->set_table('ordenes');
		$crud->field_type('estado', 'hidden', '');
		$crud->field_type('id_orden', 'hidden', '');
		//$crud->field_type('fecha_final', 'hidden', '');
		$crud->set_relation('id_equipo','equipos','nombre_equipo');
		$crud->set_relation('id_zona','zonas_trabajo','nombre_zona');
		$crud->set_relation('id_centro_costo','centro_costo','{no_centro_costo} ({nombre_centro_costo})');
		$crud->set_relation_n_n('Trabajadores', 'ordenes_personas', 'personas', 'id_orden', 'id_persona', '{nombre_persona}', null, null, true);
		$crud->required_fields('no_orden','fecha_orden','descripcion_ordenes','id_centro_costo');
		$crud->columns('no_orden','fecha_orden','estado','descripcion_ordenes');
		$crud->set_rules('no_orden','Número órden','callback_unique');
		$crud->display_as('no_orden',utf8('No Orden'));
		$crud->display_as('id_equipo',utf8('Equipo'));
		$crud->display_as('id_zona',utf8('Otros'));
		$crud->display_as('descripcion_ordenes',utf8('Descripción'));
		$crud->display_as('id_centro_costo',utf8('Centro Costo'));
		$crud->set_rules('no_orden','Número órden','callback_unique');
		$crud->callback_before_insert(array($this,'validate_insert_ordenes'));
		$crud->callback_before_update(array($this,'validate_update_ordenes'));
		$crud->add_action(utf8('Cerrar Orden'),'#DD0000', 'c_gestionar/cerrar_orden','fa fa-thumbs-down');
		$crud->add_action(utf8('Abrir Orden'),'#49afcd', 'c_gestionar/abrir_orden','fa fa-thumbs-up');
		$crud->add_action(utf8('Resumen'),'#1155cd', 'c_reporte/resumen_ordenes','fa fa-undo');
		$crud->add_action(utf8('Eliminar Orden'),'#990000', 'c_gestionar/validate_eliminar_orden','fa fa-sign-in');
		//$crud->add_action(utf8('Agregar Trabajadores'),'#990000', 'c_gestionar//ordenes2/add','fa fa-sign-in');
		
		
		$output = $crud->render();
		$operation = $this->get_operation();
		$output->position=breadcrumb('Gestionar','Ordenes',$operation);
		$this->load_interfaz($output);
	}
	
	function cerrar_orden($id){
		$permiso='orden_cerrar';
		$this->permisos($permiso);
		$data = array( 'estado' => 'cerrada');
		$this->db->update('ordenes', $data, array('id_orden' => $id));
		
		redirect('c_gestionar/ordenes');
	}
	
	function validate_update_ordenes($id){
		$permiso='orden_editar';
		$this->permisos($permiso);
		}
	
	function validate_insert_ordenes($id){
		$permiso='orden_add';
		$this->permisos($permiso);
		}
	
   function abrir_orden($id_orden){
	    $permiso='orden_abrir';
		$this->permisos($permiso);
		$estado=$this->reporte->equipos_zona($id_orden)->result();
		$estado=json_decode(json_encode($estado), true);
		
		if ($estado[0]['id_equipo']==0 and $estado[0]['id_zona']==0) {
		echo "<script>alert('Esta orden no tiene asignado ni equipos ni otros trabajos');</script>";
		redirect('c_gestionar/ordenes', 'refresh');	
		}
		else{
		$data = array( 'estado' => 'abierta');
		$this->db->update('ordenes', $data, array('id_orden' => $id_orden));
		redirect('c_gestionar/ordenes');}
	}
	
	function validate_eliminar_orden($primary_key){
        $permiso='orden_eliminar';
		$this->permisos($permiso);		
		$this->db->select('id_orden');
		$this->db->where('id_orden', $primary_key); 
		$estado=$this->db->get('vales_entrega')->row();
		if ($estado->id_orden!==null) {
		echo "<script>alert('Esta orden no puede ser eliminada porque tiene vales asociados');</script>";
		redirect('c_gestionar/ordenes', 'refresh');	
		}
       else
			{
		$query="DELETE FROM `ordenes` WHERE`id_orden`=$primary_key";
		$this->db->query($query);
		echo "<script>alert('Orden $primary_key eliminada');</script>";
		redirect('c_gestionar/ordenes', 'refresh');
			}		
	}
	
	function productos(){
	$permiso='producto_ver';
		$this->permisos($permiso);
		$this->load_cookie('productos','no_producto','id_producto');		
		$crud = new grocery_CRUD();
		$crud->set_theme('twitter-bootstrap');
		$crud->set_table('productos');
		//$crud->field_type('existencia', 'hidden', '');
		$crud->field_type('cantidad_bloqueada', 'hidden', '');
		$crud->required_fields('id_producto','nombre_producto','precio_mn','unidad_medida');
		$crud->columns('cta','sub_cta','id_producto','nombre_producto','unidad_medida','seccion','estante','casilla','existencia','cantidad_bloqueada');
		$crud->set_rules('id_producto','Número producto','callback_unique');
		$crud->display_as('id_producto',utf8('No Producto'));
		$crud->display_as('unidad_medida',utf8('U/M'));
		$crud->display_as('precio_mn',utf8('Precio MN'));
		$crud->display_as('secion',utf8('Sección'));
		$crud->display_as('precio_mlc',utf8('Precio MLC'));
		$crud->callback_before_insert(array($this,'validate_insert_producto'));
		$crud->callback_before_update(array($this,'validate_update_producto'));
		$crud->add_action(utf8('Bloquear o Liberar producto'),'#BB0000', 'c_gestionar/bloquear_producto','fa fa-undo');
		
		$output = $crud->render();
		$operation = $this->get_operation();
		$output->position=breadcrumb('Gestionar','Productos',$operation);
		$this->load_interfaz($output);
	}
    
	function bloquear_producto(){
        $permiso='bloquear_producto';
		$this->permisos($permiso);
		$cantidad=$this->input->post('cantidad');
		$id_producto=$this->input->post('id_producto');
        	
			
		$datos = array('cantidad_bloqueada' => $cantidad);
		$this->db->update('productos', $datos, array('id_producto' => $id_producto));
				
        $data_form['action']=base_url('index.php/c_gestionar/bloquear_producto');
		$data_form['value_cantidad']=$cantidad;
		$data_form['value_id_producto']=$id_producto;
		$data['title_report']=utf8('Bloquea una cantidad determinada de productos ');
		$data['head']=$this->load->view('form_bloquear_producto', $data_form,true);  
		//$data['table']=$this->table->generate();
		//$data['footer']="<div><strong>Este reporte es generado por Yolexis_system</strong>";
		$this->load->view('v_report_template_bloquear_producto', $data);
	}
	
	function validate_update_producto($id){
		$permiso='producto_editar';
		$this->permisos($permiso);
		}
	
	function validate_insert_producto($id){
		$permiso='producto_add';
		$this->permisos($permiso);
		}		

	function validate_cant_precio(){		
		$ProductosExtras=$this->input->post('ProductosExtras');		
		foreach ($ProductosExtras as $key => $value){//key=id_producto			
				foreach ($value as $k => $v) { //$k nombre campo(precio/cantidad)
					if($k=='cantidad' && $v<=0){
						$this->form_validation->set_message('validate_cant_precio','Verifique las cantidades, estas deben ser un número mayor que cero');
						return false;
					}
				}
		}
		return true;
	}
	
	function validate_cant_precio2(){		
		$ProductosExtras=$this->input->post('ProductosExtras');		
		foreach ($ProductosExtras as $key => $value){//key=id_producto			
				foreach ($value as $k => $v) { //$k nombre campo(precio/cantidad)
					if($k=='cantidad' && $v<=0){
						$this->form_validation->set_message('validate_cant_precio2','Verifique las cantidades, estas deben ser un número mayor que cero');
						return false;
					}
					if($k=='precio_mn' && $v<=0){
						$this->form_validation->set_message('validate_cant_precio2','Verifique el precio en moneda nacional, este debe ser un número mayor que cero');
						return false;
					}
				}
		}
		return true;
	}


/**   Preparando datos   */
function clear_password_callback($value){ return "<input type='password' name='contrasena' value='' />";}
function encrypt_password_callback($post_array, $primary_key = null){    
    $post_array['contrasena'] = md5($post_array['contrasena']);
    return $post_array;
}

function get_operation(){
	$crud = new grocery_CRUD();
	$operation = $crud->getState();
	if($operation=='add'  || $operation=='insert')$operation=utf8('Añadir');
	if($operation=='edit' || $operation=='update')$operation='Editar';
	if($operation=='list' || $operation=='ajax_list')$operation='Listado';
	return $operation;
}

function load_cookie($table_name,$id,$field_unique){
	set_cookie($name='ci_table_name', $value=$table_name, $expire=0);		
	set_cookie($name='ci_id_name', $value=$id, $expire=0);		
	set_cookie($name='ci_unique_field_name', $value=$field_unique, $expire=0);
}

/**  Validations ***/
function unique(){
		$table_name=get_cookie('ci_table_name');
		$id_name=get_cookie('ci_id_name');
		$unique_field_name=get_cookie('ci_unique_field_name');
   		$unique_field_value = $this->input->post($unique_field_name);		
		$id_value =$this->uri->segment(4);
		$this->db->where($unique_field_name,$unique_field_value);
		$cant=$this->db->count_all_results($table_name);		
		$crud = new grocery_CRUD();
		$operation = $crud->getState();			
		if ($operation=='insert_validation' && $cant>=1 ) {
			$this->form_validation->set_message('unique', 'El valor de campo <b>{field}</b> ya existe.');
			return false;
		}
		if ($operation=='update_validation' && $cant==1) {
			$this->db->where($unique_field_name,$unique_field_value);
			$this->db->where($id_name.'!=',$id_value);
			$cant2=$this->db->count_all_results($table_name);
			if ($cant2==1) {
				$this->form_validation->set_message('unique', 'El valor de campo <b>{field}</b> ya existe.');
				return false;
			}
		}
		return true;
	}
	
function uniqu(){
		$table_name=get_cookie('ci_table_name');
		$id_name=get_cookie('ci_id_name');
		$unique_field_name=get_cookie('ci_unique_field_name');
   		$unique_field_value = $this->input->post($unique_field_name);		
		$id_value =$this->uri->segment(4);
		$this->db->where($unique_field_name,$unique_field_value);
		$cant=$this->db->count_all_results($table_name);		
		$crud = new grocery_CRUD();
		$operation = $crud->getState();			
		if ($operation=='insert_validation' && $cant>=1 ) {
			$this->form_validation->set_message('unique', 'El valor de campo <b>{field}</b> ya existe.');
			return false;
		}
		if ($operation=='update_validation' && $cant==1) {
			$this->db->where($unique_field_name,$unique_field_value);
			$this->db->where($id_name.'!=',$id_value);
			$cant2=$this->db->count_all_results($table_name);
			if ($cant2==1) {
				$this->form_validation->set_message('uniqu', 'El valor de campo <b>{field}</b> ya existe.');
				return false;
			}
		}
		return true;
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
End of file c_gestionar.php
Location: ./application/controllers/c_gestionar.php
*/ 
?>
