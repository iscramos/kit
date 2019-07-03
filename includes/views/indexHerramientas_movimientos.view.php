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
                        <h3>Movimientos <?php  if(isset($clave)) echo "para: ".$clave; ?></h3>
                    </div>
                    <div class="title_right ">
                        <div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search">
                          <div class="input-group pull-right">
                            <a href='indexZancos_movimientos_actualizar.php?action=NEW&reg=0&mov=0' type="button" class="btn btn-success btn-circle btn-sm" title="Nuevo movimiento" >Nuevo
                            </a>
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
                                        <th style="text-align: center;">Reg</th>
                                        <th>Clave</th>
                                        
                                        
                                        
                                        <th style="text-align: center;">Movimiento</th>
                                        <th style="text-align: center;">Gh</th>
                                       
                                        <th style="text-align: center;">Fecha Act.<br> Baja</th>
                                        <th style="text-align: center;">Líder</th>
                                        <th style="text-align: center;">Nombre</th>
                                        <th style="text-align: center;">Fecha <br> Salida</th>
                                        <th style="text-align: center;">WK <br> Salida</th>
                                        <th style="text-align: center;">Desfase <br> (WK) </th>
                                        <th style="text-align: center;">Fecha <br> Entrega</th>
                                        <th style="text-align: center;">WK <br> Entrega</th>
                                        <th style="text-align: center;">Fecha <br> Servicio</th>
                                        <th style="text-align: center;">Problema</th>
                                        <th style="text-align: center;">Acción</th>
                                    </tr>
                                </thead>
                                <tbody >
                                    <?php
                                        //$i=1;
                                        foreach ($herramientas_movimientos as $m):
                                        {
                                           
                                            echo "<tr campoid='".$m->id_registro."'>";
                                                
                                                echo "<td style='text-align: center; color:red;'>".$m->id_registro."</td>";
                                                echo "<td style='text-align: right;'>".$m->clave."</td>";
                                                
                                                //echo "<td style='text-align: center; border-right: 1px dashed;'>".$m->limite_semana."</td>";
                                                
                                                $estilo = "";
                                                if($m->tipo_movimiento == 1) // activacion
                                                {
                                                    $estilo = "background: #286090; color: white; ";
                                                }
                                                elseif($m->tipo_movimiento == 2) // baja
                                                {
                                                    $estilo = "background: #C9302C; color: white; ";
                                                }
                                                elseif ($m->tipo_movimiento == 3) // salida 
                                                {
                                                    $estilo = "background: #EC971F; color: white; ";
                                                }
                                                echo "<td style='text-align: center; $estilo' >".$m->accion."</td>";
                                                echo "<td style='text-align: center;'>".$m->gh."</td>";
                                               //echo "<td style='text-align: center;'>".$m->zona."</td>";

                                                if($m->fecha_activacion_o_baja > 0)
                                                {
                                                    echo "<td style='text-align:center;'>".date("d/m/Y", strtotime($m->fecha_activacion_o_baja))."</td>";
                                                }
                                                else
                                                {
                                                    echo "<td style='text-align:center;'> - </td>";
                                                }
                                                
                                                echo "<td>".$m->ns_salida_lider."</td>";
                                                echo "<td>".utf8_encode($m->nombre_lider_salida)."</td>";

                                                if($m->tipo_movimiento == 1) // activacion
                                                {
                                                    echo "<td style='text-align:center;'> - </td>";
                                                    echo "<td style='text-align:center;'> - </td>";
                                                    echo "<td style='text-align:center;'> - </td>";
                                                    
                                                    
                                                    echo "<td style='text-align:center;'> - </td>";
                                                    echo "<td style='text-align:center;'> - </td>";
                                                    echo "<td style='text-align:center;'> - </td>";
                                                    echo "<td style='text-align:center;'> - </td>";
                                                }
                                                else if($m->tipo_movimiento == 2) // baja
                                                {
                                                    echo "<td style='text-align:center;'> - </td>";
                                                    echo "<td style='text-align:center;'> - </td>";
                                                    echo "<td style='text-align:center;'> - </td>";
                                                    
                                                    
                                                    echo "<td style='text-align:center;'> - </td>";
                                                    echo "<td style='text-align:center;'> - </td>";
                                                    echo "<td style='text-align:center;'> - </td>";
                                                    echo "<td style='text-align:center;'> - </td>";
                                                }
                                                elseif($m->tipo_movimiento == 3) // salida
                                                {
                                                    if($m->fecha_salida > 0)
                                                    {
                                                        echo "<td style='text-align:center;'>".date("d/m/Y", strtotime($m->fecha_salida))."</td>";
                                                        echo "<td style='text-align:center;'>".$m->wk_salida."</td>";
                                                    }
                                                    else
                                                    {
                                                        echo "<td style='text-align:center;'> - </td>";
                                                        echo "<td style='text-align:center;'> - </td>";
                                                    }

                                                    // aquí sacamos el desfase
                                                    $fechaHoy = date_create(date("Y-m-d"));
                                                    $f_salida = date_create($m->fecha_salida);

                                                    
                                                    if($m->fecha_entrega > 0 && $m->fecha_salida > 0)
                                                    {
                                                        echo "<td style='text-align:center;'> - </td>";
                                                    }
                                                    else
                                                    {
                                                        $d_dias = date_diff($fechaHoy, $f_salida);
                                                        $d_dias = $d_dias->format('%a');
                                                        $semanas_limite = 0;/*$m->limite_semana;*/
                                                        $semanas_convertidas = $d_dias / 7;
                                                        $semanas_convertidas = round($semanas_convertidas, 2);
                                                        
                                                        if($semanas_convertidas > $semanas_limite)
                                                        {
                                                            $diferencia_semanas = $semanas_convertidas - $semanas_limite;
                                                            echo "<td class='invalid' style='text-align:center; background:#C9302C; color: white;'>".$diferencia_semanas."</td>";    
                                                        }
                                                        else
                                                        {
                                                            echo "<td style='text-align:center; '> - </td>";
                                                        }

                                                        
                                                        
                                                        
                                                    }
                                                    
                                                    
                                                    if($m->fecha_entrega > 0)
                                                    {
                                                        echo "<td style='text-align:center;'>".date("d/m/Y", strtotime($m->fecha_entrega))."</td>";
                                                        echo "<td style='text-align:center;'>".$m->wk_entrega."</td>";
                                                    }
                                                    else
                                                    {
                                                        echo "<td style='text-align:center;'> - </td>";
                                                        echo "<td style='text-align:center;'> - </td>";
                                                    }
                                                    

                                                    if($m->fecha_servicio > 0)
                                                    {
                                                        echo "<td style='text-align:center;'>".date("d/m/Y", strtotime($m->fecha_servicio))."</td>";
                                                    }
                                                    else
                                                    {
                                                        echo "<td style='text-align:center;'> - </td>";
                                                    }
                                                    
                                                    if($m->descripcion_problema > 0)
                                                    {
                                                        echo "<td style='text-align:center;'>".$m->problema_descripcion."</td>";
                                                    }
                                                    else
                                                    {
                                                        echo "<td style='text-align:center;'> - </td>";
                                                    }
                                                }
                                                
                                                echo "<td>";

                                                    echo " <a type='button' href='indexHerramientas_movimientos_actualizar.php?action=EDIT&reg=$m->id_registro&mov=$m->tipo_movimiento&clave=$m->clave' class='btn btn-warning btn-xs'  title='Editar registro' >Editar</a>";
                                                    /*echo " <a type='button' class='btn btn-danger btn-circle btn-xs' data-toggle='confirmation' data-btn-ok-label='S&iacute;' data-btn-ok-icon='glyphicon glyphicon-share-alt' data-btn-ok-class='btn-danger' data-btn-cancel-label='No' data-btn-cancel-icon='glyphicon glyphicon-ban-circle' data-btn-cancel-class='btn-default'><span title='Eliminar registro'class='glyphicon glyphicon-remove' aria-hidden='true'></span></a>";*/
                                                   /* echo " <a class='btn btn-danger btn-circle btn-md' data-toggle='confirmation' data-singleton='true'  title='Eliminar registro'><i class='fa fa-times'></i></a>";*/
                                                echo "</td>";
                                            echo "</tr>";

                                            //$i ++;
                                        }
                                            endforeach;
                                        ?>
                                    </tbody>
                                    <tfoot>
                                        <tr style="background: #405467;">
                                            <th></th>
                                            <th></th>
                                            
                                            <!--th></th-->
                                            <th></th>
                                            <th></th>
                                            <!--th></th-->
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
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
                        this.api().columns([0, 1, 6 ]).every( function () {
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