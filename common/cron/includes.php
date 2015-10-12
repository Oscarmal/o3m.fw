<?php /*O3M*/
/**
* Includes del sistema
*/
require_once('../php/inc.path.php');
$Raiz[local] = $_SESSION[RaizLoc];
$Raiz[url] = $_SESSION[RaizUrl];
$Raiz[sitefolder] = $_SESSION[SiteFolder];
require_once($Raiz[local].'common/php/inc.parse-cfg.php');
load_vars($Raiz[local].'common/cfg/system.cfg');
require_once($Raiz[local].$cfg[php_functions]);
require_once($Raiz[local].$cfg[php_mysql]);
require_once($Raiz[local].$cfg[php_postgres]);
require_once($Raiz[local].$cfg[php_tpl]);
require_once($Raiz[local].$cfg[path_php].'inc.constructHtml.php');
require_once($Raiz[local].$cfg[path_php].'phpmailer/inc.email.smtp.php');
// Establece variables
$Path[php] 		= $Raiz[local].$cfg[path_php];
$Path[js]		= $Raiz[url].$cfg[path_js];
$Path[css]		= $Raiz[url].$cfg[path_css];
$Path[img]		= $Raiz[url].$cfg[path_img];
$Path[log]		= $Raiz[local].$cfg[path_log];
$Path[docs]		= $Raiz[local].$cfg[path_docs];
$Path[docsurl]	= $Raiz[url].$cfg[path_docs];
$Path[tmp]		= $Raiz[local].$cfg[path_tmp];
$Path[tmpurl]	= $Raiz[url].$cfg[path_tmp];
$Path[html]		= $Raiz[local].$cfg[path_html];
$Path[src]		= $Raiz[local].$cfg[path_src];
$Path[srcjs]	= $Raiz[url].$cfg[path_src];
$Path[site]		= $Raiz[local].$cfg[path_site];
/*O3M*/
?>