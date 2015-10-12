<?php session_name('o3m_fw'); session_start(); if(isset($_SESSION['header_path'])){include_once($_SESSION['header_path']);}else{header('location: '.dirname(__FILE__));}
/**
* 				Funciones "DAO"
* Descripcion:	Ejecuta consultas SQL y devuelve el resultado.
* Creación:		2014-08-27
* @author 		Oscar Maldonado
*/

function listado_select_autorizacion_1($data=array()){
	if($data[auth]){
		global $db, $usuario;
		
		$id_horas_extra = $data[id_horas_extra];
		$id_personal 	= $data[id_personal];
		$empleado_num 	= $data[empleado_num];
		//$estatus		= $data[estatus];
		$activo			= $data[activo];
		$grupo 			= $data[grupo];
		$orden 			= $data[orden];
		$desc 			= $data[desc];
		
		$filtro.=filtro_grupo(array(
                  10 => ''
                  ,20 => "and a.id_empresa='$usuario[id_empresa]'"
                  ,30 => "and a.id_empresa='$usuario[id_empresa]' and (s1.id_supervisor='$usuario[id_personal]' or s5.id_supervisor='$usuario[id_personal]')"
                  ,34 => "and a.id_empresa='$usuario[id_empresa]' and (s1.id_supervisor='$usuario[id_personal]' or s4.id_supervisor='$usuario[id_personal]')"
                  ,35 => "and a.id_empresa='$usuario[id_empresa]' and (s1.id_supervisor='$usuario[id_personal]' or s3.id_supervisor='$usuario[id_personal]')"
                  ,40 => "and a.id_empresa='$usuario[id_empresa]' and (s1.id_supervisor='$usuario[id_personal]' or s2.id_supervisor='$usuario[id_personal]')"
                  ,50 => "and a.id_empresa='$usuario[id_empresa]' and s1.id_supervisor='$usuario[id_personal]'"
                  ,60 => "and a.id_empresa='$usuario[id_empresa]' and a.id_usuario='$usuario[id_usuario]'"
                   ));
		$filtro.= ($id_horas_extra)?" and a.id_horas_extra='$id_horas_extra'":'';
		$filtro.= ($id_personal)?" and a.id_personal='$id_personal'":'';
		$filtro.= ($empleado_num)?" and b.empleado_num='$empleado_num'":'';
		

		$filtro.= ($activo)?" and a.activo IN ($activo)":'';
		$desc 	= ($desc)?" DESC":' ASC';
		$grupo 	= ($grupo)?"
							GROUP BY $grupo":"GROUP BY tbl2.id_horas_extra";
		$orden 	= ($orden)?"ORDER BY $orden".$desc:"ORDER BY tbl2.id_horas_extra".$desc;

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
					,b.puesto
					,CONCAT(b.nombre,' ',IFNULL(b.paterno,''),' ',IFNULL(b.materno,'')) as nombre_completo
					,b.empleado_num
					,a.fecha
					,DATE_FORMAT(a.horas,'%H:%i') as horas
					,DATE_FORMAT(d.horas,'%H:%i') as tiempoextra
					,d.h_rechazadas AS rechazadas
					,d.h_dobles AS dobles
					,d.h_triples AS triples
					,d.argumento
					,a.semana_iso8601
					,b.nombre AS capturado_por
					,a.timestamp AS capturado_el
					,d.id_cat_autorizacion as nivel
					,d.estatus AS n1_estatus
					,d.id_usuario AS n1_id_usuario
					,d.timestamp AS n1_fecha
					,CONCAT(f.nombre,' ',IFNULL(f.paterno,''),' ',IFNULL(f.materno,''), ' - ',f.puesto, ' - ',f.empleado_num) as auth_nombre
				FROM $db[tbl_horas_extra] a
				LEFT JOIN $db[tbl_personal] b ON a.id_empresa=b.id_empresa AND a.id_personal=b.id_personal
				LEFT JOIN $db[tbl_empresas] c ON a.id_empresa=c.id_empresa
				LEFT JOIN $db[tbl_autorizaciones] d ON a.id_horas_extra=d.id_horas_extra
				LEFT JOIN $db[tbl_usuarios] e on d.id_usuario=e.id_usuario
				LEFT JOIN $db[tbl_personal] f ON e.id_personal=f.id_personal
				LEFT JOIN $db[tbl_autorizaciones_nomina] g ON a.id_horas_extra=g.id_horas_extra
				left join $db[tbl_supervisores] s1 on b.id_empresa=s1.id_empresa and b.id_personal=s1.id_personal and s1.id_nivel=1
				left join $db[tbl_supervisores] s2 on b.id_empresa=s2.id_empresa and b.id_personal=s2.id_personal and s2.id_nivel=2
				left join $db[tbl_supervisores] s3 on b.id_empresa=s3.id_empresa and b.id_personal=s3.id_personal and s3.id_nivel=3
				left join $db[tbl_supervisores] s4 on b.id_empresa=s4.id_empresa and b.id_personal=s4.id_personal and s4.id_nivel=4
				left join $db[tbl_supervisores] s5 on b.id_empresa=s5.id_empresa and b.id_personal=s5.id_personal and s5.id_nivel=5
			   WHERE 
			  	 	1  AND g.id_autorizacion_nomina IS NULL
			   		$filtro 
			   	ORDER BY d.id_cat_autorizacion DESC, d.timestamp DESC
					)tbl1
				)tbl2
			   		$grupo 
					$orden;";
					// dump_var($sql);
		$resultado = SQLQuery($sql);
		$resultado = (count($resultado)) ? $resultado : false ;

	}else{
		$resultado = false;
	}
	return $resultado;
}

