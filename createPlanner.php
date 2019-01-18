<?php
//require_once $_SERVER["DOCUMENT_ROOT"].'/siscohistoraca2/__config.php';
require_once('includes/config.inc.php');
require_once('includes/inc.session.php');

$id = NULL;
$equipo = NULL;
$fecha_realizacion = NULL;
$hora_inicio = NULL;
$hora_fin = NULL;
$frecuencia = NULL;

//echo date("Y-m-d H:i", $_POST["fechaLectura"]);
/*echo strftime("%Y-%m-%d %H:%M", strtotime($_POST["fechaLectura"]));*/
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
		//$equipo = $_POST['equipo'];
		$fecha_realizacion = $_POST['fecha_realizacion'];
		$hora_inicio = $_POST['hora_inicio'];
		$hora_fin = $_POST['hora_fin'];
		$frecuencia = $_POST['frecuencia'];
		

		// new object
		$plan = new Planner();
		
		$plan->id = $id;
		//$plan->equipo = $equipo;
		$plan->fecha_realizacion = $fecha_realizacion;
		$plan->hora_inicio = $hora_inicio;
		$plan->hora_fin = $hora_fin;
		$plan->frecuencia = $frecuencia;
		$plan->save();
	}	
}
else
{
	if ($_SERVER['REQUEST_METHOD'] == 'POST') 
	{
		// request data
		//$id = $_POST["id"];	
		$equipo = $_POST['equipo'];
		$fecha_realizacion = $_POST['fecha_realizacion'];
		$hora_inicio = $_POST['hora_inicio'];
		$hora_fin = $_POST['hora_fin'];
		$frecuencia = $_POST['frecuencia'];
		

		// new object
		$plan = new Planner();
		
		//$plan->id = $id;
		$plan->equipo = $equipo;
		$plan->fecha_realizacion = $fecha_realizacion;
		$plan->hora_inicio = $hora_inicio;
		$plan->hora_fin = $hora_fin;
		$plan->frecuencia = $frecuencia;
		$plan->save();
	}
}

redirect_to('indexPlanner.php');

?>