<?php session_name('o3m_fw'); session_start(); if(isset($_SESSION['header_path'])){include_once($_SESSION['header_path']);}else{header('location: '.dirname(__FILE__));}
require_once($Path[src].'admin/dao.admin.php');
function xsl_resumen($xls=''){
      global $usuario, $cfg;
      $sqlData = array(
      			 auth => 1
                        ,xls  => $xls
      		);
      $tabla = select_xls_resumen($sqlData);

      foreach ($tabla as $registro) {
            $soloUno = (!is_array($registro))?true:false; 
            $registro = (!is_array($registro))?$tabla:$registro;
            $registro[dia] = dia($registro[fecha]);
            $registro[11] = dia($registro[fecha]);
            $data[] = $registro;
            if($soloUno) break; 
      }

      $nameArchivo = 'HE_Horas-Extra_Resumen_'.$tabla[0][id_empresa];
      $tituloTabla = 'HE - Horas Extra';
      $titulos = array(
                         utf8_decode('ID Nómina PAE')
                        ,utf8_decode('CID Empleado')
                        ,utf8_decode('Nombre Completo')
                        ,utf8_decode('Entidad')
                        ,utf8_decode('Sucursal')
                        ,utf8_decode('Área')
                        ,utf8_decode('Puesto')
                        ,utf8_decode('Nómina Año')
                        ,utf8_decode('Nómina Periodo')
                        ,utf8_decode('Semana')
                        ,utf8_decode('Fecha')
                        ,utf8_decode('Día')
                        ,utf8_decode('Capturadas - Horas')
                        ,utf8_decode('Capturadas - Num')
                        ,utf8_decode('Rechazadas - Horas')
                        ,utf8_decode('Rechazadas - Num')
                        ,utf8_decode('Autorizadas - Horas')
                        ,utf8_decode('Autorizadas - Num')
                        ,utf8_decode('Pagadas - Horas')
                        ,utf8_decode('Pagadas - Num')
                        ,utf8_decode('Dobles - Horas')
                        ,utf8_decode('Dobles - Num')
                        ,utf8_decode('Triples - Horas')
                        ,utf8_decode('Triples - Num')
                        ,utf8_decode('ID HE')
                  );
      // $directorio = $cfg[path_docs].'autorizacion/';
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
      return $xls;
}


function xsl_nomina($data=array()){
      global $usuario, $cfg;
      // Extrae datos para crear xls
      $sqlData = array(
                         auth          => 1
                        ,orden         => 'a.id_horas_extra DESC'
                  );
      $tabla = select_xls_nomina($sqlData);
      $nameArchivo = 'HE_Horas-Extra_Nomina_'.$usuario[empresa];
      $tituloTabla = false;
      $titulos = array(
                         'ID Empleado'
                        ,'Semana'
                        ,'Concepto'
                        ,'Cantidad'                        
                  );
      $directorio = $cfg[path_tmp];
      $xlsData = array(
                         descarga         => false
                        ,datos            => $tabla
                        ,colsTitulos      => $titulos
                        ,archivo          => $nameArchivo
                        ,tituloTabla      => $tituloTabla
                        ,hoja             => ''
                        ,directorio       => $directorio
                        ,id_empresa       => $usuario[id_empresa]
                  );
      // Crea xls
      $xls = xls($xlsData);
      // Actualiza registros con nombre de xls y semana
      $updateXls = array(
                         auth             => 1
                        ,periodo_anio     => $data[anio]
                        ,periodo          => $data[periodo]
                        ,periodo_especial => $data[especial]
                        ,xls              => $xls[filename]
                  );
      $updateXls = update_xls($updateXls); 
      return $xls;
}

function xls_nomina_rebuild($data=array()){
      global $usuario, $cfg;
      // Extrae datos para crear xls
      $sqlData = array(
                         auth          => 1
                        ,xls           => $data[xls]
                        ,orden         => 'a.id_horas_extra DESC'
                  );
      $tabla = select_xls_nomina_rebuild($sqlData);
      $nameArchivo = 'HE_Horas-Extra_Nomina_'.$usuario[empresa];
      $tituloTabla = false;
      $titulos = array(
                         'ID Empleado'
                        ,'Semana'
                        ,'Concepto'
                        ,'Cantidad'                        
                  );
      $directorio = $cfg[path_tmp];
      $xlsData = array(
                         descarga         => false
                        ,datos            => $tabla
                        ,colsTitulos      => $titulos
                        ,archivo          => $nameArchivo
                        ,tituloTabla      => $tituloTabla
                        ,hoja             => ''
                        ,directorio       => $directorio
                        ,id_empresa       => $usuario[id_empresa]
                  );
      // Crea xls
      $xls = xls($xlsData);
      return $xls;
}
/*O3M*/
?>
