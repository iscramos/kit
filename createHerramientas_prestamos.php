<?php
//require_once $_SERVER["DOCUMENT_ROOT"].'/siscohistoraca2/__config.php';
require_once('includes/config.inc.php');
require_once('includes/inc.session.php');

$id = NULL;
$id_herramienta = NULL;
$id_almacen = NULL;
$id_categoria = NULL;
$fecha_prestamo = NULL;
$fecha_regreso = NULL;
$estatus = NULL;
$noAsociado = NULL;
$nombre = NULL;
$observacion = NULL;

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
		$id_herramienta = $_POST["id_herramienta"];
		//$id_almacen = $_POST["id_almacen"];
		//$id_categoria = $_POST["id_categoria"];
		//$fecha_prestamo = $_POST['fecha_prestamo'];
		$fecha_regreso = $_POST["fecha_regreso"];
		$estatus = $_POST["estatus"];
		//$noAsociado = $_POST["noAsociado"];
		//$nombre = $_POST["nombre"];
		$observacion = $_POST["observacion"];
		

		// new object
		$prestamos = new Herramientas_prestamos();
		$prestamos->id = $id;
		$prestamos->id_herramienta = $id_herramienta;
		//$prestamos->id_almacen = $id_almacen;
		//$prestamos->id_categoria = $id_categoria;
		//$prestamos->fecha_prestamo = $fecha_prestamo;
		$prestamos->fecha_regreso = $fecha_regreso;
		$prestamos->estatus = $estatus;
		//$prestamos->noAsociado = $noAsociado;
		//$prestamos->nombre = $nombre;
		$prestamos->observacion = $observacion;

		$prestamos->save();
	}	
}
else
{
	if ($_SERVER['REQUEST_METHOD'] == 'POST') 
	{
		// request data
		//$id = $_POST["id"];
		$id_herramienta = $_POST["id_herramienta"];
		$id_almacen = $_POST["id_almacen"];
		$id_categoria = $_POST["id_categoria"];
		$fecha_prestamo = $_POST['fecha_prestamo'];
		//$fecha_regreso = $_POST["fecha_regreso"];
		$estatus = $_POST["estatus"];
		$noAsociado = $_POST["noAsociado"];
		$nombre = $_POST["nombre"];
		//$observacion = $_POST["observacion"];
		

		// new object
		$prestamos = new Herramientas_prestamos();
		$prestamos->id_herramienta = $id_herramienta;
		$prestamos->id_almacen = $id_almacen;
		$prestamos->id_categoria = $id_categoria;
		$prestamos->fecha_prestamo = $fecha_prestamo;
		$prestamos->estatus = $estatus;
		$prestamos->noAsociado = $noAsociado;
		$prestamos->nombre = $nombre;
		//$prestamos->fecha_prestamo = $fecha_prestamo;

		$prestamos->save();
	}
}

redirect_to('indexHerramientas_prestamos.php?id_herramienta='.$id_herramienta);

?>