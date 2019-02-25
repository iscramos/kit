<?php 
    require_once('includes/config.inc.php');
    require_once(VIEW_PATH.'headerGeneral.inc.php');
    
    $query = "SELECT * FROM disponibilidad_activos
        WHERE criticidad = 'Alta'
        AND familia <> 'INVERNADEROS'
        ORDER BY activo ASC"; 

    $activos_equipos = Disponibilidad_activos::getAllByQuery($query);
    //include(VIEW_PATH.'indexMenu.php');

    $arrays = array("orfanelr@naturesweet.com", "sbarajas@naturesweet.com", "lramos@naturesweet.com");

$q = "SELECT  disponibilidad_data.ot, disponibilidad_data.descripcion AS descripcion, disponibilidad_activos.descripcion AS descripcion_equipo
        FROM disponibilidad_data
        INNER JOIN disponibilidad_activos ON disponibilidad_data.equipo = disponibilidad_activos.activo
        /*INNER JOIN correos_ots ON disponibilidad_data.ot = correos_ots.ot*/
        WHERE disponibilidad_data.ot NOT IN (SELECT ot FROM correos_ots)
            AND disponibilidad_data.tipo <> 'Mant. preventivo'
            AND disponibilidad_activos.criticidad = 'Alta'
            AND disponibilidad_activos.familia <> 'INVERNADEROS'
            AND (disponibilidad_data.estado = 'Ejecutado'
                OR disponibilidad_data.estado = 'Programada'
                OR disponibilidad_data.estado = 'Abierta'
                OR disponibilidad_data.estado = 'Falta mano de obra'
                OR disponibilidad_data.estado = 'Espera de refacciones'
                OR disponibilidad_data.estado = 'Espera de equipo'
                OR disponibilidad_data.estado = 'Solic. de trabajo' )
            ORDER BY disponibilidad_data.ot ASC";

$ots = Disponibilidad_data::getAllByQuery($q);
//print_r($ots);

