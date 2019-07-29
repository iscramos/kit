<?php
    require_once('includes/config.inc.php');
    require_once(VIEW_PATH.'headerGeneral.inc.php');
    //include(VIEW_PATH.'indexMenu.php');
    

  $fecha_hoy = date("Y-m-d");
  
  $q = "SELECT m.*, zancos_tamanos.tamano AS tamano_descripcion, zancos_tamanos.limite_semana, zancos_bd.id AS id, zancos_acciones.accion AS accion_descripcion, zancos_acciones.id AS id_accion, m2.fecha_activacion_o_baja as f_activacion

      FROM zancos_movimientos m
      INNER JOIN
      (
          SELECT max(id_registro) reg, no_zanco, fecha_activacion_o_baja
          FROM zancos_movimientos
                
          GROUP BY no_zanco
      ) m2
        ON m.no_zanco = m2.no_zanco
        INNER JOIN zancos_acciones ON m.tipo_movimiento = zancos_acciones.id
        INNER JOIN zancos_tamanos ON m.tamano = zancos_tamanos.id
        INNER JOIN zancos_bd ON m.no_zanco = zancos_bd.no_zanco
        AND m.id_registro = m2.reg
              AND m.tipo_movimiento <> 2
        AND (DATEDIFF('$fecha_hoy', m2.fecha_activacion_o_baja) ) > (547.88)
        order by m.id_registro desc";
        
  $zancos_movimientos = Zancos_movimientos::getAllByQuery($q);

 ?>
  <style type="text/css">
    #graficaHistorica
    {
      padding: 10px;
    }
  </style>     
            
        <!-- page content -->
        <div class="" role="main" style="min-height: 800px !important;">
          
          <div class='container text-center'>
            <h3 class="text-center" > Zancos reporte (> 1.5 años)</h3>
            <?php
              include(VIEW_PATH.'indexMenu_public_zancos.php')
            ?>
          </div>
          
            
          
          
          <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                  
              <div class="x_content">
                <!-- aqui va el contenido -->
                <table class="table table-condensed table-bordered table-striped table-hover dataTables-example dataTables_wrapper jambo_table bulk_action" >
                    <thead>
                        <tr>
                        
                        <th>ZANCO</th>
                        <th>TAMAÑO</th>
                        <th>AÑOS</th>
                        <th>ÚLT. REG</th>
                        <th>ZONA</th>
                        <th>GH</th>
                        
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $i=1;
                        foreach ($zancos_movimientos as $m):
                        {
                           $ban = 0;
                           // aquí sacamos los años, para ver si son mayores a 1.5 años
                            $fechaHoy = date_create(date("Y-m-d"));
                            $f_activacion = date_create($m->f_activacion);

                                    $d_dias = date_diff($fechaHoy, $f_activacion);
                                    $d_dias = $d_dias->format('%a');
                                    $anos_limite = 1.5;
                                    $anos_convertidos = $d_dias / 365.25;
                                   // $anos_convertidos = round($anos_convertidos, 1);
                           
                           if($anos_convertidos > $anos_limite)
                            {
                                echo "<tr >";
                                    echo "<td >".$m->no_zanco."</td>";
                                    echo "<td>".$m->tamano_descripcion."</td>";
                                    echo "<td style='text-align:center; background:#C9302C; color: white;'>".round($anos_convertidos, 2)."</td>"; 
                                    echo "<td>".$m->id_registro."</td>";
                                    echo "<td>".$m->zona."</td>";
                                    echo "<td>".$m->gh."</td>";

                                            
                                       
                                    
                                    
                                   
                                echo "</tr>";
                            }

                            $i ++;
                        }
                            endforeach;
                        ?>
                    </tbody>
                </table>
            
            <!-- /.table-responsive -->
              
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
                //responsive: true,
                "lengthMenu": [[20, 50, 100, -1], [20, 50, 100, "Todo"]], 
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

                

            }); // end ready
        </script>

  </body>
</html>




