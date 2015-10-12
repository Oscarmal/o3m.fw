<?php session_name('o3m_fw'); session_start(); if(isset($_SESSION['header_path'])){include_once($_SESSION['header_path']);}else{header('location: '.dirname(__FILE__));}
// Define modulo del sistema
define(MODULO, $in[modulo]);
// Archivo DAO
set_time_limit(0);
require_once($Path[src].MODULO.'/dao.admin.php');
global $usuario;
// Lógica de negocio
if($in[auth]){
	if($ins[accion]=='sincronizar'){
		// $sqlData = array(
		// 	 auth 			=> 1
		// 	,id_personal	=> $usuario[id_personal]
		// 	,id_empresa		=> $usuario[id_empresa]
		// 	,fecha 			=> fecha_form($in[fecha])
		// 	,horas 			=> $in[horas]
		// );
		//$success = captura_insert($sqlData);
		if($usuario[id_grupo]==0){
			$user='root';
			$success=select_view_vista_credenciales($user,$vacio);
		}
		else{
			$user='root';
			//$user='root';
			$id_empresa=$usuario[id_empresa_nomina];
			$success=select_view_vista_credenciales($user,$id_empresa);
		}
			
			$msj = ($success)?'Guardado':'No guardó';
			if($msj=='Guardado'){
				$valor=count($success);
				for($i=0; $i<=$valor-1; $i++){
					$sinconizacion=prueba_insert_tabla_view_vista_credenciales($success[$i]);
				}

				$sincronizacion = ($sinconizacion)?'Guardado':'No guardó';
				if($sincronizacion=='Guardado'){
					$consulta_up=select_sincronizacion_update();
				}	
				else{
					//echo 'No guardó';	
				}
			}
			else{
				//echo 'No guardó';
			}
	}elseif(!$ins[accion]){
		$error = array(error => 'Sin accion');
		$data = json_encode($error);
	}		
	$data = array(success => $msj, message => $msj);
	$data = json_encode($data);
}else{
	$error = array(error => 'Sin autorización');
	$data = json_encode($error);
}
// Resultado
echo $data;
/*O3M*/
?>