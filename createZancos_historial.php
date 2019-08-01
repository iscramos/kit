<?php
//require_once $_SERVER["DOCUMENT_ROOT"].'/siscohistoraca2/__config.php';
require_once('includes/config.inc.php');
require_once('includes/inc.session.php');

$id = NULL;
$id_registro = NULL;
$no_zanco = NULL;
$parte = NULL;
$problema = NULL;
$notas = NULL;

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
		$accion = $_POST["accion"];
		

		// new object
		$acciones = new Zancos_acciones();
		$acciones->id = $id;
		$acciones->accion = $accion;
		$acciones->save();
	}	
}
else
{
	if ($_SERVER['REQUEST_METHOD'] == 'POST') 
	{
		// request data
		//$id = $_POST["id"];
		$id_registro = $_POST["pieza_registro"];
		$no_zanco = $_POST["pieza_zanco"];
		$parte = $_POST["pieza_parte"];
		$problema = $_POST["pieza_problema"];
		$notas = sanitize_output($_POST["pieza_notas"]);
		

		// new object
		$historial = new Zancos_historial_piezas();
		//$historial->id = $id;
		$historial->id_registro = $id_registro;
		$historial->no_zanco = $no_zanco;
		$historial->parte = $parte;
		$historial->problema = $problema;
		$historial->notas = $notas;
		$historial->save();

		echo "PIEZA AGREGADA AL HISTORIAL...";
	}
}


//redirect_to('indexZancos_acciones.php');

?>