<?php session_name('o3m_fw'); session_start(); if(isset($_SESSION['header_path'])){include_once($_SESSION['header_path']);}else{header('location: '.dirname(__FILE__));}
/* O3M
* Manejador de Vistas y asignación de variables
* CAPTURA
*/
// Modulo Padre
global $vistas, $contenidos, $icono;
$icono = $var[ico_01];
define(MODULO,'MOD-01');
require_once($Path[src].strtolower(MODULO).'/dao.'.strtolower(MODULO).'.php');
require_once($Path[src].'build.contenidos.php');
# Vistas HTML
$vistas = array(
		 CAPTURA 	=> 'captura.html'
		,ERROR 	 	=> 'error.html'
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
	if($cmd == 'CAPTURA'){
		$vars = vars_captura($cmd, $urlParams);
	}else{
		$vars = vars_error($cmd);
	}
	return $vars;
}

#############
// Funciones para asignar variables a cada vista
// $negocio => Logica de negocio; $texto => Mensajes de interfaz

function vars_captura($seccion, $urlParams){
	global $var, $Path, $icono, $dic, $vistas, $usuario;
	## Logica de negocio ##
	$titulo 	= $dic[captura][titulo];
	$data_contenido = array();
	$contenido 	= contenidoHtml(strtolower(MODULO).'/'.$vistas[strtoupper($seccion)], $data_contenido);
	## Envio de valores ##
	$negocio = array(
				 MORE 		=> incJs($Path[srcjs].strtolower(MODULO).'/captura.js')	
				,MODULE 	=> strtolower(MODULO)
				,SECTION 	=> ($seccion)
			);
	$texto = array(
				 ICONO 			=> $icono
				,TITULO			=> $titulo
				,CONTENIDO 		=> $contenido				
				,id_usuario 	=> $usuario[id_usuario]
				,periodo_inicio	=> $usuario[periodo_inicio]
				,periodo_fin 	=> $usuario[periodo_fin]
				,empleado_num 	=> $usuario[empleado_num]
				,empleado_nombre=> $usuario[nombre]
				,captura_fecha 	=> date('d/m/Y')
				,guardar		=> $dic[captura][guardar]
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