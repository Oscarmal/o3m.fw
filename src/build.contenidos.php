<?php session_name('o3m_fw'); session_start(); if(isset($_SESSION['header_path'])){include_once($_SESSION['header_path']);}else{header('location: '.dirname(__FILE__));}
/* O3M
* Funciones para construir contenidos HTML
* 
*/
require_once($Path[src].'mod-01/dao.mod-01.php');
require_once($Path[src].'mod-02/dao.autorizacion.php');
require_once($Path[src].'mod-03/dao.consulta.php');
require_once($Path[src].'mod-04/dao.reportes.php');
require_once($Path[src].'mod-05/dao.admin.php');
//*****************************************************************************************************************************************
// CONSULTA
function build_grid_consulta_autorizacion_1(){
	// Construye listado de horas extra capturadas
	global $usuario, $dic;
	$sqlData = array(
			 auth 		=> true
			,estatus	=> 1
			,activo		=> 1
		);
	$tabla = listado_select_autorizacion_1($sqlData);	
	$campos = array(
				 'id_horas_extra'
				,'nombre_completo'
				,'empleado_num'
				,'estado'
				,'sucursal'
				,'localidad'
				,'puesto'
				,'fecha'
				,'horas'
				,'tiempoextra'
				,'auth_nombre'
			);	
	switch ($usuario[id_grupo]) {
		case 50: $nivel = 1; break;		
		case 40: $nivel = 2; break;
		case 35: $nivel = 3; break;
		case 34: $nivel = 4; break;
		case 30: $nivel = 5; break;
		default: $nivel = 1; break;
	}
	// dump_var($tabla);
	if($tabla){	
		foreach ($tabla as $registro) {		
			$tbl_resultados .= '<tr class="gradeA">';
			$soloUno = (!is_array($registro))?true:false; #Deteccion de total de registros
			$data = (!$soloUno)?$registro:$tabla; #Seleccion de arreglo	
			for($i=0; $i<count($campos); $i++){
				$data[$campos[$i]] = ($data[$campos[$i]]=='00:00:00')?'-':$data[$campos[$i]];
				$tbl_resultados .= '<td>'.utf8_encode($data[$campos[$i]]).'</td>';
			}
			$estatus = (is_null($data[n1_estatus]))?99:$data[n1_estatus];
			$override = ($estatus!=0)?'<a onclick="popup_override('.$data[id_horas_extra].',\''.$data[dobles].'\',\''.$data[triples].'\',\''.$data[rechazadas].'\');" class="enlace azul" title="'.$dic[general][modificar].'">['.$dic[general][modificar].']</a>':'';
			$override = ($data[nivel]<=$nivel && $data[n1_estatus]!='')?$override:'';
			switch ($estatus) {
				case 0:  $valor='<div style="color:#FF0000;">Rechazado</div><p class="txt_largo">'.utf8_encode($data[argumento]).'</p>'; break;
				case 1:  $valor='<div style="color:#31B404;" >Aceptado</div><p class="txt_largo">'.utf8_encode($data[argumento]).'</p>'; break;				
				default: $valor='<div style="color:#DF7401;">Pendiente</div>'; break;
			}				
			$tbl_resultados .= '<td>'.$valor.$override.'</td>';
			$tbl_resultados .= '</tr>';
			if($soloUno) break;
		}
	}
	return $tbl_resultados;
}
function build_grid_consulta_autorizacion_2($data=array()){
// Construye listado de horas extra autorizadas
	global $usuario, $Path;
	$sqlData = array(
			 auth 		=> true
			,estatus 	=> 1
			,orden		=> 'a.id_horas_extra DESC'
			,xls 		=> $data[xls]
		);
	
	$tabla = listado_select_autorizacion_2($sqlData);
	//dump_var($tabla);
	$campos = array(
				 'id_horas_extra'
				,'nombre_completo'
				,'empleado_num'
				,'empresa'
				,'sucursal'
				,'fecha'
				,'horas'
			);
	if($tabla){
		foreach ($tabla as $registro) {		
			$tbl_resultados .= '<tr class="gradeA">';
			$soloUno = (!is_array($registro))?true:false; #Deteccion de total de registros
			$data = (!$soloUno)?$registro:$tabla; #Seleccion de arreglo
			for($i=0; $i<count($campos); $i++){
				
				$tbl_resultados .= ($data[$campos[$i]])?'<td>'.$data[$campos[$i]].'</td>':'<td>-</td>';
			}
		$estatus = (is_null($data[n2_estatus]))?99:$data[n2_estatus];
			switch ($estatus) {
				case 0:  $valor='<div style="color:#FF0000;">Rechazado</div>'; break;
				case 1:  $valor='<div style="color:#31B404;">Aceptado</div>';	break;				
				default: $valor='<div style="color:#DF7401;">Pendiente</div>'; break;
			}
		$tbl_resultados .= '<td>'.$valor.'</td>';
			$tbl_resultados .= '</tr>';
			if($soloUno) break; 		
		}
	}
	
	return $tbl_resultados;
}
function build_grid_consulta_autorizacion_3(){
	// Construye listado de horas extra asignadas
	global $usuario, $Path;
	$sqlData = array(
			 auth 		=> true
			,estatus	=> 1
			,orden		=> 'a.id_horas_extra DESC'
		);
	$tabla = listado_select_autorizacion_3($sqlData);	
	$campos = array(
			  	'id_horas_extra'
				,'nombre_completo'
				,'empleado_num'
				,'empresa'
				,'sucursal'
				,'fecha'
				,'horas'
				//,'capturado_por'
				//,'capturado_el'
				//,'asignado_por'
				//,'asignado_el'					
			);
	if($tabla){
		foreach ($tabla as $registro) {		
			$tbl_resultados .= '<tr class="gradeA">';
			$soloUno = (!is_array($registro))?true:false; #Deteccion de total de registros
			$data = (!$soloUno)?$registro:$tabla; #Seleccion de arreglo
			for($i=0; $i<count($campos); $i++){
				$tbl_resultados .= ($data[$campos[$i]])?'<td>'.$data[$campos[$i]].'</td>':'<td>-</td>';		
			}
			$estatus = (is_null($data[n3_estatus]))?99:$data[n3_estatus];
			switch ($estatus) {
				case 0:  $valor='<div style="color:#FF0000;">Rechazado</div>'; break;
				case 1:  $valor='<div style="color:#31B404;">Aceptado</div>';	break;				
				default: $valor='<div style="color:#DF7401;">Pendiente</div>'; break;
			}
			$tbl_resultados .= '<td>'.$valor.'</td>';
			$tbl_resultados .= '</tr>';
			if($soloUno) break; 		
		}	
	}
	
	return $tbl_resultados;
}
function build_grid_consulta_autorizacion_4(){
	// Construye listado de horas extra autorizadas

	global $usuario, $Path;
	$sqlData = array(
			 auth 		=> true
			,estatus	=> 1
			,orden		=> 'a.id_horas_extra DESC'
		);
	$tabla = listado_select_autorizacion_4($sqlData);	
	$campos = array(
			  	'id_horas_extra'
				,'nombre_completo'
				,'empleado_num'
				,'empresa'
				,'sucursal'
				,'fecha'
				,'horas'
			);
	if($tabla){
		foreach ($tabla as $registro) {		
			$tbl_resultados .= '<tr class="gradeA">';
			$soloUno = (!is_array($registro))?true:false; #Deteccion de total de registros

			$data = (!$soloUno)?$registro:$tabla; #Seleccion de arreglo
			
			for($i=0; $i<count($campos); $i++){
				$tbl_resultados .= ($data[$campos[$i]])?'<td>'.$data[$campos[$i]].'</td>':'<td>-</td>';		
			}			
			$estatus = (is_null($data[n4_estatus]))?99:$data[n4_estatus];
			switch ($estatus) {
				case 0:  $valor='<div style="color:#FF0000;">Rechazado</div>'; break;
				case 1:  $valor='<div style="color:#31B404;">Aceptado</div>';	break;				
				default: $valor='<div style="color:#DF7401;">Pendiente</div>'; break;
			}			
			$tbl_resultados .= '<td>'.$valor.'</td>';
			$tbl_resultados .= '</tr>';
			if($soloUno) break; 		
		}	
	}
	return $tbl_resultados;
}
function build_grid_consulta_autorizacion_5($data=array()){
/**
* Construye listado de horas extra autorizadas 
*/
	global $usuario, $Path;
	$sqlData = array(
			 auth 		=> true
			,estatus	=> 1
			,activo 	=> 1
			,orden		=> 'a.id_horas_extra DESC'
		);
	$tabla = listado_select_autorizacion_5($sqlData);
	$campos = array(
				 'id_horas_extra'
				,'nombre_completo'
				,'empleado_num'
				,'empresa'
				,'sucursal'
				,'fecha'
				,'horas'	
			);
	if($tabla){
		foreach ($tabla as $registro) {	
			$tbl_resultados .= '<tr class="gradeA">';
			$soloUno = (!is_array($registro))?true:false; #Deteccion de total de registros
			$data = (!$soloUno)?$registro:$tabla; #Seleccion de arreglo
			for($i=0; $i<count($campos); $i++){
				$tbl_resultados .= ($data[$campos[$i]])?'<td>'.$data[$campos[$i]].'</td>':'<td>-</td>';		
			}
			$estatus = (is_null($data[n5_estatus]))?99:$data[n5_estatus];
			switch ($estatus) {
				case 0:  $valor='<div style="color:#FF0000;">Rechazado</div>'; break;
				case 1:  $valor='<div style="color:#31B404;">Aceptado</div>';	break;				
				default: $valor='<div style="color:#DF7401;">Pendiente</div>'; break;
			}
		$tbl_resultados .= '<td>'.$valor.'</td>';
			$tbl_resultados .= '</tr>';
			if($soloUno) break; 		
		}
	}
	return $tbl_resultados;
}
function build_grid_consulta_autorizaciones(){
	global $usuario, $Path;
	$sqlData = array(
			 auth 		=> true
			,estatus	=> 1
			,activo 	=> 1
		);
	$tabla = listado_select_autorizaciones($sqlData);
	$campos = array(
				 'id_horas_extra'
				,'nombre_completo'
				,'id_nomina'
				,'empleado_num'
				,'estado'
				,'sucursal'
				,'localidad'
				,'puesto'
				,'fecha'
				,'horas'
				,'tiempoextra'
				// ,'dobles'
				// ,'triples'
				// ,'rechazadas'
				,'auth_nombre'
			);	
	switch ($usuario[id_grupo]) {
		case 50: $nivel = 1; break;		
		case 40: $nivel = 2; break;
		case 35: $nivel = 3; break;
		case 34: $nivel = 4; break;
		case 30: $nivel = 5; break;
		default: $nivel = 1; break;
	}
	// dump_var($tabla);
	if($tabla){	
		foreach ($tabla as $registro) {		
			$tbl_resultados .= '<tr class="gradeA">';
			$soloUno = (!is_array($registro))?true:false; #Deteccion de total de registros
			$data = (!$soloUno)?$registro:$tabla; #Seleccion de arreglo	
			for($i=0; $i<count($campos); $i++){
				$data[$campos[$i]] = ($data[$campos[$i]]=='00:00:00')?'-':$data[$campos[$i]];
				$tbl_resultados .= '<td>'.utf8_encode($data[$campos[$i]]).'</td>';
			}
			$estatus = (is_null($data[n1_estatus]))?99:$data[n1_estatus];			
			switch ($estatus) {
				case 0:  $valor='<div style="color:#FF0000;">Rechazado</div><p class="txt_largo">'.utf8_encode($data[argumento]).'</p>'; break;
				case 1:  $valor='<div style="color:#31B404;" >Aceptado</div><p class="txt_largo">'.utf8_encode($data[argumento]).'</p>'; break;				
				default: $valor='<div style="color:#DF7401;">Pendiente</div>'; break;
			}				
			$tbl_resultados .= '<td>'.$valor.'</td>';
			$tbl_resultados .= '</tr>';
			if($soloUno) break;
		}
	}
	return $tbl_resultados;
}
function build_grid_consulta_pendientes(){
	global $usuario, $Path;
	$sqlData = array(
			 auth 		=> true
			,estatus	=> 1
			,activo 	=> 1
		);
	$tabla = listado_select_pendientes($sqlData);
	$campos = array(
				 'id_horas_extra'
				,'nombre_completo'
				,'id_nomina'
				,'empleado_num'
				,'estado'
				,'sucursal'
				,'localidad'
				,'puesto'
				,'fecha'
				,'capturado_el'
				,'horas'
				,'nivel1_nombre'
				,'nivel1_mail'
			);	
	switch ($usuario[id_grupo]) {
		case 50: $nivel = 1; break;		
		case 40: $nivel = 2; break;
		case 35: $nivel = 3; break;
		case 34: $nivel = 4; break;
		case 30: $nivel = 5; break;
		default: $nivel = 1; break;
	}
	// dump_var($tabla);
	if($tabla){	
		foreach ($tabla as $registro) {		
			$tbl_resultados .= '<tr class="gradeA">';
			$soloUno = (!is_array($registro))?true:false; #Deteccion de total de registros
			$data = (!$soloUno)?$registro:$tabla; #Seleccion de arreglo	
			for($i=0; $i<count($campos); $i++){
				$data[$campos[$i]] = ($data[$campos[$i]]=='00:00:00')?'-':$data[$campos[$i]];				
				if($campos[$i]=='nivel1_nombre'){
					$tbl_resultados .= '<td><p>'.utf8_encode($data[$campos[$i]]).'<br/><a href="mailto:'.$data[nivel1_mail].'">'.$data[nivel1_mail].'</a>'.'</p></td>';
				}elseif($campos[$i]!='nivel1_mail'){					
					$tbl_resultados .= '<td>'.utf8_encode($data[$campos[$i]]).'</td>';
				}
			}
			$estatus = (is_null($data[n1_estatus]))?99:$data[n1_estatus];			
			switch ($estatus) {
				case 0:  $valor='<div style="color:#FF0000;">Rechazado</div><p class="txt_largo">'.utf8_encode($data[argumento]).'</p>'; break;
				case 1:  $valor='<div style="color:#31B404;" >Aceptado</div><p class="txt_largo">'.utf8_encode($data[argumento]).'</p>'; break;				
				default: $valor='<div style="color:#DF7401;">Pendiente</div>'; break;
			}				
			$tbl_resultados .= '<td>'.$valor.'</td>';
			$tbl_resultados .= '</tr>';
			if($soloUno) break;
		}
	}
	return $tbl_resultados;
}
//*****************************************************************************************************************************************
function build_select_empresas(){
	global $usuario;
	$sqlData = array( auth => true, activo => 1 );
	$tabla = empresas($sqlData);	
	// $readonly = ($usuario[grupo]>1)?'readonly="readonly" onmouseover="this.disabled=true;" onmouseout="this.disabled=false;"':'';
	$objeto = "<select id='sel_empresa' name='sel_empresa' $readonly >";
	// $objeto .= ($usuario[grupo]<=1)?'<option value="" selected="selected">Todas</option>' : '' ;
	foreach ($tabla as $registro) {
		$data = (!is_array($registro))?$tabla:$registro; 
		$regs = (!is_array($registro))?count($tabla)/2:1; 
		for($i=0; $i<$regs; $i++){
			$objeto .='<option value="'.$data[id_empresa].'">'.$data[empresa].'</option>'; 
		if(!is_array($registro)) break;
		}
		if(!is_array($registro)) break;
	}
	$objeto .= "</select>";
	return $objeto;
}
function build_select_anios($id_empresa=false){
	$sqlData = array( auth => true, id_empresa => $id_empresa );
	$tabla = anios($sqlData);		
	$objeto = "<select id='sel_anio' name='sel_anio'>";	
	foreach ($tabla as $registro) {
		$soloUno = (!is_array($registro))?true:false; 
		$data = (!$soloUno)?$registro:$tabla;		
		for($i=0; $i<count($data)/2; $i++){				
			$objeto .='<option value="'.$data[anio].'">'.$data[anio].'</option>'; 
		}		
		if($soloUno) break;
	}
	$objeto .= (!$soloUno)?'<option value="" selected="selected">Todos</option>':'';		
	$objeto .= "</select>";
	return $objeto;
}
function build_grid_autorizaciones_aprobadas(){
	// Construye listado de horas extra autorizadas

	global $usuario, $Path;
	$sqlData = array(
			 auth 		=> true
			,estatus	=> 1
			,orden		=> 'g.id_horas_extra DESC'
		);
	$tabla = autorizaciones_aprobadas($sqlData);	
	$campos = array(
			  //	'id_horas_extra'
				'nombre_completo'
				,'empleado_num'
				,'fecha'
				,'horas'
				,'autorizado_por'
				,'autorizado_el'
			);
	$count=count($tabla);
	foreach ($tabla as $registro) {		
		$tbl_resultados .= '<tr class="gradeA">';
		$soloUno = (!is_array($registro))?true:false; #Deteccion de total de registros
		$data = (!$soloUno)?$registro:$tabla; #Seleccion de arreglo
		
		if($registro[id_horas_extra]){
			$tbl_resultados .= '<td>
									'.$registro[id_horas_extra].'
									<input type="hidden" id ="id_personal_'.$count.'" name="id_personal_'.$count.'" value="'.$registro[id_personal].'"/>
									<input type="hidden" id ="id_empresa_'.$count.'"  name="id_empresa_'.$count.'" value="'.$registro[id_empresa].'"/>
									<input type="hidden" id ="horas_rechazadas_'.$count.'"  name="horas_rechazadas_'.$count.'" value="'.$registro[horas_rechazadas].'"/>
									<input type="hidden" id ="horas_dobles_'.$count.'"  name="horas_dobles_'.$count.'" value="'.$registro[horas_dobles].'"/>
									<input type="hidden" id ="horas_triples_'.$count.'"  name="horas_triples_'.$count.'" value="'.$registro[horas_triples].'"/>
									<input type="hidden" id ="empleado_num_'.$count.'"  name="empleado_num_'.$count.'" value="'.$registro[empleado_num].'"/>
								</td>';	
		$count--;	
		}
		for($i=0; $i<count($campos); $i++){

			$tbl_resultados .= ($data[$campos[$i]])?'<td>'.$data[$campos[$i]].'</td>':'<td>-</td>';		
		}
		$tbl_resultados .= '<td><span class="btn" onclick="autorizar('.$data[0].');"><img src="'.$Path[img].'ico_edit.png" width="20" title="brightness" class="brightness"/></span></td>';
		// $tbl_resultados .= '<td align="center">
		// 						<select id="id_'.$data[0].'" name="id_'.$data[0].'" onChange="ok(this)" class="campos">
		// 							<option value="" selected></option>
		// 							<option value="1">1</option>
		// 							<option value="2">2</option>
		// 							<option value="3">3</option>
		// 							<option value="4">4</option>
		// 							<option value="5">5</option>
		// 						</select>
		// 					</td>';
		$tbl_resultados .= '</tr>';
		if($soloUno) break; 		
	}
	return $tbl_resultados;
}
//*****************************************************************************************************************************************
// SINCRONIZACION
function build_grid_usuarios(){
	global $Path;
	$sqlData = array(
			 auth 			=> 1
			,id_empresa		=> $usuario[id_empresa]
			,id_number		=> $usuario[id_number]
			,activo 		=> 1
		);
	$tabla = select_view_nomina($sqlData);	
	//dump_var($tabla);

	$campos = array(
				 'id_empresa'
				,'empresa'
				,'id_nomina'
				,'empleado_num'
				,'nombre'
				,'rfc'
				,'imss'
				,'puesto'
				,'fecha_corte'

			);
	
	foreach ($tabla as $registro) {		
		$tbl_resultados .= '<tr class="gradeA">';
		$soloUno = (!is_array($registro))?true:false; #Deteccion de total de registros
		$data = (!$soloUno)?$registro:$tabla; #Seleccion de arreglo	
		for($i=0; $i<count($campos); $i++){
			$tbl_resultados .= '<td>'.utf8_encode($data[$campos[$i]]).'</td>';
		}	
		$tbl_resultados .= '</tr>';
		if($soloUno) break; 		
	}
	return $tbl_resultados;
}
function build_catalgo_empresa(){
	$catalgo_empresa=select_catalgos_empresa();
	$select.='<select name="empresa" id="empresa" class="chosen-select" data-placeholder="Seleccione una empresa">
				<option value="0">Seleccione una Empresa</option>';
	foreach($catalgo_empresa as $empresa){
		$soloUno = (!is_array($empresa))?true:false; #Deteccion de total de registros
		$data = (!$soloUno)?$empresa:$catalgo_empresa; #Seleccion de arreglo
		for($i=1; $i<count($data)/2; $i++){
			$select.='<option value="'.$data[id_empresa].'"">'.utf8_encode($data[nombre]).'</option>';
		}
		if($soloUno) break;
	}
	$select.='</select>';
	return $select;
}
function build_catalgo_usuarios_grupo(){
	$catalgo_usuarios=select_catalgo_usuarios_grupo();
	
	$select.='<select name="usuario" id="usuario" class="chosen-select" data-placeholder="Seleccione un nivel">';
	foreach($catalgo_usuarios as $usuario){
		if($usuario[id_grupo]==50){
			$select.='<option value='.$usuario[id_grupo].' selected>'.$usuario[id_grupo].' - '.$usuario[grupo].'</option>';
		}
		else{
			$select.='<option value='.$usuario[id_grupo].'>'.$usuario[id_grupo].' - '.$usuario[grupo].'</option>';
		}
	}
	$select.='</select>';
	return $select;
}
function build_select_empresas_tabla(){
	$empresa_tabla=select_empresas_tabla();

	$campos = array(
				 'id_empresa'
				,'nombre'
				,'siglas'
				,'razon'
				,'timestamp'
			);
	foreach ($empresa_tabla as $registro) {		
		$tbl_resultados .= '<tr class="gradeA">';
		$soloUno = (!is_array($registro))?true:false; #Deteccion de total de registros
		$data = (!$soloUno)?$registro:$empresa_tabla; #Seleccion de arreglo	
		for($i=0; $i<count($campos); $i++){
			$tbl_resultados .= '<td>'.utf8_encode($data[$campos[$i]]).'</td>';
		}	
		$tbl_resultados .= '</tr>';
		if($soloUno) break; 		
	}
	return $tbl_resultados;
}
function build_catalgo_supervisores($nivel=1, $id_personal=false){
	global $usuario;
	$id_empresa = ($usuario[id_grupo]>20)?$usuario[id_empresa]:'';
	$sqlData = array(
		  auth 		=> 1
	);
	$catalgo_supervisores=select_catalgo_supervisores($sqlData);
	$sqlData = array(
		  auth 			=> 1
		 ,id_empresa 	=> $id_empresa
		 ,id_personal 	=> $id_personal
		 ,id_nivel 		=> $nivel
	);	
	$detecta_supervisor = select_detecta_supervisor($sqlData);	
	$select.='<select name="nivel'.$nivel.'" id="nivel'.$nivel.'" class="chosen-select" data-placeholder="Seleccione el supervisor del Nivel-'.$nivel.'" class="chosen-select">';		
	$select.='<option value="" selected>Seleccione el supervisor del Nivel-'.$nivel.'</option>';
	if($catalgo_supervisores){		
		foreach($catalgo_supervisores as $supervisor){
			$sel = ($supervisor[id_personal]==$detecta_supervisor[id_supervisor])?'selected':'';
			$select.='<option value="'.$supervisor[id_personal].'" '.$sel.'>'.utf8_encode($supervisor[nombre]).' - '.$supervisor[empleado_num].'</option>';
		}		
	}
	$select.='</select>';
	return $select;
}

