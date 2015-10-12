<?php session_name('o3m_fw'); session_start(); if(isset($_SESSION['header_path'])){include_once($_SESSION['header_path']);}else{header('location: '.dirname(__FILE__));}
/**
* 				Funciones "DAO"
* Descripcion:	Ejecuta consultas SQL y devuelve el resultado.
* Creación:		2014-10-30
* Modificado:	2015-03-26
* @author 		Oscar Maldonado
*/
// function reporte01_select($data=array()){
// 	if($data[auth]){
// 		global $db, $usuario;		
// 		$id_empresa = (is_array($data[id_empresa]))?implode(',',$data[id_empresa]):$data[id_empresa];
// 		$anio 		= (is_array($data[anio]))?implode(',',$data[anio]):$data[anio];
// 		$id_periodo	= (is_array($data[periodo]))?implode(',',$data[periodo]):$data[periodo];
// 		$filtro.= ($id_empresa)?" and a.id_empresa IN ($id_empresa)":'';
// 		$filtro.= ($anio)?" and DATE_FORMAT(a.fecha,'%Y') IN ($anio)":'';
// 		$filtro.= ($periodo)?" and g.id_periodo IN ($id_periodo)":'';
// 		$filtro.=filtro_grupo(array(
// 	           10 => ''
// 	          ,20 => "and a.id_empresa='$usuario[id_empresa]'"
// 	          ,30 => "and a.id_empresa='$usuario[id_empresa]' "
// 	          ,34 => "and a.id_empresa='$usuario[id_empresa]' "
// 	          ,35 => "and a.id_empresa='$usuario[id_empresa]' "
// 	          ,40 => "and a.id_empresa='$usuario[id_empresa]' "
// 	          ,50 => "and a.id_empresa='$usuario[id_empresa]' "
// 	          ,60 => "and a.id_empresa='$usuario[id_empresa]' and a.id_usuario='$usuario[id_usuario]'"
//            ));
// 		$sql = "SELECT 
// 					 a.id_empresa
// 					,f.nombre as empresa
// 					,f.siglas
// 					,DATE_FORMAT(a.fecha,'%Y') as anio_fecha
// 					,CONCAT(TRUNCATE(SUM(IF(a.activo=1,TIME_TO_SEC(a.horas),0))/3600,0),':',RPAD(ROUND(60*RIGHT(TRUNCATE(SUM(IF(a.activo=1,TIME_TO_SEC(a.horas),0))/3600,2),3),0),2,'0')) capturadas_horas
// 					,FORMAT(SUM(IF(a.activo=1,TIME_TO_SEC(a.horas),0))/3600,2) capturadas_porcentaje
// 					,CONCAT(TRUNCATE(SUM(IF(a.activo=1 AND b.estatus IS NULL,TIME_TO_SEC(a.horas),0))/3600,0),':',RPAD(ROUND(60*RIGHT(TRUNCATE(SUM(IF(a.activo=1 AND b.estatus IS NULL,TIME_TO_SEC(a.horas),0))/3600,2),3),0),2,'0')) pendientes_horas
// 					,FORMAT(SUM(IF(a.activo=1 AND b.estatus IS NULL,TIME_TO_SEC(a.horas),0))/3600,2) pendientes_porcentaje
// 					,CONCAT(TRUNCATE(SUM(IF(a.activo=1 AND b.activo=1 AND b.estatus=1,TIME_TO_SEC(b.horas),0))/3600,0),':',RPAD(ROUND(60*RIGHT(TRUNCATE(SUM(IF(a.activo=1 AND b.activo=1 AND b.estatus=1,TIME_TO_SEC(b.horas),0))/3600,2),3),0),2,'0')) autorizadas_horas
// 					,FORMAT(SUM(IF(a.activo=1 AND b.activo=1 AND b.estatus=1,TIME_TO_SEC(b.horas),0))/3600,2) autorizadas_porcentaje
// 					,CONCAT(TRUNCATE(
// 						(SUM(IF(a.activo=1,TIME_TO_SEC(a.horas),0))
// 						-(
// 							 SUM(IF(a.activo=1 AND b.estatus IS NULL,TIME_TO_SEC(a.horas),0))
// 						 + SUM(IF(a.activo=1 AND b.activo=1 AND b.estatus=1,TIME_TO_SEC(b.horas),0))
// 						 ))/3600,0),':',RPAD(ROUND(60*RIGHT(TRUNCATE(
// 						(SUM(IF(a.activo=1,TIME_TO_SEC(a.horas),0))
// 							-(
// 								 SUM(IF(a.activo=1 AND b.estatus IS NULL,TIME_TO_SEC(a.horas),0))
// 							 + SUM(IF(a.activo=1 AND b.activo=1 AND b.estatus=1,TIME_TO_SEC(b.horas),0))
// 							 ))/3600,2),3),0),2,'0')
// 						) as rechazadas_horas
// 					,FORMAT(
// 					 SUM(IF(a.activo=1,TIME_TO_SEC(a.horas),0))/3600
// 					-(
// 					  SUM(IF(a.activo=1 AND b.estatus IS NULL,TIME_TO_SEC(a.horas),0))/3600
// 					+ SUM(IF(a.activo=1 AND b.activo=1 AND b.estatus=1,TIME_TO_SEC(b.horas),0))/3600
// 					)
// 					,2) as rechazadas_porcentaje
// 					,CONCAT(TRUNCATE(SUM(IF(a.activo=1 AND b.activo=1 AND c.activo=1 AND c.id_concepto IS NOT NULL,TIME_TO_SEC(c.total_horas),0))/3600,0),':',RPAD(ROUND(60*RIGHT(TRUNCATE(SUM(IF(a.activo=1 AND b.activo=1 AND c.activo=1 AND c.id_concepto IS NOT NULL,TIME_TO_SEC(c.total_horas),0))/3600,2),3),0),2,'0')) pagadas_horas
// 					,FORMAT(SUM(IF(a.activo=1 AND b.activo=1 AND c.activo=1 AND c.id_concepto IS NOT NULL,TIME_TO_SEC(c.total_horas),0))/3600,2) pagadas_porcentaje
// 					,CONCAT(TRUNCATE(SUM(IF(a.activo=1 AND b.activo=1 AND c.activo=1 AND c.id_concepto=2,TIME_TO_SEC(c.total_horas),0))/3600,0),':',RPAD(ROUND(60*RIGHT(TRUNCATE(SUM(IF(a.activo=1 AND b.activo=1 AND c.activo=1 AND c.id_concepto=2,TIME_TO_SEC(c.total_horas),0))/3600,2),3),0),2,'0')) dobles_horas
// 					,FORMAT(SUM(IF(a.activo=1 AND b.activo=1 AND c.activo=1 AND c.id_concepto=2,TIME_TO_SEC(c.total_horas),0))/3600,2) dobles_porcentaje
// 					,CONCAT(TRUNCATE(SUM(IF(a.activo=1 AND b.activo=1 AND c.activo=1 AND c.id_concepto=3,TIME_TO_SEC(c.total_horas),0))/3600,0),':',RPAD(ROUND(60*RIGHT(TRUNCATE(SUM(IF(a.activo=1 AND b.activo=1 AND c.activo=1 AND c.id_concepto=3,TIME_TO_SEC(c.total_horas),0))/3600,2),3),0),2,'0')) triples_horas
// 					,FORMAT(SUM(IF(a.activo=1 AND b.activo=1 AND c.activo=1 AND c.id_concepto=3,TIME_TO_SEC(c.total_horas),0))/3600,2) triples_porcentaje
// 				FROM $db[tbl_horas_extra] a
// 				LEFT JOIN (SELECT * FROM 
// 					(SELECT * FROM $db[tbl_autorizaciones] ORDER BY id_horas_extra ASC, id_cat_autorizacion DESC) AS tbl_aut
// 					GROUP BY tbl_aut.id_horas_extra) b ON a.id_horas_extra=b.id_horas_extra
// 				LEFT JOIN (SELECT id_horas_extra, id_cat_autorizaciones, anio, periodo, periodo_especial, semana, id_concepto, activo
// 					,SEC_TO_TIME(SUM(IF(id_concepto=2,TIME_TO_SEC(horas),0))) as dobles_horas
// 					,SUM(IF(id_concepto=2,horas_porcentaje,0)) as dobles_porcentaje
// 					,SEC_TO_TIME(SUM(IF(id_concepto=3,TIME_TO_SEC(horas),0))) as triples_horas
// 					,SUM(IF(id_concepto=3,horas_porcentaje,0)) as triples_porcentaje
// 					,SEC_TO_TIME(SUM(TIME_TO_SEC(horas))) as total_horas
// 					,SUM(horas_porcentaje) as total_porcentaje
// 					FROM $db[tbl_autorizaciones_nomina]
// 					GROUP BY id_horas_extra ASC) c ON a.id_horas_extra=c.id_horas_extra
// 				LEFT JOIN $db[tbl_personal] d ON a.id_personal=d.id_personal
// 				LEFT JOIN $db[tbl_usuarios] e ON a.id_usuario=e.id_usuario
// 				LEFT JOIN $db[tbl_empresas] f ON a.id_empresa=f.id_empresa
// 				LEFT JOIN $db[tbl_calendarios] g ON a.fecha BETWEEN g.fecha_inicio AND g.fecha_fin
// 				WHERE 1 $filtro
// 				GROUP BY a.id_empresa, anio_fecha
// 				ORDER BY a.id_empresa ASC, anio_fecha DESC;";
// 		// dump_var($sql);
// 		$resultado = SQLQuery($sql);
// 		$resultado = (count($resultado)) ? $resultado : false ;
// 	}else{
// 		$resultado = false;
// 	}
// 	return $resultado;
// }

