<?php session_name('o3m_fw'); session_start(); if(isset($_SESSION['header_path'])){include_once($_SESSION['header_path']);}else{header('location: '.dirname(__FILE__));}
/**
* 				Funciones "DAO"
* Descripcion:	Ejecuta consultas SQL y devuelve el resultado.
* Creación:		2014-10-02
* @author 		Oscar Maldonado
*/


/**
* Autorización nivel 1
*/

function select_autorizacion_1($data=array()){
/**
* Listado de autorizaciones nivel 1
*/
	$resultado = false;
	if($data[auth]){
	               global $db, $usuario;
	               $id_horas_extra = (is_array($data[id_horas_extra]))?implode(',',$data[id_horas_extra]):$data[id_horas_extra];
	               $id_personal    = (is_array($data[id_personal]))?implode(',',$data[id_personal]):$data[id_personal];
	                $empleado_num  = (is_array($data[empleado_num]))?implode(',',$data[empleado_num]):$data[empleado_num];
	               $id_usuario     = (is_array($data[id_usuario]))?implode(',',$data[id_usuario]):$data[id_usuario];
	               $grupo          = (is_array($data[grupo]))?implode(',',$data[grupo]):$data[grupo];
	               $orden          = (is_array($data[orden]))?implode(',',$data[orden]):$data[orden];
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
	               $grupo  = ($grupo)?"GROUP BY $grupo":"GROUP BY a.id_horas_extra";
	               $orden  = ($orden)?"ORDER BY $orden":"ORDER BY a.id_horas_extra ASC";                      
	               $sql = "SELECT 
								 a.id_horas_extra
								,a.id_empresa
								,c.nombre as empresa
								,b.estado
								,b.sucursal_nomina as sucursal
								,b.sucursal as localidad
								,b.puesto
								,a.id_personal
								,CONCAT(b.nombre,' ',IFNULL(b.paterno,''),' ',IFNULL(b.materno,'')) as nombre_completo
								,b.empleado_num
								,a.fecha
								,DATE_FORMAT(a.horas,'%H:%i') as horas
								,a.semana_iso8601
								,n1.estatus AS n1_estatus
								,n1.id_usuario AS n1_id_usuario
								,n1.timestamp AS n1_fecha
							FROM $db[tbl_horas_extra] a
							LEFT JOIN $db[tbl_personal] b ON a.id_empresa=b.id_empresa AND a.id_personal=b.id_personal
							LEFT JOIN $db[tbl_empresas] c ON a.id_empresa=c.id_empresa
							LEFT JOIN $db[tbl_autorizaciones_nomina] d ON a.id_horas_extra=d.id_horas_extra
							/*LEFT JOIN $db[tbl_autorizaciones] AS n1 ON a.id_horas_extra=n1.id_horas_extra AND n1.id_cat_autorizacion=1*/
							LEFT JOIN (SELECT a.* FROM (SELECT * FROM $db[tbl_autorizaciones] ORDER BY timestamp DESC, id_cat_autorizacion DESC) a GROUP BY a.id_horas_extra) AS n1 ON a.id_horas_extra=n1.id_horas_extra AND n1.id_cat_autorizacion=1
							LEFT JOIN (SELECT a.* FROM (SELECT * FROM $db[tbl_autorizaciones] ORDER BY timestamp DESC, id_cat_autorizacion DESC) a GROUP BY a.id_horas_extra) AS n2 ON a.id_horas_extra=n2.id_horas_extra AND n2.id_cat_autorizacion=2
							LEFT JOIN (SELECT a.* FROM (SELECT * FROM $db[tbl_autorizaciones] ORDER BY timestamp DESC, id_cat_autorizacion DESC) a GROUP BY a.id_horas_extra) AS n3 ON a.id_horas_extra=n3.id_horas_extra AND n3.id_cat_autorizacion=3
							LEFT JOIN (SELECT a.* FROM (SELECT * FROM $db[tbl_autorizaciones] ORDER BY timestamp DESC, id_cat_autorizacion DESC) a GROUP BY a.id_horas_extra) AS n4 ON a.id_horas_extra=n4.id_horas_extra AND n4.id_cat_autorizacion=4
							LEFT JOIN (SELECT a.* FROM (SELECT * FROM $db[tbl_autorizaciones] ORDER BY timestamp DESC, id_cat_autorizacion DESC) a GROUP BY a.id_horas_extra) AS n5 ON a.id_horas_extra=n5.id_horas_extra AND n5.id_cat_autorizacion=5
							left join $db[tbl_supervisores] s1 on b.id_empresa=s1.id_empresa and b.id_personal=s1.id_personal and s1.id_nivel=1
							left join $db[tbl_supervisores] s2 on b.id_empresa=s2.id_empresa and b.id_personal=s2.id_personal and s2.id_nivel=2
							left join $db[tbl_supervisores] s3 on b.id_empresa=s3.id_empresa and b.id_personal=s3.id_personal and s3.id_nivel=3
							left join $db[tbl_supervisores] s4 on b.id_empresa=s4.id_empresa and b.id_personal=s4.id_personal and s4.id_nivel=4
							left join $db[tbl_supervisores] s5 on b.id_empresa=s5.id_empresa and b.id_personal=s5.id_personal and s5.id_nivel=5
			               WHERE 1 AND n1.estatus IS NULL AND n2.estatus IS NULL AND n3.estatus IS NULL AND n4.estatus IS NULL AND n5.estatus IS NULL AND d.id_autorizacion_nomina IS NULL
			               $filtro 			               
			               $grupo 
			               $orden;";
	               // dump_var($sql);
	               $resultado = SQLQuery($sql);
	               $resultado = (count($resultado)) ? $resultado : false ;
	}
	return $resultado;
}
function select_layout_autorizacion_1($data=array()){
/**
* Listado de registros autorizados en todos sus niveles
*/
	$resultado = false;
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
					,30 => "and a.id_empresa='$usuario[id_empresa]'"
					,40 => "and a.id_empresa='$usuario[id_empresa]'"
					,50 => "and a.id_empresa='$usuario[id_empresa]'"
					,60 => "and a.id_empresa='$usuario[id_empresa]' and a.id_usuario='$usuario[id_usuario]'"
				));
		$filtro.= ($id_horas_extra)?" and a.id_horas_extra IN ($id_horas_extra)":'';
		$filtro.= ($id_personal)?" and a.id_personal IN ($id_personal)":'';
		$filtro.= ($empleado_num)?" and b.empleado_num IN ($empleado_num)":'';		
		$filtro.= ($activo)?" and n4.activo IN ($activo)":'';
		$filtro.= ($id_usuario)?" and a.id_usuario IN ($id_usuario)":'';
		$grupo 	= ($grupo)?"GROUP BY $grupo":"GROUP BY a.id_horas_extra";
		$orden 	= ($orden)?"ORDER BY $orden":"ORDER BY a.id_horas_extra ASC";		
		$sql = "SELECT 
					 a.id_horas_extra
					,a.id_empresa
					,c.nombre as empresa
					,b.estado
					,b.sucursal_nomina as sucursal
					,b.sucursal as localidad
					,b.puesto
					,a.id_personal
					,b.empleado_num
					,CONCAT(b.nombre,' ',IFNULL(b.paterno,''),' ',IFNULL(b.materno,'')) as nombre_completo
					,a.fecha
					,DATE_FORMAT(a.horas,'%H:%i') as horas
					,a.semana_iso8601
				FROM $db[tbl_horas_extra] a
				LEFT JOIN $db[tbl_personal] b ON a.id_empresa=b.id_empresa AND a.id_personal=b.id_personal
				LEFT JOIN $db[tbl_empresas] c ON a.id_empresa=c.id_empresa
				LEFT JOIN $db[tbl_autorizaciones_nomina] d ON a.id_horas_extra=d.id_horas_extra
				WHERE 1 $filtro 
				$grupo 
				$orden;";				
		$resultado = SQLQuery($sql);
		$resultado = (count($resultado)) ? $resultado : false ;
	}
	return $resultado;
}
function select_acumulado_semanal_2($data=array()){
	if($data[auth]){
		global $db;
		$id_empresa 	= (is_array($data[id_empresa]))?implode(',',$data[id_empresa]):$data[id_empresa];
		$id_personal 	= (is_array($data[id_personal]))?implode(',',$data[id_personal]):$data[id_personal];
		$empleado_num 	= (is_array($data[empleado_num]))?implode(',',$data[empleado_num]):$data[empleado_num];
		$fecha 			= (is_array($data[fecha]))?implode(',',date("Y-m-d", strtotime(str_replace('/', '-', $data[fecha])))):date("Y-m-d", strtotime(str_replace('/', '-', $data[fecha])));
		$semana_iso8601 = semana_iso8601($fecha);
		$filtro.= ($id_empresa)?" and a.id_empresa IN ($id_empresa)":'';
		$filtro.= ($id_personal)?" and a.id_personal IN ($id_personal)":'';
		$filtro.= ($empleado_num)?" and b.empleado_num IN ($empleado_num)":'';
		$filtro.= ($semana_iso8601)?" and a.semana_iso8601 IN ('$semana_iso8601')":'';
		$sql="SELECT 
				 a.id_empresa
				,a.id_personal
				,b.empleado_num
				,CONCAT(b.nombre,' ',IFNULL(b.paterno,''),' ',IFNULL(b.materno,'')) as nombre_completo
				,a.semana_iso8601
				,COUNT(*) AS tot_regs
				,SUM(DATE_FORMAT(c.horas,'%H:%i')) AS tot_horas
			FROM $db[tbl_horas_extra] a
			LEFT JOIN $db[tbl_personal] b ON a.id_personal=b.id_personal
			LEFT JOIN $db[tbl_autorizaciones_nomina] c ON a.id_horas_extra=c.id_horas_extra
			WHERE 1 and c.activo=1 and c.horas IS NULL $filtro
			GROUP BY  id_empresa ,id_personal, semana_iso8601 ASC;";
		$resultado = SQLQuery($sql);
		$resultado = (count($resultado)) ? $resultado : false ;
	}
	return $resultado;
}
function insert_autorizacion_1($data=array()){
	global $db,$usuario;
	$resultado = false;
	if($data[auth]==1){
		$id_hora_extra=$data[id_horas_extra];
		$estatus=$data[estatus];
		$argumento=$data[argumento];
		$timestamp = date('Y-m-d H:i:s');

		$sql="INSERT INTO
			$db[tbl_autorizaciones]
			SET 
			id_horas_extra 		= $id_hora_extra,
			id_cat_autorizacion = 1,
			estatus 	   		= $estatus,
			id_usuario 			= $usuario[id_usuario],
			argumento 			= '$argumento',
			timestamp 			= '$timestamp',
			activo 				= 1;";
		$resultado = (SQLDo($sql))?true:false;
	}
	return $resultado;

}
function insert_layout_autorizacion_1($data=array()){
/**
 * Inserta registros autorizados para generar el layout
 */
	$resultado = false;
	if($data[auth]){
		global $db, $usuario;
		switch ($usuario[id_grupo]) {
			case 50: $nivel = 1; break;		
			case 40: $nivel = 2; break;
			case 35: $nivel = 3; break;
			case 34: $nivel = 4; break;
			case 30: $nivel = 5; break;
			default: $nivel = 1; break;
		}
		$id_cat_autorizacion = $nivel;

		$id_horas_extra 	 = $data[id_horas_extra];
		$dobles 			 = horas_int($data[dobles]);
		$triples 			 = horas_int($data[triples]);
		$rechazadas			 = horas_int($data[rechazadas]);
		$horas	 			 = $data[horas];
		// $id_concepto 		 = $data[id_concepto];	
		$estatus 			 = $data[estatus];
		$argumento 			 = $data[argumento];	
		$timestamp 			 = date('Y-m-d H:i:s');
		$sql="INSERT INTO
			$db[tbl_autorizaciones]
			SET 
			id_horas_extra 		= '$id_horas_extra',
			id_cat_autorizacion = '$id_cat_autorizacion',
			estatus 	   		= '$estatus',
			id_usuario 			= '$usuario[id_usuario]',
			argumento 			= '$argumento',
			horas 				= '$horas',
			h_dobles 			= '$dobles',
			h_triples 			= '$triples',
			h_rechazadas 		= '$rechazadas',
			timestamp 			= '$timestamp',
			activo 				= '1';";
			// dump_var($sql);
		$resultado = (SQLDo($sql))?true:false;
	}
	return $resultado;
}
/*Fin1*/

