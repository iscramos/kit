 <?php require_once(VIEW_PATH.'header.inc.php');
 ?>

        <!-- page content -->
        <div class="right_col" role="main">
            <div class="">
                <div class="page-title">
                    <div class="title_left">
                        <h3>Invernaderos...</h3>
                    </div>
                    <div class="title_right ">
                        <div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search">
                          <div class="input-group pull-right">
                            <button type="button" class="btn btn-success btn-circle btn-sm" title="Nuevo registro" id="agregar"><i class="fa fa-plus"></i>
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
                                            <!--th>#</th-->
                                            <th>#</th>
                                            <th>INVERNADERO</th>
                                            <th>ZONA</th>
                                            <th>SURCOS</th>
                                            <th>METROS ESTANDAR</th>
                                            <th>METROS REALES</th>
                                            <th>SURCO REAL</th>
                                            <th>ACCION</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                            $i=1;
                                            foreach ($recursos_invernaderos as $inv):
                                            {
                                                echo "<tr campoid='".$inv->id."'>";
                                                    echo "<th width='5px' class='spec'>$i</th>";
                                                    echo "<td>".$inv->invernadero."</td>";
                                                    echo "<td>".$inv->zona."</td>";
                                                    echo "<td>".$inv->surcos."</td>";
                                                    echo "<td>".$inv->metros_lineales_estandar."</td>";
                                                    echo "<td>".$inv->metros_lineales_reales."</td>";
                                                    echo "<td>".$inv->surco_real."</td>";


                                                    echo "<td>";
                                                            echo "<a type='button' class='btn btn-warning btn-sm optionEdit' valueEdit='".$inv->id."' title='Editar registro' ><i class='fa fa-pencil-square-o'></i></a>";
                                                            /*echo " <a type='button' class='btn btn-danger btn-circle btn-sm' data-toggle='confirmation'
                                                            data-placement='left' data-btn-ok-label='S&iacute;' data-btn-ok-icon='glyphicon glyphicon-share-alt' data-btn-ok-class='btn-danger' data-btn-cancel-label='No' data-btn-cancel-icon='glyphicon glyphicon-ban-circle' data-btn-cancel-class='btn-default'><span title='Eliminar registro'class='glyphicon glyphicon-remove' aria-hidden='true'></span></a>";*/
                                                            echo " <a type='button' class='btn btn-danger btn-sm' data-toggle='confirmation' data-singleton='true' data-placement='left' title='¿Eliminar registro?'><i class='fa fa-times'></i></a>";
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
          <div class="modal-dialog " role="document">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Agregar / Modificar Invernadero</h4>
              </div>
              <div class="modal-body">
                <form name='frmtipo' class="form-horizontal" id="divdestino" method="post" action="<?php echo $url; ?>createRecursoInvernadero.php">
          
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
            
            $('[data-toggle="confirmation"]').confirmation(
            {

                title: '¿Eliminar?',
                btnOkLabel : '<i class="icon-ok-sign icon-white"></i> Si',
                      
                onConfirm: function(event) {
                    //event.preventDefault();
                  var id = $(this).parents("tr").attr("campoid");
                  window.location.href='deleteRecursoInvernadero.php?id='+id;
                },
            });

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

                    ajax.open("GET", "updateRecursoInvernadero.php?id="+uID, true);
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