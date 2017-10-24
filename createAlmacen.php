<?php
//require_once $_SERVER["DOCUMENT_ROOT"].'/siscohistoraca2/__config.php';
require_once('includes/config.inc.php');
require_once('includes/inc.session.php');

$id = NULL;
$descripcion = NULL;
$cantidad_minima = NULL;
$cantidad_maxima = NULL;
$stock = NULL;
$unidad = NULL;
$precio_unitario = NULL;
$estatus = NULL;


/*echo "<pre>";
	print_r($_POST);

	//echo date("Y-m-d H:i:s", strtotime($_POST['fecha']) );
echo "</pre>";
die("He llegado");*/

if(isset($_POST["id"]) && intval($_POST["id"]) > 0)
{
	if ($_SERVER['REQUEST_METHOD'] == 'POST') 
	{

		// request data
		$id = $_POST["id"];
		$descripcion = $_POST["descripcion"];
		$cantidad_minima = $_POST["cantidad_minima"];
		$cantidad_maxima = $_POST["cantidad_maxima"];
		$stock = $_POST["stock"];
		$unidad = $_POST["unidad"];
		$precio_unitario = $_POST["precio_unitario"];
		$estatus = $_POST["estatus"];
		

		// new object
		$material = new Almacen_inventario();
		$material->id = $id;
		$material->descripcion = $descripcion;
		$material->cantidad_minima = $cantidad_minima;
		$material->cantidad_maxima = $cantidad_maxima;
		$material->stock = $stock;
		$material->unidad = $unidad;
		$material->precio_unitario = $precio_unitario;
		$material->estatus = $estatus;
		$material->save();
	}	
}
else
{
	if ($_SERVER['REQUEST_METHOD'] == 'POST') 
	{
		// request data
		//$id = $_POST["id"];
		$temp_con_tomate = $_POST['temp_con_tomate'];
		$hr_vacia = $_POST['hr_vacia'];
		$hr_con_tomate = $_POST['hr_con_tomate'];
		$temp_tomate_entrada = $_POST['temp_tomate_entrada'];
		$temp_tomate_salida = $_POST['temp_tomate_salida'];
		$temp_externa = $_POST['temp_externa'];
		$puerta_cerrada = $_POST['puerta_cerrada'];
		$lona_bien_ubicada = $_POST['lona_bien_ubicada'];
		$e_75_encendido = $_POST['e_75_encendido'];
		$fecha_medicion = date("Y-m-d H:i:s", strtotime($_POST['fecha']) );
		$num_tarimas = $_POST['num_tarimas'];
		$temp_vacia = $_POST['temp_vacia'];
		

		// new object
		$camara = new Mediciones_camara_fria();
		//$categoria->id = $id;
		$camara->temp_con_tomate = $temp_con_tomate;
		$camara->hr_vacia = $hr_vacia;
		$camara->hr_con_tomate = $hr_con_tomate;
		$camara->temp_tomate_entrada = $temp_tomate_entrada;
		$camara->temp_tomate_salida = $temp_tomate_salida;
		$camara->temp_externa = $temp_externa;
		$camara->puerta_cerrada = $puerta_cerrada;
		$camara->lona_bien_ubicada = $lona_bien_ubicada;
		$camara->e_75_encendido = $e_75_encendido;
		$camara->fecha_medicion = $fecha_medicion;
		$camara->num_tarimas = $num_tarimas;
		$camara->temp_vacia = $temp_vacia;
		$camara->save();
	}
}

redirect_to('indexAlmacen.php');

?>