function listado_select_autorizaciones($data=array()){
	if($data[auth]){
		global $db, $usuario;
		$id_horas_extra = (is_array($data[id_horas_extra]))?implode(',',$data[id_horas_extra]):$data[id_horas_extra];
		$id_personal 	= (is_array($data[id_personal]))?implode(',',$data[id_personal]):$data[id_personal];
		$empleado_num 	= (is_array($data[empleado_num]))?implode(',',$data[empleado_num]):$data[empleado_num];
		$id_usuario		= (is_array($data[id_usuario]))?implode(',',$data[id_usuario]):$data[id_usuario];
		$activo 		= (is_array($data[activo]))?implode(',',$data[activo]):$data[activo];
		$grupo 			= (is_array($data[grupo]))?implode(',',$data[grupo]):$data[grupo];
		$orden 			= (is_array($data[orden]))?implode(',',$data[orden]):$data[orden];
		$filtro.=filtro_grupo(array(
                   10 => ''
                  ,20 => "and a.id_empresa='$usuario[id_empresa]'"
                  ,30 => "and a.id_empresa='$usuario[id_empresa]' and (s1.id_supervisor='$usuario[id_personal]' or s5.id_supervisor='$usuario[id_personal]')"
                  ,34 => "and a.id_empresa='$usuario[id_empresa]' and (s1.id_supervisor='$usuario[id_personal]' or s4.id_supervisor='$usuario[id_personal]')"
                  ,35 => "and a.id_empresa='$usuario[id_empresa]' and (s1.id_supervisor='$usuario[id_personal]' or s3.id_supervisor='$usuario[id_personal]')"
                  ,40 => "and a.id_empresa='$usuario[id_empresa]' and (s1.id_supervisor='$usuario[id_personal]' or s2.id_supervisor='$usuario[id_personal]')"
                  ,50 => "and a.id_empresa='$usuario[id_empresa]' and s1.id_supervisor='$usuario[id_personal]'"
                  ,60 => "and a.id_empresa='$usuario[id_empresa]' and a.id_usuario='$usuario[id_usuario]'"
       		));
		$filtro.= ($id_horas_extra)?" and a.id_horas_extra IN ($id_horas_extra)":'';
		$filtro.= ($id_personal)?" and a.id_personal IN ($id_personal)":'';
		$filtro.= ($empleado_num)?" and b.empleado_num IN ($empleado_num)":'';		
		$filtro.= ($activo)?" and a.activo IN ($activo)":'';
		$filtro.= ($id_usuario)?" and a.id_usuario IN ($id_usuario)":'';
		$grupo 	= ($grupo)?"GROUP BY $grupo":"GROUP BY tbl2.id_horas_extra";
			$orden 	= ($orden)?"ORDER BY $orden":"ORDER BY tbl2.id_horas_extra ASC";
		$sql = "SELECT tbl2.* FROM 
					(SELECT tbl1.* FROM 
						(SELECT 
					 a.id_horas_extra
					,a.id_empresa					
					,a.id_personal
					,b.id_nomina
					,c.nombre as empresa
					,b.estado
					,b.sucursal_nomina as sucursal
					,b.sucursal as localidad
					,b.puesto
					,CONCAT(b.nombre,' ',IFNULL(b.paterno,''),' ',IFNULL(b.materno,'')) as nombre_completo
					,b.empleado_num
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
				FROM $db[tbl_horas_extra] a
				LEFT JOIN $db[tbl_personal] b ON a.id_empresa=b.id_empresa AND a.id_personal=b.id_personal
				LEFT JOIN $db[tbl_empresas] c ON a.id_empresa=c.id_empresa
				LEFT JOIN $db[tbl_autorizaciones] d ON a.id_horas_extra=d.id_horas_extra
				LEFT JOIN $db[tbl_usuarios] e on d.id_usuario=e.id_usuario
				LEFT JOIN $db[tbl_personal] f ON e.id_personal=f.id_personal
				LEFT JOIN $db[tbl_autorizaciones_nomina] g ON a.id_horas_extra=g.id_horas_extra
				left join $db[tbl_supervisores] s1 on b.id_empresa=s1.id_empresa and b.id_personal=s1.id_personal and s1.id_nivel=1
				left join $db[tbl_supervisores] s2 on b.id_empresa=s2.id_empresa and b.id_personal=s2.id_personal and s2.id_nivel=2
				left join $db[tbl_supervisores] s3 on b.id_empresa=s3.id_empresa and b.id_personal=s3.id_personal and s3.id_nivel=3
				left join $db[tbl_supervisores] s4 on b.id_empresa=s4.id_empresa and b.id_personal=s4.id_personal and s4.id_nivel=4
				left join $db[tbl_supervisores] s5 on b.id_empresa=s5.id_empresa and b.id_personal=s5.id_personal and s5.id_nivel=5
			   WHERE 
			  	 	1 /*AND a.activo=1 */ $filtro 
			   	ORDER BY d.id_cat_autorizacion DESC, d.timestamp DESC
					)tbl1
				)tbl2				
				WHERE 1 /*AND tbl2.activo=1*/
				/*Filtro por un mes atras*/
				AND (YEAR(tbl2.fecha)>=YEAR(CURRENT_DATE-INTERVAL 1 MONTH) AND MONTH(tbl2.fecha)>=MONTH(CURRENT_DATE-INTERVAL 1 MONTH) 
					 OR tbl2.n1_estatus IS NULL)
		   		$grupo 
				$orden;";
			// dump_var($sql);
		$resultado = SQLQuery($sql);
		$resultado = (count($resultado)) ? $resultado : false ;
	}
	return $resultado;
}

