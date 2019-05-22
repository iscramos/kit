<?php
//require_once $_SERVER["DOCUMENT_ROOT"].'/siscohistoraca2/__config.php';
require_once('includes/config.inc.php');
require_once('includes/inc.session.php');

$no_zanco = NULL;
$id_registro = NULL;
$tamano = NULL;
$tiempo_limite = NULL;
$tipo_movimiento = NULL;
$gh = NULL;
$zona = NULL;
$fecha_activacion_o_baja = NULL;
$ns_salida_lider = NULL;
$nombre_lider_salida = NULL;
$fecha_salida = NULL;
$wk_salida = NULL;
$fecha_entrega = NULL;
$wk_entrega = NULL;
$fecha_servicio = NULL;
$descripcion_problema = NULL;

/*echo "<pre>";
	print_r($_POST);
echo "</pre>";
die("He llegado");*/

if(isset($_POST["id_registro"]) && intval($_POST["id_registro"]) > 0)
{
	if ($_SERVER['REQUEST_METHOD'] == 'POST') 
	{

		// request data
		$no_zanco = $_POST["no_zanco"];
		$id_registro = $_POST["id_registro"];
		$tamano = $_POST["tamano"];
		$tiempo_limite = $_POST["tiempo_limite"];
		$tipo_movimiento = $_POST["tipo_movimiento"];
		$gh = $_POST["gh"];
		$zona = $_POST["zona"];
		$fecha_activacion_o_baja = $_POST["fecha_activacion_o_baja"];
		$ns_salida_lider = $_POST["ns_salida_lider"];
		$nombre_lider_salida = $_POST["nombre_lider_salida"];
		$fecha_salida = $_POST["fecha_salida"];
		$wk_salida = $_POST["wk_salida"];
		$fecha_entrega = $_POST["fecha_entrega"];
		$wk_entrega = $_POST["wk_entrega"];
		$fecha_servicio = $_POST["fecha_servicio"];
		$descripcion_problema = $_POST["descripcion_problema"];
		

		// new object
		$movimientos = new Zancos_movimientos();

		$movimientos->no_zanco = $no_zanco;
		$movimientos->id_registro = $id_registro;
		$movimientos->tamano = $tamano;
		$movimientos->tiempo_limite = $tiempo_limite;
		$movimientos->tipo_movimiento = $tipo_movimiento;
		$movimientos->gh = $gh;
		$movimientos->zona = $zona;
		$movimientos->fecha_activacion_o_baja = $fecha_activacion_o_baja;
		$movimientos->ns_salida_lider = $ns_salida_lider;
		$movimientos->nombre_lider_salida = $nombre_lider_salida;
		$movimientos->fecha_salida = $fecha_salida;
		$movimientos->wk_salida = $wk_salida;
		$movimientos->fecha_entrega = $fecha_entrega;
		$movimientos->wk_entrega = $wk_entrega;
		$movimientos->fecha_servicio = $fecha_servicio;
		$movimientos->descripcion_problema = $descripcion_problema;
		$movimientos->save();
	}	
}
else
{
	if ($_SERVER['REQUEST_METHOD'] == 'POST') 
	{
		// request data
		$no_zanco = $_POST["no_zanco"];
		//$id_registro = $_POST["id_registro"];
		$tamano = $_POST["tamano"];
		$tiempo_limite = $_POST["tiempo_limite"];
		$tipo_movimiento = $_POST["tipo_movimiento"];
		$gh = $_POST["gh"];
		$zona = $_POST["zona"];
		$fecha_activacion_o_baja = $_POST["fecha_activacion_o_baja"];
		$ns_salida_lider = $_POST["ns_salida_lider"];
		$nombre_lider_salida = $_POST["nombre_lider_salida"];
		$fecha_salida = $_POST["fecha_salida"];
		$wk_salida = $_POST["wk_salida"];
		$fecha_entrega = $_POST["fecha_entrega"];
		$wk_entrega = $_POST["wk_entrega"];
		$fecha_servicio = $_POST["fecha_servicio"];
		$descripcion_problema = $_POST["descripcion_problema"];

		// new object
		$movimientos = new Zancos_movimientos();
		$movimientos->no_zanco = $no_zanco;
		//$movimientos->id_registro = $id_registro;
		$movimientos->tamano = $tamano;
		$movimientos->tiempo_limite = $tiempo_limite;
		$movimientos->tipo_movimiento = $tipo_movimiento;
		$movimientos->gh = $gh;
		$movimientos->zona = $zona;
		$movimientos->fecha_activacion_o_baja = $fecha_activacion_o_baja;
		$movimientos->ns_salida_lider = $ns_salida_lider;
		$movimientos->nombre_lider_salida = $nombre_lider_salida;
		$movimientos->fecha_salida = $fecha_salida;
		$movimientos->wk_salida = $wk_salida;
		$movimientos->fecha_entrega = $fecha_entrega;
		$movimientos->wk_entrega = $wk_entrega;
		$movimientos->fecha_servicio = $fecha_servicio;
		$movimientos->descripcion_problema = $descripcion_problema;
		$movimientos->save();
	}
}

redirect_to('indexZancos_movimientos.php');

?>