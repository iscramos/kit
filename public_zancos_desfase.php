<?php
    require_once('includes/config.inc.php');
    require_once(VIEW_PATH.'headerGeneral.inc.php');
    //include(VIEW_PATH.'indexMenu.php');
    

    $fecha_hoy = date("Y-m-d");
    
    $q = "SELECT m.*, zancos_tamanos.tamano AS tamano_descripcion

        FROM zancos_movimientos m
        INNER JOIN
        (
            SELECT max(id_registro) reg, no_zanco, fecha_salida
            FROM zancos_movimientos
            GROUP BY no_zanco
        ) m2
          ON m.no_zanco = m2.no_zanco
          INNER JOIN zancos_tamanos ON m.tamano = zancos_tamanos.id
          AND m.id_registro = m2.reg
          AND m.tipo_movimiento = 3
          AND m.fecha_entrega = 0
          AND (DATEDIFF('$fecha_hoy', m.fecha_salida) ) > (m.tiempo_limite * 7)
        order by m.no_zanco ASC";
          
    $zancos_movimientos = Zancos_movimientos::getAllByQuery($q);
 ?>
      
            
        <!-- page content -->
        <div class="" role="main" >
          
          <div class='container text-center'>
            <h3 class="text-center" > Zancos reporte (desfase)</h3>
            <?php
              include(VIEW_PATH.'indexMenu_public_zancos.php')
            ?> 
          </div>
          
            
          
          
            <div class="col-md-12 col-sm-12 col-xs-12">
                <a class=" pull-right" title="Descargar registros" style="margin-bottom: 5px; " href="helperExcel_personalizado.php?parametro=ZANCOS_DESFASE" target="_BLANK"><img src="dist/img/excel.png" width="24px"></a>
                
              <div class="x_panel">
                        
                <div class="x_content">

                <!-- aqui va el contenido -->
                <table class="table table-condensed table-bordered table-striped table-hover dataTables-example dataTables_wrapper jambo_table bulk_action" >
                    <thead>
                        <tr>
                        
                        <th>ZANCO</th>
                        <th>TAMAÑO</th>
                        <th>DESFASE <br> SEMANAS</th>
                        <th>ÚLTIMO <br> REGISTRO</th>
                        <th>ZONA <br> ACTUAL</th>
                        <th>GH <br> ACTUAL</th>
                        
                        <th>FECHA <br> SALIDA</th>
                        <th>DATOS DE ASOCIADO</th>
                        
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
                            $fecha_salida = date_create($m->fecha_salida);

                                    $d_dias = date_diff($fechaHoy, $fecha_salida);
                                    $d_dias = $d_dias->format('%a');
                                    $semanas_limite = $m->tiempo_limite;
                                    $semanas_convertidas = $d_dias / 7;
                                    $semanas_convertidas = round($semanas_convertidas, 2);
                           
                           /*if($semanas_convertidas > $semanas_limite)
                            {*/
                                $diferencia_semanas = $semanas_convertidas - $semanas_limite;

                                echo "<tr >";
                                    echo "<td >".$m->no_zanco."</td>";
                                    echo "<td>".$m->tamano_descripcion."</td>";
                                    echo "<td style='text-align:center; background:#C9302C; color: white;'>".$diferencia_semanas."</td>"; 
                                    echo "<td>".$m->id_registro."</td>";
                                    echo "<td>".$m->zona."</td>";
                                    echo "<td>".$m->gh."</td>";

                                            
                                       
                                    
                                    if($m->fecha_salida > 0)
                                    {
                                        echo "<td style='text-align: center;'>".date("d-m-Y", strtotime($m->fecha_salida))."</td>";   
                                    }
                                    else
                                    {
                                        echo "<td style='text-align: center;'> - </td>";
                                    }

                                    echo "<td> (".$m->ns_salida_lider.") ".utf8_encode($m->nombre_lider_salida)."</td>";
                                   
                                echo "</tr>";
                            //}

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




