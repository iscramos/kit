 <?php require_once(VIEW_PATH.'header.inc.php');
 ?>
    <style type="text/css">
        @-webkit-keyframes invalid 
        {
            from { background-color: #C82333; }
            to { background-color: inherit; }
        }
        @-moz-keyframes invalid 
        {
            from { background-color: #C82333; }
            to { background-color: inherit; }
        }
        @-o-keyframes invalid 
        {
          from { background-color: #C82333; }
          to { background-color: inherit; }
        }
        @keyframes invalid 
        {
          from { background-color: #C82333; }
          to { background-color: inherit; }
        }
        
        .invalid
        {
          -webkit-animation: invalid 1s infinite; /* Safari 4+ */
          -moz-animation:    invalid 1s infinite; /* Fx 5+ */
          -o-animation:      invalid 1s infinite; /* Opera 12+ */
          animation:         invalid 1s infinite; /* IE 10+ */
        }
    </style>
            
         <!-- page content -->
        <div class="right_col" role="main">
            <div class="">
                <div class="page-title">
                    <div class="title_left">
                        <h3>Zancos (BD)...</h3>
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
                                        
                                        <th>NO</th>
                                        <th style="text-align: center;">Tamaño</th>
                                        <th style='text-align: center;  border-right: 1px dashed;'>Límite <br> WK</th>
                                        <th style="text-align: center;">Último <br> Registro</th>
                                        <th style="text-align: center;">Gh <br> Actual</th>
                                        <th style="text-align: center;">Zona <br> Actual</th>
                                        <th style="text-align: center;">Activación <br> Registro</th>
                                        <th style="text-align: center;">Fecha Act.<br> Registro</th>
                                        <th style="text-align: center;">Años <br> vida</th>
                                        <th style="text-align: center;">WK <br> Desfase</th>
                                        <th style="text-align: center;">Último <br> Movimiento</th>
                                        <th style="text-align: center;">Fecha <br> Salida</th>
                                        <th style="text-align: center;">Fecha <br> Regreso</th>
                                        <th style="text-align: center;">Fecha <br> Servicio</th>
                                        <th style="text-align: center;">Estatus</th>
                                        <th style="text-align: center;">Acción</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        //$i=1;
                                        foreach ($zancos_bd as $bd):
                                        {
                                           
                                            echo "<tr campoid='".$bd->id."'>";
                                                echo "<th style='text-align: right;'>".$bd->no_zanco."</th>";
                                                echo "<td style='text-align: center;'>".$bd->tamano_descripcion."</td>";
                                                echo "<td style='text-align: center; color:red; border-right: 1px dashed;'>".$bd->limite_semana."</td>";
                                                echo "<td style='text-align:center;'>".$bd->id_registro."</td>";
                                                echo "<td style='text-align: center;'>".$bd->gh."</td>";
                                                echo "<td style='text-align: center;'>".$bd->zona."</td>";
                                                echo "<td style='text-align: center;'>".$bd->id_reg_activacion."</td>";
                                                echo "<td style='text-align: center;'>".date("d-m-Y", strtotime($bd->f_activacion))."</td>";

                                                $fechaHoy = date_create(date("Y-m-d"));
                                                $f_activacion = date_create($bd->f_activacion);

                                                    $d_dias = date_diff($fechaHoy, $f_activacion);
                                                    $d_dias = $d_dias->format('%a');
                                                    
                                                    $anos_convertidos = $d_dias / 365.25;
                                                    $anos_convertidos = round($anos_convertidos, 1);

                                                if($anos_convertidos > 1.5)
                                                {
                                                    echo "<td style='text-align: center;' >".$anos_convertidos."</td>";
                                                }
                                                else
                                                {
                                                    echo "<td style='text-align: center;' >".$anos_convertidos."</td>";
                                                }
                                                
                                                

                                                if( ($bd->id_accion == 1) || ($bd->id_accion == 2) )
                                                {
                                                    echo "<td style='text-align:center; '> - </td>";
                                                } 
                                                else
                                                {
                                                    $fecha_salida = date_create($bd->fecha_salida);

                                                    $d_dias = date_diff($fechaHoy, $fecha_salida);
                                                    $d_dias = $d_dias->format('%a');
                                                    $semanas_limite = $bd->limite_semana;
                                                    $semanas_convertidas = $d_dias / 7;
                                                    $semanas_convertidas = round($semanas_convertidas, 2);

                                                    if( ($semanas_convertidas > $semanas_limite) && ($bd->fecha_entrega == 0) )
                                                    {
                                                        $temporal_diferencia = $semanas_convertidas - $semanas_limite;
                                                        echo "<td>".$temporal_diferencia."</td>";
                                                    }
                                                    else
                                                    {
                                                        echo "<td style='text-align: center;'> - </td>";
                                                    }
                                                }
                                                
                                                echo "<td>".$bd->accion_descripcion."</td>";


                                                if($bd->id_accion == 1) // alta
                                                {
                                                    echo "<td style='text-align: center;'> - </td>";
                                                    echo "<td style='text-align: center;'> - </td>";
                                                    echo "<td style='text-align: center;'> - </td>";
                                                    echo "<td style='text-align: center; background: #218838; color: white;' > ACTIVACION </td>";
                                                }
                                                elseif($bd->id_accion == 2) // baja
                                                {
                                                    echo "<td style='text-align: center;'> - </td>";
                                                    echo "<td style='text-align: center;'> - </td>";
                                                    echo "<td style='text-align: center;'> - </td>";
                                                    echo "<td style='text-align: center; background: #563D7C; color: white;'> BAJA </td>";
                                                }
                                                elseif($bd->id_accion == 3) // disposicion
                                                {
                                                    if( ($bd->fecha_salida > 0)  && ($bd->fecha_entrega == 0) && ($bd->fecha_servicio == 0))
                                                    {
                                                        echo "<td style='text-align: center;'>".date("d-m-Y", strtotime($bd->fecha_salida))."</td>";
                                                        echo "<td style='text-align: center;'> - </td>";
                                                        echo "<td style='text-align: center;'> - </td>";
                                                        echo "<td style='text-align: center; background: #E0A800; color: black;'> CAMPO </td>";
                                                    }
                                                    
                                                    else if( ($bd->fecha_salida > 0)  && ($bd->fecha_entrega > 0) && ($bd->fecha_servicio == 0))
                                                    {
                                                        echo "<td style='text-align: center;'>".date("d-m-Y", strtotime($bd->fecha_salida))."</td>";
                                                        echo "<td style='text-align: center;'>".date("d-m-Y", strtotime($bd->fecha_entrega))."</td>";
                                                        echo "<td style='text-align: center;'> - </td>";
                                                        echo "<td style='text-align:center; background: #0069D9; color: white;'>SERVICIO</td>";
                                                    }

                                                    else if( ($bd->fecha_salida > 0)  && ($bd->fecha_entrega > 0) && ($bd->fecha_servicio > 0))
                                                    {
                                                        echo "<td style='text-align: center;'>".date("d-m-Y", strtotime($bd->fecha_salida))."</td>";
                                                        echo "<td style='text-align: center;'>".date("d-m-Y", strtotime($bd->fecha_entrega))."</td>";
                                                        echo "<td style='text-align: center;'>".date("d-m-Y", strtotime($bd->fecha_servicio))."</td>";
                                                        echo "<td style='text-align:center; background: #218838; color: white;'>DISPONIBLE</td>";
                                                    }
                                                }
                                                

                                                
                                                echo "<td>";

                                                    echo " <a type='button' class='btn btn-warning btn-sm optionEdit' valueEdit='".$bd->id."' title='Editar registro' >Editar</a>";
                                                    /*echo " <a type='button' class='btn btn-danger btn-circle btn-md' data-toggle='confirmation' data-btn-ok-label='S&iacute;' data-btn-ok-icon='glyphicon glyphicon-share-alt' data-btn-ok-class='btn-danger' data-btn-cancel-label='No' data-btn-cancel-icon='glyphicon glyphicon-ban-circle' data-btn-cancel-class='btn-default'><span title='Eliminar registro'class='glyphicon glyphicon-remove' aria-hidden='true'></span></a>";
                                                   /* echo " <a class='btn btn-danger btn-circle btn-md' data-toggle='confirmation' data-singleton='true'  title='Eliminar registro'><i class='fa fa-times'></i></a>";*/
                                                echo "</td>";
                                            echo "</tr>";

                                            //$i ++;
                                        }
                                            endforeach;

                                        foreach ($zancos_stock as $stock):
                                        {
                                           
                                            echo "<tr campoid='".$stock->id."'>";
                                                echo "<th style='text-align: right;'>".$stock->no_zanco."</th>";
                                                echo "<td style='text-align: center;'>".$stock->tamano_descripcion."</td>";
                                                echo "<td style='text-align: center; color:red; border-right: 1px dashed;'>".$stock->limite_semana."</td>";
                                                echo "<td style='text-align:center;'> - </td>";
                                                echo "<td style='text-align:center;'> - </td>";
                                                echo "<td style='text-align:center;'> - </td>";
                                                echo "<td style='text-align:center;'> - </td>";
                                                echo "<td style='text-align:center;'> - </td>";
                                                echo "<td style='text-align:center;'> - </td>";
                                                echo "<td style='text-align:center;'> - </td>";
                                                echo "<td style='text-align:center;'> - </td>";
                                                echo "<td style='text-align:center;'> - </td>";
                                                echo "<td style='text-align:center;'> - </td>";
                                                echo "<td style='text-align:center;'> - </td>";
                                                echo "<td style='text-align:center; background: #5A6268; color: white;'> STOCK </td>";
                                                echo "<td>";

                                                    echo " <a type='button' class='btn btn-warning btn-sm optionEdit' valueEdit='".$stock->id."' title='Editar registro' >Editar</a>";
                                                    /*echo " <a type='button' class='btn btn-danger btn-circle btn-md' data-toggle='confirmation' data-btn-ok-label='S&iacute;' data-btn-ok-icon='glyphicon glyphicon-share-alt' data-btn-ok-class='btn-danger' data-btn-cancel-label='No' data-btn-cancel-icon='glyphicon glyphicon-ban-circle' data-btn-cancel-class='btn-default'><span title='Eliminar registro'class='glyphicon glyphicon-remove' aria-hidden='true'></span></a>";
                                                   /* echo " <a class='btn btn-danger btn-circle btn-md' data-toggle='confirmation' data-singleton='true'  title='Eliminar registro'><i class='fa fa-times'></i></a>";*/
                                                echo "</td>";
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
		        <h4 class="modal-title" id="myModalLabel">Agregar / Modificar zanco</h4>
		      </div>
		      <div class="modal-body">
                <form name='frmtipo' class="form-horizontal" id="divdestino" method="post" action="<?php echo $url; ?>createZancos_bd.php">
		  
		      </div>
		      <div class="modal-footer">
		        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
		        <button id="mandar" type="submit" class="btn btn-primary">Guardar</button>
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

                $("#mandar").on("click", function(event) 
                {
                    event.preventDefault();
                    var no_zanco = null;
                    var tamano = null;
                        no_zanco = $("#no_zanco").val()
                        tamano = $("#tamano").val()
                        consulta = "EXISTE_ZANCO";
                    
                    var respuesta = null;

                    if (no_zanco >= 0 && tamano > 0) 
                    {
                        $.get("helper_zancos.php", {consulta:consulta, no_zanco:no_zanco} ,function(data)
                        {
                            
                            respuesta = data;
                            if(respuesta == "SI")
                            {
                                alert("ESTE ZANCO YA EXISTE EN LA BD...");
                                $("#no_zanco").focus();
                                
                                return false;
                            }
                            else
                            {
                               $("form:first").submit();
                            }
                            
                        });
                    }
                    else
                    {
                        alert("Llene los campos correspondientes...");
                        return false;
                    }
                    

                    


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

                $('.dataTables-example').DataTable({
                //responsive: true,
                //"order": [[ 0, 'desc' ]],
                "ordering": false,
                "lengthMenu": [[20, 100, 100, -1], [20, 100, 200, "Todo"]], 
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