function build_catalgo_supervisores_edit($nivel=1, $id_personal=false, $extra=false){
	global $usuario;
	$id_empresa = ($usuario[id_grupo]>20)?$usuario[id_empresa]:'';
	$sqlData = array(
		  auth 		=> 1
	);
	$catalgo_supervisores=select_catalgo_supervisores($sqlData);
	$sqlData = array(
		  auth 			=> 1
		 ,id_empresa 	=> $id_empresa
		 ,id_personal 	=> $id_personal
		 ,id_nivel 		=> $nivel
	);	
	$detecta_supervisor = select_detecta_supervisor($sqlData);	
	$select.='<select name="nivel'.$nivel.'_'.$id_personal.'" id="nivel'.$nivel.'_'.$id_personal.'" class="chosen-select" data-placeholder="Seleccione el supervisor del Nivel-'.$nivel.'" '.$extra.'>';		
	$select.='<option value="" selected>Seleccione el supervisor del Nivel-'.$nivel.'</option>';
	if($catalgo_supervisores){		
		foreach($catalgo_supervisores as $supervisor){
			$sel = ($supervisor[id_personal]==$detecta_supervisor[id_supervisor])?'selected':'';
			$select.='<option value="'.$supervisor[id_personal].'" '.$sel.'>'.utf8_encode($supervisor[nombre]).' - '.$supervisor[empleado_num].'</option>';
		}		
	}
	$select.='</select>';
	return $select;
}