function grafico01_select($data=array()){
	if($data[auth]){
		global $db, $usuario;
		$id_empresa = (is_array($data[id_empresa]))?implode(',',$data[id_empresa]):$data[id_empresa];
		$anio 	= (is_array($data[anio]))?implode(',',$data[anio]):$data[anio];
		$id_periodo	= (is_array($data[periodo]))?implode(',',$data[periodo]):$data[periodo];
		$grupo 	= (is_array($data[grupo]))?implode(',',$data[grupo]):$data[grupo];
		#$orden 	= (is_array($data[orden]))?implode(',',$data[orden]):$data[orden];
		#$desc 	= $data[desc];
		$filtro.= ($id_empresa)?" and a.id_empresa IN ($id_empresa)":'';
		$filtro.= ($anio)?" and periodo_anio IN ($anio)":'';
		$filtro.= ($periodo)?" and g.id_periodo IN ($id_periodo)":'';
			$filtro.=filtro_grupo(array(
	           10 => ''
	          ,20 => "and a.id_empresa='$usuario[id_empresa]'"
	          ,30 => "and a.id_empresa='$usuario[id_empresa]' "
	          ,34 => "and a.id_empresa='$usuario[id_empresa]' "
	          ,35 => "and a.id_empresa='$usuario[id_empresa]' "
	          ,40 => "and a.id_empresa='$usuario[id_empresa]' "
	          ,50 => "and a.id_empresa='$usuario[id_empresa]' "
	          ,60 => "and a.id_empresa='$usuario[id_empresa]' and a.id_usuario='$usuario[id_usuario]'"
           ));
		#$desc 	= ($desc)?" DESC":' ASC';
		$grupo 	= ($grupo)?"GROUP BY $grupo ":'GROUP BY a.id_empresa, anio_fecha ';
		#$orden 	= ($orden)?"ORDER BY $orden".$desc:'ORDER BY a.id_empresa, anio_fecha'.$desc;
		// $sql = "SELECT 
		// 			 a.id_empresa
		// 			,f.nombre as empresa
		// 			,f.siglas
		// 			,DATE_FORMAT(a.fecha,'%Y') as anio_fecha
		// 			,CONCAT(TRUNCATE(SUM(IF(a.activo=1,TIME_TO_SEC(a.horas),0))/3600,0),':',RPAD(ROUND(60*RIGHT(TRUNCATE(SUM(IF(a.activo=1,TIME_TO_SEC(a.horas),0))/3600,2),3),0),2,'0')) capturadas_horas
		// 			,FORMAT(SUM(IF(a.activo=1,TIME_TO_SEC(a.horas),0))/3600,2) capturadas_porcentaje
		// 			,CONCAT(TRUNCATE(SUM(IF(a.activo=1 AND b.estatus IS NULL,TIME_TO_SEC(a.horas),0))/3600,0),':',RPAD(ROUND(60*RIGHT(TRUNCATE(SUM(IF(a.activo=1 AND b.estatus IS NULL,TIME_TO_SEC(a.horas),0))/3600,2),3),0),2,'0')) pendientes_horas
		// 			,FORMAT(SUM(IF(a.activo=1 AND b.estatus IS NULL,TIME_TO_SEC(a.horas),0))/3600,2) pendientes_porcentaje
		// 			,CONCAT(TRUNCATE(SUM(IF(a.activo=1 AND b.activo=1 AND b.estatus=1,TIME_TO_SEC(b.horas),0))/3600,0),':',RPAD(ROUND(60*RIGHT(TRUNCATE(SUM(IF(a.activo=1 AND b.activo=1 AND b.estatus=1,TIME_TO_SEC(b.horas),0))/3600,2),3),0),2,'0')) autorizadas_horas
		// 			,FORMAT(SUM(IF(a.activo=1 AND b.activo=1 AND b.estatus=1,TIME_TO_SEC(b.horas),0))/3600,2) autorizadas_porcentaje
		// 			,CONCAT(TRUNCATE(
		// 				(SUM(IF(a.activo=1,TIME_TO_SEC(a.horas),0))
		// 				-(
		// 					 SUM(IF(a.activo=1 AND b.estatus IS NULL,TIME_TO_SEC(a.horas),0))
		// 				 + SUM(IF(a.activo=1 AND b.activo=1 AND b.estatus=1,TIME_TO_SEC(b.horas),0))
		// 				 ))/3600,0),':',RPAD(ROUND(60*RIGHT(TRUNCATE(
		// 				(SUM(IF(a.activo=1,TIME_TO_SEC(a.horas),0))
		// 					-(
		// 						 SUM(IF(a.activo=1 AND b.estatus IS NULL,TIME_TO_SEC(a.horas),0))
		// 					 + SUM(IF(a.activo=1 AND b.activo=1 AND b.estatus=1,TIME_TO_SEC(b.horas),0))
		// 					 ))/3600,2),3),0),2,'0')
		// 				) as rechazadas_horas
		// 			,FORMAT(
		// 			 SUM(IF(a.activo=1,TIME_TO_SEC(a.horas),0))/3600
		// 			-(
		// 			  SUM(IF(a.activo=1 AND b.estatus IS NULL,TIME_TO_SEC(a.horas),0))/3600
		// 			+ SUM(IF(a.activo=1 AND b.activo=1 AND b.estatus=1,TIME_TO_SEC(b.horas),0))/3600
		// 			)
		// 			,2) as rechazadas_porcentaje
		// 			,CONCAT(TRUNCATE(SUM(IF(a.activo=1 AND b.activo=1 AND c.activo=1 AND c.id_concepto IS NOT NULL,TIME_TO_SEC(c.total_horas),0))/3600,0),':',RPAD(ROUND(60*RIGHT(TRUNCATE(SUM(IF(a.activo=1 AND b.activo=1 AND c.activo=1 AND c.id_concepto IS NOT NULL,TIME_TO_SEC(c.total_horas),0))/3600,2),3),0),2,'0')) pagadas_horas
		// 			,FORMAT(SUM(IF(a.activo=1 AND b.activo=1 AND c.activo=1 AND c.id_concepto IS NOT NULL,TIME_TO_SEC(c.total_horas),0))/3600,2) pagadas_porcentaje
		// 			,CONCAT(TRUNCATE(SUM(IF(a.activo=1 AND b.activo=1 AND c.activo=1 AND c.id_concepto=2,TIME_TO_SEC(c.total_horas),0))/3600,0),':',RPAD(ROUND(60*RIGHT(TRUNCATE(SUM(IF(a.activo=1 AND b.activo=1 AND c.activo=1 AND c.id_concepto=2,TIME_TO_SEC(c.total_horas),0))/3600,2),3),0),2,'0')) dobles_horas
		// 			,FORMAT(SUM(IF(a.activo=1 AND b.activo=1 AND c.activo=1 AND c.id_concepto=2,TIME_TO_SEC(c.total_horas),0))/3600,2) dobles_porcentaje
		// 			,CONCAT(TRUNCATE(SUM(IF(a.activo=1 AND b.activo=1 AND c.activo=1 AND c.id_concepto=3,TIME_TO_SEC(c.total_horas),0))/3600,0),':',RPAD(ROUND(60*RIGHT(TRUNCATE(SUM(IF(a.activo=1 AND b.activo=1 AND c.activo=1 AND c.id_concepto=3,TIME_TO_SEC(c.total_horas),0))/3600,2),3),0),2,'0')) triples_horas
		// 			,FORMAT(SUM(IF(a.activo=1 AND b.activo=1 AND c.activo=1 AND c.id_concepto=3,TIME_TO_SEC(c.total_horas),0))/3600,2) triples_porcentaje
		// 		FROM $db[tbl_horas_extra] a
		// 		LEFT JOIN (SELECT * FROM 
		// 			(SELECT * FROM $db[tbl_autorizaciones] ORDER BY id_horas_extra ASC, id_cat_autorizacion DESC) AS tbl_aut
		// 			GROUP BY tbl_aut.id_horas_extra) b ON a.id_horas_extra=b.id_horas_extra
		// 		LEFT JOIN (SELECT id_horas_extra, id_cat_autorizaciones, anio, periodo, periodo_especial, semana, id_concepto, activo
		// 			,SEC_TO_TIME(SUM(IF(id_concepto=2,TIME_TO_SEC(horas),0))) as dobles_horas
		// 			,SUM(IF(id_concepto=2,horas_porcentaje,0)) as dobles_porcentaje
		// 			,SEC_TO_TIME(SUM(IF(id_concepto=3,TIME_TO_SEC(horas),0))) as triples_horas
		// 			,SUM(IF(id_concepto=3,horas_porcentaje,0)) as triples_porcentaje
		// 			,SEC_TO_TIME(SUM(TIME_TO_SEC(horas))) as total_horas
		// 			,SUM(horas_porcentaje) as total_porcentaje
		// 			FROM $db[tbl_autorizaciones_nomina]
		// 			GROUP BY id_horas_extra ASC) c ON a.id_horas_extra=c.id_horas_extra
		// 		LEFT JOIN $db[tbl_personal] d ON a.id_personal=d.id_personal
		// 		LEFT JOIN $db[tbl_usuarios] e ON a.id_usuario=e.id_usuario
		// 		LEFT JOIN $db[tbl_empresas] f ON a.id_empresa=f.id_empresa
		// 		LEFT JOIN $db[tbl_calendarios] g ON a.fecha BETWEEN g.fecha_inicio AND g.fecha_fin
		// 		WHERE 1 $filtro $grupo
		// 		;";
		$sql = "SELECT 
					 a.nomina_anio
					,a.nomina_periodo	
					,a.periodo_anio	
					,a.periodo_inicio	
					,a.periodo_fin
					,a.id_empresa	
					,a.empresa	
					,a.siglas
					,a.anio_fecha
					,CONCAT(TRUNCATE(SUM(TIME_TO_SEC(a.capturadas_horas))/3600,0),':',RPAD(ROUND(60*RIGHT(TRUNCATE(SUM(TIME_TO_SEC(a.capturadas_horas))/3600,2),3),0),2,'0')) as capturadas_horas
					,	SUM(a.capturadas_porcentaje) as capturadas_porcentaje
					,CONCAT(TRUNCATE(SUM(TIME_TO_SEC(a.pendientes_horas))/3600,0),':',RPAD(ROUND(60*RIGHT(TRUNCATE(SUM(TIME_TO_SEC(a.pendientes_horas))/3600,2),3),0),2,'0')) as pendientes_horas
					,	SUM(a.pendientes_porcentaje) as pendientes_porcentaje
					,CONCAT(TRUNCATE(SUM(TIME_TO_SEC(a.autorizadas_horas))/3600,0),':',RPAD(ROUND(60*RIGHT(TRUNCATE(SUM(TIME_TO_SEC(a.autorizadas_horas))/3600,2),3),0),2,'0')) as autorizadas_horas
					,	SUM(a.autorizadas_porcentaje) as autorizadas_porcentaje
					,CONCAT(TRUNCATE(SUM(TIME_TO_SEC(a.rechazadas_horas))/3600,0),':',RPAD(ROUND(60*RIGHT(TRUNCATE(SUM(TIME_TO_SEC(a.rechazadas_horas))/3600,2),3),0),2,'0')) as rechazadas_horas
					,	SUM(a.rechazadas_porcentaje) as rechazadas_porcentaje
					,CONCAT(TRUNCATE(SUM(TIME_TO_SEC(a.pagadas_horas))/3600,0),':',RPAD(ROUND(60*RIGHT(TRUNCATE(SUM(TIME_TO_SEC(a.pagadas_horas))/3600,2),3),0),2,'0')) as pagadas_horas
					,	SUM(a.pagadas_porcentaje) as pagadas_porcentaje
					,CONCAT(TRUNCATE(SUM(TIME_TO_SEC(a.dobles_horas))/3600,0),':',RPAD(ROUND(60*RIGHT(TRUNCATE(SUM(TIME_TO_SEC(a.dobles_horas))/3600,2),3),0),2,'0')) as dobles_horas
					,	SUM(a.dobles_porcentaje) as dobles_porcentaje
					,CONCAT(TRUNCATE(SUM(TIME_TO_SEC(a.triples_horas))/3600,0),':',RPAD(ROUND(60*RIGHT(TRUNCATE(SUM(TIME_TO_SEC(a.triples_horas))/3600,2),3),0),2,'0')) as triples_horas
					,	SUM(a.triples_porcentaje) as triples_porcentaje
					FROM 
						(SELECT 
							 a.id_horas_extra
							,d.id_nomina
							,d.empleado_num as cid
							,CONCAT(d.nombre,' ',IFNULL(d.paterno,''),' ',IFNULL(d.materno,'')) as nombre_completo
							,g.id_calendario as id_periodo
							,DATE_FORMAT(g.fecha_inicio,'%Y') as periodo_anio
							,g.fecha_inicio as periodo_inicio
							,g.fecha_fin as periodo_fin
							,c.nomina_anio 
							,c.nomina_periodo 
							,a.fecha
							,c.semana
							,a.id_empresa
							,f.nombre as empresa
							,f.siglas
							,DATE_FORMAT(a.fecha,'%Y') as anio_fecha
							,IF(a.activo=1,a.horas,0) as capturadas_horas
							,FORMAT(IF(a.activo=1,TIME_TO_SEC(a.horas),0)/3600,2) as capturadas_porcentaje
							,IF(a.activo=1 AND b.estatus IS NULL,TIME_TO_SEC(a.horas),0) as pendientes_horas
							,FORMAT(IF(a.activo=1 AND b.estatus IS NULL,a.horas,0)/3600,2) as pendientes_porcentaje
							,IF(a.activo=1 AND b.activo=1 AND b.estatus=1,b.horas,0) as autorizadas_horas
							,FORMAT(IF(a.activo=1 AND b.activo=1 AND b.estatus=1,TIME_TO_SEC(b.horas),0)/3600,2) as autorizadas_porcentaje
							,SEC_TO_TIME(IF(a.activo=1,TIME_TO_SEC(a.horas),0) - IF(a.activo=1 AND b.activo=1 AND b.estatus=1,TIME_TO_SEC(b.horas),0)) as rechazadas_horas
							,FORMAT((IF(a.activo=1,TIME_TO_SEC(a.horas),0) - IF(a.activo=1 AND b.activo=1 AND b.estatus=1,TIME_TO_SEC(b.horas),0))/3600,2) as rechazadas_porcentaje
							,SEC_TO_TIME(TIME_TO_SEC(c.dobles_horas) + TIME_TO_SEC(c.triples_horas)) as pagadas_horas
							,FORMAT((TIME_TO_SEC(c.dobles_horas) + TIME_TO_SEC(c.triples_horas))/3600,2) as pagadas_porcentaje
							,c.dobles_horas
							,c.dobles_porcentaje
							,c.triples_horas
							,c.triples_porcentaje
						FROM $db[tbl_horas_extra] a
						LEFT JOIN (SELECT * FROM 
							(SELECT * FROM $db[tbl_autorizaciones] ORDER BY id_horas_extra ASC, id_cat_autorizacion DESC) AS tbl_aut
							GROUP BY tbl_aut.id_horas_extra) b ON a.id_horas_extra=b.id_horas_extra
						LEFT JOIN (SELECT id_horas_extra, id_cat_autorizaciones, IF(anio=0 or anio IS NULL,final_anio,anio) as nomina_anio, IF(periodo=0 or periodo IS NULL, final_periodo, periodo) as nomina_periodo, periodo_especial, semana, id_concepto, activo, xls	
							,SEC_TO_TIME(SUM(IF(id_concepto=2,TIME_TO_SEC(horas),0))) as dobles_horas
							,SUM(IF(id_concepto=2,horas_porcentaje,0)) as dobles_porcentaje
							,SEC_TO_TIME(SUM(IF(id_concepto=3,TIME_TO_SEC(horas),0))) as triples_horas
							,SUM(IF(id_concepto=3,horas_porcentaje,0)) as triples_porcentaje
							,SEC_TO_TIME(SUM(TIME_TO_SEC(horas))) as total_horas
							,SUM(horas_porcentaje) as total_porcentaje
							FROM $db[tbl_autorizaciones_nomina]
							GROUP BY id_horas_extra ASC) c ON a.id_horas_extra=c.id_horas_extra
						LEFT JOIN $db[tbl_personal] d ON a.id_personal=d.id_personal
						LEFT JOIN $db[tbl_usuarios] e ON a.id_usuario=e.id_usuario
						LEFT JOIN $db[tbl_empresas] f ON a.id_empresa=f.id_empresa
						LEFT JOIN $db[tbl_calendarios] g ON a.fecha BETWEEN g.fecha_inicio AND g.fecha_fin
						WHERE 1 AND a.activo=1 AND b.activo=1 AND c.activo=1 
						GROUP BY a.id_horas_extra
						ORDER BY a.id_empresa, c.nomina_anio, c.nomina_periodo, d.nombre, d.paterno, d.materno , a.fecha ASC) as a
				WHERE 1 $filtro
				GROUP BY a.id_empresa, a.periodo_anio/*, nomina_anio, nomina_periodo*/ ASC
				;";
				// dump_var($sql);
		$resultado = SQLQuery($sql);
		$resultado = (count($resultado)) ? $resultado : false ;
	}else{
		$resultado = false;
	}
	return $resultado;
}

