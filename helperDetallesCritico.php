<?php
//require_once $_SERVER["DOCUMENT_ROOT"].'/siscohistoraca2/__config.php';
require_once('includes/config.inc.php');
require_once('includes/inc.session.php');



//$bloques = Bloques::getById($id);
//print_r($bloques);
$str = "";
if( isset($_REQUEST["equipo"]) ) 
{
	$equipo = $_REQUEST["equipo"];
    $direccion = $url.$content."/monitoreo.json";
    $json_ordenes = file_get_contents($direccion);
    $ordenes = json_decode($json_ordenes, true);
    $descripcion = "";
    
    $activos = Activos_equipos::getByEamActivo($equipo);
    foreach ($activos as $activo) 
    {
        $descripcion = $activo->descripcion;
    }
    
    $str = "<p><b>Equipo: </b>".$equipo." (".$descripcion.")</p>";
    $str.="<table class='table table-bordered jambo_table bulk_action' style='font-size:12px; !important;'>";
                    $str.="<thead >";
                        $str.="<tr >";
                            $str.="<th>ORDEN</th> <th>DESCRIPCION</th> <th>HASTA</th> <th>ESTADO</th>";
                        $str.="</tr>";
                    $str.="</thead>";
                    $str.="<tbody>";
    foreach ($ordenes as $orden) 
    {
        
        if($orden["equipo"] == $equipo)
        {
            if($orden["estado"] != "Terminado" && ($orden["tipo"] == "Correctivo planeado" || $orden["tipo"] == "Correctivo de emergencia") )
            {
                
                        $str.="<tr>";
                            $str.="<td>".$orden["orden_trabajo"]."</td> 
                                    <td>".$orden["descripcion"]."</td> 
                                    <td>".date("d-M-Y", strtotime($orden["fecha_finalizacion_programada"]))."</td>
                                    <td>".$orden["estado"]."</td> ";
                        $str.="</tr>";
                    
            }

            
        }
          
    }

    $str.="</tbody>";
                $str.="</table>";
	
    
}
else
{
	$str.="NO DATA";
}


echo $str;
?>