function build_catalgo_sucursales_nomina($id=false, $sucursal_nomina=false, $extra=false){
	global $usuario;
	$id_empresa = ($usuario[id_grupo]>20)?$usuario[id_empresa]:'';
	$sqlData = array(
		  auth 		=> 1
	);
	$catalgo_sucursales=select_catalogo_sucursales_nomina($sqlData);
	$select.='<select name="'.$id.'" id="'.$id.'" class="chosen-select" data-placeholder="Seleccione una sucursal" '.$extra.'>';		
	$select.='<option value="" selected>Seleccione una sucursal</option>';
	if($catalgo_sucursales){		
		foreach($catalgo_sucursales as $sucursal){
			$sel = ($sucursal[sucursal_nomina]==$sucursal_nomina)?'selected':'';
			$select.='<option value="'.$sucursal[sucursal_nomina].'" '.$sel.'>'.utf8_encode($sucursal[sucursal_nomina]).'</option>';
		}		
	}
	$select.='</select>';
	return $select;
}



//*****************************************************************************************************************************************
// REPORTES
function build_reporte01($id_empresa=false, $anio=false, $periodo=false){
// Construye reporte general
	global $Path;
	$sqlData = array( auth => true, id_empresa => $id_empresa, anio => $anio, periodo => $periodo );
	$tabla = select_reporte_general_por_anio($sqlData);
	// dump_var($tabla);
	$campos = array(
				 // 'id_empresa',
				'empresa'
				,'siglas'
				,'anio_fecha'
				,'capturadas_horas'
				,'pendientes_horas'
				,'autorizadas_horas'
				,'rechazadas_horas'
				,'pagadas_horas'
				,'dobles_horas'
				,'triples_horas'
				,'capturadas_porcentaje'
				,'pendientes_porcentaje'
				,'autorizadas_porcentaje'
				,'rechazadas_porcentaje'
				,'pagadas_porcentaje'
				,'dobles_porcentaje'
				,'triples_porcentaje'
			);
	if($tabla){
		foreach ($tabla as $registro) {		
			++$x;
			$tbl_resultados .= '<tr >';
			$soloUno = (!is_array($registro))?true:false; #Deteccion de total de registros
			$data = (!$soloUno)?$registro:$tabla; #Seleccion de arreglo	
			for($i=0; $i<count($campos); $i++){
				if($campos[$i]=='anio_fecha'){					
					$tbl_resultados .= '<td style="min-width:50px;">'.'<span id="grupo-'.$x.'" class="arrow">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$data[$campos[$i]].'</span></td>';
				}
				elseif($i<=2){
					$tbl_resultados .= '<td>'.$data[$campos[$i]].'</td>';
				}else{
					$c = explode('_', $campos[$i]);
					$t = explode(':',$data[$c[0].'_horas']);
					$tiempo = $t[0].':'.$t[1];
					if($c[1]=='porcentaje')
					break;
					$tbl_resultados .= '<td>'.$tiempo.' hrs. <br/> '.$data[$c[0].'_porcentaje'].' </td>';
				}
			}
			// Detalle
			$tbl_resultados .= '<tr><td colspan="10">';
			$tbl_resultados .= '<div id="tabla-detalles-'.$x.'">
								<table class="tabla_acordeon">';
			$tbl_resultados .= '<thead>
								<tr>
									<th>Año</th>
									<th>Perioro<br/>Inicio</th>
									<th>Periodo<br/>Fin</th>
									<th>Horas<br/>Capturadas</th>
					                <th>Horas<br/>Pendientes</th>
					                <th>Horas<br/>Autorizadas</th>
					                <th>Horas<br/>Rechazadas</th>
					                <th>Horas<br/>Pagadas</th>
					                <th>Horas<br/>Dobles</th>
					                <th>Horas<br/>Triples</th>
								</tr>
								</thead>
								<tbody>
			';
			$sqlData_detalle = array( auth => 1, id_empresa => $data[id_empresa], anio => $data[anio_fecha] );
			$tabla_detalle = select_reporte_por_periodo($sqlData_detalle);
			// dump_var($tabla_detalle);
			$campos_detalle = array(
				'anio_fecha'
				,'periodo_inicio'
				,'periodo_fin'
				,'capturadas_horas'
				,'pendientes_horas'
				,'autorizadas_horas'
				,'rechazadas_horas'
				,'pagadas_horas'
				,'dobles_horas'
				,'triples_horas'
				,'capturadas_porcentaje'
				,'pendientes_porcentaje'
				,'autorizadas_porcentaje'
				,'rechazadas_porcentaje'
				,'pagadas_porcentaje'
				,'dobles_porcentaje'
				,'triples_porcentaje'
			);
			foreach ($tabla_detalle as $registro_detalle) {	
				$tbl_resultados .= '<tr>';
				$soloUno_detalle = (!is_array($registro_detalle))?true:false; #Deteccion de total de registros
				$data_detalle = (!$soloUno_detalle)?$registro_detalle:$tabla_detalle; #Seleccion de arreglo	
				for($n=0; $n<count($campos_detalle); $n++){					
					// $tbl_resultados .= '<td>'.utf8_encode($data_detalle[$campos_detalle[$i]]).'</td>';
					if($n<=2){
						$tbl_resultados .= '<td>'.$data_detalle[$campos_detalle[$n]].'</td>';
					}else{
						$c2 = explode('_', $campos_detalle[$n]);
						$t2 = explode(':',$data_detalle[$c2[0].'_horas']);
						$tiempo_detalle = $t2[0].':'.$t2[1];
						if($c2[1]=='porcentaje')
						break;
						$tbl_resultados .= '<td>'.$tiempo_detalle.' hrs. <br/> '.$data_detalle[$c2[0].'_porcentaje'].' </td>';
					}
				}							
				$tbl_resultados .= '</tr>';
			 if($soloUno_detalle) break;
			}
			$tbl_resultados .= '</tbody></table></div>';
			$tbl_resultados .= '</td></tr>';
			// Fin Detalle
			$tbl_resultados .= '</tr>';
			if($soloUno) break;
		}		
		return $tbl_resultados;
	}		
}

