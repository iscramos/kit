<?php
//require_once $_SERVER["DOCUMENT_ROOT"].'/siscohistoraca2/__config.php';
require_once('includes/config.inc.php');
require_once('includes/inc.session.php');

$id = NULL;
$descripcion = NULL;

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
		$descripcion = $_POST["descripcion"];

		// new object
		$problemas = new Zancos_problemas();
		$problemas->id = $id;
		$problemas->descripcion = $descripcion;
		$problemas->save();
	}	
}
else
{
	if ($_SERVER['REQUEST_METHOD'] == 'POST') 
	{
		// request data
		//$id = $_POST["id"];
		$descripcion = $_POST["descripcion"];

		// new object
		$problemas = new Zancos_problemas();
		//$categoria->id = $id;
		$problemas->descripcion = $descripcion;
		$problemas->save();
	}
}

redirect_to('indexZancos_problemas.php');

?>