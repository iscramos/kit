<?php
//require_once $_SERVER["DOCUMENT_ROOT"].'/siscohistoraca2/__config.php';
require_once('includes/config.inc.php');
require_once('includes/inc.session.php');

$id = NULL;
$gh = NULL;
$zona = NULL;

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
		$gh = $_POST["gh"];
		$zona = $_POST["zona"];
		

		// new object
		$ghs = new Zancos_ghs();
		$ghs->id = $id;
		$ghs->gh = $gh;
		$ghs->zona = $zona;
		$ghs->save();
	}	
}
else
{
	if ($_SERVER['REQUEST_METHOD'] == 'POST') 
	{
		// request data
		//$id = $_POST["id"];
		$gh = $_POST["gh"];
		$zona = $_POST["zona"];

		// new object
		$ghs = new Zancos_ghs();
		//$categoria->id = $id;
		$ghs->gh = $gh;
		$ghs->zona = $zona;
		$ghs->save();
	}
}

redirect_to('indexZancos_ghs.php');

?>