function listado_select_pendientes($data=array()){
	if($data[auth]){
		global $db, $usuario,$var;
		$nivel_minimo 	= ($var[nivel_minimo])?$var[nivel_minimo]:1;
		$id_horas_extra = (is_array($data[id_horas_extra]))?implode(',',$data[id_horas_extra]):$data[id_horas_extra];
		$id_personal 	= (is_array($data[id_personal]))?implode(',',$data[id_personal]):$data[id_personal];
		$empleado_num 	= (is_array($data[empleado_num]))?implode(',',$data[empleado_num]):$data[empleado_num];
		$id_usuario		= (is_array($data[id_usuario]))?implode(',',$data[id_usuario]):$data[id_usuario];
		$activo 		= (is_array($data[activo]))?implode(',',$data[activo]):$data[activo];
		$grupo 			= (is_array($data[grupo]))?implode(',',$data[grupo]):$data[grupo];
		$orden 			= (is_array($data[orden]))?implode(',',$data[orden]):$data[orden];
		$filtro.=filtro_grupo(array(
                   10 => ''
                  ,20 => "and a.id_empresa='$usuario[id_empresa]'"
                  ,30 => "and a.id_empresa='$usuario[id_empresa]' and (s1.id_supervisor='$usuario[id_personal]' or s5.id_supervisor='$usuario[id_personal]')"
                  ,34 => "and a.id_empresa='$usuario[id_empresa]' and (s1.id_supervisor='$usuario[id_personal]' or s4.id_supervisor='$usuario[id_personal]')"
                  ,35 => "and a.id_empresa='$usuario[id_empresa]' and (s1.id_supervisor='$usuario[id_personal]' or s3.id_supervisor='$usuario[id_personal]')"
                  ,40 => "and a.id_empresa='$usuario[id_empresa]' and (s1.id_supervisor='$usuario[id_personal]' or s2.id_supervisor='$usuario[id_personal]')"
                  ,50 => "and a.id_empresa='$usuario[id_empresa]' and s1.id_supervisor='$usuario[id_personal]'"
                  ,60 => "and a.id_empresa='$usuario[id_empresa]' and a.id_usuario='$usuario[id_usuario]'"
       		));
		$filtro.= ($id_horas_extra)?" and a.id_horas_extra IN ($id_horas_extra)":'';
		$filtro.= ($id_personal)?" and a.id_personal IN ($id_personal)":'';
		$filtro.= ($empleado_num)?" and b.empleado_num IN ($empleado_num)":'';		
		$filtro.= ($activo)?" and a.activo IN ($activo)":'';
		$filtro.= ($id_usuario)?" and a.id_usuario IN ($id_usuario)":'';
		$grupo 	= ($grupo)?"GROUP BY $grupo":"GROUP BY tbl1.id_horas_extra";
			$orden 	= ($orden)?"ORDER BY $orden":"ORDER BY tbl1.id_horas_extra ASC";
		// $sql = "SELECT tbl2.* FROM 
		// 			(SELECT tbl1.* FROM 
		// 				(SELECT 
		// 			 a.id_horas_extra
		// 			,a.id_empresa					
		// 			,a.id_personal
		// 			,c.nombre as empresa
		// 			,b.estado
		// 			,b.sucursal_nomina as sucursal
		// 			,b.sucursal as localidad
		// 			,b.puesto
		// 			,CONCAT(b.nombre,' ',IFNULL(b.paterno,''),' ',IFNULL(b.materno,'')) as nombre_completo
		// 			,b.empleado_num
		// 			,b.id_nomina
		// 			,a.fecha
		// 			,DATE_FORMAT(a.horas,'%H:%i') as horas
		// 			,DATE_FORMAT(d.horas,'%H:%i') as tiempoextra
		// 			,d.h_rechazadas AS rechazadas
		// 			,d.h_dobles AS dobles
		// 			,d.h_triples AS triples
		// 			,d.argumento
		// 			,d.activo
		// 			,a.semana_iso8601
		// 			,b.nombre AS capturado_por
		// 			,a.timestamp AS capturado_el
		// 			,d.id_cat_autorizacion as nivel
		// 			,d.estatus AS n1_estatus
		// 			,d.id_usuario AS n1_id_usuario
		// 			,d.timestamp AS n1_fecha
		// 			,CONCAT(f.nombre,' ',IFNULL(f.paterno,''),' ',IFNULL(f.materno,''), ' - ',f.puesto, ' - ',f.empleado_num) as auth_nombre
		// 			,CONCAT(i.nombre,' ',IFNULL(i.paterno,''),' ',IFNULL(i.materno,''), ' - ',i.puesto, ' - ',i.empleado_num) as nivel1_nombre
		// 			,i.email as nivel1_mail
		// 		FROM $db[tbl_horas_extra] a
		// 		LEFT JOIN $db[tbl_personal] b ON a.id_empresa=b.id_empresa AND a.id_personal=b.id_personal
		// 		LEFT JOIN $db[tbl_empresas] c ON a.id_empresa=c.id_empresa
		// 		LEFT JOIN $db[tbl_autorizaciones] d ON a.id_horas_extra=d.id_horas_extra
		// 		LEFT JOIN $db[tbl_usuarios] e on d.id_usuario=e.id_usuario
		// 		LEFT JOIN $db[tbl_personal] f ON e.id_personal=f.id_personal
		// 		LEFT JOIN $db[tbl_autorizaciones_nomina] g ON a.id_horas_extra=g.id_horas_extra 
		// 		LEFT JOIN $db[tbl_supervisores] h ON a.id_personal=h.id_personal and h.id_nivel=1
		// 		LEFT JOIN $db[tbl_personal] i ON h.id_supervisor=i.id_personal
		// 		left join $db[tbl_supervisores] s1 on b.id_empresa=s1.id_empresa and b.id_personal=s1.id_personal and s1.id_nivel=1
		// 		left join $db[tbl_supervisores] s2 on b.id_empresa=s2.id_empresa and b.id_personal=s2.id_personal and s2.id_nivel=2
		// 		left join $db[tbl_supervisores] s3 on b.id_empresa=s3.id_empresa and b.id_personal=s3.id_personal and s3.id_nivel=3
		// 		left join $db[tbl_supervisores] s4 on b.id_empresa=s4.id_empresa and b.id_personal=s4.id_personal and s4.id_nivel=4
		// 		left join $db[tbl_supervisores] s5 on b.id_empresa=s5.id_empresa and b.id_personal=s5.id_personal and s5.id_nivel=5
		// 	   WHERE 
		// 	  	 	1 /*AND a.activo=1 */ $filtro 
		// 	   	ORDER BY d.id_cat_autorizacion DESC, d.timestamp DESC
		// 			)tbl1
		// 		)tbl2				
		// 		WHERE 1 /*AND tbl2.activo=1*/
		// 		/*Filtro por un mes atras*/
		// 		/*AND (YEAR(tbl2.fecha)>=YEAR(CURRENT_DATE-INTERVAL 1 MONTH) AND MONTH(tbl2.fecha)>=MONTH(CURRENT_DATE-INTERVAL 1 MONTH) 
		// 			 OR tbl2.n1_estatus IS NULL)*/
		// 		AND tbl2.n1_estatus IS NULL
		//    		$grupo 
		// 		$orden;";
		$sql = "SELECT tbl2.* FROM 
					(SELECT tbl1.* FROM (
						SELECT 
						 a.id_horas_extra
						,a.id_empresa
						,c.nombre as empresa
						,b.id_nomina
						,b.estado
						,b.sucursal_nomina as sucursal
						,b.sucursal as localidad
						,b.puesto
						,a.id_personal
						,b.empleado_num
						,CONCAT(b.nombre,' ',IFNULL(b.paterno,''),' ',IFNULL(b.materno,'')) as nombre_completo
						,a.fecha
						,e.estatus
						,TIME_FORMAT(a.horas,'%H:%i') as horas
						,TIME_FORMAT(e.h_dobles,'%H:%i') as dobles
						,TIME_FORMAT(e.h_triples,'%H:%i') as triples
						,TIME_FORMAT(e.h_rechazadas,'%H:%i') as rechazadas
						,a.semana_iso8601
						,e.id_cat_autorizacion
						,b.nombre AS capturado_por
						,a.timestamp AS capturado_el
						,CASE IFNULL(e.id_cat_autorizacion,'NULL')
							WHEN 'NULL' THEN CONCAT(s1.nombre,' ',IFNULL(s1.paterno,''),' ',IFNULL(s1.materno,''), ' - ',s1.puesto, ' - ',s1.empleado_num)
							WHEN 1 THEN CONCAT(s2.nombre,' ',IFNULL(s2.paterno,''),' ',IFNULL(s2.materno,''), ' - ',s2.puesto, ' - ',s2.empleado_num)
							WHEN 2 THEN CONCAT(s3.nombre,' ',IFNULL(s2.paterno,''),' ',IFNULL(s3.materno,''), ' - ',s3.puesto, ' - ',s3.empleado_num)
						END AS nivel1_nombre
						,CASE IFNULL(e.id_cat_autorizacion,'NULL')
							WHEN 'NULL' THEN IFNULL(s1.email,'')
							WHEN 1 THEN IFNULL(s2.email,'')
							WHEN 2 THEN IFNULL(s3.email,'')
						END AS nivel1_mail
					FROM $db[tbl_horas_extra] a
					LEFT JOIN $db[tbl_personal] b ON a.id_empresa=b.id_empresa AND a.id_personal=b.id_personal
					LEFT JOIN $db[tbl_empresas] c ON a.id_empresa=c.id_empresa
					LEFT JOIN $db[tbl_autorizaciones_nomina] d ON a.id_horas_extra=d.id_horas_extra
					LEFT JOIN (SELECT a.* FROM (SELECT * FROM $db[tbl_autorizaciones] ORDER BY timestamp DESC, id_cat_autorizacion DESC) a GROUP BY a.id_horas_extra) e ON a.id_horas_extra=e.id_horas_extra
					LEFT JOIN $db[tbl_usuarios] g on e.id_usuario=g.id_usuario
					LEFT JOIN $db[tbl_personal] h ON g.id_personal=h.id_personal
					LEFT JOIN $db[tbl_supervisores] n1 ON a.id_personal=n1.id_personal and n1.id_nivel=1
					LEFT JOIN $db[tbl_personal] s1 ON n1.id_supervisor=s1.id_personal
					LEFT JOIN $db[tbl_supervisores] n2 ON a.id_personal=n2.id_personal and n2.id_nivel=2
					LEFT JOIN $db[tbl_personal] s2 ON n2.id_supervisor=s2.id_personal
					LEFT JOIN $db[tbl_supervisores] n3 ON a.id_personal=n3.id_personal and n3.id_nivel=3
					LEFT JOIN $db[tbl_personal] s3 ON n3.id_supervisor=s3.id_personal
					WHERE 1 $filtro AND d.id_autorizacion_nomina IS NULL AND (e.id_cat_autorizacion<'$nivel_minimo' OR e.id_cat_autorizacion IS NULL) AND (e.estatus=1 OR e.estatus IS NULL)
					ORDER BY e.id_cat_autorizacion DESC, e.timestamp DESC
					) as tbl1
					$grupo 
					$orden
					) as tbl2
				;";
			// dump_var($sql);
		$resultado = SQLQuery($sql);
		$resultado = (count($resultado)) ? $resultado : false ;
	}
	return $resultado;
}

