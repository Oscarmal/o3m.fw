<?php /*O3M*/
/**
* Descripción:	Cron que envía correo al final del día de cierre de periodo a supervisores 
* @author:		Oscar Maldonado
* Creación:		2015-04-20
* Modificación:	
*/

// INCLUDES
require_once('includes.php');

/***********
* BUSSINES
***********/
// Deteccion de fin de periodo	
$periodo = select_periodo_activo();
if($periodo[periodo_fin]==date("Y-m-d")){
// if($periodo[periodo_fin]){
	$fecha = strtotime('+1 day', strtotime($periodo[periodo_fin])); #suma un día
	$fecha = date('d/m/Y', $fecha);
	if($html_tpl = email_tpl($fecha)){
		// Supervisores
		$sqlData = array(
			 auth 		=> true
			,estatus	=> 1
			,activo 	=> 1
		);
		$datos = listado_select_pendientes($sqlData);
		if(count($datos)){
			foreach($datos as $registro){
				$soloUno = (!is_array($registro))?true:false; #Deteccion de total de registros
				$data = (!$soloUno)?$registro:$datos; #Seleccion de arreglo	
				$destinatarios[] = array(
					 email	=> $data[email]
					,nombre	=> $data[nombre_completo]
				);
				if($soloUno) break;
			}
		}
		// Inplants
		$sqlData = array( auth => true);
		$datos = select_inplants($sqlData);
		if(count($datos)){
			foreach($datos as $registro){
				$soloUno = (!is_array($registro))?true:false; #Deteccion de total de registros
				$data = (!$soloUno)?$registro:$datos; #Seleccion de arreglo	
				$destinatariosCC[] = array(
					 email	=> $data[nivel1_mail]
					,nombre	=> $data[nivel1_nombre]
				);
				if($soloUno) break;
			}
		}	
		// Envio de correo
		$tplData = array(
			 html_tpl 			=> $html_tpl
			,destinatarios 		=> $destinatarios
			,destinatariosCC 	=> $destinatariosCC
			,destinatariosBCC 	=> $destinatariosBCC
			,asunto 			=> 'Sistema de Horas Extra'
			,adjuntos 			=> $adjuntos
		);
		// dump_var($tplData);
		if(send_mail_smtp($tplData)){
			$resultado = "Correo enviado OK: ".date("Y-m-d H:i:s");
		}else{
			$resultado = "ERROR: No se pudo enviar el correo.";
		}
	}else{
		$resultado = "ERROR: ".$html_tpl;
	}
	// Respuesta
	echo $resultado;
}else{
	echo "Proceso OK - Sin envio de correos: ".date("Y-m-d H:i:s");
}

/***********
* FUNCTIONS
***********/
// MAIL
function email_tpl($fecha){
	global $Raiz, $cfg, $Path;
	// Envia datos a plantilla html
	$vista_new 	= 'email/email_aviso_supervisores.html';
	$tpl_data = array(
			 TOP_IMG 		=> $Raiz[url].$cfg[path_img].'email_top.jpg'
			,TITULO 		=> 'Recordatorio de Horas Extra'	
			,VAR_FECHA 		=> $fecha
			,LINK 			=> '<a href="'.$cfg[app_link].'" target="_blank">Sistema Horas Extra</a>'
		);		
	$HTML = contenidoHtml($vista_new, $tpl_data);
	// Crea archivo html temporal
	$fname = $Path[tmp].date('YmdHis').'.html';
	$file = fopen($fname, "w");
	fwrite($file, $HTML);
	fclose($file);
	// Devuelve ruta del archivo tmp
	return $fname;
}

