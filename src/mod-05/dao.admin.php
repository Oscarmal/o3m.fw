<?php session_name('o3m_fw'); session_start(); if(isset($_SESSION['header_path'])){include_once($_SESSION['header_path']);}else{header('location: '.dirname(__FILE__));}
// require_once($Raiz[local].$cfg[php_postgres]);
/**
* 				Funciones "DAO"
* Descripcion:	Ejecuta consultas SQL y devuelve el resultado.
* Creación:		2014-08-27
* @author 		Oscar Maldonado
*/
set_time_limit(0);
function select_view_nomina($data=array()){
	if($data[auth]){
		global $db, $usuario;
		$id_nomina = (is_array($data[id_nomina]))?implode(',',$data[id_nomina]):$data[id_nomina];
		$id_empresa = (is_array($data[id_empresa]))?implode(',',$data[id_empresa]):$data[id_empresa];
		$id_number = (is_array($data[id_number]))?implode(',',$data[id_number]):$data[id_number];
		//$activo = (is_array($data[activo]))?implode(',',$data[activo]):$data[activo];
		$grupo 			= (is_array($data[grupo]))?implode(',',$data[grupo]):$data[grupo];
		$orden 			= (is_array($data[orden]))?implode(',',$data[orden]):$data[orden];
		$filtro.=filtro_grupo(array(
					 10 => ''
					,20 => "and c.id_empresa='$usuario[id_empresa]'"
					,30 => "and c.id_empresa='$usuario[id_empresa]'"
					,40 => "and c.id_empresa='$usuario[id_empresa]'"
					,50 => "and c.id_empresa='$usuario[id_empresa]'"
					,60 => "and c.id_personal='$usuario[id_personal]'"
				));
		$filtro.= ($id_nomina)?" and c.id_nomina IN ($id_nomina)":'';
		$filtro.= ($id_empresa)?" and c.id_empresa IN ($id_empresa)":'';
		// $filtro.= ($id_number)?" and a.id_number IN ($id_number)":'';
		//$filtro.= ($activo)?" and b.activo IN ($activo)":'';
		$desc 	= ($desc)?" DESC":' ASC';
		$orden 	= ($orden)?"ORDER BY $orden".$desc:'ORDER BY c.id_empresa, c.empleado_num'.$desc;		

		$sql="SELECT 
				/*IF(a.id_empresa is null, c.id_nomina,a.id_empresa) as id_empresa
				,IF(a.id_number is null, c.empleado_num,a.id_number) as id_number
				,CONCAT(IFNULL(c.nombre,''),' ', IFNULL(c.paterno,''),' ',IFNULL(c.materno,'')) as nombre
				,c.timestamp as fecha_corte
				,c.id_personal
				,a.position
				,a.area
				,a.rfc
				,a.imss
				,a.ingreso
				,IF(a.empresa is null, b.nombre,a.empresa) as empresa
				,IF(a.empresa_razon_social is null, b.nombre,a.empresa_razon_social) as empresa_razon_social
				,a.id_empleado
				,c.empleado_num
				,b.id_empresa as id_he_empresa
				FROM 
					$db[tbl_personal] c
				LEFT JOIN 
					$db[view_nomina] a 
						ON c.id_nomina=a.id_view_nomina
				LEFT JOIN 
					$db[tbl_empresas] b 
						ON a.id_empresa=b.id_empresa */
				 c.id_personal
				,b.id_nomina as id_empresa
				,c.id_nomina
				,c.empleado_num
				,CONCAT(IFNULL(c.nombre,''),' ', IFNULL(c.paterno,''),' ',IFNULL(c.materno,'')) as nombre
				,c.timestamp as fecha_corte
				,c.puesto
				,c.sucursal
				,c.rfc
				,c.imss
				,b.razon as empresa
				FROM $db[tbl_personal] c				
				LEFT JOIN $db[tbl_empresas] b ON c.id_empresa=b.id_empresa
				LEFT JOIN $db[tbl_usuarios] d ON c.id_personal=d.id_personal
				WHERE 1 AND d.activo=1 AND c.activo=1 $filtro 
				$grupo $orden ;";
		// dump_var($sql);
		$resultado = SQLQuery($sql);				

		$resultado = (count($resultado)) ? $resultado : false ;
	}else{
		$resultado = false;
	}
	return $resultado;
}
function select_view_vista_credenciales($filtrado,$id_empresa){
	global $db, $usuario;
	///consulta para que traiga solo a chrysler
	$filtro = ($usuario[id_grupo]>=20)?"WHERE id_empresa in ($id_empresa)":'';
		$sql="SELECT 
				* 
			FROM 
				$db[pgsql_vista_credenciales]
			$filtro
				;";
		//echo $sql;
		$resultado = pgquery($sql);
		$resultado = (count($resultado)) ? $resultado : false ;
	
	return $resultado;
}
/*O3M*/
function insert_sincronizacion_update(){
	global $db, $usuario, $var;
	
		$sql="INSERT INTO
				$db[tbl_personal] 
					(nombre, paterno, materno, email, rfc,imss,sucursal,puesto,empleado_num,id_empresa,timestamp,id_usuario, id_nomina, estado, sucursal_nomina)
						(
						SELECT 	
							$db[view_nomina].nombre_empleado,
							$db[view_nomina].apellido_paterno_empleado,
							$db[view_nomina].apellido_materno_empleado,
							LOWER($db[view_nomina].correo_electronico),
							$db[view_nomina].rfc,
							$db[view_nomina].imss,
							$db[view_nomina].area,
							$db[view_nomina].position,
							$db[view_nomina].id_number,
							$db[view_nomina].id_empresa,
							DATE_FORMAT(now(),'%Y-%m-%d %h:%i:%s') as timestamp,
							$usuario[id_usuario]
							,$db[view_nomina].id_empleado
							,$db[view_nomina].estado
							,$db[view_nomina].sucursal
						FROM 
						 	$db[view_nomina] 
						LEFT JOIN
							$db[tbl_empresas]
							ON 
								$db[view_nomina].id_empresa = $db[tbl_empresas].id_nomina
						LEFT JOIN
							$db[tbl_personal]
							ON
								$db[view_nomina].id_number = $db[tbl_personal].id_nomina	
							AND 
								$db[view_nomina].id_empresa = $db[tbl_personal].id_empresa	
						WHERE 	
							$db[tbl_personal].id_personal is NULL
						)
					;";
		
		$id_personal = SQLDo($sql);

		// Actualiza datos modificados en vista de nomina
		$sql_update = "UPDATE $db[tbl_personal] a
						LEFT JOIN $db[view_nomina] b on a.id_nomina=b.id_empleado
						SET 
							 a.estado=b.estado
							,a.sucursal_nomina=b.sucursal
							/*,a.empleado_num=b.id_number*/
							,a.nombre=b.nombre_empleado
							,a.paterno=b.apellido_paterno_empleado
							,a.materno=b.apellido_materno_empleado
							/*,a.email=LOWER(b.correo_electronico)*/
							,a.sucursal=b.area
							,a.puesto=b.position
						WHERE b.id_view_nomina is not null
				;";
		$update_data = SQLDo($sql_update);

		// Desactiva empleados que ya no estan en la vista
		$sql_desactivar = "UPDATE $db[tbl_personal] a 
					LEFT JOIN $db[view_nomina] b ON b.id_empleado=a.id_nomina
					LEFT JOIN $db[tbl_usuarios] c on a.id_personal=c.id_personal
					LEFT JOIN $db[tbl_grupos] d on c.id_grupo=d.id_grupo
					SET a.activo=0
					WHERE a.id_empresa='$usuario[id_empresa]' and a.id_personal>10 and d.grupo='empleados' and b.id_empleado IS NULL 
					;";
					// dump_var($sql);
		$update_desactivar = SQLDo($sql_desactivar);

		// Crea usuario
		$sql2="INSERT INTO 
					 $db[tbl_usuarios]
				(usuario,clave,id_personal,timestamp)
					SELECT 
						 empleado_num as usuario
						,md5(empleado_num) as clave
						,id_personal
						,DATE_FORMAT(now(),'%Y-%m-%d %h:%i:%s') as timestamp
					FROM $db[tbl_personal] a
					LEFT JOIN $db[tbl_usuarios] b USING(id_personal)
					WHERE a.activo=1 and b.id_usuario is null
						;";
							//echo $sql2;
		$resultado = SQLDo($sql2);
		// Crea cadena de supervisión nivel 3
		if($var[id_nivel3] && $resultado){
			$id_nivel 		= 3;
			$id_empresa 	= $usuario[id_empresa];
			$id_supervisor 	= $var[id_nivel3];
			$sql_nivel="INSERT INTO 
				$db[tbl_supervisores]
				(id_empresa,id_personal,id_supervisor,id_nivel,id_usuario,timestamp)
					SELECT 
						 $id_empresa as id_empresa
						,a.id_personal
						,$id_supervisor as id_supervisor
						,$id_nivel as id_nivel
						,$usuario[id_usuario] as id_usuario
						,DATE_FORMAT(now(),'%Y-%m-%d %h:%i:%s') as timestamp
					FROM $db[tbl_personal] a
					LEFT JOIN $db[tbl_supervisores] b ON a.id_personal=b.id_personal AND b.id_nivel='$id_nivel'
					LEFT JOIN $db[tbl_usuarios] c ON a.id_personal=c.id_personal
					WHERE a.activo=1 AND c.id_grupo=60 AND b.id_nivel IS NULL
					GROUP BY a.id_personal
				;";
			$success_nivel = SQLDo($sql_nivel);
		}

		$resultado = (count($resultado)) ? $resultado : false ;
	
	return $resultado;
}
function truncate_vista_nomina(){
	global $db, $usuario;
	$sql="TRUNCATE TABLE $db[view_nomina]";
	$resultado = SQLDo($sql);
		$resultado = (count($resultado)) ? $resultado : false ;
	
	return $resultado;
}
function select_catalgos_empresa(){
	global $db,$usuario;
	
	if($usuario[id_grupo]<=10){
		$sql_alterno='';
	}
	else{
		$sql_alterno="and id_empresa=$usuario[id_empresa]";
	}
	
	$sql="SELECT 
				id_empresa,
				nombre
			FROM 
				$db[tbl_empresas] 
			WHERE 1 and id_empresa>1 AND activo=1
				$sql_alterno
				group by nombre ASC;";
		$resultado = SQLQuery($sql);
		$resultado = (count($resultado)) ? $resultado : false ;
	return $resultado;
}
function select_catalgo_usuarios_grupo(){
	global $db,$usuario;
	$sql="SELECT 
				id_grupo,
				grupo
			FROM 
				$db[tbl_grupos]
			WHERE 
				id_grupo IN (50,40,35,20)
			ORDER BY id_grupo;";
		//echo $sql;
		$resultado = SQLQuery($sql);
		$resultado = (count($resultado)) ? $resultado : false ;
	return $resultado;
}
function insert_nuevo_registro($nombre,$apellido_paterno,$apellido_materno,$correo,$rfc,$nss,$sucursal,$puesto,$no_empleado,$id_empresa,$id_usuario_grupo,$timestamp,$id_nomina){
	global $db, $usuario;

	$sql="INSERT INTO
				$db[tbl_personal]
				(nombre,
				paterno,
				materno,
				rfc,
				imss,
				email,
				sucursal,
				sucursal_nomina,
				puesto,
				empleado_num,
				id_nomina,
				id_empresa,
				timestamp,
				id_usuario)
				values
				('$nombre',
				'$apellido_paterno',
				'$apellido_materno',
				'$rfc',
				'$nss',
				'$correo',
				'$sucursal',
				'$sucursal',
				'$puesto',
				'$no_empleado',
				'$id_nomina',
				'$id_empresa',
				'$timestamp',
				'$usuario[id_usuario]');";
		
		$id_personal = SQLDo($sql);	

		$vUsuario = ($no_empleado)?$no_empleado:$id_nomina;
		$vClave = md5($vUsuario);
		$sql2="INSERT INTO $db[tbl_usuarios] 
				SET
					 usuario 	='$vUsuario'
					,clave 		='$vClave'
					,id_grupo 	='$id_usuario_grupo'
					,id_personal='$id_personal'
					,timestamp 	='$timestamp'
					,activo 	='1';";
		$id_usuario = SQLDo($sql2);
		
		$resultado = (count($id_usuario)) ? $id_usuario : false ;
	return $resultado;
}
function select_empresas_tabla(){
	global $db,$usuario;
	
	$sql="SELECT 
				id_empresa,
				nombre,
				siglas,
				razon,
				timestamp
			FROM 
				$db[tbl_empresas]
			WHERE activo=1;";
		//echo $sql;
		$resultado = SQLQuery($sql);
		$resultado = (count($resultado)) ? $resultado : false ;
	return $resultado;
}
function select_empresas_activas(){
	global $db,$usuario;
	
	$sql="SELECT 
				id_empresa,
				id_nomina,
				nombre,
				siglas,
				razon,
				timestamp
			FROM 
				$db[tbl_empresas]
			WHERE 
				activo = 1";
		//echo $sql;
		$resultado = SQLQuery($sql);
		$resultado = (count($resultado)) ? $resultado : false ;
	return $resultado;
}
function select_empresas_nomina(){
	global $db, $usuario;
		///consulta para que traiga solo a chrysler
		/*$sql="SELECT DISTINCT 
				$db[pgsql_vista_credenciales].id_empresa,
				$db[pgsql_vista_credenciales].empresa,
				$db[pgsql_vista_credenciales].empresa_razon_social
			FROM 
				$db[pgsql_vista_credenciales]
			WHERE
				id_empresa=3082
			ORDER BY 
				$db[pgsql_vista_credenciales].id_empresa;";*/
				//echo $sql;
				$sql="SELECT DISTINCT 
				$db[pgsql_vista_credenciales].id_empresa,
				$db[pgsql_vista_credenciales].empresa,
				$db[pgsql_vista_credenciales].empresa_razon_social
			FROM 
				$db[pgsql_vista_credenciales]
			ORDER BY 
				$db[pgsql_vista_credenciales].id_empresa;";
		$resultado = pgquery($sql);
		$resultado = (count($resultado)) ? $resultado : false ;

	return $resultado;
}
function insert_empresa_nomina_tmp(){
	global $db;

	$sql="INSERT INTO 
			$db[tbl_empresas]
			(nombre,siglas,rfc,razon,direccion,pais,email,timestamp,id_usuario,activo,id_nomina)
		SELECT 
			t.nombre,
			t.siglas,
			t.rfc,
			t.razon,
			t.direccion,
			t.pais,
			t.email,
			t.timestamp,
			t.id_usuario,
			t.activo,
			t.id_nomina
		FROM 
			$db[tbl_tmp_empresas] t
			LEFT JOIN 
				$db[tbl_empresas] e
				ON 
					t.id_nomina=e.id_nomina
			WHERE 
				e.id_nomina is NULL";
		
	$resultado = SQLDo($sql);
		$resultado = (count($resultado)) ? $resultado : false ;
	
	return $resultado;
}
function eliminar_tmp_empresa_nomina(){
	global $db;

	$sql="DROP TABLE IF EXISTS $db[tbl_tmp_empresas];";
	$resultado = SQLDo($sql);
		$resultado = (count($resultado)) ? $resultado : false ;
	
	return $resultado;
}


