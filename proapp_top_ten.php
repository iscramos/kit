<?php 
    
    
    $familia_critica = array("ELECTRICA", "EMBARQUES", "FUMIGACION", "METROLOGIA", "REMOLQUES", "RIEGO", "TRACTORES");

    $arrays = array("orfanelr@naturesweet.com", "sbarajas@naturesweet.com", "lramos@naturesweet.com");

    function get_nombre_dia($fecha)
    {
      $fechats = strtotime($fecha); //pasamos a timestamp

      //el parametro w en la funcion date indica que queremos el dia de la semana
      //lo devuelve en numero 0 domingo, 1 lunes,....
      switch (date('w', $fechats))
      {
          case 0: return "DOMINGO"; break;
          case 1: return "LUNES"; break;
          case 2: return "MARTES"; break;
          case 3: return "MIERCOLES"; break;
          case 4: return "JUEVES"; break;
          case 5: return "VIERNES"; break;
          case 6: return "SABADO"; break;
      }
    }


    // para saber si ya se mandó correo de la semana anterior
    $fechaHoy = date("Y-m-d");
    $data_fechas = Disponibilidad_calendarios::getByDia($fechaHoy);

    $s = $data_fechas[0]->semana;
    $y = $data_fechas[0]->ano;

    $s_anterior = $s - 1;
    
    if($s == 1)
    {
      $_anterior = 52;
    }
    $days_min = Disponibilidad_calendarios::getMinDiaByAnoSemana($s_anterior, $y);
    $days_max = Disponibilidad_calendarios::getMaxDiaByAnoSemana($s_anterior, $y);

    $d_min = $days_min[0]->dia;
    $d_max = $days_max[0]->dia;

    $nombre_fecha_hoy = get_nombre_dia($fechaHoy);
    
    $correo_enviado = Correos_top::getByFechaEnvio($fechaHoy);

    //print_r($correo_enviado);

    // termina búsqueda de envío
//print_r($ots);

