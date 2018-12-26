<?php 
  require_once(VIEW_PATH.'header.inc.php');
  
    //include(VIEW_PATH.'indexMenu.php');
 ?>
 
  <!-- page content -->
  <div class="right_col" role="main">
    <!-- top tiles -->
    <div class="row tile_count">
      
    <!-- /top tiles -->

    <div class="row loading efecto">
      <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="dashboard_graph">

          <div class="row x_title">
            <div class="col-md-12">
              <h3>Responsables <small> activos asignados</small></h3>
            </div>
          </div>

          <div class="col-md-12 col-sm-12 col-xs-12">
            <!-- El contenido -->
                  <?php 
                    
                  
                    $direccion = $url.$content."/activos.json";
                    //echo $direccion;
                    $json_activos = file_get_contents($direccion);
                    $activos = json_decode($json_activos, true);
                    //echo $fechaInicio;
                  ?>
                    
              <div>
                  
                    <table class='table table-bordered table-condensed dataTables-example jambo_table bulk_action' style='font-size: 11px;'>
                      <thead >
                        <tr>
                          <th>ACTIVO</th>
                          <th>DESCRIPCION</th>
                          <th>RESPONSABLE</th>
                        </tr>
                      </thead>
                      <tbody>
                    <?php
                    foreach ($activos as $activo) 
                    {
                      echo "<tr >";
                        echo "<td>".$activo["equipo"]."</td>";
                        echo "<td>".$activo["descripcion"]."</td>";
                        echo "<td>".$activo["responsable"]."</td>";
                      echo "</tr >";
                        
                    } // fin del foreach 
                    ?>
                      </tbody>
                    </table>

                    
                          
              </div>

          </div>

          <!-- /.row -->
                              

          <div class="clearfix"></div>
        </div>
      </div>

    </div>
    <br />      

  </div>



 <?php require_once(VIEW_PATH.'footer.inc.php'); ?>
    

    
          
        <script type="text/javascript">
            
          

          $('.dataTables-example').DataTable({
                //responsive: true,
                "language":{
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
                }
            });
            

            
        </script>
</body>

</html>