/**
* Administración - Asignacion de semana
*/
function select_asignar_semana($data=array()){
/**
* Listado de registros autorizados en todos sus niveles
*/
	$resultado = false;
	if($data[auth]){
		global $db, $usuario, $var;
		$nivel_minimo = ($var[nivel_minimo])?$var[nivel_minimo]:1;
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
		$filtro.= ($activo)?" and e.activo IN ($activo)":'';
		$filtro.= ($id_usuario)?" and a.id_usuario IN ($id_usuario)":'';
		$grupo 	= ($grupo)?"GROUP BY $grupo":"GROUP BY tbl1.id_horas_extra";
		$orden 	= ($orden)?"ORDER BY $orden":"ORDER BY tbl1.fecha, tbl1.id_nomina ASC";		
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
						,TIME_FORMAT(e.horas,'%H:%i') as horas
						,TIME_FORMAT(e.h_dobles,'%H:%i') as dobles
						,TIME_FORMAT(e.h_triples,'%H:%i') as triples
						,TIME_FORMAT(e.h_rechazadas,'%H:%i') as rechazadas
						,a.semana_iso8601
						,e.id_cat_autorizacion
					FROM $db[tbl_horas_extra] a
					LEFT JOIN $db[tbl_personal] b ON a.id_empresa=b.id_empresa AND a.id_personal=b.id_personal
					LEFT JOIN $db[tbl_empresas] c ON a.id_empresa=c.id_empresa
					LEFT JOIN $db[tbl_autorizaciones_nomina] d ON a.id_horas_extra=d.id_horas_extra
					/*LEFT JOIN $db[tbl_autorizaciones] e ON a.id_horas_extra=e.id_horas_extra*/
					LEFT JOIN (SELECT a.* FROM (SELECT * FROM he_autorizaciones ORDER BY timestamp DESC, id_cat_autorizacion DESC) a GROUP BY a.id_horas_extra) e ON a.id_horas_extra=e.id_horas_extra
					WHERE 1 $filtro AND a.activo=1 AND e.activo=1 AND d.id_autorizacion_nomina IS NULL and e.id_cat_autorizacion>='$nivel_minimo'
					ORDER BY e.id_cat_autorizacion DESC, e.timestamp DESC
					) as tbl1
					$grupo 
					$orden
					) as tbl2
				WHERE tbl2.estatus=1;";
				// dump_var($sql);
		$resultado = SQLQuery($sql);
		$resultado = (count($resultado)) ? $resultado : false ;
	}
	return $resultado;
}
function select_acumulado_semanal($data=array()){
	if($data[auth]){
		global $db;
		$id_empresa 	= (is_array($data[id_empresa]))?implode(',',$data[id_empresa]):$data[id_empresa];
		$id_personal 	= (is_array($data[id_personal]))?implode(',',$data[id_personal]):$data[id_personal];
		$empleado_num 	= (is_array($data[empleado_num]))?implode(',',$data[empleado_num]):$data[empleado_num];
		$fecha 			= (is_array($data[fecha]))?implode(',',date("Y-m-d", strtotime(str_replace('/', '-', $data[fecha])))):date("Y-m-d", strtotime(str_replace('/', '-', $data[fecha])));
		$semana 	 	= (is_array($data[semana]))?implode(',',$data[semana]):$data[semana];
		$sqlData = array(
			 auth 			=> true
			,fecha 			=> $data[fecha]
			,id_empresa 	=> $data[id_empresa]
			,tipo 			=> 'INCIDENCIAS'
		);
		$periodo = select_detecta_periodo_fecha($sqlData);
		$filtro.= ($id_empresa)?" and a.id_empresa IN ($id_empresa)":'';
		$filtro.= ($id_personal)?" and a.id_personal IN ($id_personal)":'';
		$filtro.= ($empleado_num)?" and b.empleado_num IN ($empleado_num)":'';
		$filtro.= ($periodo)?" and a.fecha BETWEEN '$periodo[inicio]' AND '$periodo[fin]'":'';
		$filtro.= ($semana)?" and e.semana IN ($semana)":'';
		$sql="SELECT 
				 a.id_empresa
				,a.id_personal
				,b.empleado_num
				,CONCAT(b.nombre,' ',IFNULL(b.paterno,''),' ',IFNULL(b.materno,'')) as nombre_completo
				,e.semana
				,COUNT(a.id_horas_extra) AS tot_regs
				,TIME_FORMAT(SEC_TO_TIME(SUM(TIME_TO_SEC(c.horas))),'%H:%i') AS tot_horas
				,TIME_FORMAT(SEC_TO_TIME(SUM(TIME_TO_SEC(e.dobles_horas))),'%H:%i') as dobles_horas
				,TIME_FORMAT(SEC_TO_TIME(SUM(TIME_TO_SEC(e.triples_horas))),'%H:%i') as triples_horas
			FROM $db[tbl_horas_extra] a
			LEFT JOIN $db[tbl_personal] b ON a.id_personal=b.id_personal
			LEFT JOIN (SELECT * FROM 
						(SELECT * FROM $db[tbl_autorizaciones] ORDER BY id_horas_extra ASC, id_cat_autorizacion DESC) AS tbl_aut
							GROUP BY tbl_aut.id_horas_extra) c ON a.id_horas_extra=c.id_horas_extra
			LEFT JOIN he_calendarios d on d.fecha_inicio='$periodo[inicio]' AND d.fecha_inicio='$periodo[fin]'			
			LEFT JOIN(SELECT
									 id_autorizacion_nomina
									,id_horas_extra
									,id_cat_autorizaciones
									,id_concepto
									,anio
									,periodo
									,periodo_especial
									,semana
									,TIME_FORMAT(SEC_TO_TIME(SUM(TIME_TO_SEC(horas))),'%H:%i') as horas
									,TIME_FORMAT(SEC_TO_TIME(SUM(TIME_TO_SEC(IF(id_concepto=2,horas,0)))),'%H:%i') as dobles_horas
									,FORMAT(SUM(IF(id_concepto=2,horas_porcentaje,0)),1) as dobles_porcentaje
									,TIME_FORMAT(SEC_TO_TIME(SUM(TIME_TO_SEC(IF(id_concepto=3,horas,0)))),'%H:%i') as triples_horas
									,FORMAT(SUM(IF(id_concepto=3,horas_porcentaje,0)),1) as triples_porcentaje
									,xls
									,activo
									FROM $db[tbl_autorizaciones_nomina]
									GROUP BY id_horas_extra ASC) e ON a.id_horas_extra=e.id_horas_extra
			WHERE 1 $filtro
				and c.activo=1 and c.horas IS NOT NULL /*AND e.xls IS NULL*/
			GROUP BY a.id_empresa ,a.id_personal, e.semana
			ORDER BY a.fecha ASC;";
			// dump_var($sql);
		$resultado = SQLQuery($sql);
		$resultado = (count($resultado)) ? $resultado : false ;
	}
	return $resultado;
}
function select_detecta_periodo_fecha($data=array()){
	if($data[auth]){
		global $db;
		$id_empresa 	= (is_array($data[id_empresa]))?implode(',',$data[id_empresa]):$data[id_empresa];
		$tipo 			= (is_array($data[tipo]))?implode(',',"'".$data[tipo]."'"):"'".$data[tipo]."'";
		$fecha 			= (is_array($data[fecha]))?implode(',',date("Y-m-d", strtotime(str_replace('/', '-', $data[fecha])))):date("Y-m-d", strtotime(str_replace('/', '-', $data[fecha])));
		$filtro.= ($id_empresa)?" and a.id_empresa IN ($id_empresa)":'';
		$filtro.= ($tipo)?" and a.tipo IN ($tipo)":'';
		$filtro.= ($fecha)?" and (a.fecha_inicio<='$fecha' and a.fecha_fin>='$fecha')":'';
		$sql="SELECT 
				 a.id_empresa
				,a.tipo
				,a.fecha_inicio as inicio
				,a.fecha_fin as fin
			FROM $db[tbl_calendarios] a
			WHERE 1 $filtro
			LIMIT 1;";
			// dump_var($sql);
		$resultado = SQLQuery($sql);
		$resultado = (count($resultado)) ? $resultado : false ;
	}
	return $resultado;
}
function insert_layout($data=array()){
/**
 * Inserta registros autorizados para generar el layout
 */
	$resultado = false;
	if($data[auth]){
		global $db, $usuario;
		$id_horas_extra 	 = $data[id_horas_extra];
		$id_cat_autorizacion = $data[id_cat_autorizacion];
		$anio				 = $data[anio];
		$semana 			 = $data[semana];
		$periodo			 = $data[periodo];
		$periodo_especial	 = $data[periodo_especial];
		// $horas 				 = horas_int($data[horas]);
		$horas 				 = $data[horas];
		$horas_porcentaje	 = $data[horas_porcentaje];
		$id_concepto 		 = $data[id_concepto];		
		$timestamp 			 = date('Y-m-d H:i:s');
		$sql = "INSERT INTO $db[tbl_autorizaciones_nomina] SET
					id_horas_extra 			='$id_horas_extra',
					id_cat_autorizaciones 	= '$id_cat_autorizacion',
					anio 					= '$anio',
					semana 					= '$semana',
					periodo					= '$periodo',
					periodo_especial		= '$periodo_especial',
					horas 					= '$horas',
					horas_porcentaje 		= '$horas_porcentaje',
					id_concepto 			= '$id_concepto',					
					id_usuario 				= '$usuario[id_usuario]',
					timestamp 				= '$timestamp'
					;";
			// dump_var($sql);
		$resultado = (SQLDo($sql))?true:false;
	}
	return $resultado;
}
/*FinLayout*/