function build_reporte_periodos($id_empresa=false, $anio=false, $periodo=false){
// Construye reporte general
	global $Path;
	$sqlData = array( auth => true, id_empresa => $id_empresa, anio => $anio, periodo => $periodo );
	$tabla = select_reporte_por_periodo($sqlData);
	// dump_var($tabla);
	$campos = array(
				 // 'id_empresa',
				'empresa'
				,'siglas'
				,'nomina_anio'
				,'nomina_periodo'
				,'nomina_periodo_especial'
				,'capturadas_horas'
				,'autorizadas_horas'
				,'pagadas_horas'
				,'dobles_horas'
				,'triples_horas'
				,'capturadas_porcentaje'
				,'autorizadas_porcentaje'
				,'pagadas_porcentaje'
				,'dobles_porcentaje'
				,'triples_porcentaje'
			);
	if($tabla){
		foreach ($tabla as $registro) {		
			++$x;
			$soloUno = (!is_array($registro))?true:false; #Deteccion de total de registros
			$data = (!$soloUno)?$registro:$tabla; #Seleccion de arreglo	
			$tbl_resultados .= '<tr >';
			$tbl_resultados .= '<td  align="center">'.'<span id="grupo-'.$x.'" class="arrow">&nbsp;</span></td>';
			$tbl_resultados .= '<td >'.'<span class="excel" onclick="descargar_xls('.$data[id_empresa].','.$data[nomina_anio].','.$data[nomina_periodo].',\''.$data[nomina_periodo_especial].'\')">&nbsp;</span></td>';
			for($i=0; $i<count($campos); $i++){
				// if($campos[$i]=='nomina_periodo'){					
				// 	$tbl_resultados .= '<td style="min-width:50px;">'.'<span id="grupo-'.$x.'" class="arrow">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$data[$campos[$i]].'</span><span class="excel" onclick="descargar_xls('.$data[nomina_anio].','.$data[nomina_periodo].')"></span></td>';
				// }
				// else
				if($i<=2){
					$tbl_resultados .= '<td style="text-align:center;">'.$data[$campos[$i]].'</td>';

				}elseif($i==3){
					$especial 		 = ($data[nomina_periodo_especial])?'-'.$data[nomina_periodo_especial]:'';
					$tbl_resultados .= '<td style="text-align:center;">'.$data[nomina_periodo].$especial.'</td>';
				}elseif($i==4){
					$tbl_resultados .= '';
				}else{
					$c = explode('_', $campos[$i]);
					$t = explode(':',$data[$c[0].'_horas']);
					$tiempo = $t[0].':'.$t[1];
					if($c[1]=='porcentaje')
					break;
					$tbl_resultados .= '<td>'.$tiempo.' hrs. <br/> '.$data[$c[0].'_porcentaje'].' </td>';
				}
			}
			// Detalle
			$tbl_resultados .= '<tr><td colspan="10">';
			$tbl_resultados .= '<div id="tabla-detalles-'.$x.'">
								<table class="tabla_acordeon">';
			$tbl_resultados .= '<thead>
								<tr>
									<th>CID</th>
									<th>Nombre</th>
									<th>Entidad</th>
									<th>Sucursal</th>
									<th>Área</th>
									<th>Puesto</th>
									<th width="70">Fecha</th>
									<th width="60">Horas<br/>Capturadas</th>
					                <th width="60">Horas<br/>Autorizadas</th>
					                <th width="60">Horas<br/>Pagadas</th>
					                <th width="60">Horas<br/>Dobles</th>
					                <th width="60">Horas<br/>Triples</th>
								</tr>
								</thead>
								<tbody>
			';
			$sqlData_detalle = array( auth => 1, id_empresa => $data[id_empresa], anio => $data[nomina_anio], periodo => $data[nomina_periodo], periodo_especial => $data[nomina_periodo_especial] );
			$tabla_detalle = select_reporte_nominativo($sqlData_detalle);
			// dump_var($tabla_detalle);
			$campos_detalle = array(
				'cid'
				,'nombre_completo'
				,'estado'
				,'sucursal'
				,'localidad'
				,'puesto'
				,'fecha'
				,'capturadas_horas'
				,'autorizadas_horas'
				,'pagadas_horas'
				,'dobles_horas'
				,'triples_horas'
				,'capturadas_porcentaje'
				,'autorizadas_porcentaje'
				,'pagadas_porcentaje'
				,'dobles_porcentaje'
				,'triples_porcentaje'
			);
			foreach ($tabla_detalle as $registro_detalle) {	
				$tbl_resultados .= '<tr>';
				$soloUno_detalle = (!is_array($registro_detalle))?true:false; #Deteccion de total de registros
				$data_detalle = (!$soloUno_detalle)?$registro_detalle:$tabla_detalle; #Seleccion de arreglo	
				for($n=0; $n<count($campos_detalle); $n++){					
					// $tbl_resultados .= '<td>'.utf8_encode($data_detalle[$campos_detalle[$i]]).'</td>';
					if($n<=6){
						$tbl_resultados .= '<td>'.utf8_encode($data_detalle[$campos_detalle[$n]]).'</td>';
					}else{
						$c2 = explode('_', $campos_detalle[$n]);
						$t2 = explode(':',$data_detalle[$c2[0].'_horas']);
						$tiempo_detalle = $t2[0].':'.$t2[1];
						if($c2[1]=='porcentaje')
						break;
						$tbl_resultados .= '<td>'.$tiempo_detalle.' hrs. <br/> '.$data_detalle[$c2[0].'_porcentaje'].' </td>';
					}
				}							
				$tbl_resultados .= '</tr>';
			 if($soloUno_detalle) break;
			}
			$tbl_resultados .= '</tbody></table></div>';
			$tbl_resultados .= '</td></tr>';
			// Fin Detalle
			$tbl_resultados .= '</tr>';
			if($soloUno) break;
		}		
		return $tbl_resultados;
	}		
}

function build_hitorial_usuario(){
	
	$tabla = historial_usuario($sqlData);	

	foreach ($tabla as $registro) {		
		$tbl_resultados .= '<tr class="gradeA">';
		$soloUno = (!is_array($registro))?true:false; #Deteccion de total de registros
		$data = (!$soloUno)?$registro:$tabla; #Seleccion de arreglo	


		$tbl_resultados .= '<td>'.$data[id_horas_extra].'</td>';
		$tbl_resultados .= '<td>'.$data[nombre].'</td>';
		$tbl_resultados .= '<td>'.$data[paterno].'</td>';
		$tbl_resultados .= '<td>'.$data[fecha].'</td>';
		$tbl_resultados .= '<td>'.$data[hora_extra].'</td>';
		$tbl_resultados .= '<td>'.$data[estatus_fecha].'</td>';

		if($data[estatus]=='' || $data[estatus]==NULL){
			$tbl_resultados .= '<td>PENDIENTE</td>';
		}
		else{
			$tbl_resultados .= '<td>'.$data[estatus].'</td>';
		}
		//$tbl_resultados .= '<td>'.$data[id_autorizacion].'</td>';
		//$tbl_resultados .= '<td>'.$data[time_auto].'</td>';
		$tbl_resultados .= '<td>'.$data[horas_rechazadas].'</td>';
		$tbl_resultados .= '<td>'.$data[horas_simples].'</td>';
		$tbl_resultados .= '<td>'.$data[horas_dobles].'</td>';
		$tbl_resultados .= '<td>'.$data[horas_triples].'</td>';
		$tbl_resultados .= '<td>'.$data[id_concepto].'</td>';
		

		$tbl_resultados .= '</tr>';
		if($soloUno) break; 		
	}
	return $tbl_resultados;
}