$HTML = "NO SEND";
if( ($correo_enviado->fecha_envio == "")  && ($nombre_fecha_hoy == "MARTES") )
{
  
      $HTML ='<!DOCTYPE html>';
    $HTML.='<html>';
    $HTML.='<head>';
      $HTML.='<title></title>';
    $HTML.='</head>';
    $HTML.='<body>';
    $HTML.= '<style type="text/css">';
    $HTML.='body{background: #EDEDED;}';
      $HTML.='.contiene{display: flex; justify-content: center; width: 100%;   height: 100%; padding: 0px;}';
      $HTML.='.principal{border: 1px solid rgba(221,221,221,.78); width: 60%; border-spacing: 0; border-collapse: collapse; font-family: "Helvetica Neue",Roboto,Arial,"Droid Sans",sans-serif;}'; 
      $HTML.='.header{background: #25733A; height: 100px; color: white; display: flex; justify-content: center; align-items: center;}';
      $HTML.='.principal img{ width: 80px; float: left; padding-top: 0px; padding-bottom: 10px; }';
      $HTML.='.principal tbody tr td{padding: 40px; background: white; }';

      $HTML.='.tablita{border: 1px solid rgba(221,221,221,.78);width: 100%;border-spacing: 0;border-collapse: collapse;}';
      $HTML.='.tablita thead{background: #405467;color: white;font-family: "Helvetica Neue",Roboto,Arial,"Droid Sans",sans-serif;font-size: 12px;}';
      $HTML.='.tablita thead tr{height: 30px;text-align: left;}';
      $HTML.='.tablita thead tr th{border: 1px solid #ddd;padding: 5px;}';
      $HTML.='.tablita tbody{font-family: "Helvetica Neue",Roboto,Arial,"Droid Sans",sans-serif;font-size: 11px;}';

      $HTML.='.tablita tbody tr{height: 20px;}';
      $HTML.='.tablita tbody tr td{border: 1px solid #ddd;padding: 5px;}';

      $HTML.='.fecha{text-align: right;}';

      $HTML.='.enlace{text-align: right; font-size: 12px;}';

    $HTML.='</style>';
      $HTML.='<div class="contiene">';    
        $HTML.='<table class="principal">';
          $HTML.='<thead>';
            $HTML.='<tr>';
              $HTML.='<th class="header">';
                $HTML.='<h2>TOP TEN DE EQUIPOS CRÍTICOS EN LA SEMANA ['.$s_anterior.'] POR FAMILIA</h2>';
                
              $HTML.='</th>';
            $HTML.='</tr>';
          $HTML.='</thead>';
          $HTML.='<tbody>';
            $HTML.='<tr>';
              $HTML.='<td>';
                  $HTML.='<img src="../../kit/dist/img/logo_2018_peque.png">';
                  $HTML.='<p class="fecha">';
                    $HTML.='<b>Fecha de envío: '.date("d-m-Y").'</b>';
                    
                  $HTML.='</p>';
                  $HTML.='<hr>';
                  foreach ($familia_critica as $fam) 
                  {
                    $HTML.='<br>';
                    $HTML.='<h2 style="text-align:center; color:red;">'.$fam.'</h2>';

                    $HTML.='<table class="tablita">';
                      $HTML.='<thead>';
                        $HTML.='<tr>';
                          
                          $HTML.='<th style="width: 10%;">EQUIPO</th>';
                          $HTML.='<th style="width: 55%;">DESCRIPCION</th>';
                          $HTML.='<th style="width: 5%;">FAILS</th>';
                          $HTML.='<th style="width: 30%;">PROBLEMA(S) ENCONTRADOS </th>';
                        $HTML.='</tr>';
                      $HTML.='</thead>';
                      $HTML.='<tbody>';

                      $q = "SELECT count(*) AS numero, disponibilidad_data.descripcion AS descripcion, disponibilidad_activos.descripcion AS descripcion_equipo, disponibilidad_data.equipo, disponibilidad_data.fecha_finalizacion_programada,
                             GROUP_CONCAT( DISTINCT disponibilidad_problemas.descripcion ORDER BY disponibilidad_problemas.descripcion SEPARATOR '<BR>  ') AS problemas

                            FROM disponibilidad_data
                            INNER JOIN disponibilidad_activos ON disponibilidad_data.equipo = disponibilidad_activos.activo
                            LEFT JOIN disponibilidad_problemas ON disponibilidad_data.codigo_problema = disponibilidad_problemas.problema
                            
                            WHERE disponibilidad_data.tipo <> 'Mant. preventivo'
                                AND disponibilidad_activos.criticidad = 'Alta'
                                AND disponibilidad_activos.familia = '$fam'
                                    
                                AND (disponibilidad_data.estado = 'Ejecutado'
                                    OR disponibilidad_data.estado = 'Programada'
                                    OR disponibilidad_data.estado = 'Abierta'
                                    OR disponibilidad_data.estado = 'Falta mano de obra'
                                    OR disponibilidad_data.estado = 'Espera de refacciones'
                                    OR disponibilidad_data.estado = 'Espera de equipo'
                                    OR disponibilidad_data.estado = 'Solic. de trabajo'
                                    OR disponibilidad_data.estado = 'Terminado' )
                                AND disponibilidad_data.fecha_finalizacion_programada BETWEEN '$d_min' AND '$d_max'
                                GROUP BY disponibilidad_data.equipo
                                ORDER BY numero DESC
                                LIMIT 10";
                                //echo $q;
                      $ots = Disponibilidad_data::getAllByQuery($q);

                            
                            $i = 0;
                            foreach ($ots as $ot) 
                            {
                              
                              

                              $HTML.='<tr>';
                                $HTML.='<td>'.$ot->equipo.'</td>';
                                $HTML.='<td>'.$ot->descripcion_equipo.'</td>';
                                $HTML.='<td style="color:red;">'.$ot->numero.'</td>';
                                $HTML.='<td>'.$ot->problemas.'</td>';
                              $HTML.='</tr>';

                              
                              $i++;
                            }
                            
                        
                      $HTML.='</tbody>';
                    $HTML.='</table> '; 
                  }
                    
              $HTML.='</td>';
            $HTML.='</tr> ';
            $HTML.='<tr>';
              $HTML.='<td>';
                $HTML.='<p class="enlace">Tambien puede consultar el siguiente <a href="http://192.168.167.231/kit/pbi.php" >enlace</a></p>';

              $HTML.='</td>';
            $HTML.='</tr> ';
          $HTML.='</tbody>';
        $HTML.='</table> '; 
      $HTML.='</div>';
  $HTML.='</body>';
  $HTML.='</html>';


  $correos_top = new Correos_top();
  $correos_top->fecha_envio = $fechaHoy;
  $correos_top->save();

  
}
 



ob_start();
echo $HTML;
$variableHTML = ob_get_clean();

    //print_r($años);
?>
  <style type="text/css">
   #calendar
   {
    padding: 10px;
   }
   .caption
   {
    background: white;
   }
   .x_panel
   {
      background: #F7F7F7;
   }
  </style>     
          