<?php session_name('o3m_fw'); session_start(); if(isset($_SESSION['header_path'])){include_once($_SESSION['header_path']);}else{header('location: '.dirname(__FILE__));}
// Define modulo del sistema
define(MODULO, $in[modulo]);
// Archivo DAO
require_once($Path[src].MODULO.'/dao.'.strtolower(MODULO).'.php');
require_once($Path[src].'views.vars.'.MODULO.'.php');
// Lógica de negocio
if($in[auth]){
	if($ins[accion]=='grafico01'){
		// Extraccion de datos
		$sqlData = array( 
				 auth 		=> true 
				,id_empresa	=> $ins[id_empresa]
				,anio 		=> $ins[anio]
			);
		$datos = grafico01_select($sqlData);
		// dump_var($datos);		
		if($datos){
			$data = array();
			$totales = array();
			$empresas = array();
			foreach ($datos as $registro) {
				if(!is_array($registro)){
					$soloUno = true;
					$data = $datos;
					$regs = count($registro);
				}else{
					$soloUno = false;
					$data = $registro;
					$regs = count($datos);
				}
				// $totales[anio] = $data [anio_fecha];
				// $totales[capturadas] += $data [horas_capturadas];
				// $totales[pendientes] += $data [horas_pendientes];
				// $totales[autorizadas] += $data [horas_autorizadas];
				// $totales[rechazadas] += $data [horas_rechazadas];
				// $totales[dobles] += $data [horas_dobles];
				// $totales[triples] += $data [horas_triples];
				$totales[capturadas] += $data [capturadas_porcentaje];
				$totales[pendientes] += $data [pendientes_porcentaje];
				$totales[autorizadas] += $data [autorizadas_porcentaje];
				$totales[rechazadas] += $data [rechazadas_porcentaje];
				$totales[pagadas] += $data [pagadas_porcentaje];
				$totales[dobles] += $data [dobles_porcentaje];
				$totales[triples] += $data [triples_porcentaje];
				// $totales[semanas] += $data [tot_semanas];
				$totales[semanas] = 0;
				$totales[contador]++;
				$totales[regs]=$regs;				
				if($soloUno) break;
			}
			$success = true;
			$msj = "Con datos";
		}else{
			$msj = "Sin datos";
		}
		$data = array(success => $success, message => $msj, datos => $datos, totales => $totales, regs => $regs);
		$data = json_encode($data);
	}elseif($in[accion]=='rebuild_reporte01'){
		$tabla = build_reporte01($in[id_empresa],$in[anio],$in[periodo]);
		// dump_var($tabla);
		if($tabla){			
			$success = true;
			$msj = "Con datos";
		}else{
			$msj = "Sin datos";
		}
		$data = array(success => $success, message => $msj, tabla => $tabla);
		$data = json_encode($data);
	}elseif($in[accion]=='rebuild_sel_anio'){
		$sel_anio = build_select_anios($ins[id_empresa]);
		// $sel_periodo = build_select_periodos($in[id_empresa],$in[anio]);
		if($sel_anio){			
			$success = true;
			$msj = "Con datos";
		}else{
			$msj = "Sin datos";
		}
		$data = array(success => $success, message => $msj, sel_anio => $sel_anio);
		$data = json_encode($data);
	}elseif($in[accion]=='xls_reporte_periodo'){
		$sqlData = array( auth => true, id_empresa => $in[id_empresa], anio => $in[anio], periodo => $in[periodo], periodo_especial => $in[periodo_especial] );
		$data = select_reporte_nominativo_xls($sqlData);
		// dump_var($data);
		if(count($data)){		
			$especial = ($in[periodo_especial])?'-'.$in[periodo_especial]:'';
			$nameArchivo = 'HE_Horas-Extra_Reporte_Nominativo_'.$in[anio].'-'.$in[periodo].$especial;
			$tituloTabla = utf8_decode('Horas Extra - Reporte Nominativo - Año: '.$in[anio].' Periodo: '.$in[periodo]);
			$titulos = array(
		            /* utf8_decode('ID Empresa')
					,utf8_decode('Empresa')
					,utf8_decode('Siglas')*/					
					 utf8_decode('CID Empleado')
					,utf8_decode('ID Nómina PAE')
		            ,utf8_decode('Nombre Completo')
					,utf8_decode('Entidad')
					,utf8_decode('Sucursal')
					,utf8_decode('Área')
					,utf8_decode('Puesto')
					,utf8_decode('Nómina Año')
					,utf8_decode('Nómina Periodo')
					,utf8_decode('Nómina Periodo Especial')
					,utf8_decode('Semana')
					,utf8_decode('Fecha')
					,utf8_decode('Capturadas - Horas')
					,utf8_decode('Capturadas - Num')
					,utf8_decode('Autorizadas - Horas')
					,utf8_decode('Autorizadas - Num')
					,utf8_decode('Pagadas - Horas')
					,utf8_decode('Pagadas - Num')
					,utf8_decode('Dobles - Horas')
					,utf8_decode('Dobles - Num')
					,utf8_decode('Triples - Horas')
					,utf8_decode('Triples - Num')

					,utf8_decode('Autorizó (CID-Nombre-Fecha)')
					,utf8_decode('supervisor_n1_cid')
					,utf8_decode('supervisor_n1_nombre')
					,utf8_decode('supervisor_n1_puesto')
					,utf8_decode('supervisor_n2_cid')
					,utf8_decode('supervisor_n2_nombre')
					,utf8_decode('supervisor_n2_puesto')
					,utf8_decode('supervisor_n3_cid')
					,utf8_decode('supervisor_n3_nombre')
					,utf8_decode('supervisor_n3_puesto')

					,utf8_decode('ID HE')
			      );
			$directorio = $cfg[path_tmp];
			$xlsData = array(
			             descarga         => false
			            ,datos            => $data
			            ,colsTitulos      => $titulos
			            ,archivo          => $nameArchivo
			            ,tituloTabla      => $tituloTabla
			            ,hoja             => ''
			            ,directorio       => $directorio
			            ,id_empresa       => $usuario[id_empresa]
			      );
			$xls = xls($xlsData); 
			$success = true;
			$msj = "Con datos";
		}else{
			$msj = "Sin datos";
		}
		$data = array(success => $success, message => $msj, xls => $xls);
		$data = json_encode($data);
	}elseif(!$ins[accion]){
		$error = array(error => 'Sin accion');
		$data = json_encode($error);
	}
}else{
	$error = array(error => 'Sin autorización');
	$data = json_encode($error);
}
// Resultado
echo $data;
/*O3M*/
?>