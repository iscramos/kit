<?php
//require_once $_SERVER["DOCUMENT_ROOT"].'/siscohistoraca2/__config.php';
require_once('includes/config.inc.php');
require_once('includes/inc.session.php');

$id = NULL;
$categoria = NULL;

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
		$categoria = $_POST["categoria"];
		

		// new object
		$categorias = new Herramientas_categorias();
		$categorias->id = $id;
		$categorias->categoria = $categoria;
		$categorias->save();
	}	
}
else
{
	if ($_SERVER['REQUEST_METHOD'] == 'POST') 
	{
		// request data
		//$id = $_POST["id"];
		$categoria = $_POST["categoria"];
		

		// new object
		$categorias = new Herramientas_categorias();
		//$categoria->id = $id;
		$categorias->categoria = $categoria;
		$categorias->save();
	}
}

redirect_to('indexHerramientas_categorias.php');

?>