function empresas($data=array()){
	if($data[auth]){
		global $db, $usuario;
		$id_empresa = (is_array($data[id_empresa]))?implode(',',$data[id_empresa]):$data[id_empresa];
		$activo = (is_array($data[activo]))?implode(',',$data[activo]):$data[activo];
		$filtro .= ($id_empresa)?" AND a.id_empresa IN ($id_empresa)":'';
		$filtro .= ($activo)?" AND b.activo IN ($activo)":'';
		$filtro.=filtro_grupo(array(
	           10 => ''
	          ,20 => "and a.id_empresa='$usuario[id_empresa]'"
	          ,30 => "and a.id_empresa='$usuario[id_empresa]' "
	          ,34 => "and a.id_empresa='$usuario[id_empresa]' "
	          ,35 => "and a.id_empresa='$usuario[id_empresa]' "
	          ,40 => "and a.id_empresa='$usuario[id_empresa]' "
	          ,50 => "and a.id_empresa='$usuario[id_empresa]' "
	          ,60 => "and a.id_empresa='$usuario[id_empresa]' and a.id_usuario='$usuario[id_usuario]'"
           ));
		$sql = "SELECT 
					 a.id_empresa
					,b.nombre AS empresa
					,b.siglas
				FROM $db[tbl_horas_extra] a
				LEFT JOIN $db[tbl_empresas] b ON a.id_empresa=b.id_empresa
				WHERE 1 $filtro
				GROUP BY b.nombre
				ORDER BY b.id_empresa
				;";
				// dump_var($sql);
		$resultado = SQLQuery($sql);
		$resultado = (count($resultado)) ? $resultado : false ;

	}else{
		$resultado = false;
	}
	return $resultado;
}

