<?php session_name('o3m_fw'); session_start(); if(isset($_SESSION['header_path'])){include_once($_SESSION['header_path']);}else{header('location: '.dirname(__FILE__));}
/* O3M
* Manejador de Vistas y asignación de variables
* 
*/
require_once('views.vars.error.php');
// Modulo Padre
#Modulos
$modulos = array(
			 'GENERAL' 		=> 'views.vars.general.php'
			,'MOD-01' 		=> 'views.vars.captura.php'			
			,'MOD-02' 		=> 'views.vars.autorizacion.php'
			,'MOD-03' 		=> 'views.vars.consulta.php'
			,'MOD-04' 		=> 'views.vars.reportes.php'
			,'MOD-05' 		=> 'views.vars.admin.php'
		);
// $modulo = strtoupper(enArray($modulo,$modulos));
#Vistas
$contenedor = array(
			 CONTENEDOR => 'system/frm_contenedor.html'
			,FRM_HEADER => 'system/frm_header.html'
			,FRM_MENU 	=> 'system/frm_menu.html'
			,FRM_FOOTER => 'system/frm_footer.html'
			,FRM_CONTENT=> 'system/frm_contenido.html'
		);

// $visitas = MODULO => SECCIONES
$frm_vistas = array(
			 'GENERAL' => 
			 	array(
			 		 INICIO 		=> 'inicio.html'
			 	)
			,'MOD-01' => 
			 	array(
			 		 CAPTURA 		=> 'captura.html'			 		
			 	)			
			,'MOD-02' => 
			 	array(
			 		 INDEX 			=> 'autorizacion.html'
			 		,AUTORIZACION_1 	=> 'autorizacion_1.html'	
					,AUTORIZACION_2 	=> 'autorizacion_2.html'
					,AUTORIZACION_3		=> 'autorizacion_3.html'
					,AUTORIZACION_4		=> 'autorizacion_4.html'
					,AUTORIZACION_5		=> 'autorizacion_5.html'
					,AUTORIZACION_6		=> 'autorizacion_6.html'
			 		// ,LAYOUT 		=> 'layout.html'
			 	)
			,'MOD-03' => 
			 	array(
			 		 INDEX 			=> 'index.html'
			 		,CONSULTA_AUTORIZACION_1 	=> 'consulta_autorizacion_1.html'
			 		,CONSULTA_AUTORIZACION_2 	=> 'consulta_autorizacion_2.html'
			 		,CONSULTA_AUTORIZACION_3 	=> 'consulta_autorizacion_3.html'
			 		,CONSULTA_AUTORIZACION_4 	=> 'consulta_autorizacion_4.html'
			 		,CONSULTA_AUTORIZACION_5 	=> 'consulta_autorizacion_5.html'
			 		,CONSULTA_AUTORIZACIONES 	=> 'consulta_autorizaciones.html'
			 		,CONSULTA_PENDIENTES 	 	=> 'consulta_pendientes.html'
			 	)  
			,'MOD-04' => 
			 	array(
			 		 INDEX 			=> 'index.html'
			 		,REPORTE01 		=> 'rep_general.html'
			 		,REPORTE02	 	=> 'rep_periodos.html'
			 		,HISTORIAL	 	=> 'historia_usuario.html'
			 	)
			,'MOD-05' => 
			 	array(
			 		 INDEX 			=> 'index.html'
			 		,LAYOUT			=> 'layout.html'
			 		,XLS			=> 'xls.html'
			 		,XLS_LISTA		=> 'xls_rebuild.html'
			 		,USUARIOS		=> 'usuarios.html'
			 		,SINCRONIZACION	=> 'sincronizacion.html'
			 		,ALTA_USUARIO	=> 'alta_usuario.html'
			 		,SINCRONIZACION_EMPRESAS => 'sincronizacion_empresas.html'
			 		,ADMIN_USUARIOS => 'usuarios_admin.html'
			 		,CALENDARIO 	=> 'calendario_periodos.html'
			 		,SUPERVISORES 	=> 'usuarios_supervisores.html'
			 	)
			,'ERROR' => 'error.html'
		);