$HTML = "NO SEND";
if(!empty($ots))
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
                $HTML.='<h2>OT DE EQUIPOS CRÍTICOS</h2>';
                
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
                  $HTML.='<table class="tablita">';
                    $HTML.='<thead>';
                      $HTML.='<tr>';
                        $HTML.='<th>OT</th>';
                        $HTML.='<th>DESCRIPCION</th>';
                        
                        $HTML.='<th>EQUIPO</th>';
                        
                      $HTML.='</tr>';
                    $HTML.='</thead>';
                    $HTML.='<tbody>';

                          $valores = "";
                          $i = 0;
                          foreach ($ots as $ot) 
                          {
                            if($i != 0)
                            {
                              $valores.=", ";
                            }
                            $valores.="(";
                            $valores.=$ot->ot;

                            $HTML.='<tr>';
                              $HTML.='<td>'.$ot->ot.'</td>';
                              $HTML.='<td>'.$ot->descripcion.'</td>';
                              $HTML.='<td>'.$ot->descripcion_equipo.'</td>';
                            $HTML.='</tr>';

                            $valores.=")";
                            $i++;
                          }
                          //echo $valores;
                          $correos_inserta = new Correos_ots();
                          $correos_inserta->q = $valores;
                          $correos_inserta->inserta_dura();
                      
                    $HTML.='</tbody>';
                  $HTML.='</table> ';   
              $HTML.='</td>';
            $HTML.='</tr> ';
            $HTML.='<tr>';
              $HTML.='<td>';
                $HTML.='<p class="enlace">Tambien puede consultar el siguiente <a href="http://192.168.167.231/kit/equipos_parados.php" >enlace</a></p>';
              $HTML.='</td>';
            $HTML.='</tr> ';
          $HTML.='</tbody>';
        $HTML.='</table> '; 
      $HTML.='</div>';
  $HTML.='</body>';
  $HTML.='</html>';
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
            
        <!-- page content -->
        <div class="right_col" role="main">
          
          <div class='container text-center'>
            <h3 class="text-center" > Equipos críticos con OT</h3>
              
          </div>
          
            
          <br>
          
          <div class="x_panel">
            <div class="x_content">

              <?php
                  $consulta = "SELECT * FROM disponibilidad_data
                                  WHERE tipo <> 'Mant. preventivo'
                                      AND (estado = 'Ejecutado'
                                          OR estado = 'Programada'
                                          OR estado = 'Abierta'
                                          OR estado = 'Falta mano de obra'
                                          OR estado = 'Espera de refacciones'
                                          OR estado = 'Espera de equipo'
                                          OR estado = 'Solic. de trabajo' )
                                      ORDER BY fecha_inicio_programada ASC";
                  $ordenes = Disponibilidad_data::getAllByQuery($consulta); // Para las ordenes no terminadas
                  
                  //print_r($ordenes);
                  foreach ($activos_equipos as $critico) 
                  {
                      //$no_ot = 0;
                      $enciendeParado = 0;
                      $colorEstatus = "";

                      foreach ($ordenes as $ot) 
                      {
                          if($ot->equipo == $critico->activo)
                          {
                              
                              //echo $ot["equipo"]."<br>";
                              $enciendeParado = 1;
                          
                          }
                      }


                      if ($enciendeParado == 1)
                      {

                          //$colorEstatus = "bs-callout bs-callout-red";
                        echo "<div class='col-xs-6 col-sm-2 col-md-2'>";
                          echo "<div class='contiene' style='margin-bottom: 20px; border: 1px solid #ddd; '>";
                              if(strpos($critico->activo, 'CO-TRC') !== false)
                              {
                                  echo "<img src='".$url."dist/img/tractor.png' alt='...' class='img-responsive'>";
                              }
                              else if(strpos($critico->descripcion, 'CO-CAM') !== false)
                              {
                                   echo "<img src='".$url."dist/img/volteo.png' alt='...' class='img-responsive'>";
                              }
                              else if($critico->familia == "FUMIGACION")
                              {
                                  echo "<img src='".$url."dist/img/parihuela.png' alt='...' class='img-responsive'>";
                              }
                              else if(strpos($critico->activo, 'CO-TOL') !== false)
                              {
                                   echo "<img src='".$url."dist/img/tolva.png' alt='...' class='img-responsive'>";
                              }
                              else if(strpos($critico->activo, 'CO-GEN') !== false)
                              {
                                   echo "<img src='".$url."dist/img/generador.png' alt='...' class='img-responsive'>";
                              }
                              else if(strpos($critico->activo, 'CO-TRA-0') !== false)
                              {
                                   echo "<img src='".$url."dist/img/transformador.png' alt='...' class='img-responsive'>";
                              }
                              else if(strpos($critico->activo, 'CO-ENF') !== false)
                              {
                                   echo "<img src='".$url."dist/img/camara.png' alt='...' class='img-responsive'>";
                              }
                              else if(strpos($critico->activo, 'CO-MON') !== false)
                              {
                                   echo "<img src='".$url."dist/img/montacargas.png' alt='...' class='img-responsive'>";
                              }
                              else if(strpos($critico->activo, 'CO-LVC') !== false)
                              {
                                   echo "<img src='".$url."dist/img/lavadora.png' alt='...' class='img-responsive'>";
                              }
                              else if(strpos($critico->activo, 'CO-POZ') !== false)
                              {
                                   echo "<img src='".$url."dist/img/pozo.png' alt='...' class='img-responsive'>";
                              }
                              else if(strpos($critico->activo, 'CO-COR') !== false)
                              {
                                   echo "<img src='".$url."dist/img/controlador.png' alt='...' class='img-responsive'>";
                              }
                              else if(strpos($critico->activo, 'CO-CIS') !== false)
                              {
                                   echo "<img src='".$url."dist/img/cisterna.png' alt='...' class='img-responsive'>";
                              }
                              else if(strpos($critico->activo, 'CO-TRA-PER') !== false)
                              {
                                   echo "<img src='".$url."dist/img/tarima_personal.png' alt='...' class='img-responsive'>";
                              }
                              else if(strpos($critico->activo, 'CO-TRA-PLM') !== false)
                              {
                                   echo "<img src='".$url."dist/img/tarima_plana.png' alt='...' class='img-responsive'>";
                              }
                              else if(strpos($critico->activo, 'CO-MEZ') !== false)
                              {
                                   echo "<img src='".$url."dist/img/mezclador.png' alt='...' class='img-responsive'>";
                              }
                              else if(strpos($critico->activo, 'CO-BMU') !== false)
                              {
                                   echo "<img src='".$url."dist/img/bomba.png' alt='...' class='img-responsive'>";
                              }
                              else
                              {
                                  echo "<img src='' alt='...' class='img-responsive'>";
                              }
                              
                              echo "<div class='caption'> ";
                                  echo "<p style='font-size:10px;'>".$critico->activo."</p>";
                                  echo "<p>
                                          <a href='#' class='btn btn-primary btn-xs detalles' equipo='".$critico->activo."' role='button' title='".$critico->descripcion."'>Detalles</a>
                                      </p>";
                              echo "</div>";
                          echo "</div>";
                      echo "</div>"; 
                      }
                        
                  }
              ?>

          
          </div>
        </div>
      </div>
      <div class="clearfix"></div>
    
          

          <!-- Modal -->
    <div class="modal fade" id="modalDetalles" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="myModalLabel">Detalles de parada</h4>
          </div>
          <div class="modal-body" id="divdestino">
                
          
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
          
          </div>
        </div>
      </div>
    </div>

         
