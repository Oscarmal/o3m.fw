<?php session_name('o3m_fw'); session_start(); if(isset($_SESSION['header_path'])){include_once($_SESSION['header_path']);}else{header('location: '.dirname(__FILE__));}
/* O3M
* Manejador de Vistas y asignación de variables
* CONSULTA
*/
// Modulo Padre
global $vistas, $contenidos, $icono;
$icono = $var[ico_03];
define(MODULO,'CONSULTA');
require_once($Path[src].strtolower(MODULO).'/dao.'.strtolower(MODULO).'.php');
require_once($Path[src].'build.contenidos.php');
# Vistas HTML
$vistas = array(
		 INDEX 						=> 'index.html'
		,CONSULTA_AUTORIZACION_1 	=> 'consulta_autorizacion_1.html'
		,CONSULTA_AUTORIZACION_2 	=> 'consulta_autorizacion_2.html'
		,CONSULTA_AUTORIZACION_3 	=> 'consulta_autorizacion_3.html'
		,CONSULTA_AUTORIZACION_4 	=> 'consulta_autorizacion_4.html'
		,CONSULTA_AUTORIZACION_5 	=> 'consulta_autorizacion_5.html'
		,CONSULTA_AUTORIZACIONES 	=> 'consulta_autorizaciones.html'
		,CONSULTA_PENDIENTES 	 	=> 'consulta_pendientes.html'
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
	}elseif($cmd == 'CONSULTA_AUTORIZACION_1'){
		$vars = vars_autorizacion_1($cmd, $urlParams);
	}elseif($cmd == 'CONSULTA_AUTORIZACION_2'){
		$vars = vars_autorizacion_2($cmd, $urlParams);
	}
	elseif($cmd == 'CONSULTA_AUTORIZACION_3'){
		$vars = vars_autorizacion_3($cmd, $urlParams);
	}
	elseif($cmd == 'CONSULTA_AUTORIZACION_4'){
		$vars = vars_autorizacion_4($cmd, $urlParams);
	}
	elseif($cmd == 'CONSULTA_AUTORIZACION_5'){
		$vars = vars_autorizacion_5($cmd, $urlParams);
	}
	elseif($cmd == 'CONSULTA_AUTORIZACIONES'){
		$vars = vars_autorizaciones($cmd, $urlParams);
	}
	elseif($cmd == 'CONSULTA_PENDIENTES'){
		$vars = vars_pendientes($cmd, $urlParams);
	}
	else{
		$vars = vars_error($cmd);
	}
	return $vars;
}
#############
// Funciones para asignar variables a cada vista
// $negocio => Logica de negocio; $texto => Mensajes de interfaz
function vars_autorizacion_1($seccion, $urlParams){
	global $var, $Path, $icono, $dic, $vistas, $usuario;
	## Logica de negocio ##		
	$titulo 	= $dic[consulta][titulo_autorizacion_1];
	$tbl_resultados = build_grid_consulta_autorizacion_1();
	$data_contenido = array(
				TBL_RESULTS=> $tbl_resultados
		);
	$contenido 	= contenidoHtml(strtolower(MODULO).'/'.$vistas[strtoupper($seccion)], $data_contenido);
	## Envio de valores ##
	$negocio = array(
				 MORE 		=> incJs($Path[srcjs].strtolower(MODULO).'/consulta.js')	
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
function vars_autorizacion_2($seccion, $urlParams){
	global $var, $Path, $icono, $dic, $vistas, $usuario;
	## Logica de negocio ##		
	$titulo 	= $dic[consulta][titulo_autorizacion_2];
	$tbl_resultados = build_grid_consulta_autorizacion_2();
	$data_contenido = array(
				TBL_RESULTS=> $tbl_resultados
		);
	$contenido 	= contenidoHtml(strtolower(MODULO).'/'.$vistas[strtoupper($seccion)], $data_contenido);
	## Envio de valores ##
	$negocio = array(
				 MORE 		=> incJs($Path[srcjs].strtolower(MODULO).'/autorizacion_listado.js')	
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
function vars_autorizacion_3($seccion, $urlParams){
	global $var, $Path, $icono, $dic, $vistas, $usuario;
	## Logica de negocio ##		
	$titulo 	= $dic[consulta][titulo_autorizacion_3];
	$tbl_resultados = build_grid_consulta_autorizacion_3();
	$data_contenido = array(
				TBL_RESULTS=> $tbl_resultados
		);
	$contenido 	= contenidoHtml(strtolower(MODULO).'/'.$vistas[strtoupper($seccion)], $data_contenido);
	## Envio de valores ##
	$negocio = array(
				 MORE 		=> incJs($Path[srcjs].strtolower(MODULO).'/autorizacion_listado.js')	
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
function vars_autorizacion_4($seccion, $urlParams){
	global $var, $Path, $icono, $dic, $vistas, $usuario;
	## Logica de negocio ##		
	$titulo 	= $dic[consulta][titulo_autorizacion_4];
	$tbl_resultados = build_grid_consulta_autorizacion_4();
	$data_contenido = array(
				TBL_RESULTS=> $tbl_resultados
		);
	$contenido 	= contenidoHtml(strtolower(MODULO).'/'.$vistas[strtoupper($seccion)], $data_contenido);
	## Envio de valores ##
	$negocio = array(
				 MORE 		=> incJs($Path[srcjs].strtolower(MODULO).'/autorizacion_listado.js')	
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
function vars_autorizacion_5($seccion, $urlParams){
	global $var, $Path, $icono, $dic, $vistas, $usuario;
	## Logica de negocio ##		
	$titulo 	= $dic[consulta][titulo_autorizacion_5];
	$tbl_resultados = build_grid_consulta_autorizacion_5();
	$data_contenido = array(
				TBL_RESULTS=> $tbl_resultados
		);
	$contenido 	= contenidoHtml(strtolower(MODULO).'/'.$vistas[strtoupper($seccion)], $data_contenido);
	## Envio de valores ##
	$negocio = array(
				 MORE 		=> incJs($Path[srcjs].strtolower(MODULO).'/autorizacion_listado.js')	
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
function vars_autorizaciones($seccion, $urlParams){
	global $var, $Path, $icono, $dic, $vistas, $usuario;
	## Logica de negocio ##		
	$titulo 	= $dic[consulta][titulo_autorizacion_seguimiento];
	$tbl_resultados = build_grid_consulta_autorizaciones();
	$data_contenido = array(
				TBL_RESULTS=> $tbl_resultados
		);
	$contenido 	= contenidoHtml(strtolower(MODULO).'/'.$vistas[strtoupper($seccion)], $data_contenido);
	## Envio de valores ##
	$negocio = array(
				 MORE 		=> incJs($Path[srcjs].strtolower(MODULO).'/consulta.js')	
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
function vars_pendientes($seccion, $urlParams){
	global $var, $Path, $icono, $dic, $vistas, $usuario;
	## Logica de negocio ##		
	$titulo 	= $dic[consulta][titulo_consulta_pendientes];
	$tbl_resultados = build_grid_consulta_pendientes();
	$data_contenido = array(
				TBL_RESULTS=> $tbl_resultados
		);
	$contenido 	= contenidoHtml(strtolower(MODULO).'/'.$vistas[strtoupper($seccion)], $data_contenido);
	## Envio de valores ##
	$negocio = array(
				 MORE 		=> incJs($Path[srcjs].strtolower(MODULO).'/consulta.js')	
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
function vars_error($cmd){
	global $dic;
	## Envio de valores ##
	$data = array(MENSAJE => $dic[error][mensaje].': '.$cmd);
	return $data;
}
?>