function anios($data=array()){
	if($data[auth]){
		global $db, $usuario; 
		$anio = (is_array($data[anio]))?implode(',',$data[anio]):$data[anio];
		$id_empresa = (is_array($data[id_empresa]))?implode(',',$data[id_empresa]):$data[id_empresa];
		$filtro.=filtro_grupo(array(
	           10 => ''
	          ,20 => "and a.id_empresa='$usuario[id_empresa]'"
	          ,30 => "and a.id_empresa='$usuario[id_empresa]' "
	          ,34 => "and a.id_empresa='$usuario[id_empresa]' "
	          ,35 => "and a.id_empresa='$usuario[id_empresa]' "
	          ,40 => "and a.id_empresa='$usuario[id_empresa]' "
	          ,50 => "and a.id_empresa='$usuario[id_empresa]' "
	          ,60 => "and a.id_empresa='$usuario[id_empresa]' and a.id_usuario='$usuario[id_usuario]'"
           ));
		$filtro .= ($anio)?" AND DATE_FORMAT(a.fecha,'%Y') IN ($anio)":'';
		$filtro .= ($id_empresa)?" AND a.id_empresa IN ($id_empresa)":'';
		$sql = "SELECT DATE_FORMAT(fecha,'%Y') AS anio 
				FROM $db[tbl_horas_extra] a
				WHERE 1 $filtro 
				GROUP BY anio DESC;";
		$resultado = SQLQuery($sql);
		$resultado = (count($resultado)) ? $resultado : false ;
	}else{
		$resultado = false;
	}
	return $resultado;
}
/*O3M*/

function historial_usuario(){
	global $db,$usuario;
	$sql="SELECT 
			a.id_horas_extra,
			a.id_personal,
			a.fecha,
			a.horas as hora_extra,
			a.id_usuario,
			a.timestamp,
			a.id_empresa,
			'a.estatus_fecha', 
			'a.estatus',
			b.id_horas_extra as id_hora_autoizacion,
			'b.id_autorizacion',
			'b.aut_estatus',
			b.timestamp,
			TIME_FORMAT(SEC_TO_TIME(SUM(TIME_TO_SEC(IF(b.id_concepto=0,b.horas,NULL)))),'%H:%i') AS horas_rechazadas,
			TIME_FORMAT(SEC_TO_TIME(SUM(TIME_TO_SEC(IF(b.id_concepto=1,b.horas,NULL)))),'%H:%i') AS horas_simples,
			TIME_FORMAT(SEC_TO_TIME(SUM(TIME_TO_SEC(IF(b.id_concepto=2,b.horas,NULL)))),'%H:%i') AS horas_dobles,
			TIME_FORMAT(SEC_TO_TIME(SUM(TIME_TO_SEC(IF(b.id_concepto=3,b.horas,NULL)))),'%H:%i') AS horas_triples,
			c.nombre,
			c.paterno,
			c.id_personal
		FROM 
			$db[tbl_horas_extra] a
			LEFT JOIN 
				$db[tbl_autorizaciones_nomina] b
				ON 
					a.id_horas_extra=b.id_horas_extra
			LEFT JOIN 
				$db[tbl_personal] c
				ON
					a.id_personal=c.id_personal
		WHERE 
			a.id_personal=$usuario[id_usuario]
		GROUP BY 
			a.id_horas_extra";
	// dump_var($sql);
	$resultado = SQLQuery($sql);
	$resultado = (count($resultado)) ? $resultado : false ;
	return $resultado;
}

// function select_reporte_por_periodo($data=array()){
// 	if($data[auth]){
// 		global $db, $usuario;
// 		$id_empresa = (is_array($data[id_empresa]))?implode(',',$data[id_empresa]):$data[id_empresa];
// 		$anio 	= (is_array($data[anio]))?implode(',',$data[anio]):$data[anio];
// 		$filtro.= ($id_empresa)?" and a.id_empresa IN ($id_empresa)":'';
// 		$filtro.= ($anio)?" and DATE_FORMAT(a.fecha,'%Y') IN ($anio)":'';
// 		$filtro.=filtro_grupo(array(
// 	           10 => ''
// 	          ,20 => "and a.id_empresa='$usuario[id_empresa]'"
// 	          ,30 => "and a.id_empresa='$usuario[id_empresa]' "
// 	          ,34 => "and a.id_empresa='$usuario[id_empresa]' "
// 	          ,35 => "and a.id_empresa='$usuario[id_empresa]' "
// 	          ,40 => "and a.id_empresa='$usuario[id_empresa]' "
// 	          ,50 => "and a.id_empresa='$usuario[id_empresa]' "
// 	          ,60 => "and a.id_empresa='$usuario[id_empresa]' and a.id_usuario='$usuario[id_usuario]'"
//            ));
// 		$sql = "SELECT 
// 					 a.id_empresa
// 					,f.nombre as empresa
// 					,f.siglas
// 					,DATE_FORMAT(a.fecha,'%Y') as anio_fecha
// 					,a.fecha as fecha_captura
// 					,g.id_calendario as id_periodo
// 					,DATE_FORMAT(g.fecha_inicio,'%Y') as periodo_anio
// 					,g.fecha_inicio as periodo_inicio
// 					,g.fecha_fin as periodo_fin
// 					,CONCAT(TRUNCATE(SUM(IF(a.activo=1,TIME_TO_SEC(a.horas),0))/3600,0),':',RPAD(ROUND(60*RIGHT(TRUNCATE(SUM(IF(a.activo=1,TIME_TO_SEC(a.horas),0))/3600,2),3),0),2,'0')) capturadas_horas
// 					,FORMAT(SUM(IF(a.activo=1,TIME_TO_SEC(a.horas),0))/3600,2) capturadas_porcentaje
// 					,CONCAT(TRUNCATE(SUM(IF(a.activo=1 AND b.estatus IS NULL,TIME_TO_SEC(a.horas),0))/3600,0),':',RPAD(ROUND(60*RIGHT(TRUNCATE(SUM(IF(a.activo=1 AND b.estatus IS NULL,TIME_TO_SEC(a.horas),0))/3600,2),3),0),2,'0')) pendientes_horas
// 					,FORMAT(SUM(IF(a.activo=1 AND b.estatus IS NULL,TIME_TO_SEC(a.horas),0))/3600,2) pendientes_porcentaje
// 					,CONCAT(TRUNCATE(SUM(IF(a.activo=1 AND b.activo=1 AND b.estatus=1,TIME_TO_SEC(b.horas),0))/3600,0),':',RPAD(ROUND(60*RIGHT(TRUNCATE(SUM(IF(a.activo=1 AND b.activo=1 AND b.estatus=1,TIME_TO_SEC(b.horas),0))/3600,2),3),0),2,'0')) autorizadas_horas
// 					,FORMAT(SUM(IF(a.activo=1 AND b.activo=1 AND b.estatus=1,TIME_TO_SEC(b.horas),0))/3600,2) autorizadas_porcentaje
// 					,CONCAT(TRUNCATE(
// 						(SUM(IF(a.activo=1,TIME_TO_SEC(a.horas),0))
// 						-(
// 							 SUM(IF(a.activo=1 AND b.estatus IS NULL,TIME_TO_SEC(a.horas),0))
// 						 + SUM(IF(a.activo=1 AND b.activo=1 AND b.estatus=1,TIME_TO_SEC(b.horas),0))
// 						 ))/3600,0),':',RPAD(ROUND(60*RIGHT(TRUNCATE(
// 						(SUM(IF(a.activo=1,TIME_TO_SEC(a.horas),0))
// 							-(
// 								 SUM(IF(a.activo=1 AND b.estatus IS NULL,TIME_TO_SEC(a.horas),0))
// 							 + SUM(IF(a.activo=1 AND b.activo=1 AND b.estatus=1,TIME_TO_SEC(b.horas),0))
// 							 ))/3600,2),3),0),2,'0')
// 						) as rechazadas_horas
// 					,FORMAT(
// 					 SUM(IF(a.activo=1,TIME_TO_SEC(a.horas),0))/3600
// 					-(
// 					  SUM(IF(a.activo=1 AND b.estatus IS NULL,TIME_TO_SEC(a.horas),0))/3600
// 					+ SUM(IF(a.activo=1 AND b.activo=1 AND b.estatus=1,TIME_TO_SEC(b.horas),0))/3600
// 					)
// 					,2) as rechazadas_porcentaje
// 					,CONCAT(TRUNCATE(SUM(IF(a.activo=1 AND b.activo=1 AND c.activo=1 AND c.id_concepto IS NOT NULL,TIME_TO_SEC(c.total_horas),0))/3600,0),':',RPAD(ROUND(60*RIGHT(TRUNCATE(SUM(IF(a.activo=1 AND b.activo=1 AND c.activo=1 AND c.id_concepto IS NOT NULL,TIME_TO_SEC(c.total_horas),0))/3600,2),3),0),2,'0')) pagadas_horas
// 					,FORMAT(SUM(IF(a.activo=1 AND b.activo=1 AND c.activo=1 AND c.id_concepto IS NOT NULL,TIME_TO_SEC(c.total_horas),0))/3600,2) pagadas_porcentaje
// 					,CONCAT(TRUNCATE(SUM(IF(a.activo=1 AND b.activo=1 AND c.activo=1 AND c.id_concepto=2,TIME_TO_SEC(c.total_horas),0))/3600,0),':',RPAD(ROUND(60*RIGHT(TRUNCATE(SUM(IF(a.activo=1 AND b.activo=1 AND c.activo=1 AND c.id_concepto=2,TIME_TO_SEC(c.total_horas),0))/3600,2),3),0),2,'0')) dobles_horas
// 					,FORMAT(SUM(IF(a.activo=1 AND b.activo=1 AND c.activo=1 AND c.id_concepto=2,TIME_TO_SEC(c.total_horas),0))/3600,2) dobles_porcentaje
// 					,CONCAT(TRUNCATE(SUM(IF(a.activo=1 AND b.activo=1 AND c.activo=1 AND c.id_concepto=3,TIME_TO_SEC(c.total_horas),0))/3600,0),':',RPAD(ROUND(60*RIGHT(TRUNCATE(SUM(IF(a.activo=1 AND b.activo=1 AND c.activo=1 AND c.id_concepto=3,TIME_TO_SEC(c.total_horas),0))/3600,2),3),0),2,'0')) triples_horas
// 					,FORMAT(SUM(IF(a.activo=1 AND b.activo=1 AND c.activo=1 AND c.id_concepto=3,TIME_TO_SEC(c.total_horas),0))/3600,2) triples_porcentaje
// 				FROM $db[tbl_horas_extra] a
// 				LEFT JOIN (SELECT * FROM 
// 					(SELECT * FROM $db[tbl_autorizaciones] ORDER BY id_horas_extra ASC, id_cat_autorizacion DESC) AS tbl_aut
// 					GROUP BY tbl_aut.id_horas_extra) b ON a.id_horas_extra=b.id_horas_extra
// 				LEFT JOIN (SELECT id_horas_extra, id_cat_autorizaciones, anio, periodo, periodo_especial, semana, id_concepto, activo
// 					,SEC_TO_TIME(SUM(IF(id_concepto=2,TIME_TO_SEC(horas),0))) as dobles_horas
// 					,SUM(IF(id_concepto=2,horas_porcentaje,0)) as dobles_porcentaje
// 					,SEC_TO_TIME(SUM(IF(id_concepto=3,TIME_TO_SEC(horas),0))) as triples_horas
// 					,SUM(IF(id_concepto=3,horas_porcentaje,0)) as triples_porcentaje
// 					,SEC_TO_TIME(SUM(TIME_TO_SEC(horas))) as total_horas
// 					,SUM(horas_porcentaje) as total_porcentaje
// 					FROM $db[tbl_autorizaciones_nomina]
// 					GROUP BY id_horas_extra ASC) c ON a.id_horas_extra=c.id_horas_extra
// 				LEFT JOIN $db[tbl_personal] d ON a.id_personal=d.id_personal
// 				LEFT JOIN $db[tbl_usuarios] e ON a.id_usuario=e.id_usuario
// 				LEFT JOIN $db[tbl_empresas] f ON a.id_empresa=f.id_empresa
// 				LEFT JOIN $db[tbl_calendarios] g ON a.fecha BETWEEN g.fecha_inicio AND g.fecha_fin
// 				WHERE 1 $filtro
// 				GROUP BY a.id_empresa, g.id_calendario
// 				ORDER BY a.id_empresa, g.id_calendario ASC
// 				;";
// 		// dump_var($sql);
// 		$resultado = SQLQuery($sql);
// 		$resultado = (count($resultado)) ? $resultado : false ;
// 	}else{
// 		$resultado = false;
// 	}
// 	return $resultado;
// }

