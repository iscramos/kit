<?php
//require_once $_SERVER["DOCUMENT_ROOT"].'/siscohistoraca2/__config.php';
require_once('includes/config.inc.php');
require_once('includes/inc.session.php');

$id = NULL;
$tamano = NULL;
$limite_semana = NULL;

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
		$tamano = $_POST["tamano"];
		$limite_semana = $_POST["limite_semana"];
		

		// new object
		$tamanos = new Zancos_tamanos();
		$tamanos->id = $id;
		$tamanos->tamano = $tamano;
		$tamanos->limite_semana = $limite_semana;
		$tamanos->save();
	}	
}
else
{
	if ($_SERVER['REQUEST_METHOD'] == 'POST') 
	{
		// request data
		//$id = $_POST["id"];
		$tamano = $_POST["tamano"];
		$limite_semana = $_POST["limite_semana"];
		

		// new object
		$tamanos = new Zancos_tamanos();
		//$categoria->id = $id;
		$tamanos->tamano = $tamano;
		$tamanos->limite_semana = $limite_semana;
		$tamanos->save();
	}
}

redirect_to('indexZancos_tamanos.php');

?>