function build_select_periodos($id_empresa=false){
	$sqlData = array( auth => true, id_empresa => $id_empresa );
	$tabla = periodos($sqlData);		
	$objeto = "<select id='sel_periodo' name='sel_periodo'>";	
	foreach ($tabla as $registro) {
		$soloUno = (!is_array($registro))?true:false; 
		$data = (!$soloUno)?$registro:$tabla;					
		$objeto .='<option value="'.$data[id_periodo].'">'.$data[periodo].'</option>'; 
		if($soloUno) break;
	}
	$objeto .= (!$soloUno)?'<option value="" selected="selected">Todos</option>':'';		
	$objeto .= "</select>";
	return $objeto;
}

//*****************************************************************************************************************************************
// AUTORIZACION
function build_autorizacion_1(){
	// Construye grid de autorizaciones
	global $Path;
	$sqlData = array(
			 auth 		=> true
			,estatus 	=> 0
			,orden		=> 'a.id_horas_extra DESC'
		);
	$tabla = select_autorizacion_1($sqlData);	
	$campos = array(
				 'id_horas_extra'
				,'nombre_completo'
				,'empleado_num'
				,'estado'
				,'sucursal'
				,'localidad'
				,'puesto'
				,'fecha'
				,'horas'
			);
	if($tabla){
		foreach ($tabla as $registro) {		
			$tbl_resultados .= '<tr class="gradeA">';
			$soloUno = (!is_array($registro))?true:false; #Deteccion de total de registros
			$data = (!$soloUno)?$registro:$tabla; #Seleccion de arreglo			
			for($i=0; $i<count($campos); $i++){
				$tbl_resultados .= '<td>'.utf8_encode($data[$campos[$i]]).'</td>';
			}
			$tbl_resultados .= '<td><span class="btn" onclick="popup_autorizacion_1('.$data[0].');"><img src="'.$Path[img].'ico_edit.png" width="20" title="brightness" class="brightness" /></span></td>';
			$tbl_resultados .= '</tr>';
			if($soloUno) break; 		
		}
	}
	return $tbl_resultados;
}

function build_grid_autorizacion_2($data=array()){
/**
* Construye listado de horas extra autorizadas
*/
	global $Path;
	$sqlData = array(
			 auth 		=> true
			,orden		=> 'a.id_horas_extra DESC'
		);
	$tabla = select_autorizacion_2($sqlData);
	$campos = array(
				 'id_horas_extra'
				,'nombre_completo'
				,'empleado_num'
				,'estado'
				,'sucursal'
				,'localidad'
				,'puesto'
				,'fecha'
				,'horas'
				,'n1_horas'
			);
	if($tabla){
		foreach ($tabla as $registro) {		
			$tbl_resultados .= '<tr class="gradeA">';
			$soloUno = (!is_array($registro))?true:false; #Deteccion de total de registros
			$data = (!$soloUno)?$registro:$tabla; #Seleccion de arreglo			
			for($i=0; $i<count($campos); $i++){
				$tbl_resultados .= '<td>'.utf8_encode($data[$campos[$i]]).'</td>';
			}
			$tbl_resultados .= '<td><span class="btn" onclick="popup_autorizacion_2('.$data[0].');"><img src="'.$Path[img].'ico_edit.png" width="20" title="brightness" class="brightness" /></span></td>';
			$tbl_resultados .= '</tr>';
			if($soloUno) break; 		
		}
	}
	return $tbl_resultados;
}

function build_grid_autorizacion_3($data=array()){
/**
* Construye listado de horas extra autorizadas
*/
	global $Path;
	$sqlData = array(
			 auth 		=> true
			,orden		=> 'a.id_horas_extra DESC'
		);
	$tabla = select_autorizacion_3($sqlData);
	$campos = array(
				 'id_horas_extra'
				,'nombre_completo'
				,'empleado_num'
				,'estado'
				,'sucursal'
				,'localidad'
				,'puesto'
				,'fecha'
				,'horas'
				,'n2_horas'
			);
	if($tabla){
		foreach ($tabla as $registro) {		
			$tbl_resultados .= '<tr class="gradeA">';
			$soloUno = (!is_array($registro))?true:false; #Deteccion de total de registros
			$data = (!$soloUno)?$registro:$tabla; #Seleccion de arreglo			
			for($i=0; $i<count($campos); $i++){
				$tbl_resultados .= '<td>'.utf8_encode($data[$campos[$i]]).'</td>';
			}
			$tbl_resultados .= '<td><span class="btn" onclick="popup_autorizacion_3('.$data[0].');"><img src="'.$Path[img].'ico_edit.png" width="20" title="brightness" class="brightness" /></span></td>';
			$tbl_resultados .= '</tr>';
			if($soloUno) break; 		
		}
	}
	return $tbl_resultados;
}

function build_grid_autorizacion_4($data=array()){
/**
* Construye listado de horas extra autorizadas
*/
	global $usuario, $Path;
	$sqlData = array(
			 auth 		=> true
			,estatus	=> 1
			,activo 	=> 1
			,orden		=> 'a.id_horas_extra DESC'
		);
	$tabla = select_autorizacion_4($sqlData);
	$campos = array(
				 'id_horas_extra'
				,'empresa'
				,'sucursal'
				,'nombre_completo'
				,'empleado_num'
				,'fecha'
				,'horas'
				,'dobles'
				,'triples'
				,'rechazadas'
			);
	if($tabla){
		foreach ($tabla as $registro) {	
			$tbl_resultados .= '<tr class="gradeA">';
			$soloUno = (!is_array($registro))?true:false; #Deteccion de total de registros
			$data = (!$soloUno)?$registro:$tabla; #Seleccion de arreglo
			for($i=0; $i<count($campos); $i++){
				$tbl_resultados .= ($data[$campos[$i]])?'<td>'.$data[$campos[$i]].'</td>':'<td>-</td>';		
			}
			$tbl_resultados .= '<td align="center">
									<select id="id_'.$data[0].'" name="id_'.$data[0].'" onChange="ok(this)" class="campos">
										<option value="" selected></option>
										<option value="si">Autorizar</option>
										<option value="no">Declinar</option>
									</select>
								</td>';
			$tbl_resultados .= '<td align="center">
									<input type="checkbox" id="ok_'.$data[0].'" class="element-checkbox" style="display: none;">
									<div id="ico-'.$data[0].'" class="ico-autorizacion" title="Pendiente"></div>
									<span>
										<input type="text" id="muestra_'.$data[0].'" style="display: none;" width="48">
										<input type="hidden" id="asig_'.$data[0].'" value="0">
									</span>
								</td>';
			$tbl_resultados .= '</tr>';
			if($soloUno) break; 		
		}
	}
	return $tbl_resultados;
}

function build_grid_autorizacion_5($data=array()){
/**
* Construye listado de horas extra autorizadas
*/
	global $usuario, $Path;
	$sqlData = array(
			 auth 		=> true
			,estatus	=> 1
			,activo 	=> 1
			,orden		=> 'a.id_horas_extra DESC'
		);
	$tabla = select_autorizacion_5($sqlData);
	$campos = array(
				 'id_horas_extra'
				,'empresa'
				,'sucursal'
				,'nombre_completo'
				,'empleado_num'
				,'fecha'
				,'horas'
				,'dobles'
				,'triples'
				,'rechazadas'
			);
	if($tabla){
		foreach ($tabla as $registro) {	
			$tbl_resultados .= '<tr class="gradeA">';
			$soloUno = (!is_array($registro))?true:false; #Deteccion de total de registros
			$data = (!$soloUno)?$registro:$tabla; #Seleccion de arreglo
			for($i=0; $i<count($campos); $i++){
				$tbl_resultados .= ($data[$campos[$i]])?'<td>'.$data[$campos[$i]].'</td>':'<td>-</td>';		
			}
			$tbl_resultados .= '<td align="center">
									<select id="id_'.$data[0].'" name="id_'.$data[0].'" onChange="ok(this)" class="campos">
										<option value="" selected></option>
										<option value="si">Autorizar</option>
										<option value="no">Declinar</option>
									</select>
								</td>';
			$tbl_resultados .= '<td align="center">
									<input type="checkbox" id="ok_'.$data[0].'" class="element-checkbox" style="display: none;">
									<div id="ico-'.$data[0].'" class="ico-autorizacion" title="Pendiente"></div>
									<span>
										<input type="text" id="muestra_'.$data[0].'" style="display: none;" width="48">
										<input type="hidden" id="asig_'.$data[0].'" value="0">
									</span>
								</td>';
			$tbl_resultados .= '</tr>';
			if($soloUno) break; 		
		}
	}
	return $tbl_resultados;
}
//*****************************************************************************************************************************************
// ADMINISTRACION
function build_grid_layout($data=array()){
/**
* Construye listado de horas extra autorizadas 
*/
	global $usuario, $Path, $cfg;
	$sqlData = array(
			 auth 		=> true
			,estatus	=> 1
			,activo 	=> 1
		);

	$tabla = select_asignar_semana($sqlData);
	$campos = array(
				 'id_horas_extra'
				,'nombre_completo'
				,'id_nomina'
				,'empleado_num'
				,'estado'
				,'sucursal'
				,'localidad'
				,'puesto'				
				,'fecha'
				,'horas'
				,'id_empresa'
				,'id_personal'
			);
	if($tabla){
		foreach ($tabla as $registro) {	
			$tbl_resultados .= '<tr class="gradeA">';
			$soloUno = (!is_array($registro))?true:false; #Deteccion de total de registros
			$data = (!$soloUno)?$registro:$tabla; #Seleccion de arreglo
			for($i=0; $i<count($campos); $i++){				
				if($campos[$i]!='id_empresa' && $campos[$i]!='id_personal'){
					$tbl_resultados .= ($data[$campos[$i]])?'<td align="center">'.utf8_encode($data[$campos[$i]]).'</td>':'<td>-</td>';
				}
			}
			// $horas = ($cfg[horas_redondeadas])?redondeo_horas_extra($data[horas]):'N/A';
			// $tbl_resultados .= '<td align="center">'.$horas.'</td>';			
			$arrDatos=array(
				 horas 			=> $horas_redondeadas
				,fecha 			=> $data[fecha]
				,id_empresa 	=> $data[id_empresa]
				,id_personal 	=> $data[id_personal]
			);
			$tbl_resultados .= '<td align="center">'.'<input class="chk_select" type="checkbox" name="check[]" value="'.$data[id_horas_extra].'">'.'</td>';

			$tbl_resultados .= '</tr>';
			if($soloUno) break; 		
		}
	}
	return $tbl_resultados;
}

