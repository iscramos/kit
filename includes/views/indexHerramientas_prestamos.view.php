 <?php require_once(VIEW_PATH.'header.inc.php');
 ?>

            
          <!-- page content -->
        <div class="right_col" role="main">
            <div class="">
                <div class="page-title">
                    <div class="title_left">
                        <h3>Mis préstamos o devoluciones...</h3>
                    <?php 
                        if(isset($herramientas->id) )
                        {
                            
                            echo "<p>
                                    ".$herramientas->descripcion_almacen." <i class='fa fa-long-arrow-right fa-lg' aria-hidden='true'></i>  <strong><a class='btn btn-success btn-sm' title='Regresar' href='".$url."indexHerramientas_herramientas.php?id_almacen=".$herramientas->id_almacen."&id_categoria=".$herramientas->id_categoria."'>".$herramientas->categoria." </a></strong><i class='fa fa-angle-double-right fa-md' aria-hidden='true'></i> ".$herramientas->descripcion."</p>
                                    <input class='form-group hidden' id='id_almacen' value='".$herramientas->id_almacen."'>
                                    <input class='form-group hidden' id='id_categoria' value='".$herramientas->id_categoria."'>
                                    <input class='form-group hidden' id='id_herramienta' value='".$herramientas->id."'>";
                        }
                    ?>
                </div>
                    <div class="title_right ">
                        <div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search">
                          <div class="input-group pull-right">
                            <?php
                                if($ultimo_estado[0]->estatus == "" || $ultimo_estado[0]->estatus == 2)
                                {
                                    echo "<button type='button' class='btn btn-success btn-sm' title='Nuevo registro' id='agregar'>Nuevo
                            </button>";
                                }
                            ?>
                            
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
                                        <th>TRACK</th>
                                        <th>CODIGO</th>
                                        <th>NOMBRE</th>
                                        <th>FECHA PRESTAMO</th>
                                        <th>FECHA REGRESO</th>
                                        <th>ESTATUS</th>
                                        <th>OBSERVACION</th>
                                        <th>ACCION</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        //$i=1;
                                        //print_r($herramientas_herramientas);
                                        foreach ($herramientas_prestamos as $prestamos):
                                        {
                                            echo "<tr campoid='".$prestamos->id."'>";
                                                echo "<th width='5px' class='spec'>".$prestamos->id."</th>";
                                                echo "<td>".$prestamos->noAsociado."</td>";
                                                echo "<td>".$prestamos->nombre."</td>";
                                                //echo "<td>".$herramienta->categoria."</td>";
                                                echo "<td>".date("d-m-Y H:m:s", strtotime($prestamos->fecha_prestamo))."</td>";

                                                if($prestamos->fecha_regreso != NULL)
                                                {
                                                   echo "<td>".date("d-m-Y H:m:s", strtotime($prestamos->fecha_regreso))."</td>"; 
                                                }
                                                else
                                                {
                                                    echo "<td class='text-center'> - </td>"; 
                                                }

                                                if ($prestamos->estatus == 1) 
                                                {
                                                    echo "<td style='background: #f0ad4e; color:white;'>EN PRESTAMO</td>"; 
                                                }
                                                elseif($prestamos->estatus == 2)
                                                {   
                                                    echo "<td style='background: #169F85; color:white;'>DEVUELTO</td>";
                                                }


                                                echo "<td>".$prestamos->observacion."</td>";
                                               
                                               if($prestamos->estatus == 1)
                                                {
                                                   echo "<td>";
                                                    echo "<a type='button' class='btn btn-warning btn-sm optionEdit' valueEdit='".$prestamos->id."' title='Editar registro' >Editar</a>";
                                                    echo " <a type='button' class='btn btn-danger btn-sm' data-toggle='confirmation' data-singleton='true' data-placement='left' title='¿Eliminar registro?'>Eliminar</a>";
                                                    echo "</td>"; 
                                                }
                                                elseif($prestamos->estatus == 2)
                                                {
                                                   echo "<td class='text-center'> - </td>";  
                                                }
                                                
                                            echo "</tr>";

                                            //$i ++;
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
                  var id_herramienta = $("#id_herramienta").val();
                  window.location.href='deleteHerramienta_prestamo.php?id='+idR+'&id_herramienta='+id_herramienta;
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
                        "sPrevious": "Anterior",
                        
                    
                    },
                    "search": "Buscar ",
                    "sNext": "Siguiente",
                    "sPrevious": "Anterior",
                    "lengthMenu": "_MENU_ Registros por página",
                    "zeroRecords": "Nada encontrado",
                    "info": "Mostrando página _PAGE_ de _PAGES_",
                    "infoEmpty": "No registros disponibles",
                    "infoFiltered": "(filtrado de _MAX_ registros totales)",


                },
                "aaSorting": [[ 0, "desc" ]],
            });

            }); // end ready
        </script>
</body>

</html>