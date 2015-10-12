<?php /*O3M*/
/**
* Descripción:	Parsea archivo con datos de configuración incial y los
*				pone disponibles en variables globales.
* Creación:		2014-04-25
* @author		Oscar Maldonado - O3M
* @param 		$filename
* @return 		$cfg[], $db[], $var[]
*/
function load_vars($filename='') {
#Load config information from config.ini file.		
	try {
		global $cfg, $db, $var;
		if (file_exists($filename)) {
	        if ($handle = fopen($filename, 'r')) {
	        	$varsList = array('cfg','var','db');
	            while (!feof($handle)) {
	                list($type, $name, $value) = preg_split("/\||=/", fgets($handle), 3);                              
					$value = utf8_encode($value);
					if (trim($type)=='cfg') { 
					#CFG vars
						$cfg[trim($name)] = trim($value);
					}
					if (trim($type)=='var') { 
					#VAR vars
						$var[trim($name)] = trim($value);
					}
					if (trim($type)=='db') { 
					#DB vars
						$db[trim($name)] = trim($value);					
					}				
					if (in_array(trim($type),$varsList)) { 
					#Print for Debug
						$opt = ($opt) ? $opt.' . ' : '';
					 	$val.=$type.' | '.$opt.$name.' = '.$value."<br/>\n\r";
					}
	            }
	            ## DB Conections Vars
				if(strtolower($db[db_connection]) === 'local' && $db[db_onoff]){
					switch (strtolower($db[db_engine])) {
						case 'mysql':
							$db[host] = $db[db_local_host];
							$db[user] = $db[db_local_user];
							$db[pass] = $db[db_local_pass];
							$db[db1] = $db[db_local_db1];
							$db[db2] = $db[db_local_db2];
							$db[db3] = $db[db_local_db3];
							$db[conn_std] = $db[db_local_host].','.$db[db_local_user].','.$db[db_local_pass];
							$db[conn_dbi] = $db[db_local_host].','.$db[db_local_user].','.$db[db_local_pass].','.$db[db_local_db1];
							$db[conn_pdo] = 'mysql:host='.$db[db_local_host].';dbname='.$db[db_local_db1].', '.$db[db_local_user].', '.$db[db_local_pass];
							break;	
						case 'postgres':
							break;
						case 'oracle':
							break;
						case 'mssql':
							break;					
						default:
							break;
					}					
				}elseif(strtolower($db[db_connection]) === 'prod' && $db[db_onoff]){
					switch (strtolower($db[db_engine])) {
						case 'mysql':
							$db[host] 	= $db[db_prod_host];
							$db[user] 	= $db[db_prod_user];
							$db[pass] 	= $db[db_prod_pass];
							$db[db1] 	= $db[db_prod_db1];
							$db[db2] 	= $db[db_prod_db2];
							$db[db3] 	= $db[db_prod_db3];
							$db[conn_std] = $db[db_prod_host].','.$db[db_prod_user].','.$db[db_prod_pass];
							$db[conn_dbi] = $db[db_prod_host].','.$db[db_prod_user].','.$db[db_prod_pass].','.$db[db_prod_db1];
							$db[conn_pdo] = 'mysql:host='.$db[db_prod_host].';dbname='.$db[db_prod_db1].', '.$db[db_prod_user].', '.$db[db_prod_pass];
							break;	
						case 'postgres':
							break;
						case 'oracle':
							break;
						case 'mssql':
							break;					
						default:
							break;
					}					
				}
				#Print for Debug
			 	$val.='conn_std'.' = '.$db[conn_std]."<br/>\n\r";
			 	$val.='conn_dbi'.' = '.$db[conn_dbi]."<br/>\n\r";
			 	$val.='conn_pdo'.' = '.$db[conn_pdo]."<br/>\n\r";
				##--DB end
	        }	        
			return $val;
		}else{
			$msj = "¡ERROR CRÍTICO!<br/> No se ha logrado cargar el archivo de configuración, por favor, contacte al administrador del sistema.<br/>";
	    	throw new Exception($msj, 1);    	
	    }	
	} catch (Exception $e) {		
		print($e->getMessage());
		return false;
	}	   
}
/*O3M*/
?>