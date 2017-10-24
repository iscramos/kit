<?php
//require_once $_SERVER["DOCUMENT_ROOT"].'/siscohistoraca2/__config.php';
require_once('includes/config.inc.php');
require_once('includes/inc.session.php');

$id = NULL;
$ano = NULL;
$mes = NULL;
$semana = NULL;
$totalmp = NULL;
$otrosmp = NULL;
$terminadosmp = NULL;
$pendientesmp = NULL;
$cumplimientomp = NULL;

$totalmc = NULL;
$otrosmc = NULL;
$terminadosmc = NULL;
$pendientesmc = NULL;
$acumuladosmc = NULL;
$cumplimientomc = NULL;

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
		$nombre_equipo = $_POST["nombre_equipo"];
		$familia = $_POST["familia"];

		// new object
		$activo = new Activos_equipos();
		$activo->id = $id;
		$activo->nombre_equipo = $nombre_equipo;
		$activo->familia = $familia;
		$activo->save();
	}	
}
else
{
	if ($_SERVER['REQUEST_METHOD'] == 'POST') 
	{
		// request data
		$ano = $_POST["ano"];
		$mes = $_POST["mes"];
		$semana = $_POST["semana"];
		$totalmp = $_POST["totalmp"];
		$otrosmp = $_POST["otrosmp"];
		$terminadosmp = $_POST["terminadosmp"];
		$pendientesmp = $_POST["pendientesmp"];
		$cumplimientomp = $_POST["cumplimientomp"];

		$totalmc = $_POST["totalmc"];
		$otrosmc = $_POST["otrosmc"];
		$terminadosmc = $_POST["terminadosmc"];
		$pendientesmc = $_POST["pendientesmc"];
		$acumuladosmc = $_POST["acumuladosmc"];
		$cumplimientomc = $_POST["cumplimientomc"];

		// new object
		$historico = new Mp_mc_historicos();
		$historico->ano = $ano;
		$historico->mes = $mes;
		$historico->semana = $semana;
		$historico->totalmp = $totalmp;
		$historico->otrosmp = $otrosmp;
		$historico->terminadosmp = $terminadosmp;
		$historico->pendientesmp = $pendientesmp;
		$historico->cumplimientomp = $cumplimientomp;

		$historico->totalmc = $totalmc;
		$historico->otrosmc = $otrosmc;
		$historico->terminadosmc = $terminadosmc;
		$historico->pendientesmc = $pendientesmc;
		$historico->acumuladosmc = $acumuladosmc;
		$historico->cumplimientomc = $cumplimientomc;
		$historico->save();
	}
}

//redirect_to('indexActivosEquipos.php');

?>