/**
* Aministración XLS
*/
function select_xls($data=array()){
/**
* Listado de registros que se incluiran en el XLS
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
		$filtro.= ($activo)?" and d.activo IN ($activo)":'';
		$filtro.= ($id_usuario)?" and a.id_usuario IN ($id_usuario)":'';
		$grupo 	= ($grupo)?"GROUP BY $grupo":"GROUP BY a.id_horas_extra";
		// $orden 	= ($orden)?"ORDER BY $orden":"ORDER BY a.fecha, a.empleado_num ASC";		
		$sql = "SELECT 
					 a.id_horas_extra
					,c.nombre as empresa
					,b.estado
					,b.sucursal_nomina as sucursal
					,b.sucursal as localidad
					,CONCAT(b.nombre,' ',IFNULL(b.paterno,''),' ',IFNULL(b.materno,'')) as nombre_completo
					,b.empleado_num	
					,b.id_nomina				
					,a.fecha		
					,a.timestamp as capturado_el			
					,a.semana_iso8601
					,a.horas as horas_capturadas
					,d.nomina_anio as anio
					,d.nomina_periodo as periodo
					,d.semana
					,TIME_FORMAT(SEC_TO_TIME(TIME_TO_SEC(a.horas)-TIME_TO_SEC(d.horas)),'%H:%i') as rechazadas_horas
					,d.horas as horas_autorizadas
					,d.dobles_horas
					,d.dobles_porcentaje
					,d.triples_horas
					,d.triples_porcentaje
				FROM $db[tbl_horas_extra] a
				LEFT JOIN $db[tbl_personal] b ON a.id_empresa=b.id_empresa AND a.id_personal=b.id_personal
				LEFT JOIN $db[tbl_empresas] c ON a.id_empresa=c.id_empresa				
				LEFT JOIN(SELECT
									 id_autorizacion_nomina
									,id_horas_extra
									,id_cat_autorizaciones
									,anio
									,periodo
									,periodo_especial
									,IF(anio=0 or anio IS NULL, final_anio, anio) as nomina_anio
									,IF(periodo=0 or periodo IS NULL, final_periodo, periodo) as nomina_periodo
									/*,IF(periodo=0 or periodo IS NULL, CONCAT(final_periodo,'-',IFNULL(final_periodo_especial,'')), CONCAT(periodo,'-',IFNULL(periodo_especial,''))) as nomina_periodo*/
									,semana
									,TIME_FORMAT(SEC_TO_TIME(SUM(TIME_TO_SEC(horas))),'%H:%i') as horas
									,TIME_FORMAT(SEC_TO_TIME(SUM(TIME_TO_SEC(IF(id_concepto=2,horas,0)))),'%H:%i') as dobles_horas
									,FORMAT(SUM(IF(id_concepto=2,horas_porcentaje,0)),1) as dobles_porcentaje
									,TIME_FORMAT(SEC_TO_TIME(SUM(TIME_TO_SEC(IF(id_concepto=3,horas,0)))),'%H:%i') as triples_horas
									,FORMAT(SUM(IF(id_concepto=3,horas_porcentaje,0)),1) as triples_porcentaje
									,xls
									,activo
									FROM $db[tbl_autorizaciones_nomina]
									GROUP BY id_horas_extra ASC) d ON a.id_horas_extra=d.id_horas_extra
				WHERE 1 $filtro AND d.id_autorizacion_nomina IS NOT NULL AND d.xls IS NULL
				$grupo 
				ORDER BY a.fecha ASC;";
				// dump_var($sql);
		$resultado = SQLQuery($sql);
		$resultado = (count($resultado)) ? $resultado : false ;
	}
	return $resultado;
}
function select_xls_resumen($data=array()){
/**
* Listado de registros que se incluiran en el XLS-Resumen
*/
	$resultado = false;
	if($data[auth]){
		global $db, $usuario;
		$id_horas_extra = (is_array($data[id_horas_extra]))?implode(',',$data[id_horas_extra]):$data[id_horas_extra];
		$id_personal 	= (is_array($data[id_personal]))?implode(',',$data[id_personal]):$data[id_personal];
		$empleado_num 	= (is_array($data[empleado_num]))?implode(',',$data[empleado_num]):$data[empleado_num];
		$id_usuario		= (is_array($data[id_usuario]))?implode(',',$data[id_usuario]):$data[id_usuario];
		$activo 		= (is_array($data[activo]))?implode(',',$data[activo]):$data[activo];
		$xls 			= (is_array($data[xls]))?implode(',',"'".$data[xls]."'"):"'".$data[xls]."'";
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
		$filtro.= ($empleado_num)?" and d.empleado_num IN ($empleado_num)":'';		
		// $filtro.= ($activo)?" and n4.activo IN ($activo)":'';
		$filtro.= ($id_usuario)?" and a.id_usuario IN ($id_usuario)":'';
		$filtro.= ($xls)?" and c.xls IN ($xls)":'';
		$grupo 	= ($grupo)?"GROUP BY $grupo":"GROUP BY a.id_horas_extra";
		$orden 	= ($orden)?"ORDER BY $orden":"ORDER BY a.id_horas_extra ASC";		
				$sql = "SELECT 
					/* a.id_empresa
					,f.nombre as empresa
					,f.siglas*/					
					 d.id_nomina
					,d.empleado_num as cid
					,CONCAT(d.nombre,' ',IFNULL(d.paterno,''),' ',IFNULL(d.materno,'')) as nombre_completo
					,d.estado
					,d.sucursal_nomina as sucursal
					,d.sucursal as localidad
					,d.puesto
					,c.nomina_anio 
					,c.nomina_periodo
					,c.semana						 
					,a.fecha		
		 			,'dia' as dia
					,IF(a.activo=1,a.horas,0) as capturadas_horas
					,FORMAT(IF(a.activo=1,TIME_TO_SEC(a.horas),0)/3600,2) as capturadas_porcentaje
					,SEC_TO_TIME(IF(a.activo=1,TIME_TO_SEC(a.horas),0) - IF(a.activo=1 AND b.activo=1 AND b.estatus=1,TIME_TO_SEC(b.horas),0)) as rechazadas_horas
					,FORMAT((IF(a.activo=1,TIME_TO_SEC(a.horas),0) - IF(a.activo=1 AND b.activo=1 AND b.estatus=1,TIME_TO_SEC(b.horas),0))/3600,2) as rechazadas_porcentaje
					,IF(a.activo=1 AND b.activo=1 AND b.estatus=1,b.horas,0) as autorizadas_horas
					,FORMAT(IF(a.activo=1 AND b.activo=1 AND b.estatus=1,TIME_TO_SEC(b.horas),0)/3600,2) as autorizadas_porcentaje
					,SEC_TO_TIME(TIME_TO_SEC(c.dobles_horas) + TIME_TO_SEC(c.triples_horas)) as pagadas_horas
					,FORMAT((TIME_TO_SEC(c.dobles_horas) + TIME_TO_SEC(c.triples_horas))/3600,2) as pagadas_porcentaje
					,c.dobles_horas
					,c.dobles_porcentaje
					,c.triples_horas
					,c.triples_porcentaje
					,a.id_horas_extra
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
				WHERE 1 AND a.activo=1 AND b.activo=1 AND c.activo=1 AND c.xls IS NOT NULL $filtro
				GROUP BY a.id_horas_extra
				ORDER BY a.id_empresa, c.nomina_anio, c.nomina_periodo, d.nombre, d.paterno, d.materno , a.fecha ASC
				;";
				// dump_var($sql);
		$resultado = SQLQuery($sql);
		$resultado = (count($resultado)) ? $resultado : false ;
	}
	return $resultado;
}
function select_xls_nomina($data=array()){
/**
* Listado de registros que se incluiran en el XLS-Resumen
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
		$sql = "SELECT 
					 /*c.id_nomina as id_empresa,*/
					 b.id_nomina as id_empleado
					,d.semana
					,e.clave as id_concepto
					/*,TIME_FORMAT(d.horas,'%H') as horas*/
					,SUM(d.horas_porcentaje) as horas
				FROM $db[tbl_horas_extra] a
				LEFT JOIN $db[tbl_personal] b ON a.id_empresa=b.id_empresa AND a.id_personal=b.id_personal
				LEFT JOIN $db[tbl_empresas] c ON a.id_empresa=c.id_empresa
				LEFT JOIN $db[tbl_autorizaciones_nomina] d ON a.id_horas_extra=d.id_horas_extra
				LEFT JOIN $db[tbl_conceptos] e ON d.id_concepto=e.id_concepto
				WHERE 1 $filtro AND d.id_autorizacion_nomina IS NOT NULL AND d.xls IS NULL AND d.id_concepto>0
				GROUP BY b.id_nomina, d.semana, e.clave
				;";
		$resultado = SQLQuery($sql);
		$resultado = (count($resultado)) ? $resultado : false ;
	}
	return $resultado;
}
function update_xls($data=array()){
	// Actualiza datos al generar archivo xls
	$resultado = false;
	if($data[auth]){
		global $db, $usuario;
		$campos = array();
		$timestamp = date('Y-m-d H:i:s');
		// $id_horas_extra = (is_array($data[id_horas_extra]))?implode(',',$data[id_horas_extra]):$data[id_horas_extra];		
		$campos [] = ($data[xls])?"a.xls='$data[xls]'":'';	
		$campos [] = ($data[periodo_anio])?"a.final_anio='$data[periodo_anio]'":'';
		$campos [] = ($data[periodo])?"a.final_periodo='$data[periodo]'":'';
		$campos [] = ($data[periodo_especial])?"a.final_periodo_especial='$data[periodo_especial]'":'';
		$campos [] = "a.final_timestamp='$timestamp'";
		$campos [] = "a.final_id_usuario='$usuario[id_usuario]'";
		$campos = implode(',',array_filter($campos));
		$filtro .= filtro_grupo(array(
						 10 => ''
						,20 => "and b.id_empresa='$usuario[id_empresa]'"
						,30 => "and b.id_empresa='$usuario[id_empresa]'"
						,40 => "and b.id_empresa='$usuario[id_empresa]'"
						,50 => "and b.id_empresa='$usuario[id_empresa]'"
						,60 => "and a.id_usuario='$usuario[id_usuario]'"
				));		
		// $filtro	.= ($id_horas_extra)?" and a.id_horas_extra IN ($id_horas_extra)":'';
		if(!empty($campos)){
			$sql = "UPDATE $db[tbl_autorizaciones_nomina] a
					LEFT JOIN $db[tbl_horas_extra] b ON a.id_horas_extra=b.id_horas_extra			
					SET $campos
					WHERE 1 AND xls IS NULL $filtro
					;";
			// dump_var($sql);
			$resultado = (SQLDo($sql))?true:false;
		}
	}
	return $resultado;
}