function select_reporte_general_por_anio($data=array()){
	if($data[auth]){
		global $db, $usuario;
		$id_empresa = (is_array($data[id_empresa]))?implode(',',$data[id_empresa]):$data[id_empresa];
		$anio 	= (is_array($data[anio]))?implode(',',$data[anio]):$data[anio];
		$filtro.= ($id_empresa)?" and a.id_empresa IN ($id_empresa)":'';
		$filtro.= ($anio)?" and a.anio_fecha IN ($anio)":'';
		$filtro.=filtro_grupo(array(
	           10 => ''
	          ,20 => "and a.id_empresa='$usuario[id_empresa]'"
	          ,30 => "and a.id_empresa='$usuario[id_empresa]' "
	          ,34 => "and a.id_empresa='$usuario[id_empresa]' "
	          ,35 => "and a.id_empresa='$usuario[id_empresa]' "
	          ,40 => "and a.id_empresa='$usuario[id_empresa]' "
	          ,50 => "and a.id_empresa='$usuario[id_empresa]' "
	          ,60 => "and a.id_empresa='$usuario[id_empresa]' and a.id_usuario='$usuario[id_usuario]'"
           ));
		$sql = "SELECT 
					 a.nomina_anio
					,a.nomina_periodo	
					,a.periodo_anio	
					,a.periodo_inicio	
					,a.periodo_fin
					,a.id_empresa	
					,a.empresa	
					,a.siglas
					,a.anio_fecha
					,CONCAT(TRUNCATE(SUM(TIME_TO_SEC(a.capturadas_horas))/3600,0),':',RPAD(ROUND(60*RIGHT(TRUNCATE(SUM(TIME_TO_SEC(a.capturadas_horas))/3600,2),3),0),2,'0')) as capturadas_horas
					,FORMAT(SUM(a.capturadas_porcentaje),2) as capturadas_porcentaje
					,CONCAT(TRUNCATE(SUM(TIME_TO_SEC(a.pendientes_horas))/3600,0),':',RPAD(ROUND(60*RIGHT(TRUNCATE(SUM(TIME_TO_SEC(a.pendientes_horas))/3600,2),3),0),2,'0')) as pendientes_horas
					,FORMAT(SUM(a.pendientes_porcentaje),2) as pendientes_porcentaje
					,CONCAT(TRUNCATE(SUM(TIME_TO_SEC(a.autorizadas_horas))/3600,0),':',RPAD(ROUND(60*RIGHT(TRUNCATE(SUM(TIME_TO_SEC(a.autorizadas_horas))/3600,2),3),0),2,'0')) as autorizadas_horas
					,FORMAT(SUM(a.autorizadas_porcentaje),2) as autorizadas_porcentaje
					,CONCAT(TRUNCATE(SUM(TIME_TO_SEC(a.rechazadas_horas))/3600,0),':',RPAD(ROUND(60*RIGHT(TRUNCATE(SUM(TIME_TO_SEC(a.rechazadas_horas))/3600,2),3),0),2,'0')) as rechazadas_horas
					,FORMAT(SUM(a.rechazadas_porcentaje),2) as rechazadas_porcentaje
					,CONCAT(TRUNCATE(SUM(TIME_TO_SEC(a.pagadas_horas))/3600,0),':',RPAD(ROUND(60*RIGHT(TRUNCATE(SUM(TIME_TO_SEC(a.pagadas_horas))/3600,2),3),0),2,'0')) as pagadas_horas
					,FORMAT(SUM(a.pagadas_porcentaje),2) as pagadas_porcentaje
					,CONCAT(TRUNCATE(SUM(TIME_TO_SEC(a.dobles_horas))/3600,0),':',RPAD(ROUND(60*RIGHT(TRUNCATE(SUM(TIME_TO_SEC(a.dobles_horas))/3600,2),3),0),2,'0')) as dobles_horas
					,FORMAT(SUM(a.dobles_porcentaje),2) as dobles_porcentaje
					,CONCAT(TRUNCATE(SUM(TIME_TO_SEC(a.triples_horas))/3600,0),':',RPAD(ROUND(60*RIGHT(TRUNCATE(SUM(TIME_TO_SEC(a.triples_horas))/3600,2),3),0),2,'0')) as triples_horas
					,FORMAT(SUM(a.triples_porcentaje),2) as triples_porcentaje
					FROM 
						(SELECT 
							 a.id_horas_extra
							,d.id_nomina
							,d.empleado_num as cid
							,CONCAT(d.nombre,' ',IFNULL(d.paterno,''),' ',IFNULL(d.materno,'')) as nombre_completo
							,g.id_calendario as id_periodo
							,DATE_FORMAT(g.fecha_inicio,'%Y') as periodo_anio
							,g.fecha_inicio as periodo_inicio
							,g.fecha_fin as periodo_fin
							,c.nomina_anio 
							,c.nomina_periodo 
							,a.fecha
							,c.semana
							,a.id_empresa
							,f.nombre as empresa
							,f.siglas
							,DATE_FORMAT(a.fecha,'%Y') as anio_fecha
							,IF(a.activo=1,a.horas,0) as capturadas_horas
							,FORMAT(IF(a.activo=1,TIME_TO_SEC(a.horas),0)/3600,2) as capturadas_porcentaje
							,IF(a.activo=1 AND b.estatus IS NULL,TIME_TO_SEC(a.horas),0) as pendientes_horas
							,FORMAT(IF(a.activo=1 AND b.estatus IS NULL,a.horas,0)/3600,2) as pendientes_porcentaje
							,IF(a.activo=1 AND b.activo=1 AND b.estatus=1,b.horas,0) as autorizadas_horas
							,FORMAT(IF(a.activo=1 AND b.activo=1 AND b.estatus=1,TIME_TO_SEC(b.horas),0)/3600,2) as autorizadas_porcentaje
							,SEC_TO_TIME(IF(a.activo=1,TIME_TO_SEC(a.horas),0) - IF(a.activo=1 AND b.activo=1 AND b.estatus=1,TIME_TO_SEC(b.horas),0)) as rechazadas_horas
							,FORMAT((IF(a.activo=1,TIME_TO_SEC(a.horas),0) - IF(a.activo=1 AND b.activo=1 AND b.estatus=1,TIME_TO_SEC(b.horas),0))/3600,2) as rechazadas_porcentaje
							,SEC_TO_TIME(TIME_TO_SEC(c.dobles_horas) + TIME_TO_SEC(c.triples_horas)) as pagadas_horas
							,FORMAT((TIME_TO_SEC(c.dobles_horas) + TIME_TO_SEC(c.triples_horas))/3600,2) as pagadas_porcentaje
							,c.dobles_horas
							,c.dobles_porcentaje
							,c.triples_horas
							,c.triples_porcentaje
						FROM $db[tbl_horas_extra] a
						LEFT JOIN (SELECT * FROM 
							(SELECT * FROM $db[tbl_autorizaciones] ORDER BY id_horas_extra ASC, id_cat_autorizacion DESC) AS tbl_aut
							GROUP BY tbl_aut.id_horas_extra) b ON a.id_horas_extra=b.id_horas_extra
						LEFT JOIN (SELECT id_horas_extra, id_cat_autorizaciones, IF(anio=0 or anio IS NULL,final_anio,anio) as nomina_anio, IF(periodo=0 or periodo IS NULL, final_periodo, periodo) as nomina_periodo, periodo_especial, semana, id_concepto, activo, xls	
							,SEC_TO_TIME(SUM(IF(id_concepto=2,TIME_TO_SEC(horas),0))) as dobles_horas
							,SUM(IF(id_concepto=2,horas_porcentaje,0)) as dobles_porcentaje
							,SEC_TO_TIME(SUM(IF(id_concepto=3,TIME_TO_SEC(horas),0))) as triples_horas
							,SUM(IF(id_concepto=3,horas_porcentaje,0)) as triples_porcentaje
							,SEC_TO_TIME(SUM(TIME_TO_SEC(horas))) as total_horas
							,SUM(horas_porcentaje) as total_porcentaje
							FROM $db[tbl_autorizaciones_nomina]
							GROUP BY id_horas_extra ASC) c ON a.id_horas_extra=c.id_horas_extra
						LEFT JOIN $db[tbl_personal] d ON a.id_personal=d.id_personal
						LEFT JOIN $db[tbl_usuarios] e ON a.id_usuario=e.id_usuario
						LEFT JOIN $db[tbl_empresas] f ON a.id_empresa=f.id_empresa
						LEFT JOIN $db[tbl_calendarios] g ON a.fecha BETWEEN g.fecha_inicio AND g.fecha_fin
						WHERE 1 AND a.activo=1 AND b.activo=1 AND c.activo=1 
						GROUP BY a.id_horas_extra
						ORDER BY a.id_empresa, c.nomina_anio, c.nomina_periodo, d.nombre, d.paterno, d.materno , a.fecha ASC) as a
				WHERE 1 AND a.nomina_periodo>=1 $filtro
				GROUP BY a.id_empresa, a.nomina_anio, a.nomina_periodo/*, nomina_anio, nomina_periodo*/ ASC
				;";
		// dump_var($sql);
		$resultado = SQLQuery($sql);
		$resultado = (count($resultado)) ? $resultado : false ;
	}else{
		$resultado = false;
	}
	return $resultado;
}