function calculo_horas_extra($data=array()){
	global $cfg;
	$tiempo 	= explode(':',$data[horas]);	
	$horas 		= $tiempo[0];
	$minutos	= str_pad($tiempo[1],2,'0',STR_PAD_LEFT);
	/*I Diario*/
	$dobles 	= ($horas>3)? 3 : $horas;
	$triples 	= ($horas-$dobles>=1) ?  $horas-$dobles : 0 ;

	$minutos_dobles = ($horas<3)?$minutos:'00';
	$minutos_triples = ($triples)?$minutos:'00';
	/*II Acumulado*/
	$sqlData = array(
			 auth 			=> true
			,fecha 			=> $data[fecha]
			,id_empresa 	=> $data[id_empresa]
			,id_personal 	=> $data[id_personal]
			,semana 		=> $data[semana]
		);
	$data_acumuladas = select_acumulado_semanal($sqlData); 	
// dump_var($data_acumuladas);
	$horas_acumuladas = (!$cfg[acumulado_semanal])?$data_acumuladas[tot_horas]:$data_acumuladas[dobles_horas];
	$tiempo_acumulado = ($horas_acumuladas)?explode(':',$horas_acumuladas):0;
	$horas_acumuladas = $tiempo_acumulado[0];
	$minutos_acumulados = ($cfg[horas_redondeadas])?0:$tiempo_acumulado[1];
// dump_var($horas_acumuladas.'|'.$minutos_acumulados.'|'.$dobles.'|'.$minutos_dobles.'|'.$triples.'|'.$minutos_triples);

	/*Opc 2*/
	#Calculo en minutos
	$max_diario_dobles_minutos = 180; #3 hrs
	$max_semana_dobles_minutos = 540; #9 hrs
	$c_horas = $horas * 60;
	$c_mins = $minutos;
	$horas_acumuladas = $horas_acumuladas * 60;
	$minutos_acumulados = $minutos_acumulados;
	$tiempo_acumulado = $horas_acumuladas + $minutos_acumulados;
	$tiempo_capturado = $c_horas + $c_mins;

	#Diario
	$dobles 	= ($dobles>=$max_diario_dobles_minutos)?$max_diario_dobles_minutos:$tiempo_capturado; #3hrs
	$triples 	= ($tiempo_capturado-$dobles>=1) ?  $tiempo_capturado-$dobles : 0 ;

	#Acumulado semanal
	if($tiempo_acumulado + $tiempo_capturado >= $max_semana_dobles_minutos){
		$dobles = ($max_semana_dobles_minutos-$tiempo_acumulado>0)?$max_semana_dobles_minutos-$tiempo_acumulado:0;
		if($dobles>=$max_diario_dobles_minutos){
			$dobles_excedente = $dobles-$max_diario_dobles_minutos;
			$dobles = $max_diario_dobles_minutos;		
		}
		$triples = $tiempo_capturado-$dobles;
	}else{
		if($dobles<=$max_diario_dobles_minutos){
			$dobles = $tiempo_capturado;
			$triples = 0;		
		}else{
			$dobles = $max_diario_dobles_minutos;
			$triples = $tiempo_capturado-$dobles;		
		}
	}

	$dobles 	= number_format($dobles / 60,2);
	$triples 	= number_format($triples / 60,2);
	$dobles 	= explode('.',$dobles);
	$triples 	= explode('.',$triples);
	$d_hora 	= $dobles[0];
	$d_minuto 	= round(('0.'.$dobles[1])*60,0);
	$t_hora 	= $triples[0];
	$t_minuto 	= round(('0.'.$triples[1])*60,0);
	$dobles 	= str_pad($d_hora,2,'0',STR_PAD_LEFT).':'.str_pad(substr($d_minuto,0,2),2,'0',STR_PAD_LEFT);
	$triples 	= str_pad($t_hora,2,'0',STR_PAD_LEFT).':'.str_pad(substr($t_minuto,0,2),2,'0',STR_PAD_LEFT);

/*Fin Opc 2*/

	$datos[dobles]	= $dobles;
	$datos[triples]	= $triples;

	# Conversion de horas a porcentaje
	$resultado[dobles][resultado_horas]			= $datos[dobles];
	$resultado[dobles][tiempo] 					= explode(':',$datos[dobles]);	
	$resultado[dobles][horas]					= $resultado[dobles][tiempo][0];
	$resultado[dobles][minutos]					= $resultado[dobles][tiempo][1];	
	$resultado[dobles][mins_porc] 				= round($resultado[dobles][minutos]/60,1)*10;
	$resultado[dobles][mins_porc_decima]		= substr($resultado[dobles][mins_porc],0,1);
	$resultado[dobles][mins_porc_centesima] 	= substr($resultado[dobles][mins_porc],1,1);
	$resultado[dobles][mins_porc_finales] 		= ($resultado[dobles][mins_porc_centesima]>5)?$resultado[dobles][mins_porc_decima]+1:$resultado[dobles][mins_porc_decima];
	$resultado[dobles][resultado_porcentaje]	= $resultado[dobles][horas].'.'.$resultado[dobles][mins_porc_finales];

	$resultado[triples][resultado_horas]		= $datos[triples];
	$resultado[triples][tiempo] 	 			= explode(':',$datos[triples]);	
	$resultado[triples][horas]	 	 			= $resultado[triples][tiempo][0];
	$resultado[triples][minutos]	 			= $resultado[triples][tiempo][1];	
	$resultado[triples][mins_porc]  			= round($resultado[triples][minutos]/60,1)*10;
	$resultado[triples][mins_porc_decima]		= substr($resultado[triples][mins_porc],0,1);
	$resultado[triples][mins_porc_centesima] 	= substr($resultado[triples][mins_porc],1,1);
	$resultado[triples][mins_porc_finales] 		= ($resultado[triples][mins_porc_centesima]>5)?$resultado[triples][mins_porc_decima]+1:$resultado[triples][mins_porc_decima];
	$resultado[triples][resultado_porcentaje] 	= $resultado[triples][horas].'.'.$resultado[triples][mins_porc_finales];

	// dump_var($resultado);
	return $resultado;
}

function redondeo_horas_extra($data=false){
	$tiempo 	= explode(':',$data);	
	$horas 		= $tiempo[0];
	$minutos	= $tiempo[1];	
	$mins_porc 	= $minutos/60*100;
	$redondeo 	= ($mins_porc>50)?1:0;
	$horas 		= str_pad($horas+$redondeo,2,'0',STR_PAD_LEFT).':00';	
	return $horas;
}

function build_grid_xls($data=array()){
/**
* Construye listado de horas extra que se incluiran en el XLS 
*/
	global $usuario, $Path;
	$sqlData = array(
			 auth 		=> true
			,estatus	=> 1
			,activo 	=> 1
			,orden		=> 'a.id_horas_extra DESC'
		);
	$tabla = select_xls($sqlData);
	$campos = array(
				 'id_horas_extra'
				// ,'empresa'
				 ,'estado'
				 ,'sucursal'
				 ,'localidad'
				,'nombre_completo'
				,'id_nomina'
				,'empleado_num'
				,'fecha'
				,'capturado_el'
				,'horas_autorizadas'
				,'dobles_horas'
				,'dobles_porcentaje'
				,'triples_horas'
				,'triples_porcentaje'
				,'periodo'	
				,'semana'
			);
	if($tabla){
		foreach ($tabla as $registro) {	
			$tbl_resultados .= '<tr class="gradeA">';
			$soloUno = (!is_array($registro))?true:false; #Deteccion de total de registros
			$data = (!$soloUno)?$registro:$tabla; #Seleccion de arreglo
			for($i=0; $i<count($campos); $i++){
				if($campos[$i]=='dobles_horas' || $campos[$i]=='triples_horas'){
					$tbl_resultados .= ($data[$campos[$i]])?'<td>'.$data[$campos[$i]].' hrs.<br/>'.$data[$campos[$i+1]].' </td>':'<td>-</td>';		
				}elseif($campos[$i]!='dobles_porcentaje' && $campos[$i]!='triples_porcentaje' && $campos[$i]!='dobles_horas' && $campos[$i]!='triples_horas'){
					$tbl_resultados .= ($data[$campos[$i]])?'<td>'.utf8_encode($data[$campos[$i]]).'</td>':'<td>-</td>';		
				}
			}
			$tbl_resultados .= '</tr>';
			if($soloUno) break; 		
		}
	}
	return $tbl_resultados;
}

