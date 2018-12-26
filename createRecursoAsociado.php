<?php
//require_once $_SERVER["DOCUMENT_ROOT"].'/siscohistoraca2/__config.php';
require_once('includes/config.inc.php');
require_once('includes/inc.session.php');

$id = NULL;
$tipo = NULL;
$rango = NULL;
$codigo = NULL;
$nombre = NULL;
$sexo = NULL;
$departamento = NULL;
$puesto = NULL;
$f_nacimiento = NULL;
$f_ingreso = NULL;
$activo = NULL;
$lider = NULL;
$zona = NULL;
$gh = NULL;
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
		$tipo = $_POST['tipo'];
		$rango = $_POST['rango'];
		$codigo = $_POST['codigo'];
		$nombre = $_POST['nombre'];
		$sexo = $_POST['sexo'];
		$departamento = $_POST['departamento'];
		$puesto = $_POST['puesto'];
		$f_nacimiento = $_POST['f_nacimiento'];
		$f_ingreso = $_POST['f_ingreso'];
		$activo = $_POST['activo'];
		$lider = $_POST['lider'];
		$zona = $_POST['zona'];
		$gh = $_POST['gh'];
		

		// new object
		$asociado = new Recursos_asociados();
		//$categoria->id = $id;
		$asociado->id = $id;
		$asociado->tipo = $tipo;
		$asociado->rango = $rango;
		$asociado->codigo = $codigo;
		$asociado->nombre = $nombre;
		$asociado->sexo = $sexo;
		$asociado->departamento = $departamento;
		$asociado->puesto = $puesto;
		$asociado->f_nacimiento = $f_nacimiento;
		$asociado->f_ingreso = $f_ingreso;
		$asociado->activo = $activo;
		$asociado->lider = $lider;
		$asociado->zona = $zona;
		$asociado->gh = $gh;
		$asociado->save();
	}	
}
else
{
	if ($_SERVER['REQUEST_METHOD'] == 'POST') 
	{
		// request data
		//$id = $_POST["id"];	
		$tipo = $_POST['tipo'];
		$rango = $_POST['rango'];
		$codigo = $_POST['codigo'];
		$nombre = $_POST['nombre'];
		$sexo = $_POST['sexo'];
		$departamento = $_POST['departamento'];
		$puesto = $_POST['puesto'];
		$f_nacimiento = $_POST['f_nacimiento'];
		$f_ingreso = $_POST['f_ingreso'];
		$activo = $_POST['activo'];
		$lider = $_POST['lider'];
		$zona = $_POST['zona'];
		$gh = $_POST['gh'];
		

		// new object
		$asociado = new Recursos_asociados();
		
		//$asociado->id = $id;
		$asociado->tipo = $tipo;
		$asociado->rango = $rango;
		$asociado->codigo = $codigo;
		$asociado->nombre = $nombre;
		$asociado->sexo = $sexo;
		$asociado->departamento = $departamento;
		$asociado->puesto = $puesto;
		$asociado->f_nacimiento = $f_nacimiento;
		$asociado->f_ingreso = $f_ingreso;
		$asociado->activo = $activo;
		$asociado->lider = $lider;
		$asociado->zona = $zona;
		$asociado->gh = $gh;
		$asociado->save();
	}
}

redirect_to('indexRecursosAsociados.php');

?>