function select_reporte_por_periodo($data=array()){
	if($data[auth]){
		global $db, $usuario;
		$id_empresa = (is_array($data[id_empresa]))?implode(',',$data[id_empresa]):$data[id_empresa];
		$anio 	= (is_array($data[anio]))?implode(',',$data[anio]):$data[anio];
		$filtro.= ($id_empresa)?" and a.id_empresa IN ($id_empresa)":'';
		$filtro.= ($anio)?" and a.periodo_anio IN ($anio)":'';
		$filtro.=filtro_grupo(array(
	           10 => ''
	          ,20 => "and a.id_empresa='$usuario[id_empresa]'"
	          ,30 => "and a.id_empresa='$usuario[id_empresa]' "
	          ,34 => "and a.id_empresa='$usuario[id_empresa]' "
	          ,35 => "and a.id_empresa='$usuario[id_empresa]' "
	          ,40 => "and a.id_empresa='$usuario[id_empresa]' "
	          ,50 => "and a.id_empresa='$usuario[id_empresa]' "
	          ,60 => "and a.id_empresa='$usuario[id_empresa]' and a.id_usuario='$usuario[id_usuario]'"
           ));
		$sql = "SELECT 
					a.nomina_anio 
					/*,IF(TRIM(a.nomina_periodo_especial)!='', CONCAT(a.nomina_periodo,'-',a.nomina_periodo_especial),a.nomina_periodo) as nomina_periodo*/
					,a.nomina_periodo
					,a.nomina_periodo_especial
					,a.periodo_anio	
					,a.periodo_inicio	
					,a.periodo_fin
					,a.id_empresa	
					,a.empresa	
					,a.siglas
					,a.anio_fecha
					,CONCAT(TRUNCATE(SUM(TIME_TO_SEC(a.capturadas_horas))/3600,0),':',RPAD(ROUND(60*RIGHT(TRUNCATE(SUM(TIME_TO_SEC(a.capturadas_horas))/3600,2),3),0),2,'0')) as capturadas_horas
					,FORMAT(SUM(a.capturadas_porcentaje),2) as capturadas_porcentaje
					,CONCAT(TRUNCATE(SUM(TIME_TO_SEC(a.pendientes_horas))/3600,0),':',RPAD(ROUND(60*RIGHT(TRUNCATE(SUM(TIME_TO_SEC(a.pendientes_horas))/3600,2),3),0),2,'0')) as pendientes_horas
					,FORMAT(SUM(a.pendientes_porcentaje),2) as pendientes_porcentaje
					,CONCAT(TRUNCATE(SUM(TIME_TO_SEC(a.autorizadas_horas))/3600,0),':',RPAD(ROUND(60*RIGHT(TRUNCATE(SUM(TIME_TO_SEC(a.autorizadas_horas))/3600,2),3),0),2,'0')) as autorizadas_horas
					,FORMAT(SUM(a.autorizadas_porcentaje),2) as autorizadas_porcentaje
					,CONCAT(TRUNCATE(SUM(TIME_TO_SEC(a.rechazadas_horas))/3600,0),':',RPAD(ROUND(60*RIGHT(TRUNCATE(SUM(TIME_TO_SEC(a.rechazadas_horas))/3600,2),3),0),2,'0')) as rechazadas_horas
					,FORMAT(SUM(a.rechazadas_porcentaje),2) as rechazadas_porcentaje
					,CONCAT(TRUNCATE(SUM(TIME_TO_SEC(a.pagadas_horas))/3600,0),':',RPAD(ROUND(60*RIGHT(TRUNCATE(SUM(TIME_TO_SEC(a.pagadas_horas))/3600,2),3),0),2,'0')) as pagadas_horas
					,FORMAT(SUM(a.pagadas_porcentaje),2) as pagadas_porcentaje
					,CONCAT(TRUNCATE(SUM(TIME_TO_SEC(a.dobles_horas))/3600,0),':',RPAD(ROUND(60*RIGHT(TRUNCATE(SUM(TIME_TO_SEC(a.dobles_horas))/3600,2),3),0),2,'0')) as dobles_horas
					,FORMAT(SUM(a.dobles_porcentaje),2) as dobles_porcentaje
					,CONCAT(TRUNCATE(SUM(TIME_TO_SEC(a.triples_horas))/3600,0),':',RPAD(ROUND(60*RIGHT(TRUNCATE(SUM(TIME_TO_SEC(a.triples_horas))/3600,2),3),0),2,'0')) as triples_horas
					,FORMAT(SUM(a.triples_porcentaje),2) as triples_porcentaje
					FROM 
						(SELECT 
							 a.id_horas_extra
							,d.id_nomina
							,d.empleado_num as cid
							,CONCAT(d.nombre,' ',IFNULL(d.paterno,''),' ',IFNULL(d.materno,'')) as nombre_completo
							,g.id_calendario as id_periodo
							,DATE_FORMAT(g.fecha_inicio,'%Y') as periodo_anio
							,g.fecha_inicio as periodo_inicio
							,g.fecha_fin as periodo_fin
							,c.nomina_anio 
							,c.nomina_periodo
							,c.nomina_periodo_especial
							,a.fecha
							,c.semana
							,a.id_empresa
							,f.nombre as empresa
							,f.siglas
							,DATE_FORMAT(a.fecha,'%Y') as anio_fecha
							,IF(a.activo=1,a.horas,0) as capturadas_horas
							,FORMAT(IF(a.activo=1,TIME_TO_SEC(a.horas),0)/3600,2) as capturadas_porcentaje
							,IF(a.activo=1 AND b.estatus IS NULL,TIME_TO_SEC(a.horas),0) as pendientes_horas
							,FORMAT(IF(a.activo=1 AND b.estatus IS NULL,a.horas,0)/3600,2) as pendientes_porcentaje
							,IF(a.activo=1 AND b.activo=1 AND b.estatus=1,b.horas,0) as autorizadas_horas
							,FORMAT(IF(a.activo=1 AND b.activo=1 AND b.estatus=1,TIME_TO_SEC(b.horas),0)/3600,2) as autorizadas_porcentaje
							,SEC_TO_TIME(IF(a.activo=1,TIME_TO_SEC(a.horas),0) - IF(a.activo=1 AND b.activo=1 AND b.estatus=1,TIME_TO_SEC(b.horas),0)) as rechazadas_horas
							,FORMAT((IF(a.activo=1,TIME_TO_SEC(a.horas),0) - IF(a.activo=1 AND b.activo=1 AND b.estatus=1,TIME_TO_SEC(b.horas),0))/3600,2) as rechazadas_porcentaje
							,SEC_TO_TIME(TIME_TO_SEC(c.dobles_horas) + TIME_TO_SEC(c.triples_horas)) as pagadas_horas
							,FORMAT((TIME_TO_SEC(c.dobles_horas) + TIME_TO_SEC(c.triples_horas))/3600,2) as pagadas_porcentaje
							,c.dobles_horas
							,c.dobles_porcentaje
							,c.triples_horas
							,c.triples_porcentaje
						FROM $db[tbl_horas_extra] a
						LEFT JOIN (SELECT * FROM 
							(SELECT * FROM $db[tbl_autorizaciones] ORDER BY id_horas_extra ASC, id_cat_autorizacion DESC) AS tbl_aut
							GROUP BY tbl_aut.id_horas_extra) b ON a.id_horas_extra=b.id_horas_extra
						LEFT JOIN (SELECT id_horas_extra, id_cat_autorizaciones, IF(anio=0 or anio IS NULL,final_anio,anio) as nomina_anio, IF(periodo=0 or periodo IS NULL, final_periodo, periodo) as nomina_periodo, IF(periodo_especial=0 or periodo_especial IS NULL, final_periodo_especial, periodo_especial) as nomina_periodo_especial, semana, id_concepto, activo, xls	
							,SEC_TO_TIME(SUM(IF(id_concepto=2,TIME_TO_SEC(horas),0))) as dobles_horas
							,SUM(IF(id_concepto=2,horas_porcentaje,0)) as dobles_porcentaje
							,SEC_TO_TIME(SUM(IF(id_concepto=3,TIME_TO_SEC(horas),0))) as triples_horas
							,SUM(IF(id_concepto=3,horas_porcentaje,0)) as triples_porcentaje
							,SEC_TO_TIME(SUM(TIME_TO_SEC(horas))) as total_horas
							,SUM(horas_porcentaje) as total_porcentaje
							FROM $db[tbl_autorizaciones_nomina]
							WHERE activo=1 	
							GROUP BY id_horas_extra ASC) c ON a.id_horas_extra=c.id_horas_extra
						LEFT JOIN $db[tbl_personal] d ON a.id_personal=d.id_personal
						LEFT JOIN $db[tbl_usuarios] e ON a.id_usuario=e.id_usuario
						LEFT JOIN $db[tbl_empresas] f ON a.id_empresa=f.id_empresa
						LEFT JOIN $db[tbl_calendarios] g ON a.fecha BETWEEN g.fecha_inicio AND g.fecha_fin
						WHERE 1 AND a.activo=1 AND b.activo=1 
						GROUP BY a.id_horas_extra
						ORDER BY a.id_empresa, c.nomina_anio, c.nomina_periodo, d.nombre, d.paterno, d.materno , a.fecha ASC) as a
				WHERE 1 AND a.nomina_periodo>=1 $filtro
				GROUP BY a.id_empresa, a.nomina_anio, a.nomina_periodo, a.nomina_periodo_especial ASC
				;";

		// dump_var($sql);
		$resultado = SQLQuery($sql);
		$resultado = (count($resultado)) ? $resultado : false ;
	}else{
		$resultado = false;
	}
	return $resultado;
}

