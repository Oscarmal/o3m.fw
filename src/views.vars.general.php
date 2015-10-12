<?php session_name('o3m_fw'); session_start(); if(isset($_SESSION['header_path'])){include_once($_SESSION['header_path']);}else{header('location: '.dirname(__FILE__));}
/* O3M
* Manejador de Vistas y asignación de variables
* 
*/
// Modulo Padre
define(MODULO, 'GENERAL');
global $vistas, $contenidos, $icono;
$icono = $var[ico_01];
# Vistas
$vistas = array(
			 LOGIN 	=> 'login.html'
			,INICIO => 'inicio.html'
			,ERROR 	=> 'error.html'
			);

# Comandos
function vistas($cmd){
	global $vistas;
	$modulo = strtolower(MODULO).'/';
	$comando = strtoupper(enArray($cmd,$vistas));	
	if(array_key_exists($comando,$vistas)){
		$html = $modulo.$vistas[$comando];
	}else{
		$html = $vistas[ERROR];
	}
	return $html;
}

# Variables
function tpl_vars($cmd, $urlParams=array()){
	global $vistas;
	$cmd = strtoupper(enArray($cmd,$vistas));
	if($cmd == 'LOGIN'){
		$vars = vars_login($urlParams);
	}elseif($cmd == 'INICIO'){
		$vars = vars_inicio($urlParams);
	}else{
		$vars = vars_error($cmd);
	}
	return $vars;
}

#############
// Funciones para asignar variables a cada vista
// $negocio => Logica de negocio; $texto => Mensajes de interfaz

function vars_login($urlParams){
	global $Path, $dic;
	$modulo = strtolower(MODULO).'/';
	$seccion = encrypt('LOGIN',1);
	## Logica de negocio ##
	// Mensajes via URL	
	switch ($urlParams[e]) {
		case 1: $msj = $dic[login][msj_noauth];
				break;
		case 2: $msj = $dic[login][msj_salir];
				break;			
		default:$msj = $dic[login][msj_entrar];
				break;
	}

	## Envio de valores ##
	$negocio = array(
				 MORE 		=> incJs($Path[srcjs].$modulo.'login.js')
				 			  .incCss($Path[css].'maruti-login.css')
				,MODULE 	=> strtolower(MODULO)
				,SECTION 	=> strtolower($seccion)				
			);
	$texto = array(
				 login 		=> $dic[general][login]
				,usuario 	=> $dic[general][usuario]
				,clave 		=> $dic[general][clave]
				,entrar 	=> $dic[general][entrar]
				,MSJ 		=> $msj
			);	
	$data = array_merge($negocio, $texto);	
	return $data;
}
function vars_inicio($urlParams){
	global $var, $Path, $icono, $dic, $usuario;
	## Logica de negocio ##
	$titulo = $dic[general][titulo];
	$contenido = $dic[general][msj_inicio];
	## Envio de valores ##
	$negocio = array(
				 MORE 		=> ''				
				,ICONO 		=> $icono
				,TITULO		=> $titulo
				,CONTENIDO 	=> $contenido
			);
	$texto = array();
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