<div id="modalBodyCentroCarga"></div>
 

 <?php require_once(VIEW_PATH.'footer.inc.php'); ?>
        <script type="text/javascript">


          // codigo para el envío de correos
          function mandarMails() 
          {
            //alert("hola");
            asunto = 'AVISO DE OT EN EQUIPOS CRITICOS';
            body = '<?php echo $variableHTML; ?>';
            mails = <?php echo json_encode($arrays); ?>;
            subTitulo = '<?php echo "Mantenimiento"; ?>';
            if(body == "NO SEND")
            {
              return true;
            }
            else
            {
              $.post("http://192.168.167.231/ns/mails/index.php",
                    {mails: mails, asunto: asunto, body: body, subTitulo: subTitulo}, function (data) {
                $("#modalBodyCentroCarga").html(data);
                //console.log("Correo enviado");
            });
            }
            
          }
          mandarMails();

          //-- Se termina
          $(document).ready(function(){
            $(".detalles").on("click", function(event) 
                { 
                    event.preventDefault();
                    var v = 0;
                        v = $(this).attr("equipo");
                        //alert(v);
                    ajaxCargaDatos("divdestino", v);
                
                });

                


                function creaAjax()
                {
                    var objetoAjax=false;
                    try {
                        /*Para navegadores distintos a internet explorer*/
                        objetoAjax = new ActiveXObject("Msxml2.XMLHTTP");
                    } catch (e)
                    {
                        try {
                            /*Para explorer*/
                            objetoAjax = new ActiveXObject("Microsoft.XMLHTTP");
                        } catch (E) {
                            objetoAjax = false;
                            }
                        }
                    if (!objetoAjax && typeof XMLHttpRequest!='undefined') {
                        objetoAjax = new XMLHttpRequest();
                    }
                    return objetoAjax;
                }

                function ajaxCargaDatos(divdestino, uID)
                {
                    var ajax=creaAjax();

                    ajax.open("GET", "helperDetallesCritico.php?equipo="+uID, true);
                    ajax.onreadystatechange=function() 
                    { 
                        if (ajax.readyState==1)
                        {
                          // Mientras carga ponemos un letrerito que dice "Verificando..."
                          $('#'+divdestino).html='Cargando...';
                        }
                        if (ajax.readyState==4)
                        {
                          // Cuando ya terminó, ponemos el resultado
                            var str =ajax.responseText; 
                                        
                            $('#'+divdestino).html(''+str+'');
                            $("#modalDetalles").modal("show");
                
                        } 
                    }
                    ajax.send(null);
                }
          });
           
        </script>

  </body>
</html>