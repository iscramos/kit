 <?php require_once(VIEW_PATH.'header.inc.php');
 ?> 

            
        <!-- page content -->
        <div class="right_col" role="main">
            
                <div class="page-title">
                    <div class="title_left">
                        <h3>Mediciones de rebombeo...</h3>
                    </div>
                    <div class="title_right ">
                        <div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search">
                          <div class=" pull-right">
                                <div class="btn-group">
                                    <a href="indexGraficaMedidores.php" type="button" class="btn btn-default btn-circle btn-sm" title="Ver mapa de medidores" ><i class="fa fa-globe " aria-hidden="true"></i>
                                    </a>
                                    <a href="indexGraficaRebombeo.php" type="button" class="btn btn-default btn-circle btn-sm" title="Ver gráficos" ><i class="fa fa-bar-chart" aria-hidden="true"></i>
                                    </a>
                                    <a href="helperExcel.php?parametro=MEDICIONES_REBOMBEO" type="button" class="btn btn-default btn-circle btn-sm btn-primary" title="Exportar registros a excel" ><i class="fa fa-download"></i>
                                    </a>
                                </div>
                                <button type="button" class="btn btn-success btn-circle btn-sm" title="Nuevo registro" id="agregar"><i class="fa fa-plus"></i>
                                </button>

                          </div>
                        </div>
                    </div>

                </div>

                
                <div class="">
                    <div class="clearfix"></div>
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="x_panel">
                                <div class="x_title">
                                    <h2><i class="fa fa-cogs"></i> Registros <small>en el sistema </small> </h2>
                                    
                                    <ul class="nav navbar-right panel_toolbox">
                                      <li>
                                        <a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                                      </li>
                                    </ul>
                                    <div class="clearfix"></div>
                                </div>
                                <div class="x_content">
                                    <div class=" col-md-12md text-center">
                                        <span class="label label-success">En el rango</span>
                                        <span class="label label-danger">Fuera de rango</span>
                                    </div>
                                    <!-- aqui va el contenido -->
                                    <table  class="table table-condensed table-bordered table-striped table-hover dataTables-example dataTables_wrapper jambo_table bulk_action" style='font-size:11px;'>
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>DESCRIPCION DEL EQUIPO</th>
                                                <th>MEDICION</th>
                                                <th>FECHA / HORA</th>
                                                <th>VOLT <BR> L1 - L2</th>
                                                <th>VOLT <BR> L2 - L3</th>
                                                <th>VOLT <BR> L1 - L3</th>
                                                <th>AMP <BR> L1</th>
                                                <th>AMP <BR> L2</th>
                                                <th>AMP <BR> L3</th>
                                                <th>NIVEL <BR> ESTATICO</th>
                                                <th>NIVEL <BR> DINAMICO</th>
                                                <th>CAUDAL</th>
                                                <th>M<SUP>3</SUP> X 10 <BR> CONSUMIDOS</th>
                                                <th>ACCION</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                                $i=1;
                                                foreach ($mediciones as $medicion):
                                                {
                                                    
                                                    $colorVoltaje_l1_l2 = "";
                                                    $colorVoltaje_l2_l3 = "";
                                                    $colorVoltaje_l1_l3 = "";
                                                    $colorAmperaje_l1 = "";
                                                    $colorAmperaje_l2 = "";
                                                    $colorAmperaje_l3 = "";
                                                    
                                                    if($medicion->voltaje_l1_l2 < $medicion->volt_nomi_bajo || $medicion->voltaje_l1_l2 > $medicion->volt_nomi_alto)
                                                    {
                                                        $colorVoltaje_l1_l2 = "#D55551";
                                                    }
                                                    else
                                                    {
                                                        $colorVoltaje_l1_l2 = "#59BA5F";
                                                    }

                                                    if($medicion->voltaje_l2_l3 < $medicion->volt_nomi_bajo || $medicion->voltaje_l2_l3 > $medicion->volt_nomi_alto)
                                                    {
                                                        $colorVoltaje_l2_l3 = "#D55551";
                                                    }
                                                    else
                                                    {
                                                        $colorVoltaje_l2_l3 = "#59BA5F";
                                                    }

                                                    if($medicion->voltaje_l1_l3 < $medicion->volt_nomi_bajo || $medicion->voltaje_l1_l3 > $medicion->volt_nomi_alto)
                                                    {
                                                        $colorVoltaje_l1_l3 = "#D55551";
                                                    }
                                                    else
                                                    {
                                                        $colorVoltaje_l1_l3 = "#59BA5F";
                                                    }

                                                    // para el amperaje
                                                    if($medicion->amperaje_l1 < $medicion->amp_min || $medicion->amperaje_l1 > $medicion->amp_max)
                                                    {
                                                        $colorAmperaje_l1 = "#D55551";
                                                    }
                                                    else
                                                    {
                                                        $colorAmperaje_l1 = "#59BA5F";
                                                    }

                                                    if($medicion->amperaje_l2 < $medicion->amp_min || $medicion->amperaje_l2 > $medicion->amp_max)
                                                    {
                                                        $colorAmperaje_l2 = "#D55551";
                                                    }
                                                    else
                                                    {
                                                        $colorAmperaje_l2 = "#59BA5F";
                                                    }

                                                    if($medicion->amperaje_l3 < $medicion->amp_min || $medicion->amperaje_l3 > $medicion->amp_max)
                                                    {
                                                        $colorAmperaje_l3 = "#D55551";
                                                    }
                                                    else
                                                    {
                                                        $colorAmperaje_l3 = "#59BA5F";
                                                    }

                                                   
                                                    echo "<tr campoid='".$medicion->id."'>";
                                                        echo "<td width='5px' class='spec'>$i</td>";
                                                        echo "<td>".$medicion->descripcion."</td>";
                                                        echo "<td>".$medicion->tipoM."</td>";
                                                        echo "<td>".date("d-m-Y H:i", strtotime($medicion->fechaLectura))."</td>";

                                                        if($medicion->tipo == 1)
                                                        {
                                                           echo "<td style='color:white; background-color: ".$colorVoltaje_l1_l2."; '>".$medicion->voltaje_l1_l2."</td>";
                                                            echo "<td style='color:white; background-color: ".$colorVoltaje_l2_l3."; '>".$medicion->voltaje_l2_l3."</td>";
                                                            echo "<td style='color:white; background-color: ".$colorVoltaje_l1_l3."; '>".$medicion->voltaje_l1_l3."</td>";
                                                            echo "<td style='color:white; background-color: ".$colorAmperaje_l1."'>".$medicion->amperaje_l1."</td>";
                                                            echo "<td style='color:white; background-color: ".$colorAmperaje_l2."; '>".$medicion->amperaje_l2."</td>";
                                                            echo "<td style='color:white; background-color: ".$colorAmperaje_l3."; '>".$medicion->amperaje_l3."</td>"; 
                                                        }
                                                        else
                                                        {
                                                            echo "<td style='text-align: center;' > - </td>";
                                                            echo "<td style='text-align: center;' > - </td>";
                                                            echo "<td style='text-align: center;' > - </td>";
                                                            echo "<td style='text-align: center;' > - </td>";
                                                            echo "<td style='text-align: center;' > - </td>";
                                                            echo "<td style='text-align: center;' > - </td>";
                                                        }


                                                        echo "<td>".$medicion->nivel_estatico."</td>";
                                                        echo "<td>".$medicion->nivel_dinamico."</td>";
                                                        echo "<td>".$medicion->caudal."</td>";

                                                        if($medicion->m_consumidos != "")
                                                        {
                                                            echo "<td>".($medicion->m_consumidos * 10)."</td>";
                                                        }
                                                        else
                                                        {
                                                           echo "<td>".$medicion->m_consumidos."</td>"; 
                                                        }
                                                        
                                                        echo "<td>";
                                                            echo "<a type='button' class='btn btn-warning btn-circle btn-sm optionEdit' valueEdit='".$medicion->id."' title='Editar registro' ><i class='fa fa-pencil-square-o'></i></a>";
                                                            echo " <a type='button' class='btn btn-danger btn-circle btn-sm' data-toggle='confirmation'
                                                            data-placement='left' data-btn-ok-label='S&iacute;' data-btn-ok-icon='glyphicon glyphicon-share-alt' data-btn-ok-class='btn-danger' data-btn-cancel-label='No' data-btn-cancel-icon='glyphicon glyphicon-ban-circle' data-btn-cancel-class='btn-default'><span title='Eliminar registro'class='glyphicon glyphicon-remove' aria-hidden='true'></span></a>";
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
                        </div> <!-- fin class='' -->
                    </div>

                    <div class="clearfix"></div>
                </div>
        </div> 


        <!-- Modal -->
        <div class="modal fade bs-modal-lg" id="modalAgregar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
          <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content ">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Agregar / Modificar Lectura</h4>
              </div>
              <div class="modal-body">
                <form name='frmtipo' class="form-horizontal" id="divdestino" method="post" action="<?php echo $url; ?>createMedicionesRebombeo.php">
          
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
                  window.location.href='deleteMedicionRebombeo.php?id='+idR;
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

                        //console.log(v);

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

                    ajax.open("GET", "updateMedicionesRebombeo.php?id="+uID, true);
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