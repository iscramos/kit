<?php 

// Initialize site configuration
require_once('includes/config.inc.php');
require_once('includes/inc.session.php');
//require_once("lib/login.php");

// Get posts from database
//echo $_SESSION["school"];

if($_SESSION["type"] == 1 || $_SESSION["type"] == 7) // para admin y hidroelectrico
{
	$consulta = "SELECT bd_rebombeo.*, (DATE_FORMAT(bd_rebombeo.fechaLectura, '%d/%m/%Y %H:%i')) AS fecha_fomateada, disponibilidad_activos.descripcion, tipoMedicion_rebombeo.descripcion as tipoM
					FROM bd_rebombeo
					INNER JOIN disponibilidad_activos ON bd_rebombeo.equipo = disponibilidad_activos.activo
					INNER JOIN tipoMedicion_rebombeo ON bd_rebombeo.tipo = tipoMedicion_rebombeo.id
					WHERE disponibilidad_activos.organizacion = 'COL'
					/*AND DATE_FORMAT(bd_rebombeo.fechaLectura, '%Y-%m-%d') >= '2018-12-30'*/
					ORDER BY bd_rebombeo.fechaLectura DESC, disponibilidad_activos.descripcion ASC, tipoMedicion_rebombeo.descripcion ASC
						LIMIT 1000";
	$mediciones = Bd_rebombeo::getAllByQuery($consulta);
	// Include page view
	require_once(VIEW_PATH.'indexMedicionesRebombeo.view.php');
}
else
{
	// Include page view
	redirect_to('index.php');
}