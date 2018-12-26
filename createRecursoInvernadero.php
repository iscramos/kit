<?php
//require_once $_SERVER["DOCUMENT_ROOT"].'/siscohistoraca2/__config.php';
require_once('includes/config.inc.php');
require_once('includes/inc.session.php');

$id = NULL;
$invernadero = NULL;
$zona = NULL;
$surcos = NULL;
$metros_lineales_estandar = NULL;
$metros_lineales_reales = NULL;
$surco_real = NULL;

//echo date("Y-m-d H:i", $_POST["fechaLectura"]);
/*echo strftime("%Y-%m-%d %H:%M", strtotime($_POST["fechaLectura"]));*/
/*echo "<pre>";
	print_r($_POST);
echo "</pre>";
die("He llegado");*/

if(isset($_POST["id"]) && intval($_POST["id"]) > 0)
{
	if ($_SERVER['REQUEST_METHOD'] == 'POST') 
	{
		//die("entro");
		// request data
		$id = $_POST["id"];
		$invernadero = $_POST['invernadero'];
		$zona = $_POST['zona'];
		$surcos = $_POST['surcos'];
		$metros_lineales_estandar = $_POST['metros_lineales_estandar'];
		$metros_lineales_reales = $_POST['metros_lineales_reales'];
		$surco_real = $_POST['surco_real'];
		

		// new object
		$inv = new Recursos_invernaderos();
		
		$inv->id = $id;
		$inv->invernadero = $invernadero;
		$inv->zona = $zona;
		$inv->surcos = $surcos;
		$inv->metros_lineales_estandar = $metros_lineales_estandar;
		$inv->metros_lineales_reales = $metros_lineales_reales;
		$inv->surco_real = $surco_real;
		$inv->save();
	}	
}
else
{
	if ($_SERVER['REQUEST_METHOD'] == 'POST') 
	{
		// request data
		//$id = $_POST["id"];	
		$invernadero = $_POST['invernadero'];
		$zona = $_POST['zona'];
		$surcos = $_POST['surcos'];
		$metros_lineales_estandar = $_POST['metros_lineales_estandar'];
		$metros_lineales_reales = $_POST['metros_lineales_reales'];
		$surco_real = $_POST['surco_real'];
		

		// new object
		$inv = new Recursos_invernaderos();
		
		//$departamento->id = $id;
		$inv->invernadero = $invernadero;
		$inv->zona = $zona;
		$inv->surcos = $surcos;
		$inv->metros_lineales_estandar = $metros_lineales_estandar;
		$inv->metros_lineales_reales = $metros_lineales_reales;
		$inv->surco_real = $surco_real;
		$inv->save();
	}
}

redirect_to('indexRecursosInvernaderos.php');

?>