function select_xls_lista($data=array()){
/**
* Listado de registros que se incluiran en el XLS
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
		$filtro.= ($activo)?" and d.activo IN ($activo)":'';
		$filtro.= ($id_usuario)?" and a.id_usuario IN ($id_usuario)":'';
		// $grupo 	= ($grupo)?"GROUP BY $grupo":"GROUP BY d.xls";
		$orden 	= ($orden)?"ORDER BY $orden":"ORDER BY d.xls ASC";		
		$sql = "SELECT 
					 c.id_nomina as id_empresa
					,c.nombre as empresa
					,IF(d.anio=0 or d.anio IS NULL, d.final_anio, d.anio) as nomina_anio
					/*,IF(d.periodo=0 or d.periodo IS NULL, d.final_periodo, d.periodo) as nomina_periodo*/
					,IF(d.periodo=0 or d.periodo IS NULL, CONCAT(d.final_periodo,'-',IFNULL(d.final_periodo_especial,'')), CONCAT(d.periodo,'-',IFNULL(d.periodo_especial,''))) as nomina_periodo
					,d.semana
					,d.xls
				FROM $db[tbl_horas_extra] a
				LEFT JOIN $db[tbl_personal] b ON a.id_empresa=b.id_empresa AND a.id_personal=b.id_personal
				LEFT JOIN $db[tbl_empresas] c ON a.id_empresa=c.id_empresa
				LEFT JOIN $db[tbl_autorizaciones_nomina] d ON a.id_horas_extra=d.id_horas_extra
				LEFT JOIN $db[tbl_autorizaciones] AS n1 ON a.id_horas_extra=n1.id_horas_extra AND n1.id_cat_autorizacion=1
				LEFT JOIN $db[tbl_autorizaciones] AS n2 ON a.id_horas_extra=n2.id_horas_extra AND n2.id_cat_autorizacion=2
				LEFT JOIN $db[tbl_autorizaciones] AS n3 ON a.id_horas_extra=n3.id_horas_extra AND n3.id_cat_autorizacion=3
				LEFT JOIN $db[tbl_autorizaciones] AS n4 ON a.id_horas_extra=n4.id_horas_extra AND n4.id_cat_autorizacion=4 
				WHERE 1 $filtro AND d.xls IS NOT NULL
				GROUP BY d.xls, d.periodo, d.periodo_especial 
				$orden;";
				// dump_var($sql);
		$resultado = SQLQuery($sql);
		$resultado = (count($resultado)) ? $resultado : false ;
	}
	return $resultado;
}

