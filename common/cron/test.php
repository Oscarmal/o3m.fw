<?php /*O3M*/
/**
* Descripción:	Cron que envía correo al final del día de cierre de periodo a supervisores 
* @author:		Oscar Maldonado
* Creación:		2015-04-20
* Modificación:	
*/

// INCLUDES
require_once('includes.php');

// BUSSINESS
// echo date("Y-m-d H:i:s");

# Envío de correo
if($html_tpl = email_tpl($success)){
	// extraccion de datos
	// $sqlData = array(
	// 	 auth 		=> true
	// 	,estatus	=> 1
	// 	,activo 	=> 1
	// );
	// $tabla = select_inplants($sqlData);
	// if(count($datos)){
	// 	foreach($datos as $registro){
	// 		$soloUno = (!is_array($registro))?true:false; #Deteccion de total de registros
	// 		$data = (!$soloUno)?$registro:$datos; #Seleccion de arreglo	
	// 		$destinatarios[] = array(
	// 			 email	=> $data[email]
	// 			,nombre	=> $data[nombre_completo]
	// 		);
	// 		if($soloUno) break;
	// 	}
	// }

	$destinatarios[] = array(
		 // email	=> $data[email]
		 email	=> 'oscar.maldonado@isolution.mx'
		,nombre	=> $data[nombre_completo]
	);

	// Envio de correo
	$tplData = array(
		 html_tpl 			=> $html_tpl
		,destinatarios 		=> $destinatarios
		,destinatariosCC 	=> $destinatariosCC
		,destinatariosBCC 	=> $destinatariosBCC
		,asunto 			=> 'Sistema de Horas Extra'
		,adjuntos 			=> $adjuntos
	);
	send_mail_smtp($tplData);
}else{
	$resultado = "ERROR: ".$html_tpl;
}

// dump_var($tabla);

// MAIL
function email_tpl(){
	global $Raiz, $cfg, $Path;
	// Envia datos a plantilla html
	$vista_new 	= 'email/email_aviso_supervisores.html';
	$tpl_data = array(
			 TOP_IMG 		=> $Raiz[url].$cfg[path_img].'email_top.jpg'
			,TITULO 		=> 'Recordatorio de Horas Extra'	
			,EMPLEADO_NUM 	=> $data[empleado_num]
			,EMPLEADO 		=> $data[nombre_completo]
			,FECHA_HE 		=> $data[fecha]
			,HORAS 			=> $data[horas]
			,CAPTURA 		=> $data[capturado_el]
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
/*O3M*/
?>