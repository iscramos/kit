<?php
    require_once('includes/config.inc.php');
    require_once(VIEW_PATH.'headerGeneral.inc.php');
    //include(VIEW_PATH.'indexMenu.php');
   
   if(isset($_REQUEST["consulta"]))
   {
      $consulta = $_REQUEST["consulta"];
      $atributo = $_REQUEST["atributo"];

      if($consulta == "DATA_ACTIVE")
      {
        $q = "SELECT ot, equipo, descripcion, fecha_informe, fecha_inicio_programada, fecha_finalizacion, estado 
              FROM disponibilidad_data
              WHERE equipo = '$atributo' 
              ORDER BY fecha_informe DESC LIMIT 10";

        //echo $q;
        $ots = Disponibilidad_data::getAllByQuery($q);
        //print_r($ots);
      }
   } 
 ?>
            
        <!-- page content -->
        <div class="" role="main" style="min-height: 800px !important;">
          
          <div class='container text-center'>
            <h3 class="text-center" > QR SCANNER</h3>
            
          </div>
          
            
          
          
          <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                  
              <div class="x_content">
                <!-- aqui va el contenido -->
                  
                    <?php
                    if($consulta != "" && $atributo != "")
                    {
                      
                      
                        echo "<table class='table table-condensed table-bordered table-striped table-hover dataTables-example dataTables_wrapper jambo_table bulk_action'>";
                          echo "<thead>";
                            echo "<tr>";
                              echo "<th class='text-center'>OT</th>";
                              echo "<th class='text-center'>EQUIPO</th>";
                              echo "<th class='text-center'>DESCRIPCION</th>";
                              echo "<th class='text-center'>ESTADO</th>";
                              echo "<th class='text-center'>F SOLICITADA</th>";
                              echo "<th class='text-center'>F PROGRAMADA</th>";
                              echo "<th class='text-center'>F TERMINO</th>";
                            echo "</tr>";
                          echo "</thead>";
                          echo "<tbody>";
                          foreach ($ots as $ot) 
                          {
                            echo "<tr>";
                              echo "<td class='text-left'>".$ot->ot."</td>";
                              echo "<td class='text-left'>".$ot->equipo."</td>";
                              echo "<td class='text-left'>".$ot->descripcion."</td>";
                              echo "<td>".$ot->estado."</td>";
                              echo "<td>".date("d/m/Y", strtotime($ot->fecha_informe))."</td>";
                              echo "<td>".date("d/m/Y", strtotime($ot->fecha_inicio_programada))."</td>";
                              echo "<td>".date("d/m/Y", strtotime($ot->fecha_finalizacion))."</td>";
                            echo "</tr>";
                          }
                          echo "</tbody>";
                        echo "</table>";
                      
                    }
                    else
                    {
                      echo "<div class='col-xs-12 col-sm-4 col-sm-offset-4 '>
                            <video autoplay controls loop width='600px' height='400px' src='".$url.$contentRead."qr_temporal/qr.mp4' ></video>
                          </div>";

                      echo "<div class='col-xs-12 col-sm-4 col-sm-offset-4 '>
                        <h1 style='color: black;'>404</h1>
                        <p>Faltan algunos parámetros</p>
                        <a class='btn btn-success' href='index.php'>Ir a inicio</a>


                      </div>";
                    }
                      
                    ?>
                    
                  </div>
              
                </div>
              </div>
            </div>
          
              
        </div>
 

 <?php require_once(VIEW_PATH.'footer.inc.php'); ?>
        <script type="text/javascript">
          $(document).ready(function()
            {
                $('.dataTables-example').DataTable(
                {
                responsive: true,
                paging: false,
                //"lengthMenu": [[20, 50, 100, -1], [20, 50, 100, "Todo"]], 
                "searching": false,
                /*"language":{
                    "oPaginate": {
                        "sNext" : "Siguiente",
                        "sPrevious": "Anterior"
                    },
                    "search": "Buscar ",
                    "sNext": "Siguiente",
                    "sPrevious": "Anterior",
                    "lengthMenu": "_MENU_ Registros por página",
                    "zeroRecords": "Nada encontrado",
                    "info": "Mostrando página _PAGE_ de _PAGES_",
                    "infoEmpty": "No registros disponibles",
                    "infoFiltered": "(filtrado de _MAX_ registros totales)"
                  }*/
                });

            }); // end ready
        </script>

  </body>
</html>




