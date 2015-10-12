<?php session_name('o3m_fw'); session_start(); if(isset($_SESSION['header_path'])){include_once($_SESSION['header_path']);}else{header('location: '.dirname(__FILE__));}
// Define modulo del sistema
define(MODULO, $in[modulo]);
// Archivo DAO
require_once($Path[src].MODULO.'/dao.'.strtolower(MODULO).'.php');
require_once($Path[src].'views.vars.'.MODULO.'.php');
// Lógica de negocio

if($in[auth]){	
	if($in[accion]=='popup-override'){
		// Extraccion de datos
		$sqlData = array(
			 auth 			=> true
			,id_horas_extra	=> $in[id_horas_extra]
		);
		$datos = select_layout_autorizacion_1($sqlData);
		// Deteccion de semana del año ISO8601
		$datos_semama = select_acumulado_semanal_2(array(
			 auth 			=> 1
			,id_empresa 	=> $datos[id_empresa]
			,id_personal	=> $datos[id_personal]
			,fecha 			=> $datos[fecha]
		));
		$semana_iso8601 = ($datos_semama[semana_iso8601])?$datos_semama[semana_iso8601]:$datos[semana_iso8601];
		$semana_horas	= ($datos_semama[tot_horas])?$datos_semama[tot_horas]:0;
		// Impresion de vista
		$vista_new 	= 'consulta/consulta_popup.html';		
		$tpl_data = array(
				 MORE 			=> incJs($Path[srcjs].strtolower(MODULO).'/consulta_popup.js')
				,id 	 		=> $datos[id_horas_extra]
				,nombre	 		=> $datos[nombre_completo]
				,clave	 		=> $datos[empleado_num]
				,fecha	 		=> $datos[fecha]
				,horas	 		=> $datos[horas]
				,semana_iso 	=> $semana_iso8601
				,tot_horas		=> $semana_horas.' hrs.'
				,dobles 		=> $in[dobles]
				,triples 		=> $in[triples]
				,rechazadas 	=> $in[rechazadas]
				,guardar 		=> 'Guardar'			
				,cerrar	 		=> 'Cerrar'			
				);		
		// dump_var($tpl_data);
		$CONTENIDO 	= contenidoHtml($vista_new, $tpl_data);
		// Envio de resultado
		$success = true;
		$msj = ($success)?'Popup OK':'Popup Fail';
		$data = array(success => $success, message => $msj, html => $CONTENIDO);			
	}
	elseif($in[accion]=='popup-guardar'){
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
	elseif($in[accion]=='xls_consulta_autorizaciones'){
		$sqlData = array(auth => true);
		$data = listado_select_autorizacion_1_xls($sqlData);
		if(count($data)){		
			$nameArchivo = 'HE_Horas-Extra_Consula_Autorizaciones_'.date('Ymd-His');
			$tituloTabla = utf8_decode('Horas Extra - Consulta Autorizaciones - '.date('Y-m-d H:i:s'));
			$titulos = array(					
					 utf8_decode('ID Nómina PAE')
		            ,utf8_decode('Nombre Completo')
					,utf8_decode('CID Empleado')
					,utf8_decode('Entidad')
					,utf8_decode('Sucursal')
					,utf8_decode('Área')
					,utf8_decode('Puesto')
					,utf8_decode('Fecha')
					,utf8_decode('Tiempo extra capturado')
					,utf8_decode('Tiempo extra autorizado')
					,utf8_decode('Autorización pendiente')
					,utf8_decode('Estatus')
					,utf8_decode('Argumento')
					,utf8_decode('ID HE')
			      );
			$directorio = $cfg[path_tmp];
			$xlsData = array(
			             descarga         => false
			            ,datos            => $data
			            ,colsTitulos      => $titulos
			            ,archivo          => $nameArchivo
			            ,tituloTabla      => $tituloTabla
			            ,hoja             => ''
			            ,directorio       => $directorio
			            ,id_empresa       => $usuario[id_empresa]
			      );
			$xls = xls($xlsData); 
			$success = true;
			$msj = "Con datos";
		}else{
			$msj = "Sin datos";
		}
		$data = array(success => $success, message => $msj, xls => $xls);
	}
	elseif($in[accion]=='xls_seguimiento_autorizaciones'){
		$sqlData = array(
			 auth 		=> true
			,estatus	=> 1
			,activo 	=> 1
		);
		$data = listado_select_autorizaciones_xls($sqlData);
		if(count($data)){		
			$nameArchivo = 'HE_Horas-Extra_Seguimiento_Autorizaciones_'.date('Ymd-His');
			$tituloTabla = utf8_decode('Horas Extra - Seguimiento Autorizaciones - '.date('Y-m-d H:i:s'));
			$titulos = array(					
					 utf8_decode('ID Nómina PAE')
		            ,utf8_decode('Nombre Completo')
					,utf8_decode('CID Empleado')
					,utf8_decode('Entidad')
					,utf8_decode('Sucursal')
					,utf8_decode('Área')
					,utf8_decode('Puesto')
					,utf8_decode('Fecha')
					,utf8_decode('Tiempo extra capturado')
					,utf8_decode('Tiempo extra autorizado')
					,utf8_decode('Autorización pendiente')
					,utf8_decode('Estatus')
					,utf8_decode('Argumento')
					,utf8_decode('ID HE')
			      );
			$directorio = $cfg[path_tmp];
			$xlsData = array(
			             descarga         => false
			            ,datos            => $data
			            ,colsTitulos      => $titulos
			            ,archivo          => $nameArchivo
			            ,tituloTabla      => $tituloTabla
			            ,hoja             => ''
			            ,directorio       => $directorio
			            ,id_empresa       => $usuario[id_empresa]
			      );
			$xls = xls($xlsData); 
			$success = true;
			$msj = "Con datos";
		}else{
			$msj = "Sin datos";
		}
		$data = array(success => $success, message => $msj, xls => $xls);
	}
	elseif($in[accion]=='xls_seguimiento_pendientes'){
		$sqlData = array(
			 auth 		=> true
			,estatus	=> 1
			,activo 	=> 1
		);
		$data = listado_select_pendientes_xls($sqlData);
		if(count($data)){		
			$nameArchivo = 'HE_Horas-Extra_Seguimiento_Pendientes_'.date('Ymd-His');
			$tituloTabla = utf8_decode('Horas Extra - Seguimiento Pendientes - '.date('Y-m-d H:i:s'));
			$titulos = array(					
					 utf8_decode('ID Nómina PAE')
		            ,utf8_decode('Nombre Completo')
					,utf8_decode('CID Empleado')
					,utf8_decode('Entidad')
					,utf8_decode('Sucursal')
					,utf8_decode('Área')
					,utf8_decode('Puesto')
					,utf8_decode('Fecha')
					,utf8_decode('Tiempo extra capturado')
					,utf8_decode('Tiempo extra autorizado')
					,utf8_decode('Autorización pendiente')
					,utf8_decode('Estatus')
					,utf8_decode('Argumento')
					,utf8_decode('ID HE')
			      );
			$directorio = $cfg[path_tmp];
			$xlsData = array(
			             descarga         => false
			            ,datos            => $data
			            ,colsTitulos      => $titulos
			            ,archivo          => $nameArchivo
			            ,tituloTabla      => $tituloTabla
			            ,hoja             => ''
			            ,directorio       => $directorio
			            ,id_empresa       => $usuario[id_empresa]
			      );
			$xls = xls($xlsData); 
			$success = true;
			$msj = "Con datos";
		}else{
			$msj = "Sin datos";
		}
		$data = array(success => $success, message => $msj, xls => $xls);
	}
	$data = json_encode($data);
}else{
	$error = array(error => 'Sin autorización');
	$data = json_encode($error);
}
// Resultado
echo $data;
/*O3M*/
?>