// XLS
function listado_select_autorizacion_1_xls($data=array()){
	if($data[auth]){
		global $db, $usuario;
		
		$id_horas_extra = $data[id_horas_extra];
		$id_personal 	= $data[id_personal];
		$empleado_num 	= $data[empleado_num];
		//$estatus		= $data[estatus];
		$activo			= $data[activo];
		$grupo 			= $data[grupo];
		$orden 			= $data[orden];
		$desc 			= $data[desc];
		
		$filtro.=filtro_grupo(array(
                  10 => ''
                  ,20 => "and a.id_empresa='$usuario[id_empresa]'"
                  ,30 => "and a.id_empresa='$usuario[id_empresa]' and (s1.id_supervisor='$usuario[id_personal]' or s5.id_supervisor='$usuario[id_personal]')"
                  ,34 => "and a.id_empresa='$usuario[id_empresa]' and (s1.id_supervisor='$usuario[id_personal]' or s4.id_supervisor='$usuario[id_personal]')"
                  ,35 => "and a.id_empresa='$usuario[id_empresa]' and (s1.id_supervisor='$usuario[id_personal]' or s3.id_supervisor='$usuario[id_personal]')"
                  ,40 => "and a.id_empresa='$usuario[id_empresa]' and (s1.id_supervisor='$usuario[id_personal]' or s2.id_supervisor='$usuario[id_personal]')"
                  ,50 => "and a.id_empresa='$usuario[id_empresa]' and s1.id_supervisor='$usuario[id_personal]'"
                  ,60 => "and a.id_empresa='$usuario[id_empresa]' and a.id_usuario='$usuario[id_usuario]'"
                   ));
		$filtro.= ($id_horas_extra)?" and a.id_horas_extra='$id_horas_extra'":'';
		$filtro.= ($id_personal)?" and a.id_personal='$id_personal'":'';
		$filtro.= ($empleado_num)?" and b.empleado_num='$empleado_num'":'';
		

		$filtro.= ($activo)?" and a.activo IN ($activo)":'';
		$desc 	= ($desc)?" DESC":' ASC';
		$grupo 	= ($grupo)?"
							GROUP BY $grupo":"GROUP BY tbl2.id_horas_extra";
		$orden 	= ($orden)?"ORDER BY $orden".$desc:"ORDER BY tbl2.id_horas_extra".$desc;

		$sql = "SELECT tbl2.* FROM 
					(SELECT tbl1.* FROM 
						(SELECT 					 
					 b.id_nomina
					,CONCAT(IFNULL(b.paterno,''),' ',IFNULL(b.materno,''),', ',IFNULL(b.nombre,'')) as nombre_completo
					,b.empleado_num
					,b.estado
					,b.sucursal_nomina as sucursal
					,b.sucursal as localidad
					,b.puesto
					,a.fecha
					,DATE_FORMAT(a.horas,'%H:%i') as horas
					,DATE_FORMAT(d.horas,'%H:%i') as tiempoextra
					,CONCAT(f.nombre,' ',IFNULL(f.paterno,''),' ',IFNULL(f.materno,''), ' - ',f.puesto, ' - ',f.empleado_num) as auth_nombre
					,IF(d.estatus=1, 'Aceptado', IF(d.estatus=0, 'Rechazado', 'Pendiente')) AS n1_estatus
					,d.argumento
					,a.id_horas_extra
				FROM $db[tbl_horas_extra] a
				LEFT JOIN $db[tbl_personal] b ON a.id_empresa=b.id_empresa AND a.id_personal=b.id_personal
				LEFT JOIN $db[tbl_empresas] c ON a.id_empresa=c.id_empresa
				LEFT JOIN $db[tbl_autorizaciones] d ON a.id_horas_extra=d.id_horas_extra
				LEFT JOIN $db[tbl_usuarios] e on d.id_usuario=e.id_usuario
				LEFT JOIN $db[tbl_personal] f ON e.id_personal=f.id_personal
				LEFT JOIN $db[tbl_autorizaciones_nomina] g ON a.id_horas_extra=g.id_horas_extra
				left join $db[tbl_supervisores] s1 on b.id_empresa=s1.id_empresa and b.id_personal=s1.id_personal and s1.id_nivel=1
				left join $db[tbl_supervisores] s2 on b.id_empresa=s2.id_empresa and b.id_personal=s2.id_personal and s2.id_nivel=2
				left join $db[tbl_supervisores] s3 on b.id_empresa=s3.id_empresa and b.id_personal=s3.id_personal and s3.id_nivel=3
				left join $db[tbl_supervisores] s4 on b.id_empresa=s4.id_empresa and b.id_personal=s4.id_personal and s4.id_nivel=4
				left join $db[tbl_supervisores] s5 on b.id_empresa=s5.id_empresa and b.id_personal=s5.id_personal and s5.id_nivel=5
			   WHERE 
			  	 	1  AND g.id_autorizacion_nomina IS NULL
			   		$filtro 
			   	ORDER BY d.id_cat_autorizacion DESC, d.timestamp DESC
					)tbl1
				)tbl2
			   		$grupo 
					$orden;";
					// dump_var($sql);
		$resultado = SQLQuery($sql);
		$resultado = (count($resultado)) ? $resultado : false ;

	}else{
		$resultado = false;
	}
	return $resultado;
}