/**
* Autorización nivel 2
*/
function select_autorizacion_2($data=array()){
/**
* Listado de autorizaciones nivel 2
*/
	$resultado = false;
	if($data[auth]){
	               global $db, $usuario;
	               $id_horas_extra = (is_array($data[id_horas_extra]))?implode(',',$data[id_horas_extra]):$data[id_horas_extra];
	               $id_personal    = (is_array($data[id_personal]))?implode(',',$data[id_personal]):$data[id_personal];
	                $empleado_num  = (is_array($data[empleado_num]))?implode(',',$data[empleado_num]):$data[empleado_num];
	               $id_usuario     = (is_array($data[id_usuario]))?implode(',',$data[id_usuario]):$data[id_usuario];
	               $grupo          = (is_array($data[grupo]))?implode(',',$data[grupo]):$data[grupo];
	               $orden          = (is_array($data[orden]))?implode(',',$data[orden]):$data[orden];
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
	               $grupo  = ($grupo)?"GROUP BY $grupo":"GROUP BY a.id_horas_extra";
	               $orden  = ($orden)?"ORDER BY $orden":"ORDER BY a.id_horas_extra ASC";                      
	               $sql = "SELECT 
								 a.id_horas_extra
								,a.id_empresa
								,c.nombre as empresa
								,b.estado
								,b.sucursal_nomina as sucursal
								,b.sucursal as localidad
								,b.puesto
								,a.id_personal
								,CONCAT(b.nombre,' ',IFNULL(b.paterno,''),' ',IFNULL(b.materno,'')) as nombre_completo
								,b.empleado_num
								,a.fecha
								,DATE_FORMAT(a.horas,'%H:%i') as horas
								,DATE_FORMAT(n1.horas,'%H:%i') as n1_horas
								,a.semana_iso8601
								,n1.estatus AS n1_estatus
								,n1.id_usuario AS n1_id_usuario
								,n1.timestamp AS n1_fecha
							FROM $db[tbl_horas_extra] a
							LEFT JOIN $db[tbl_personal] b ON a.id_empresa=b.id_empresa AND a.id_personal=b.id_personal
							LEFT JOIN $db[tbl_empresas] c ON a.id_empresa=c.id_empresa
							LEFT JOIN $db[tbl_autorizaciones_nomina] d ON a.id_horas_extra=d.id_horas_extra
							LEFT JOIN (SELECT a.* FROM (SELECT * FROM $db[tbl_autorizaciones] ORDER BY timestamp DESC, id_cat_autorizacion DESC) a GROUP BY a.id_horas_extra) AS n1 ON a.id_horas_extra=n1.id_horas_extra AND n1.id_cat_autorizacion=1
							LEFT JOIN (SELECT a.* FROM (SELECT * FROM $db[tbl_autorizaciones] ORDER BY timestamp DESC, id_cat_autorizacion DESC) a GROUP BY a.id_horas_extra) AS n2 ON a.id_horas_extra=n2.id_horas_extra AND n2.id_cat_autorizacion=2
							LEFT JOIN (SELECT a.* FROM (SELECT * FROM $db[tbl_autorizaciones] ORDER BY timestamp DESC, id_cat_autorizacion DESC) a GROUP BY a.id_horas_extra) AS n3 ON a.id_horas_extra=n3.id_horas_extra AND n3.id_cat_autorizacion=3
							LEFT JOIN (SELECT a.* FROM (SELECT * FROM $db[tbl_autorizaciones] ORDER BY timestamp DESC, id_cat_autorizacion DESC) a GROUP BY a.id_horas_extra) AS n4 ON a.id_horas_extra=n4.id_horas_extra AND n4.id_cat_autorizacion=4
							LEFT JOIN (SELECT a.* FROM (SELECT * FROM $db[tbl_autorizaciones] ORDER BY timestamp DESC, id_cat_autorizacion DESC) a GROUP BY a.id_horas_extra) AS n5 ON a.id_horas_extra=n5.id_horas_extra AND n5.id_cat_autorizacion=5
							left join $db[tbl_supervisores] s1 on b.id_empresa=s1.id_empresa and b.id_personal=s1.id_personal and s1.id_nivel=1
							left join $db[tbl_supervisores] s2 on b.id_empresa=s2.id_empresa and b.id_personal=s2.id_personal and s2.id_nivel=2
							left join $db[tbl_supervisores] s3 on b.id_empresa=s3.id_empresa and b.id_personal=s3.id_personal and s3.id_nivel=3
							left join $db[tbl_supervisores] s4 on b.id_empresa=s4.id_empresa and b.id_personal=s4.id_personal and s4.id_nivel=4
							left join $db[tbl_supervisores] s5 on b.id_empresa=s5.id_empresa and b.id_personal=s5.id_personal and s5.id_nivel=5
			               WHERE 1 AND n1.estatus=1 AND n2.estatus IS NULL AND n3.estatus IS NULL AND n4.estatus IS NULL AND n5.estatus IS NULL AND d.id_autorizacion_nomina IS NULL
			               $filtro 			               
			               $grupo 
			               $orden;";
	               // dump_var($sql);
	               $resultado = SQLQuery($sql);
	               $resultado = (count($resultado)) ? $resultado : false ;
	}
	return $resultado;
}
/*Fin2*/


