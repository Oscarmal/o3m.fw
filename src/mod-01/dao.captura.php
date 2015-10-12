<?php session_name('o3m_fw'); session_start(); if(isset($_SESSION['header_path'])){include_once($_SESSION['header_path']);}else{header('location: '.dirname(__FILE__));}
/**
* 				Funciones "DAO"
* Descripcion:	Ejecuta consultas SQL y devuelve el resultado.
* Creación:		2014-08-27
* @author 		Oscar Maldonado
*/
function captura_select($data=array()){
	if($data[auth]){
		global $db, $usuario;
		$id_horas_extra = $data[id_horas_extra];
		$id_personal 	= $data[id_personal];
		$empleado_num 	= $data[empleado_num];
		$estatus		= $data[estatus];
		$grupo 			= $data[grupo];
		$orden 			= $data[orden];
		$desc 			= $data[desc];
		$filtro	= ($id_horas_extra)?" and a.id_horas_extra='$id_horas_extra'":'';
		$filtro.= ($id_personal)?" and a.id_personal='$id_personal'":'';
		$filtro.= ($empleado_num)?" and b.empleado_num='$empleado_num'":'';
		if($status && $status!=1){
			$filtro.=" and d.estatus='$estatus'";
		}elseif($estatus){
			$filtro.=" and d.estatus IS NULL";
		}
		$desc 	= ($desc)?" DESC":' ASC';
		$grupo 	= ($grupo)?"GROUP BY $grupo":'GROUP BY a.id_horas_extra';
		$orden 	= ($orden)?"ORDER BY $orden".$desc:'ORDER BY a.id_horas_extra'.$desc;
		$sql = "SELECT a.id_horas_extra
					,CONCAT(b.nombre,' ', b.paterno,' ',b.materno) as nombre_completo
					,b.empleado_num
					,DATE_FORMAT(a.fecha,'%d/%m/%Y') as fecha
					,DATE_FORMAT(a.horas,'%H:%i') as horas
					,c.usuario as capturado_por
					,a.timestamp as capturado_el
				FROM $db[tbl_horas_extra] a
				LEFT JOIN $db[tbl_personal] b ON a.id_personal=b.id_personal
				LEFT JOIN $db[tbl_usuarios] c ON a.id_usuario=c.id_usuario
				LEFT JOIN $db[tbl_autorizaciones] d ON a.id_horas_extra=d.id_horas_extra
				WHERE 1 
				$filtro $grupo $orden
				;";
		$resultado = SQLQuery($sql);
		$resultado = (count($resultado)) ? $resultado : false ;

	}else{
		$resultado = false;
	}
	return $resultado;
}

function captura_insert($data=array()){
	if($data[auth]){
		global $db, $usuario;
		$id_personal 	= $data[id_personal];
		$id_empresa 	= $data[id_empresa];
		$fecha 			= $data[fecha];
		$horas 			= horas_int($data[horas]);
		$semana_iso8601 = semana_iso8601($fecha);
		$timestamp = date('Y-m-d H:i:s');
		$sql = "INSERT INTO $db[tbl_horas_extra] SET
					id_personal='$id_personal',
					id_empresa='$id_empresa',
					semana_iso8601='$semana_iso8601',
					fecha = '$fecha',
					horas ='$horas',
					id_usuario = '$usuario[id_usuario]',
					timestamp = '$timestamp'
					;";		

		$resultado = SQLDo($sql);
	}else{
		$resultado = false;
	}
	return $resultado;
}
function select_correos($data=array()){
	$resultado = false;
	if($data[auth]){
		global $db, $usuario;
		$id_horas_extra = (is_array($data[id_horas_extra]))?implode(',',$data[id_horas_extra]):$data[id_horas_extra];
		$grupo 			= (is_array($data[grupo]))?implode(',',$data[grupo]):$data[grupo];
		$orden 			= (is_array($data[orden]))?implode(',',$data[orden]):$data[orden];
		$filtro.= ($id_horas_extra)?" and a.id_horas_extra IN ($id_horas_extra)":'';
		$grupo 	= ($grupo)?"GROUP BY $grupo":"GROUP BY a.id_horas_extra";
		$orden 	= ($orden)?"ORDER BY $orden":"ORDER BY a.id_horas_extra ASC";		
		$sql = "SELECT 
					 a.id_horas_extra
					,a.id_empresa
					,c.nombre as empresa
					,a.id_personal
					,b.empleado_num
					,CONCAT(b.nombre,' ',IFNULL(b.paterno,''),' ',IFNULL(b.materno,'')) as nombre_completo
					,a.fecha
					,a.horas
					,a.semana_iso8601
					,b.email
					,s1p.email as s1_email
					,CONCAT(s1p.nombre,' ',IFNULL(s1p.paterno,''),' ',IFNULL(s1p.materno,'')) as s1_nombre_completo
				FROM $db[tbl_horas_extra] a
				LEFT JOIN $db[tbl_personal] b ON a.id_empresa=b.id_empresa AND a.id_personal=b.id_personal
				LEFT JOIN $db[tbl_empresas] c ON a.id_empresa=c.id_empresa
				left join $db[tbl_supervisores] s1 on b.id_empresa=s1.id_empresa and b.id_personal=s1.id_personal and s1.id_nivel=1
				left join $db[tbl_personal] s1p on s1.id_supervisor=s1p.id_personal
				WHERE 1 $filtro 
				$grupo 
				$orden;";
		$resultado = SQLQuery($sql);
		$resultado = (count($resultado)) ? $resultado : false ;
	}
	return $resultado;
}

function captura_verifica($data=array()){
	if($data[auth]){
		global $db, $usuario;
		$id_personal 	= $data[id_personal];
		$id_empresa 	= $data[id_empresa];
		$fecha			= $data[fecha];
		$filtro	= ($id_empresa)?" and a.id_empresa='$id_empresa'":'';
		$filtro.= ($id_personal)?" and a.id_personal='$id_personal'":'';
		$filtro.= ($fecha)?" and a.fecha='$fecha'":'';
		$sql = "SELECT 
					 a.id_horas_extra
					,DATE_FORMAT(a.fecha,'%d/%m/%Y') as fecha
					,DATE_FORMAT(a.horas,'%H:%i') as horas
					,a.timestamp as capturado_el
				FROM $db[tbl_horas_extra] a
				/*LEFT JOIN (SELECT id_horas_extra, MAX(id_cat_autorizacion) as id_cat_autorizacion, estatus FROM $db[tbl_autorizaciones] GROUP BY id_horas_extra) AS auth ON a.id_horas_extra=auth.id_horas_extra*/
				LEFT JOIN (SELECT * FROM 
					(SELECT * FROM $db[tbl_autorizaciones] where activo=1 ORDER BY id_horas_extra ASC, id_cat_autorizacion DESC, timestamp DESC) AS tbl_aut
					GROUP BY tbl_aut.id_horas_extra) auth ON a.id_horas_extra=auth.id_horas_extra
				WHERE 1 AND a.activo=1 AND (auth.estatus!=0 OR auth.estatus IS NULL) $filtro ;";
				// dump_var($sql);
		$resultado = SQLQuery($sql);
		$resultado = (count($resultado)) ? $resultado : false ;

	}else{
		$resultado = false;
	}
	return $resultado;
}

/*O3M*/
?>