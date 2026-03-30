<?php
class c_nomenclador extends CI_Controller {
   public function __construct(){
      parent::__construct();     
      $this->load->database();
      $this->load->library('grocery_CRUD');
      $this->load->helper(array('cookie'));
	  $this->load->model('m_reporte','reporte');
      // $this->output->enable_profiler(TRUE);
   }
	function load_interfaz($output = null){ $this->load->view('v_interfaz',$output); }

	
//crea roles en la base de datos pero de forma ineficiente o insuficientes pues no son funcionales hasta que se programan
	/*function roles(){
	$permiso='nomencladores';
		$this->permisos($permiso);
		$this->load_cookie('roles','id_rol','rol');
		$crud = new grocery_CRUD();
		$crud->set_theme('twitter-bootstrap');
		$crud->set_table('roles');
		$crud->required_fields('rol');
		$crud->set_rules('rol','Nombre del rol','required|callback_unique');
		
		$operation = $this->get_operation();
		$output = $crud->render();
		$output ->position=breadcrumb('Administrar','Roles',$operation);		
		$this->load_interfaz($output);
		
	}*/
	
	function crear_permisos(){
	$permiso='nadie';
		$this->permisos($permiso);
		$this->load_cookie('permisos','id_permiso','permiso');
		$crud = new grocery_CRUD();
		$crud->set_theme('twitter-bootstrap');
		$crud->set_table('permisos');
		$crud->columns('permiso','descripcion');
		$crud->required_fields('permiso');
		$crud->set_rules('permiso','Permiso','required|callback_unique');
		$crud->add_action(utf8('Eliminar permisos'),'#BB0000', 'c_gestionar/eliminar_permiso','fa fa-thumbs-down');
				
		$operation = $this->get_operation();
		$output = $crud->render();
		$output ->position=breadcrumb('Administrar','Permisos',$operation);		
		$this->load_interfaz($output);
		
	}
	
	function Locales(){
	$permiso='nomencladores';
		$this->permisos($permiso);
		$this->load_cookie('locales','no_local','nombre_local');
		$crud = new grocery_CRUD();
		$crud->set_theme('twitter-bootstrap');
		$crud->set_table('locales');
		$crud->set_rules('nombre_local','Nombre del local','required|callback_unique');
		
		$operation = $this->get_operation();
		$output = $crud->render();
		$output ->position=breadcrumb('Nomenclador','Nombrar locales',$operation);		
		$this->load_interfaz($output);		
	}

	function materiales_piezas(){
	$permiso='nomencladores';
		$this->permisos($permiso);
		$this->load_cookie('clasificacion_materiales_piezas','no_clasificacion','nombre_clasificacion');
		$crud = new grocery_CRUD();
		$crud->set_theme('twitter-bootstrap');
		$crud->set_table('clasificacion_materiales_piezas');
		$crud->set_rules('nombre_clasificacion','Nombre del material o la pieza','required|callback_unique');
		
		$operation = $this->get_operation();
		$output = $crud->render();
		$output ->position=breadcrumb('Nomenclador','Clasificacion de materiales o piezas',$operation);		
		$this->load_interfaz($output);
		
	}
	
	function clasificar_productos(){
	$permiso='nomencladores';
		$this->permisos($permiso);
		$this->load_cookie('clasificar_productos','id_clasificar','nombre_clasificar');
		$crud = new grocery_CRUD();
		$crud->set_theme('twitter-bootstrap');
		$crud->set_table('clasificar_productos');
		$crud->set_rules('nombre_clasificar','Clasificación','required|callback_unique');
		
		$operation = $this->get_operation();
		$output = $crud->render();
		$output ->position=breadcrumb('Nomenclador','Clasificacion de productos',$operation);		
		$this->load_interfaz($output);
	}
	
	function equipos(){
	$permiso='nomencladores';
		$this->permisos($permiso);
		$this->load_cookie('equipos','id_equipo','nomnbre_equipo');
		$crud = new grocery_CRUD();
		$crud->set_theme('twitter-bootstrap');
		$crud->set_table('equipos');
		$crud->columns('id_equipo','nombre_equipo','chapa');
		$crud->required_fields('nombre_equipo');
		$crud->set_rules('nombre_equipo','Nombre del equipo','required');
		
		$operation = $this->get_operation();
		$output = $crud->render();
		$output ->position=breadcrumb('Nomenclador','Clasificacion de equipos',$operation);		
		$this->load_interfaz($output);
		
	}