function build_grid_xls_lista($data=array()){
/**
* Construye listado XLS para regenerar 
*/
	global $usuario, $Path;
	$sqlData = array(
			 auth 		=> true
			,estatus	=> 1
			,activo 	=> 1
			,orden		=> 'a.id_horas_extra DESC'
		);
	$tabla = select_xls_lista($sqlData);
	$campos = array(
				 'id_empresa'
				,'empresa'
				,'nomina_anio'
				,'nomina_periodo'
				,'xls'	
			);
	if($tabla){
		foreach ($tabla as $registro) {	
			$tbl_resultados .= '<tr class="gradeA">';
			$soloUno = (!is_array($registro))?true:false; #Deteccion de total de registros
			$data = (!$soloUno)?$registro:$tabla; #Seleccion de arreglo
			for($i=0; $i<count($campos); $i++){
				$tbl_resultados .= ($data[$campos[$i]])?'<td>'.$data[$campos[$i]].'</td>':'<td>-</td>';		
			}
			$tbl_resultados .= '<td><span class="btn" onclick="genera_xls_rebuild(\'regenera-xls-nomina\',\''.$data[xls].'\');"><img src="'.$Path[img].'excel.gif" width="20" /></span></td>';
			$tbl_resultados .= '<td><span class="btn" onclick="genera_xls_rebuild(\'regenera-xls-resumen\',\''.$data[xls].'\');"><img src="'.$Path[img].'excel.gif" width="20" /></span></td>';
			$tbl_resultados .= '</tr>';
			if($soloUno) break; 		
		}
	}
	return $tbl_resultados;
}

function build_grid_admin_usuarios(){
	global $Path, $usuario;
	$sqlData = array(
			 auth 			=> 1
			,id_empresa		=> $usuario[id_empresa]
			,activo 		=> 1
		);
	$tabla = select_admin_usuarios($sqlData);	
	//dump_var($tabla);

	$campos = array(
				 'id_nomina'
				,'empleado_num'
				,'empleado_nombre'
				,'empresa'
				,'sucursal'
				,'puesto'
				,'perfiles'
			);
	
	foreach ($tabla as $registro) {		
		$tbl_resultados .= '<tr class="gradeA">';
		$soloUno = (!is_array($registro))?true:false; #Deteccion de total de registros
		$data = (!$soloUno)?$registro:$tabla; #Seleccion de arreglo	
		for($i=0; $i<count($campos); $i++){
			$tbl_resultados .= '<td>'.utf8_encode($data[$campos[$i]]).'</td>';
		}
		$tbl_resultados .= '<td align="center"><span class="btn" onclick="supervisores('.$data[id_personal].');"><img src="'.$Path[img].'revision.png" width="20" title="brightness" class="brightness" /></span></td>';
		$tbl_resultados .= '<td align="center"><span class="btn" onclick="admin_usuario('.$data[id_personal].');"><img src="'.$Path[img].'ico_edit.png" width="20" title="brightness" class="brightness" /></span></td>';
		$tbl_resultados .= '<td align="center"><span class="btn" onclick="admin_usuario_reset('.$data[id_personal].',\''.$data[empleado_num].' - '.$data[empleado_nombre].'\');"><img src="'.$Path[img].'key.png" width="20" title="brightness" class="brightness" /></span></td>';
		$tbl_resultados .= '</tr>';
		if($soloUno) break; 		
	}
	return $tbl_resultados;
}

function build_grid_supervisores(){
	global $Path, $usuario;
	$sqlData = array(
			 auth 			=> 1
			,id_empresa		=> $usuario[id_empresa]
			,activo 		=> 1
		);
	$tabla = select_supervisores($sqlData);	
	//dump_var($tabla);

	$campos = array(
				'id_personal',
				 'id_nomina'
				,'empleado_nombre'
				,'sucursal'
				,'empleado_num'
				,'empleado_email'
			);
	
	foreach ($tabla as $registro) {		
		$tbl_resultados .= '<tr class="gradeA">';
		$soloUno = (!is_array($registro))?true:false; #Deteccion de total de registros
		$data = (!$soloUno)?$registro:$tabla; #Seleccion de arreglo	
		for($i=0; $i<count($campos); $i++){
			if($i==0){
				$tbl_resultados .= '<td align="center">'.'<input class="chk_select" type="checkbox" name="check[]" id="check_'.$data[id_personal].'" value="'.$data[id_personal].'">'.'</td>';
			}elseif($i==3){
				$tbl_resultados .= '<td align="left">'.build_catalgo_sucursales_nomina('sucursal_'.$data[id_personal], $data[sucursal],'onchange="check_on_edit(this.id);"').'</td>';
			}elseif($i==4){
				$tbl_resultados .= '<td align="center">'.'<input id="cid_'.$data[id_personal].'" name="cid_'.$data[id_personal].'" value="'.$data[empleado_num].'" style="width: 70px;" maxlength="10" onkeyup="check_on_edit(this.id);" />'.'</td>';
			}elseif($i==5){
				$tbl_resultados .= '<td align="center">'.'<input id="mail_'.$data[id_personal].'" name="mail_'.$data[id_personal].'" value="'.$data[empleado_email].'" style="width: 250px;" onkeyup="check_on_edit(this.id);" />'.'</td>';
			}else{
				$tbl_resultados .= '<td>'.utf8_encode($data[$campos[$i]]).'</td>';
			}
		}
		$tbl_resultados .= '<td align="left">'
							.build_catalgo_supervisores_edit(1,$data[id_personal], 'onchange="check_on_edit(this.id);"').'</br>'
							.build_catalgo_supervisores_edit(2,$data[id_personal], 'onchange="check_on_edit(this.id);"').'</br>'
							.build_catalgo_supervisores_edit(3,$data[id_personal], 'onchange="check_on_edit(this.id);"').'</br></td>';
		$tbl_resultados .= '</tr>';
		if($soloUno) break; 		
	}
	return $tbl_resultados;
}

//*****************************************************************************************************************************************
// E-MAIL
function email_tpl_captura($id_horas_extra){
	global $Raiz, $Path, $usuario, $cfg;
	// Extraccion de datos
	$sqlData = array(
			 auth 			=> true
			,id_horas_extra => $id_horas_extra
		);
	$data = captura_select($sqlData);
	// Envia datos a plantilla html
	$vista_new 	= 'email/email_captura.html';
	$tpl_data = array(
			 TOP_IMG 		=> $Raiz[url].$cfg[path_img].'email_top.jpg'
			,TITULO 		=> 'Registro de Horas Extra'	
			,EMPLEADO_NUM 	=> $data[empleado_num]
			,EMPLEADO 		=> $data[nombre_completo]
			,FECHA_HE 		=> $data[fecha]
			,HORAS 			=> $data[horas]
			,CAPTURA 		=> $data[capturado_el]
			,LINK 			=> '<a href="'.$cfg[app_link].'" target="_blank">Sistema Horas Extra</a>'
		);		
	$HTML = contenidoHtml($vista_new, $tpl_data);
	// Crea archivo html temporal
	$fname = $Path[tmp].$usuario[id_empresa].$usuario[id_usuario].date('YmdHis').'.html';
	$file = fopen($fname, "w");
	fwrite($file, $HTML);
	fclose($file);
	// Devuelve ruta del archivo tmp
	return $fname;
}

function email_tpl_autorizaciones($id_horas_extra, $nivel){
	global $Raiz, $Path, $usuario, $cfg;
	// Extraccion de datos
	$sqlData = array(
			 auth 			=> true
			,id_horas_extra => $id_horas_extra
			,id_nivel		=> $nivel
		);
	$data = select_data_autorizaciones($sqlData);
	// Envia datos a plantilla html
	$vista_new 	= 'email/email_autorizacion_1.html';
	$tpl_data = array(
			 TOP_IMG 		=> $Raiz[url].$cfg[path_img].'email_top.jpg'
			,TITULO 		=> utf8_decode("Autorización Nivel $nivel de Horas Extra")
			,EMPLEADO_NUM 	=> $data[empleado_num]
			,EMPLEADO 		=> utf8_decode($data[nombre_completo])
			,FECHA_HE 		=> $data[fecha]
			,HORAS 			=> $data[horas]
			,TIEMPOEXTRA 	=> $data[tiempoextra]
			,ARGUMENTO 		=> utf8_decode($data[argumento])
			,ESTATUS 		=> $data[estatus]
			,SUPERVISOR 	=> $data[supervisor]
			,CAPTURA 		=> $data[timestamp]
			,LINK 			=> '<a href="'.$cfg[app_link].'" target="_blank">Sistema Horas Extra</a>'			
		);	

	$HTML = contenidoHtml($vista_new, $tpl_data);
	// Crea archivo html temporal
	$fname = $Path[tmp].$usuario[id_empresa].$usuario[id_usuario].date('YmdHis').'.html';
	$file = fopen($fname, "w");
	fwrite($file, $HTML);
	fclose($file);
	// Devuelve ruta del archivo tmp
	return $fname;
}

