<?php /*O3M*/
/**
* Descripción:	Establece variables con ruta local
* @author:		Oscar Maldonado - O3M
* Creación:		2015-10-08
* Comentarios: SYSTEM_FOLDER => El nombre de la carpeta del sitio: www/[Carpeta]
**/
session_name('o3m_fw');
session_start();
#Carpeta del sistema
define(SYSTEM_FOLDER, 'o3m.fw');
$path['folder'] = preg_split("/(".SYSTEM_FOLDER.")/", $_SERVER['REQUEST_URI']);
$path['folder'] = $path['folder'][0].SYSTEM_FOLDER.'/';
##
#Directorio local de sistema
define(PATH_LOCAL, $_SERVER['DOCUMENT_ROOT'].$path['folder']);
##
#URL raiz del sistema
define(PATH_URL, 'http://'.$_SERVER['SERVER_NAME'].$path['folder']);
##
$_SESSION['RaizLoc'] 	= PATH_LOCAL;
$_SESSION['RaizUrl'] 	= PATH_URL;
$_SESSION['SiteFolder'] = SYSTEM_FOLDER;
// print_r($_SESSION); die();
/*O3M*/
?>