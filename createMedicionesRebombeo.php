<?php
//require_once $_SERVER["DOCUMENT_ROOT"].'/siscohistoraca2/__config.php';
require_once('includes/config.inc.php');
require_once('includes/inc.session.php');

$id = NULL;
$equipo = NULL;
$tipo = NULL;
$fechaLectura = NULL;
$voltaje_l1_l2 = NULL;
$voltaje_l2_l3 = NULL;
$voltaje_l1_l3 = NULL;
$amperaje_l1 = NULL;
$amperaje_l2 = NULL;
$amperaje_l3 = NULL;
$caudal = NULL;
$nivel_estatico = NULL;
$nivel_dinamico = NULL;
$hp = NULL;
$volt_nomi_bajo = NULL;
$volt_nomi_alto = NULL;
$amp_max = NULL;
$amp_min = NULL;
$m_consumidos = NULL;
$reinicio = NULL;
$comentarios = NULL;
//echo date("Y-m-d H:i", $_POST["fechaLectura"]);
/*echo strftime("%Y-%m-%d %H:%M", strtotime($_POST["fechaLectura"]));
echo "<pre>";
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
		//$equipo = $_POST["equipo"];
		//$fechaLectura = $_POST["fechaLectura"];
		$voltaje_l1_l2 = $_POST["voltaje_l1_l2"];
		$voltaje_l2_l3 = $_POST["voltaje_l2_l3"];
		$voltaje_l1_l3 = $_POST["voltaje_l1_l3"];
		$amperaje_l1 = $_POST["amperaje_l1"];
		$amperaje_l2 = $_POST["amperaje_l2"];
		$amperaje_l3 = $_POST["amperaje_l3"];
		$caudal = $_POST["caudal"];
		$nivel_estatico = $_POST["nivel_estatico"];
		$nivel_dinamico = $_POST["nivel_dinamico"];
		$hp = $_POST["hp"];
		$volt_nomi_bajo = $_POST["volt_nomi_bajo"];
		$volt_nomi_alto = $_POST["volt_nomi_alto"];
		$amp_max = $_POST["amp_max"];
		$amp_min = $_POST["amp_min"];
		$m_consumidos = $_POST["m_consumidos"];
		if (isset($_POST['reinicio'])) 
		{
			$reinicio = 1;
		}
		else
		{
			$reinicio = 0;
		}
		$comentarios = $_POST["comentarios"];
		

		// new object
		$rebombeo = new Bd_rebombeo();
		$rebombeo->id = $id;
		//$rebombeo->equipo = $equipo;
		//$rebombeo->fechaLectura = $fechaLectura;
		$rebombeo->voltaje_l1_l2 = $voltaje_l1_l2;
		$rebombeo->voltaje_l2_l3 = $voltaje_l2_l3;
		$rebombeo->voltaje_l1_l3 = $voltaje_l1_l3;
		$rebombeo->amperaje_l1 = $amperaje_l1;
		$rebombeo->amperaje_l2 = $amperaje_l2;
		$rebombeo->amperaje_l3 = $amperaje_l3;
		$rebombeo->caudal = $caudal;
		$rebombeo->nivel_estatico = $nivel_estatico;
		$rebombeo->nivel_dinamico = $nivel_dinamico;
		$rebombeo->hp = $hp;
		$rebombeo->volt_nomi_bajo = $volt_nomi_bajo;
		$rebombeo->volt_nomi_alto = $volt_nomi_alto;
		$rebombeo->amp_max = $amp_max;
		$rebombeo->amp_min = $amp_min;
		$rebombeo->m_consumidos = $m_consumidos;
		$rebombeo->reinicio = $reinicio;
		$rebombeo->comentarios = $comentarios;
		$rebombeo->save();
	}	
}
else
{
	if ($_SERVER['REQUEST_METHOD'] == 'POST') 
	{
		// request data
		//$id = $_POST["id"];
		$equipo = $_POST["equipo"];
		$tipo = $_POST["tipo"];
		$fechaLectura = date("Y-m-d H:i", strtotime($_POST["fechaLectura"]));
		$voltaje_l1_l2 = $_POST["voltaje_l1_l2"];
		$voltaje_l2_l3 = $_POST["voltaje_l2_l3"];
		$voltaje_l1_l3 = $_POST["voltaje_l1_l3"];
		$amperaje_l1 = $_POST["amperaje_l1"];
		$amperaje_l2 = $_POST["amperaje_l2"];
		$amperaje_l3 = $_POST["amperaje_l3"];
		$caudal = $_POST["caudal"];
		$nivel_estatico = $_POST["nivel_estatico"];
		$nivel_dinamico = $_POST["nivel_dinamico"];
		$hp = $_POST["hp"];
		$volt_nomi_bajo = $_POST["volt_nomi_bajo"];
		$volt_nomi_alto = $_POST["volt_nomi_alto"];
		$amp_max = $_POST["amp_max"];
		$amp_min = $_POST["amp_min"];
		$m_consumidos = $_POST["m_consumidos"];
		if (isset($_POST['reinicio'])) 
		{
			$reinicio = 1;
		}
		else
		{
			$reinicio = 0;
		}
		$comentarios = $_POST["comentarios"];
		

		// new object
		$rebombeo = new Bd_rebombeo();
		//$categoria->id = $id;
		$rebombeo->equipo = $equipo;
		$rebombeo->tipo = $tipo;
		$rebombeo->fechaLectura = $fechaLectura;
		$rebombeo->voltaje_l1_l2 = $voltaje_l1_l2;
		$rebombeo->voltaje_l2_l3 = $voltaje_l2_l3;
		$rebombeo->voltaje_l1_l3 = $voltaje_l1_l3;
		$rebombeo->amperaje_l1 = $amperaje_l1;
		$rebombeo->amperaje_l2 = $amperaje_l2;
		$rebombeo->amperaje_l3 = $amperaje_l3;
		$rebombeo->caudal = $caudal;
		$rebombeo->nivel_estatico = $nivel_estatico;
		$rebombeo->nivel_dinamico = $nivel_dinamico;
		$rebombeo->hp = $hp;
		$rebombeo->volt_nomi_bajo = $volt_nomi_bajo;
		$rebombeo->volt_nomi_alto = $volt_nomi_alto;
		$rebombeo->amp_max = $amp_max;
		$rebombeo->amp_min = $amp_min;
		$rebombeo->m_consumidos = $m_consumidos;
		$rebombeo->reinicio = $reinicio;
		$rebombeo->comentarios = $comentarios;
		$rebombeo->save();
	}
}

redirect_to('indexMedicionesRebombeo.php');

?>