# Comandos
function frm_vistas($cmd){
	global $contenedor; 
	$seccion = $cmd;
	if(array_key_exists($seccion,$contenedor)){
		$html = strtolower($contenedor[$seccion]);			
	}else{
		$html = $contenedor[ERROR];
	}
	return $html;
}

# Variables
function frm_vars($modulo, $seccion, $urlParams=array()){	
	global $frm_vistas, $modulos;	
	$mod  = strtoupper(enArray($modulo,$modulos));
	$sec = strtoupper(enArray($seccion,$frm_vistas[$mod]));	
	if($mod){
		$inc = $modulos[$mod];
	}
	if($sec){
		$vars = vars_frame($urlParams, $inc, $modulo, $seccion);
	}else{
		$vars = vars_frm_error($sec);		
	}
	return $vars;
}

#############
// Funciones para asignar variables a cada vista
// $negocio => Logica de negocio; $texto => Mensajes de interfaz

function vars_frame($urlParams, $inc, $modulo, $seccion){
// Carga la vista del Contenedor principal
	// print_r($inc);	die();
	global $cfg,$var, $parm, $Path, $dic, $contenedor, $usuario;
	## Logica de negocio ##
	if(!file_exists($Path[src].$inc)){				
		print_error('El archivo no existe: '.$inc);
	}else{
		require_once($Path[src].$inc);	
		// FRM_HEADER
		$header_opc = array(
					 MORE 	 		=> incJs($Path[srcjs].'general/login_popup.js')
					,img_logo		=> $var[img_logo]
					,ico_user		=> $var[ico_user]
					,ico_exit		=> $var[ico_exit]
					,fecha_hoy		=> fechaHoy()
					,TITULO	 		=> $cfg[app_title]
					,LINK_SALIR		=> $Path['url'].$parm[GENERAL].'/'.$parm[LOGOUT]

				);
		$HEADER 	= contenidoHtml($contenedor[FRM_HEADER], $header_opc);
		// --
		// FRM_MENU
		require_once($Path[src].'build.menu.php');
		$menu_opc = array(MENU => buildMenu());
		$MENU 		= contenidoHtml($contenedor[FRM_MENU], $menu_opc);
		// --	
		// FRM_FOOTER
		$footer_opc = array(
					 ANIO 		=> date('Y')
					,IMG_FOOTER => $Path[img].$var[img_footer]
				);
		$FOOTER 	= contenidoHtml($contenedor[FRM_FOOTER], $footer_opc);
		// --	
		// FRM_CONTENIDO
		$vista_new 	= $contenedor[FRM_CONTENT];
		$tpl_data 	= tpl_vars($seccion,$urlParams); 
		$CONTENIDO 	= contenidoHtml($vista_new, $tpl_data); 
		// --

		## Envio de valores ##
		$negocio = array(
					 MORE 			=> $tpl_data[MORE]				
					,FRM_HEADER		=> $HEADER
					,FRM_MENU 		=> $MENU
					,FRM_CONTENIDO	=> $CONTENIDO
					,FRM_FOOTER		=> $FOOTER
				);
		$texto = array(
					 salir 			=> $dic[general][salir]
					,usuario 		=> $dic[general][usuario]
					,user 			=> utf8_encode($usuario[nombre].' '.$usuario[usuario].' - '.$usuario[grupo])
					,empresa	 	=> utf8_encode($usuario[empresa])
					,contrasenia 	=> $dic[general][contrasenia]
				);
		$data = array_merge($negocio, $texto);
		return $data;
	}
}
function vars_frm_error($cmd){
	global $dic;
	## Envio de valores ##
	$data = array(MENSAJE => $dic[error][mensaje].': '.$cmd);
	return $data;
}
?>