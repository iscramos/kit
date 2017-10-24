<?php
//require_once $_SERVER["DOCUMENT_ROOT"].'/siscohistoraca2/__config.php';
require_once('includes/config.inc.php');
require_once('includes/inc.session.php');

$id = NULL;
$clave = NULL;
$id_categoria = NULL;
$descripcion = NULL;
$precio_unitario = NULL;
$fecha_entrada = NULL;

$id_almacen = NULL;

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
		$clave = $_POST["clave"];
		$id_categoria = $_POST["id_categoria"];
		$descripcion = $_POST["descripcion"];
		$precio_unitario = $_POST["precio_unitario"];
		$id_almacen = $_POST["id_almacen"];
		

		// new object
		$herramientas = new Herramientas_herramientas();
		//$herramientas->id = $id;
		$herramientas->clave = $clave;
		$herramientas->id_categoria = $id_categoria;
		$herramientas->descripcion = $descripcion;
		$herramientas->precio_unitario = $precio_unitario;
		$herramientas->fecha_entrada = date("Y-m-d H:i:s");

		$herramientas->save();
	}
}

redirect_to('indexHerramientas_herramientas.php?id_categoria='.$id_categoria.'&id_almacen='.$id_almacen);

?>