function listado_select_autorizaciones_xls($data=array()){
	if($data[auth]){
		global $db, $usuario;
		$id_horas_extra = (is_array($data[id_horas_extra]))?implode(',',$data[id_horas_extra]):$data[id_horas_extra];
		$id_personal 	= (is_array($data[id_personal]))?implode(',',$data[id_personal]):$data[id_personal];
		$empleado_num 	= (is_array($data[empleado_num]))?implode(',',$data[empleado_num]):$data[empleado_num];
		$id_usuario		= (is_array($data[id_usuario]))?implode(',',$data[id_usuario]):$data[id_usuario];
		$activo 		= (is_array($data[activo]))?implode(',',$data[activo]):$data[activo];
		$grupo 			= (is_array($data[grupo]))?implode(',',$data[grupo]):$data[grupo];
		$orden 			= (is_array($data[orden]))?implode(',',$data[orden]):$data[orden];
		$filtro.=filtro_grupo(array(
                   10 => ''
                  ,20 => "and a.id_empresa='$usuario[id_empresa]'"
                  ,30 => "and a.id_empresa='$usuario[id_empresa]' and (s1.id_supervisor='$usuario[id_personal]' or s5.id_supervisor='$usuario[id_personal]')"
                  ,34 => "and a.id_empresa='$usuario[id_empresa]' and (s1.id_supervisor='$usuario[id_personal]' or s4.id_supervisor='$usuario[id_personal]')"
                  ,35 => "and a.id_empresa='$usuario[id_empresa]' and (s1.id_supervisor='$usuario[id_personal]' or s3.id_supervisor='$usuario[id_personal]')"
                  ,40 => "and a.id_empresa='$usuario[id_empresa]' and (s1.id_supervisor='$usuario[id_personal]' or s2.id_supervisor='$usuario[id_personal]')"
                  ,50 => "and a.id_empresa='$usuario[id_empresa]' and s1.id_supervisor='$usuario[id_personal]'"
                  ,60 => "and a.id_empresa='$usuario[id_empresa]' and a.id_usuario='$usuario[id_usuario]'"
       		));
		$filtro.= ($id_horas_extra)?" and a.id_horas_extra IN ($id_horas_extra)":'';
		$filtro.= ($id_personal)?" and a.id_personal IN ($id_personal)":'';
		$filtro.= ($empleado_num)?" and b.empleado_num IN ($empleado_num)":'';		
		$filtro.= ($activo)?" and a.activo IN ($activo)":'';
		$filtro.= ($id_usuario)?" and a.id_usuario IN ($id_usuario)":'';
		$grupo 	= ($grupo)?"GROUP BY $grupo":"GROUP BY tbl2.id_horas_extra";
			$orden 	= ($orden)?"ORDER BY $orden":"ORDER BY tbl2.id_horas_extra ASC";
		$sql = "SELECT tbl2.* FROM 
					(SELECT tbl1.* FROM 
						(SELECT 
					 b.id_nomina
					,CONCAT(IFNULL(b.paterno,''),' ',IFNULL(b.materno,''),', ',IFNULL(b.nombre,'')) as nombre_completo
					,b.empleado_num
					,b.estado
					,b.sucursal_nomina as sucursal
					,b.sucursal as localidad
					,b.puesto
					,a.fecha
					,DATE_FORMAT(a.horas,'%H:%i') as horas
					,DATE_FORMAT(d.horas,'%H:%i') as tiempoextra
					,CONCAT(f.nombre,' ',IFNULL(f.paterno,''),' ',IFNULL(f.materno,''), ' - ',f.puesto, ' - ',f.empleado_num) as auth_nombre
					,IF(d.estatus=1, 'Aceptado', IF(d.estatus=0, 'Rechazado', 'Pendiente')) AS n1_estatus
					,d.argumento
					,a.id_horas_extra
				FROM $db[tbl_horas_extra] a
				LEFT JOIN $db[tbl_personal] b ON a.id_empresa=b.id_empresa AND a.id_personal=b.id_personal
				LEFT JOIN $db[tbl_empresas] c ON a.id_empresa=c.id_empresa
				LEFT JOIN $db[tbl_autorizaciones] d ON a.id_horas_extra=d.id_horas_extra
				LEFT JOIN $db[tbl_usuarios] e on d.id_usuario=e.id_usuario
				LEFT JOIN $db[tbl_personal] f ON e.id_personal=f.id_personal
				LEFT JOIN $db[tbl_autorizaciones_nomina] g ON a.id_horas_extra=g.id_horas_extra
				left join $db[tbl_supervisores] s1 on b.id_empresa=s1.id_empresa and b.id_personal=s1.id_personal and s1.id_nivel=1
				left join $db[tbl_supervisores] s2 on b.id_empresa=s2.id_empresa and b.id_personal=s2.id_personal and s2.id_nivel=2
				left join $db[tbl_supervisores] s3 on b.id_empresa=s3.id_empresa and b.id_personal=s3.id_personal and s3.id_nivel=3
				left join $db[tbl_supervisores] s4 on b.id_empresa=s4.id_empresa and b.id_personal=s4.id_personal and s4.id_nivel=4
				left join $db[tbl_supervisores] s5 on b.id_empresa=s5.id_empresa and b.id_personal=s5.id_personal and s5.id_nivel=5
			   WHERE 
			  	 	1 /*AND a.activo=1 */ $filtro 
			   	ORDER BY d.id_cat_autorizacion DESC, d.timestamp DESC
					)tbl1
				)tbl2				
				WHERE 1 /*AND tbl2.activo=1*/
				/*Filtro por un mes atras*/
				AND (YEAR(tbl2.fecha)>=YEAR(CURRENT_DATE-INTERVAL 1 MONTH) AND MONTH(tbl2.fecha)>=MONTH(CURRENT_DATE-INTERVAL 1 MONTH) 
					 OR tbl2.n1_estatus='Pendiente')
		   		$grupo 
				$orden;";
			// dump_var($sql);
		$resultado = SQLQuery($sql);
		$resultado = (count($resultado)) ? $resultado : false ;
	}
	return $resultado;
}

