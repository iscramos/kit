<?php 

// Initialize site configuration
require_once('includes/config.inc.php');
require_once('includes/inc.session.php');
//require_once("lib/login.php");

// Get posts from database
//echo $_SESSION["school"];

if($_SESSION["type"] == 9)
{
    $consulta_historial = "SELECT zancos_historial_piezas.*, zancos_problemas.descripcion AS descripcion_problema, zancos_partes.descripcion AS descripcion_pieza 
            FROM zancos_historial_piezas
                INNER JOIN zancos_problemas ON zancos_historial_piezas.problema = zancos_problemas.id
                INNER JOIN zancos_partes ON zancos_historial_piezas.parte = zancos_partes.parte";
				
	$zancos_historial = Zancos_historial_piezas::getAllByQuery($consulta_historial);
	
	// Include page view
	require_once(VIEW_PATH.'indexZancos_reportes_historial.view.php');
}
else
{
	// Include page view
	redirect_to('index.php');
}