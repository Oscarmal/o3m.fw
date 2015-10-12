<?php session_name('o3m_fw'); session_start(); if(isset($_SESSION['header_path'])){include_once($_SESSION['header_path']);}else{header('location: '.dirname(__FILE__));}
// Define modulo del sistema
define(MODULO, $in[modulo]);
// Archivo DAO
require_once($Path[src].MODULO.'/dao.'.strtolower(MODULO).'.php');
require_once($Path[src].MODULO.'/xls.'.strtolower(MODULO).'.php');
require_once($Path[src].'views.vars.'.MODULO.'.php');
// Lógica de negocio

if($in[auth]){	
	/**
	* Autorización nivel 1
	*/
	if($in[accion]=='autorizacion1-popup'){
		// Extraccion de datos
		$sqlData = array(
			 auth 			=> true
			,id_horas_extra	=> $in[id_horas_extra]
		);
		$datos = select_layout_autorizacion_1($sqlData);
		// Impresion de vista
		$vista_new 	= 'autorizacion/autorizar_popup_1.html';
		$tpl_data = array(
				 MORE 			=> incJs($Path[srcjs].strtolower(MODULO).'/autorizar_popup_1.js')
				,id 	 		=> $datos[id_horas_extra]
				,nombre	 		=> utf8_encode($datos[nombre_completo])
				,clave	 		=> $datos[empleado_num]
				,fecha	 		=> $datos[fecha]
				,horas	 		=> $datos[horas]
				,guardar 		=> 'Autorizar'			
				,cerrar	 		=> 'Cerrar'			
				);		
		$CONTENIDO 	= contenidoHtml($vista_new, $tpl_data);
		// Envio de resultado
		$success = true;
		$msj = ($success)?'Popup OK':'Popup Fail';
		$data = array(success => $success, message => $msj, html => $CONTENIDO);			
	}
	elseif($in[accion]=='autorizacion1-guardar'){
		if(!empty($ins[datos])){				
			$datos = explode('|',$in[datos]);
			foreach($datos as $dato){
				$data = explode('=',$dato);	
				$data_arr[$data[0]]=$data[1];
			}			
			$id_horas_extra 	= $data_arr['id_horas_extra'];

			$horas				= ($data_arr['horas'])?str_pad($data_arr['horas'],2):'00';
			$minutos 			= ($data_arr['minutos'])?str_pad($data_arr['minutos'],2):'00';
			$tiempoextra 		= $horas.':'.$minutos;
			$estatus			= ($tiempoextra=='00:00')?0:1;		
			$argumento 			= mb_strtoupper($data_arr['argumento'], 'UTF-8');
			$sqlData = array(
						 auth 				=> true
						,id_horas_extra		=> $id_horas_extra
						,horas 				=> $tiempoextra
						,estatus 			=> $estatus
						,argumento 			=> $argumento
					);
			$success  =  insert_layout_autorizacion_1($sqlData);
			if($success){	
			// envío de correo
				if($html_tpl = email_tpl_autorizaciones($id_horas_extra,1)){
					// extraccion de datos
					$sqlData = array(
						 auth 			=> 1
						,id_horas_extra	=> $success
					);
					$data = select_correos_autorizaciones($sqlData);
					$destinatarios[] = array(
						 email	=> $data[email]
						,nombre	=> $data[nombre_completo]
					);
					$destinatarios[] = array(
						 email	=> $data[s2_email]
						,nombre	=> $data[s2_nombre_completo]
					);
					// $adjuntos[] = $Raiz[local].$cfg[path_img].'email_top.jpg';
					$tplData = array(
						 html_tpl 		=> $html_tpl
						,destinatarios 	=> $destinatarios
						,asunto 		=> 'Sistema de Horas Extra'
						,adjuntos 		=> $adjuntos
					);
					send_mail_smtp($tplData);
				}
			}
			$msj = ($success)?'Guardado':'No guardó';			
			$data = array(success => $success, message => $msj);
		}else{
			$success = false;
			$msj = "Sin guardar por falta de datos.";
		}		
	}
	/*Fin1*/
	/**
	* Autorización nivel 2
	*/
	elseif($in[accion]=='autorizacion2-popup'){
		// Extraccion de datos
		$sqlData = array(
			 auth 			=> true
			,id_horas_extra	=> $in[id_horas_extra]
		);
		$datos = select_layout_autorizacion_1($sqlData);
		// Impresion de vista
		$vista_new 	= 'autorizacion/autorizar_popup_2.html';
		$tpl_data = array(
				 MORE 			=> incJs($Path[srcjs].strtolower(MODULO).'/autorizar_popup_2.js')
				,id 	 		=> $datos[id_horas_extra]
				,nombre	 		=> utf8_encode($datos[nombre_completo])
				,clave	 		=> $datos[empleado_num]
				,fecha	 		=> $datos[fecha]
				,horas	 		=> $datos[horas]
				,guardar 		=> 'Autorizar'			
				,cerrar	 		=> 'Cerrar'			
				);		
		$CONTENIDO 	= contenidoHtml($vista_new, $tpl_data);
		// Envio de resultado
		$success = true;
		$msj = ($success)?'Popup OK':'Popup Fail';
		$data = array(success => $success, message => $msj, html => $CONTENIDO);			
	}
	elseif($in[accion]=='autorizacion2-guardar'){
		if(!empty($ins[datos])){				
			$datos = explode('|',$in[datos]);
			foreach($datos as $dato){
				$data = explode('=',$dato);	
				$data_arr[$data[0]]=$data[1];
			}			
			$id_horas_extra 	= $data_arr['id_horas_extra'];
			$horas				= ($data_arr['horas'])?str_pad($data_arr['horas'],2):'00';
			$minutos 			= ($data_arr['minutos'])?str_pad($data_arr['minutos'],2):'00';
			$tiempoextra 		= $horas.':'.$minutos;
			$estatus			= ($tiempoextra=='00:00')?0:1;		
			$argumento 			= mb_strtoupper($data_arr['argumento'], 'UTF-8');
			$sqlData = array(
						 auth 				=> true
						,id_horas_extra		=> $id_horas_extra
						,horas 				=> $tiempoextra
						,estatus 			=> $estatus
						,argumento 			=> $argumento
					);
			$success  =  insert_layout_autorizacion_1($sqlData);
			if($success){	
			// envío de correo
				switch ($usuario[id_grupo]) {
					case 50: $nivel = 1; break;		
					case 40: $nivel = 2; break;
					case 35: $nivel = 3; break;
					case 34: $nivel = 4; break;
					case 30: $nivel = 5; break;
					default: $nivel = 1; break;
				}
				if($html_tpl = email_tpl_autorizaciones($id_horas_extra,$nivel)){
					// extraccion de datos
					$sqlData = array(
						 auth 			=> 1
						,id_horas_extra	=> $success
					);
					$data = select_correos_autorizaciones($sqlData);
					$destinatarios[] = array(
						 email	=> $data[email]
						,nombre	=> $data[nombre_completo]
					);
					$destinatarios[] = array(
						 email	=> $data[s1_email]
						,nombre	=> $data[s1_nombre_completo]
					);
					$destinatarios[] = array(
						 email	=> $data[s2_email]
						,nombre	=> $data[s2_nombre_completo]
					);
					// $adjuntos[] = $Raiz[local].$cfg[path_img].'email_top.jpg';
					$tplData = array(
						 html_tpl 		=> $html_tpl
						,destinatarios 	=> $destinatarios
						,asunto 		=> 'Sistema de Horas Extra'
						,adjuntos 		=> $adjuntos
					);
					send_mail_smtp($tplData);
				}
			}
			$msj = ($success)?'Guardado':'No guardó';			
			$data = array(success => $success, message => $msj);
		}
	}
	/*Fin2*/
	/**
	* Autorización nivel 3
	*/
	elseif($in[accion]=='autorizacion3-popup'){
		// Extraccion de datos
		$sqlData = array(
			 auth 			=> true
			,id_horas_extra	=> $in[id_horas_extra]
		);
		$datos = select_layout_autorizacion_1($sqlData);
		// Impresion de vista
		$vista_new 	= 'autorizacion/autorizar_popup_3.html';
		$tpl_data = array(
				 MORE 			=> incJs($Path[srcjs].strtolower(MODULO).'/autorizar_popup_3.js')
				,id 	 		=> $datos[id_horas_extra]
				,nombre	 		=> utf8_encode($datos[nombre_completo])
				,clave	 		=> $datos[empleado_num]
				,fecha	 		=> $datos[fecha]
				,horas	 		=> $datos[horas]
				,guardar 		=> 'Autorizar'			
				,cerrar	 		=> 'Cerrar'			
				);		
		$CONTENIDO 	= contenidoHtml($vista_new, $tpl_data);
		// Envio de resultado
		$success = true;
		$msj = ($success)?'Popup OK':'Popup Fail';
		$data = array(success => $success, message => $msj, html => $CONTENIDO);			
	}
	elseif($in[accion]=='autorizacion3-guardar'){
		if(!empty($ins[datos])){				
			$datos = explode('|',$in[datos]);
			foreach($datos as $dato){
				$data = explode('=',$dato);	
				$data_arr[$data[0]]=$data[1];
			}			
			$id_horas_extra 	= $data_arr['id_horas_extra'];
			$horas				= ($data_arr['horas'])?str_pad($data_arr['horas'],2):'00';
			$minutos 			= ($data_arr['minutos'])?str_pad($data_arr['minutos'],2):'00';
			$tiempoextra 		= $horas.':'.$minutos;
			$estatus			= ($tiempoextra=='00:00')?0:1;		
			$argumento 			= mb_strtoupper($data_arr['argumento'], 'UTF-8');
			$sqlData = array(
						 auth 				=> true
						,id_horas_extra		=> $id_horas_extra
						,horas 				=> $tiempoextra
						,estatus 			=> $estatus
						,argumento 			=> $argumento
					);
			$success  =  insert_layout_autorizacion_1($sqlData);
			if($success){	
			// envío de correo
				switch ($usuario[id_grupo]) {
					case 50: $nivel = 1; break;		
					case 40: $nivel = 2; break;
					case 35: $nivel = 3; break;
					case 34: $nivel = 4; break;
					case 30: $nivel = 5; break;
					default: $nivel = 1; break;
				}
				if($html_tpl = email_tpl_autorizaciones($id_horas_extra,$nivel)){
					// extraccion de datos
					$sqlData = array(
						 auth 			=> 1
						,id_horas_extra	=> $success
					);
					$data = select_correos_autorizaciones($sqlData);
					$destinatarios[] = array(
						 email	=> $data[email]
						,nombre	=> $data[nombre_completo]
					);
					$destinatarios[] = array(
						 email	=> $data[s2_email]
						,nombre	=> $data[s2_nombre_completo]
					);
					$destinatarios[] = array(
						 email	=> $data[s3_email]
						,nombre	=> $data[s3_nombre_completo]
					);
					// $adjuntos[] = $Raiz[local].$cfg[path_img].'email_top.jpg';
					$tplData = array(
						 html_tpl 		=> $html_tpl
						,destinatarios 	=> $destinatarios
						,asunto 		=> 'Sistema de Horas Extra'
						,adjuntos 		=> $adjuntos
					);
					send_mail_smtp($tplData);
				}
			}
			$msj = ($success)?'Guardado':'No guardó';			
			$data = array(success => $success, message => $msj);
		}
	}
	/*Fin3*/

	$data = json_encode($data);
}else{
	$error = array(error => 'Sin autorización');
	$data = json_encode($error);
}
// Resultado
echo $data;
/*O3M*/
?>