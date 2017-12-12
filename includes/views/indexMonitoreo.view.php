<?php 
  require_once(VIEW_PATH.'header.inc.php');
  
    //include(VIEW_PATH.'indexMenu.php');
 ?>
  <style type="text/css">
   
    .slider {
        width: 97%;
        margin: 5px auto;
    }

    .slick-slide {
      margin: 0px 0px;
    }

    .slick-slide img {
      width: 100%;
    }

    .slick-prev:before,
    .slick-next:before {
        color: black;
    }

    .efecto
    {
      border: none;
      background: #000;
      
      opacity: -1;
      color: #000;
    }
    
  </style>
  <!-- page content -->
  <div class="right_col" role="main">
    <!-- top tiles -->
    <div class="row tile_count">
      <div class="col-md-3 col-sm-3 col-xs-3 tile_stats_count">
        <span class="count_top"><i class="fa fa-file-text"></i> OT atrasadas</span>
        <div class="count indicaRetraso"><!-- -- EL RETRASO -- --></div>
        <span class="count_bottom"><i class="green"></i> </span>
      </div>
      <div class="col-md-3 col-sm-3 col-xs-3 tile_stats_count">
        <span class="count_top"><i class="fa fa-clock-o"></i> Week</span>
        <?php 
          $fechaConsulta = date("d/m/Y");
          $fechaConsultaFormateada = date("m-d");
          $semanaActual = Calendario_nature::getSemanaByFecha($fechaConsultaFormateada);
          echo "<div class='count green'>".$semanaActual[0]->semana."</div>";
          echo "<span class='count_bottom'> ".$fechaConsulta."</span>";
          
          echo "<input class='form-control hidden' name='parametroSemana' id='parametroSemana' value='".$semanaActual[0]->semana."'>";

        ?>
        
 
      </div>

      <div class="col-md-6 col-sm-6 col-xs-6 tile_stats_count">
        <span class="count_top"><i class="fa fa-folder-open"></i> Archivo de carga (monitoreo.xlsx)</span>
        
          <form action="load.php" method="POST" enctype="multipart/form-data" class="form-inline">
             <div class='form-group'>
                  <div class='col-sm-10'>  
                      <input type='file' id='archivo' name='archivo' onChange='extensionCHK(this);' required>
                      <button type="submit" class="btn btn-success btn-xs"> <span class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></span> Cargar...</button>
                  </div>
              </div>
              <div class='form-group hidden' >
                  <label class='col-sm-2 control-label' >Líder</label>
                  <div class="col-sm-10">
                      <input type="number" class='form-control hidden' name='lider' id='lider' value='<?php echo $lider; ?>'>
                  </div>
              </div>
              
          </form>
  
      </div>


      
    <!-- /top tiles -->

    <div class="row loading efecto">
      <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="dashboard_graph">

          <div class="row x_title">
            <div class="col-md-6">
              <h3>Monitoreo semanal <small>programación de actividades</small></h3>
            </div>
            <div class="col-md-6">
              <div id="" class="pull-right" >
                <i class="fa fa-clock-o fa-lg" aria-hidden="true" > </i> 
                Esta página se actualizará en: &nbsp;
                <span id="expire" class="pull-right " ></span> 
              </div>
            </div>
          </div>

          <div class="col-md-12 col-sm-12 col-xs-12">
            <!-- El contenido -->
            <?php
              if($actualizado == "@")
              {
                  echo "<audio controls autoplay class='hidden'>
                          <source src='".$url."content/base.ogg' type='audio/ogg'>
                        </audio>";
              }
            ?>
            <section class="variable slider" style="margin-top: 0px;">
              <div class="cargando">
                  <div id="general" class="col-sm-12"></div> 
                  <div id="MPgeneral" class="col-sm-6"></div> 
                  <div id="MCgeneral" class="col-sm-6"></div>
              </div>

              <div >
                  <?php 
                    $direccion = $url.$content."/monitoreo.json";
                    //echo $direccion;
                    $json_ordenes = file_get_contents($direccion);
                    $ordenes = json_decode($json_ordenes, true);

                    $dias = ["DOMINGO", "LUNES", "MARTES", "MIERCOLES", "JUEVES", "VIERNES", "SABADO"];
                    //$lideres = [41185, 239];

                    $diaHoy = date("Y-m-d");
                    $fecha_inicio = "";
                    $ano = date("Y");
                    $nombreDiaHoy = $dias[date('w', strtotime($diaHoy))];

                    $datosSemana = Calendario_nature::getAllSemana($semanaActual[0]->semana);
                    $fecha_inicio = $datosSemana[0]->fecha_inicio;
                    $fecha_inicio = $ano."-".$fecha_inicio;
                    //echo $fechaInicio;
                  ?>
                  <h3 style="text-align: center;">MONITOREO DEL DIA (<?php echo $nombreDiaHoy; ?>)</h3>
                  <div id="porDiaIncrementa" >

                  <?php
                    
                      $nombreLider = "";
                      $puesto = "";
                      $departamento = "";

                      $totalMantenimientos = 0;
                      $totalMP = 0;
                      $totalMC = 0;
                      $totalTerminadosMP = 0;
                      $totalTerminadosMC = 0;

                      $porcentajeTerminadosMP = 0;
                      $porcentajeTerminadosMC = 0;

                      foreach ($ordenes as $orden) 
                      {
                        if( ($lider == $orden["responsable"]) && (date("Y-m-d", strtotime($orden["fecha_finalizacion_programada"])) >= $diaHoy) && (date("Y-m-d", strtotime($orden["fecha_inicio_programada"])) <= $diaHoy) )
                          {
                          //echo $orden["responsable"]."<br>";
                          //echo $lider;
                          /*echo "inicio = ".$fecha_inicio;
                          echo "<br>Programada = ".$orden["fecha_inicio_programada"];
                          echo "<br> Hoy = ".$diaHoy."<br><br>";*/

                          if($orden["tipo"] == "Mant. preventivo")
                          {
                            if($orden["estado"] == "Terminado")
                            {
                              $totalTerminadosMP ++;
                            }

                            $totalMP ++;
                          }
                          elseif ($orden["tipo"] != "Mant. preventivo" )
                          {
                            if($orden["estado"] == "Terminado")
                            {
                              $totalTerminadosMC ++;
                            }

                            $totalMC ++;
                          }
                        }
                      }

                      $totalMantenimientos = $totalMP + $totalMC;
                      if($totalTerminadosMP != 0)
                      {
                        $porcentajeTerminadosMP = ( (5 * $totalTerminadosMP) / $totalMP );
                        $porcentajeTerminadosMP = round($porcentajeTerminadosMP, 1);
                      }
                      if($totalTerminadosMC != 0)
                      {
                        $porcentajeTerminadosMC = ( (5 * $totalTerminadosMC) / $totalMC );
                        $porcentajeTerminadosMC = round($porcentajeTerminadosMC, 1);
                      }
                      
                      //echo "TotalTerminadoMP = ". $totalTerminadosMP. " totalTerminadosMC = ". $totalTerminadosMC. " totalMantenimientos = ".$totalMantenimientos;
                      $realizadoPorcentaje = ( (100) * ($totalTerminadosMP + $totalTerminadosMC) ) / $totalMantenimientos;
                      $realizadoPorcentaje = round($realizadoPorcentaje, 1);

                      //echo "porcentajeTerminadosMP =".$porcentajeTerminadosMP;
                      //echo " porcentajeTerminadosMC = ".$porcentajeTerminadosMC;

                      $direccion0 = "http://192.168.167.231/proapp/ws/?asociado=".$lider;
                      $json_asociado = file_get_contents($direccion0);
                      $asociadoData = json_decode($json_asociado, true);

                      foreach ($asociadoData as $datosAsociado) 
                      {
                        $nombreLider = $datosAsociado["nombre"];
                        $puesto = $datosAsociado["puesto"];
                        $departamento = $datosAsociado["departamento"];
                      }

                      

                        echo "<div class='col-md-5'>

                                <div class='card hovercard'>
                                    <div class='cardheader'>

                                    </div>
                                    <div class='avatar centrar'>
                                        <img class='' src='".$url."/dist/img/avatar.jpg'>
                                    </div>
                                    <div class='info'>
                                        <div class='title'>
                                            <a >".$nombreLider."</a>
                                        </div>
                                        <div class='desc'>".$departamento."</div>
                                        <div class='desc'>".$puesto."</div>
                                    </div>
                                    <div class='bottom'>
                                    <br>
                                    <br>
                                        <a class='' style='font-size:80px !important;'>".$realizadoPorcentaje." % </a>
                                    </div>
                                    
                                </div>

                            </div>";

                      echo "<div class='col-md-7' style='padding-top:10px;'>
                              <div class='well well-sm' style='border-top-color: #337ab7; border-top-width: 4px;'>
                                  <div class='row'>
                                      <div class='col-xs-12 col-md-12 text-center'>
                                          <h1 class='rating-num'>".$totalMantenimientos."</h1>
                                          <div>
                                              <h4>Mantenimientos programados</h4>
                                          </div>
                                      </div>
                                      <div class='col-xs-6 col-md-6'>
                                          
                                      </div>
                                  </div>
                              </div>
                          </div>";

                      echo "<div class='col-md-7'>
                              <div class='well well-sm' style='border-top-color: #5cb85c; border-top-width: 4px;'>
                                  <div class='row'>
                                      <div class='col-xs-12 col-md-4 text-center'>
                                          <h2>".$totalTerminadosMP." / ".$totalMP." </h2>
                                          <div>
                                              <h4>Mantenimientos preventivos</h4>
                                          </div>
                                      </div>
                                      <div class='col-xs-12 col-md-8'>
                                        <input type='text' class='kv-fa rating-loading' value='".$porcentajeTerminadosMP."' data-size='md' title='Cherri Tickets'>
                                      </div>
                                  </div>
                              </div>
                          </div>";

                      echo "<div class='col-md-7'>
                              <div class='well well-sm' style='border-top-color: #f0ad4e; border-top-width: 4px;'>
                                  <div class='row'>
                                      <div class='col-xs-12 col-md-4 text-center'>
                                          <h2>".$totalTerminadosMC." / ".$totalMC." </h2>
                                          <div>
                                              <h4>Mantenimientos correctivos</h4>
                                          </div>
                                      </div>
                                      <div class='col-xs-12 col-md-8'>
                                        <input type='text' class='kv-fa rating-loading' value='".$porcentajeTerminadosMC."' data-size='md' title='Cherri Tickets'>
                                      </div>
                                  </div>
                              </div>
                          </div>";
                    
                    
                  ?>
                    
                  </div>
                <!--img src="http://placehold.it/200x300?text=2"-->
              </div>
              
              <?php
                
                
                
                  // LAS ORDENES ACTUALES
                    $i = 1;
                    echo "<div>";
                      echo "<h3 style='text-align:center;' style='margin-top: 0px;' >".$nombreDiaHoy."</h3>";
                       echo "<div id='top'>";
                          echo "<table class='table table-bordered table-condensed jambo_table bulk_action' style='font-size: 11px;'> ";
                            echo "<thead>
                                    <tr>
                                      <th>#</th>
                                      <th>ORDEN</th>
                                      <th>DESCRIPCION</th>
                                      <th>EQUIPO</th>
                                      
                                      <!--th>CLASE</th-->
                                      <th>TECNICO</th>
                                      <th>DESDE</th>
                                      <th>HASTA</th>
                                      <th>CIERRE</th>
                                      <th>ESTADO</th>
                                      <th>AVANCE</th>
                                    </tr>
                                  </thead>";
                                echo "<tbody>";
                    foreach ($ordenes as $orden) 
                    {
                      $fechaAbuscar = $orden["fecha_inicio_programada"];
                      $fechaAbuscar = date("Y-m-d",strtotime($fechaAbuscar));
                      $fechaATerminar = $orden["fecha_finalizacion_programada"];
                      if( ($orden["responsable"] == $lider) && ($fechaAbuscar <= $diaHoy)  && ($fechaATerminar >= $diaHoy) )
                      {
                        

                                      // BUSCANDO SI ES EQUIPO CRÍTICO
                                        $color_semaforo = "";
                                        $color_semaforo = " style='color:#5cb85c;' ";
                                        $datos_criticos = Activos_equipos::getAllByEQuipo($orden["equipo"]);
                                        if (count($datos_criticos) > 0)
                                        {
                                          if($orden["tipo"] == "Mant. preventivo")
                                          {
                                            $color_semaforo = " style='color:#f0ad4e;' ";
                                          }
                                          else if($orden["tipo"] == "Correctivo de emergencia" || $orden["tipo"] == "Correctivo planeado")
                                          {
                                            $color_semaforo = " style='color:#d9534f;' ";
                                          }
                                        }
                                      // TERMINA SI ES CRITICO  

                                      echo "<tr  >";
                                        echo "<td>".$i."</td>";
                                        echo "<td>".$orden["orden_trabajo"]."</td>";
                                        echo "<td> <i class='fa fa-file-text fa-lg' aria-hidden='true' ".$color_semaforo." ></i> ".$orden["descripcion"]."</td>";

                                        
                                        
                                        echo "<td >".$orden["equipo"]."</td>";
                                        
                                        //echo "<td>".$nombreResponsable."</td>";
                                        //echo "<td>".$orden["clase"]."</td>";
                                        
                                        $direccion2 = "http://192.168.167.231/proapp/ws/?asociado=".$orden["tecnico"];
                                        $json_asociado = file_get_contents($direccion2);
                                        $asociadoData = json_decode($json_asociado, true);
                                        //print_r($asociadoData);
                                        //$empleado_nature = Empleados_nature::getAllByAsociado($orden["tecnico"]);
                                        /*if(count($empleado_nature) > 0)
                                        {*/
                                        foreach ($asociadoData as $aData) 
                                        {
                                          echo "<td>".utf8_encode($aData["nombre"])."</td>";
                                        }
                                        /*}
                                        else
                                        {
                                          echo "<td>".$orden["tecnico"]."</td>";
                                        }*/

                                        echo "<td class='bg-success'>".date("d-M",strtotime($orden["fecha_inicio_programada"]))."</td>";
                                                  echo "<td class='bg-success'>".date("d-M",strtotime($orden["fecha_finalizacion_programada"]))."</td>";

                                        /*if($orden["fecha_inicio"] == "")
                                        {
                                          echo "<td> </td>";
                                        }
                                        else
                                        {
                                          echo "<td>".date("d-m-Y",strtotime($orden["fecha_inicio"]))."</td>"; 
                                        }*/
                                        
                                        if($orden["fecha_finalizacion"] == "")
                                        {
                                          echo "<td> </td>";
                                        }
                                        else
                                        {
                                          echo "<td>".date("d-M",strtotime($orden["fecha_finalizacion"]))."</td>"; 
                                        }
                                        echo "<td>".$orden["estado"]."</td>";
                                        
                                        if($orden["estado"] == "Programada")
                                        {
                                          echo "<td class='disponibility' >
                                                <div class='progress' style='margin-bottom: 0px !important; height:15px !important;'>
                                                  <div class='porcentaje progress-bar progress-bar-danger' role='progressbar' aria-valuenow='10' aria-valuemin='0' aria-valuemax='100' style='width: 10%; line-height: 15px;' data-valor='10' >10%
                                                  </div>
                                                </div>
                                              </td>";
                                        }
                                        else if($orden["estado"] == "Ejecutado")
                                        {
                                          echo "<td class='disponibility'>
                                                <div class='progress' style='margin-bottom: 0px !important; height:15px !important;'>
                                                  <div class='porcentaje progress-bar progress-bar-warning' role='progressbar' aria-valuenow='70' aria-valuemin='0' aria-valuemax='100' style='width: 70%; line-height: 15px;' data-valor='70' >70%
                                                  </div>
                                                </div>
                                              </td>";
                                        }
                                        else if($orden["estado"] == "Terminado")
                                        {
                                          echo "<td class='disponibility'>
                                                <div class='progress' style='margin-bottom: 0px !important; height:15px !important;'>
                                                  <div class='porcentaje progress-bar progress-bar-success' role='progressbar' aria-valuenow='100' aria-valuemin='0' aria-valuemax='100' style='width: 100%; line-height: 15px;' data-valor='100' >100%
                                                  </div>
                                                </div>
                                              </td>";
                                        }
                                        else
                                        {
                                          echo "<td class='disponibility'>
                                                <div class='progress' style='margin-bottom: 0px !important; height:15px !important;'>
                                                  <div class='porcentaje progress-bar progress-bar-success' role='progressbar' aria-valuenow='0' aria-valuemin='0' aria-valuemax='100' style='width: 0%; line-height: 15px;' data-valor='0' >0%
                                                  </div>
                                                </div>
                                              </td>";
                                        }
                                        //echo "<td></td>";
                                      echo "</tr>";
                        $i ++;            
                      } // fin del if
                    } // fin del foreach 
                              echo "</tbody>";
                          echo "</table>
                            </div>
                          <!--img src='http://placehold.it/200x300?text=2'-->
                        </div>";

                  // LAS ORDENES ATRASADAS
                    $i = 1;
                    $x = 0;
                    echo "<div>";
                      echo "<h3 style='text-align:center;' style='margin-top: 0px;' >ÓRDENES DE TRABAJO ATRASADAS</h3>";
                       echo "<div id='top'>";
                          echo "<table class='table table-bordered table-condensed jambo_table bulk_action' style='font-size: 11px;'> ";
                            echo "<thead >
                                    <tr>
                                      <th>#</th>
                                      <th>ORDEN</th>
                                      <th>DESCRIPCION</th>
                                      <th>EQUIPO</th>
                                      
                                      <!--th>CLASE</th-->
                                      <th>TECNICO</th>
                                      <th>DESDE</th>
                                      <th>HASTA</th>
                                      <th>CIERRE</th>
                                      <th>ESTADO</th>
                                      <th>AVANCE</th>
                                    </tr>
                                  </thead>";
                                echo "<tbody>";
                    foreach ($ordenes as $orden) 
                    {
                      $fechaAbuscar = $orden["fecha_inicio_programada"];
                      $fechaAbuscar = date("Y-m-d",strtotime($fechaAbuscar));
                      $fechaATerminar = $orden["fecha_finalizacion_programada"];

                      //$fechaAbuscar = $orden["fecha_inicio_programada"];
                      //echo $fechaAbuscar;
                      //$diaProgramado = $dias[date('w', strtotime($fechaAbuscar))];
                      //echo $diaProgramado;
                      if( ($orden["responsable"] == $lider) && ($fechaATerminar < $diaHoy)  && $orden["estado"] != "Terminado")
                      {
                                      /*$nombreResponsable = "";
                                      if($orden["responsable"] == 41185)
                                      {
                                        $nombreResponsable = "ORFANEL RENDON";
                                      }
                                      elseif ($orden["responsable"] == 239) 
                                      {
                                        $nombreResponsable = "HUMBERTO CERVANTES";
                                      }*/
                                      // BUSCANDO SI ES EQUIPO CRÍTICO
                                        $color_semaforo = "";
                                        $color_semaforo = " style='color:#5cb85c;' ";
                                        $datos_criticos = Activos_equipos::getAllByEQuipo($orden["equipo"]);
                                        if (count($datos_criticos) > 0)
                                        {
                                          if($orden["tipo"] == "Mant. preventivo")
                                          {
                                            $color_semaforo = " style='color:#f0ad4e;' ";
                                          }
                                          else if($orden["tipo"] == "Correctivo de emergencia" || $orden["tipo"] == "Correctivo planeado")
                                          {
                                            $color_semaforo = " style='color:#d9534f;' ";
                                          }
                                        }
                                      // TERMINA SI ES CRITICO  

                                      echo "<tr >";
                                        echo "<td>".$i."</td>";
                                        echo "<td>".$orden["orden_trabajo"]."</td>";
                                        echo "<td> <i class='fa fa-file-text fa-lg' aria-hidden='true' ".$color_semaforo." ></i> ".$orden["descripcion"]."</td>";
                                        echo "<td>".$orden["equipo"]."</td>";
                                        //echo "<td>".$nombreResponsable."</td>";
                                        //echo "<td>".$orden["clase"]."</td>";

                                        $direccion2 = "http://192.168.167.231/proapp/ws/?asociado=".$orden["tecnico"];
                                        $json_asociado = file_get_contents($direccion2);
                                        $asociadoData = json_decode($json_asociado, true);
                                        foreach ($asociadoData as $aData) 
                                        {
                                          echo "<td>".utf8_encode($aData["nombre"])."</td>";
                                        }

                                        echo "<td class='bg-danger'>".date("d-M",strtotime($orden["fecha_inicio_programada"]))."</td>";
                                        echo "<td class='bg-danger'>".date("d-M",strtotime($orden["fecha_finalizacion_programada"]))."</td>";

                                        
                                        /*if($orden["fecha_inicio"] == "")
                                        {
                                          echo "<td> </td>";
                                        }
                                        else
                                        {
                                          echo "<td>".date("d-m-Y",strtotime($orden["fecha_inicio"]))."</td>"; 
                                        }*/
                                        
                                        if($orden["fecha_finalizacion"] == "")
                                        {
                                          echo "<td> </td>";
                                        }
                                        else
                                        {
                                          echo "<td>".date("d-M",strtotime($orden["fecha_finalizacion"]))."</td>"; 
                                        }

                                        echo "<td>".$orden["estado"]."</td>";
                                        if($orden["estado"] == "Programada")
                                        {
                                          echo "<td class='disponibility' >
                                                <div class='progress' style='margin-bottom: 0px !important; height:15px !important;'>
                                                  <div class='porcentaje progress-bar progress-bar-danger' role='progressbar' aria-valuenow='10' aria-valuemin='0' aria-valuemax='100' style='width: 10%; line-height: 15px;' data-valor='10' >10%
                                                  </div>
                                                </div>
                                              </td>";
                                        }
                                        else if($orden["estado"] == "Ejecutado")
                                        {
                                          echo "<td class='disponibility'>
                                                <div class='progress' style='margin-bottom: 0px !important; height:15px !important;'>
                                                  <div class='porcentaje progress-bar progress-bar-warning' role='progressbar' aria-valuenow='70' aria-valuemin='0' aria-valuemax='100' style='width: 70%; line-height: 15px;' data-valor='70' >70%
                                                  </div>
                                                </div>
                                              </td>";
                                        }
                                        else if($orden["estado"] == "Terminado")
                                        {
                                          echo "<td class='disponibility'>
                                                <div class='progress' style='margin-bottom: 0px !important; height:15px !important;'>
                                                  <div class='porcentaje progress-bar progress-bar-success' role='progressbar' aria-valuenow='100' aria-valuemin='0' aria-valuemax='100' style='width: 100%; line-height: 15px;' data-valor='100' >100%
                                                  </div>
                                                </div>
                                              </td>";
                                        }
                                        else
                                        {
                                          echo "<td class='disponibility'>
                                                <div class='progress' style='margin-bottom: 0px !important; height:15px !important;'>
                                                  <div class='porcentaje progress-bar progress-bar-success' role='progressbar' aria-valuenow='0' aria-valuemin='0' aria-valuemax='100' style='width: 0%; line-height: 15px;' data-valor='0' >0%
                                                  </div>
                                                </div>
                                              </td>";
                                        }
                                        //echo "<td></td>";
                                      echo "</tr>";
                        $i ++;
                        $x ++;            
                      } // fin del if
                    } // fin del foreach 
                              echo "</tbody>";
                          echo "</table>
                              <input type='number' class='form-control hidden' name='noRetrasadas' id='noRetrasadas' value=".$x.">
                            </div>
                          <!--img src='http://placehold.it/200x300?text=2'-->
                        </div>";
                  

  
                

              ?>

              
              
          </section>

          </div>

          <!-- /.row -->
                              

          <div class="clearfix"></div>
        </div>
      </div>

    </div>
    <br />      

  </div>

                                
                                
                            



            
           

        





 <?php require_once(VIEW_PATH.'footer.inc.php'); ?>

    <script type="text/javascript" src="<?php echo $url; ?>dist/slick/slick.min.js"></script>
    <script src="<?php echo $url; ?>dist/js/star-rating.js"></script>

    <script src="<?php echo $url; ?>dist/js/jquery.dateformat.js"></script>
    <script src="<?php echo $url; ?>dist/js/jquery.epiclock.js"></script>
    

    <script type="text/javascript">
        function extensionCHK(campo)
        {
            var src = campo.value;
            var log = src.length;
            
            /*var pdf = log - 3;
            var wpdf = src.substring(pdf, log);
                wpdf = wpdf.toUpperCase();*/

            // para .XLSX
            var xlsx = log - 4;
            var wsubc = src.substring(xlsx, log);
                wsubc = wsubc.toUpperCase();
          
          //this.files[0].size gets the size of your file.
          var tamano = $("#archivo")[0].files[0].size;
          
          if (tamano > 10485760)
          {
            //alert('El archivo a subir debe ser menor a 1MB');
            $("#archivo").val("");
            alert("El archivo pesa más de 10MB.");
          
          }

          else if(wsubc!='XLSX')
          {
            //alert('El archivo a subir debe ser una imagen JPG, o PDF');
            $("#archivo").val("");
            alert("El archivo debe ser un monitoreo.xlsx");
            
          }
        }
    </script>
          
        <script type="text/javascript">
            $('.slider').slick({
              infinite: true,
              slidesToShow: 1,
              slidesToScroll: 1,
              autoplay: true,
              autoplaySpeed: 10000,
              dots: true,
              fade: true
              //cssEase: 'linear'
            });
           
            /*

              //google.charts.load('current', {'packages':['treemap']});
              google.charts.setOnLoadCallback(drawTableTop);

              function drawTableTop() 
              {
                var data = new google.visualization.DataTable();
                data.addColumn('string', 'ORDEN');
                data.addColumn('number', 'TIPO');
                data.addColumn('boolean', 'ESTADO');
                data.addRows([
                  ['Francisco',  {v: 10000, f: '$10,000'}, true],
                  ['Juanito',   {v:8000,   f: '$8,000'},  false],
                  ['Carlitos', {v: 12500, f: '$12,500'}, true],
                  ['Bob',   {v: 7000,  f: '$7,000'},  true]
                ]);

                var table = new google.visualization.Table(document.getElementById('top'));

                table.draw(data, {showRowNumber: true, width: '100%', height: '100%'});
              }*/
              

            $(document).ready(function()
            {
               
                //------------------------------
                //  Expire
                //------------------------------
                $(function ()
                {   
                    $('#expire').epiclock({mode: $.epiclock.modes.expire, offset: {minutes: 10}}).bind('timer', function ()
                    {
                        $('<span>This timer has expired!</span>').css({color: '#F60000', display: 'none', paddingLeft: 10}).appendTo(this).fadeIn(250);
                        location.reload();
                    });
                });

                

                $('#general').html('Cargando...');
                $('#MPgeneral').html('Cargando...');
                $('#MCgeneral').html('Cargando...');

                var parametroLider = $("#lider").val();
                var lideres = [parametroLider];

                var parametroSemana = $("#parametroSemana").val();

                drawPorSemana(parametroSemana);
              

                function drawPorSemana($parametroSemana)
                {
                  // Para crear la gráfica de cumplimiento histórico
                  /*var anoParametro = $("#ano").val();*/
                  
                  /*var constructorLider = [['LIDER',  'TOTAL', {role:'annotation' }, 'MP', {role:'annotation' }, 'MC', {role:'annotation' }]];*/

                  var constructorLunes = [['ORDEN',  'LIDER', 'TIPO', 'CLASE', {role:'annotation' }, 'MC', {role:'annotation' }]];
                 

                  $.getJSON("excelMonitoreo.php?semanaActual="+parametroSemana, function(result)
                  {
                    
                    
                      var cuentaMPgeneral = 0;
                      var cuentaMCgeneral = 0;
                      var cuentaTotalGeneral = 0;

                      var cuentaMPterminados = 0;
                      var cuentaMPpendientes = 0;

                      var cuentaMCterminados = 0;
                      var cuentaMCpendientes = 0;

                      var promedioCumplimientoMP = 0;
                      var promedioCumplimientoMC = 0;
                      
                      var Terminados = 0;
                      var Pendientes = 0;

                      

                    $.each(lideres, function(key, value)
                    {
                      var lider = value;
                      var terminadosLiderMP = 0;
                      var pendientesLiderMP = 0;
                      var totalLiderMP = 0;

                      var terminadosLiderMC = 0;
                      var pendientesLiderMC = 0;
                      var totalLiderMC = 0;

                      $.each(result, function(i, field)
                      {
                        
                        
                          
                          // PARA CONTAR LA INFORMACION DE MANTENIMIENTOS GENERALES DE LA ASEMANA
                          if(lider == field["responsable"])
                          {
                            if(field["tipo"] == "Mant. preventivo")
                            {
                              if(field["estado"] == "Terminado")
                              {
                                cuentaMPterminados++;
                                terminadosLiderMP++;
                              }
                              else
                              {
                                cuentaMPpendientes++;
                                pendientesLiderMP++;
                              }

                              cuentaMPgeneral ++;
                              totalLiderMP++;
                            } 
                            else if (field["tipo"] != "Mant. preventivo")
                            {
                              if(field["estado"] == "Terminado")
                              {
                                cuentaMCterminados++;
                                terminadosLiderMC++;
                              }
                              else
                              {
                                cuentaMCpendientes++;
                                pendientesLiderMC++;
                              }

                              cuentaMCgeneral ++;
                              totalLiderMC++;
                            }

                            cuentaTotalGeneral = cuentaMPgeneral + cuentaMCgeneral;
                            promedioCumplimientoMP = parseFloat( ( (cuentaMPterminados / cuentaMPgeneral) * 100).toFixed(1) );
                              //promedioCumplimientoMP = round(promedioCumplimientoMP, 1);
                            promedioCumplimientoMC = parseFloat( ( (cuentaMCterminados / cuentaMCgeneral) * 100).toFixed(1) );
                              //promedioCumplimientoMC = round(promedioCumplimientoMC, 1);
                            terminados = (cuentaMPterminados + cuentaMCterminados);
                            pendientes = (cuentaMPpendientes + cuentaMCpendientes)

                          }
                          
                      
                          
                    });// fin de each result

                   
                    var nombreLider = "";
                    var porcentajeLiderMP = 0;
                        porcentajeLiderMP = parseFloat( ( (terminadosLiderMP / totalLiderMP) * 100).toFixed(1) ) ;
        
                    var porcentajeLiderMC = 0;
                        porcentajeLiderMC = parseFloat( ( (terminadosLiderMC / totalLiderMC) * 100 ).toFixed(1) ) ;
                       
                    var porcentajeLiderTotal = 0;
                    var porcentajeLiderTotal = ( parseFloat(porcentajeLiderMP)  + parseFloat(porcentajeLiderMC) / 2) ;
                    
                    /*if(lider == 41185) 
                    {
                      nombreLider = "ORFANEL";
                    }
                    else if(lider == 239) 
                    {
                      nombreLider = "HUMBERTO";
                    }
                    else if(lider == 239) 
                    {
                      nombreLider = "HUMBERTO";
                    }*/

                    //console.log(nombreLider+"->"+porcentajeLiderTotal+"-"+porcentajeLiderMP+"-"+porcentajeLiderMC);
                    /*constructorLider.push([nombreLider, 
                      porcentajeLiderTotal, porcentajeLiderTotal,
                      porcentajeLiderMP, porcentajeLiderMP,
                      porcentajeLiderMC, porcentajeLiderMC]);*/

                  }); // fin de lider

                    google.charts.load('current', {'packages':['corechart', 'table', 'bar']});
                    google.charts.setOnLoadCallback(drawChart);

                    function drawChart() 
                    {

                      var data = google.visualization.arrayToDataTable([
                        ['Mantenimiento', 'No.'],
                        ['Terminado ',     terminados],
                        ['Pendiente ',     pendientes]
                      ]);

                      var options = {
                        title: 'No mantenimientos ('+cuentaTotalGeneral+') , MP = '+promedioCumplimientoMP+' % '+' MC = '+promedioCumplimientoMC +' % ',
                        is3D: true,
                        height: 300,
                         slices: {  
                                    1: {offset: 0.2},
                                    12: {offset: 0.3},
                                    14: {offset: 0.4},
                                    15: {offset: 0.5},
                                },
                        
                        colors: ['#5cb85c', '#dc3912']

                      };

                      var chart = new google.visualization.PieChart(document.getElementById('general'));

                      chart.draw(data, options);
                    }

                    google.charts.setOnLoadCallback(drawChartMPGeneral);

                    function drawChartMPGeneral() 
                    {
                      var data = google.visualization.arrayToDataTable([
                        ['Estado', '%'],
                        ['Terminado ('+cuentaMPterminados+')',     cuentaMPterminados],
                        ['Pendiente ('+cuentaMPpendientes+')',      cuentaMPpendientes]
                      ]);

                      var options = {
                        title: 'Mantemientos preventivos ('+cuentaMPgeneral+')',
                        pieHole: 0.3,
                        height: 200,
                        colors: ['#5cb85c', '#dc3912'],
                      };

                      var chart = new google.visualization.PieChart(document.getElementById('MPgeneral'));
                      chart.draw(data, options);
                    }

                    google.charts.setOnLoadCallback(drawChartMCGeneral);

                    function drawChartMCGeneral() 
                    {
                      var data = google.visualization.arrayToDataTable([
                        ['Estado', '%'],
                        ['Terminado ('+cuentaMCterminados+')',     cuentaMCterminados],
                        ['Pendiente ('+cuentaMCpendientes+')',       cuentaMCpendientes]
                      ]);

                      var options = {
                        title: 'Mantemientos correctivos ('+cuentaMCgeneral+')',
                        pieHole: 0.3,
                        height: 200,
                        colors: ['#5cb85c', '#dc3912']
                      };

                      var chart = new google.visualization.PieChart(document.getElementById('MCgeneral'));
                      chart.draw(data, options);
                    }

                    // PARA VER DATOS POR LIDER

                   /* google.charts.setOnLoadCallback(drawChartPorLider);

                    function drawChartPorLider() 
                    {
                      
                      var data = google.visualization.arrayToDataTable(constructorLider);

                      var options = {
                  
                        
                          title: 'Mantenimientos por líder',
                          //subtitle: 'Cumplimiento mensual de MP vs MC',

                        
                        bars: 'vertical',
                        vAxis: {
                              
                              format: '#\'%\'',
                              
                          },
                          
                        height: 600,
                        //width:400,
                        colors: ['#337ab7', '#5cb85c', '#f0ad4e']
                      };

                      var chart = new google.visualization.ColumnChart(document.getElementById('porLider'));
                      chart.draw(data, options);

                      //chart.draw(data, google.charts.Bar.convertOptions(options));
                    }*/

                    // PARA VER LOS DATOS AL DÍA



                    



                  }); // fin de getJson
                  // PARA PASAR EL NUMERO DE ORDENES RETRASADAS
                  var noRetrasadas = 0;
                    noRetrasadas = $("#noRetrasadas").val();
                   $(".indicaRetraso").text(noRetrasadas);

                   $('.kv-fa').rating({
                      theme: 'krajee-fa',
                      filledStar: '<i class="fa fa-money"></i>',
                      emptyStar: '<i class="fa fa-money"></i>'
                  });

                }// fin de la funcion


                



            }); // end ready

            $( window ).load(function() 
            {
              $(".loading").removeClass("efecto");
            });
            

            
        </script>
</body>

</html>