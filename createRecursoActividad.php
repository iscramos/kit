<?php
//require_once $_SERVER["DOCUMENT_ROOT"].'/siscohistoraca2/__config.php';
require_once('includes/config.inc.php');
require_once('includes/inc.session.php');

$id = NULL;
$id_actividad = NULL;
$nombre = NULL;
$etapa = NULL;
$objetivo = NULL;
$eficiencia_exponencial = NULL;
$pago_surco = NULL;
$tipo_jornal = NULL;
$tipo_pago = NULL;
$centro_costo = NULL;
$factor = NULL;

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
		$id_actividad = $_POST['id_actividad'];
		$nombre = $_POST['nombre'];
		$etapa = $_POST['etapa'];
		$objetivo = $_POST['objetivo'];
		$eficiencia_exponencial = $_POST['eficiencia_exponencial'];
		$pago_surco = $_POST['pago_surco'];
		$tipo_jornal = $_POST['tipo_jornal'];
		$tipo_pago = $_POST['tipo_pago'];
		$centro_costo = $_POST['centro_costo'];
		$factor = $_POST['factor'];
		

		// new object
		$act = new Recursos_actividades();
		
		$act->id = $id;
		$act->id_actividad = $id_actividad;
		$act->nombre = $nombre;
		$act->etapa = $etapa;
		$act->objetivo = $objetivo;
		$act->eficiencia_exponencial = $eficiencia_exponencial;
		$act->pago_surco = $pago_surco;
		$act->tipo_jornal = $tipo_jornal;
		$act->tipo_pago = $tipo_pago;
		$act->centro_costo = $centro_costo;
		$act->factor = $factor;
		$act->save();
	}	
}
else
{
	if ($_SERVER['REQUEST_METHOD'] == 'POST') 
	{
		// request data
		//$id = $_POST["id"];	
		$id_actividad = $_POST['id_actividad'];
		$nombre = $_POST['nombre'];
		$etapa = $_POST['etapa'];
		$objetivo = $_POST['objetivo'];
		$eficiencia_exponencial = $_POST['eficiencia_exponencial'];
		$pago_surco = $_POST['pago_surco'];
		$tipo_jornal = $_POST['tipo_jornal'];
		$tipo_pago = $_POST['tipo_pago'];
		$centro_costo = $_POST['centro_costo'];
		$factor = $_POST['factor'];
		

		// new object
		$act = new Recursos_actividades();
		
		//$departamento->id = $id;
		$act->id_actividad = $id_actividad;
		$act->nombre = $nombre;
		$act->etapa = $etapa;
		$act->objetivo = $objetivo;
		$act->eficiencia_exponencial = $eficiencia_exponencial;
		$act->pago_surco = $pago_surco;
		$act->tipo_jornal = $tipo_jornal;
		$act->tipo_pago = $tipo_pago;
		$act->centro_costo = $centro_costo;
		$act->factor = $factor;
		$act->save();
	}
}

redirect_to('indexRecursosActividades.php');

?>