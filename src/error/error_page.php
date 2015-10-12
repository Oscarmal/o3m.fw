<?php 
require_once('../../common/php/inc.path.php');
$error = $_GET['e'];
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Error <? echo $error; ?> </title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" type="text/css" href="<? echo PATH_URL; ?>src/error/libs/bootstrap.min.css">
        <link rel="stylesheet" type="text/css" href="<? echo PATH_URL; ?>src/error/libs/style.css">

        <!-- JQUERY LIBRARY LINKS -->
        <script src="<? echo PATH_URL; ?>src/error/libs/jquery-1.9.1.js"></script>
        <script src="<? echo PATH_URL; ?>src/error/libs/jquery-migrate-1.2.1.min.js"></script>
    </head>

    <body>
        <div class="container">
            <div class="col-md-6 col-sm-6 imgSec">
                <div class="icon">
                    <div class="victor"></div>
                    <div class="animation"></div>
                </div>
            </div>
            <div class="col-md-6 col-sm-6 content">
                <h2 class="heading"><? echo $error; ?></h2>
                <p>Opps Error!</p>
                <p><small>Lo sentimos, pero la página que está buscando no existe.</small></p>
                <a href="#" class="button" onclick="javascript: window.history.go(-1);"> Regresar</a>
            </div>
        </div>
    </body>
</html> 