<?php session_name('o3m_fw'); session_start(); if(isset($_SESSION['header_path'])){include_once($_SESSION['header_path']);}else{header('location: '.dirname(__FILE__));}
/* O3M
* Manejador de Vistas y asignación de variables
* ADMIN
*/
// Modulo Padre
global $vistas, $contenidos, $icono;
$icono = $var[ico_03];
define(MODULO,'ADMIN');
require_once($Path[src].strtolower(MODULO).'/dao.'.strtolower(MODULO).'.php');
require_once($Path[src].'build.contenidos.php');
# Vistas HTML
$vistas = array(
		 INDEX 			=> 'index.html'
		,XLS 	 		=> 'xls.html'
		,XLS_LISTA		=> 'xls_rebuild.html'
		,LAYOUT 		=> 'layout.html'
		,USUARIOS 		=> 'usuarios.html'
		,SINCRONIZACION => 'sincronizacion.html'
		,ALTA_USUARIO	=> 'alta_usuario.html'
		,SINCRONIZACION_EMPRESAS => 'sincronizacion_empresas.html'
		,ADMIN_USUARIOS => 'usuarios_admin.html'
		,CALENDARIO 	=> 'calendario_periodos.html'
		,SUPERVISORES 	=> 'usuarios_supervisores.html'
	);

# Vistas
function vistas($cmd){
	global $vistas;
	$comando = strtoupper(enArray(MODULO,$vistas));	
	if(array_key_exists($comando,$vistas)){
		$html = $vistas[$comando];
	}else{
		$html = $vistas[ERROR];
	}
	return $html;
}

# Variables
function tpl_vars($cmd, $urlParams=array()){
	global $vistas;
	$cmd = strtoupper(enArray($cmd,$vistas));
	if($cmd == 'INDEX'){
		$vars = vars_index($cmd, $urlParams);
	}elseif($cmd == 'USUARIOS'){
		$vars = vars_usuarios($cmd, $urlParams);
	}
	elseif($cmd == 'SINCRONIZACION'){
		$vars = vars_sincronizacion($cmd, $urlParams);
	}
	elseif($cmd == 'ALTA_USUARIO'){
		$vars = vars_alta_usuario($cmd, $urlParams);
	}
	elseif($cmd == 'SINCRONIZACION_EMPRESAS'){
		$vars = vars_sincronizacion_empresas($cmd, $urlParams);
	}
	elseif($cmd == 'LAYOUT'){
		$vars = vars_layout($cmd, $urlParams);
	}
	elseif($cmd == 'XLS'){
		$vars = vars_xls($cmd, $urlParams);
	}
	elseif($cmd == 'XLS_LISTA'){
		$vars = vars_xls_lista($cmd, $urlParams);
	}
	elseif($cmd == 'ADMIN_USUARIOS'){
		$vars = vars_admin_usuarios($cmd, $urlParams);
	}
	elseif($cmd == 'CALENDARIO'){
		$vars = vars_calendario($cmd, $urlParams);
	}
	elseif($cmd == 'SUPERVISORES'){
		$vars = vars_supervisores($cmd, $urlParams);
	}
	else{
		$vars = vars_error($cmd);
	}
	return $vars;
}

