<?php 

// Initialize site configuration
require_once('includes/config.inc.php');
require_once('includes/inc.session.php');
//require_once("lib/login.php");

// Get posts from database
//echo $_SESSION["school"];

if( ($_SESSION["type"] == 7 ) ) // for admin, taller mecanico
{	
	
	$anos = Disponibilidad_anos::getAllByOrden("ano", "DESC");
	$semanas = Disponibilidad_semanas::getAllByOrden("semana", "DESC");
	require_once(VIEW_PATH.'indexMedidoresSispa.view.php');
}
else
{
	// Include page view
	redirect_to('index.php');
}