	function tipo_fuerza(){
	$permiso='nomencladores';
		$this->permisos($permiso);
		$this->load_cookie('tipo_fuerza_trabajo','no_tipo_fuerza_trabajo','nombre_tipo_fuerza_trabajo');
		$crud = new grocery_CRUD();
		$crud->set_theme('twitter-bootstrap');
		$crud->set_table('tipo_fuerza_trabajo');
		$crud->required_fields('nombre_tipo_fuerza_trabajo');
		$crud->set_rules('nombre_tipo_fuerza_trabajo','Tipo fuerza trabajo','required|callback_unique');
		
		$operation = $this->get_operation();
		$output = $crud->render();
		$output ->position=breadcrumb('Nomenclador','Tipo de fuerza de trabajo',$operation);		
		$this->load_interfaz($output);
		
	}


	function mes(){
	$permiso='nomencladores';
		$this->permisos($permiso);
		$this->load_cookie('meses','no_mes','nombre_mes');		
		$crud = new grocery_CRUD();
		$crud->set_theme('twitter-bootstrap');
		$crud->set_table('meses');
		$crud->required_fields('no_mes','nombre_mes');		
		$crud->set_rules('nombre_mes','Nombre','required|callback_unique');		
		$operation = $this->get_operation();
		$output = $crud->render();		
		$output ->position=breadcrumb('Nomenclador','Meses',$operation);
		$this->load_interfaz($output);
		
	}	
	
	function zonas_trabajo(){
	$permiso='nomencladores';
		$this->permisos($permiso);
		$this->load_cookie('zonas_trabajo','id_zona','nombre_zona');
		$crud = new grocery_CRUD();
		$crud->set_theme('twitter-bootstrap');
		$crud->set_table('zonas_trabajo');
		$crud->set_rules('nombre_zona','Nombre de la zona de trabajo','required|callback_unique');
		$crud->display_as('nombre_zona',utf8('Region trabajo'));
		
		$operation = $this->get_operation();
		$output = $crud->render();
		$output ->position=breadcrumb('Nomenclador','Clasificacion de zonas trabajo',$operation);		
		$this->load_interfaz($output);
		
	}
	
	function anual(){
	$permiso='nomencladores';
		$this->permisos($permiso);
		$this->load_cookie('anual','no_plan_anual','cantidad');		
		$crud = new grocery_CRUD();
		$crud->set_theme('twitter-bootstrap');
		$crud->set_table('anual');
		$crud->required_fields('no_plan_anual','cantidad');		
		$crud->set_rules('nombre_mes','Nombre','required|callback_unique');
        $crud->set_rules('cantidad','Cantidad','required');		
		$operation = $this->get_operation();
		$output = $crud->render();		
		$output ->position=breadcrumb('Nomenclador','Año',$operation);
		$this->load_interfaz($output);
		
	}

	function centro_costo(){
	$permiso='nomencladores';
		$this->permisos($permiso);
		$this->load_cookie('centro_costo','id_centro_costo','no_centro_costo');		
		$crud = new grocery_CRUD();
		$crud->set_theme('twitter-bootstrap');
		$crud->set_table('centro_costo');
		$crud->required_fields('no_centro_costo','nombre_centro_costo');		
		$crud->set_rules('no_centro_costo','No Centro Costo','required|callback_unique');
		$crud->set_rules('nombre_centro_costo','Centro Costo','required|callback_unique');
		$operation = $this->get_operation();
		$output = $crud->render();		
		$output ->position=breadcrumb('Nomenclador','Centro',$operation);
		$this->load_interfaz($output);
		
	}
	

	function categ_ocup(){
	$permiso='nomencladores';
		$this->permisos($permiso);
		$this->load_cookie('categ_ocup','id_categ_ocup','nombre_categ_ocup');		
		$crud = new grocery_CRUD();
		$crud->set_theme('twitter-bootstrap');
		$crud->set_table('categ_ocup');
		$crud->required_fields('nombre_categ_ocup','descripcion');
        $crud->display_as('nombre_categ_ocup',utf8('Siglas'));		
		$crud->set_rules('nombre_categ_ocup','Name','required|callback_unique');
		$operation = $this->get_operation();
		$output = $crud->render();		
		$output ->position=breadcrumb('Nomenclador','Insertar Categoria Ocupacional',$operation);
		$this->load_interfaz($output);
		
	}
	
