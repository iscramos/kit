 <?php require_once(VIEW_PATH.'header.inc.php');
 ?>

        <!-- page content -->
        <div class="right_col" role="main">

            <!-- top tiles -->
            <div class="row tile_count text_right">

              <div class="col-md-6 col-sm-12 col-xs-12 tile_stats_count">
                <span class="count_top"><i class="fa fa-folder-open"></i> Archivo de carga (data.xlsx)</span>
                
                  <form name="importa" action="disponibilidad_importar.php" method="POST" enctype="multipart/form-data">
                     <div class='form-group'>
                          <div class='col-sm-12'>  
                              <input type='file' id='archivo' name='archivo' onChange='extensionCHK(this);' required>
                              <button type="submit" class="btn btn-success btn-xs"> <span class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></span> Cargar...</button>
                          </div>
                      </div>
                      
                      
                  </form>
          
              </div>
            </div>  
            <!-- /top tiles -->


            <div class="">
                

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
                                            
                                            <th>OT</th>
                                            <th>DESCRIPCION</th>
                                            <th>EQUIPO</th>
                                            <th>TIPO</th>
                                            <th>ESTADO</th>
                                            <th>CLASE</th>
                                            <th>RESPONSABLE</th>
                                            <th>TECNICO</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                            //$i=1;
                                            foreach ($disponibilidad_data as $data):
                                            {
                                                echo "<tr campoid='".$data->id."'>";
                                                    //echo "<th width='5px' class='spec'>$i</th>";
                                                    
                                                    echo "<td><a style='color:#2371AE;' href='".$url."indexOrden.php?ot=".$data->ot."'>".$data->ot."</a></td>";
                                                    echo "<td>".$data->descripcion."</td>";
                                                    echo "<td>".$data->equipo."</td>";
                                                    echo "<td>".$data->tipo."</td>";
                                                    echo "<td>".$data->estado."</td>";
                                                    echo "<td>".$data->clase."</td>";
                                                    echo "<td>".$data->responsable."</td>";
                                                    echo "<td>".$data->tecnico."</td>";
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
                <h4 class="modal-title" id="myModalLabel">Agregar / Modificar tiempo ideal</h4>
              </div>
              <div class="modal-body">
                <form name='frmtipo' class="form-horizontal" id="divdestino" method="post" action="<?php echo $url; ?>createMpIdeal.php">
          
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
                  var idR = $(this).parents("tr").attr("campoid");
                  window.location.href='deleteMpIdeal.php?id='+idR;
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

                    ajax.open("GET", "updateMpIdeal.php?id="+uID, true);
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


            function extensionCHK(campo)
            {
                var src = campo.value;
                var log = src.length;
                
                /*var pdf = log - 3;
                var wpdf = src.substring(pdf, log);
                    wpdf = wpdf.toUpperCase();*/

                // para .XLSX
                var xlsx = log - 4;
                var wsubc = src.substring(xlsx, log);
                    wsubc = wsubc.toUpperCase();
              
              //this.files[0].size gets the size of your file.
              var tamano = $("#archivo")[0].files[0].size;
              
              if (tamano > 2000000)
              {
                //alert('El archivo a subir debe ser menor a 1MB');
                $("#archivo").val("");
                alert("El archivo a subir debe ser menor a 2 MB");
              
              }

              else if(wsubc!='XLSX')
              {
                //alert('El archivo a subir debe ser una imagen JPG, o PDF');
                $("#archivo").val("");
                alert("El archivo a subir debe ser un .XLSX");
                
              }
              else
              {
                
                
              }
            }
        </script>
</body>

</html>