#############
// Funciones para asignar variables a cada vista
// $negocio => Logica de negocio; $texto => Mensajes de interfaz
function vars_sincronizacion($seccion, $urlParams){
	global $var, $Path, $icono, $dic, $vistas, $usuario;
	## Logica de negocio ##		
	$titulo 	= $dic[admin][sincronizar_titulo];

	$tbl_resultados = build_grid_usuarios();
	$data_contenido = array(
				TBL_RESULTS=> $tbl_resultados
		);
	$contenido 	= contenidoHtml(strtolower(MODULO).'/'.$vistas[strtoupper($seccion)], $data_contenido);
	## Envio de valores ##
	$negocio = array(
				 MORE 		=>  incJs($Path[srcjs].strtolower(MODULO).'/admin.js')
				,MODULE 	=> strtolower(MODULO)
				,SECTION 	=> ($seccion)								 
			);
	$texto = array(
				 ICONO 			=> $icono
				,TITULO			=> $titulo
				,CONTENIDO 		=> $contenido
				,sincronizar_usuarios =>$dic[admin][sincronizar_usuarios]
			);
	$data = array_merge($negocio, $texto);
	return $data;
}
function vars_alta_usuario($seccion, $urlParams){
	global $var, $Path, $icono, $dic, $vistas, $usuario;
	## Logica de negocio ##
	$titulo 	= $dic[admin][alta_usuario];
	$data_contenido = array();
	$catalago_empresa=build_catalgo_empresa();
	$catalogo_usuario_grupo=build_catalgo_usuarios_grupo();
	$catalogo_sucursales = build_catalgo_sucursales_nomina('sucursal');
	// $catalogo_nivel1=build_catalgo_supervisores(1);
	// $catalogo_nivel2=build_catalgo_supervisores(2);
	// $catalogo_nivel3=build_catalgo_supervisores(3);
	// $catalogo_nivel4=build_catalgo_supervisores(4);
	// $catalogo_nivel5=build_catalgo_supervisores(5);
	$contenido 	= contenidoHtml(strtolower(MODULO).'/'.$vistas[strtoupper($seccion)], $data_contenido);
	## Envio de valores ##
	/*var_dump(MODULO);
	die();*/
	$negocio = array(
				 MORE 		=>  incJs($Path[srcjs].strtolower(MODULO).'/admin.js')
				,MODULE 	=> strtolower(MODULO)
				,SECTION 	=> ($seccion)								 
			);
	$texto = array(
				 ICONO 					=> $icono
				,TITULO					=> $titulo
				,CONTENIDO 				=> $contenido
				,catalgo_empresa 		=> $catalago_empresa
				,catalogo_usuario_grupo => $catalogo_usuario_grupo
				,catalogo_sucursales 	=> $catalogo_sucursales
				// ,catalogo_nivel1 		=>$catalogo_nivel1
				// ,catalogo_nivel2 		=>$catalogo_nivel2
				// ,catalogo_nivel3 		=>$catalogo_nivel3
				// ,catalogo_nivel4 		=>$catalogo_nivel4
				// ,catalogo_nivel5 		=>$catalogo_nivel5

			);
	$data = array_merge($negocio, $texto);
	return $data;
}
function vars_sincronizacion_empresas($seccion, $urlParams){
	global $var, $Path, $icono, $dic, $vistas, $usuario;
	## Logica de negocio ##		
	$titulo 	= $dic[admin][sincronizar_empresas_titulo];

	$tbl_resultados = build_select_empresas_tabla();
	$data_contenido = array(
				TBL_RESULTS=> $tbl_resultados
		);
	$contenido 	= contenidoHtml(strtolower(MODULO).'/'.$vistas[strtoupper($seccion)], $data_contenido);
	## Envio de valores ##
	$negocio = array(
				 MORE 		=>  incJs($Path[srcjs].strtolower(MODULO).'/admin.js')
				,MODULE 	=> strtolower(MODULO)
				,SECTION 	=> ($seccion)								 
			);
	$texto = array(
				 ICONO 			=> $icono
				,TITULO			=> $titulo
				,CONTENIDO 		=> $contenido
				,sincronizar_empresa_boton	=>$dic[admin][sincronizar_empresa_boton]
			);
	$data = array_merge($negocio, $texto);
	return $data;
}
function vars_layout($seccion, $urlParams){
	global $var, $Path, $icono, $dic, $vistas, $usuario;
	## Logica de negocio ##		
	$titulo 	= $dic[admin][layout];

	$tbl_resultados = build_grid_layout();
	$data_contenido = array(
				TBL_RESULTS=> $tbl_resultados
		);
	$contenido 	= contenidoHtml(strtolower(MODULO).'/'.$vistas[strtoupper($seccion)], $data_contenido);
	## Envio de valores ##
	$negocio = array(
				 MORE 		=>  incJs($Path[srcjs].strtolower(MODULO).'/admin.js')
				,MODULE 	=> strtolower(MODULO)
				,SECTION 	=> ($seccion)								 
			);
	$texto = array(
				 ICONO 			=> $icono
				,TITULO			=> $titulo
				,CONTENIDO 		=> $contenido
			);
	$data = array_merge($negocio, $texto);
	return $data;
}
function vars_xls($seccion, $urlParams){
	global $var, $Path, $icono, $dic, $vistas, $usuario;
	## Logica de negocio ##		
	$titulo 	= $dic[admin][xls];
	$tbl_resultados = build_grid_xls();
	$data_contenido = array(
				TBL_RESULTS=> $tbl_resultados
		);
	$contenido 	= contenidoHtml(strtolower(MODULO).'/'.$vistas[strtoupper($seccion)], $data_contenido);
	## Envio de valores ##
	$negocio = array(
				 MORE 		=>  incJs($Path[srcjs].strtolower(MODULO).'/admin.js')
				,MODULE 	=> strtolower(MODULO)
				,SECTION 	=> ($seccion)								 
			);
	$texto = array(
				 ICONO 			=> $icono
				,TITULO			=> $titulo
				,CONTENIDO 		=> $contenido
			);
	$data = array_merge($negocio, $texto);
	return $data;
}
function vars_xls_lista($seccion, $urlParams){
	global $var, $Path, $icono, $dic, $vistas, $usuario;
	## Logica de negocio ##		
	$titulo 	= $dic[admin][xls_lista];
	$tbl_resultados = build_grid_xls_lista();
	$data_contenido = array(
				TBL_RESULTS=> $tbl_resultados
		);
	$contenido 	= contenidoHtml(strtolower(MODULO).'/'.$vistas[strtoupper($seccion)], $data_contenido);
	## Envio de valores ##
	$negocio = array(
				 MORE 		=>  incJs($Path[srcjs].strtolower(MODULO).'/admin.js')
				,MODULE 	=> strtolower(MODULO)
				,SECTION 	=> ($seccion)								 
			);
	$texto = array(
				 ICONO 			=> $icono
				,TITULO			=> $titulo
				,CONTENIDO 		=> $contenido
			);
	$data = array_merge($negocio, $texto);
	return $data;
}

