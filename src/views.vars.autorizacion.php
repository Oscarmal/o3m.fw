<?php session_name('o3m_fw'); session_start(); if(isset($_SESSION['header_path'])){include_once($_SESSION['header_path']);}else{header('location: '.dirname(__FILE__));}
/* O3M
* Manejador de Vistas y asignación de variables
* AUTORIZACION
*/
// Modulo Padre
global $vistas, $contenidos, $icono;
$icono = $var[ico_02];
define(MODULO,'AUTORIZACION');
require_once($Path[src].strtolower(MODULO).'/dao.'.strtolower(MODULO).'.php');
require_once($Path[src].'build.contenidos.php');
# Vistas HTML
$vistas = array(
		 INDEX 				=> 'index.html'	
		,AUTORIZACION_1 	=> 'autorizacion_1.html'	
		,AUTORIZACION_2 	=> 'autorizacion_2.html'
		,AUTORIZACION_3		=> 'autorizacion_3.html'
		,AUTORIZACION_4		=> 'autorizacion_4.html'
		,AUTORIZACION_5		=> 'autorizacion_5.html'
		,AUTORIZACION_6		=> 'autorizacion_6.html'
		,ERROR 	 			=> 'error.html'
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
	}
	elseif($cmd == 'AUTORIZACION_1'){
		$vars = vars_autorizacion_1($cmd, $urlParams);
	}
	elseif($cmd == 'AUTORIZACION_2'){
		$vars = vars_autorizacion_2($cmd, $urlParams);
	}
	elseif($cmd == 'AUTORIZACION_3'){
		$vars = vars_autorizacion_3($cmd, $urlParams);		
	}
	elseif($cmd == 'AUTORIZACION_4'){
		$vars = vars_autorizacion_4($cmd, $urlParams);
	}
	elseif($cmd == 'AUTORIZACION_5'){
		$vars = vars_autorizacion_5($cmd, $urlParams);
	}
	elseif($cmd == 'AUTORIZACION_6'){
		$vars = vars_autorizacion_6($cmd, $urlParams);
	}else{
		$vars = vars_error($cmd);
	}
	return $vars;
}
#############
// Funciones para asignar variables a cada vista
// $negocio => Logica de negocio; $texto => Mensajes de interfaz
function vars_index($seccion, $urlParams){
	global $var, $Path, $icono, $dic, $vistas, $usuario;
	## Logica de negocio ##		
	$titulo 	= $dic[autorizacion][autorizacion_titulo];
	$tbl_resultados = build_grid_autorizaciones();
	$data_contenido = array(
				TBL_RESULTS=> $tbl_resultados
		);
	$contenido 	= contenidoHtml(strtolower(MODULO).'/'.$vistas[strtoupper($seccion)], $data_contenido);
	## Envio de valores ##
	$negocio = array(
				 MORE 		=> incJs($Path[srcjs].strtolower(MODULO).'/autorizacion.js')	
				,MODULE 	=> strtolower(MODULO)
				,SECTION 	=> ($seccion)				 
			);
	$texto = array(
				 ICONO 		=> $icono
				,TITULO		=> $titulo
				,CONTENIDO 	=> $contenido
				,genera_xls	=> $dic[autorizacion][genera_xls]
			);
	$data = array_merge($negocio, $texto);
	return $data;
}
function vars_autorizacion_1($seccion, $urlParams){
	global $var, $Path, $icono, $dic, $vistas, $usuario;
	## Logica de negocio ##		
	$titulo 	= $dic[autorizacion][autorizacion_1_titulo];
	$tbl_resultados = build_autorizacion_1();
	$data_contenido = array(
				TBL_RESULTS=> $tbl_resultados
		);
	$contenido 	= contenidoHtml(strtolower(MODULO).'/'.$vistas[strtoupper($seccion)], $data_contenido);
	## Envio de valores ##
	$negocio = array(
				 MORE 		=> incJs($Path[srcjs].strtolower(MODULO).'/autorizacion.js')	
				,MODULE 	=> strtolower(MODULO)
				,SECTION 	=> ($seccion)				 
			);
	$texto = array(
				 ICONO 		=> $icono
				,TITULO		=> $titulo
				,CONTENIDO 	=> $contenido
				,genera_xls	=> $dic[autorizacion][genera_xls]
			);
	$data = array_merge($negocio, $texto);
	return $data;
}
function vars_autorizacion_2($seccion, $urlParams){
	global $var, $Path, $icono, $dic, $vistas, $usuario;
	## Logica de negocio ##		
	$titulo 	= $dic[autorizacion][autorizacion_2_titulo];
	$tbl_resultados = build_grid_autorizacion_2();
	$data_contenido = array(
				TBL_RESULTS=> $tbl_resultados
		);
	$contenido 	= contenidoHtml(strtolower(MODULO).'/'.$vistas[strtoupper($seccion)], $data_contenido);
	## Envio de valores ##
	$negocio = array(
				 MORE 		=> incJs($Path[srcjs].strtolower(MODULO).'/autorizacion.js')	
				,MODULE 	=> strtolower(MODULO)
				,SECTION 	=> ($seccion)				 
			);
	$texto = array(
				 ICONO 		=> $icono
				,TITULO		=> $titulo
				,CONTENIDO 	=> $contenido
				,genera_xls	=> $dic[autorizacion][genera_xls]
			);
	$data = array_merge($negocio, $texto);
	return $data;
}
function vars_autorizacion_3($seccion, $urlParams){
	global $var, $Path, $icono, $dic, $vistas, $usuario;
	## Logica de negocio ##		
	$titulo 	= $dic[autorizacion][autorizacion_3_titulo];
	$tbl_resultados = build_grid_autorizacion_3();
	$data_contenido = array(
				TBL_RESULTS=> $tbl_resultados
		);
	$contenido 	= contenidoHtml(strtolower(MODULO).'/'.$vistas[strtoupper($seccion)], $data_contenido);
	## Envio de valores ##
	$negocio = array(
				 MORE 		=> incJs($Path[srcjs].strtolower(MODULO).'/autorizacion.js')	
				,MODULE 	=> strtolower(MODULO)
				,SECTION 	=> ($seccion)				 
			);
	$texto = array(
				 ICONO 		=> $icono
				,TITULO		=> $titulo
				,CONTENIDO 	=> $contenido
				,genera_xls	=> $dic[autorizacion][genera_xls]
			);
	$data = array_merge($negocio, $texto);
	return $data;
}
function vars_autorizacion_4($seccion, $urlParams){
	global $var, $Path, $icono, $dic, $vistas, $usuario;

	## Logica de negocio ##		
	$titulo 	= $dic[autorizacion][autorizacion_4_titulo];
	$tbl_resultados = build_grid_autorizacion_4();
	$data_contenido = array(
				TBL_RESULTS=> $tbl_resultados
		);
	$contenido 	= contenidoHtml(strtolower(MODULO).'/'.$vistas[strtoupper($seccion)], $data_contenido);
	## Envio de valores ##
	$negocio = array(
				 MORE 		=> incJs($Path[srcjs].strtolower(MODULO).'/autorizacion.js')	
				,MODULE 	=> strtolower(MODULO)
				,SECTION 	=> ($seccion)				 
			);
	$texto = array(
				 ICONO 		=> $icono
				,TITULO		=> $titulo
				,CONTENIDO 	=> $contenido
				,genera_xls	=> $dic[autorizacion][genera_xls]
			);
	$data = array_merge($negocio, $texto);
	return $data;
}
function vars_autorizacion_5($seccion, $urlParams){
	global $var, $Path, $icono, $dic, $vistas, $usuario;

	## Logica de negocio ##		
	$titulo 	= $dic[autorizacion][autorizacion_5_titulo];
	$tbl_resultados = build_grid_autorizacion_5();
	$data_contenido = array(
				TBL_RESULTS=> $tbl_resultados
		);
	$contenido 	= contenidoHtml(strtolower(MODULO).'/'.$vistas[strtoupper($seccion)], $data_contenido);
	## Envio de valores ##
	$negocio = array(
				 MORE 		=> incJs($Path[srcjs].strtolower(MODULO).'/autorizacion.js')	
				,MODULE 	=> strtolower(MODULO)
				,SECTION 	=> ($seccion)				 
			);
	$texto = array(
				 ICONO 		=> $icono
				,TITULO		=> $titulo
				,CONTENIDO 	=> $contenido
				,genera_xls	=> $dic[autorizacion][genera_xls]
			);
	$data = array_merge($negocio, $texto);
	return $data;
}
function vars_autorizacion_6($seccion, $urlParams){
	global $var, $Path, $icono, $dic, $vistas, $usuario;

	## Logica de negocio ##		
	$titulo 	= $dic[autorizacion][autorizacion_3_titulo];
	$tbl_resultados = build_grid_autorizaciones_aprobadas();
	$data_contenido = array(
				TBL_RESULTS=> $tbl_resultados
		);
	$contenido 	= contenidoHtml(strtolower(MODULO).'/'.$vistas[strtoupper($seccion)], $data_contenido);
	## Envio de valores ##
	$negocio = array(
				 MORE 		=> incJs($Path[srcjs].strtolower(MODULO).'/autorizacion.js')	
				,MODULE 	=> strtolower(MODULO)
				,SECTION 	=> ($seccion)				 
			);
	$texto = array(
				 ICONO 		=> $icono
				,TITULO		=> $titulo
				,CONTENIDO 	=> $contenido
				,genera_xls	=> $dic[autorizacion][genera_xls]
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