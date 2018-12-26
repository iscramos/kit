<?php
//require_once $_SERVER["DOCUMENT_ROOT"].'/siscohistoraca2/__config.php';
require_once('includes/config.inc.php');
require_once('includes/inc.session.php');

//$bloques = Bloques::getById($id);
//print_r($bloques);
$str="";
if(isset($_REQUEST['consulta']) && ($_SESSION["type"] == 1 || $_SESSION["type"] == 5 || $_SESSION["type"] == 8)) // para el admimistrador
{	
	//$mes = $_GET['mes'];
	$consulta = $_REQUEST['consulta'];
	if($consulta == "ZONA")
	{
		$lider = $_REQUEST['lider'];
		$q = "SELECT * FROM recursos_asociados 
						WHERE lider = $lider LIMIT 1";

		$zonas = Recursos_asociados::getAllByQuery($q);
    	if(count($zonas) > 0)
    	{
			$str.=$zonas[0]->zona."&";
    	}
    	else
    	{
    		$str.="";
    	}
		
	}
	elseif($consulta == "ASOCIADO")
	{
		$codigo = $_REQUEST['codigo'];
		$q = "SELECT * FROM recursos_asociados 
						WHERE codigo = $codigo LIMIT 1";

		$asociados = Recursos_asociados::getAllByQuery($q);
    	if(count($asociados) > 0)
    	{
			$str.=$asociados[0]->nombre."&".$asociados[0]->lider."&".$asociados[0]->zona;
    	}
    	else
    	{
    		$str.="*NO ENCONTRADO*";
    	}
    	
	}
	elseif($consulta == "SEMANA")
	{
		$fecha = $_REQUEST['fecha'];
		

		$semanitas = Disponibilidad_calendarios::getByDia($fecha);
    	if(count($semanitas) > 0)
    	{
			$str.=$semanitas[0]->semana."&";
    	}
    	else
    	{
    		$str.="*NO ENCONTRADO*";
    	}
    	
	}
	elseif($consulta == "ACTIVIDAD")
	{
		$id_actividad = $_REQUEST['id_actividad'];
		$q = "SELECT * FROM recursos_actividades 
						WHERE id_actividad = $id_actividad LIMIT 1";


		$actividad = Recursos_actividades::getAllByQuery($q);

    	if(count($actividad) > 0)
    	{
			$str.=$actividad[0]->nombre."&".$actividad[0]->tipo_pago."&".$actividad[0]->objetivo."&".$actividad[0]->pago_surco;
    	}
    	else
    	{
    		$str.="*NO ENCONTRADO*";
    	}
    	
	}
	elseif($consulta == "INVERNADERO")
	{
		$invernadero = $_REQUEST['invernadero'];
		$q = "SELECT * FROM recursos_invernaderos
					WHERE invernadero = '$invernadero'  LIMIT 1";

		
		$gh = Recursos_Invernaderos::getAllByQuery($q);

    	if(count($gh) > 0)
    	{
			$str.=$gh[0]->surco_real."&";
    	}
    	else
    	{
    		$str.="*NO ENCONTRADO*";
    	}
    	
	}
	

	
}

else
{
	echo "NO REQUEST";
}


echo $str;


?>
