<?php
//require_once $_SERVER["DOCUMENT_ROOT"].'/siscohistoraca2/__config.php';
require_once('includes/config.inc.php');
require_once('includes/inc.session.php');

$id = NULL;
$id_herramienta = NULL;
$fecha_prestamo = NULL;
$fecha_regreso = NULL;
$estatus = NULL;
$noAsociado = NULL;
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
		$clave = $_POST["clave"];
		$id_categoria = $_POST["id_categoria"];
		$descripcion = $_POST["descripcion"];
		$precio_unitario = $_POST["precio_unitario"];
		$id_almacen = $_POST["id_almacen"];
		

		// new object
		$herramientas = new Herramientas_herramientas();
		$herramientas->id = $id;
		$herramientas->clave = $clave;
		$herramientas->id_categoria = $id_categoria;
		$herramientas->descripcion = $descripcion;
		$herramientas->precio_unitario = $precio_unitario;

		$herramientas->save();
	}	
}
else
{
	if ($_SERVER['REQUEST_METHOD'] == 'POST') 
	{
		// request data
		//$id = $_POST["id"];
		$id_herramienta = $_POST["id_herramienta"];
		$fecha_prestamo = date("Y-m-d H:i:s", strtotime($_POST['fecha_prestamo']) );
		//$fecha_regreso = $_POST["fecha_regreso"];
		$estatus = $_POST["estatus"];
		$noAsociado = $_POST["noAsociado"];
		//$observacion = $_POST["observacion"];
		

		// new object
		$prestamos = new Herramientas_prestamos();
		$prestamos->id_herramienta = $id_herramienta;
		$prestamos->fecha_prestamo = $fecha_prestamo;
		$prestamos->estatus = $estatus;
		$prestamos->noAsociado = $noAsociado;

		$prestamos->save();
	}
}

redirect_to('indexHerramientas_prestamos.php?id_herramienta='.$id_herramienta);

?>