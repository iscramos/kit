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

if( isset($_REQUEST["wk"]) && isset($_REQUEST["ano"]) && isset($_REQUEST["param"]) && isset($_REQUEST["adicional"]) )
{
    $wk = $_REQUEST["wk"];
    $ano = $_REQUEST["ano"];
    $param = $_REQUEST["param"];
    $adicional = $_REQUEST["adicional"];

    $consulta = "";
    if($param == 0)
    {
        if($adicional == 0)
        {
            $min_calendario = Disponibilidad_calendarios::getMinDiaByAnoSemana($wk, $ano);    
            $max_calendario = Disponibilidad_calendarios::getMaxDiaByAnoSemana($wk, $ano);
            $diaMin = $min_calendario[0]->dia;
            $diaMax = $max_calendario[0]->dia;
            $consulta = "SELECT * FROM disponibilidad_data
                        WHERE (fecha_inicio_programada BETWEEN '$diaMin' AND '$diaMax')
                            AND tipo <> 'Mant. preventivo'
                            AND latitud  <> ''
                            AND longitud <> ''
                            AND (estado <> 'Rechazado')
                            ORDER BY fecha_inicio_programada";
        }
        elseif($adicional == 1)
        {
            $min_calendario = Disponibilidad_calendarios::getMinDiaByAnoSemana($wk, $ano);    
            $max_calendario = Disponibilidad_calendarios::getMaxDiaByAnoSemana($wk, $ano);
            $diaMin = $min_calendario[0]->dia;
            $diaMax = $max_calendario[0]->dia;
            $consulta = "SELECT * FROM disponibilidad_data
                        WHERE (fecha_inicio_programada BETWEEN '$diaMin' AND '$diaMax')
                            AND tipo <> 'Mant. preventivo'
                            AND latitud  <> ''
                            AND longitud <> ''
                            AND (estado = 'Ejecutado'
                                OR estado = 'Terminado')
                            ORDER BY fecha_inicio_programada";
        }
        else
        {
            $min_calendario = Disponibilidad_calendarios::getMinDiaByAnoSemana($wk, $ano);    
            $max_calendario = Disponibilidad_calendarios::getMaxDiaByAnoSemana($wk, $ano);
            $diaMin = $min_calendario[0]->dia;
            $diaMax = $max_calendario[0]->dia;
            $consulta = "SELECT * FROM disponibilidad_data
                        WHERE (fecha_inicio_programada BETWEEN '$diaMin' AND '$diaMax')
                            AND tipo <> 'Mant. preventivo'
                            AND latitud  <> ''
                            AND longitud <> ''
                                AND (estado = 'Programada'
                                OR estado = 'Abierta'
                                OR estado = 'Solic. de trabajo')
                            ORDER BY fecha_inicio_programada";
        }
           
    }
    elseif ($param == 1) 
    {
        
        $min_calendario = Disponibilidad_calendarios::getMinDiaByAno($ano);    
        $max_calendario = Disponibilidad_calendarios::getMaxDiaByAno($ano);
        $diaMin = $min_calendario[0]->dia;
        $diaMax = $max_calendario[0]->dia;
        $consulta = "SELECT * FROM disponibilidad_data
                    WHERE (fecha_inicio_programada BETWEEN '$diaMin' AND '$diaMax')
                        AND tipo <> 'Mant. preventivo'
                        AND latitud  <> ''
                        AND longitud <> ''
                        AND (estado = 'Ejecutado'
                            OR estado = 'Terminado')
                        ORDER BY fecha_inicio_programada";
                        
    }
    else if($param == 2)
    {
        $min_calendario = Disponibilidad_calendarios::getMinDiaByAno($ano);    
        $max_calendario = Disponibilidad_calendarios::getMaxDiaByAno($ano);
        $diaMin = $min_calendario[0]->dia;
        $diaMax = $max_calendario[0]->dia;
        $consulta = "SELECT * FROM disponibilidad_data
                    WHERE (fecha_inicio_programada BETWEEN '$diaMin' AND '$diaMax')
                        AND tipo <> 'Mant. preventivo'
                        AND latitud  <> ''
                        AND longitud <> ''
                            AND (estado = 'Programada'
                            OR estado = 'Abierta'
                            OR estado = 'Solic. de trabajo')
                        ORDER BY fecha_inicio_programada";
    }
    else
    {
        $min_calendario = Disponibilidad_calendarios::getMinDiaByAno($ano);    
        $max_calendario = Disponibilidad_calendarios::getMaxDiaByAno($ano);
        $diaMin = $min_calendario[0]->dia;
        $diaMax = $max_calendario[0]->dia;
        $consulta = "SELECT * FROM disponibilidad_data
                    WHERE (fecha_inicio_programada BETWEEN '$diaMin' AND '$diaMax')
                        AND latitud  <> ''
                        AND longitud <> ''
                            AND (estado <> 'Rechazado')
                        ORDER BY fecha_inicio_programada"; 
    }

    

    $ordenes = Disponibilidad_data::getAllByQuery($consulta);
    //print_r($ordenes);
    $contenedor[] = array();
        
    $i = 0;

    foreach ($ordenes as $fugas) 
    {
        $orden_trabajo = $fugas->ot;
        $descripcion = $fugas->descripcion;
        $equipo = $fugas->equipo;
        $estado = $fugas->estado;
        $latitud = $fugas->latitud;
        $longitud = $fugas->longitud;
        $fecha_inicio_programada = date("d-m-Y", strtotime($fugas->fecha_inicio_programada));
        $fecha_finalizacion_programada = date("d-m-Y", strtotime($fugas->fecha_finalizacion_programada));


        $contentString = "<b>OT: </b>".$orden_trabajo." <br> "." <b>Equipo: </b>".$equipo." <br> <b>Problema:</b> ".$descripcion." <br> <b>Para el:</b> ".$fecha_finalizacion_programada." <br> <b>Hasta el:</b> ".$fecha_finalizacion_programada;

        $contenedor[$i] = array( 
                                "orden_trabajo"=>$orden_trabajo,
                                "descripcion"=>$descripcion,
                                "equipo"=>$equipo,
                                "estado"=>$estado,
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