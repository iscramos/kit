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
                    <h1 class="page-header">Órdenes de trabajo</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
            	<div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading text-right">
                            <button type="button" class="btn btn-success btn-circle btn-md" title="Nuevo registro" id=""><i class="fa fa-plus"></i>
                            </button>
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="table-responsive">
                            <table  class="table table-striped table-bordered table-hover dataTables-example" style="font-size: 11px;">
                                <thead>
                                    <tr>
                                        <!--th>#</th-->
                                        <th>OT</th>
                                        <th>Descripción</th>
                                        <th>Equipo</th>
                                        <th>Tipo</th>
                                        <th>Estado</th>
                                        <th>Clase</th>
                                        <th>Departamento</th>
                                        <th>Solicitado</th>
                                        <th>Responsable</th>
                                        <th>Fecha informe</th>
                                        <th>Fecha inicio</th>
                                        <th>Fecha finalización</th>
                                        <th>Semana</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        $i=1;
                                        foreach ($ordenesots as $ordenesot):
                                        {
                                            $typeDescription = null;
                                            echo "<tr campoid={$ordenesot->id}>";
                                                /*echo "<th width='5px' class='spec'>$i</th>";*/
                                                echo "<td>".$ordenesot->orden_trabajo."</td>";
                                                echo "<td>".utf8_encode($ordenesot->descripcion)."</td>";
                                                echo "<td>".$ordenesot->equipo."</td>";
                                                echo "<td>".$ordenesot->tipo."</td>";
                                                echo "<td>".$ordenesot->estado."</td>";
                                                echo "<td>".$ordenesot->clase."</td>";
                                                echo "<td>".$ordenesot->departamento."</td>";
                                                echo "<td>".$ordenesot->solicitado."</td>";
                                                echo "<td>".$ordenesot->responsable."</td>";
                                                echo "<td>";
                                                        if($ordenesot->fecha_informe != null)
                                                            {
                                                                echo date(("d-m-Y"), strtotime($ordenesot->fecha_informe));
                                                            }
                                                echo "</td>";
                                                echo "<td>";
                                                        if($ordenesot->fecha_inicio != null)
                                                            {
                                                                echo date(("d-m-Y"), strtotime($ordenesot->fecha_inicio));
                                                            }
                                                echo "</td>";
                                                echo "<td>";
                                                        if($ordenesot->fecha_finalizacion != null)
                                                            {
                                                                echo date(("d-m-Y"), strtotime($ordenesot->fecha_finalizacion));
                                                            }
                                                echo "</td>";
                                                echo "<td>".$ordenesot->semana."</td>";
                                                /*echo "<td>";
                                                    echo "<a type='button' class='btn btn-warning btn-circle btn-md optionEdit' valueEdit='".$user->id."' title='Editar registro' ><i class='fa fa-pencil-square-o'></i></a>";
                                                    echo " <a type='button' class='btn btn-danger btn-circle btn-md' data-toggle='confirmation'  data-btn-ok-label='S&iacute;' data-btn-ok-icon='glyphicon glyphicon-share-alt' data-btn-ok-class='btn-danger' data-btn-cancel-label='No' data-btn-cancel-icon='glyphicon glyphicon-ban-circle' data-btn-cancel-class='btn-default'><span title='Eliminar registro'class='glyphicon glyphicon-remove' aria-hidden='true'></span></a>";
                                                echo "</td>";*/
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
		        <h4 class="modal-title" id="myModalLabel">Agregar / Modificar usuario</h4>
		      </div>
		      <div class="modal-body">
                <form name='frmtipo' class="form-horizontal" id="divdestino" method="post" action="<?php echo $url; ?>createUser.php">
		  
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
            //$('[data-toggle="tooltip"]').tooltip();
            /*$('[data-toggle="confirmation"]').confirmation(
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
                $("#agregar").on("click", function(event) 
                { 
                    event.preventDefault();
                    var v = 0;

                    ajaxCargaDatos("divdestino", v );
                
                });

                $(".optionEdit").on("click", function(event) 
                { 
                    event.preventDefault();
                    var v = 0;
                        v = $(this).attr("valueEdit");

                        console.log(v);

                    ajaxCargaDatos("divdestino", v );
                
                });

                $('.password').focus(function () 
                {
                   $('.password').attr('type', 'text'); 
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

                    ajax.open("GET", "updateUser.php?id="+uID, true);
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
                    $(this).html( "<input class='form-control input-sm' type='text' placeholder='Buscar "+title+"' >" );
                } );
                
             
                // DataTable
                var table = $('.dataTables-example').DataTable();
             
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