	function areas(){
	$permiso='nomencladores';
		$this->permisos($permiso);
		$this->load_cookie('areas','id_area','nombre_area');		
		$crud = new grocery_CRUD();
		$crud->set_theme('twitter-bootstrap');
		$crud->set_table('areas');
		$crud->required_fields('nombre_area');		
		$crud->set_rules('nombre_area','Nombre Área','required');
		$operation = $this->get_operation();
		$output = $crud->render();		
		$output ->position=breadcrumb('Nomenclador','Insertar Área',$operation);
		$this->load_interfaz($output);
		
	}
	
	function brigada(){
	$permiso='nomencladores';
		$this->permisos($permiso);
		$this->load_cookie('brigada','id_brigada','nombre_brigada');		
		$crud = new grocery_CRUD();
		$crud->set_theme('twitter-bootstrap');
		$crud->set_table('brigada');
		$crud->required_fields('nombre_brigada');		
		$crud->set_rules('nombre_brigada','Nombre brigada','required');
		$operation = $this->get_operation();
		$output = $crud->render();		
		$output ->position=breadcrumb('Nomenclador','Insertar Brigada',$operation);
		$this->load_interfaz($output);
	}
	
	function escala(){
	$permiso='nomencladores';
		$this->permisos($permiso);
		$this->load_cookie('grupo_escala','id_grupo_escala','nombre_grupo_escala');		
		$crud = new grocery_CRUD();
		$crud->set_theme('twitter-bootstrap');
		$crud->set_table('grupo_escala');
		$crud->required_fields('nombre_grupo_escala');		
		$crud->set_rules('nombre_grupo_escala','Nombre escala','required|callback_unique');
		$operation = $this->get_operation();
		$output = $crud->render();		
		$output ->position=breadcrumb('Nomenclador','Insertar Escala',$operation);
		$this->load_interfaz($output);
		
	}
	
	function nivel_prep(){
	$permiso='nomencladores';
		$this->permisos($permiso);
		$this->load_cookie('nivel_prep','id_nivel_prep','nombre_nivel_prep');		
		$crud = new grocery_CRUD();
		$crud->set_theme('twitter-bootstrap');
		$crud->set_table('nivel_prep');
		$crud->required_fields('nombre_nivel_prep');		
		$crud->set_rules('nombre_nivel_prep','Nombre nivel preparación','required|callback_unique');
		$crud->display_as('nombre_nivel_prep',utf8('Siglas'));
		$operation = $this->get_operation();
		$output = $crud->render();		
		$output ->position=breadcrumb('Nomenclador','Insertar Nivel Preparación',$operation);
		$this->load_interfaz($output);
		
	}
	
	function cargos(){
	$permiso='nomencladores';
		$this->permisos($permiso);
		$this->load_cookie('cargos','id_cargo','nombre_cargo');		
		$crud = new grocery_CRUD();
		$crud->set_theme('twitter-bootstrap');
		$crud->set_table('cargos');
		//$crud->set_relation('id_categ_ocup','categ_ocup','nombre_categ_ocup');
		$crud->display_as('id_categ_ocup','Categoria Ocupacional');
		$crud->display_as('nombre_cargo','Nombre del cargo');
		$crud->required_fields('nombre_cargo');		
		$crud->set_rules('nombre_cargo','Nombre','required|callback_unique');
		$operation = $this->get_operation();
		$output = $crud->render();		
		$output ->position=breadcrumb('Nomenclador','Insertar nuevo Cargo',$operation);
		$this->load_interfaz($output);
		
	}
	
	function entidades(){
	$permiso='nomencladores';
		$this->permisos($permiso);
		$this->load_cookie('entidades','id_entidad','no_entidad');		
		$crud = new grocery_CRUD();
		$crud->set_theme('twitter-bootstrap');
		$crud->set_table('entidades');
		$crud->display_as('nombre_entidad','Nombre de la entidad');
		$crud->display_as('no_entidad','Número');
		$crud->required_fields('no_entidad','nombre_entidad');		
		$crud->set_rules('no_entidad','Número','required|callback_unique');
		$crud->set_rules('nombre_entidad','Nombre de entidad','required|callback_unique');
		$operation = $this->get_operation();
		$output = $crud->render();		
		$output ->position=breadcrumb('Nomenclador','Insertar nueva entidad',$operation);
		$this->load_interfaz($output);
		
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
End of file c_nomenclador.php
Location: ./application/controllers/c_nomenclador.php
*/ 
?>
