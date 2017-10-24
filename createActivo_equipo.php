<?php
//require_once $_SERVER["DOCUMENT_ROOT"].'/siscohistoraca2/__config.php';
require_once('includes/config.inc.php');
require_once('includes/inc.session.php');

$id = NULL;
$nombre_equipo = NULL;
$familia = NULL;

/*echo "<pre>";
	print_r($_POST);
echo "</pre>";
die("He llegado");*/

if(isset($_POST["id"]) && intval($_POST["id"]) > 0)
{
	if ($_SERVER['REQUEST_METHOD'] == 'POST') 
	{

		// request data
		$id = $_POST["id"];
		$nombre_equipo = $_POST["nombre_equipo"];
		$familia = $_POST["familia"];

		// new object
		$activo = new Activos_equipos();
		$activo->id = $id;
		$activo->nombre_equipo = $nombre_equipo;
		$activo->familia = $familia;
		$activo->save();
	}	
}
else
{
	if ($_SERVER['REQUEST_METHOD'] == 'POST') 
	{
		// request data
		$nombre_equipo = $_POST["nombre_equipo"];
		$familia = $_POST["familia"];

		// new object
		$activo = new Activos_equipos();
		$activo->nombre_equipo = $nombre_equipo;
		$activo->familia = $familia;
		$activo->save();
	}
}

redirect_to('indexActivosEquipos.php');

?>