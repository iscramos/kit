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
                    <h1 class="page-header">Detalles de herramienta</h1>
                    <?php 
                        if(isset($herramientas->id) )
                        {
                            
                            echo "<p>
                                    <i class='fa fa-home fa-lg' aria-hidden='true'></i> ".$herramientas->descripcion_almacen." <i class='fa fa-long-arrow-right fa-lg' aria-hidden='true'></i>  <a href='".$url."indexHerramientas_herramientas.php?id_almacen=".$herramientas->id_almacen."&id_categoria=".$herramientas->id_categoria."'>".$herramientas->categoria." </a><i class='fa fa-angle-double-right fa-md' aria-hidden='true'></i> ".$herramientas->descripcion."</p>";
                        }
                    ?>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
            	<div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading text-right">
                            <button type="button" class="btn btn-success btn-circle btn-md" title="Nuevo registro" id="agregar"><i class="fa fa-plus"></i>
                            </button>
                            <input class="form-control hidden" type="number" name="id_herramienta" id="id_herramienta" value="<?php if(isset($herramientas->id)) echo $herramientas->id; ?>">
                           
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                        <div class="table-responsive">
                            <table width="100%" class="table table-striped table-bordered table-hover dataTables-example" >
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>No. asociado</th>
                                        <th>Fecha préstamo</th>
                                        <th>Fecha regreso</th>
                                        <th>Estatus</th>
                                        <th>Observación</th>
                                        <th>Acción</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        $i=1;
                                        //print_r($herramientas_herramientas);
                                        foreach ($herramientas_prestamos as $prestamos):
                                        {
                                            echo "<tr campoid={$prestamos->id}>";
                                                echo "<th width='5px' class='spec'>$i</th>";
                                                echo "<td>".$prestamos->noAsociado."</td>";
                                                //echo "<td>".$herramienta->categoria."</td>";
                                                echo "<td>".date("d-m-Y H:m:s", strtotime($prestamos->fecha_prestamo))."</td>";

                                                if($prestamos->fecha_regreso != NULL)
                                                {
                                                   echo "<td>".date("d-m-Y H:m:s", strtotime($prestamos->fecha_regreso))."</td>"; 
                                                }
                                                else
                                                {
                                                    echo "<td></td>"; 
                                                }

                                                if ($prestamos->estatus == 1) 
                                                {
                                                    echo "<td style='background: #f0ad4e; color:white;'>EN PRESTAMO</td>"; 
                                                }
                                                elseif($prestamos->estatus == 2)
                                                {                                           echo "<td>REGRESADO</td>"; 
                                                
                                                }
                                                echo "<td>".$prestamos->observacion."</td>";
                                               
                                                echo "<td>";
                                                    

                                                    /*echo " <a type='button' class='btn btn-warning btn-circle btn-md optionEdit' valueEdit='".$herramienta->id."' title='Editar registro' ><i class='fa fa-pencil-square-o'></i></a>";
                                                    echo " <a type='button' class='btn btn-danger btn-circle btn-md' data-toggle='confirmation' data-btn-ok-label='S&iacute;' data-btn-ok-icon='glyphicon glyphicon-share-alt' data-btn-ok-class='btn-danger' data-btn-cancel-label='No' data-btn-cancel-icon='glyphicon glyphicon-ban-circle' data-btn-cancel-class='btn-default'><span title='Eliminar registro'class='glyphicon glyphicon-remove' aria-hidden='true'></span></a>";*/
                                                   /* echo " <a class='btn btn-danger btn-circle btn-md' data-toggle='confirmation' data-singleton='true'  title='Eliminar registro'><i class='fa fa-times'></i></a>";*/
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
		  <div class="modal-dialog" role="document">
		    <div class="modal-content">
		      <div class="modal-header">
		        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		        <h4 class="modal-title" id="myModalLabel">Agregar / Modificar Préstamo</h4>
		      </div>
		      <div class="modal-body">
                <form name='frmtipo' class="form-horizontal" id="divdestino" method="post" action="<?php echo $url; ?>createHerramientas_prestamos.php">
		  
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
                    var id_herramienta = 0;
                        id_herramienta = $("#id_herramienta").val();

                    ajaxCargaDatos("divdestino", v, id_herramienta);
                
                });

                $(".optionEdit").on("click", function(event) 
                { 
                    event.preventDefault();
                    var v = 0;
                        v = $(this).attr("valueEdit");

                    var id_herramienta = 0;
                        id_herramienta = $("#id_herramienta").val();

                        //console.log(v);

                    ajaxCargaDatos("divdestino", v, id_herramienta);
                
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

                function ajaxCargaDatos(divdestino, uID, id_herramienta)
                {
                    var ajax=creaAjax();

                    ajax.open("GET", "updateHerramientas_prestamos.php?id="+uID+"&id_herramienta="+id_herramienta, true);
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