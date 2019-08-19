<?php 

// Initialize site configuration
require_once('includes/config.inc.php');
require_once('includes/inc.session.php');
//require_once("lib/login.php");

// Get posts from database
//echo $_SESSION["school"];

if($_SESSION["type"] == 5)
{
	
	$q = "SELECT herramientas_transacciones.*, herramientas_herramientas.descripcion, sum(herramientas_transacciones.cantidad) AS articulos_totales
                FROM herramientas_transacciones
                    INNER JOIN herramientas_herramientas ON herramientas_transacciones.clave = herramientas_herramientas.clave
                    	GROUP BY herramientas_transacciones.id_transaccion
                    		ORDER BY herramientas_transacciones.id_transaccion DESC"; 
		
	$herramientas_transacciones = Herramientas_transacciones::getAllByQuery($q);
	
	// Include page view
	require_once(VIEW_PATH.'indexHerramientas_transacciones.view.php');
	
	
}
else
{
	// Include page view
	redirect_to('index.php');
}