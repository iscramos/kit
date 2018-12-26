<?php
//require_once $_SERVER["DOCUMENT_ROOT"].'/siscohistoraca2/__config.php';
require_once('includes/config.inc.php');
require_once('includes/inc.session.php');

$id = NULL;
$departamento = NULL;

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
		$departamento = $_POST['departamento'];
		

		// new object
		$departamentos = new Recursos_departamentos();
		//$categoria->id = $id;
		$departamentos->id = $id;
		$departamentos->departamento = $departamento;
		$departamentos->save();
	}	
}
else
{
	if ($_SERVER['REQUEST_METHOD'] == 'POST') 
	{
		// request data
		//$id = $_POST["id"];	
		$departamento = $_POST['departamento'];
		

		// new object
		$departamentos = new Recursos_departamentos();
		
		//$departamento->id = $id;
		$departamentos->departamento = $departamento;
		$departamentos->save();
	}
}

redirect_to('indexRecursosDepartamentos.php');

?>