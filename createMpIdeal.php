<?php
//require_once $_SERVER["DOCUMENT_ROOT"].'/siscohistoraca2/__config.php';
require_once('includes/config.inc.php');
require_once('includes/inc.session.php');

$id = NULL;
$id_activo_equipo = NULL;
$A = NULL;
$B = NULL;
$C = NULL;
$D = NULL;
$E = NULL;
$F = NULL;

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
		$id_activo_equipo = $_POST["id_activo_equipo"];
		$A = $_POST['A'];
		$B = $_POST['B'];
		$C = $_POST['C'];
		$D = $_POST['D'];
		$E = $_POST['E'];
		$F = $_POST['F'];

		// new object
		$ideal = new Mpideales();
		$ideal->id = $id;
		$ideal->id_activo_equipo = $id_activo_equipo;
		$ideal->A = $A;
		$ideal->B = $B;
		$ideal->C = $C;
		$ideal->D = $D;
		$ideal->E = $E;
		$ideal->F = $F;
		$ideal->save();
	}	
}
else
{
	if ($_SERVER['REQUEST_METHOD'] == 'POST') 
	{
		/*echo "<pre>";
	print_r($_POST);
echo "</pre>";
die("He llegado");*/
		// request data
		//$id = $_POST["id"];
		$id_activo_equipo = $_POST["id_activo_equipo"];
		$A = $_POST['A'];
		$B = $_POST['B'];
		$C = $_POST['C'];
		$D = $_POST['D'];
		$E = $_POST['E'];
		$F = $_POST['F'];

		// new object
		$ideal = new Mpideales();
		//$ideal->id = $id;
		$ideal->id_activo_equipo = $id_activo_equipo;
		$ideal->A = $A;
		$ideal->B = $B;
		$ideal->C = $C;
		$ideal->D = $D;
		$ideal->E = $E;
		$ideal->F = $F;
		$ideal->save();
	}
}

redirect_to('indexMpIdeal.php');

?>