function select_xls_nomina_rebuild($data=array()){
/**
* Listado de registros que se incluiran en el XLS-Resumen
*/
	$resultado = false;
	if($data[auth]){
		global $db, $usuario;
		$id_horas_extra = (is_array($data[id_horas_extra]))?implode(',',$data[id_horas_extra]):$data[id_horas_extra];
		$id_personal 	= (is_array($data[id_personal]))?implode(',',$data[id_personal]):$data[id_personal];
		$empleado_num 	= (is_array($data[empleado_num]))?implode(',',$data[empleado_num]):$data[empleado_num];
		$xls 			= (is_array($data[xls]))?implode(',',$data[xls]):$data[xls];
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
		$filtro.= ($xls)?" and d.xls='$xls'":'';
		$filtro.= ($id_personal)?" and a.id_personal IN ($id_personal)":'';
		$filtro.= ($empleado_num)?" and b.empleado_num IN ($empleado_num)":'';		
		$filtro.= ($activo)?" and n4.activo IN ($activo)":'';
		$filtro.= ($id_usuario)?" and a.id_usuario IN ($id_usuario)":'';		
		$sql = "SELECT 
					 b.id_nomina as id_empleado
					,d.semana
					,e.clave as id_concepto
					/*,TIME_FORMAT(d.horas,'%H') as horas*/
					,SUM(d.horas_porcentaje) as horas_porcentaje
				FROM $db[tbl_horas_extra] a
				LEFT JOIN $db[tbl_personal] b ON a.id_empresa=b.id_empresa AND a.id_personal=b.id_personal
				LEFT JOIN $db[tbl_empresas] c ON a.id_empresa=c.id_empresa
				LEFT JOIN $db[tbl_autorizaciones_nomina] d ON a.id_horas_extra=d.id_horas_extra
				LEFT JOIN $db[tbl_conceptos] e ON d.id_concepto=e.id_concepto
				WHERE 1 $filtro AND d.id_autorizacion_nomina IS NOT NULL AND d.xls IS NOT NULL AND d.id_concepto>0
				GROUP BY b.id_nomina, d.semana, e.clave
				;";
				// dump_var($sql);
		$resultado = SQLQuery($sql);
		$resultado = (count($resultado)) ? $resultado : false ;
	}
	return $resultado;
}

function pgsql_select_periodo_activo($data=array()){
	if($data[auth]){
		global $db, $usuario;
		$id_empresa = $usuario[id_empresa_nomina];
		$sql="SELECT
				 id_empresa
				,periodo
				,periodo_especial
				,ano_periodo as periodo_anio
				,fecha_inicio
				,fecha_fin
				,id_estatus_periodo as estatus
			FROM $db[pgsql_vista_cat_periodos] 
			WHERE id_estatus_periodo=1 AND id_empresa='$id_empresa';";
		$resultado = pgquery($sql);
		$resultado = (count($resultado)) ? $resultado : false ;
		// dump_var($sql);
	}
	return $resultado;
}
/*FinLayout*/