function email_tpl_usuario_nuevo($id_usuario){
	global $Path, $usuario, $cfg, $Raiz;
	// Extraccion de datos
	$sqlData = array(
			 auth 			=> true
			,id_usuario => $id_usuario
		);
	$data = admin_select_usuario($sqlData);
	// Envia datos a plantilla html
	$vista_new 	= 'email/email_nuevo_usuario.html';
	$tpl_data = array(
			 TOP_IMG 		=> $Raiz[url].$cfg[path_img].'email_top.jpg'
			,TITULO 		=> 'Nuevo usuario del sistema'	
			,EMPLEADO_NUM 	=> $data[empleado_num]
			,EMPLEADO 		=> $data[empleado_nombre]
			,USUARIO 		=> $data[usuario]
			,CLAVE 			=> $data[clave]
			,FECHA 			=> $data[timestamp]
			,PUESTO 		=> $data[puesto]
			,EMPRESA 		=> $data[empresa]
			,SUCURSAL 		=> $data[sucursal]
			,NIVEL1 		=> $data[nivel1_nombre]
			,NIVEL2 		=> $data[nivel2_nombre]
			,NIVEL3 		=> $data[nivel3_nombre]
			,NIVEL4 		=> $data[nivel4_nombre]
			,NIVEL5 		=> $data[nivel5_nombre]
			,LINK 			=> '<a href="'.$cfg[app_link].'" target="_blank">Sistema Horas Extra</a>'
		);		
	$HTML = contenidoHtml($vista_new, $tpl_data);
	// Crea archivo html temporal
	$fname = $Path[tmp].$usuario[id_empresa].$usuario[id_usuario].date('YmdHis').'.html';
	$file = fopen($fname, "w");
	fwrite($file, $HTML);
	fclose($file);
	// Devuelve ruta del archivo tmp
	return $fname;
}

function email_tpl_usuario_reset($id_personal){
	global $Path, $usuario, $cfg, $Raiz;
	// Extraccion de datos
	$sqlData = array(
			 auth 			=> true
			,id_personal => $id_personal
		);
	$data = admin_select_usuario($sqlData);
	// Envia datos a plantilla html
	$vista_new 	= 'email/email_nuevo_usuario.html';
	$tpl_data = array(
			 TOP_IMG 		=> $Raiz[url].$cfg[path_img].'email_top.jpg'
			,TITULO 		=> 'Restablecimiento de Clave'	
			,EMPLEADO_NUM 	=> $data[empleado_num]
			,EMPLEADO 		=> $data[empleado_nombre]
			,USUARIO 		=> $data[usuario]
			,CLAVE 			=> $data[usuario]
			,FECHA 			=> $data[timestamp]
			,PUESTO 		=> $data[puesto]
			,EMPRESA 		=> $data[empresa]
			,SUCURSAL 		=> $data[sucursal]
			,NIVEL1 		=> $data[nivel1_nombre]
			,NIVEL2 		=> $data[nivel2_nombre]
			,NIVEL3 		=> $data[nivel3_nombre]
			,NIVEL4 		=> $data[nivel4_nombre]
			,NIVEL5 		=> $data[nivel5_nombre]
			,LINK 			=> '<a href="'.$cfg[app_link].'" target="_blank">Sistema Horas Extra</a>'
		);		
	$HTML = contenidoHtml($vista_new, $tpl_data);
	// Crea archivo html temporal
	$fname = $Path[tmp].$usuario[id_empresa].$usuario[id_usuario].date('YmdHis').'.html';
	$file = fopen($fname, "w");
	fwrite($file, $HTML);
	fclose($file);
	// Devuelve ruta del archivo tmp
	return $fname;
}

function email_tpl_usuario_modificado($id_personal){
	global $Path, $usuario, $cfg, $Raiz;
	// Extraccion de datos
	$sqlData = array(
			 auth 			=> true
			,id_personal => $id_personal
		);
	$data = admin_select_usuario($sqlData);
	// Envia datos a plantilla html
	$vista_new 	= 'email/email_nuevo_usuario.html';
	$tpl_data = array(
			 TOP_IMG 		=> $Raiz[url].$cfg[path_img].'email_top.jpg'
			,TITULO 		=> 'Modificaci&oacute;n de datos de usuario'	
			,EMPLEADO_NUM 	=> $data[empleado_num]
			,EMPLEADO 		=> $data[empleado_nombre]
			,USUARIO 		=> $data[usuario]
			,CLAVE 			=> $data[usuario]
			,FECHA 			=> $data[timestamp]
			,PUESTO 		=> $data[puesto]
			,EMPRESA 		=> $data[empresa]
			,SUCURSAL 		=> $data[sucursal]
			,NIVEL1 		=> $data[nivel1_nombre]
			,NIVEL2 		=> $data[nivel2_nombre]
			,NIVEL3 		=> $data[nivel3_nombre]
			,NIVEL4 		=> $data[nivel4_nombre]
			,NIVEL5 		=> $data[nivel5_nombre]
			,LINK 			=> '<a href="'.$cfg[app_link].'" target="_blank">Sistema Horas Extra</a>'
		);		
	$HTML = contenidoHtml($vista_new, $tpl_data);
	// Crea archivo html temporal
	$fname = $Path[tmp].$usuario[id_empresa].$usuario[id_usuario].date('YmdHis').'.html';
	$file = fopen($fname, "w");
	fwrite($file, $HTML);
	fclose($file);
	// Devuelve ruta del archivo tmp
	return $fname;
}

function build_catalgo_calendario_empresas(){
	$catalgo_empresa=select_catalgos_empresa();
	$select.='<select name="empresa" id="empresa">
				<option value="0">Aplica a todas</option>';
	foreach($catalgo_empresa as $empresa){
		$soloUno = (!is_array($empresa))?true:false; #Deteccion de total de registros
		$data = (!$soloUno)?$empresa:$catalgo_empresa; #Seleccion de arreglo
		for($i=1; $i<count($data)/2; $i++){
			$select.='<option value="'.$data[id_empresa].'"">'.utf8_encode($data[nombre]).'</option>';
		}
		if($soloUno) break;
	}
	$select.='</select>';
	return $select;
}

function build_input_select_enum($tipo=''){
/**
* Crea un input html <select></select> a partir de un campo ENUM
*/
	$resultado = false;	
	switch (strtolower($tipo)) {
		case 'calendario_tipo':
			$tabla = 'tbl_calendarios';
			$campo = 'tipo';
			break;
		default:
			$error = true;
			break;
	}
	if(!$error){
		$adata = array(auth => true, tabla => $tabla, campo => $campo);
		$tabla = select_enum_generales($adata);	
		$objeto = "<select id='$campo' name='$campo'>";	
		$objeto .= "<option value='' selected > </option>";
		if($tabla){
			foreach($tabla as $registro){
				$objeto .= "<option value='".$registro."'>".++$x." - ".utf8_encode($registro)."</option>";
			}
		}
		$objeto .= "</select>";	
	}else{ $objeto='ERROR -> No se pudo crear listado'; }
	return $objeto;
}

function build_tbl_calendario(){
	global $Path, $usuario;
	// Extraccion de datos
	$sqlData = array(
			 auth 		=> true
			,id_empresa => $usuario[id_empresa]
		);
	$grupos=select_tbl_calendario_grupos($sqlData);	
	$grupos_campos = array(
				 'anio'
				,'id_empresa'
				,'empresa'
				,'total_fechas'
			);

	foreach ($grupos as $grupo) {	
		++$x;		
		$grupo_soloUno 	= (!is_array($grupo))?true:false; #Deteccion de total de registros
		$data_grupo = (!$grupo_soloUno)?$grupo:$grupos; #Seleccion de arreglo			
		$tbl_resultados .= '<tr>';
		for($i=0; $i<count($grupos_campos); $i++){
			if($i!=1)
			$tbl_resultados .= '<td>'.utf8_encode($data_grupo[$grupos_campos[$i]]).'</td>';
		}
		$tbl_resultados .= '<td><span id="grupo-'.$x.'" class="arrow"></span></td>';
		$tbl_resultados .= '</tr>';
		// Detalle
		$tbl_resultados .= '<tr><td colspan="5">';
		$tbl_resultados .= '<div id="tabla-detalles-'.$x.'">
							<table >';
		$tbl_resultados .= '<thead>
							<tr>
								<th>Empresa</th>
								<th>Tipo</th>
								<th>Año</th>
								<th>Inicio</th>
								<th>Fin</th>
							</tr>
							</thead>
							<tbody>
		';
		$sqlData = array(
				 auth 		=> true
				,id_empresa => $data_grupo[id_empresa]
				,anio 		=> $data_grupo[anio]
			);
		$tabla=select_tbl_calendario($sqlData);		
		$datos_campos = array(
					 'empresa'
					,'tipo'				
					,'anio'
					,'fecha_inicio'
					,'fecha_fin'
				);
		foreach ($tabla as $registro) {	
			$tbl_resultados .= '<tr>';
			$soloUno = (!is_array($registro))?true:false; #Deteccion de total de registros
			$data = (!$soloUno)?$registro:$tabla; #Seleccion de arreglo	
			for($i=0; $i<count($datos_campos); $i++){					
				$tbl_resultados .= '<td>'.utf8_encode($data[$datos_campos[$i]]).'</td>';
			}							
			$tbl_resultados .= '</tr>';
		 if($soloUno) break;
		}
		$tbl_resultados .= '</tbody></table></div>';
		$tbl_resultados .= '</td></tr>';
		// Fin Detalle
		if($grupo_soloUno) break;
	}
	// dump_var($tbl_resultados);
	return $tbl_resultados;
}
/*O3M*/
?>