/**
* Autorización nivel 3
*/
function select_autorizacion_3($data=array()){
/**
* Listado de autorizaciones nivel 3
*/
	$resultado = false;
	if($data[auth]){
	               global $db, $usuario;
	               $id_horas_extra = (is_array($data[id_horas_extra]))?implode(',',$data[id_horas_extra]):$data[id_horas_extra];
	               $id_personal    = (is_array($data[id_personal]))?implode(',',$data[id_personal]):$data[id_personal];
	                $empleado_num  = (is_array($data[empleado_num]))?implode(',',$data[empleado_num]):$data[empleado_num];
	               $id_usuario     = (is_array($data[id_usuario]))?implode(',',$data[id_usuario]):$data[id_usuario];
	               $grupo          = (is_array($data[grupo]))?implode(',',$data[grupo]):$data[grupo];
	               $orden          = (is_array($data[orden]))?implode(',',$data[orden]):$data[orden];
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
	               $grupo  = ($grupo)?"GROUP BY $grupo":"GROUP BY a.id_horas_extra";
	               $orden  = ($orden)?"ORDER BY $orden":"ORDER BY a.id_horas_extra ASC";                      
	               $sql = "SELECT 
								 a.id_horas_extra
								,a.id_empresa
								,c.nombre as empresa
								,b.estado
								,b.sucursal_nomina as sucursal
								,b.sucursal as localidad
								,b.puesto
								,a.id_personal
								,CONCAT(b.nombre,' ',IFNULL(b.paterno,''),' ',IFNULL(b.materno,'')) as nombre_completo
								,b.empleado_num
								,a.fecha
								,DATE_FORMAT(a.horas,'%H:%i') as horas
								,DATE_FORMAT(n2.horas,'%H:%i') as n2_horas
								,a.semana_iso8601
								,n1.estatus AS n1_estatus
								,n1.id_usuario AS n1_id_usuario
								,n1.timestamp AS n1_fecha
							FROM $db[tbl_horas_extra] a
							LEFT JOIN $db[tbl_personal] b ON a.id_empresa=b.id_empresa AND a.id_personal=b.id_personal
							LEFT JOIN $db[tbl_empresas] c ON a.id_empresa=c.id_empresa
							LEFT JOIN $db[tbl_autorizaciones_nomina] d ON a.id_horas_extra=d.id_horas_extra
							LEFT JOIN (SELECT a.* FROM (SELECT * FROM $db[tbl_autorizaciones] ORDER BY timestamp DESC, id_cat_autorizacion DESC) a GROUP BY a.id_horas_extra) AS n1 ON a.id_horas_extra=n1.id_horas_extra AND n1.id_cat_autorizacion=1
							LEFT JOIN (SELECT a.* FROM (SELECT * FROM $db[tbl_autorizaciones] ORDER BY timestamp DESC, id_cat_autorizacion DESC) a GROUP BY a.id_horas_extra) AS n2 ON a.id_horas_extra=n2.id_horas_extra AND n2.id_cat_autorizacion=2
							LEFT JOIN (SELECT a.* FROM (SELECT * FROM $db[tbl_autorizaciones] ORDER BY timestamp DESC, id_cat_autorizacion DESC) a GROUP BY a.id_horas_extra) AS n3 ON a.id_horas_extra=n3.id_horas_extra AND n3.id_cat_autorizacion=3
							LEFT JOIN (SELECT a.* FROM (SELECT * FROM $db[tbl_autorizaciones] ORDER BY timestamp DESC, id_cat_autorizacion DESC) a GROUP BY a.id_horas_extra) AS n4 ON a.id_horas_extra=n4.id_horas_extra AND n4.id_cat_autorizacion=4
							LEFT JOIN (SELECT a.* FROM (SELECT * FROM $db[tbl_autorizaciones] ORDER BY timestamp DESC, id_cat_autorizacion DESC) a GROUP BY a.id_horas_extra) AS n5 ON a.id_horas_extra=n5.id_horas_extra AND n5.id_cat_autorizacion=5
							left join $db[tbl_supervisores] s1 on b.id_empresa=s1.id_empresa and b.id_personal=s1.id_personal and s1.id_nivel=1
							left join $db[tbl_supervisores] s2 on b.id_empresa=s2.id_empresa and b.id_personal=s2.id_personal and s2.id_nivel=2
							left join $db[tbl_supervisores] s3 on b.id_empresa=s3.id_empresa and b.id_personal=s3.id_personal and s3.id_nivel=3
							left join $db[tbl_supervisores] s4 on b.id_empresa=s4.id_empresa and b.id_personal=s4.id_personal and s4.id_nivel=4
							left join $db[tbl_supervisores] s5 on b.id_empresa=s5.id_empresa and b.id_personal=s5.id_personal and s5.id_nivel=5
			               WHERE 1 AND n2.estatus=1 AND n3.estatus IS NULL AND n4.estatus IS NULL AND n5.estatus IS NULL AND d.id_autorizacion_nomina IS NULL
			               $filtro 			               
			               $grupo 
			               $orden;";
	               // dump_var($sql);
	               $resultado = SQLQuery($sql);
	               $resultado = (count($resultado)) ? $resultado : false ;
	}
	return $resultado;
}
/*Fin3*/


