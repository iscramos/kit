<?php 

// Initialize site configuration
require_once('includes/config.inc.php');
require_once('includes/inc.session.php');
//require_once("lib/login.php");

// Get posts from database
//echo $_SESSION["school"];

if($_SESSION["type"] == 5)
{
	$codigo = $_REQUEST["codigo"];
	
    $direccion0 = "http://192.168.167.231/proapp/ws/?asociado=".$codigo;
    $json_asociado = file_get_contents($direccion0);
    $asociadoData = json_decode($json_asociado, true);

	$a_nombre = null;
    $a_departamento = null;
    $a_puesto = null;
    $a_estatus = null;
    $a_lider = null;
    $a_codigo = null;
    $a_imagen = null;

    if(count($asociadoData) > 0)
    {
    	$a_nombre = $asociadoData[0]['nombre'];
        $a_departamento = "DEPARTAMENTO: <b>".$asociadoData[0]['departamento']."</b>";
        $a_puesto = $asociadoData[0]['puesto'];
        $a_estatus = " (<b>".$asociadoData[0]['status']."</b>)";
        $a_lider = "LIDER: <b>".$asociadoData[0]['lider']."</b>";
        $a_codigo = "<b style='color: red;'>".$asociadoData[0]['codigo']."</b> ";

        $a_imagen = "../col2/ch/perfils/".$asociadoData[0]['codigo'];
        if (!file_exists($a_imagen)) 
        {
            $a_imagen = "dist/img/avatar.jpg";
        } 

        
    }
    
    $q = "SELECT herramientas_temporal.*, herramientas_herramientas.descripcion AS descripcion
                FROM herramientas_temporal
                    INNER JOIN herramientas_herramientas ON herramientas_temporal.clave = herramientas_herramientas.clave
                        WHERE Herramientas_temporal.codigo_asociado = $codigo";    

    $temporales = Herramientas_temporal::getAllByQuery($q);
    //echo $q;
    //print_r($temporales);
	// Include page view
	require_once(VIEW_PATH.'indexHerramientas_temporal.view.php');	
}
else
{
	// Include page view
	redirect_to('index.php');
}