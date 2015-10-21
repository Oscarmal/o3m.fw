<?php session_name('o3m_fw'); session_start(); if(isset($_SESSION['header_path'])){include_once($_SESSION['header_path']);}else{header('location: '.dirname(__FILE__));}
// Define modulo del sistema
define(MODULO, $in[modulo]);
// Archivo DAO
require_once($Path[src].strtolower(MODULO).'/dao.login.php');
require_once($Path[src].'views.vars.'.strtolower(MODULO).'.php');
require_once($Path[src].'build.menu.php');
// Lógica de negocio
if($in[accion]=='login-perfiles'){
	if(!empty($ins[usuario]) && !empty($ins[clave])){			
		if($usuario = login($ins[usuario], md5($in[clave]))){
			llena_sesion($usuario);
			if(!$usuario[login]){
				$success = 'primer-logueo';		
				$html = build_contrasenia_popup('primer_logueo');
			}
			elseif($usuario[perfiles]>1){
				$vista_new 	= 'general/perfil_popup.html';
				$tpl_data = array(
						 MORE 	 	=> incJs($Path[srcjs].'general/login.js')
						,CONTENIDO	=> build_usuario_perfiles($usuario[id_personal])	
						);		
				$html = contenidoHtml($vista_new, $tpl_data);
				$success = 'popup';
			}else{
				// Respuesta
				$modulo = $parm[GENERAL];
				$seccion = $parm[INICIO];
				$url = $Path['url']."$modulo/$seccion";
				if($usuario[login]==1){					
					$success = 'autorizado';
				}else{					
					$success = 'primer-logueo';					
					$html = build_contrasenia_popup('primer_logueo');
				}
				llena_sesion($usuario);
			}
		}else{
			$modulo = $parm[GENERAL];
			$seccion = $parm[ERROR];
			$url = $Path['url']."$modulo/$seccion";
			$success = false;		
		}
		$data = array(success => $success, url => $url, html => $html);
	}
}
elseif($in[accion]=='login-perfil-select'){
	if(!empty($ins[id_usuario])){
		$usuario = login_unico($in[id_usuario]);
		$modulo = $parm[GENERAL];
		$seccion = $parm[INICIO];
		$url = $Path['url']."$modulo/$seccion";
		llena_sesion($usuario);					
		$success = true;		
		$data = array(success => $success, url => $url);
	}
}
elseif($in[accion]=='primer_logueo'){	
	$datos=validar_contrasenia($_SESSION[user][id_usuario]);
	if($datos[clave]==md5($in[pass])){
		$success = 'igual';
		$CONTENIDO=0;
	}
	else{
		$success=update_pass_user(md5($in[pass]),$_SESSION[user][id_personal]);
		if($success){
			$modulo = $parm[GENERAL];
			$seccion = $parm[INICIO];
			$CONTENIDO = $Path['url']."$modulo/$seccion";
		}
		else{
			$modulo 	= $parm[GENERAL];
			$seccion 	= $parm[ERROR];
			$CONTENIDO 	= $Path['url']."$modulo/$seccion";
			$success 	= true;
		}
	}
	$data = array(success => $success, url => $CONTENIDO);	
}

elseif($in[accion]=='contrasenia_popup'){	
	$CONTENIDO = build_contrasenia_popup('contrasenia_cambio');
	if($CONTENIDO){$success = true;}
	$data = array(success => $success, html => $CONTENIDO);
}

elseif($in[accion]=='contrasenia_cambio'){	
	$success=update_pass_user(md5($in[pass]), $_SESSION[user][id_personal]);
	if($success){
		$modulo = $parm[GENERAL];
		$seccion = $parm[INICIO];
		$CONTENIDO = $Path['url']."$modulo/$seccion";
	}
	$data = array(success => $success, url => $CONTENIDO);
}

