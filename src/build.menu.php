<?php session_name('o3m_fw'); session_start(); if(isset($_SESSION['header_path'])){include_once($_SESSION['header_path']);}else{header('location: '.dirname(__FILE__));}
/** 
* Descripción:	Crea las opciones del MENU principal del sistema
* @author:		Oscar Maldonado - O3M
* Creación: 	2013-02-16
* Modificación:	2015-10-14;
**/

function buildMenu($visible=false, $invisible=false){
	global $cfg, $Path, $usuario;
	#Extraccion de datos de la DB-tabla de menú
	$menus = select_menus(false,false,$visible,$invisible);
	if($menus){
		$menus = (!is_array($menus[0]))?array($menus):$menus;
		#Deteccion de total de elementos por grupo
		foreach($menus as $elm){$grupos [] = $elm[id_grupo]; $subgrupos [] = $elm[id_superior];}
		// $menu_array[grupos] = array_count_values($grupos);	
		$grupos = array_count_values($grupos);
		$subgrupos = array_count_values($subgrupos);
		$subgrupos = array_diff_key($subgrupos, $grupos);
		foreach ($subgrupos as $subgrupo => $sub) {
			$grupos[$subgrupo] = $sub;
		}
	    $menu_array[grupos] = $grupos;
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
			// $html 	= '<a href="#" class="menu_opt" id="'.$menu_element[menu].'" '.$onclick.'>'.$margen.$imagen.$texto.$flecha.'</a>'.$input;		
			$html 	= $margen.$imagen.$texto;		
			$subs [$menu_element[id_menu]] = array(
						id_menu 	=> $menu_element[id_menu], 
						id_grupo 	=> $menu_element[id_grupo], 
						menu 		=> $menu_element[menu],
						texto 		=> $menu_element[texto], 
						nivel 		=> $menu_element[nivel], 
						html 		=> $html, 
						onclick 	=> $onclick,
						subs 		=> array()
					);
			unset($subs, $margen);
		}		
		$menu_html = build_ul_menu_01($menu_array);	
		return $menu_html;
	}else{return false;}
}
function select_menus($id_grupo=false, $nivel=false, $visible=false, $invisible=false){
// Regresa listado de la tabla de mené del sistema
	global $db, $usuario;
	$visible = (!$visible)?$usuario[accesos][visible]:$visible;
	$invisible = (!$invisible)?$usuario[accesos][invisible]:$invisible;
	// $si = "SELECT id_menu FROM $db[tbl_menus] WHERE id_grupo IN (".$usuario[accesos][visible].")";
	// $no = "SELECT id_menu FROM $db[tbl_menus] WHERE id_menu IN (".$usuario[accesos][invisible].")";
	// $visible 	= ($usuario[accesos][visible])?"AND a.id_menu IN(".$si.")":'';
	// $invisible 	= ($usuario[accesos][invisible])?"AND a.id_menu NOT IN(".$no.")":'';
	$visible 	= ($visible)?"AND FIND_IN_SET(a.id_menu, '".$visible."')":'';
	$invisible 	= ($invisible)?"AND (NOT FIND_IN_SET(a.id_grupo, '".$invisible."') AND NOT FIND_IN_SET(a.id_menu, '".$invisible."'))":'';
	$filtro .= ($id_grupo)?"AND a.id_grupo='$id_grupo'":'';
	$filtro .= ($nivel)?"AND a.nivel='$nivel'":'';
	$sql = "SELECT a.*, b.menu as pertenece, c.menu as superior
			FROM $db[tbl_menus] a
			LEFT JOIN $db[tbl_menus] b ON a.id_grupo=b.id_menu AND b.nivel=1 
			LEFT JOIN $db[tbl_menus] c ON a.id_superior=c.id_menu
			WHERE 1 AND a.activo=1 $visible $invisible $filtro
			ORDER BY a.id_grupo, a.nivel, a.orden ASC;";
			// dump_var($sql);
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
			$html_link 	= '<a href="#" '.$elemento[onclick].'>'.$elemento[html].$flecha.'</a>'.$input;
			$html.= ($elemento[subs])?'<li>'.$html_link.build_ul_menu($elemento[subs]).'</li>':'<li>'.$html_link.'</li>';			
	  	} 
	  	$html .= "\n".'</ul>'; 
	  	return $html;
	}else{ return false;}
}

function build_ul_menu_01($array=array()){
// MENÚ - Construye una lista HTML a partir de un arreglo recibido:  <ul><li>[datos]</li>/ul>
	if($array){
		#Grupos
		if(array_key_exists('grupos', $array)){
			$grupos = $array[grupos];
			unset($array[grupos]);
		}
		#Detección de nivel
		if($array[nivel]){
			$clase_ul 	= 'sub-menu';			
		}else{
			$clase_ul 	= 'main-menu cf';
			$html 	   .= '<label for="tm" id="toggle-menu">Menú<span class="drop-icon">▾</span></label>
			<input type="checkbox" id="tm">';
		}	
		#Inicio de lista
	  	$html .= "\n".'<ul class="'.$clase_ul.'">';
		foreach($array as $elemento){
			#Submenu	
			if($grupos[$elemento[id_grupo]]>1){
				#Flechas
				$flecha = ' <span class="drop-icon">▾</span><label class="drop-icon" for="sm'.$elemento[id_menu].'">▾</label>';
				$input 	= '<input type="checkbox" id="sm'.$elemento[id_menu].'">';
			}else{unset($flecha, $input);}
			$html_link 	= '<a href="#" '.$elemento[onclick].'>'.$elemento[html].$flecha.'</a>'.$input;
			#HTML 
			if(is_array($elemento)){
				$html.= "\n";
				if($elemento[subs]){		
					$elemento[subs][nivel] = $elemento[nivel];
					$elemento[grupos] = $grupos;
					$html.='<li>'.$html_link.build_ul_menu_01($elemento[subs]).'</li>';
				}else{
					$html.='<li>'.$html_link.'</li>';
				}
			}
	  	} 
	  	$html .= "\n".'</ul>'; 
	  	return $html;
	}else{ return false;}
}
/*O3M*/
?>