function select_reporte_nominativo($data=array()){
	if($data[auth]){
		global $db, $usuario;
		$id_empresa = (is_array($data[id_empresa]))?implode(',',$data[id_empresa]):$data[id_empresa];
		$anio 		= (is_array($data[anio]))?implode(',',$data[anio]):$data[anio];
		$periodo 	= (is_array($data[periodo]))?implode(',',"'".$data[periodo]."'"):"'".$data[periodo]."'";
		$periodo_especial 	= (isset($data[periodo_especial]))?"'".$data[periodo_especial]."'":'';
		$filtro.= ($id_empresa)?" and a.id_empresa IN ($id_empresa)":'';
		$filtro.= ($anio)?" and c.nomina_anio IN ($anio)":'';
		$filtro.= ($periodo)?" and c.nomina_periodo IN ($periodo)":'';
		$filtro.= ($periodo_especial)?" and c.nomina_periodo_especial IN ($periodo_especial)":'';
		$filtro.=filtro_grupo(array(
	           10 => ''
	          ,20 => "and a.id_empresa='$usuario[id_empresa]'"
	          ,30 => "and a.id_empresa='$usuario[id_empresa]' "
	          ,34 => "and a.id_empresa='$usuario[id_empresa]' "
	          ,35 => "and a.id_empresa='$usuario[id_empresa]' "
	          ,40 => "and a.id_empresa='$usuario[id_empresa]' "
	          ,50 => "and a.id_empresa='$usuario[id_empresa]' "
	          ,60 => "and a.id_empresa='$usuario[id_empresa]' and a.id_usuario='$usuario[id_usuario]'"
           ));
		$sql = "SELECT 
					 a.id_horas_extra
					,d.id_nomina
					,d.empleado_num as cid
					,CONCAT(d.nombre,' ',IFNULL(d.paterno,''),' ',IFNULL(d.materno,'')) as nombre_completo
					,d.estado
					,d.sucursal_nomina as sucursal
					,d.sucursal as localidad
					,d.puesto
					,g.id_calendario as id_periodo
					,DATE_FORMAT(g.fecha_inicio,'%Y') as periodo_anio
					,g.fecha_inicio as periodo_inicio
					,g.fecha_fin as periodo_fin
					,c.nomina_anio 
					,c.nomina_periodo 
					,c.nomina_periodo_especial 
					,a.fecha
					,c.semana
					,a.id_empresa
					,f.nombre as empresa
					,f.siglas
					,DATE_FORMAT(a.fecha,'%Y') as anio_fecha
					,IF(a.activo=1,a.horas,0) as capturadas_horas
					,FORMAT(IF(a.activo=1,TIME_TO_SEC(a.horas),0)/3600,2) as capturadas_porcentaje
					,IF(a.activo=1 AND b.estatus IS NULL,TIME_TO_SEC(a.horas),0) as pendientes_horas
					,FORMAT(IF(a.activo=1 AND b.estatus IS NULL,a.horas,0)/3600,2) as pendientes_porcentaje
					,IF(a.activo=1 AND b.activo=1 AND b.estatus=1,b.horas,0) as autorizadas_horas
					,FORMAT(IF(a.activo=1 AND b.activo=1 AND b.estatus=1,TIME_TO_SEC(b.horas),0)/3600,2) as autorizadas_porcentaje
					,SEC_TO_TIME(IF(a.activo=1,TIME_TO_SEC(a.horas),0) - IF(a.activo=1 AND b.activo=1 AND b.estatus=1,TIME_TO_SEC(b.horas),0)) as rechazadas_horas
					,FORMAT((IF(a.activo=1,TIME_TO_SEC(a.horas),0) - IF(a.activo=1 AND b.activo=1 AND b.estatus=1,TIME_TO_SEC(b.horas),0))/3600,2) as rechazadas_porcentaje
					,SEC_TO_TIME(TIME_TO_SEC(c.dobles_horas) + TIME_TO_SEC(c.triples_horas)) as pagadas_horas
					,FORMAT((TIME_TO_SEC(c.dobles_horas) + TIME_TO_SEC(c.triples_horas))/3600,2) as pagadas_porcentaje
					,c.dobles_horas
					,c.dobles_porcentaje
					,c.triples_horas
					,c.triples_porcentaje					
				FROM $db[tbl_horas_extra] a
				LEFT JOIN (SELECT * FROM 
					(SELECT * FROM $db[tbl_autorizaciones] WHERE activo=1 ORDER BY id_horas_extra ASC, id_cat_autorizacion DESC) AS tbl_aut
					GROUP BY tbl_aut.id_horas_extra) b ON a.id_horas_extra=b.id_horas_extra
				LEFT JOIN (SELECT id_horas_extra, id_cat_autorizaciones, IF(anio=0 or anio IS NULL,final_anio,anio) as nomina_anio, IF(periodo=0 or periodo IS NULL, final_periodo, periodo) as nomina_periodo, IF(periodo_especial=0 or periodo_especial IS NULL, final_periodo_especial, periodo_especial) as nomina_periodo_especial, semana, id_concepto, activo, xls	
							,SEC_TO_TIME(SUM(IF(id_concepto=2,TIME_TO_SEC(horas),0))) as dobles_horas
							,SUM(IF(id_concepto=2,horas_porcentaje,0)) as dobles_porcentaje
							,SEC_TO_TIME(SUM(IF(id_concepto=3,TIME_TO_SEC(horas),0))) as triples_horas
							,SUM(IF(id_concepto=3,horas_porcentaje,0)) as triples_porcentaje
							,SEC_TO_TIME(SUM(TIME_TO_SEC(horas))) as total_horas
							,SUM(horas_porcentaje) as total_porcentaje
							FROM $db[tbl_autorizaciones_nomina]
							WHERE activo=1 	
							GROUP BY id_horas_extra ASC) c ON a.id_horas_extra=c.id_horas_extra
				LEFT JOIN $db[tbl_personal] d ON a.id_personal=d.id_personal
				LEFT JOIN $db[tbl_usuarios] e ON a.id_usuario=e.id_usuario
				LEFT JOIN $db[tbl_empresas] f ON a.id_empresa=f.id_empresa
				LEFT JOIN $db[tbl_calendarios] g ON a.fecha BETWEEN g.fecha_inicio AND g.fecha_fin
				WHERE 1 AND a.activo=1 AND b.activo=1 $filtro
				GROUP BY a.id_horas_extra
				ORDER BY a.id_empresa, c.nomina_anio, c.nomina_periodo, d.nombre, d.paterno, d.materno , a.fecha ASC
				;";
		// dump_var($sql);
		$resultado = SQLQuery($sql);
		$resultado = (count($resultado)) ? $resultado : false ;
	}else{
		$resultado = false;
	}
	return $resultado;
}

