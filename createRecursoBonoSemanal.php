<?php
//require_once $_SERVER["DOCUMENT_ROOT"].'/siscohistoraca2/__config.php';
require_once('includes/config.inc.php');
require_once('includes/inc.session.php');

$id = NULL;
$codigo_supervisor = NULL;
$nombre_supervisor = NULL;
$codigo = NULL;
$nombre = NULL;
$semana = NULL;
$id_actividad = NULL;
$nombre_actividad = NULL;
$pago_por = NULL;
$pago_especial = NULL;
$fecha = NULL;
$surcos_cajas = NULL;
$tiempo = NULL;
$hora_inicio = NULL;
$hora_fin = NULL;
$gh = NULL;
$zona = NULL;
$surcos_reales = NULL;
$surcos_hora = NULL;
$objetivo_hora = NULL;
$eficiencia = NULL;
$precio_actividad = NULL;
$subpago = NULL;
$lider = NULL;
$tiempo_muerto = NULL;
$observacion = NULL;

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
		// request data
		$id = $_POST["id"];
		//$codigo = $_POST["codigo"];
		//$nombre = $_POST["nombre"];
		//$semana = $_POST["semana"];
		//$id_actividad = $_POST["id_actividad"];
		//$nombre_actividad = $_POST["nombre_actividad"];
		//$pago_por = $_POST["pago_por"];
		$pago_especial = $_POST["pago_especial"];
		//$fecha = $_POST["fecha"];
		$surcos_cajas = $_POST["surcos_cajas"];
		$tiempo = $_POST["tiempo"];
		$hora_inicio = $_POST["hora_inicio"];
		$hora_fin = $_POST["hora_fin"];
		$gh = $_POST["gh"];
		//$zona = $_POST["zona"];
		$surcos_reales = $_POST["surcos_reales"];
		$surcos_hora = $_POST["surcos_hora"];
		//$objetivo_hora = $_POST["objetivo_hora"];
		$eficiencia = $_POST["eficiencia"];
		//$precio_actividad = $_POST["precio_actividad"];
		$subpago = $_POST["subpago"];
		//$lider = $_POST["lider"];
		$tiempo_muerto = $_POST["tiempo_muerto"];
		$observacion = $_POST["observacion"];
		

		// new object
		$bonos = new Recursos_bonos_semanal();
		
		$bonos->id = $id;
		//$bonos->codigo = $codigo;
		//$bonos->nombre = $nombre;
		//$bonos->semana = $semana;
		//$bonos->id_actividad = $id_actividad;
		//$bonos->nombre_actividad = $nombre_actividad;
		//$bonos->pago_por = $pago_por;
		$bonos->pago_especial = $pago_especial;
		//$bonos->fecha = $fecha;
		$bonos->surcos_cajas = $surcos_cajas;
		$bonos->tiempo = $tiempo;
		$bonos->hora_inicio = $hora_inicio;
		$bonos->hora_fin = $hora_fin;
		$bonos->gh = $gh;
		//$bonos->zona = $zona;
		$bonos->surcos_reales = $surcos_reales;
		$bonos->surcos_hora = $surcos_hora;
		//$bonos->objetivo_hora = $objetivo_hora;
		$bonos->eficiencia = $eficiencia;
		//$bonos->precio_actividad = $precio_actividad;
		$bonos->subpago = $subpago;
		//$bonos->lider = $lider;
		$bonos->tiempo_muerto = $tiempo_muerto;
		$bonos->observacion = $observacion;
		$bonos->save();
	}	
}
else
{
	if ($_SERVER['REQUEST_METHOD'] == 'POST') 
	{
		// request data
		//$id = $_POST["id"];
		$codigo_supervisor = $_POST["codigo_supervisor"];
		$nombre_supervisor = $_POST["nombre_supervisor"];
		$codigo = $_POST["codigo"];
		$nombre = $_POST["nombre"];
		$semana = $_POST["semana"];
		$id_actividad = $_POST["id_actividad"];
		$nombre_actividad = $_POST["nombre_actividad"];
		$pago_por = $_POST["pago_por"];
		$pago_especial = $_POST["pago_especial"];
		$fecha = $_POST["fecha"];
		$surcos_cajas = $_POST["surcos_cajas"];
		$tiempo = $_POST["tiempo"];
		$hora_inicio = $_POST["hora_inicio"];
		$hora_fin = $_POST["hora_fin"];
		$gh = $_POST["gh"];
		$zona = $_POST["zona"];
		$surcos_reales = $_POST["surcos_reales"];
		$surcos_hora = $_POST["surcos_hora"];
		$objetivo_hora = $_POST["objetivo_hora"];
		$eficiencia = $_POST["eficiencia"];
		$precio_actividad = $_POST["precio_actividad"];
		$subpago = $_POST["subpago"];
		$lider = $_POST["lider"];
		$tiempo_muerto = $_POST["tiempo_muerto"];
		$observacion = $_POST["observacion"];
		

		// new object
		$bonos = new Recursos_bonos_semanal();
		
		//$departamento->id = $id;
		$bonos->codigo_supervisor = $codigo_supervisor;
		$bonos->nombre_supervisor = $nombre_supervisor;
		$bonos->codigo = $codigo;
		$bonos->nombre = $nombre;
		$bonos->semana = $semana;
		$bonos->id_actividad = $id_actividad;
		$bonos->nombre_actividad = $nombre_actividad;
		$bonos->pago_por = $pago_por;
		$bonos->pago_especial = $pago_especial;
		$bonos->fecha = $fecha;
		$bonos->surcos_cajas = $surcos_cajas;
		$bonos->tiempo = $tiempo;
		$bonos->hora_inicio = $hora_inicio;
		$bonos->hora_fin = $hora_fin;
		$bonos->gh = $gh;
		$bonos->zona = $zona;
		$bonos->surcos_reales = $surcos_reales;
		$bonos->surcos_hora = $surcos_hora;
		$bonos->objetivo_hora = $objetivo_hora;
		$bonos->eficiencia = $eficiencia;
		$bonos->precio_actividad = $precio_actividad;
		$bonos->subpago = $subpago;
		$bonos->lider = $lider;
		$bonos->tiempo_muerto = $tiempo_muerto;
		$bonos->observacion = $observacion;
		$bonos->save();
	}
}

redirect_to('indexRecursosBonosSemanales.php');

?>