function listado_select_pendientes_xls($data=array()){
	if($data[auth]){
		global $db, $usuario, $var;
		$nivel_minimo 	= ($var[nivel_minimo])?$var[nivel_minimo]:1;
		$id_horas_extra = (is_array($data[id_horas_extra]))?implode(',',$data[id_horas_extra]):$data[id_horas_extra];
		$id_personal 	= (is_array($data[id_personal]))?implode(',',$data[id_personal]):$data[id_personal];
		$empleado_num 	= (is_array($data[empleado_num]))?implode(',',$data[empleado_num]):$data[empleado_num];
		$id_usuario		= (is_array($data[id_usuario]))?implode(',',$data[id_usuario]):$data[id_usuario];
		$activo 		= (is_array($data[activo]))?implode(',',$data[activo]):$data[activo];
		$grupo 			= (is_array($data[grupo]))?implode(',',$data[grupo]):$data[grupo];
		$orden 			= (is_array($data[orden]))?implode(',',$data[orden]):$data[orden];
		$filtro.=filtro_grupo(array(
                   10 => ''
                  ,20 => "and a.id_empresa='$usuario[id_empresa]'"
                  ,30 => "and a.id_empresa='$usuario[id_empresa]' and (s1.id_supervisor='$usuario[id_personal]' or s5.id_supervisor='$usuario[id_personal]')"
                  ,34 => "and a.id_empresa='$usuario[id_empresa]' and (s1.id_supervisor='$usuario[id_personal]' or s4.id_supervisor='$usuario[id_personal]')"
                  ,35 => "and a.id_empresa='$usuario[id_empresa]' and (s1.id_supervisor='$usuario[id_personal]' or s3.id_supervisor='$usuario[id_personal]')"
                  ,40 => "and a.id_empresa='$usuario[id_empresa]' and (s1.id_supervisor='$usuario[id_personal]' or s2.id_supervisor='$usuario[id_personal]')"
                  ,50 => "and a.id_empresa='$usuario[id_empresa]' and s1.id_supervisor='$usuario[id_personal]'"
                  ,60 => "and a.id_empresa='$usuario[id_empresa]' and a.id_usuario='$usuario[id_usuario]'"
       		));
		$filtro.= ($id_horas_extra)?" and a.id_horas_extra IN ($id_horas_extra)":'';
		$filtro.= ($id_personal)?" and a.id_personal IN ($id_personal)":'';
		$filtro.= ($empleado_num)?" and b.empleado_num IN ($empleado_num)":'';		
		$filtro.= ($activo)?" and a.activo IN ($activo)":'';
		$filtro.= ($id_usuario)?" and a.id_usuario IN ($id_usuario)":'';
		$grupo 	= ($grupo)?"GROUP BY $grupo":"GROUP BY tbl1.id_horas_extra";
			$orden 	= ($orden)?"ORDER BY $orden":"ORDER BY tbl1.id_horas_extra ASC";

		$sql = "SELECT tbl2.* FROM 
					(SELECT tbl1.* FROM (
						SELECT 
						 b.id_nomina
						,CONCAT(b.nombre,' ',IFNULL(b.paterno,''),' ',IFNULL(b.materno,'')) as nombre_completo
						,b.empleado_num
						,b.estado
						,b.sucursal_nomina as sucursal
						,b.sucursal as localidad
						,b.puesto
						,a.fecha
						,TIME_FORMAT(a.horas,'%H:%i') as horas
						,TIME_FORMAT(e.horas,'%H:%i') as tiempoextra
						,CASE IFNULL(e.id_cat_autorizacion,'NULL')
							WHEN 'NULL' THEN CONCAT(s1.nombre,' ',IFNULL(s1.paterno,''),' ',IFNULL(s1.materno,''), ' - ',s1.puesto, ' - ',s1.empleado_num)
							WHEN 1 THEN CONCAT(s2.nombre,' ',IFNULL(s2.paterno,''),' ',IFNULL(s2.materno,''), ' - ',s2.puesto, ' - ',s2.empleado_num)
							WHEN 2 THEN CONCAT(s3.nombre,' ',IFNULL(s2.paterno,''),' ',IFNULL(s3.materno,''), ' - ',s3.puesto, ' - ',s3.empleado_num)
						END AS auth_nombre
						/*,IF(e.estatus=1, 'Aceptado', IF(e.estatus=0, 'Rechazado', 'Pendiente')) AS n1_estatus*/
						,'Pendiente' AS n1_estatus
						,e.argumento
						,a.id_horas_extra
					FROM $db[tbl_horas_extra] a
					LEFT JOIN $db[tbl_personal] b ON a.id_empresa=b.id_empresa AND a.id_personal=b.id_personal
					LEFT JOIN $db[tbl_empresas] c ON a.id_empresa=c.id_empresa
					LEFT JOIN $db[tbl_autorizaciones_nomina] d ON a.id_horas_extra=d.id_horas_extra
					LEFT JOIN (SELECT a.* FROM (SELECT * FROM $db[tbl_autorizaciones] ORDER BY timestamp DESC, id_cat_autorizacion DESC) a GROUP BY a.id_horas_extra) e ON a.id_horas_extra=e.id_horas_extra
					LEFT JOIN $db[tbl_usuarios] g on e.id_usuario=g.id_usuario
					LEFT JOIN $db[tbl_personal] h ON g.id_personal=h.id_personal
					LEFT JOIN $db[tbl_supervisores] n1 ON a.id_personal=n1.id_personal and n1.id_nivel=1
					LEFT JOIN $db[tbl_personal] s1 ON n1.id_supervisor=s1.id_personal
					LEFT JOIN $db[tbl_supervisores] n2 ON a.id_personal=n2.id_personal and n2.id_nivel=2
					LEFT JOIN $db[tbl_personal] s2 ON n2.id_supervisor=s2.id_personal
					LEFT JOIN $db[tbl_supervisores] n3 ON a.id_personal=n3.id_personal and n3.id_nivel=3
					LEFT JOIN $db[tbl_personal] s3 ON n3.id_supervisor=s3.id_personal
					WHERE 1 $filtro AND d.id_autorizacion_nomina IS NULL AND (e.id_cat_autorizacion<'$nivel_minimo' OR e.id_cat_autorizacion IS NULL) AND (e.estatus=1 OR e.estatus IS NULL)
					ORDER BY e.id_cat_autorizacion DESC, e.timestamp DESC
					) as tbl1
					$grupo 
					$orden
					) as tbl2
				;";
				// dump_var($sql);
		$resultado = SQLQuery($sql);
		$resultado = (count($resultado)) ? $resultado : false ;
	}
	return $resultado;
}
/*O3M*/
?>