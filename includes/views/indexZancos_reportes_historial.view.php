 <?php require_once(VIEW_PATH.'header.inc.php');
 ?>

            
         <!-- page content -->
        <div class="right_col" role="main">
            <div class="">
                <div class="page-title">
                    <div class="title_left">
                        <h3>Reportes (historial piezas)...</h3>
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
                            <div class="x_content" >

                                <div class="row" style="text-align: center;">
                                    <h4>PARETOS</h4>
                                    <div id="pareto_pieza" class="col-sm-6">
                                        
                                    </div>
                                    <div id="pareto_problema" class="col-sm-6">
                                        
                                    </div>
                                </div>
                                <hr>
                                <div class="row">   
                                     <!-- aqui va el contenido -->
                                    <table class="table table-condensed table-bordered table-striped table-hover dataTables-example dataTables_wrapper jambo_table bulk_action" >
                                        <thead>
                                            <tr>
                                            
                                            <th>#</th>
                                            <th>REGISTRO</th>
                                            <th>NO ZANCO</th>
                                            <th>PIEZA</th>
                                            <th>DESCRIPCION</th>
                                            <th>PROBLEMA</th>
                                            <th>NOTAS</th>
                                            
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                            $i=1;
                                            foreach ($zancos_historial as $historial):
                                            {
                                                echo "<tr>";
                                                    echo "<td>".$i."</td>";
                                                    echo "<td>".$historial->id_registro."</td>";
                                                    echo "<td>".$historial->no_zanco."</td>";
                                                    echo "<td>".$historial->parte."</td>";
                                                    echo "<td>".$historial->descripcion_pieza."</td>";
                                                    echo "<td>".$historial->descripcion_problema."</td>";
                                                    echo "<td>".$historial->notas."</td>";
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
            
            $(window).load(function() 
            {
                
                google.charts.load("visualization", "1", {packages:["corechart"]});
                google.charts.setOnLoadCallback(draw_pareto_pieza);
                google.charts.setOnLoadCallback(draw_pareto_problema);


                function draw_pareto_pieza()
                {
                    var constructor = [['',  'Total', {role:'annotation'}]];

                    $.getJSON("json_zancos.php?consulta=PARETO_PIEZAS", function(result)
                    {
                        $.each(result, function(i, field)
                        {
                            veces = parseInt(field["veces"]);
                            parte = field["descripcion"];

                            
                            constructor.push([parte, veces, veces]);
                        });

                    
                        
                        //alert(constructor);
                        var data = google.visualization.arrayToDataTable(constructor);
                        var view = new google.visualization.DataView(data);
                            view.setColumns([0, 1, 
                                                {
                                                    calc: "stringify",
                                                    sourceColumn: 1,
                                                    type: "string",
                                                    role: "annotation"
                                                }
                                            ]);

                            var options = {
                              //isStacked: true, barras acostadas
                              bar: {groupWidth: "90%"},
                              legend: { position: "bottom" },
                              
                              chart: {
                                //title: '',
                                //subtitle: '',

                              },
                              bars: 'vertical',
                              vAxis: {
                                  //title: '% de cumplimiento',
                                  //format: '#\'%\''
                                  format: 'decimal'
                                  
                              },
                              fontSize: 12,
                              height: 480,
                              'chartArea': {'width': '90%', 'height': '80%'},
                              colors: ['#f0ad4e', '#5cb85c']
                            };

                            var chart = new google.visualization.ColumnChart(document.getElementById('pareto_pieza'));

                            chart.draw(view, options);
                    });

                }

                function draw_pareto_problema()
                {
                    var constructor = [['',  'Total', {role:'annotation'}]];

                    $.getJSON("json_zancos.php?consulta=PARETO_PROBLEMAS", function(result)
                    {
                        $.each(result, function(i, field)
                        {
                            veces = parseInt(field["veces"]);
                            parte = field["descripcion"];

                            
                            constructor.push([parte, veces, veces]);
                        });

                    
                        
                        //alert(constructor);
                        var data = google.visualization.arrayToDataTable(constructor);
                        var view = new google.visualization.DataView(data);
                            view.setColumns([0, 1, 
                                                {
                                                    calc: "stringify",
                                                    sourceColumn: 1,
                                                    type: "string",
                                                    role: "annotation"
                                                }
                                            ]);

                            var options = {
                              //isStacked: true, barras acostadas
                              bar: {groupWidth: "90%"},
                              legend: { position: "bottom" },
                              
                              chart: {
                                //title: '',
                                //subtitle: '',

                              },
                              bars: 'vertical',
                              vAxis: {
                                  //title: '% de cumplimiento',
                                  //format: '#\'%\''
                                  format: 'decimal'
                                  
                              },
                              fontSize: 12,
                              height: 480,
                              'chartArea': {'width': '90%', 'height': '80%'},
                              colors: ['#5cb85c', '#f0ad4e']
                            };

                            var chart = new google.visualization.ColumnChart(document.getElementById('pareto_problema'));

                            chart.draw(view, options);
                    });

                }

                
                
            });

            $(document).ready(function()
            {
                $('#pareto_pieza').html('<div style="text-align:center;"><img src="dist/img/loading.gif"/></div>');
                $('#pareto_problema').html('<div style="text-align:center;"><img src="dist/img/loading.gif"/></div>');

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