function vars_admin_usuarios($seccion, $urlParams){
	global $var, $Path, $icono, $dic, $vistas, $usuario;
	## Logica de negocio ##		
	$titulo 	= $dic[admin][admin_usuarios_titulo];

	$tbl_resultados = build_grid_admin_usuarios();
	$data_contenido = array(
				TBL_RESULTS=> $tbl_resultados
		);
	$contenido 	= contenidoHtml(strtolower(MODULO).'/'.$vistas[strtoupper($seccion)], $data_contenido);
	## Envio de valores ##
	$negocio = array(
				 MORE 		=>  incJs($Path[srcjs].strtolower(MODULO).'/admin.js')
				,MODULE 	=> strtolower(MODULO)
				,SECTION 	=> ($seccion)								 
			);
	$texto = array(
				 ICONO 			=> $icono
				,TITULO			=> $titulo
				,CONTENIDO 		=> $contenido
				,sincronizar_usuarios =>$dic[admin][sincronizar_usuarios]
			);
	$data = array_merge($negocio, $texto);
	return $data;
}

function vars_calendario($seccion, $urlParams){
	global $var, $Path, $icono, $dic, $vistas, $usuario;
	## Logica de negocio ##
	$titulo 	= $dic[admin][admin_calendario_titulo];
	$data_contenido = array();
	$catalago_empresa=build_catalgo_calendario_empresas();
	$contenido 	= contenidoHtml(strtolower(MODULO).'/'.$vistas[strtoupper($seccion)], $data_contenido);
	## Envio de valores ##
	$negocio = array(
				 MORE 		=>  incJs($Path[srcjs].strtolower(MODULO).'/admin_calendario.js')
				,MODULE 	=> strtolower(MODULO)
				,SECTION 	=> ($seccion)								 
			);
	$texto = array(
				 ICONO 						=> $icono
				,TITULO						=> $titulo
				,CONTENIDO 					=> $contenido
				,catalgo_empresa 			=> $catalago_empresa
				,catalogo_calendario_tipo 	=> build_input_select_enum('calendario_tipo')
				,TBL_CALENDARIO 			=> build_tbl_calendario()

			);
	$data = array_merge($negocio, $texto);
	return $data;
}

function vars_supervisores($seccion, $urlParams){
	global $var, $Path, $icono, $dic, $vistas, $usuario;
	## Logica de negocio ##		
	$titulo 	= $dic[admin][admin_supervisores_titulo];

	$tbl_resultados = build_grid_supervisores();
	$data_contenido = array(
				TBL_RESULTS=> $tbl_resultados
		);
	$contenido 	= contenidoHtml(strtolower(MODULO).'/'.$vistas[strtoupper($seccion)], $data_contenido);
	## Envio de valores ##
	$negocio = array(
				 MORE 		=>  incJs($Path[srcjs].strtolower(MODULO).'/supervisores.js')
				,MODULE 	=> strtolower(MODULO)
				,SECTION 	=> ($seccion)								 
			);
	$texto = array(
				 ICONO 			=> $icono
				,TITULO			=> $titulo
				,CONTENIDO 		=> $contenido
				,sincronizar_usuarios =>$dic[admin][sincronizar_usuarios]
			);
	$data = array_merge($negocio, $texto);
	return $data;
}

function vars_error($cmd){
	global $dic;
	## Envio de valores ##
	$data = array(MENSAJE => $dic[error][mensaje].': '.$cmd);
	return $data;
}

?>