function select_catalgo_supervisores($data=array()){
/**
* Listado de usuarios del sistema
*/
	if($data[auth]){
		global $db, $usuario;
		$id_nomina = (is_array($data[id_nomina]))?implode(',',$data[id_nomina]):$data[id_nomina];
		$id_empresa = (is_array($data[id_empresa]))?implode(',',$data[id_empresa]):$data[id_empresa];
		$grupo 			= (is_array($data[grupo]))?implode(',',$data[grupo]):$data[grupo];
		$orden 			= (is_array($data[orden]))?implode(',',$data[orden]):$data[orden];
		$filtro.=filtro_grupo(array(
					 10 => ''
					,20 => "and a.id_empresa='$usuario[id_empresa]'"
					,30 => "and a.id_empresa='$usuario[id_empresa]'"
					,40 => "and a.id_empresa='$usuario[id_empresa]'"
					,50 => "and a.id_empresa='$usuario[id_empresa]'"
					,60 => "and a.id_personal='$usuario[id_personal]'"
				));
		$filtro.= ($id_nomina)?" and a.id_nomina IN ($id_nomina)":'';
		$filtro.= ($id_empresa)?" and a.id_empresa IN ($id_empresa)":'';
		$filtro.= ($id_number)?" and a.id_number IN ($id_number)":'';
		$desc 	= ($desc)?" DESC":' ASC';
		$orden 	= ($orden)?"ORDER BY $orden".$desc:'ORDER BY a.id_empresa, a.nombre, a.paterno, a.materno'.$desc;
		$sql="SELECT 
				 a.id_personal
				,a.id_empresa
				,b.razon as empresa
				,a.empleado_num
				,CONCAT(IFNULL(a.nombre,''),' ', IFNULL(a.paterno,''),' ',IFNULL(a.materno,'')) as nombre
				,a.puesto
				,a.sucursal
				,c.id_grupo
				FROM $db[tbl_personal] a
				LEFT JOIN $db[tbl_empresas] b ON a.id_empresa=b.id_empresa
				LEFT JOIN $db[tbl_usuarios] c ON a.id_personal=c.id_personal
				WHERE 1 AND a.activo=1 AND c.id_grupo BETWEEN 30 AND 50 $filtro 
				GROUP BY a.id_personal
				$orden ;";
				// dump_var($sql);
		$resultado = SQLQuery($sql);				
		$resultado = (count($resultado)) ? $resultado : false ;
	}else{
		$resultado = false;
	}
	return $resultado;
}

function select_detecta_supervisor($data=array()){
/**
* Detecta el supervisor de un id_personal
*/
	if($data[auth]){
		global $db, $usuario;
		$id_empresa  	= (is_array($data[id_empresa]))?implode(',',$data[id_empresa]):$data[id_empresa];
		$id_personal 	= (is_array($data[id_personal]))?implode(',',$data[id_personal]):$data[id_personal];
		$id_nivel 	 	= (is_array($data[id_nivel]))?implode(',',$data[id_nivel]):$data[id_nivel];
		$grupo 			= (is_array($data[grupo]))?implode(',',$data[grupo]):$data[grupo];
		$orden 			= (is_array($data[orden]))?implode(',',$data[orden]):$data[orden];
		$filtro.=filtro_grupo(array(
					 10 => ''
					,20 => "and a.id_empresa='$usuario[id_empresa]'"
					,30 => "and a.id_empresa='$usuario[id_empresa]'"
					,40 => "and a.id_empresa='$usuario[id_empresa]'"
					,50 => "and a.id_empresa='$usuario[id_empresa]'"
					,60 => "and a.id_personal='$usuario[id_personal]'"
				));
		$filtro.= ($id_empresa)?" and a.id_empresa IN ($id_empresa)":'';
		$filtro.= ($id_personal)?" and a.id_personal IN ($id_personal)":'';
		$filtro.= ($id_nivel)?" and a.id_nivel IN ($id_nivel)":'';
		$sql="SELECT 
					id_empresa
					,id_personal
					,id_supervisor
					,id_nivel
				FROM $db[tbl_supervisores] a
				WHERE 1 $filtro ;";
				// dump_var($sql);
		$resultado = SQLQuery($sql);				
		$resultado = (count($resultado)) ? $resultado : false ;
	}else{
		$resultado = false;
	}
	return $resultado;
}

function insert_supervisor($data=array()){
/**
* Inserta Supervisor
*/
	$resultado = false;	
	if($data[auth]){
		global $db, $usuario;
		$id_empresa 	= $data[id_empresa];
		$id_usuario 	= $data[id_usuario];
		$id_supervisor	= $data[id_supervisor];
		$id_nivel 		= $data[id_nivel];
		$timestamp 		= date('Y-m-d H:i:s');
		$sql="SELECT id_personal FROM $db[tbl_usuarios] WHERE id_usuario='$id_usuario';";
		$id_personal = SQLQuery($sql);
		$sql="INSERT INTO $db[tbl_supervisores] 
			SET
				 id_empresa 	='$id_empresa'
				,id_personal	='$id_personal[0]'
				,id_supervisor	='$id_supervisor'
				,id_nivel		='$id_nivel'
				,id_usuario 	='$usuario[id_usuario]'
				,timestamp 		='$timestamp'
			;";
		// $id = $id=SQLDo($sql);
		$resultado = (SQLDo($sql))?true:false;
		// $resultado = ($id)?$id:false;
	}
	return $resultado;
}
function insert_supervisor_sincronizacion($data=array()){
	global $db,$usuario;
	$resultado = false;	
	if($data[auth]){
		$nivel 			=	$data[id_nivel];
		$id_personal 	=	$data[id_personal];
		$id_empresa 	=	$data[id_empresa];
		$id_supervisor 	=	$data[id_supervisor];
		$timestamp 		= date('Y-m-d H:i:s');
		$sql="INSERT INTO 
				$db[tbl_supervisores]
				SET 
					id_empresa		=	'$id_empresa',
					id_personal		=	'$id_personal',
					id_supervisor	=	'$id_supervisor',
					id_nivel 		=	'$nivel',
					id_usuario  	=	'$usuario[id_usuario]',
					timestamp      	= 	'$timestamp';";
			//echo $sql;
			//die();
		$resultado = (SQLDo($sql))?true:false;
	}

	return $resultado;
}

function delete_supervisores($data=array()){
	global $db,$usuario;
	$resultado = false;	
	if($data[auth]){
		$id_personal 	=	$data[id_personal];
		$id_empresa 	=	$data[id_empresa];
		$sql="DELETE FROM $db[tbl_supervisores]	WHERE id_empresa='$id_empresa' AND id_personal = '$id_personal';";
			// dump_var($sql);
		$resultado = (SQLDo($sql))?true:false;
	}

	return $resultado;
}

function select_datos_usuario($data=array()){
	global $db;
	if($data[auth]){
		$sql="SELECT 
				a.id_personal,
				a.nombre,
				a.paterno,
				a.materno,
				a.rfc,
				a.imss,
				a.sucursal,
				b.nombre as empresa,
				b.id_empresa
			FROM 
				$db[tbl_personal] a
				LEFT JOIN 
					$db[tbl_empresas] b
					ON 
					a.id_empresa=b.id_empresa
			WHERE
				a.id_personal=$data[id_personal]";
		$resultado = SQLQuery($sql);				
			$resultado = (count($resultado)) ? $resultado : false ;
	}else{
		$resultado = false;
	}
	return $resultado;
}

