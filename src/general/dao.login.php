<?php session_name('o3m_fw'); session_start(); if(isset($_SESSION['header_path'])){include_once($_SESSION['header_path']);}else{header('location: '.dirname(__FILE__));}
/**
* 				Funciones "DAO"
* Descripcion:	Ejecuta consultas SQL y devuelve el resultado.
* Creación:		2014-08-27
* @author 		Oscar Maldonado
*/
function login($usuario, $clave){
	global $db;
	$sql = "SELECT 
				 a.id_usuario
				,a.usuario
				,a.id_grupo
				,d.grupo
				,a.activo
				,a.login
				,b.id_personal
				,CONCAT(b.nombre,' ',IFNULL(b.paterno,''),' ',IFNULL(b.materno,'')) as nombreCompleto
				,b.empleado_num
				,b.email
				,c.nombre as empresa
				,c.id_empresa as id_empresa
				,c.id_nomina as id_empresa_nomina
				,c.pais
				,d.visible as visible_group
				,d.invisible as invisible_group
				/*,a.visible as visible_user*/
				/* visible_user + Padres de grupo*/
				,CONCAT(IFNULL(a.visible,''),',',(SELECT CAST(GROUP_CONCAT(DISTINCT id_grupo SEPARATOR ',') AS CHAR(1000)) FROM sis_menu WHERE FIND_IN_SET(id_menu, CONCAT(IFNULL(d.visible,''),',',IFNULL(a.visible,'')))  GROUP BY '')) as visible_user
				,a.invisible as invisible_user
				,COUNT(a.id_personal) as perfiles
				FROM $db[tbl_usuarios] a
				LEFT JOIN $db[tbl_personal] b USING(id_personal)
				LEFT JOIN $db[tbl_empresas] c USING(id_empresa)
				LEFT JOIN $db[tbl_grupos] d ON a.id_grupo=d.id_grupo
				WHERE a.usuario='$usuario' and a.clave='$clave' and a.activo=1 and b.activo=1 AND c.activo=1 AND d.activo=1
				GROUP BY a.id_personal;";
				// dump_var($sql);
	$resultado = SQLQuery($sql);
	$resultado = ($resultado[0]) ? $resultado : false ;
	return $resultado;
}
/*O3M*/
function validar_contrasenia($id_usuario){
	global $db,$usuario;
	// dump_var($usuario);
	$sql="SELECT 
			clave
		FROM 
			$db[tbl_usuarios]
		WHERE 
			id_usuario='$id_usuario';";
			// dump_var($sql);
	$resultado = SQLQuery($sql);
	$resultado = ($resultado[0]) ? $resultado : false ;
	return $resultado;
}
function update_pass_user($pass,$id_personal){
	global $db,$usuario;

	$sql="UPDATE 
			$db[tbl_usuarios]
		SET 
			clave 	='$pass',
			login 	= 1
		WHERE 
			id_personal='$id_personal';";
	// dump_var($sql);
	$resultado = SQLDo($sql);
	$resultado = (count($resultado)) ? $resultado : false ;
	return $resultado;
}

function perfiles($id_personal){
	global $db;
	$sql = "SELECT 
				 a.id_usuario
				,a.usuario
				,a.clave
				,a.id_grupo
				,a.activo
				,a.login
				,b.id_personal
				,b.empleado_num
				,c.id_empresa as id_empresa	
				,d.grupo			
				FROM $db[tbl_usuarios] a
				LEFT JOIN $db[tbl_personal] b USING(id_personal)
				LEFT JOIN $db[tbl_empresas] c USING(id_empresa)
				LEFT JOIN $db[tbl_grupos] d ON a.id_grupo=d.id_grupo
				WHERE a.id_personal='$id_personal'
				;";
	// dump_var($sql);
	$resultado = SQLQuery($sql);
	$resultado = ($resultado[0]) ? $resultado : false ;
	return $resultado;
}

function login_unico($id_usuario){
	global $db;
	$sql = "SELECT 
				 a.id_usuario
				,a.usuario
				,a.id_grupo
				,d.grupo
				,a.activo
				,a.login
				,b.id_personal
				,CONCAT(b.nombre,' ',IFNULL(b.paterno,''),' ',IFNULL(b.materno,'')) as nombreCompleto
				,b.empleado_num
				,b.email
				,c.nombre as empresa
				,c.id_empresa as id_empresa
				,c.id_nomina as id_empresa_nomina
				,c.pais
				,d.visible as visible_group
				,d.invisible as invisible_group
				,a.visible as visible_user
				,a.invisible as invisible_user
				FROM $db[tbl_usuarios] a
				LEFT JOIN $db[tbl_personal] b USING(id_personal)
				LEFT JOIN $db[tbl_empresas] c USING(id_empresa)
				LEFT JOIN $db[tbl_grupos] d ON a.id_grupo=d.id_grupo
				WHERE a.id_usuario='$id_usuario' AND a.activo=1 AND b.activo=1 AND c.activo=1 AND d.activo=1;";
	$resultado = SQLQuery($sql);
	$resultado = ($resultado[0]) ? $resultado : false ;
	return $resultado;
}
?>