/**
* Autorización nivel 4
*/
function select_autorizacion_4($data=array()){
/**
* Listado de autorizaciones nivel 4
*/
	$resultado = false;
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
					,30 => "and a.id_empresa='$usuario[id_empresa]' and (s4.id_supervisor='$usuario[id_personal]' or s5.id_supervisor='$usuario[id_personal]')"
					,34 => "and a.id_empresa='$usuario[id_empresa]' and s4.id_supervisor='$usuario[id_personal]'"
					,35 => "and a.id_empresa='$usuario[id_empresa]' and s4.id_supervisor='$usuario[id_personal]'"
					,40 => "and a.id_empresa='$usuario[id_empresa]' and s4.id_supervisor='$usuario[id_personal]'"
					,50 => "and a.id_empresa='$usuario[id_empresa]' and s4.id_supervisor='$usuario[id_personal]'"
					,60 => "and a.id_empresa='$usuario[id_empresa]' and a.id_usuario='$usuario[id_usuario]'"
                ));
		$filtro.= ($id_horas_extra)?" and a.id_horas_extra IN ($id_horas_extra)":'';
		$filtro.= ($id_personal)?" and a.id_personal IN ($id_personal)":'';
		$filtro.= ($empleado_num)?" and b.empleado_num IN ($empleado_num)":'';		
		$filtro.= ($activo)?" and n3.activo IN ($activo)":'';
		$filtro.= ($id_usuario)?" and a.id_usuario IN ($id_usuario)":'';
		$grupo 	= ($grupo)?"GROUP BY $grupo":"GROUP BY a.id_horas_extra";
		$orden 	= ($orden)?"ORDER BY $orden":"ORDER BY a.id_horas_extra ASC";		
		$sql = "SELECT 
					 a.id_horas_extra
					,a.id_empresa
					,c.nombre as empresa
					,b.sucursal
					,a.id_personal
					,b.empleado_num
					,CONCAT(b.nombre,' ',IFNULL(b.paterno,''),' ',IFNULL(b.materno,'')) as nombre_completo
					,a.fecha
					,DATE_FORMAT(a.horas,'%H:%i') as horas
					,a.semana_iso8601
					,n1.estatus AS n1_estatus
					,n1.id_usuario AS n1_id_usuario
					,n1.timestamp AS n1_fecha
					,n2.estatus AS n2_estatus
					,n2.id_usuario AS n2_id_usuario
					,n2.timestamp AS n2_fecha
					,n3.estatus AS n3_estatus
					,n3.id_usuario AS n3_id_estatus
					,n3.timestamp AS n3_fecha
					,n4.estatus AS n4_estatus
					,n4.id_usuario AS n4_id_usuario
					,n4.timestamp AS n4_fecha
					,DATE_FORMAT(n1.h_dobles,'%H:%i') as dobles
					,DATE_FORMAT(n1.h_triples,'%H:%i') as triples
					,DATE_FORMAT(n1.h_rechazadas,'%H:%i') as rechazadas
				FROM $db[tbl_horas_extra] a
				LEFT JOIN $db[tbl_personal] b ON a.id_empresa=b.id_empresa AND a.id_personal=b.id_personal
				LEFT JOIN $db[tbl_empresas] c ON a.id_empresa=c.id_empresa
				LEFT JOIN $db[tbl_autorizaciones] AS n1 ON a.id_horas_extra=n1.id_horas_extra AND n1.id_cat_autorizacion=1
				LEFT JOIN $db[tbl_autorizaciones] AS n2 ON a.id_horas_extra=n2.id_horas_extra AND n2.id_cat_autorizacion=2
				LEFT JOIN $db[tbl_autorizaciones] AS n3 ON a.id_horas_extra=n3.id_horas_extra AND n3.id_cat_autorizacion=3
				LEFT JOIN $db[tbl_autorizaciones] AS n4 ON a.id_horas_extra=n4.id_horas_extra AND n4.id_cat_autorizacion=4 
				left join $db[tbl_supervisores] s1 on b.id_empresa=s1.id_empresa and b.id_personal=s1.id_personal and s1.id_nivel=1
				left join $db[tbl_supervisores] s2 on b.id_empresa=s2.id_empresa and b.id_personal=s2.id_personal and s2.id_nivel=2
				left join $db[tbl_supervisores] s3 on b.id_empresa=s3.id_empresa and b.id_personal=s3.id_personal and s3.id_nivel=3
				left join $db[tbl_supervisores] s4 on b.id_empresa=s4.id_empresa and b.id_personal=s4.id_personal and s4.id_nivel=4
				left join $db[tbl_supervisores] s5 on b.id_empresa=s5.id_empresa and b.id_personal=s5.id_personal and s5.id_nivel=5
				WHERE 1 $filtro AND n3.estatus=1 AND n4.estatus IS NULL
				$grupo 
				$orden;";
				// dump_var($sql);
		$resultado = SQLQuery($sql);
		$resultado = (count($resultado)) ? $resultado : false ;
	}
	return $resultado;
}
function insert_autorizacion_4($data=array()){
/**
* Inserta registros autorizados de nivel 4
*/
	$resultado = false;	
	if($data[auth]){		
		global $db, $usuario;
		$id_horas_extra 	 = $data[id_horas_extra];
		$id_cat_autorizacion = 4;
		$estatus 			 = $data[estatus];
		$argumento			 =	$data[argumento];
		$timestamp 			 = date('Y-m-d H:i:s');

		$sql = "INSERT INTO $db[tbl_autorizaciones] SET
					id_horas_extra 		= '$id_horas_extra',
					id_cat_autorizacion = '$id_cat_autorizacion',
					estatus 			= '$estatus',
					id_usuario 			= '$usuario[id_usuario]',
					argumento 			= '$argumento',
					timestamp 			= '$timestamp'
					;";
		$resultado = (SQLDo($sql))?true:false;
	}
	return $resultado;
}
/*Fin4*/


