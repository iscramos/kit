<?php 
  require_once(VIEW_PATH.'header.inc.php');
  
    //include(VIEW_PATH.'indexMenu.php');
 ?>
 
  <!-- page content -->
  <div class="right_col" role="main">
    <!-- top tiles -->
    <div class="row tile_count">
      
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
        <span class="count_top"><i class="fa fa-folder-open"></i> Archivo de carga (activos.xlsx)</span>
        
          <form action="loadActivo.php" method="POST" enctype="multipart/form-data" class="form-inline">
             <div class='form-group'>
                  <div class='col-sm-10'>  
                      <input type='file' id='archivo' name='archivo' onChange='extensionCHK(this);' required>
                      <button type="submit" class="btn btn-success btn-xs"> <span class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></span> Cargar...</button>
                  </div>
              </div>
              
              
          </form>
  
      </div>


      
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
              if($actualizado == "@")
              {
                  echo "<audio controls autoplay class='hidden'>
                          <source src='".$url."content/base.ogg' type='audio/ogg'>
                        </audio>";
              }
            ?>
            
              
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
            alert("El archivo debe ser un activos.xlsx");
            
          }
        }
    </script>
          
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