function select_reporte_nominativo_xls($data=array()){
	if($data[auth]){
		global $db, $usuario;
		$id_empresa = (is_array($data[id_empresa]))?implode(',',$data[id_empresa]):$data[id_empresa];
		$anio 		= (is_array($data[anio]))?implode(',',$data[anio]):$data[anio];
		$periodo 	= (is_array($data[periodo]))?implode(',',"'".$data[periodo]."'"):"'".$data[periodo]."'";
		$periodo_especial 	= (isset($data[periodo_especial]))?$data[periodo_especial]:'';
		$filtro.= ($id_empresa)?" and a.id_empresa IN ($id_empresa)":'';
		$filtro.= ($anio)?" and c.nomina_anio IN ($anio)":'';
		$filtro.= ($periodo)?" and c.nomina_periodo IN ($periodo)":'';
		$filtro.= (isset($periodo_especial))?" and c.nomina_periodo_especial='$periodo_especial'":"and c.nomina_periodo_especial=''";
		$filtro.=filtro_grupo(array(
	           10 => ''
	          ,20 => "and a.id_empresa='$usuario[id_empresa]'"
	          ,30 => "and a.id_empresa='$usuario[id_empresa]' "
	          ,34 => "and a.id_empresa='$usuario[id_empresa]' "
	          ,35 => "and a.id_empresa='$usuario[id_empresa]' "
	          ,40 => "and a.id_empresa='$usuario[id_empresa]' "
	          ,50 => "and a.id_empresa='$usuario[id_empresa]' "
	          ,60 => "and a.id_empresa='$usuario[id_empresa]' and a.id_usuario='$usuario[id_usuario]'"
           ));
		$sql = "SELECT 
					/* a.id_empresa
					,f.nombre as empresa
					,f.siglas*/					
					 d.empleado_num as cid
					,d.id_nomina
					,CONCAT(IFNULL(d.paterno,''),' ',IFNULL(d.materno,''),', ',d.nombre) as nombre_completo
					,d.estado
					,d.sucursal_nomina as sucursal
					,d.sucursal as localidad
					,d.puesto
					,c.nomina_anio 
					,c.nomina_periodo
					,c.nomina_periodo_especial
					,c.semana						 
					,a.fecha
					,IF(a.activo=1,a.horas,0) as capturadas_horas
					,FORMAT(IF(a.activo=1,TIME_TO_SEC(a.horas),0)/3600,2) as capturadas_porcentaje
					,IF(a.activo=1 AND b.activo=1 AND b.estatus=1,b.horas,0) as autorizadas_horas
					,FORMAT(IF(a.activo=1 AND b.activo=1 AND b.estatus=1,TIME_TO_SEC(b.horas),0)/3600,2) as autorizadas_porcentaje
					,SEC_TO_TIME(TIME_TO_SEC(c.dobles_horas) + TIME_TO_SEC(c.triples_horas)) as pagadas_horas
					,FORMAT((TIME_TO_SEC(c.dobles_horas) + TIME_TO_SEC(c.triples_horas))/3600,2) as pagadas_porcentaje
					,c.dobles_horas
					,c.dobles_porcentaje
					,c.triples_horas
					,c.triples_porcentaje
					,CONCAT(IFNULL(auth.empleado_num,''),' - ',auth.nombre,' ',IFNULL(auth.paterno,''),' ',IFNULL(auth.materno,''),' - ',IFNULL(b.timestamp,'')) as autorizo
					,n1.empleado_num as supervisor_n1_cid
					,CONCAT(n1.nombre,' ',IFNULL(n1.paterno,''),' ',IFNULL(n1.materno,'')) as supervisor_n1_nombre
					,n1.puesto as supervisor_n1_puesto
					,n2.empleado_num as supervisor_n2_cid
					,CONCAT(n2.nombre,' ',IFNULL(n2.paterno,''),' ',IFNULL(n2.materno,'')) as supervisor_n2_nombre
					,n2.puesto as supervisor_n2_puesto
					,n3.empleado_num as supervisor_n3_cid
					,CONCAT(n3.nombre,' ',IFNULL(n3.paterno,''),' ',IFNULL(n3.materno,'')) as supervisor_n3_nombre
					,n3.puesto as supervisor_n3_puesto
					,a.id_horas_extra
				FROM $db[tbl_horas_extra] a
				LEFT JOIN (SELECT * FROM 
					(SELECT * FROM $db[tbl_autorizaciones] where activo=1 ORDER BY id_horas_extra ASC, id_cat_autorizacion DESC) AS tbl_aut
					GROUP BY tbl_aut.id_horas_extra) b ON a.id_horas_extra=b.id_horas_extra
				LEFT JOIN (SELECT id_horas_extra, id_cat_autorizaciones, IF(anio=0 or anio IS NULL,final_anio,anio) as nomina_anio, IF(periodo=0 or periodo IS NULL, final_periodo, periodo) as nomina_periodo, IF(periodo_especial=0 or periodo_especial IS NULL, final_periodo_especial, periodo_especial) as nomina_periodo_especial, semana, id_concepto, activo, xls	
							,SEC_TO_TIME(SUM(IF(id_concepto=2,TIME_TO_SEC(horas),0))) as dobles_horas
							,SUM(IF(id_concepto=2,horas_porcentaje,0)) as dobles_porcentaje
							,SEC_TO_TIME(SUM(IF(id_concepto=3,TIME_TO_SEC(horas),0))) as triples_horas
							,SUM(IF(id_concepto=3,horas_porcentaje,0)) as triples_porcentaje
							,SEC_TO_TIME(SUM(TIME_TO_SEC(horas))) as total_horas
							,SUM(horas_porcentaje) as total_porcentaje
							FROM $db[tbl_autorizaciones_nomina]
							WHERE activo=1 	
							GROUP BY id_horas_extra ASC) c ON a.id_horas_extra=c.id_horas_extra
				LEFT JOIN $db[tbl_personal] d ON a.id_personal=d.id_personal
				LEFT JOIN $db[tbl_usuarios] e ON a.id_usuario=e.id_usuario
				LEFT JOIN $db[tbl_empresas] f ON a.id_empresa=f.id_empresa
				LEFT JOIN $db[tbl_calendarios] g ON a.fecha BETWEEN g.fecha_inicio AND g.fecha_fin
				LEFT JOIN $db[tbl_usuarios] u_auth ON b.id_usuario=u_auth.id_usuario 
				LEFT JOIN $db[tbl_personal] auth ON u_auth.id_personal=auth.id_personal
				left join he_supervisores s1 on a.id_personal=s1.id_personal and s1.id_nivel=1
				left join he_personal n1 on s1.id_supervisor=n1.id_personal
				left join sis_usuarios un1 on n1.id_personal=un1.id_personal
				left join he_supervisores s2 on a.id_personal=s2.id_personal and s2.id_nivel=2
				left join he_personal n2 on s2.id_supervisor=n2.id_personal
				left join sis_usuarios un2 on n2.id_personal=un2.id_personal
				left join he_supervisores s3 on a.id_personal=s3.id_personal and s3.id_nivel=3
				left join he_personal n3 on s3.id_supervisor=n3.id_personal
				left join sis_usuarios un3 on n3.id_personal=un3.id_personal
				WHERE 1 AND a.activo=1 AND b.activo=1 $filtro
				GROUP BY a.id_horas_extra
				ORDER BY a.id_empresa, c.nomina_anio, c.nomina_periodo, d.nombre, d.paterno, d.materno , a.fecha ASC
				;";
		// dump_var($sql);
		$resultado = SQLQuery($sql);
		$resultado = (count($resultado)) ? $resultado : false ;
	}else{
		$resultado = false;
	}
	return $resultado;
}

function periodos($data=array()){
	if($data[auth]){		
		global $db, $usuario; 
		$id_periodo = (is_array($data[id_periodo]))?implode(',',$data[id_periodo]):$data[id_periodo];
		$id_empresa = (is_array($data[id_empresa]))?implode(',',$data[id_empresa]):$data[id_empresa];
		$filtro.=filtro_grupo(array(
	           10 => ''
	          ,20 => "and a.id_empresa='$usuario[id_empresa]'"
	          ,30 => "and a.id_empresa='$usuario[id_empresa]' "
	          ,34 => "and a.id_empresa='$usuario[id_empresa]' "
	          ,35 => "and a.id_empresa='$usuario[id_empresa]' "
	          ,40 => "and a.id_empresa='$usuario[id_empresa]' "
	          ,50 => "and a.id_empresa='$usuario[id_empresa]' "
	          ,60 => "and a.id_empresa='$usuario[id_empresa]' and a.id_usuario='$usuario[id_usuario]'"
           ));
		$filtro .= ($id_periodo)?" AND id_periodo IN ($id_periodo)":'';
		$filtro .= ($id_empresa)?" AND a.id_empresa IN ($id_empresa)":'';
		$sql = "SELECT 
					 id_calendario as id_periodo
					,CONCAT('Del ',DATE_FORMAT(fecha_inicio,'%d/%m/%Y'),' al ', DATE_FORMAT(fecha_fin,'%d/%m/%Y')) as periodo
				FROM $db[tbl_calendarios] a
				WHERE 1 AND tipo='INCIDENCIAS' $filtro 
				GROUP BY CONCAT('Del ',DATE_FORMAT(fecha_inicio,'%d/%m/%Y'),' al ', DATE_FORMAT(fecha_fin,'%d/%m/%Y'))
				ORDER BY fecha_inicio;";
				// dump_var($sql);
		$resultado = SQLQuery($sql);
		$resultado = (count($resultado)) ? $resultado : false ;
	}else{
		$resultado = false;
	}
	return $resultado;
}
?>