/**
* Autorización nivel 5
*/
function select_autorizacion_5($data=array()){
/**
* Listado de autorizaciones nivel 5
*/
	$resultado = false;
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
					,30 => "and a.id_empresa='$usuario[id_empresa]' and s5.id_supervisor='$usuario[id_personal]'"
					,34 => "and a.id_empresa='$usuario[id_empresa]' and s5.id_supervisor='$usuario[id_personal]'"
					,35 => "and a.id_empresa='$usuario[id_empresa]' and s5.id_supervisor='$usuario[id_personal]'"
					,40 => "and a.id_empresa='$usuario[id_empresa]' and s5.id_supervisor='$usuario[id_personal]'"
					,50 => "and a.id_empresa='$usuario[id_empresa]' and s5.id_supervisor='$usuario[id_personal]'"
					,60 => "and a.id_empresa='$usuario[id_empresa]' and a.id_usuario='$usuario[id_usuario]'"
                ));
		$filtro.= ($id_horas_extra)?" and a.id_horas_extra IN ($id_horas_extra)":'';
		$filtro.= ($id_personal)?" and a.id_personal IN ($id_personal)":'';
		$filtro.= ($empleado_num)?" and b.empleado_num IN ($empleado_num)":'';		
		$filtro.= ($activo)?" and n4.activo IN ($activo)":'';
		$filtro.= ($id_usuario)?" and a.id_usuario IN ($id_usuario)":'';
		$grupo 	= ($grupo)?"GROUP BY $grupo":"GROUP BY a.id_horas_extra";
		$orden 	= ($orden)?"ORDER BY $orden":"ORDER BY a.id_horas_extra ASC";		
		$sql = "SELECT 
					 a.id_horas_extra
					,a.id_empresa
					,c.nombre as empresa
					,b.sucursal
					,a.id_personal
					,b.empleado_num
					,CONCAT(b.nombre,' ',IFNULL(b.paterno,''),' ',IFNULL(b.materno,'')) as nombre_completo
					,a.fecha
					,DATE_FORMAT(a.horas,'%H:%i') as horas
					,a.semana_iso8601
					,n1.estatus AS n1_estatus
					,n1.id_usuario AS n1_id_usuario
					,n1.timestamp AS n1_fecha
					,n2.estatus AS n2_estatus
					,n2.id_usuario AS n2_id_usuario
					,n2.timestamp AS n2_fecha
					,n3.estatus AS n3_estatus
					,n3.id_usuario AS n3_id_estatus
					,n3.timestamp AS n3_fecha
					,n4.estatus AS n4_estatus
					,n4.id_usuario AS n4_id_usuario
					,n4.timestamp AS n4_fecha
					,n5.estatus AS n5_estatus
					,n5.id_usuario AS n5_id_usuario
					,n5.timestamp AS n5_fecha
					,DATE_FORMAT(n1.h_dobles,'%H:%i') as dobles
					,DATE_FORMAT(n1.h_triples,'%H:%i') as triples
					,DATE_FORMAT(n1.h_rechazadas,'%H:%i') as rechazadas
				FROM $db[tbl_horas_extra] a
				LEFT JOIN $db[tbl_personal] b ON a.id_empresa=b.id_empresa AND a.id_personal=b.id_personal
				LEFT JOIN $db[tbl_empresas] c ON a.id_empresa=c.id_empresa
				LEFT JOIN $db[tbl_autorizaciones] AS n1 ON a.id_horas_extra=n1.id_horas_extra AND n1.id_cat_autorizacion=1
				LEFT JOIN $db[tbl_autorizaciones] AS n2 ON a.id_horas_extra=n2.id_horas_extra AND n2.id_cat_autorizacion=2
				LEFT JOIN $db[tbl_autorizaciones] AS n3 ON a.id_horas_extra=n3.id_horas_extra AND n3.id_cat_autorizacion=3
				LEFT JOIN $db[tbl_autorizaciones] AS n4 ON a.id_horas_extra=n4.id_horas_extra AND n4.id_cat_autorizacion=4
				LEFT JOIN $db[tbl_autorizaciones] AS n5 ON a.id_horas_extra=n5.id_horas_extra AND n5.id_cat_autorizacion=5
				left join $db[tbl_supervisores] s1 on b.id_empresa=s1.id_empresa and b.id_personal=s1.id_personal and s1.id_nivel=1
				left join $db[tbl_supervisores] s2 on b.id_empresa=s2.id_empresa and b.id_personal=s2.id_personal and s2.id_nivel=2
				left join $db[tbl_supervisores] s3 on b.id_empresa=s3.id_empresa and b.id_personal=s3.id_personal and s3.id_nivel=3
				left join $db[tbl_supervisores] s4 on b.id_empresa=s4.id_empresa and b.id_personal=s4.id_personal and s4.id_nivel=4
				left join $db[tbl_supervisores] s5 on b.id_empresa=s5.id_empresa and b.id_personal=s5.id_personal and s5.id_nivel=5
				WHERE 1 $filtro AND n4.estatus=1 AND n5.estatus IS NULL
				$grupo 
				$orden;";
				// dump_var($sql);
		$resultado = SQLQuery($sql);
		$resultado = (count($resultado)) ? $resultado : false ;
	}
	return $resultado;
}
function insert_autorizacion_5($data=array()){
/**
* Inserta registros autorizados de nivel 5
*/
	$resultado = false;	
	if($data[auth]){		
		global $db, $usuario;
		$id_horas_extra 	 = $data[id_horas_extra];
		$id_cat_autorizacion = 5;
		$estatus 			 = $data[estatus];
		$argumento			 =	$data[argumento];
		$timestamp 			 = date('Y-m-d H:i:s');
		$sql = "INSERT INTO $db[tbl_autorizaciones] SET
					id_horas_extra 		= '$id_horas_extra',
					id_cat_autorizacion = '$id_cat_autorizacion',
					estatus 			= '$estatus',
					id_usuario 			= '$usuario[id_usuario]',
					argumento 			= '$argumento',
					timestamp 			= '$timestamp'
					;";
		$resultado = (SQLDo($sql))?true:false;
	}
	return $resultado;
}
/*Fin5*/

