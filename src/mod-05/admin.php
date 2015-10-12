<?php session_name('o3m_fw'); session_start(); if(isset($_SESSION['header_path'])){include_once($_SESSION['header_path']);}else{header('location: '.dirname(__FILE__));}
// Define modulo del sistema
define(MODULO, $in[modulo]);
// Archivo DAO
set_time_limit(0);
require_once($Path[src].MODULO.'/dao.'.strtolower(MODULO).'.php');
require_once($Path[src].MODULO.'/'.'layout.xls.php');
require_once($Path[src].'views.vars.'.MODULO.'.php');
global $usuario,$db;
// Lógica de negocio

if($in[auth]){
	if($ins[accion]=='sincronizar'){
		$datos=select_empresas_activas();
		
		if(count($datos[id_nomina])==1){
			$id_empresa=$datos[id_nomina];
		}
		else{
			for($j=0;$j<count($datos);$j++){
				 
				$id_empresa.=$datos[$j][id_nomina].',';
			}
		}
			$id_empresa_nomina=trim($id_empresa,",");
		
		// if($usuario[id_grupo]<20){
		// 	$filtrado=false;
		// 	$success=select_view_vista_credenciales($filtrado,$id_empresa_nomina);
		// }
		// else{
		// 	$filtrado=true;
		// 	$id_empresa=$usuario[id_empresa_nomina];
		// 	$success=select_view_vista_credenciales($filtrado,$id_empresa);
		// }
		$id_empresa=$usuario[id_empresa_nomina];
		$success=select_view_vista_credenciales($filtrado,$id_empresa);	
		
		$msj = ($success)?'Guardado':'No guardó';
			if($msj=='Guardado'){
				$valor=count($success);

				$query='';
				for($i=0; $i<=$valor-1; $i++){
				
					$id_empresa 			=	$success[$i][id_empresa];
					$id_number				=	$success[$i][id_number];
					$nombre					=	$success[$i][nombre_empleado];
					$paterno				=	$success[$i][apellido_paterno_empleado];
					$materno				=	$success[$i][apellido_materno_empleado];
					$email					=	(strlen($success[$i][correo_electronico])>3) ? $success[$i][correo_electronico] : '';
					$position				=	$success[$i][position];
					$area					=	$success[$i][area];
					$rfc					=	$success[$i][rfc];
					$imss					=	$success[$i][imss];
					$ingreso				=	$success[$i][ingreso];
					$empresa 				=	$success[$i][empresa];
					$empresa_razon_social	=	$success[$i][empresa_razon_social];
					$id_empleado			=	$success[$i][id_empleado];
					$estado					=	sanitizerUrl($success[$i][estado]);
					$sucursal				=	sanitizerUrl($success[$i][sucursal]);

					$query.="INSERT INTO
							$db[view_nomina]
						SET
							id_empresa 					=	(SELECT id_empresa FROM he_empresas WHERE id_nomina=$id_empresa),
							id_number 					=	'$id_number',
							nombre_empleado				=	'$nombre',
							apellido_paterno_empleado 	=	'$paterno',
							apellido_materno_empleado 	=	'$materno',
							correo_electronico			= 	'$email',
							position 					=	'$position',
							area 						=	'$area',
							rfc 						=	'$rfc',
							imss 						=	'$imss',
							ingreso 					=	'$ingreso',
							empresa 					=	'$empresa',
							empresa_razon_social 		=	'$empresa_razon_social',
							id_empleado 				=	'$id_empleado',
							estado 						=	'$estado',
							sucursal 					=	'$sucursal'
						;\r\n";
				}

				$archivo=$Path[tmp].'insert_'.date('Ymd-His').'.sql';
				$file=fopen($archivo, 'w');
				$query2=count($query);
				fwrite($file,$query);
				fclose($file);
				
				$host = $db[db_local_host];
				$user = $db[db_local_user];
				$pass = $db[db_local_pass];
				$base = $db[db_local_db1];
				truncate_vista_nomina();

				$insert=exec("mysql -h ".$host." -u ".$user." -p".$pass." --default-character-set=latin1 ".$base." < ".$archivo);
				if ($insert === FALSE) {
				  $msj='No guardó';
				}
				else{
					unlink($archivo);
					insert_sincronizacion_update();
					$msj='Guardado';
				}
			}
			else{
				$msj='No guardó';
			}
		$data = array(success => $msj, message => $msj);
	}
	elseif($in[accion]=='nuevo_usuario'){

		$nombre				=	mb_strtoupper($in[nombre], 'UTF-8');
		$apellido_paterno	=	mb_strtoupper($in[apellido_paterno], 'UTF-8');
		$apellido_materno	=	mb_strtoupper($in[apellido_materno], 'UTF-8');
		$correo				=	$in[correo];
		$rfc				=	mb_strtoupper($in[rfc], 'UTF-8');
		$nss				=	mb_strtoupper($in[nss], 'UTF-8');
		$sucursal			=	mb_strtoupper($in[sucursal], 'UTF-8');
		$puesto				=	mb_strtoupper($in[puesto], 'UTF-8');
		$no_empleado		=	mb_strtoupper($in[no_empleado], 'UTF-8');
		$id_nomina			=	mb_strtoupper($in[id_nomina], 'UTF-8');		
		$id_empresa 		=	$in[id_empresa];
		$id_usuario_grupo 	=	$in[id_usuario];
		$timestamp 			= 	date('Y-m-d H:i:s');
		$success = insert_nuevo_registro($nombre,$apellido_paterno,$apellido_materno,$correo,$rfc,$nss,$sucursal,$puesto,$no_empleado,$id_empresa,$id_usuario_grupo,$timestamp,$id_nomina);
		// dump_var("entra");
		// for($x=1; $x<=5; $x++){
		// 	$nivel_vars = array(
		// 			 auth 			=> 1
		// 			,id_empresa 	=> $id_empresa
		// 			,id_usuario		=> $nuevo
		// 			,id_supervisor	=> $in['nivel'.$x]
		// 			,id_nivel 		=> $x
		// 		);

		// 	$nivel = insert_supervisor($nivel_vars);
		// 	$success++;
		// }
		if($success){	
		// envío de correo
			if($html_tpl = email_tpl_usuario_nuevo($nuevo)){
				// extraccion de datos
				$sqlData = array(
					 auth 		=> 1
					,id_usuario	=> $nuevo
				);
				$data = admin_select_usuario($sqlData);
				$destinatarios[] = array(
					 email	=> $data[empleado_correo]
					,nombre	=> $data[empleado_nombre]
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
		$data = array(success => $msj, message => $msj);		
	}
	elseif($in[accion]=='sincronizar_empresa'){
			$success=select_empresas_nomina($filtrado,$vacio);
		  	$msj = ($success)?'Guardado':'No guardó';
			if($msj=='Guardado'){
				$valor=count($success);
				$query='';
				$query.="CREATE TABLE IF NOT EXISTS `tmp_empresas_nomina` (
							  `id_empresa` smallint(4) NOT NULL AUTO_INCREMENT,
							  `nombre` varchar(200) COLLATE utf8_spanish_ci DEFAULT NULL,
							  `siglas` varchar(20) COLLATE utf8_spanish_ci DEFAULT NULL,
							  `rfc` varchar(18) COLLATE utf8_spanish_ci DEFAULT NULL,
							  `razon` varchar(200) COLLATE utf8_spanish_ci DEFAULT NULL,
							  `direccion` text COLLATE utf8_spanish_ci,
							  `pais` varchar(15) COLLATE utf8_spanish_ci DEFAULT 'MX',
							  `email` varchar(80) COLLATE utf8_spanish_ci DEFAULT NULL,
							  `timestamp` datetime DEFAULT NULL,
							  `id_usuario` int(11) DEFAULT NULL,
							  `activo` tinyint(1) DEFAULT '0',
							  `id_nomina` int(11) DEFAULT NULL,
							  PRIMARY KEY (`id_empresa`),
							  KEY `i_nomina` (`id_nomina`)
							);";
				for($i=0; $i<=$valor-1; $i++){
				
					$id_nomina 		=	$success[$i][id_empresa];
					$empresa		=	$success[$i][empresa_razon_social];
					$siglas			=	$success[$i][empresa];
					$timestamp 		= 	date('Y-m-d H:i:s');
					$id_usuario 	= 	$usuario[id_usuario];

					$query.="INSERT INTO
							tmp_empresas_nomina
						SET
							nombre 			=	'$empresa',
							siglas 			=	'$siglas',
							razon 			=	'$empresa',
							timestamp 		=	'$timestamp',
							id_usuario 		=	$id_usuario,
							id_nomina 		=	'$id_nomina';\r\n";
				}
				$archivo=$Path[tmp].'insert_empresas'.date('Ymd-His').'.sql';
				$file=fopen($archivo, 'w');
				$query2=count($query);
				fwrite($file,$query);
				fclose($file);
				
				$host = $db[db_local_host];
				$user = $db[db_local_user];
				$pass = $db[db_local_pass];
				$base = $db[db_local_db1];

				$insert=exec("mysql -h ".$host." -u ".$user." -p".$pass." --default-character-set=latin1 ".$base." < ".$archivo);

				if ($insert === FALSE) {
				  $msj='No guardó';
				}
				else{
					$msj='Guardado';
					$success=insert_empresa_nomina_tmp();
					eliminar_tmp_empresa_nomina();
					unlink($archivo);
				}
			}
			else{
				 $msj='No guardó';
			}
		$data = array(success => $msj, message => $msj);
	}
	elseif($in[accion]=='supervisor-popup'){
		$sqlData = array(
			 auth 			=> 1,
			 id_personal 	=> $in[id_personal]
		);

		$catalogo_nivel1=build_catalgo_supervisores(1, $in[id_personal]);
		$catalogo_nivel2=build_catalgo_supervisores(2, $in[id_personal]);
		$catalogo_nivel3=build_catalgo_supervisores(3, $in[id_personal]);
		$catalogo_nivel4=build_catalgo_supervisores(4, $in[id_personal]);
		$catalogo_nivel5=build_catalgo_supervisores(5, $in[id_personal]);
		$datos_usuario=select_datos_usuario($sqlData);
		//dump_var($datos_usuario);

		$vista_new 	= 'admin/supervisor_popup.html';
		$tpl_data = array(
				 MORE 			=> incJs($Path[srcjs].strtolower(MODULO).'/supervisor_popup.js')
				 					.incJs($Path[js].'chosen_v1.4.2/chosen.jquery.min.js')
				,id_personal 	=> $in[id_personal]
				,catalgo	 	=> $select
				,guardar 		=> 'Guardar'			
				,cerrar	 		=> 'Cerrar'
				,id_personal 	=> $datos_usuario[id_personal]
				,id_empresa 	=> $datos_usuario[id_empresa]
				,nombre 		=> utf8_encode($datos_usuario[nombre].' '.$datos_usuario[paterno].' '.$datos_usuario[materno])
				,rfc 			=> utf8_encode($datos_usuario[rfc])
				,imss 			=> utf8_encode($datos_usuario[imss])
				,sucursal 		=> utf8_encode($datos_usuario[sucursal])
				,empresa 		=> utf8_encode($datos_usuario[empresa])
				,catalogo_nivel1 		=>$catalogo_nivel1
				,catalogo_nivel2 		=>$catalogo_nivel2
				,catalogo_nivel3 		=>$catalogo_nivel3
				,catalogo_nivel4 		=>$catalogo_nivel4
				,catalogo_nivel5 		=>$catalogo_nivel5			
				);		
		$CONTENIDO 	= contenidoHtml($vista_new, $tpl_data);
		// dump_var($CONTENIDO);
		// Envio de resultado
		$success = ($CONTENIDO)?true:false;
		$msj = ($success)?'Popup OK':'Popup Fail';
		$data = array(success => $success, message => $msj, html => $CONTENIDO);			
	}
	elseif($in[accion]=='supervisor-guardar'){	
			$nivel_vars = array(
					 auth 			=> 1
					,id_personal 	=>$in[id_personal]
					,id_empresa 	=> $in[id_empresa]
			);

			// Limpia cadena de supervisión
			delete_supervisores($nivel_vars);

			// Inserta nueva cadena de supevisión
			if($in[nivel1]){
				$nivel_vars[id_supervisor] = $in[nivel1];
				$nivel_vars[id_nivel] = 1;
				$success=insert_supervisor_sincronizacion($nivel_vars);
			}

			if($in[nivel2]){
				$nivel_vars[id_supervisor] = $in[nivel2];
				$nivel_vars[id_nivel] = 2;
				$success=insert_supervisor_sincronizacion($nivel_vars);
			}

			if($in[nivel3]){
				$nivel_vars[id_supervisor] = $in[nivel3];
				$nivel_vars[id_nivel] = 3;
				$success=insert_supervisor_sincronizacion($nivel_vars);
			}

			if($in[nivel4]){
				$nivel_vars[id_supervisor] = $in[nivel4];
				$nivel_vars[id_nivel] = 4;
				$success=insert_supervisor_sincronizacion($nivel_vars);
			}

			if($in[nivel5]){
				$nivel_vars[id_supervisor] = $in[nivel5];
				$nivel_vars[id_nivel] = 5;
				$success=insert_supervisor_sincronizacion($nivel_vars);
			}
			// --
		
		$msj = ($success)?'Guardado':'No guardó';
		$data = array(success => $success, message => $msj);
	}
	elseif($in[accion]=='admin-usuario-popup'){
		$sqlData = array(
			 auth 			=> 1,
			 id_personal 	=> $in[id_personal]
		);

		// $catalogo_nivel1=build_catalgo_supervisores(1);
		// $catalogo_nivel2=build_catalgo_supervisores(2);
		// $catalogo_nivel3=build_catalgo_supervisores(3);
		// $catalogo_nivel4=build_catalgo_supervisores(4);
		// $catalogo_nivel5=build_catalgo_supervisores(5);
		$datos_usuario=select_admin_usuarios($sqlData);
		//dump_var($datos_usuario);

		$vista_new 	= 'admin/usuarios_admin_popup.html';
		$tpl_data = array(
				 MORE 			=> incJs($Path[srcjs].strtolower(MODULO).'/usuarios_admin_popup.js')
				,id_personal 	=> $in[id_personal]
				,catalgo	 	=> $select
				,guardar 		=> 'Guardar'			
				,cerrar	 		=> 'Cerrar'
				,id_personal 	=> $datos_usuario[id_personal]
				,id_empresa 	=> $datos_usuario[id_empresa]
				,nombre 		=> utf8_encode($datos_usuario[nombre])
				,paterno 		=> utf8_encode($datos_usuario[paterno])
				,materno 		=> utf8_encode($datos_usuario[materno])
				,rfc 			=> utf8_encode($datos_usuario[rfc])
				,nss 			=> utf8_encode($datos_usuario[imss])
				,sucursal 		=> build_catalgo_sucursales_nomina('sucursal', $datos_usuario[sucursal])
				,empresa 		=> utf8_encode($datos_usuario[empresa])
				,correo 		=> utf8_encode($datos_usuario[empleado_correo])
				,puesto 		=> utf8_encode($datos_usuario[puesto])
				,empleado_num	=> utf8_encode($datos_usuario[empleado_num])
				,id_nomina 		=> utf8_encode($datos_usuario[id_nomina])
				// ,catalogo_nivel1 		=>$catalogo_nivel1
				// ,catalogo_nivel2 		=>$catalogo_nivel2
				// ,catalogo_nivel3 		=>$catalogo_nivel3
				// ,catalogo_nivel4 		=>$catalogo_nivel4
				// ,catalogo_nivel5 		=>$catalogo_nivel5			
				);		
		$CONTENIDO 	= contenidoHtml($vista_new, $tpl_data);
		// dump_var($CONTENIDO);
		// Envio de resultado
		$success = ($CONTENIDO)?true:false;
		$msj = ($success)?'Popup OK':'Popup Fail';
		$data = array(success => $success, message => $msj, html => $CONTENIDO);			
	}
	elseif($in[accion]=='layout-popup'){
		// Deteccion de periodo activo en nomina
		$periodo = pgsql_select_periodo_activo(array(auth => 1));
		// Impresion de vista
		$vista_new 	= 'admin/layout_popup.html';
		$tpl_data = array(
				 MORE 			=> incJs($Path[srcjs].strtolower(MODULO).'/layout_popup.js')
				,ids			=> $in[ids]
				,periodo_anio	=> $periodo[periodo_anio]
				,periodo 		=> $periodo[periodo]
				,periodo_especial => $periodo[periodo_especial]
				,guardar 		=> 'Guardar'			
				,cerrar	 		=> 'Cerrar'			
				);		
		$CONTENIDO 	= contenidoHtml($vista_new, $tpl_data);
		// Envio de resultado
		$success = true;
		$msj = ($success)?'Popup OK':'Popup Fail';
		$data = array(success => $success, message => $msj, html => $CONTENIDO);			
	}
	elseif($in[accion]=='layout-guardar'){
		if(!empty($ins[datos])){			
			$datos = explode('|',$in[datos]);
			foreach($datos as $dato){
				$data = explode('=',$dato);	
				$data_arr[$data[0]]=$data[1];				
			}
			// Extraccion de ID's id_horas_extra
			$ids = explode(',',$data_arr[ids]);
			// inserción de información por cada registro id_horas_extra
			for($i=1; $i<=count($ids); $i++){
				$id_horas_extra 	= $ids[$i-1];
				$semana 			= $data_arr[semana];

				// Extraccion de datos
				$sqlData = array(
					 auth 			=> true
					,id_horas_extra	=> $id_horas_extra
				);
				$datos = select_asignar_semana($sqlData);
			// dump_var($datos);
				// Rendondeo de horas
				$horas = ($cfg[horas_redondeadas])?redondeo_horas_extra($datos[horas]):$datos[horas];
				// dump_var($horas);
				// cálculo de dobles y triples
				$arrDatos=array(
					 horas 			=> $horas
					,fecha 			=> $datos[fecha]
					,id_empresa 	=> $datos[id_empresa]
					,id_personal 	=> $datos[id_personal]
					,semana 	 	=> $semana
				);			
				$calculo_horas 	= calculo_horas_extra($arrDatos);
		// if($i==8){dump_var($calculo_horas);}
		// dump_var($calculo_horas);
				// Inserción en tabla
				$anio     			= $data_arr['anio'];			
				$periodo   			= $data_arr['periodo'];
				$periodo_especial 	= $data_arr['periodo_especial'];
				$semana   			= $data_arr['semana'];
				$id_cat_autorizacion= $datos[id_cat_autorizacion];
				$rechazadas			= false; #rechazadas
				$dobles_horas 		= $calculo_horas[dobles][resultado_horas];
				$dobles_porcentaje	= $calculo_horas[dobles][resultado_porcentaje];
				$triples_horas		= $calculo_horas[triples][resultado_horas];
				$triples_porcentaje	= $calculo_horas[triples][resultado_porcentaje];

		// dump_var($calculo_horas);		
				if(intval($calculo_horas[dobles][horas]) || intval($calculo_horas[dobles][minutos])){
				// DOBLES
					$sqlData = array(
						 auth 				=> true
						,id_horas_extra		=> $id_horas_extra
						,anio				=> $anio
						,periodo			=> $periodo
						,periodo_especial 	=> $periodo_especial
						,semana				=> $semana
						,horas 				=> $dobles_horas
						,horas_porcentaje 	=> $dobles_porcentaje
						,id_concepto 		=> 2
						,id_cat_autorizacion=> $id_cat_autorizacion
					);
				// dump_var($sqlData);
					$success  =  insert_layout($sqlData);
				}
				if(intval($calculo_horas[triples][horas]) || intval($calculo_horas[triples][minutos])){
				// TRIPLES
					$sqlData = array(
						 auth 				=> true
						,id_horas_extra		=> $id_horas_extra
						,anio				=> $anio
						,periodo			=> $periodo
						,periodo_especial 	=> $periodo_especial
						,semana				=> $semana
						,horas 				=> $triples_horas
						,horas_porcentaje 	=> $triples_porcentaje
						,id_concepto 		=> 3
						,id_cat_autorizacion=> $id_cat_autorizacion
					);
				// dump_var($sqlData);
					$success  =  insert_layout($sqlData);
				}
				
			}
			$msj = ($success)?'Guardado':'No guardó';			
			$data = array(success => $success, message => $msj);
		}else{
			$success = false;
			$msj = "Sin guardar por falta de datos.";
		}		
	}
	elseif($in[accion]=='genera-xls-nomina'){
		$success = false;
		$nodata = true;
		$sqlData = array(
				 anio 		=> $in[anio]
				,periodo 	=> $in[periodo]
				,especial 	=> $in[periodo_especial]
			);
		if($success = ($xls = xsl_nomina($sqlData))?true:false){
			$msj = "Archivo generado";
			$nodata = false;
		}else{
			$msj = "Sin datos";
		}
		$data = array(success => $success, message => $msj, xls => $xls[url], archivo => $xls[filename], nodata => $nodata);
	}
	elseif($in[accion]=='regenera-xls-nomina'){
		$success = false;
		$nodata = true;
		$sqlData = array(
						 auth 	=> true
						,xls	=> $in[xls]
					);
		if($success = ($xls = xls_nomina_rebuild($sqlData))?true:false){
			$msj = "Archivo generado";
			$nodata = false;
		}else{
			$msj = "Sin datos";
		}
		$data = array(success => $success, message => $msj, xls => $xls[url], archivo => $xls[filename], nodata => $nodata);
	}
	elseif($in[accion]=='regenera-xls-resumen'){
		$success = false;
		$nodata = true;
		if($success = ($xls = xsl_resumen($in[xls]))?true:false){
			$msj = "Archivo generado";
			$nodata = false;
		}else{
			$msj = "Sin datos";
		}
		$data = array(success => $success, message => $msj, xls => $xls[url], archivo => $xls[filename], nodata => $nodata);
	}
	elseif($in[accion]=='admin-usuario-reset'){
		$sqlData = array(
			 auth 			=> 1,
			 id_personal 	=> $in[id_personal]
		);	
		$success  =  reset_usuario_clave($sqlData);
		if($success){	
		// envío de correo
			if($html_tpl = email_tpl_usuario_reset($in[id_personal])){
				// extraccion de datos
				$sqlData = array(
					 auth 		 => 1
					,id_personal => $in[id_personal]
				);
				$data = admin_select_usuario($sqlData);
				$destinatarios[] = array(
					 email	=> $data[empleado_correo]
					,nombre	=> $data[empleado_nombre]
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
		$msj = ($success)?'Popup OK':'Popup Fail';
		$data = array(success => $success, message => $msj, html => $CONTENIDO);			
	}
	elseif($in[accion]=='calendario-guardar-fecha'){
		$anio = explode('-',fecha_form($in[fecha_inicio],1));
		$fecha_fin = ($in[fecha_fin]=='')?NULL:fecha_form($in[fecha_fin],1);
		$sqlData = array(
						 auth 			=> true
						,tipo			=> $in[tipo]
						,id_empresa		=> $in[empresa]
						,anio			=> $anio[0]
						,fecha_inicio	=> fecha_form($in[fecha_inicio],1)
						,fecha_fin		=> $fecha_fin
					);
		$success  =  insert_calendario_fecha($sqlData);
		$msj = ($success)?'Guardado':'No guardó';
		$data = array(success => $msj, message => $msj);		
	}
	elseif($in[accion]=='modificar-usuario'){	
		$sqlData = array(
				 auth 				=> 1
				,id_personal 	=> $in[id_personal]
				,id_empresa 	=> $in[id_empresa]
				,nombre 		=> utf8_encode($in[nombre])
				,paterno 		=> utf8_encode($in[apellido_paterno])
				,materno 		=> utf8_encode($in[apellido_materno])
				,sucursal 		=> utf8_encode($in[sucursal])
				,email 			=> utf8_encode($in[correo])
				,empleado_num	=> utf8_encode($in[no_empleado])
				,id_nomina 		=> utf8_encode($in[id_nomina])
		);
		$success=update_usuario($sqlData);
		if($success){	
		// envío de correo
			if($html_tpl = email_tpl_usuario_modificado($in[id_personal])){
				// extraccion de datos
				$sqlData = array(
					 auth 		 => 1
					,id_personal => $in[id_personal]
				);
				$data = admin_select_usuario($sqlData);
				$destinatarios[] = array(
					 email	=> $data[empleado_correo]
					,nombre	=> $data[empleado_nombre]
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
	elseif($in[accion]=='xls-popup'){
		// Deteccion de periodo activo en nomina
		$periodo = pgsql_select_periodo_activo(array(auth => 1));
		// Impresion de vista
		$vista_new 	= 'admin/xls_popup.html';
		$tpl_data = array(
				 MORE 			=> incJs($Path[srcjs].strtolower(MODULO).'/xls_popup.js')
				,periodo_anio	=> $periodo[periodo_anio]
				,periodo 		=> $periodo[periodo]
				,periodo_especial => $periodo[periodo_especial]
				,guardar 		=> 'Guardar'			
				,cerrar	 		=> 'Cerrar'			
				);		
		$CONTENIDO 	= contenidoHtml($vista_new, $tpl_data);
		// Envio de resultado
		$success = true;
		$msj = ($success)?'Popup OK':'Popup Fail';
		$data = array(success => $success, message => $msj, html => $CONTENIDO);			
	}
	elseif($in[accion]=='supervisores-actualizar'){
			foreach ($in[datos] as $registro) {	
				// dump_var($registro);
				#CID & mail
				if($registro[cid] || $registro[mail] || $registro[sucursal]){
					$sucursal 	= ($registro[sucursal])?utf8_encode($registro[sucursal]):false;
					$cid 		= ($registro[cid])?utf8_encode($registro[cid]):false;
					$mail 		= ($registro[mail])?utf8_encode($registro[mail]):false;
					$sqlData = array(
							 auth 			=> 1
							,id_personal 	=> $registro[id_personal]
							,sucursal 		=> $sucursal
							,email 			=> $mail
							,empleado_num	=> $cid
					);
					$success=update_usuario($sqlData);
				}
				#Supervisores

				if($registro[nivel1] || $registro[nivel2] || $registro[nivel3] || $registro[nivel4] || $registro[nivel5]){
					$nivel_vars = array(
							 auth 			=> 1
							,id_personal 	=> $registro[id_personal]
							,id_empresa 	=> $usuario[id_empresa]
					);
					// Limpia cadena de supervisión
					delete_supervisores($nivel_vars);
					
					$nivel_vars[id_empresa] = $usuario[id_empresa];
					// Inserta nueva cadena de supevisión
					if($registro[nivel1]){
						$nivel_vars[id_supervisor] = $registro[nivel1];
						$nivel_vars[id_nivel] = 1;
						$success=insert_supervisor_sincronizacion($nivel_vars);
					}

					if($registro[nivel2]){
						$nivel_vars[id_supervisor] = $registro[nivel2];
						$nivel_vars[id_nivel] = 2;
						$success=insert_supervisor_sincronizacion($nivel_vars);
					}

					if($registro[nivel3]){
						$nivel_vars[id_supervisor] = $registro[nivel3];
						$nivel_vars[id_nivel] = 3;
						$success=insert_supervisor_sincronizacion($nivel_vars);
					}

					if($registro[nivel4]){
						$nivel_vars[id_supervisor] = $registro[nivel4];
						$nivel_vars[id_nivel] = 4;
						$success=insert_supervisor_sincronizacion($nivel_vars);
					}

					if($registro[nivel5]){
						$nivel_vars[id_supervisor] = $registro[nivel5];
						$nivel_vars[id_nivel] = 5;
						$success=insert_supervisor_sincronizacion($nivel_vars);
					}
				}
			}		
		$msj = ($success)?'Guardado':'No guardó';
		$data = array(success => $success, message => $msj);
	}
	elseif(!$ins[accion]){
		$error = array(error => 'Sin accion');		
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