<?php session_name('o3m_fw'); session_start(); if(isset($_SESSION['header_path'])){include_once($_SESSION['header_path']);}else{header('location: '.__DIR__);}
/* O3M
* Manejador de Vistas
* Dependencia: tpl.views.vars.php
* Modulos => $in[m]; Secciones => $in[s];
*/
// Valida parametro URL
if(!$in[m] || !isset($in[m])){header('location: '.$Raiz[url]);}
// Modulos
define(MOD_GENERAL, 'views.vars.general.php');
define(MOD_CONTENEDOR, 'views.vars.contenedor.php');
if($cfg[encrypt_onoff]){
	$modulo = $in[m];
	$seccion = $in[s];
}else{
	$modulo = strtoupper($in[m]);
	$seccion = strtoupper($in[s]);
}
// Distingue entre Login y Contendor
if(enArray($seccion,array(LOGIN=>''))){
	require_once($Path[src].MOD_GENERAL);	
	$vista 		= vistas($seccion);
	$tpl_data 	= tpl_vars($seccion,$ins);
	print(contenidoHtml($vista, $tpl_data));
	// Cierra sesión de usuario
	unset($_SESSION[user]['id_usuario']);
}else{
	require_once($Path[src].MOD_CONTENEDOR);
	$vista 		= frm_vistas('CONTENEDOR');
	$tpl_data 	= frm_vars($modulo, $seccion,$ins);
	print(contenedorHtml($vista, $tpl_data));
}
/*O3M*/
?>
