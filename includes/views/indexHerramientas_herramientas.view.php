 <?php require_once(VIEW_PATH.'header.inc.php');
 ?>

          <!-- page content -->
        <div class="right_col" role="main">
            <div class="">
                <div class="page-title">
                    <div class="title_left">
                        <h3>Mis artículos...</h3>
                        
                    </div>
                    <div class="title_right ">
                        <div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search">
                          <div class="input-group pull-right">
                            <button type="button" class="btn btn-success btn-circle btn-sm" title="Nuevo registro" id="agregar">Nuevo
                            </button>
                          </div>
                        </div>
                    </div>

                </div>

                <div class="clearfix"></div>

                <div class="row">
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="x_panel">
                            <div class="x_title">
                                <h2><i class="fa fa-cogs"></i> Registros <small>en el sistema</small></h2>
                                <ul class="nav navbar-right panel_toolbox">
                                  <li>
                                    <a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                                  </li>
                                </ul>
                                <div class="clearfix"></div>
                            </div>
                            <div class="x_content">

                                <!-- aqui va el contenido -->
                                <table class="table table-condensed table-bordered table-striped table-hover dataTables-example dataTables_wrapper jambo_table bulk_action" >
                                    <thead>
                                        <tr> 
                                        <th>#</th>
                                        <th>Clave</th>
                                        <!--th>Categoría</th-->
                                        <th>Descripción</th>
                                        <th>Precio unitario</th>
                                        <th>Fecha de entrada</th>
                                        <th>Estatus</th>
                                        <th>Acción</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        $i=1;
                                        //print_r($herramientas_herramientas);
                                        foreach ($herramientas_herramientas as $herramienta):
                                        {
                                            //$prestamos = Herramientas_prestamos::getAllMaxHerramienta($herramienta->id);
                                            
                                            //print_r($prestamos);
                                            echo "<tr campoid='".$herramienta->id."' >";
                                                echo "<th width='5px' class='spec'>$i</th>";
                                                echo "<td>".$herramienta->clave."</td>";
                                                //echo "<td>".$herramienta->categoria."</td>";
                                                echo "<td>".$herramienta->descripcion."</td>";
                                                echo "<td>$ ".$herramienta->precio_unitario."</td>";
                                                echo "<td>".date("d-m-Y H:m:s", strtotime($herramienta->fecha_entrada))."</td>";


                                                
                                                    if($herramienta->estatus == "" || $herramienta->estatus == 2 )
                                                    {
                                                        echo "<td style='background: #169F85; color:white;'>EN ALMACEN</td>";
                                                    }
                                                    else if($herramienta->estatus == 1 )
                                                    {
                                                        echo "<td style='background: #f0ad4e; color:white;'>EN PRESTAMO</td>";
                                                    }
                                                
                                                
                                                echo "<td>";

                                                    echo " <a type='button' class='btn btn-warning btn-sm optionEdit' valueEdit='".$herramienta->id."' title='Editar registro' >Editar</a>";
                                                echo "</td>";
                                            echo "</tr>";

                                            $i ++;
                                        }
                                        endforeach;
                                    ?>
                                    </tbody>
                                </table>
                            
                            <!-- /.table-responsive -->
                            </div>
                        </div>
                    </div> <!-- fin class='' -->
                </div>
            <div class="clearfix"></div>
        </div>
    </div> 


  		<!-- Modal -->
		<div class="modal fade" id="modalAgregar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		  <div class="modal-dialog" role="document">
		    <div class="modal-content">
		      <div class="modal-header">
		        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		        <h4 class="modal-title" id="myModalLabel">Agregar / Modificar herramienta</h4>
		      </div>
		      <div class="modal-body">
                <form name='frmtipo' class="form-horizontal" id="divdestino" method="post" action="<?php echo $url; ?>createHerramientas_herramientas.php" enctype="multipart/form-data">
		  
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
            $('[data-toggle="tooltip"]').tooltip();
            $('[data-toggle="confirmation"]').confirmation(
            {
                title: '¿Eliminar?',
                btnOkLabel : '<i class="icon-ok-sign icon-white"></i> Si',
                      
                onConfirm: function(event) {
                  var idR = $(this).parents("tr").attr("campoid");
                  window.location.href='deleteUser.php?id='+idR;
                },
            });

            $(document).ready(function()
            {
                $("#agregar").on("click", function(event) 
                { 
                    event.preventDefault();
                    var v = 0;
                    var id_categoria = 0;
                    var id_almacen = 0;
                        id_categoria = $("#id_categoria").val();
                        id_almacen = $("#id_almacen").val();
                        //alert(id_categoria);

                    ajaxCargaDatos("divdestino", v, id_categoria, id_almacen);
                
                });

                $(".optionEdit").on("click", function(event) 
                { 
                    event.preventDefault();
                    var v = 0;
                        v = $(this).attr("valueEdit");

                    var id_categoria = 0;
                    var id_almacen = 0;
                        id_categoria = $("#id_categoria").val();
                        id_almacen = $("#id_almacen").val();

                        //console.log(v);

                    ajaxCargaDatos("divdestino", v, id_categoria, id_almacen);
                
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

                function ajaxCargaDatos(divdestino, uID, id_categoria, id_almacen)
                {
                    var ajax=creaAjax();

                    ajax.open("GET", "updateHerramientas_herramientas.php?id="+uID+"&id_categoria="+id_categoria+"&id_almacen="+id_almacen, true);
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

            }); // end ready
        </script>
</body>

</html>