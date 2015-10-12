<?php session_name('o3m_fw'); session_start(); if(isset($_SESSION['header_path'])){include_once($_SESSION['header_path']);}else{header('location: '.dirname(__FILE__));}
/* O3M
* Manejador de Vistas y asignación de variables
* REPORTES
*/
// Modulo Padre
global $vistas, $contenidos, $icono;
$icono = $var[ico_04];
define(MODULO,'REPORTES');
require_once($Path[src].strtolower(MODULO).'/dao.'.strtolower(MODULO).'.php');
require_once($Path[src].'build.contenidos.php');
# Vistas HTML
$vistas = array(
		 INDEX 			=> 'index.html'
		,REPORTE01 		=> 'rep_general.html'
		,REPORTE02	 	=> 'rep_periodos.html'
		,HISTORIAL	 	=> 'historia_usuario.html'
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
	}elseif($cmd == 'REPORTE01'){
		$vars = vars_reporte_general($cmd, $urlParams);
	}elseif($cmd == 'REPORTE02'){
		$vars = vars_reporte_periodos($cmd, $urlParams);
	}elseif($cmd == 'HISTORIAL'){
		$vars = vars_historial_usuario($cmd, $urlParams);
	}
	else{
		$vars = vars_error($cmd);
	}
	return $vars;
}

#############
// Funciones para asignar variables a cada vista
// $negocio => Logica de negocio; $texto => Mensajes de interfaz
function vars_reporte_general($seccion, $urlParams){
	global $var, $Path, $icono, $dic, $vistas, $usuario;
	## Logica de negocio ##		
	$titulo 	= $dic[reportes][reporte01_titulo];
	$empresa_inicial = ($usuario[id_grupo]>=20)?$usuario[id_empresa]:0;
	$tbl_resultados = build_reporte01($empresa_inicial);	
	$sel_empresa = build_select_empresas();
	$id_empresa = ($usuario[id_grupo]>=20)?$usuario[id_empresa]:false;
	$sel_anio = ($usuario[id_grupo]>=20)?build_select_anios($id_empresa):'';
	// $sel_periodo = build_select_periodos($id_empresa);
	$data_contenido = array(
				TBL_RESULTS 	=> $tbl_resultados
				,ID_EMPRESA 	=> $empresa_inicial
				,select_empresa => $sel_empresa
				,select_anio 	=> $sel_anio
				// ,select_periodo	=> $sel_periodo
		);
	$contenido 	= contenidoHtml(strtolower(MODULO).'/'.$vistas[strtoupper($seccion)], $data_contenido);
	## Envio de valores ##
	$negocio = array(
				 MORE 		=>  incJs($Path[srcjs].strtolower(MODULO).'/reporte_general.js')
				 			   .incJs($Path[js].'highcharts.js')
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

function vars_reporte_periodos($seccion, $urlParams){
	global $var, $Path, $icono, $dic, $vistas, $usuario;
	## Logica de negocio ##		
	$titulo 	= $dic[reportes][reporte02_titulo];
	$empresa_inicial = ($usuario[id_grupo]>=20)?$usuario[id_empresa]:0;
	$tbl_resultados = build_reporte_periodos();
	$sel_empresa = build_select_empresas();
	$id_empresa = ($usuario[id_grupo]>=20)?$usuario[id_empresa]:false;
	$sel_anio = ($usuario[id_grupo]>=20)?build_select_anios($id_empresa):'';
	$sel_periodo = build_select_periodos($id_empresa);
	$data_contenido = array(
				TBL_RESULTS 	=> $tbl_resultados
				,ID_EMPRESA 	=> $empresa_inicial
				,select_empresa => $sel_empresa
				,select_anio 	=> $sel_anio
				,select_periodo	=> $sel_periodo
		);
	$contenido 	= contenidoHtml(strtolower(MODULO).'/'.$vistas[strtoupper($seccion)], $data_contenido);
	## Envio de valores ##
	$negocio = array(
				 MORE 		=>  incJs($Path[srcjs].strtolower(MODULO).'/reporte_periodos.js')
				 			   .incJs($Path[js].'highcharts.js')
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

function vars_historial_usuario($seccion, $urlParams){
	global $var, $Path, $icono, $dic, $vistas, $usuario;
	## Logica de negocio ##		
	$titulo 	= $dic[reportes][reporte02_titulo];
	$tbl_resultados = build_hitorial_usuario();
	$data_contenido = array(
				TBL_RESULTS=> $tbl_resultados
		);
	$contenido 	= contenidoHtml(strtolower(MODULO).'/'.$vistas[strtoupper($seccion)], $data_contenido);
	## Envio de valores ##
	$negocio = array(
				 MORE 		=>  incJs($Path[srcjs].strtolower(MODULO).'/historial.js')
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