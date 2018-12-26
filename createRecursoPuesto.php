<?php
//require_once $_SERVER["DOCUMENT_ROOT"].'/siscohistoraca2/__config.php';
require_once('includes/config.inc.php');
require_once('includes/inc.session.php');

$id = NULL;
$puesto = NULL;

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
		//$id = $_POST["id"];
		$puesto = $_POST['puesto'];
		

		// new object
		$p = new Recursos_puestos();
		//$categoria->id = $id;
		$p->id = $id;
		$p->puesto = $puesto;
		$p->save();
	}	
}
else
{
	if ($_SERVER['REQUEST_METHOD'] == 'POST') 
	{
		// request data
		//$id = $_POST["id"];	
		$puesto = $_POST['puesto'];
		

		// new object
		$p = new Recursos_puestos();
		
		//$departamento->id = $id;
		$p->puesto = $puesto;
		$p->save();
	}
}

redirect_to('indexRecursosPuestos.php');

?>