<?php session_name('o3m_fw'); session_start(); if(isset($_SESSION['header_path'])){include_once($_SESSION['header_path']);}else{header('location: '.dirname(__FILE__));}
/* O3M
* Mensaje de Error
* 
*/
// Modulo Padre

function print_error($msj){
	$data = array(MENSAJE => $msj);
	echo contenedorHtml('error.html', $data);
	die();
}