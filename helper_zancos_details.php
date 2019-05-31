<?php
//require_once $_SERVER["DOCUMENT_ROOT"].'/siscohistoraca2/__config.php';
require_once('includes/config.inc.php');
require_once('includes/inc.session.php');

//$bloques = Bloques::getById($id);
//print_r($bloques);
$str="";
if(isset($_REQUEST['consulta']) && ($_SESSION["type"] == 9) ) // para zancos
{	
	//$mes = $_GET['mes'];
	$consulta = $_REQUEST['consulta'];
	
	if($consulta == "NUEVO")
	{
		echo "En construción...";
	}
	

	
}

else
{
	echo "NO REQUEST";
}


echo $str;


?>
