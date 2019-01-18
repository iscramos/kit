<?php
//require_once $_SERVER["DOCUMENT_ROOT"].'/siscohistoraca2/__config.php';
require_once('includes/config.inc.php');
//require_once('includes/inc.session.php');

/*$dia = date("Y-m-d");

$calendarios = Disponibilidad_calendarios::getByDia($dia);
$wk = $calendarios[0]->semana;
$ano = $calendarios[0]->ano;

$min_calendario = Disponibilidad_calendarios::getMinDiaByAnoSemana($wk, $ano);    
$max_calendario = Disponibilidad_calendarios::getMaxDiaByAnoSemana($wk, $ano);
$diaMin = $min_calendario[0]->dia;
$diaMax = $max_calendario[0]->dia;*/

if( isset($_REQUEST["mes"]) && isset($_REQUEST["ano"])  )
{
    $mes = $_REQUEST["mes"];
    $ano = $_REQUEST["ano"];

    
        
    $min_calendario = Disponibilidad_calendarios::getMinDiaByAnoMes($mes, $ano);    
    $max_calendario = Disponibilidad_calendarios::getMaxDiaByAnoMes($mes, $ano);
    $diaMin = $min_calendario[0]->dia;
    $diaMax = $max_calendario[0]->dia;

    $consulta = "SELECT bd_rebombeo.equipo, bd_rebombeo.m_consumidos, MAX(bd_rebombeo.fechaLectura) AS fechaLectura, equipos_rebombeo.latitud, equipos_rebombeo.longitud, disponibilidad_activos.descripcion 
                        FROM bd_rebombeo
                        INNER JOIN equipos_rebombeo ON bd_rebombeo.equipo = equipos_rebombeo.equipo
                        INNER JOIN disponibilidad_activos ON bd_rebombeo.equipo = disponibilidad_activos.activo
                        WHERE (bd_rebombeo.fechaLectura BETWEEN '$diaMin' AND '$diaMax')
                        AND bd_rebombeo.tipo = 3
                        AND equipos_rebombeo.latitud IS NOT NULL
                        AND equipos_rebombeo.longitud IS NOT NULL
                        GROUP BY bd_rebombeo.equipo
                        ORDER BY bd_rebombeo.fechaLectura DESC";
      

    //echo $consulta;

    $medidores = Bd_rebombeo::getAllByQuery($consulta);
    //print_r($ordenes);
    $contenedor[] = array();
        
    $i = 0;

    foreach ($medidores as $medidor) 
    {
        
        
        $descripcion = $medidor->descripcion;
        $latitud = $medidor->latitud;
        $longitud = $medidor->longitud;
        $m_consumidos = $medidor->m_consumidos * 10;
        $fechaLectura = date("d-m-Y H:i", strtotime($medidor->fechaLectura));


        $contentString = "<b>".$descripcion."</b><br>
                            <b style='color:orange;'>Última lectura: ".$fechaLectura."</b> <br>
                            <b style='color:blue;' > M<SUP>3</SUP> consumidos: ".$m_consumidos." </b>";

        $contenedor[$i] = array(
                                "descripcion"=>$descripcion,
                                "latitud"=>$latitud,
                                "longitud"=>$longitud,
                                "contentString"=>$contentString);
        $i++;
       
    } 
        
    

    //print_r($contenedor);
    echo json_encode($contenedor);
    /*echo "<pre>";
    print_r($contenedor);
    echo "</pre>";*/

    /*header('Content-type: application/json; charset=utf-8');
    echo json_encode($contenedor, JSON_FORCE_OBJECT);*/

    //Creamos el JSON
    //$json_string = json_encode($contenedor);
    /*$file = $content.'/monitoreo.json';
    file_put_contents($file, $json_string);*/
}
else
{
    redirect_to('index.php');
}


?>