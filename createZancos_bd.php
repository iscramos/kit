<?php
//require_once $_SERVER["DOCUMENT_ROOT"].'/siscohistoraca2/__config.php';
require_once('includes/config.inc.php');
require_once('includes/inc.session.php');

$id = NULL;
$no_zanco = NULL;
$tamano = NULL;

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
		$no_zanco = $_POST["no_zanco"];
		$tamano = $_POST["tamano"];
		

		// new object
		$bd = new Zancos_bd();
		$bd->id = $id;
		$bd->no_zanco = $no_zanco;
		$bd->tamano = $tamano;
		$bd->save();
	}	
}
else
{
	if ($_SERVER['REQUEST_METHOD'] == 'POST') 
	{
		// request data
		//$id = $_POST["id"];
		$no_zanco = $_POST["no_zanco"];
		$tamano = $_POST["tamano"];

		// new object
		$bd = new Zancos_bd();
		//$categoria->id = $id;
		$bd->no_zanco = $no_zanco;
		$bd->tamano = $tamano;
		$bd->save();
	}
}

redirect_to('indexZancos_bd.php');

?>