 <?php require_once(VIEW_PATH.'header.inc.php');
    include(VIEW_PATH.'indexMenu.php');
 ?>

            
            <!-- /.navbar-static-side -->
        </nav>

        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <br>
                    <button class="btn btn-primary btn-md expandir" title="Expandir"> <i class="fa fa-expand" aria-hidden="true"></i> </button>

                    <button class="btn btn-primary btn-md contraer hidden" title="Contraer"> <i class="fa fa-compress" aria-hidden="true"></i> </button>
                    <h1 class="page-header">Inventario de materiales</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
            	<div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading text-right">
                            <a href="helperExcel.php?parametro=INVENTARIO_MATERIALES" type="button" class="btn btn-default btn-circle btn-md" title="Exportar registros a excel" ><i class="fa fa-download"></i>
                            </a>

                            <button type="button" class="btn btn-success btn-circle btn-md" title="Nuevo registro" id="agregar_"><i class="fa fa-plus"></i>
                            </button>
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="panel panel-default">
                              <div class="panel-body">
                              <form class="form-inline" style="font-size: 12px;">
                                  <div class="form-group">
                                    <label >Costo total <i class="fa fa-usd" aria-hidden="true"></i></label>
                                    <input style="background: #337ab7 !important; color: white !important;" class="form-control" type="text" name="costoIdeal" id="costoIdeal" value="" readonly>
                                  </div>
                                  <div class="form-group">
                                    <label >Costo real <i class="fa fa-usd" aria-hidden="true"></i></label>
                                    <input style="background: #5cb85c !important; color: white !important;" class="form-control" type="text" name="costoReal" id="costoReal" value="" readonly>
                                  </div>

                                  <div class="form-group">
                                    <label >Disponibilidad <i class="fa fa-percent" aria-hidden="true"></i></label>
                                    <input class="form-control" type="text" name="porcentajeDisponibilidad" id="porcentajeDisponibilidad" value="0.00" readonly>
                                  </div>
                                  
                                </form>
                              </div>
                            </div>
                        <div class="table-responsive">
                            <table width="100%" class="table table-striped table-bordered table-hover dataTables-example" style="font-size: 11px;">
                                <thead>
                                    <tr>
                                        <!--th>#</th-->
                                        <th>Código</th>
                                        <th>Descripción</th>
                                        <th>Clase</th>
                                        <th>Unidad</th>
                                        <th>Mín</th>
                                        <th>Máx</th>
                                        <th>Stock</th>
                                        <th>P/U ($)</th>
                                        <th>Total ($)</th>
                                        <th>Estatus</th>
                                        <th>% disponibilidad</th>
                                        <th>Acción</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        $i=1;
                                       // print_r($camaras);
                                        $sumaPorcentajes = 0;
                                        $costoRealStock = 0;
                                        $costoTotalMaximos = 0;
                                        foreach ($almacen as $a):
                                        {
                                            $subtotalStock = 0;
                                            $subtotalMaximo = 0;
                                           
                                            echo "<tr campoid={$a->id}>";
                                                //echo "<th width='5px' class='spec'>$i</th>";
                                                echo "<td>".$a->codigo."</td>";
                                                echo "<td>".utf8_encode($a->descripcion)."</td>";
                                                echo "<td>".$a->clase."</td>";
                                                echo "<td>".$a->unidad."</td>";
                                                echo "<td>".$a->cantidad_minima."</td>";
                                                echo "<td>".$a->cantidad_maxima."</td>";

                                                if($a->stock > $a->cantidad_maxima)
                                                {
                                                    echo "<td style='text-align:right; background:#337ab7; color:white;'>".$a->stock."</td>";
                                                }
                                                elseif($a->stock >= $a->cantidad_minima && $a->stock <= $a->cantidad_maxima)
                                                {
                                                    echo "<td style='text-align:right; background:#5cb85c; color:white;'>".$a->stock."</td>";
                                                }
                                                elseif($a->stock < $a->cantidad_minima)
                                                {
                                                    if($a->stock <= 2)
                                                    {
                                                        echo "<td style='text-align:right; background:#d9534f; color:white;'>".$a->stock."</td>";
                                                    }
                                                    else
                                                    {
                                                        echo "<td style='text-align:right; background:#f0ad4e; color:white;'>".$a->stock."</td>";
                                                    }
                                                    
                                                }
                                                $totalTemporal = 0.00;
                                                $totalTemporal = ($a->precio_unitario) * ($a->stock);

                                                // para obtener la suma de los costos totales
                                                $subtotalStock = ($a->precio_unitario) * ($a->stock);
                                                $subtotalMaximo = ($a->precio_unitario) * ($a->cantidad_maxima);

                                                $costoRealStock = $costoRealStock + $subtotalStock;
                                                $costoTotalMaximos = $costoTotalMaximos + $subtotalMaximo;
                                                // ------------------------------------------

                                                echo "<td>".$a->precio_unitario."</td>";
                                                echo "<td>".$totalTemporal."</td>";

                                                if($a->estatus ==  1)
                                                {
                                                    echo "<td style='text-align:center;'><i class='fa fa-check' aria-hidden='true' style='color:green;'></i></td>";
                                                }
                                                else
                                                {
                                                    echo "<td style='text-align:center;'><i class='fa fa-times' aria-hidden='true' style='color:red;'></i></td>";
                                                }

                                                $porcentajeDisponible = (100 * $a->stock) / $a->cantidad_maxima; 
                                                $porcentajeDisponible = round($porcentajeDisponible, 1);

                                                if($porcentajeDisponible >= 60)
                                                {
                                                    if($porcentajeDisponible > 100)
                                                    {
                                                        $porcentajeDisponible = 100;
                                                    }
                                                    echo "<td>
                                                        <div class='progress '>
                                                          <div class='progress-bar progress-bar-success progress-bar-striped' role='progressbar' aria-valuenow='".$porcentajeDisponible."' aria-valuemin='0' aria-valuemax='100' style='width: ".$porcentajeDisponible."%;'>
                                                            ".$porcentajeDisponible."%
                                                          </div>
                                                        </div>
                                                    </td>";
                                                }
                                                elseif ($porcentajeDisponible >= 20 && $porcentajeDisponible <= 59) 
                                                {
                                                    echo "<td>
                                                        <div class='progress'>
                                                          <div class='progress-bar progress-bar-warning progress-bar-striped' role='progressbar' aria-valuenow='".$porcentajeDisponible."' aria-valuemin='0' aria-valuemax='100' style='width: ".$porcentajeDisponible."%;'>
                                                            ".$porcentajeDisponible."%
                                                          </div>
                                                        </div>
                                                    </td>";
                                                }
                                                elseif ($porcentajeDisponible >= 0 && $porcentajeDisponible <= 19) 
                                                {
                                                    echo "<td>
                                                        <div class='progress'>
                                                          <div class='progress-bar progress-bar-danger progress-bar-striped' role='progressbar' aria-valuenow='".$porcentajeDisponible."' aria-valuemin='0' aria-valuemax='100' style='width: ".$porcentajeDisponible."%;'>
                                                            ".$porcentajeDisponible."%
                                                          </div>
                                                        </div>
                                                    </td>";
                                                }

                                                $sumaPorcentajes = $sumaPorcentajes + $porcentajeDisponible;
                                               

                                               
                                                
                                                echo "<td>";

                                                    echo " <a type='button' class='btn btn-warning btn-circle btn-md optionEdit' valueEdit='".$a->id."' title='Editar registro' ><i class='fa fa-pencil-square-o'></i></a>";
                                                    /*echo " <a type='button' class='btn btn-danger btn-circle btn-md' data-toggle='confirmation' data-btn-ok-label='S&iacute;' data-btn-ok-icon='glyphicon glyphicon-share-alt' data-btn-ok-class='btn-danger' data-btn-cancel-label='No' data-btn-cancel-icon='glyphicon glyphicon-ban-circle' data-btn-cancel-class='btn-default'><span title='Eliminar registro'class='glyphicon glyphicon-remove' aria-hidden='true'></span></a>";
                                                   /* echo " <a class='btn btn-danger btn-circle btn-md' data-toggle='confirmation' data-singleton='true'  title='Eliminar registro'><i class='fa fa-times'></i></a>";*/
                                                echo "</td>";
                                            echo "</tr>";

                                            $i ++;
                                        }
                                        endforeach;
                                        $vDisponibilidad = round($sumaPorcentajes / $i, 1);

                                        //echo "costo total stock = ".$costoRealStock."<br>";
                                        //echo "costo total maximos = ".$costoTotalMaximos."<br>";
                                        
                                    ?>
                                </tbody>
                            </table>

                            <input type="text" class="form-control hidden" id="vDisponibilidad" value="<?php echo $vDisponibilidad; ?>">
                            <input type="text" class="form-control hidden" id="costoRealStock" value="<?php echo $costoRealStock; ?>">
                            <input type="text" class="form-control hidden" id="costoTotalMaximos" value="<?php echo $costoTotalMaximos; ?>">
                            <!-- /.table-responsive -->
                            </div>
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            
        </div>
        <!-- /#page-wrapper -->


  		<!-- Modal -->
		<div class="modal fade" id="modalAgregar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		  <div class="modal-dialog modal-lg" role="document">
		    <div class="modal-content">
		      <div class="modal-header">
		        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		        <h4 class="modal-title" id="myModalLabel">Agregar / editar material</h4>
		      </div>
		      <div class="modal-body">
                <form name='frmtipo' class="form-horizontal" id="divdestino" method="post" action="<?php echo $url; ?>createAlmacen.php">
		  
		      </div>
		      <div class="modal-footer">
		        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
		        <button type="submit" class="btn btn-primary">Guardar</button>
		      </div>
                </form>
		    </div>
		  </div>
		</div>



 <?php require_once(VIEW_PATH.'footer.inc.php'); ?>

        <script type="text/javascript">
            /*$('[data-toggle="tooltip"]').tooltip();
            $('[data-toggle="confirmation"]').confirmation(
            {
                title: '¿Eliminar?',
                btnOkLabel : '<i class="icon-ok-sign icon-white"></i> Si',
                      
                onConfirm: function(event) {
                  var idR = $(this).parents("tr").attr("campoid");
                  window.location.href='deleteUser.php?id='+idR;
                },
            });*/

            $(document).ready(function()
            {
                var vDisponibilidad = 0;
                    vDisponibilidad = $("#vDisponibilidad").val();
                $("#porcentajeDisponibilidad").val(vDisponibilidad);

                var costoRealStock = 0;
                    costoRealStock = $("#costoRealStock").val();
                $("#costoReal").val(costoRealStock);

                var costoTotalMaximos = 0;
                    costoTotalMaximos = $("#costoTotalMaximos").val();
                $("#costoIdeal").val(costoTotalMaximos);costoTotalMaximos


                $('#datetimepicker1').datetimepicker();
                /*$("#agregar").on("click", function(event) 
                { 
                    event.preventDefault();
                    var v = 0;

                    ajaxCargaDatos("divdestino", v );
                
                });*/

                $(".optionEdit").on("click", function(event) 
                { 
                    event.preventDefault();
                    var v = 0;
                        v = $(this).attr("valueEdit");

                        console.log(v);

                    ajaxCargaDatos("divdestino", v );
                
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

                    ajax.open("GET", "updateAlmacen.php?id="+uID, true);
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
                            $("#modalAgregar").modal("show");
                
                        } 
                    }
                    ajax.send(null);
                }

                $('.dataTables-example thead th').each( function () 
                {
                    var title = $('.dataTables-example thead th').eq( $(this).index() ).text();
                    if(title != "Unidad" && title != "Clase" && title != "Mín" && title != "Máx" && title != "Stock" && title != "P/U ($)" && title != "Total ($)" && title != "Estatus" && title != "% disponibilidad" && title != "Acción")
                    {
                        $(this).html( "<input class='form-control input-sm' type='text' placeholder='Buscar "+title+"' >" );
                    }
                   
                    

                } );
                
             
                // DataTable
                /*var table = $('.dataTables-example').DataTable();
             
                // Apply the search
                table.columns().eq( 0 ).each( function ( colIdx ) {
                    $( 'input', table.column( colIdx ).header() ).on( 'keyup change', function () {
                        table
                            .column( colIdx )
                            .search( this.value )
                            .draw();
                    } );

                    $('input', table.column(colIdx).header()).on('click', function(e)
                    {
                        e.stopPropagation();
                    });
                } );*/
                 var table = $('.dataTables-example').DataTable({
                //responsive: true,
                "aDisplayLength": 100,
                    "aLengthMenu": [[100, -1], [100, "Todo"]],
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

                 // Apply the search
                table.columns().eq( 0 ).each( function ( colIdx ) {
                    $( 'input', table.column( colIdx ).header() ).on( 'keyup change', function () {
                        table
                            .column( colIdx )
                            .search( this.value )
                            .draw();
                    } );

                    $('input', table.column(colIdx).header()).on('click', function(e)
                    {
                        e.stopPropagation();
                    });
                } );
                /*$('.dataTables-example').DataTable({
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
                });*/



            }); // end ready
        </script>
</body>

</html>