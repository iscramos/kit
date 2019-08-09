<?php 
    require_once('includes/config.inc.php');
    require_once(VIEW_PATH.'headerGeneral.inc.php');
    //include(VIEW_PATH.'indexMenu.php');

    $meses = Disponibilidad_meses::getAll();
    
    $ano = Null;
    $mes = Null;
    $mes_nombre = Null;
    $dia = Null;

    if(isset($_REQUEST['ano']) && isset($_REQUEST['mes']) && isset($_REQUEST['mes_nombre']) )
    {
      $ano = $_REQUEST['ano'];
      $mes = $_REQUEST['mes'];
      $mes_nombre = $_REQUEST['mes_nombre'];
      $dia = date("Y-m-d");
    }
    //print_r($años);
 ?>
  <style type="text/css">
    #calendar
    {
      padding: 10px;
    }

    .LNoticias-info 
    {
      padding-left: 3.4375rem !important;
      padding-bottom: 2.5rem !important;
      position: relative;
      min-height: inherit;
      border-radius: 0 .25rem .25rem 0;
      background-color: transparent !important;
    }

    .LNoticias-info span
    {
      line-height: 20px;
    }

    .diames 
    {
      width: 25px;
      color: #FFFFFF;
      float: left;
      padding: 0px 0px;
      position: relative;
      text-align: center;
      -webkit-border-radius: 4px;
      -moz-border-radius: 4px;
      -o-border-radius: 4px;
      border-radius: 4px;
      margin-left: -33px;
      font-size: 11px;
    }

    .LNoticias-info>.LNoticias-name 
    {
      font-size: 1.2rem !important;
      color: #14235F!important;
      text-align: center;
    }

    .LNoticias-position 
    {
      margin: -2px 0 0px;
      line-height: 18px;
      font-weight: bold;
    }

    .LNoticias-info>p 
    {
      margin: 0;
      text-align: left !important;
    }

    hr
    {
      margin-top: 0px !important;
      margin-bottom: 0px !important;
      border-top: 1px dashed #333;
    }

    .imagencita
    {
      float: right;
      width: 60px;
    }

    .jambo_table td
    {
      border-bottom: 2px solid orange !important;
    }

  </style>     
            
        <!-- page content -->
        <div class="right_col" role="main">
          
          <div class='container text-center'>
            <h3 class="text-center" > Proyección de mantenimientos preventivos</h3>
              <form class="form-inline">
                <div class="form-group ">
                  <input class="hidden" type="text" name="ano" id="ano" value="<?php echo $ano; ?>">
                  
                  <select class="form-control" id="mes" name="mes">
                    <?php
                      foreach ($meses as $m) 
                      {
                        if($m->mes == $mes)
                        {
                          echo "<option value='".$m->mes."' style='display:none; ' selected>".$m->mes_nombre."</option>";
                        }
                        
                          echo "<option value='".$m->mes."' >".$m->mes_nombre."</option>";
                        
                        
                      }
                    ?>
                  </select>
                </div>
              </form>
          </div>
          
            
          <br>
            <div  id="calendar" class="">
              
              <?php
                if( $ano != "" && $mes != "" && $mes_nombre != "" )
                  {
                    
                    $dia = date("Y-m-d");

                    $q = "SELECT * FROM disponibilidad_calendarios
                            WHERE mes = $mes
                                AND ano = $ano
                                  ORDER BY dia ASC";

                    $semanas = Disponibilidad_calendarios::getAllByQuery($q);

                    
                    //print_r($semanas);
                    echo "<table class='table  table-bordered  table-hover  dataTables_wrapper jambo_table bulk_action'>";
                      echo "<thead>";
                        echo "<tr>";
                          echo "<th>W</th>";
                          echo "<th width='14.28%'>DOMINGO</th>";
                          echo "<th width='14.28%'>LUNES</th>";
                          echo "<th width='14.28%'>MARTES</th>";
                          echo "<th width='14.28%'>MIERCOLES</th>";
                          echo "<th width='14.28%'>JUEVES</th>";
                          echo "<th width='14.28%'>VIERNES</th>";
                          echo "<th width='14.28%'>SABADO</th>";
                        
                        echo "</tr>";
                      echo "</thead>";
                      echo "<tbody>";

                      $ban_semana = 1;
                      foreach ($semanas as $s) 
                      {
                        if($ban_semana == 1)
                        {
                          echo "<tr>";
                            echo "<th>".$s->semana."</th>";
                        }

                        
                        //echo $ban_semana;
                        /*$semanita = $s->semana;
                        $query = "SELECT * FROM disponibilidad_calendarios
                                    WHERE ano = $ano
                                      AND mes = $mes
                                      AND semana =  $semanita
                                    ORDER BY mes, dia";

                        $dias = Disponibilidad_calendarios::getAllByQuery($query);*/

                        /*echo "<tr>";
                          echo "<th>".$semanita."</th>";
                          foreach ($dias as $d) 
                          {*/
                            $fondo = "background-color:#3DC6AA!important;";

                            $dia_actual = $s->dia;
                            $consulta = "SELECT planner.*, disponibilidad_activos.descripcion as descripcion
                                  FROM  planner
                                  INNER JOIN disponibilidad_activos ON planner.equipo = disponibilidad_activos.activo
                                  WHERE planner.fecha_realizacion = '$dia_actual'
                                  ORDER BY planner.hora_inicio, planner.hora_fin ASC LIMIT 5";  

                            //echo $consulta;
                            $plan = Planner::getAllByQuery($consulta);
                                 

                            if($s->dia == $dia )
                            {
                              $fondo = "background-color:#FF9100!important;";
                            }

                            echo "<td>";
                              echo "<div class='LNoticias-info '>    
                                      <p>    
                                        <span style='$fondo' class='diames'> ".date("d", strtotime($s->dia))."
                                          <span>".date("M", strtotime($s->dia))."</span>
                                        </span>
                                      </p>"; 

                                      if (empty($plan)) 
                                      {
                                        echo "<h3 class='LNoticias-name'>
                                            <i class='fa fa-clock-o' aria-hidden='true'></i>  
                                            <a ></a>
                                          </h3>    
                                          <h5 class='LNoticias-position'></h5> ";
                                      }
                                      else
                                      {
                                        

                                        foreach ($plan as $p) 
                                        {
                                          $imagen = "";
                                          $findTractor   = "CO-TRC";
                                          $findParihuela   = "CO-PRH";
                                          $findTolva   = "CO-TOL";

                                          $posTractor = strpos($p->equipo, $findTractor);
                                          $posParihuela = strpos($p->equipo, $findParihuela);
                                          $posTolva = strpos($p->equipo, $findTolva);

                                          // Nótese el uso de ===. Puesto que == simple no funcionará como se espera
                                          // porque la posición de 'a' está en el 1° (primer) caracter.
                                          if ($posTractor !== false) 
                                          {
                                            $imagen = "<img class='imagencita' src='".$url."dist/img/tractor_sin_fondo.png'>";
                                          } 
                                          elseif ($posParihuela !== false) 
                                          {
                                            $imagen = "<img class='imagencita' src='".$url."dist/img/parihuela_sin_fondo.png'>";
                                          }
                                          elseif ($posTolva !== false) 
                                          {
                                            $imagen = "<img class='imagencita' src='".$url."dist/img/tolva_sin_fondo.png'>";
                                          }
                                          echo "
                                              $imagen
                                            <h3 class='LNoticias-name'>
                                            <i class='fa fa-clock-o' aria-hidden='true'></i>  
                                            <a >".date("h:i A", strtotime($p->hora_inicio))." - ".date("h:i A", strtotime($p->hora_fin))."</a>
                                            </h3>    
                                            <h5 style='font-size:12px;' class='LNoticias-position'>".$p->equipo." TIPO '".$p->frecuencia."'</h5>
                                            <p style='font-size:09px;'>".$p->descripcion."</p> 
                                            <hr>";
                                        }
                                        
                                      }
                                      
                                      
                                    echo "</div>";
                            echo "</td>";
                          //}

                            $ban_semana ++;
                            if($ban_semana == 8)
                            {
                              $ban_semana = 1;
                              echo "</tr>";
                            }
                        

                        
                      }
                      echo "</tbody>";
                    echo "</table>";
                  }
                  else
                  {
                    echo "<h4 >No data</h4>";
                  }
              ?>
            </div>
              
        </div>
          

          

         

 

 <?php require_once(VIEW_PATH.'footer.inc.php'); ?>
        <script type="text/javascript">

               $("#mes").on("change", function() 
                {
                    var ano = null;
                    var mes = null;
                    var mes_nombre = null;

                    mes = $(this).val();
                    mes_nombre = $('select[name="mes"] option:selected').text()
                    ano = $("#ano").val();
                    //alert(window.location.href);
                    window.location = "planner.php?ano="+ano+"&mes="+mes+"&mes_nombre="+mes_nombre;
                    //alert(mes+mes_nombre+ano);
                    
                });// fin de disponibilidad
  
           
        </script>

  </body>
</html>