function build_contrasenia_popup($accion){
	global $Path;
	$vista_new 	= 'general/login_popup.html';
	$tpl_data = array(
			 MORE 	 => incJs($Path[srcjs].'general/login_popup.js')
			,id 	 	 	=> 1
			,nombre	 	=> 'USUARIO'
			,clave	 	=> 'CLAVE'
			,guardar 	=> 'Guardar'			
			,cerrar	 	=> 'Cerrar'
			,accion		=> $accion	
			);		
	return contenidoHtml($vista_new, $tpl_data);
}

function build_usuario_perfiles($id_personal){
	global $usuario, $Path;
	$campos = array(
				'id_usuario'
			    ,'usuario'
				,'grupo'				
			);
	$tabla = perfiles($id_personal);
	foreach ($tabla as $registro) {		
		$tbl_resultados .= '<tr>';
		$soloUno = (!is_array($registro))?true:false; #Deteccion de total de registros
		$datos = (!$soloUno)?$registro:$tabla; #Seleccion de arreglo
		$tbl_resultados .= '<td align="center">'.++$x.'</td>';	
		for($i=0; $i<count($campos); $i++){
			$tbl_resultados .= ($datos[$campos[$i]])?'<td align="center">'.$datos[$campos[$i]].'</td>':'<td>-</td>';		
		}
		$tbl_resultados .= '<td align="center"><span class="btn" onclick="perfil('.$datos[id_usuario].');"><img src="'.$Path[img].'key.png" width="20" title="brightness" class="brightness" /></span></td>';	
		$tbl_resultados .= '</tr>';
		if($soloUno) break; 		
	}	
	return $tbl_resultados;
}

function llena_sesion($usuario=array()){
	$_SESSION[user]['id_usuario'] 		= $usuario[id_usuario];
	$_SESSION[user]['usuario'] 			= $usuario[usuario];
	$_SESSION[user]['activo'] 			= $usuario[activo];
	$_SESSION[user]['id_grupo']			= $usuario[id_grupo];
	$_SESSION[user]['grupo']			= $usuario[grupo];
	$_SESSION[user]['id_personal']		= $usuario[id_personal];
	$_SESSION[user]['nombre']			= $usuario[nombreCompleto];
	$_SESSION[user]['empleado_num']  	= $usuario[empleado_num]; 
	$_SESSION[user]['email'] 			= $usuario[email];
	$_SESSION[user]['id_empresa'] 		= $usuario[id_empresa];		
	$_SESSION[user]['id_empresa_nomina']= $usuario[id_empresa_nomina];	
	$_SESSION[user]['empresa'] 			= $usuario[empresa];
	$_SESSION[user]['pais'] 			= $usuario[pais];
	#Accesos en menú GROUP
	$visible_group 		= array_filter(preg_split("/[\s,;|*]+/", $usuario[visible_group]));
	$invisible_group	= array_filter(preg_split("/[\s,;|*]+/", $usuario[invisible_group]));
	$invisible_group 	= array_diff($invisible_group, $visible_group);
	#Accesos en menú USER
	$visible_user 		= array_filter(preg_split("/[\s,;|*]+/", $usuario[visible_user]));
	$invisible_user		= array_filter(preg_split("/[\s,;|*]+/", $usuario[invisible_user]));
	#Accesos en menú FINAL
	#USER tiene preferencia a GROUP
	$visible_final		= array_diff(array_unique(array_merge($visible_group, $visible_user)),$invisible_user);
	$invisible_final	= array_unique(array_merge($invisible_group, $invisible_user));
	$invisible_final 	= array_diff($invisible_final, $visible_final);
	$_SESSION[user]['accesos']['visible']			= implode(',',$visible_final);
	$_SESSION[user]['accesos']['invisible']			= implode(',',$invisible_final);
	#Menú
	$_SESSION[user]['menu'] 			= buildMenu($_SESSION[user]['accesos']['visible'],$_SESSION[user]['accesos']['invisible']);
	// dump_var($_SESSION[user]);
	return true;
}

// Resultado
$data = json_encode($data);
echo $data;
/*O3M*/
?>