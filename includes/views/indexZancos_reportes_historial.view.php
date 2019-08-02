 <?php require_once(VIEW_PATH.'header.inc.php');
 ?>

<style type="text/css">
    
    
#zoom {
    position: relative;
    width: 640px;
    height: auto;
    margin: 20px auto;
    border: 12px solid #fff;
    border-radius: 10px;
    box-shadow: 1px 1px 5px rgba(50,50,50 0.5);
}

/*.zoom img:hover{
  transform:scale(1.5);
  -moz-transform: scale(1.5);
  -webkit-transform:scale(1.5);
}*/
       
.zoom
{      
  overflow:hidden;
}
</style>

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
                                    
                                    <div id="pareto_pieza" class="col-sm-6">
                                        
                                    </div>
                                    <div id="pareto_problema" class="col-sm-6">
                                        
                                    </div>
                                </div>
                                <hr>
                                
                                <div class="row">   
                                     <!-- aqui va el contenido -->
                                    <div class="col-sm-4 text-center zoom">
                                        <h4>MODEL IV</h4> 
                                        <img id="zoom_zanco" class="img img-thumbnail" src="content/partes_zancos/model4.jpg" width="100%">
                                    </div>
                                    
                                    <div class="col-sm-8">
                                        <table class="table table-condensed table-bordered table-striped table-hover dataTables-example dataTables_wrapper jambo_table bulk_action" >
                                            <thead>
                                                <tr>
                                                
                                                    <th>#</th>
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
                                                        echo "<td>".$historial->no_zanco."</td>";
                                                        echo "<td><a class='verPieza' title='Ver pieza' href='#' style='color: darkorange !important;' valueSee='".$historial->parte."'>".$historial->parte."</a></td>";
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
                        </div>
                    </div> <!-- fin class='' -->
                </div>
                <br>
                 <br>
            <div class="clearfix"></div>
        </div>
    </div> 


  		<!-- Modal -->
		<div class="modal fade" id="modalAgregar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		  <div class="modal-dialog" role="document">
		    <div class="modal-content">
		      <div class="modal-header">
		        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		        <h4 class="modal-title" id="myModalLabel">Ver</h4>
		      </div>
		      <div class="modal-body" id="divdestino" style="text-align:center;">
		  
		      </div>
		      <div class="modal-footer">
		        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
		      </div>
		    </div>
		  </div>
		</div>



 <?php require_once(VIEW_PATH.'footer.inc.php'); ?>
        <!-- mlens -->
        <script src="dist/js/jquery.mlens-1.7.min.js"></script>
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
                            parte = field["parte"];

                            
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
                              title: 'PARETO DE PIEZAS',
                              backgroundColor: '#F7F7F7',
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
                              height: 360,
                              'chartArea': {'width': '90%', 'height': '60%'},
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
                              title: 'PARETO DE PROBLEMAS',
                              backgroundColor: '#F7F7F7',
                              chart: {
                                //title: 'dfdfg',
                                //subtitle: '',

                              },
                              bars: 'vertical',
                              vAxis: {
                                  //title: '% de cumplimiento',
                                  //format: '#\'%\''
                                  format: 'decimal'
                                  
                              },
                              fontSize: 12,
                              height: 360,
                              'chartArea': {'width': '90%', 'height': '60%'},
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

                $(".verPieza").on("click", function(event) 
                { 
                    event.preventDefault();
                    var v = 0;
                        v = $(this).attr("valueSee");
                        consulta = "IMAGEN_PIEZA";

                        
                    $.get("helper_zancos.php", {consulta:consulta, parte:v} ,function(data)
                    { 
                        $("#divdestino").html(data);
                        $("#modalAgregar").modal("show");
                    });

                });

                $("#zoom_zanco").mlens(
                {
                    imgSrc: $("#zoom_zanco").attr("data-big"),   // path of the hi-res version of the image
                    lensShape: "square",                // shape of the lens (circle/square)
                    lensSize: 300,                  // size of the lens (in px)
                    borderSize: 4,                  // size of the lens border (in px)
                    borderColor: "#233E50",                // color of the lens border (#hex)
                    borderRadius: 0,                // border radius (optional, only if the shape is square)
                    imgOverlay: $("#zoom_zanco").attr("data-overlay"), // path of the overlay image (optional)
                    overlayAdapt: false, // true if the overlay image has to adapt to the lens size (true/false)
                    zoomLevel: 1.5
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