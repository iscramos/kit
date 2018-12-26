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
    $consulta = "SELECT * FROM disponibilidad_data
                    WHERE tipo <> 'Mant. preventivo'
                    AND equipo = '$equipo'
                    AND (estado = 'Ejecutado'
                        
                            OR estado = 'Programada'
                            OR estado = 'Abierta'
                            OR estado = 'Falta mano de obra'
                            OR estado = 'Espera de refacciones'
                            OR estado = 'Espera de equipo' )
                        ORDER BY fecha_inicio_programada ASC";

                        //print_r($consulta);

    $ordenes = Disponibilidad_data::getAllByQuery($consulta); // Para las ordenes no 
    
    $activos = Disponibilidad_activos::getAllByEquipo($equipo);
    //print_r($activos);
    
    $str = "<p><b>Equipo: </b>".$activos[0]->activo." (".$activos[0]->descripcion.")</p>";
    $str.="<table class='table table-bordered jambo_table bulk_action' style='font-size:12px; !important;'>";
                    $str.="<thead >";
                        $str.="<tr >";
                            $str.="<th>ORDEN</th> <th>DESCRIPCION</th> <th>HASTA</th> <th>ESTADO</th>";
                        $str.="</tr>";
                    $str.="</thead>";
                    $str.="<tbody>";
    foreach ($ordenes as $orden) 
    {       
        $str.="<tr>";
            $str.="<td>".$orden->ot."</td> 
                    <td>".$orden->descripcion."</td> 
                    <td>".date("d-M-Y", strtotime($orden->fecha_finalizacion_programada))."</td>
                    <td>".$orden->estado."</td> ";
        $str.="</tr>";
        
          
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