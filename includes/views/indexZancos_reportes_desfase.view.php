 <?php require_once(VIEW_PATH.'header.inc.php');
 ?>

            
         <!-- page content -->
        <div class="right_col" role="main">
            <div class="">
                <div class="page-title">
                    <div class="title_left">
                        <h3>Reportes (desfase)...</h3>
                    </div>
                    <div class="title_right ">
                        <!--div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search">
                          <div class="input-group pull-right">
                            <button type="button" class="btn btn-success btn-circle btn-sm" title="Nuevo registro" id="agregar">Nuevo
                            </button>
                          </div>
                        </div-->
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
		        <h4 class="modal-title" id="myModalLabel">Agregar / Modificar invernadero</h4>
		      </div>
		      <div class="modal-body">
                <form name='frmtipo' class="form-horizontal" id="divdestino" method="post" action="<?php echo $url; ?>createZancos_ghs.php">
		  
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

                    ajax.open("GET", "updateZancos_ghs.php?id="+uID, true);
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