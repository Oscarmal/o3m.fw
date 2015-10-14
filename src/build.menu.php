<?php session_name('o3m_fw'); session_start(); if(isset($_SESSION['header_path'])){include_once($_SESSION['header_path']);}else{header('location: '.dirname(__FILE__));}
/** 
* Descripción:	Crea las opciones del MENU principal del sistema
* @author:		Oscar Maldonado - O3M
* Creación: 	2013-02-16
* Modificación:	2015-10-14;
**/

function buildMenu(){
	global $cfg, $Path, $usuario;
	#Extraccion de datos de la DB-tabla de menú
	$menus = select_menus();
	if($menus){
		#Construcción de menu
		foreach($menus as $menu_element){
			#Link
			$e = explode('/', $menu_element[link]);
			$enlace = ($cfg[encrypt_onoff])?encrypt(strtoupper($e[0]),1).'/'.encrypt(strtoupper($e[1]),1):strtolower($menu_element[link]);
			$link 	= $Path['url'].$enlace;
			#Texto
			$texto  = utf8_encode($menu_element[texto]);
			#Imagen
			$imagen = (!empty($menu_element[ico]))?'<img src="'.$Path[img].$menu_element[ico].'" alt="'.utf8_encode($menu_element[texto]).'" class="icono_dos"/>':'';
			#onClick
			$onclick = (!empty($menu_element[link]))?'onclick="location.href=\''.$link.'\';"':'';			
			#Construccion de arreglo
			switch ($menu_element[nivel]) {
				case 1: $subs =& $menu_array; break;
				case 2: $subs =& $menu_array[$menu_element[id_grupo]][subs]; break;
				case 3: $subs =& $menu_array[$menu_element[id_grupo]][subs][$menu_element[id_superior]][subs]; $margen='&nbsp;&nbsp'; break;
			}
			#Elemento final
			$html = '<span class="menu_opt" id="'.$menu_element[menu].'" '.$onclick.'>'.$margen.$imagen.$texto.'</span>';		
			$subs [$menu_element[id_menu]] = array(name=>$menu_element[texto], html=>$html, subs=>array());
			unset($subs, $margen);
		}
		$menu_html = build_ul_menu($menu_array);	
		return $menu_html;
	}else{return false;}
}
function select_menus($id_grupo=false, $nivel=false){
// Regresa listado de la tabla de mené del sistema
	global $db;
	$filtro .= ($id_grupo)?"AND a.id_grupo='$id_grupo'":'';
	$filtro .= ($nivel)?"AND a.nivel='$nivel'":'';
	$sql = "SELECT a.*, b.menu as pertenece, c.menu as superior	,CONCAT(a.id_superior,'-',a.orden,'-',a.nivel) as llave
			FROM $db[tbl_menus] a
			LEFT JOIN $db[tbl_menus] b ON a.id_grupo=b.id_menu AND b.nivel=1 
			LEFT JOIN $db[tbl_menus] c ON a.id_superior=c.id_menu
			WHERE 1 AND a.activo=1 $filtro
			ORDER BY a.id_grupo, a.nivel, a.orden ASC;";
	$resultado = SQLQuery($sql);
	$resultado = ($resultado[0]) ? $resultado : false ;
	return $resultado;
}

function build_ul($array=array()){
// Construye una lista HTML a partir de un arreglo recibido:  <ul><li>[datos]</li>/ul>
	if($array){
	  	$html = '<ul>';
		foreach($array as $key => $item){
			$html.= (is_array($item))?'<li>'.utf8_encode($key).build_ul($item).'</li>':'<li>'.$item.'</li>';
	  	} 
	  	$html .= '</ul>'; 
	  	return $html;
	}else{ return false;}
}

function build_ul_menu($array=array()){
// MENÚ - Construye una lista HTML a partir de un arreglo recibido:  <ul><li>[datos]</li>/ul>
	if($array){
	  	$html = "\n".'<ul>';
		foreach($array as $elemento){
			$html.= "\n";
			$html.= ($elemento[subs])?'<li>'.$elemento[html].build_ul_menu($elemento[subs]).'</li>':'<li>'.$elemento[html].'</li>';			
	  	} 
	  	$html .= "\n".'</ul>'; 
	  	return $html;
	}else{ return false;}
}
/*O3M*/
?>