function admin_select_usuario($data=array()){
	global $db;
	if($data[auth]){
		$id_personal = $data[id_personal];
		$id_usuario = $data[id_usuario];
		$filtro .= ($id_personal)?" AND b.id_personal='$id_personal'":'';
		$filtro .= ($id_usuario)?" AND a.id_usuario='$id_usuario'":'';
		$sql="SELECT 
				a.id_usuario,
				a.usuario,
				a.clave,
				b.id_personal,
				b.empleado_num,
				CONCAT(IFNULL(b.nombre,''),' ',IFNULL(b.paterno,''),' ',IFNULL(b.materno,'')) as empleado_nombre,
				b.email as empleado_correo,
				b.puesto,
				b.rfc,
				b.imss,
				b.sucursal,
				c.nombre as empresa,
				c.id_empresa,
				CONCAT(IFNULL(s1p.nombre,''),' ',IFNULL(s1p.paterno,''),' ',IFNULL(s1p.materno,'')) as nivel1_nombre,
				s1p.email as nivel1_correo,
				CONCAT(IFNULL(s2p.nombre,''),' ',IFNULL(s2p.paterno,''),' ',IFNULL(s2p.materno,'')) as nivel2_nombre,
				s2p.email as nivel2_correo,
				CONCAT(IFNULL(s3p.nombre,''),' ',IFNULL(s3p.paterno,''),' ',IFNULL(s3p.materno,'')) as nivel3_nombre,
				s3p.email as nivel3_correo,
				CONCAT(IFNULL(s4p.nombre,''),' ',IFNULL(s4p.paterno,''),' ',IFNULL(s4p.materno,'')) as nivel4_nombre,
				s4p.email as nivel4_correo,
				CONCAT(IFNULL(s5p.nombre,''),' ',IFNULL(s5p.paterno,''),' ',IFNULL(s5p.materno,'')) as nivel5_nombre,
				s5p.email as nivel5_correo,
				a.timestamp
			FROM $db[tbl_usuarios] a
			LEFT JOIN $db[tbl_personal] b ON a.id_personal=b.id_personal
			LEFT JOIN $db[tbl_empresas] c ON b.id_empresa=c.id_empresa
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
			WHERE 1 $filtro
			GROUP BY a.id_personal /*,a.id_usuario*/
			;";
		// dump_var($sql);
		$resultado = SQLQuery($sql);				
		$resultado = (count($resultado)) ? $resultado : false ;
	}else{
		$resultado = false;
	}
	return $resultado;
}

function select_admin_usuarios($data=array()){
	global $db, $usuario;
	if($data[auth]){
		$id_empresa = $data[id_empresa];
		$id_personal = $data[id_personal];
		$id_usuario = $data[id_usuario];
		$filtro.=filtro_grupo(array(
					 10 => ''
					,20 => "and b.id_empresa='$usuario[id_empresa]'"
					,30 => "and b.id_empresa='$usuario[id_empresa]'"
					,40 => "and b.id_empresa='$usuario[id_empresa]'"
					,50 => "and b.id_empresa='$usuario[id_empresa]'"
					,60 => "and b.id_personal='$usuario[id_personal]'"
				));
		// $filtro .= ($id_empresa)?" AND b.id_empresa='$id_empresa'":'';
		$filtro .= ($id_personal)?" AND b.id_personal='$id_personal'":'';
		$filtro .= ($id_usuario)?" AND a.id_usuario='$id_usuario'":'';
		$sql="SELECT 
				a.id_usuario,
				a.usuario,
				a.clave,
				b.id_personal,
				b.empleado_num,
				b.id_nomina,
				CONCAT(IFNULL(b.nombre,''),' ',IFNULL(b.paterno,''),' ',IFNULL(b.materno,'')) as empleado_nombre,
				b.nombre,
				b.paterno,
				b.materno,
				b.email as empleado_correo,
				b.puesto,
				b.rfc,
				b.imss,
				b.sucursal as localidad,
				b.sucursal_nomina as sucursal,
				c.nombre as empresa,
				c.id_empresa,
				CONCAT(IFNULL(s1p.nombre,''),' ',IFNULL(s1p.paterno,''),' ',IFNULL(s1p.materno,'')) as nivel1_nombre,
				s1p.email as nivel1_correo,
				CONCAT(IFNULL(s2p.nombre,''),' ',IFNULL(s2p.paterno,''),' ',IFNULL(s2p.materno,'')) as nivel2_nombre,
				s2p.email as nivel2_correo,
				CONCAT(IFNULL(s3p.nombre,''),' ',IFNULL(s3p.paterno,''),' ',IFNULL(s3p.materno,'')) as nivel3_nombre,
				s3p.email as nivel3_correo,
				CONCAT(IFNULL(s4p.nombre,''),' ',IFNULL(s4p.paterno,''),' ',IFNULL(s4p.materno,'')) as nivel4_nombre,
				s4p.email as nivel4_correo,
				CONCAT(IFNULL(s5p.nombre,''),' ',IFNULL(s5p.paterno,''),' ',IFNULL(s5p.materno,'')) as nivel5_nombre,
				s5p.email as nivel5_correo,
				a.timestamp
				,count(a.id_personal) as perfiles
			FROM $db[tbl_personal] b
			LEFT JOIN $db[tbl_usuarios] a ON a.id_personal=b.id_personal
			LEFT JOIN $db[tbl_empresas] c ON b.id_empresa=c.id_empresa
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
			WHERE 1 AND b.activo=1 $filtro
			GROUP BY a.id_personal
			;";
			// dump_var($sql);
		$resultado = SQLQuery($sql);				
		$resultado = (count($resultado)) ? $resultado : false ;
	}else{
		$resultado = false;
	}
	return $resultado;
}

function reset_usuario_clave($data=array()){
	global $db,$usuario;
	$resultado = false;	
	if($data[auth]){
		$id_personal 	=	$data[id_personal];
		$sql="UPDATE $db[tbl_usuarios] a
				SET a.clave=md5(a.usuario), login=0
				WHERE id_personal='$id_personal';";
		$resultado = (SQLDo($sql))?true:false;
	}
	return $resultado;
}

function select_enum_generales($data=array()){
/**
* Extrae el indice de un campo enum $data[tabla]:$data[campo]
*/
	if($data[auth]){		
		global $db;	
		$resultado = false;
		$sql = "SHOW COLUMNS FROM ".$db[$data[tabla]]." LIKE '".$data[campo]."';";
		$resultado = SQLQuery_especial($sql);
		$resultado = (count($resultado)) ? $resultado : false ;		
		if($resultado){
			$chars = array("enum", "(", "'", ")");
	    	$resultado = trim(str_replace($chars, "", strip_tags($resultado[1])));
	    	$resultado = explode(",", $resultado);
    	}
	}

	return $resultado;
}

function select_tbl_calendario_grupos($data=array()){
	global $db, $usuario;
	if($data[auth]){
		$filtro.=filtro_grupo(array(
					 10 => ''
					,20 => "and a.id_empresa IN ('$usuario[id_empresa]', 0)"
					,30 => "and a.id_empresa='$usuario[id_empresa]'"
					,40 => "and a.id_empresa='$usuario[id_empresa]'"
					,50 => "and a.id_empresa='$usuario[id_empresa]'"
					,60 => "and a.id_personal='$usuario[id_personal]'"
				));
		$sql="SELECT 
				 a.anio
				,a.id_empresa
				,IF(a.id_empresa=0, 'Aplica a Todas',b.nombre) as empresa	
				,COUNT(*) as total_fechas		
			FROM $db[tbl_calendarios] a
			LEFT JOIN $db[tbl_empresas] b ON b.id_empresa=a.id_empresa
			WHERE 1 $filtro 
			GROUP BY a.anio ASC, a.id_empresa DESC;";
		$resultado = SQLQuery($sql);
		// dump_var($resultado);		
		$resultado = (count($resultado)) ? $resultado : false ;
	}else{
		$resultado = false;
	}
	return $resultado;
}

function select_tbl_calendario($data=array()){
	global $db;
	if($data[auth]){
		$filtro.=filtro_grupo(array(
					 10 => ''
					,20 => "and a.id_empresa='$usuario[id_empresa]'"
					,30 => "and a.id_empresa='$usuario[id_empresa]'"
					,40 => "and a.id_empresa='$usuario[id_empresa]'"
					,50 => "and a.id_empresa='$usuario[id_empresa]'"
					,60 => "and a.id_personal='$usuario[id_personal]'"
				));
		$id_empresa = $data[id_empresa];
		$anio = $data[anio];
		$sql="SELECT 
				 a.id_calendario
				,a.tipo
				,a.id_empresa
				,IF(a.id_empresa=0, 'Aplica a Todas',b.nombre) as empresa
				,a.anio
				,a.fecha_inicio
				,a.fecha_fin
				,a.id_usuario
				,a.timestamp
				,a.activo				
			FROM $db[tbl_calendarios] a
			LEFT JOIN $db[tbl_empresas] b ON b.id_empresa=a.id_empresa
			WHERE 1 AND a.anio='$anio' AND a.id_empresa='$data[id_empresa]'
			ORDER BY a.fecha_inicio ASC;";
			// dump_var($sql);
		$resultado = SQLQuery($sql);		
		$resultado = (count($resultado)) ? $resultado : false ;
	}else{
		$resultado = false;
	}
	return $resultado;
}