// DAO
function listado_select_pendientes($data=array()){
	if($data[auth]){
		global $db;
		$id_horas_extra = (is_array($data[id_horas_extra]))?implode(',',$data[id_horas_extra]):$data[id_horas_extra];
		$id_personal 	= (is_array($data[id_personal]))?implode(',',$data[id_personal]):$data[id_personal];
		$empleado_num 	= (is_array($data[empleado_num]))?implode(',',$data[empleado_num]):$data[empleado_num];
		$id_usuario		= (is_array($data[id_usuario]))?implode(',',$data[id_usuario]):$data[id_usuario];
		$activo 		= (is_array($data[activo]))?implode(',',$data[activo]):$data[activo];
		$grupo 			= (is_array($data[grupo]))?implode(',',$data[grupo]):$data[grupo];
		$orden 			= (is_array($data[orden]))?implode(',',$data[orden]):$data[orden];
		$filtro.= ($id_horas_extra)?" and a.id_horas_extra IN ($id_horas_extra)":'';
		$filtro.= ($id_personal)?" and a.id_personal IN ($id_personal)":'';
		$filtro.= ($empleado_num)?" and b.empleado_num IN ($empleado_num)":'';		
		$filtro.= ($activo)?" and a.activo IN ($activo)":'';
		$filtro.= ($id_usuario)?" and a.id_usuario IN ($id_usuario)":'';
		$sql = "SELECT tbl2.* FROM 
					(SELECT tbl1.* FROM 
						(SELECT 
					 a.id_horas_extra
					,a.id_empresa					
					,a.id_personal
					,c.nombre as empresa
					,b.estado
					,b.sucursal_nomina as sucursal
					,b.sucursal as localidad
					,CONCAT(b.nombre,' ',IFNULL(b.paterno,''),' ',IFNULL(b.materno,'')) as nombre_completo
					,b.email
					,b.empleado_num
					,b.id_nomina
					,a.fecha
					,DATE_FORMAT(a.horas,'%H:%i') as horas
					,DATE_FORMAT(d.horas,'%H:%i') as tiempoextra
					,d.h_rechazadas AS rechazadas
					,d.h_dobles AS dobles
					,d.h_triples AS triples
					,d.argumento
					,d.activo
					,a.semana_iso8601
					,b.nombre AS capturado_por
					,a.timestamp AS capturado_el
					,d.id_cat_autorizacion as nivel
					,d.estatus AS n1_estatus
					,d.id_usuario AS n1_id_usuario
					,d.timestamp AS n1_fecha
					,CONCAT(f.nombre,' ',IFNULL(f.paterno,''),' ',IFNULL(f.materno,''), ' - ',f.puesto, ' - ',f.empleado_num) as auth_nombre
					,CONCAT(i.nombre,' ',IFNULL(i.paterno,''),' ',IFNULL(i.materno,''), ' - ',i.puesto, ' - ',i.empleado_num) as nivel1_nombre
					,i.empleado_num as auth_cid
					,i.email as nivel1_mail
				FROM $db[tbl_horas_extra] a
				LEFT JOIN $db[tbl_personal] b ON a.id_empresa=b.id_empresa AND a.id_personal=b.id_personal
				LEFT JOIN $db[tbl_empresas] c ON a.id_empresa=c.id_empresa
				LEFT JOIN $db[tbl_autorizaciones] d ON a.id_horas_extra=d.id_horas_extra
				LEFT JOIN $db[tbl_usuarios] e on d.id_usuario=e.id_usuario
				LEFT JOIN $db[tbl_personal] f ON e.id_personal=f.id_personal
				LEFT JOIN $db[tbl_autorizaciones_nomina] g ON a.id_horas_extra=g.id_horas_extra 
				LEFT JOIN $db[tbl_supervisores] h ON a.id_personal=h.id_personal and h.id_nivel=1
				LEFT JOIN $db[tbl_personal] i ON h.id_supervisor=i.id_personal
				left join $db[tbl_supervisores] s1 on b.id_empresa=s1.id_empresa and b.id_personal=s1.id_personal and s1.id_nivel=1
				left join $db[tbl_supervisores] s2 on b.id_empresa=s2.id_empresa and b.id_personal=s2.id_personal and s2.id_nivel=2
				left join $db[tbl_supervisores] s3 on b.id_empresa=s3.id_empresa and b.id_personal=s3.id_personal and s3.id_nivel=3
				left join $db[tbl_supervisores] s4 on b.id_empresa=s4.id_empresa and b.id_personal=s4.id_personal and s4.id_nivel=4
				left join $db[tbl_supervisores] s5 on b.id_empresa=s5.id_empresa and b.id_personal=s5.id_personal and s5.id_nivel=5
			   WHERE 
			  	 	1 $filtro 
			   	ORDER BY d.id_cat_autorizacion DESC, d.timestamp DESC
					)tbl1
				)tbl2				
				WHERE 1 AND tbl2.n1_estatus IS NULL AND tbl2.nivel1_mail IS NOT NULL
		   		GROUP BY tbl2.auth_cid 
				;";
			// dump_var($sql);
		$resultado = SQLQuery($sql);
		$resultado = (count($resultado)) ? $resultado : false ;
	}
	return $resultado;
}

function select_inplants($data=array()){
	if($data[auth]){
		global $db;
		$sql = "SELECT 
					 CONCAT(a.nombre,' ',IFNULL(a.paterno,''),' ',IFNULL(a.materno,'')) as nombre_completo
					,a.email
				FROM $db[tbl_personal] a
				LEFT JOIN $db[tbl_usuarios] b on a.id_personal=b.id_personal
				LEFT JOIN $db[tbl_grupos] c on b.id_grupo=c.id_grupo
				WHERE c.grupo='inplant' AND a.id_personal>10
				;";
			// dump_var($sql);
		$resultado = SQLQuery($sql);
		$resultado = (count($resultado)) ? $resultado : false ;
	}
	return $resultado;
}

function select_periodo_activo($data=array()){
	global $db;
	$sql = "SELECT 
				 fecha_inicio as periodo_inicio
				,fecha_fin as periodo_fin
			FROM $db[tbl_calendarios] 
			WHERE tipo='INCIDENCIAS' AND id_empresa=41 AND curdate() BETWEEN fecha_inicio AND fecha_fin
			;";
		// dump_var($sql);
	$resultado = SQLQuery($sql);
	$resultado = (count($resultado)) ? $resultado : false ;
	return $resultado;
}
/*O3M*/
?>