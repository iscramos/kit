<?php 

    $arrays_zancos = array("lramos@naturesweet.com");
    
    


    // para saber si ya se mandó correo de la semana anterior
   

    //$nombre_fecha_hoy = get_nombre_dia($fechaHoy);
    //$nombre_fecha_hoy = "MARTES";
    $correo_enviado_zancos = Correos_zancos::getByFechaEnvio($fechaHoy);

    //print_r($correo_enviado);

    // termina búsqueda de envío
//print_r($ots);

if( ($correo_enviado_zancos->fecha_envio == "")  && ($nombre_fecha_hoy == "MARTES") )
{
    $consulta = "SELECT m.*, zancos_tamanos.tamano AS tamano_descripcion

        FROM zancos_movimientos m
        INNER JOIN
        (
            SELECT max(id_registro) reg, no_zanco
            FROM zancos_movimientos
            GROUP BY no_zanco
        ) m2
          ON m.no_zanco = m2.no_zanco
          INNER JOIN zancos_tamanos ON m.tamano = zancos_tamanos.id
          AND m.id_registro = m2.reg
          AND m.tipo_movimiento = 3
          AND m.fecha_entrega = 0
          AND (DATEDIFF('$fechaHoy', m.fecha_salida) ) > (m.tiempo_limite * 7)";

    $zancos_desfase = Zancos_bd::getAllByQuery($consulta);
    $zancos_tamanos = Zancos_tamanos::getAllByOrden("id", "ASC");

    $consulta = "SELECT * FROM zancos_ghs GROUP BY zona ORDER BY zona ASC";
    $zancos_zonas = Zancos_ghs::getAllByQuery($consulta);
    //print_r($zancos_desfase);
  
      $HTML_ZANCOS ='<!DOCTYPE html>';
    $HTML_ZANCOS.='<html>';
    $HTML_ZANCOS.='<head>';
      $HTML_ZANCOS.='<title></title>';
    $HTML_ZANCOS.='</head>';
    $HTML_ZANCOS.='<body>';
    $HTML_ZANCOS.= '<style type="text/css">';
    $HTML_ZANCOS.='body{background: #EDEDED;}';
      $HTML_ZANCOS.='.contiene{display: flex; justify-content: center; width: 100%;   height: 100%; padding: 0px;}';
      $HTML_ZANCOS.='.principal{border: 1px solid rgba(221,221,221,.78); width: 60%; border-spacing: 0; border-collapse: collapse; font-family: "Helvetica Neue",Roboto,Arial,"Droid Sans",sans-serif;}'; 
      $HTML_ZANCOS.='.header{background: #25733A; height: 100px; color: white; display: flex; justify-content: center; align-items: center;}';
      $HTML_ZANCOS.='.principal img{ width: 80px; float: left; padding-top: 0px; padding-bottom: 10px; }';
      $HTML_ZANCOS.='.principal tbody tr td{padding: 10px; background: white; }';

      $HTML_ZANCOS.='.tablita{border: 1px solid red;width: 100%;border-spacing: 0;border-collapse: collapse;}';
      $HTML_ZANCOS.='.tablita thead{background: #405467;color: white;font-family: "Helvetica Neue",Roboto,Arial,"Droid Sans",sans-serif;font-size: 12px;}';
      $HTML_ZANCOS.='.tablita thead tr{height: 30px;text-align: left;}';
      $HTML_ZANCOS.='.tablita thead tr th{border: 1px solid #ddd;padding: 5px;}';
      $HTML_ZANCOS.='.tablita tbody{font-family: "Helvetica Neue",Roboto,Arial,"Droid Sans",sans-serif;font-size: 11px;}';

      $HTML_ZANCOS.='.tablita tbody tr{height: 5px;}';
      $HTML_ZANCOS.='.tablita tbody tr td{border: 1px solid #ddd;padding: 5px;}';

      $HTML_ZANCOS.='.fecha{text-align: right;}';

      $HTML_ZANCOS.='.enlace{text-align: right; font-size: 12px;}';

    $HTML_ZANCOS.='</style>';
      $HTML_ZANCOS.='<div class="contiene">';    
        $HTML_ZANCOS.='<table class="principal">';
          $HTML_ZANCOS.='<thead>';
            $HTML_ZANCOS.='<tr>';
              $HTML_ZANCOS.='<th class="header">';
                $HTML_ZANCOS.='<h2>ZANCOS DESFASADOS HASTA LA SEMANA ['.$s_anterior.']</h2>';
                
              $HTML_ZANCOS.='</th>';
            $HTML_ZANCOS.='</tr>';
          $HTML_ZANCOS.='</thead>';
          $HTML_ZANCOS.='<tbody>';
            $HTML_ZANCOS.='<tr>';
              $HTML_ZANCOS.='<td>';
                  $HTML_ZANCOS.='<img src="../../kit/dist/img/logo_2018_peque.png">';
                  $HTML_ZANCOS.='<p class="fecha">';
                    $HTML_ZANCOS.='<b>Fecha de envío: '.date("d-m-Y").'</b>';
                    
                  $HTML_ZANCOS.='</p>';
                  $HTML_ZANCOS.='<hr>';
                    $HTML_ZANCOS.='<br>';

                    $HTML_ZANCOS.='<table class="tablita">';
                      
                            
                            $HTML_ZANCOS.="<tr>";
                                        
                                        
                                        $HTML_ZANCOS.='<td style="background: #C82333; color: white; vertical-align:middle; text-align: center;" >';
                                            $HTML_ZANCOS.='<h3>'.count($zancos_desfase).'</h3>';
                                        $HTML_ZANCOS.='</td>';
                                        $HTML_ZANCOS.='<td style="vertical-align:middle; text-align: center; ">';
                                            $HTML_ZANCOS.='>>';
                                        $HTML_ZANCOS.='</td>';
                                        $HTML_ZANCOS.='<td>';
                                            $HTML_ZANCOS.='<table class="tablita">';
                                                 
                                                    foreach ($zancos_tamanos as $t) 
                                                    {
                                                        $x = 0;
                                                        $HTML_ZANCOS.='<tr>';
                                                            $HTML_ZANCOS.='<td>'.$t->tamano.'</td>';
                                                            foreach ($zancos_desfase as $desfase) 
                                                            {
                                                                if ($desfase->tamano == $t->id) 
                                                                {
                                                                    $x++;
                                                                }
                                                            }
                                                            $HTML_ZANCOS.='<td style="text-align:right; background: #C82333; color:white; width:30px; ">'.$x.'</td>';
                                                        $HTML_ZANCOS.='</tr>';
                                                    }
                                                
                                            $HTML_ZANCOS.='</table>';
                                        $HTML_ZANCOS.='</td>';
                                        $HTML_ZANCOS.='<td style="vertical-align:middle; text-align: center;">';
                                            $HTML_ZANCOS.='>>';
                                        $HTML_ZANCOS.='</td>';
                                        $HTML_ZANCOS.='<td>';
                                            $HTML_ZANCOS.='<table class="tablita">';
                                                $HTML_ZANCOS.='<tr style="background: #C82333; color: white;">';
                                                    $HTML_ZANCOS.='<td style="background: #C82333; color: white;"> TAMANOS / ZONAS</td>';
                                                    
                                                        foreach ($zancos_zonas as $z)
                                                        {
                                                            
                                                            $HTML_ZANCOS.='<td style="background: #C82333; color: white;">'.$z->zona.'</td>';
                                                            
                                                        } 
                                                    
                                                $HTML_ZANCOS.='</tr>';
                                                $HTML_ZANCOS.='<tr style="border-bottom: 2px solid #C82333;">';
                                                    $HTML_ZANCOS.='<td> * </td>';
                                                    
                                                        foreach ($zancos_zonas as $z)
                                                        {
                                                            
                                                            $y = 0;
                                                            foreach ($zancos_desfase as $desfase) 
                                                            {
                                                                if ($desfase->zona == $z->zona) 
                                                                {
                                                                    $y++;
                                                                }
                                                            }
                                                            $HTML_ZANCOS.='<td style="color: #C82333;" >'.$y.'</td>';
                                                            
                                                        } 
                                                  
                                                $HTML_ZANCOS.='</tr>';
                                                
                                                    foreach ($zancos_tamanos as $t) 
                                                    {
                                                        $HTML_ZANCOS.='<tr>';
                                                            $HTML_ZANCOS.='<td>'.$t->tamano.'</td>';
                                                            foreach ($zancos_zonas as $z)
                                                            {
                                                                
                                                                $w = 0;
                                                                foreach ($zancos_desfase as $desfase) 
                                                                {
                                                                    if ( ($desfase->zona == $z->zona) && ($desfase->tamano == $t->id) ) 
                                                                    {
                                                                        $w++;
                                                                    }
                                                                }

                                                                if($w > 0)
                                                                {
                                                                    $HTML_ZANCOS.='<td style=" background: #F8D7DA; color: black;" >'.$w.'</td>';
                                                                }
                                                                else
                                                                {
                                                                    $HTML_ZANCOS.='<td  >'.$w.'</td>';
                                                                }
                                                                
                                                                
                                                            } 
                                                        $HTML_ZANCOS.='</tr>';
                                                    }
                                                
                                            $HTML_ZANCOS.='</table>';
                                        $HTML_ZANCOS.='</td>';
                            
                    $HTML_ZANCOS.='</table> '; 
                    
              $HTML_ZANCOS.='</td>';
            $HTML_ZANCOS.='</tr> ';
            $HTML_ZANCOS.='<tr>';
              $HTML_ZANCOS.='<td>';
                $HTML_ZANCOS.='<p class="enlace">[+] información consultar el <a href="http://192.168.167.231/kit/public_zancos_dashboard.php" ><u>enlace</u></a></p>';

              $HTML_ZANCOS.='</td>';
            $HTML_ZANCOS.='</tr> ';
          $HTML_ZANCOS.='</tbody>';
        $HTML_ZANCOS.='</table> '; 
      $HTML_ZANCOS.='</div>';
  $HTML_ZANCOS.='</body>';
  $HTML_ZANCOS.='</html>';


  $correos_zancos = new Correos_zancos();
  $correos_zancos->fecha_envio = $fechaHoy;
  $correos_zancos->save();

  
}
 



ob_start();
echo $HTML_ZANCOS;
$variableHTML_ZANCOS = ob_get_clean();

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