function insert_calendario_fecha($data=array()){
	global $db,$usuario;
	$resultado = false;	
	if($data[auth]){
		$tipo 			=	$data[tipo];
		$id_empresa 	=	$data[id_empresa];
		$anio 		 	=	$data[anio];
		$fecha_inicio 	=	$data[fecha_inicio];
		$fecha_fin 		=	$data[fecha_fin];
		$timestamp 		= date('Y-m-d H:i:s');
		$sql="INSERT INTO 
				$db[tbl_calendarios] SET 
					tipo			=	'$tipo',
					id_empresa 		=	'$id_empresa',
					anio 			=	'$anio',
					fecha_inicio	=	'$fecha_inicio',
					fecha_fin		=	'$fecha_fin',
					id_usuario  	=	'$usuario[id_usuario]',
					timestamp      	= 	'$timestamp'
					;";
					// dump_var($sql);
		$resultado = (SQLDo($sql))?true:false;
	}

	return $resultado;
}

function update_usuario($data=array()){
// Actualizacion de datos personales y de cuenta de usuario
	global $db,$usuario;
	$resultado = false;
	if($data[auth]){
		$id_empresa 	= ($data[id_empresa])?$data[id_empresa]:false;
		$id_personal 	= ($data[id_personal])?$data[id_personal]:false;
		$nombre 		= ($data[nombre])?$data[nombre]:false;
		$paterno 		= ($data[paterno])?$data[paterno]:false;
		$materno 		= ($data[materno])?$data[materno]:false;
		$sucursal 		= ($data[sucursal])?$data[sucursal]:false;
		$email 			= ($data[email])?$data[email]:false;
		$empleado_num	= ($data[empleado_num])?$data[empleado_num]:false;
		$id_nomina 		= ($data[id_nomina])?$data[id_nomina]:false;
		$timestamp 		= date('Y-m-d H:i:s');
		$campos .= ($nombre)?"nombre = '$nombre',":'';
		$campos .= ($paterno)?"paterno 	= '$paterno',":'';
		$campos .= ($materno)?"materno = '$materno',":'';
		$campos .= ($sucursal)?"sucursal_nomina = '$sucursal',":'';
		$campos .= ($email)?"email 	= '$email',":'';
		$campos .= ($empleado_num)?"empleado_num = '$empleado_num',":'';
		$campos .= ($id_nomina)?"id_nomina = '$id_nomina',":'';

		$filtro .= ($id_empresa)?"AND id_empresa='$id_empresa'":'';

		$sql="UPDATE $db[tbl_personal] SET					
					$campos
					id_usuario  	= '$usuario[id_usuario]',
					timestamp      	= '$timestamp'
				WHERE 1 AND id_personal='$id_personal' $filtro
					;";
		// dump_var($sql);
		$resultado = (SQLDo($sql))?true:false;

		if($empleado_num || $id_nomina){
			// Actualizacion de usuario
			$vUsuario = ($empleado_num)?$empleado_num:$id_nomina;
			$vClave = md5($vUsuario);
			$sql2="UPDATE $db[tbl_usuarios] 
					SET
						 usuario 	='$vUsuario'
						,clave 		='$vClave'
					WHERE id_personal='$id_personal'
					;";
			$id_usuario = SQLDo($sql2);		
			$resultado = (SQLDo($sql2))?true:false;
		}
	}

	return $resultado;
}

function select_supervisores($data=array()){
	global $db, $usuario;
	if($data[auth]){
		$id_empresa = $data[id_empresa];
		$id_personal = $data[id_personal];
		$id_usuario = $data[id_usuario];
		$filtro.=filtro_grupo(array(
					 10 => ''
					,20 => "and b.id_empresa='$usuario[id_empresa]'"
					,30 => "and b.id_empresa='$usuario[id_empresa]'"
					,40 => "and b.id_empresa='$usuario[id_empresa]'"
					,50 => "and b.id_empresa='$usuario[id_empresa]'"
					,60 => "and b.id_personal='$usuario[id_personal]'"
				));
		$filtro .= ($id_personal)?" AND b.id_personal='$id_personal'":'';
		$filtro .= ($id_usuario)?" AND a.id_usuario='$id_usuario'":'';

			$sql ="SELECT 
				 a.id_personal 
				,b.empleado_num 
				,b.id_nomina 
				,CONCAT(b.nombre,' ',IFNULL(b.paterno,''),' ',IFNULL(b.materno,'')) as empleado_nombre
				,b.estado
				,b.sucursal_nomina as sucursal
				,b.sucursal as localidad
				,b.puesto
				,b.email as empleado_email

				,un1.usuario as supervisor_n1_usuario
				,CONCAT(n1.nombre,' ',IFNULL(n1.paterno,''),' ',IFNULL(n1.materno,'')) as supervisor_n1_nombre
				,n1.email as supervisor_n1_email
				,n1.puesto as supervisor_n1_puesto

				,un2.usuario as supervisor_n2_usuario
				,CONCAT(n2.nombre,' ',IFNULL(n2.paterno,''),' ',IFNULL(n2.materno,'')) as supervisor_n2_nombre
				,n2.email as supervisor_n2_email
				,n2.puesto as supervisor_n2_puesto

				,un3.usuario as supervisor_n3_usuario
				,CONCAT(n3.nombre,' ',IFNULL(n3.paterno,''),' ',IFNULL(n3.materno,'')) as supervisor_n3_nombre
				,n3.email as supervisor_n3_email
				,n3.puesto as supervisor_n3_puesto
				from $db[tbl_usuarios] a 
				left join $db[tbl_personal] b on a.id_personal=b.id_personal
				left join $db[tbl_grupos] c on a.id_grupo=c.id_grupo

				left join $db[tbl_supervisores] d on a.id_personal=d.id_personal and d.id_nivel=1
				left join $db[tbl_personal] n1 on d.id_supervisor=n1.id_personal
				left join $db[tbl_usuarios] un1 on n1.id_personal=un1.id_personal

				left join $db[tbl_supervisores] e on a.id_personal=e.id_personal and e.id_nivel=2
				left join $db[tbl_personal] n2 on e.id_supervisor=n2.id_personal
				left join $db[tbl_usuarios] un2 on n2.id_personal=un2.id_personal

				left join $db[tbl_supervisores] f on a.id_personal=f.id_personal and f.id_nivel=3
				left join $db[tbl_personal] n3 on f.id_supervisor=n3.id_personal
				left join $db[tbl_usuarios] un3 on n3.id_personal=un3.id_personal

				WHERE 1 AND (a.activo=1 and b.activo=1) and c.grupo='empleados' and b.id_personal>10 $filtro
						AND (n1.empleado_num IS NULL OR n2.empleado_num IS NULL OR n3.empleado_num IS NULL OR b.email IS NULL OR (b.id_nomina IS NOT NULL AND b.empleado_num=b.id_nomina) )
				GROUP BY b.id_personal, a.id_usuario
			";
			// dump_var($sql);
		$resultado = SQLQuery($sql);				
		$resultado = (count($resultado)) ? $resultado : false ;
	}else{
		$resultado = false;
	}
	return $resultado;
}

function select_catalogo_sucursales_nomina($data=array()){
	global $db, $usuario;
	if($data[auth]){
		$filtro.=filtro_grupo(array(
					 10 => ''
					,20 => "and b.id_empresa='$usuario[id_empresa]'"
					,30 => "and b.id_empresa='$usuario[id_empresa]'"
					,40 => "and b.id_empresa='$usuario[id_empresa]'"
					,50 => "and b.id_empresa='$usuario[id_empresa]'"
					,60 => "and b.id_personal='$usuario[id_personal]'"
				));
			$sql = "SELECT sucursal_nomina FROM $db[tbl_personal] WHERE sucursal_nomina!='' and sucursal_nomina IS NOT NULL AND activo=1 GROUP BY sucursal_nomina ASC";
			// dump_var($sql);
		$resultado = SQLQuery($sql);				
		$resultado = (count($resultado)) ? $resultado : false ;
	}else{
		$resultado = false;
	}
	return $resultado;
}
?>