// EMAIL
function select_correos_autorizaciones($data=array()){
/**
* Listado de autorizaciones nivel 1
*/
	$resultado = false;
	if($data[auth]){
	               global $db, $usuario;
	               $id_horas_extra = (is_array($data[id_horas_extra]))?implode(',',$data[id_horas_extra]):$data[id_horas_extra];
	               $id_personal    = (is_array($data[id_personal]))?implode(',',$data[id_personal]):$data[id_personal];
	                $empleado_num  = (is_array($data[empleado_num]))?implode(',',$data[empleado_num]):$data[empleado_num];
	               $id_usuario     = (is_array($data[id_usuario]))?implode(',',$data[id_usuario]):$data[id_usuario];
	               $grupo          = (is_array($data[grupo]))?implode(',',$data[grupo]):$data[grupo];
	               $orden          = (is_array($data[orden]))?implode(',',$data[orden]):$data[orden];
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
	               $grupo  = ($grupo)?"GROUP BY $grupo":"GROUP BY a.id_horas_extra";
	               $orden  = ($orden)?"ORDER BY $orden":"ORDER BY a.id_horas_extra ASC";                      
	               $sql = "SELECT 
								 a.id_horas_extra
								,a.id_empresa
								,c.nombre as empresa
								,a.id_personal
								,CONCAT(b.nombre,' ',IFNULL(b.paterno,''),' ',IFNULL(b.materno,'')) as nombre_completo
								,b.empleado_num
								,a.fecha
								,a.horas
								,a.semana_iso8601
								,b.email
								,s1p.email as s1_email
								,CONCAT(s1p.nombre,' ',IFNULL(s1p.paterno,''),' ',IFNULL(s1p.materno,'')) as s1_nombre_completo
								,s2p.email as s2_email
								,CONCAT(s2p.nombre,' ',IFNULL(s2p.paterno,''),' ',IFNULL(s2p.materno,'')) as s2_nombre_completo
								,s3p.email as s3_email
								,CONCAT(s3p.nombre,' ',IFNULL(s3p.paterno,''),' ',IFNULL(s3p.materno,'')) as s3_nombre_completo
								,s4p.email as s4_email
								,CONCAT(s4p.nombre,' ',IFNULL(s4p.paterno,''),' ',IFNULL(s4p.materno,'')) as s4_nombre_completo
								,s5p.email as s5_email
								,CONCAT(s5p.nombre,' ',IFNULL(s5p.paterno,''),' ',IFNULL(s5p.materno,'')) as s5_nombre_completo
							FROM $db[tbl_horas_extra] a
							LEFT JOIN $db[tbl_personal] b ON a.id_empresa=b.id_empresa AND a.id_personal=b.id_personal
							LEFT JOIN $db[tbl_empresas] c ON a.id_empresa=c.id_empresa
							LEFT JOIN $db[tbl_autorizaciones] AS n1 ON a.id_horas_extra=n1.id_horas_extra AND n1.id_cat_autorizacion=1							
							left join $db[tbl_supervisores] s1 on b.id_empresa=s1.id_empresa and b.id_personal=s1.id_personal and s1.id_nivel=1
							left join $db[tbl_personal] s1p on s1.id_supervisor=s1p.id_personal
							left join $db[tbl_supervisores] s2 on b.id_empresa=s2.id_empresa and b.id_personal=s2.id_personal and s2.id_nivel=2
							left join $db[tbl_personal] s2p on s2.id_supervisor=s2p.id_personal
							left join $db[tbl_supervisores] s3 on b.id_empresa=s3.id_empresa and b.id_personal=s3.id_personal and s3.id_nivel=3
							left join $db[tbl_personal] s3p on s3.id_supervisor=s3p.id_personal
							left join $db[tbl_supervisores] s4 on b.id_empresa=s4.id_empresa and b.id_personal=s4.id_personal and s4.id_nivel=4
							left join $db[tbl_personal] s4p on s4.id_supervisor=s4p.id_personal
							left join $db[tbl_supervisores] s5 on b.id_empresa=s5.id_empresa and b.id_personal=s5.id_personal and s5.id_nivel=5
							left join $db[tbl_personal] s5p on s5.id_supervisor=s5p.id_personal
			               WHERE 1 
			               $filtro 			               
			               $grupo 
			               $orden;";
	               $resultado = SQLQuery($sql);
	               $resultado = (count($resultado)) ? $resultado : false ;
	}
	return $resultado;
}
function select_data_autorizaciones($data=array()){
/**
* Listado de autorizaciones nivel 5
*/
	$resultado = false;
	if($data[auth]){
		global $db, $usuario;
		$id_horas_extra = (is_array($data[id_horas_extra]))?implode(',',$data[id_horas_extra]):$data[id_horas_extra];
		$id_nivel 		= (is_array($data[id_nivel]))?implode(',',$data[id_nivel]):$data[id_nivel];
		$grupo 			= (is_array($data[grupo]))?implode(',',$data[grupo]):$data[grupo];
		$orden 			= (is_array($data[orden]))?implode(',',$data[orden]):$data[orden];
		$filtro.= ($id_horas_extra)?" and a.id_horas_extra IN ($id_horas_extra)":'';
		$filtro.= ($id_nivel)?" and d.id_cat_autorizacion IN ($id_nivel)":'';
		$grupo 	= ($grupo)?"GROUP BY $grupo":"GROUP BY tbl2.id_horas_extra";
		$orden 	= ($orden)?"ORDER BY $orden":"ORDER BY tbl2.id_horas_extra ASC";		
		$sql = "SELECT tbl2.* FROM 
					(SELECT tbl1.* FROM 
						(SELECT 
					 a.id_horas_extra
					,a.id_empresa					
					,a.id_personal
					,c.nombre as empresa
					,b.sucursal
					,CONCAT(b.nombre,' ',IFNULL(b.paterno,''),' ',IFNULL(b.materno,'')) as nombre_completo
					,b.empleado_num
					,a.fecha
					,DATE_FORMAT(a.horas,'%H:%i') as horas
					,DATE_FORMAT(d.horas,'%H:%i') as tiempoextra
					,d.h_rechazadas 
					,d.h_dobles 
					,d.h_triples 
					,d.argumento
		 			,d.timestamp
		 			,IF(d.estatus=1,'AUTORIZADO','NO AUTORIZADO') as estatus
					,a.semana_iso8601
					,b.nombre AS capturado_por
					,a.timestamp AS capturado_el
					,d.id_cat_autorizacion as nivel
					,d.estatus AS n1_estatus
					,d.id_usuario AS n1_id_usuario
					,d.timestamp AS n1_fecha
					,CONCAT(f.nombre,' ',IFNULL(f.paterno,''),' ',IFNULL(f.materno,''), ' - ',f.puesto) as supervisor
				FROM $db[tbl_horas_extra] a
				LEFT JOIN $db[tbl_personal] b ON a.id_empresa=b.id_empresa AND a.id_personal=b.id_personal
				LEFT JOIN $db[tbl_empresas] c ON a.id_empresa=c.id_empresa
				LEFT JOIN $db[tbl_autorizaciones] d ON a.id_horas_extra=d.id_horas_extra
				LEFT JOIN $db[tbl_usuarios] e on d.id_usuario=e.id_usuario
				LEFT JOIN $db[tbl_personal] f ON e.id_personal=f.id_personal
				left join he_supervisores s1 on b.id_empresa=s1.id_empresa and b.id_personal=s1.id_personal and s1.id_nivel=1
				left join he_supervisores s2 on b.id_empresa=s2.id_empresa and b.id_personal=s2.id_personal and s2.id_nivel=2
				left join he_supervisores s3 on b.id_empresa=s3.id_empresa and b.id_personal=s3.id_personal and s3.id_nivel=3
				left join he_supervisores s4 on b.id_empresa=s4.id_empresa and b.id_personal=s4.id_personal and s4.id_nivel=4
				left join he_supervisores s5 on b.id_empresa=s5.id_empresa and b.id_personal=s5.id_personal and s5.id_nivel=5  
			   WHERE 1
			   		$filtro 
			   	ORDER BY d.id_cat_autorizacion DESC, d.timestamp DESC
					)tbl1
				)tbl2
			   		$grupo 
					$orden;";
		$resultado = SQLQuery($sql);
		$resultado = (count($resultado)) ? $resultado : false ;
	}
	return $resultado;
}
/*O3M*/
?>