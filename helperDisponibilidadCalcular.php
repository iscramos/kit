<?php
//require_once $_SERVER["DOCUMENT_ROOT"].'/siscohistoraca2/__config.php';
require_once('includes/config.inc.php');
require_once('includes/inc.session.php');

//$bloques = Bloques::getById($id);
//print_r($bloques);
$str="";
if(isset($_GET['parametro']) && ($_SESSION["type"]==1 )) // para el admimistrador
{   
    $ano = $_GET['ano'];
    
    function getMinutes($fecha1, $fecha2)
    {
        $fecha1 = str_replace('/', '-', $fecha1);
        $fecha2 = str_replace('/', '-', $fecha2);
        $fecha1 = strtotime($fecha1);
        $fecha2 = strtotime($fecha2);
        return round( (($fecha2 - $fecha1) / 60) / 60, 1); //convirtiendo a horas
    }

    function nombreMes($mes)
    {
        switch ($mes) 
        {
        case 1:
            $mes = "ENERO";
            break;
        case 2:
            $mes = "FEBRERO";
            break;
        case 3:
            $mes = "MARZO";
            break;
        case 4:
            $mes = "ABRIL";
            break;
        case 5:
            $mes = "MAYO";
            break;
        case 6:
            $mes = "JUNIO";
            break;
        case 7:
            $mes = "JULIO";
            break;
        case 8:
            $mes = "AGOSTO";
            break;
        case 9:
            $mes = "SEPTIEMBRE";
            break;
        case 10:
            $mes = "OCTUBRE";
            break;
        case 11:
            $mes = "NOVIEMBRE";
            break;
        case 12:
            $mes = "DICIEMBRE";
            break;
        }

        return $mes;
        
    }


    $parametro = $_GET['parametro'];
 
    if($parametro == "DISPONIBILIDADGENERAL") // PARA LA DISPONIBILIDAD GENERAL DE TODO EL AÑO
    {
        
        // INICIANDO EL CALCULO DEL AÑO
        $str.="<table class='tablita table table-bordered'>";
            $str.="<thead>";
                
                $str.="<tr>";
                    $str.="<th>ORG</th>";
                    $str.="<th>AÑO</th>";
                    $str.="<th>MES</th>";
                    $str.="<th>SEMANA</th>";
                    $str.="<th>ACTIVO</th>";
                    $str.="<th>DESCRIPCION</th>";
                    $str.="<th>FAMILIA</th>";
                    $str.="<th>VIRTUAL FAILS</th>";
                    $str.="<th>MP NUM</th>";
                    $str.="<th>MC FAILS</th>";
                    $str.="<th>TOTAL FAILS</th>";
                    $str.="<th>REAL TIME OPERATION</th>";
                    $str.="<th>IDEAL TOTAL TIME MP</th>";
                    $str.="<th>EXTRA TIME MP</th>";
                    $str.="<th>TIME TO REPAIR</th>";
                    $str.="<th>TOTAL TIME TO REPAIR</th>";
                    $str.="<th>ORG</th>";
                    $str.="<th>MTTR</th>";
                    $str.="<th>MTBF</th>";
                    $str.="<th>DISPONIBILITY</th>";
                    $str.="<th>FACTOR DE FIABILIDAD</th>";
                $str.="</th>";
            $str.="</thead>";
        

            $str.="<tbody>";
                $disponibilidad_plantas = Disponibilidad_plantas::getAllByOrden("organizacion", "asc");
                foreach ($disponibilidad_plantas as $p) 
                {
                    $disponibilidad_meses = Disponibilidad_meses::getAllByOrden("mes", "asc");

                    foreach ($disponibilidad_meses as $m) 
                    {
                        $query =  "SELECT * FROM disponibilidad_calendarios
                                                WHERE ano = $ano AND mes = $m->mes
                                                GROUP BY semana
                                                ORDER BY semana ASC";
                        $disponibilidad_semanas = Disponibilidad_calendarios::getAllByQuery($query);
                        

                        foreach ($disponibilidad_semanas as $s)
                        {
                            $consulta_dia_inicio = Disponibilidad_calendarios::getMinDiaByAnoSemana($s->semana, $ano);
                            $dia_inicio = $consulta_dia_inicio[0]->dia;

                            $consulta_dia_fin = Disponibilidad_calendarios::getMaxDiaByAnoSemana($s->semana, $ano);
                            $dia_fin = $consulta_dia_fin[0]->dia;

                            $query2 =  "SELECT * FROM disponibilidad_activos
                                                WHERE organizacion = '$p->organizacion' AND criticidad = 'Alta'
                                                ORDER BY activo ASC";
                
                            $disponibilidad_activos_criticos = Disponibilidad_activos::getAllByQuery($query2);
                            
                            foreach ($disponibilidad_activos_criticos as $activo_critico) 
                            {
                                $virtual_fails = 0;
                                $mp_num = 0;
                                $mc_fails = 0;
                                $total_fails = 0;

                                $str.="<tr>";
                                    $str.="<td>".$p->organizacion."</td>";
                                    $str.="<td>".$ano."</td>";
                                    $str.="<td>".$m->mes."</td>";
                                    $str.="<td>".$s->semana."</td>";
                                    $str.="<td>".$activo_critico->activo."</td>";
                                    $str.="<td>".$activo_critico->descripcion."</td>";
                                    $str.="<td>".$activo_critico->familia."</td>";



                                    $query3 = "SELECT * FROM disponibilidad_data 
                                                    WHERE equipo = '$activo_critico->activo' 
                                                    AND tipo = 'Mant. preventivo'
                                                    AND (fecha_inicio_programada BETWEEN '$dia_inicio' AND '$dia_fin')";
                                    $disponibilidad_data_mp = Disponibilidad_data::getAllByQuery($query3);

                                    
                                    
                                    foreach ($disponibilidad_data_mp as $d) 
                                    {
                                        $codigo_mp = $d->codigo; // sacamos el codigo para el tiempo estimado del mp
                                        $te_mp = 0;
                                        $fechaHoy = null;
                                        $fechaHoy = date("Y-m-d H:i:s");

                                        $te_fecha_inicio_programada = $d->fecha_inicio_programada;
                                        $te_fecha_inicio = $d->fecha_inicio;
                                        $te_fecha_finalizacion = $d->fecha_finalizacion;

                                        if($te_fecha_inicio != "" && $te_fecha_finalizacion != "")
                                        {
                                            $te_mp = getMinutes($te_fecha_inicio, $te_fecha_finalizacion);
                                        }
                                        else
                                        {
                                            $te_mp = getMinutes($te_fecha_finalizacion, $fechaHoy);
                                        }

                                        /*echo "<b>CODIGO DE MP: </b>".$codigo_mp."<br>";
                                        echo "<b>Fecha de inicio programada: </b>".$te_fecha_inicio_programada."<br>";
                                        echo "<b>Fecha de inicio: </b>".$te_fecha_inicio."<br>";
                                        echo "<b>Fecha de finalizacion: </b>".$te_fecha_finalizacion."<br>";


                                        echo "<b>TIEMPO ESTIMADO OT: </b>".$te_mp."<br>";*/

                                       
                                        if($codigo_mp != "")
                                        {
                                            $disponibilidad_tiempos = Disponibilidad_tiempos::getByCodigo($codigo_mp);
                                            $temporal_te = $disponibilidad_tiempos->te;

                                            //echo "<b>TE PROGRAMACION: </b>". $temporal_te;
                                            if($te_mp > $temporal_te)
                                            {
                                                $virtual_fails ++;
                                            }
                                            //die("Hasta aquí");
                                        }


                                        $mp_num ++; // para contar el numero mp de un equipo en la semana
                                        
                                    }

                                    // EMPIEZA LA DATA CORRECTIVA
                                    $query4 = "SELECT * FROM disponibilidad_data 
                                                    WHERE equipo = '$activo_critico->activo' 
                                                    AND tipo <> 'Mant. preventivo'
                                                    AND (fecha_inicio_programada BETWEEN '$dia_inicio' AND '$dia_fin')";

                                    $disponibilidad_data_mc = Disponibilidad_data::getAllByQuery($query4);

                                    //$mc_fails = count($disponibilidad_data_mc);
                                    /*foreach ($disponibilidad_data_mc as $mc) 
                                    {
                                    
                                        $mc_fails ++; // para contar el numero mc de un equipo en la semana
                                        
                                    }*/

                                    $total_fails = $virtual_fails + $mc_fails; // sumando las fallas mp + mc

                                    $str.="<td>".$virtual_fails."</td>";
                                    $str.="<td>".$mp_num."</td>";
                                    $str.="<td>".$mc_fails."</td>";
                                    $str.="<td>".$total_fails."</td>";
                                $str.="</tr>";
                            }
                            
                        }
                    }
                }
                
         
        $str.="</tbody>
            </table>";
        


    }
}
else
{
    $str.="NO DATA";
}


echo $str;


?>
<style type="text/css">
.tablita
{
    font-size: 10px !important;
}
</style>
<!-- jQuery -->
    <script src="<?php echo $url; ?>vendor/jquery/jquery.js"></script>
    <!-- DataTables JavaScript -->
    <!--script src="<?php echo $url; ?>vendor/datatables/js/jquery.dataTables.min.js"></script>
    <script src="<?php echo $url; ?>vendor/datatables-plugins/dataTables.bootstrap.min.js"></script>
    <script src="<?php echo $url; ?>vendor/datatables-responsive/dataTables.responsive.js"></script-->

       <!-- Flot Charts JavaScript -->
   
    <!--script src="<?php echo $url; ?>dist/js/jsapi.js"></script-->

<script type="text/javascript">




</script>



