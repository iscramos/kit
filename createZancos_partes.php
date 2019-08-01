<?php
//require_once $_SERVER["DOCUMENT_ROOT"].'/siscohistoraca2/__config.php';
require_once('includes/config.inc.php');
require_once('includes/inc.session.php');

$id = NULL;
$accion = NULL;

echo "<pre>";
	print_r($_POST);
echo "</pre>";
die("He llegado");

if(isset($_POST["id"]) && intval($_POST["id"]) > 0)
{
	if ($_SERVER['REQUEST_METHOD'] == 'POST') 
	{

		// request data
		$id = $_POST["id"];
		$accion = $_POST["accion"];
		

		// new object
		$acciones = new Zancos_acciones();
		$acciones->id = $id;
		$acciones->accion = $accion;
		$acciones->save();
	}	
}
else
{
	if ($_SERVER['REQUEST_METHOD'] == 'POST') 
	{
		// request data
		//$id = $_POST["id"];
		$accion = $_POST["accion"];
		

		// new object
		$acciones = new Zancos_acciones();
		//$categoria->id = $id;
		$acciones->accion = $accion;
		$acciones->save();
	}
}

redirect_to('indexZancos_acciones.php');

?>