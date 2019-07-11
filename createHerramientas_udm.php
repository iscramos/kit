<?php
//require_once $_SERVER["DOCUMENT_ROOT"].'/siscohistoraca2/__config.php';
require_once('includes/config.inc.php');
require_once('includes/inc.session.php');

$id = NULL;
$udm = NULL;
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
		$udm = $_POST["udm"];
		$descripcion = $_POST["descripcion"];
		

		// new object
		$medidas = new Herramientas_udm();
		$medidas->id = $id;
		$medidas->udm = $udm;
		$medidas->descripcion = $descripcion;
		$medidas->save();
	}	
}
else
{
	if ($_SERVER['REQUEST_METHOD'] == 'POST') 
	{
		// request data
		//$id = $_POST["id"];
		$udm = $_POST["udm"];
		$descripcion = $_POST["descripcion"];
		

		// new object
		$medidas = new Herramientas_udm();
		//$categoria->id = $id;
		$medidas->udm = $udm;
		$medidas->descripcion = $descripcion;
		$medidas->save();
	}
}

redirect_to('indexHerramientas_udm.php');

?>