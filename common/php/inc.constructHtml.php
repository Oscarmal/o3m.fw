<?php /*O3M*/
/**
* Descripcion:	Funciones para contruir la vista de salida HTML
* Creación:		2014-06-17
* @author 		Oscar Maldonado - O3M
*
*/

// -- Principales
function contenedorHtml($template='system/error.html', $params=array()){
	global $Path;
	#GENERAL
	$htmlTpl = $Path['html'].$template;
	$html = new Template($htmlTpl);
	$html->set('PATH_JS', $Path[js]);
	$html->set('PATH_CSS', $Path[css]);
	$html->set('PATH_IMG', $Path[img]);
	$more = ($params[MORE])?$params[MORE]:'';
	$html->set('INCLUDES', includesHtml($more));
	$html->set('FOOTER', footerHtml());
	$html->set('POPUPS', popupsHtml());	
	$contenido_tpl 		= ($params[CONT_VIEW]=='')?'system/error.html':$params[CONT_VIEW];
	$contenido_params 	= (!$params[CONT_PARAMS])?array():$params[CONT_PARAMS];
	$html->set('CONTENIDO', contenidoHtml($contenido_tpl, $contenido_params));	
	// Busca variables adicionales dentro array $params
	if($tvars = count($params)){		
		$vnames = array_keys($params);
		$vvalues = array_values($params);
		foreach($params as $vname => $vvalue){
			$html->set($vname, $vvalue);
		}
	}
	$html=$html->output();
	return $html;
}
function contenidoHtml($template='system/error.html', $params=array()){
	global $Path;
	#GENERAL
	$htmlTpl = $Path['html'].$template;
	$html = new Template($htmlTpl);
	$html->set('PATH_JS', $Path[js]);
	$html->set('PATH_CSS', $Path[css]);
	$html->set('PATH_IMG', $Path[img]);
	$more = ($params[MORE])?$params[MORE]:'';
	$html->set('INCLUDES', includesHtml($more));
	$html->set('FOOTER', footerHtml());
	$html->set('POPUPS', popupsHtml());	
	// Busca variables adicionales dentro array $params
	if($tvars = count($params)){		
		$vnames = array_keys($params);
		$vvalues = array_values($params);
		foreach($params as $vname => $vvalue){
			$html->set($vname, $vvalue);
		}
	}
	$html=$html->output();
	return $html;
}
// -- Apoyos
function includesHtml($more='', $template='system/includes.html', $params=array()){
	global $Path, $Raiz, $cfg;
	#INCLUDES HTML
	$htmlTpl = $Path['html'].$template;
	$includes = new Template($htmlTpl);
	$includes->set('PATH_JS', $Path[js]);
	$includes->set('PATH_CSS', $Path[css]);
	$includes->set('PATH_IMG', $Path[img]);
	$includes->set('APP_TITULO', $cfg[site_title]);
	$more = ($more)?$more:'';
	$includes->set('MORE', $more);
	$includes=$includes->output();
	return $includes;
}

function footerHtml($template='system/footer.html', $params=array()){
	global $Path, $Raiz;
	#FOOTER CONTENIDO
	$htmlTpl = $Path['html'].$template;
	$footer = new Template($htmlTpl);
	$footer->set('PATH_JS', $Path[js]);
	$footer->set('PATH_CSS', $Path[css]);
	$footer->set('PATH_IMG', $Path[img]);
	$footer->set('ANIO', date('Y'));
	$footer=$footer->output();
	return $footer;
}
function popupsHtml($params=array()){
	global $Path;
	#POPUPS
	$template='system/popups.html';
	$htmlTpl = $Path['html'].$template;
	$popups = new Template($htmlTpl);
	// Busca variables adicionales dentro array $params
	if($tvars = count($params)){		
		$vnames = array_keys($params);
		$vvalues = array_values($params);
		foreach($params as $vname => $vvalue){
			$popups->set($vname, $vvalue);
		}
	}
	$popups=$popups->output();
	return $popups;
}
/*O3M*/
?>