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
		$no_zanco = $_REQUEST['no_zanco'];
		$q = "SELECT zancos_bd.*, zancos_tamanos.tamano as tamano_descripcion, zancos_tamanos.limite_semana as limite_semana 
				FROM zancos_bd
				INNER JOIN zancos_tamanos ON zancos_bd.tamano = zancos_tamanos.id
				WHERE zancos_bd.no_zanco = $no_zanco";

		$bd = Zancos_bd::getAllByQuery($q);

    	if(count($bd) > 0)
    	{
    		$str.=$bd[0]->tamano."&".$bd[0]->tamano_descripcion."&".$bd[0]->limite_semana;
    	}
    	else
    	{
    		$str.="*NO ENCONTRADO*";
    	}
		
	}
	elseif($consulta == "ASOCIADO")
	{
		/*$codigo = $_REQUEST['codigo'];

		$datos = Zancos_lideres::getByNs($codigo);
		
    	if($datos->ns > 0)
    	{
			$str.=$datos->nombre;
    	}
    	else
    	{
    		$str.="*NO ENCONTRADO*";
    	}*/
    	$asociado = $_REQUEST["codigo"];

	    $direccion0 = "http://192.168.167.231/proapp/ws/?asociado=".$asociado;
	    $json_asociado = file_get_contents($direccion0);
	    $asociadoData = json_decode($json_asociado, true);

	    if(count($asociadoData) > 0)
	    {
	        echo $asociadoData[0]['codigo']."&".$asociadoData[0]['nombre']."&".$asociadoData[0]['departamento']."&".$asociadoData[0]['puesto']."&".$asociadoData[0]['lider']."&".$asociadoData[0]['status'];
	    }
	    else
	    {
	      echo "*NO ENCONTRADO*";
	    }
    	
	}
	elseif ($consulta == "WK") 
	{
		$fecha = $_REQUEST['fecha'];

		$datos = Disponibilidad_calendarios::getByDia($fecha);
		
    	if($datos[0]->semana > 0)
    	{
			$str.=$datos[0]->semana;
    	}
    	else
    	{
    		$str.="*NO ENCONTRADO*";
    	}
	}
	elseif ($consulta == "EXISTE_ZANCO") 
	{
		$no_zanco = $_REQUEST['no_zanco'];

		$datos = Zancos_bd::buscaZanco($no_zanco);

		if(isset($datos[0]))
  		{
  			$str.="SI";
  		}
  		else
  		{
  			$str.="NO";
  		}
	}

	
}

else
{
	echo "NO REQUEST";
}


echo $str;


?>
