<?php session_name('o3m_he'); session_start(); if(isset($_SESSION['header_path'])){include_once($_SESSION['header_path']);}else{header('location: '.dirname(__FILE__));}
/*
* Descripción:	Constructor de archivo .htaccess para carpeta src
* Autor:		Oscar Maldonado
* Creación:		2014-11-09
*/
if($ins[auth]=='rebuild'){
	$fname = $RaizLoc.'src/'.'.htaccess';
	$file=fopen($fname,'w+');
	$string .= '#Archivo creado de forma automática el: '.date('Y-m-d H:i:s')."\n\r";
	$string .= 'ErrorDocument 403 '.$RaizUrl;
	$string .= "\n\r".'#O3M#';
	fwrite($file, $string);
	fclose($file);
	echo '<h2>Éxito!</h2>';
	echo 'Archivo generado correctamente!';
	echo '<br/>';
	echo 'Ruta: ';
	echo '<br/>';
	echo $fname;
	echo '<br/>';
	echo 'Contenido del archivo:';
	echo '<br/>';
	echo $string;
	echo '<hr/>';
	echo date('Y-m-d H:i:s');
}else{
	echo '<h2>Error!</h2>';
	echo 'Sin autorización para ejecutar este script.';
}
?>