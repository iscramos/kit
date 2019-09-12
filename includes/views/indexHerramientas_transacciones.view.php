 <?php require_once(VIEW_PATH.'header.inc.php');
 ?>

            
         <!-- page content -->
        <div class="right_col" role="main">
            <div class="">
                <div class="page-title">
                    <div class="title_left">
                        <h3>Despachos </h3>
                    </div>
                    <div class="title_right ">
                        <div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search">
                          <div class="input-group pull-right">
                           
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
                                        <th style="text-align: center;"># DESPACHO</th>
                                        <th style="text-align: center;">FECHA</th>
                                        <th style="text-align: center;">NOMBRE DEL ASOCIADO</th>

                                       
                                        <!--th style="text-align: center;">Fecha Act.<br> Baja</th-->
                                        <th style="text-align: center;">ARTICULOS</th>
                                        <!--th style="text-align: center;">TICKET</th-->
                                        <th style="text-align: center;">ACCION</th>
                                    </tr>
                                </thead>
                                <tbody >
                                    <?php
                                        //$i=1;
                                        foreach ($herramientas_transacciones as $transaccion):
                                        {
                                           
                                            echo "<tr campoid='".$transaccion->id_transaccion."'>";
                                                
                                                echo "<td style='color:red;'>".$transaccion->id_transaccion."</td>";
                                                echo "<td style='color:red;'>".date("d/m/Y", strtotime($transaccion->fecha))."</td>";
                                                echo "<td style=''>".$transaccion->nombre."</td>";
                                                echo "<td style='text-align:right;'>".$transaccion->articulos_totales."</td>";
                                                echo "<td style='text-align:center;'><a type='button' target='_blank' href='helperExport.php?codigo_asociado=".$transaccion->codigo_asociado."&parametro=ARTICULOS_ENTREGA&nombre=".$transaccion->nombre."' class='btn btn-primary btn-xs'  title='Ver ticket' > Imprimir <i class='fa fa-file-text-o' aria-hidden='true'></i> </a></td>";
                                                
                                                
                                                /*echo "<td>";

                                                    echo " <a type='button' href='indexHerramientas_movimientos_actualizar.php?action=EDIT&id_transaccion=$transaccion->id_transaccion' class='btn btn-warning btn-xs'  title='Editar registro' >Editar</a>";
                                                echo "</td>";*/
                                            echo "</tr>";

                                            //$i ++;
                                        }
                                            endforeach;
                                        ?>
                                    </tbody>
                                    <tfoot>
                                        <tr style="background: #ededed;">
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                        </tr>
                                    </tfoot>
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
                <h4 class="modal-title" id="myModalLabel">Agregar / Modificar zanco</h4>
              </div>
              <div class="modal-body">
                <form name='frmtipo' class="form-horizontal" id="divdestino" method="post" action="<?php echo $url; ?>createZancos_bd.php">
          
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

                    ajax.open("GET", "updateZancos_bd.php?id="+uID, true);
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

                

                $('.dataTables-example').DataTable( 
                {
                    initComplete: function () {
                        this.api().columns([0, 1, 2]).every( function () {
                            var column = this;
                            var select = $('<select class="form-control input-sm"><option value="">All</option></select>')
                                .appendTo( $(column.footer()).empty() )
                                .on( 'change', function () {
                                    var val = $.fn.dataTable.util.escapeRegex(
                                        $(this).val()
                                    );
             
                                    column
                                        .search( val ? '^'+val+'$' : '', true, false )
                                        .draw();
                                } );
             
                            column.data().unique().sort().each( function ( d, j ) {
                                select.append( '<option value="'+d+'">'+d+'</option>' )
                            } );
                        } );
                    },
                    "order": [[ 0, 'desc' ]],
                    //"ordering": true,
                    "processing": true,
                    //"serverSide": true,
                    "lengthMenu": [[15, 100, 100, -1], [15, 100, 200, "Todo"]], 
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
                } );                

            }); // end ready
        </script>
</body>

</html>