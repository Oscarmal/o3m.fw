<?php session_name('o3m_fw'); session_start(); if(isset($_SESSION['header_path'])){include_once($_SESSION['header_path']);}else{header('location: '.dirname(__FILE__));}
/* O3M
* Crea las opciones del MENU principal del sistema
* 
*/
function buildMenu($elementos=0){
	global $Path, $usuario;
	for($i=1; $i<=$elementos+1; $i++){
		$link 	= 'LINK_OPC'.$i;
		$img 	= 'img_opc'.$i;
		$txt 	= 'txt_opc'.$i;
		if($usuario[accesos][mod.$i]){			
			switch($i){				
				case 3 : 
						unset($opt20,$opt34,$opt35,$opt30,$opt40,$opt50,$opt60);
						$opt50 = ($usuario[id_grupo]<60)?'<li><a href="#" onclick="location.href=\'{LINK_OPC31}\';" target="_self">{txt_opc31}</a></li>':'';
						$opt40 = ($usuario[id_grupo]<50)?'<li><a href="#" onclick="location.href=\'{LINK_OPC32}\';" target="_self">{txt_opc32}</a></li>':'';
						$opt35 = ($usuario[id_grupo]<36)?'<li><a href="#" onclick="location.href=\'{LINK_OPC33}\';" target="_self">{txt_opc33}</a></li>':'';
						// $opt34 = ($usuario[id_grupo]<35)?'<li><a href="#" onclick="location.href=\'{LINK_OPC34}\';" target="_self">{txt_opc34}</a></li>':'';
						// $opt30 = ($usuario[id_grupo]<34)?'<li><a href="#" onclick="location.href=\'{LINK_OPC35}\';" target="_self">{txt_opc35}</a></li>':'';				
						$submenu = '
					<ul>
			        	'.$opt50.'
			        	'.$opt40.'
			        	'.$opt35.'			        	
			        	'.$opt34.'			        	
			        	'.$opt30.'
			         </ul>';
					break;
				case 4 : 
						unset($opt20,$opt34,$opt35,$opt30,$opt40,$opt50,$opt60);
						$opt50 = ($usuario[id_grupo]<20 || ($usuario[id_grupo]>20 && $usuario[id_grupo]<=50))?'<li><a href="#" onclick="location.href=\'{LINK_OPC41}\';" target="_self">{txt_opc41}</a></li>':'';
						// $opt20 = ($usuario[id_grupo]<=20 || $usuario[id_grupo]==50)?'<li><a href="#" onclick="location.href=\'{LINK_OPC46}\';" target="_self">{txt_opc46}</a></li>':'';				
						$opt60 = ($usuario[id_grupo]<70)?'<li><a href="#" onclick="location.href=\'{LINK_OPC46}\';" target="_self">{txt_opc46}</a></li>':'';						
						// $opt50 = ($usuario[id_grupo]<60)?'<li><a href="#" onclick="location.href=\'{LINK_OPC41}\';" target="_self">{txt_opc41}</a></li>':'';
						// $opt40 = ($usuario[id_grupo]<50)?'<li><a href="#" onclick="location.href=\'{LINK_OPC42}\';" target="_self">{txt_opc42}</a></li>':'';
						// $opt35 = ($usuario[id_grupo]<36)?'<li><a href="#" onclick="location.href=\'{LINK_OPC43}\';" target="_self">{txt_opc43}</a></li>':'';
						// $opt34 = ($usuario[id_grupo]<35)?'<li><a href="#" onclick="location.href=\'{LINK_OPC44}\';" target="_self">{txt_opc44}</a></li>':'';
						// $opt30 = ($usuario[id_grupo]<34)?'<li><a href="#" onclick="location.href=\'{LINK_OPC45}\';" target="_self">{txt_opc45}</a></li>':'';				
						$submenu = '
					<ul>
						'.$opt50.'
						'.$opt60.'			        	
			        	'.$opt40.'
			        	'.$opt35.'			        	
			        	'.$opt34.'			        	
			        	'.$opt30.'
			        	'.$opt20.'
			        	<li><a href="#" onclick="location.href=\'{LINK_OPC47}\';" target="_self">{txt_opc47}</a></li>
			         </ul>';
					break;
				case 5 : 
						unset($opt20,$opt34,$opt35,$opt30,$opt40,$opt50,$opt60);
						$submenu = '
					<ul>
			        	<li><a href="#" onclick="location.href=\'{LINK_OPC51}\';" target="_self">{txt_opc51}</a></li>
			        	<li><a href="#" onclick="location.href=\'{LINK_OPC52}\';" target="_self">{txt_opc52}</a></li>			        				        	
			         </ul>';
					break;
				case 6 : 
						unset($opt20,$opt34,$opt35,$opt30,$opt40,$opt50,$opt60);
						$submenu = '
					<ul>
			        	<li><a href="#" onclick="location.href=\'{LINK_OPC60}\';" target="_self">{txt_opc60}</a></li>
			        	<li><a href="#" onclick="location.href=\'{LINK_OPC61}\';" target="_self">{txt_opc61}</a></li>
			        	<li><a href="#" onclick="location.href=\'{LINK_OPC62}\';" target="_self">{txt_opc62}</a></li>
			        	
			         </ul>';
					break;				
				case 7 : 
						unset($opt20,$opt34,$opt35,$opt30,$opt40,$opt50,$opt60);
						$opt21 = ($usuario[id_grupo]<=20)?'<li><a href="#" onclick="location.href=\'{LINK_OPC74}\';" target="_self">{txt_opc74}</a></li>
								<li><a href="#" onclick="location.href=\'{LINK_OPC76}\';" target="_self">{txt_opc76}</a></li>
								<li><a href="#" onclick="location.href=\'{LINK_OPC71}\';" target="_self">{txt_opc71}</a></li>
								':'';
						$opt20 = ($usuario[id_grupo]<20)?'<li><a href="#" onclick="location.href=\'{LINK_OPC73}\';" target="_self">{txt_opc73}</a></li>':'';
						$calendario = ($usuario[id_grupo]<=20)?'<li><a href="#" onclick="location.href=\'{LINK_OPC75}\';" target="_self">{txt_opc75}</a></li>':'';						
						$submenu = '
						<ul>
				        	<li><a href="#" onclick="location.href=\'{LINK_OPC72}\';" target="_self">{txt_opc72}</a></li>
				        '.$opt21.'		        	
				        '.$opt20.'
				        '.$calendario.'
				         </ul>';
						break;
			default: $submenu = ''; break;
			}
			$opc   .= '<li><a href="#" onclick="location.href=\'{'.$link.'}\';" target="_self"><img src="'.$Path[img].'{'.$img.'}" alt="" class="icono_dos"/>{'.$txt.'}</a>'.$submenu.'</li>';
		}
	}
	return $opc;
}
/*O3M*/
?>