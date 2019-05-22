<?php
//require_once $_SERVER["DOCUMENT_ROOT"].'/siscohistoraca2/__config.php';
require_once('includes/config.inc.php');
require_once('includes/inc.session.php');

$id = NULL;
$ns = NULL;
$nombre = NULL;

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
		$ns = $_POST["ns"];
		$nombre = $_POST["nombre"];
		

		// new object
		$lideres = new Zancos_lideres();
		$lideres->id = $id;
		$lideres->ns = $ns;
		$lideres->nombre = $nombre;
		$lideres->save();
	}	
}
else
{
	if ($_SERVER['REQUEST_METHOD'] == 'POST') 
	{
		// request data
		//$id = $_POST["id"];
		$ns = $_POST["ns"];
		$nombre = $_POST["nombre"];
		

		// new object
		$lideres = new Zancos_lideres();
		//$categoria->id = $id;
		$lideres->ns = $ns;
		$lideres->nombre = $nombre;
		$lideres->save();
	}
}

redirect_to('indexZancos_lideres.php');

?>