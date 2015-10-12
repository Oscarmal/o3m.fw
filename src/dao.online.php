<?php session_name('o3m_fw'); session_start(); if(isset($_SESSION['header_path'])){include_once($_SESSION['header_path']);}else{header('location: '.dirname(__FILE__));}
/**
* 				Funciones "DAO" para función ONLINE
* Descripcion:	Ejecuta consultas SQL y devuelve el resultado.
* Creación:		2014-09-01
* @author 		Oscar Maldonado
*/
function online_select($id_usuario){
	global $db;
	$sql = "SELECT id_online FROM $db[tbl_online] WHERE id_usuario='$id_usuario' LIMIT 1;";
	$resultado = SQLQuery($sql);
	$resultado = ($resultado[0]) ? $resultado : false ;
	return $resultado;
}

function online_insert($id_usuario, $ultimo_clic){
	global $db;
	$sql = "INSERT INTO $db[tbl_online] SET 
				online = '$ultimo_clic',
				id_usuario = '$id_usuario';";
	$resultado = (SQLDo($sql))?true:false;
	return $resultado;
}

function online_update($id_usuario, $ultimo_clic){
	global $db;
	$sql = "UPDATE $db[tbl_online] SET 
				online='$ultimo_clic' 
				WHERE id_usuario='$id_usuario'
				LIMIT 1;";
	$resultado = (SQLDo($sql))?true:false;
	return $resultado;
}
/*O3M*/
?>