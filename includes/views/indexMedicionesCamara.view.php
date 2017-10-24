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
                    <h1 class="page-header">Medición de cámara fría</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
            	<div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading text-right">
                            <a href="helperExcel.php?parametro=MEDICIONES_CAMARA" type="button" class="btn btn-default btn-circle btn-md" title="Exportar registros a excel" ><i class="fa fa-download"></i>
                            </a>

                            <button type="button" class="btn btn-success btn-circle btn-md" title="Nuevo registro" id="agregar"><i class="fa fa-plus"></i>
                            </button>
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                        <div class="table-responsive">
                            <table width="100%" class="table table-striped table-bordered table-hover dataTables-example" >
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Fecha</th>
                                        <th>T. cam (vacía)</th>
                                        <th>T. cam (con tomate)</th>
                                        <th>Hr. cam (vacia)</th>
                                        <th>Hr. cam (Con tomate)</th>
                                        <th>T. tomate (entrada)</th>
                                        <th>T. tomate (salida)</th>
                                        <th>N. tarimas</th>
                                        <th>Puerta cerrada</th>
                                        <th>Lona bien ubicada</th>
                                        <th>Equipo 7.5 encendido</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        $i=1;
                                       // print_r($camaras);
                                        foreach ($camaras as $camara):
                                        {
                                           
                                            echo "<tr campoid={$camara->id}>";
                                                echo "<th width='5px' class='spec'>$i</th>";
                                                echo "<td>".date("d-M-Y H:m:s", strtotime($camara->fecha_medicion))."</td>";
                                                echo "<td>".$camara->temp_vacia."</td>";
                                                echo "<td>".$camara->temp_con_tomate."</td>";
                                                echo "<td>".$camara->hr_vacia."</td>";
                                                echo "<td>".$camara->hr_con_tomate."</td>";
                                                echo "<td>".$camara->temp_tomate_entrada."</td>";
                                                echo "<td>".$camara->temp_tomate_salida."</td>";
                                                echo "<td>".$camara->num_tarimas."</td>";

                                                if($camara->puerta_cerrada == 1)
                                                {
                                                    echo "<td style='background-color: #5cb85c; color:white;'>SI</td>";
                                                }
                                                elseif($camara->puerta_cerrada == 2)
                                                {
                                                    echo "<td style='background-color: #d9534f; color:white;'>NO</td>";
                                                }

                                                if($camara->lona_bien_ubicada == 1)
                                                {
                                                    echo "<td style='background-color: #5cb85c; color:white;'>SI</td>";
                                                }
                                                elseif($camara->lona_bien_ubicada == 2)
                                                {
                                                    echo "<td style='background-color: #d9534f; color:white;'>NO</td>";
                                                }

                                                if($camara->e_75_encendido == 1)
                                                {
                                                    echo "<td style='background-color: #5cb85c; color:white;'>SI</td>";
                                                }
                                                elseif($camara->e_75_encendido == 2)
                                                {
                                                    echo "<td style='background-color: #d9534f; color:white;'>NO</td>";
                                                }

                                               
                                                
                                                /*echo "<td>";
                                                    echo "<a href='".$url."indexHerramientas_herramientas.php?id_categoria=".$categoria->id."&id_almacen=".$categoria->id_almacen."' type='button' class='btn btn-primary btn-circle btn-md' title='Generar entrada' ><i class='fa fa-cart-plus'></i></a>";

                                                    echo " <a type='button' class='btn btn-warning btn-circle btn-md optionEdit' valueEdit='".$categoria->id."' title='Editar registro' ><i class='fa fa-pencil-square-o'></i></a>";
                                                    /*echo " <a type='button' class='btn btn-danger btn-circle btn-md' data-toggle='confirmation' data-btn-ok-label='S&iacute;' data-btn-ok-icon='glyphicon glyphicon-share-alt' data-btn-ok-class='btn-danger' data-btn-cancel-label='No' data-btn-cancel-icon='glyphicon glyphicon-ban-circle' data-btn-cancel-class='btn-default'><span title='Eliminar registro'class='glyphicon glyphicon-remove' aria-hidden='true'></span></a>";
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
		        <h4 class="modal-title" id="myModalLabel">Agregar medición de cámara fría</h4>
		      </div>
		      <div class="modal-body">
                <form name='frmtipo' class="form-horizontal" id="divdestino" method="post" action="<?php echo $url; ?>createMedicionesCamara.php">
		  
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
                $('#datetimepicker1').datetimepicker();
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

                    ajax.open("GET", "updateMedicionesCamara.php?id="+uID, true);
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