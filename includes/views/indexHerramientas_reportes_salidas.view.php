 <?php require_once(VIEW_PATH.'header.inc.php');
 ?>

          <!-- page content -->
        <div class="right_col" role="main">
            <div class="">
                <div class="page-title">
                    <div class="title_left">
                        <h3>Reporte de costos de despachos...</h3>
                        
                    </div>
                    <div class="title_right ">
                        
                    </div>

                </div>

                <div class="clearfix"></div>

                <div class="row">
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="x_panel">
                            
                            <div class="x_content">

                                <!-- aqui va el contenido -->
                                <div class="row">
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <form class=" " style="display: flex; align-items: center; justify-content: center;">
                                    
                                       
                                            <div class='col-sm-2'>
                                                <label >DESDE</label>
                                                <div class='input-group date' id='datetimepicker1' >
                                                    <input type='text' name='fecha_inicio' id='fecha_inicio' class='form-control' value='' autocomplete='off' required="true">
                                                    <span class='input-group-addon'>
                                                        <span class='glyphicon glyphicon-calendar'></span>
                                                    </span>
                                                </div>
                                            </div>
                                        
                                            <div class='col-sm-2'>
                                                <label >HASTA</label>
                                                <div class='input-group date' id='datetimepicker2' >
                                                    <input type='text' name='fecha_fin' id='fecha_fin' class='form-control' value='' autocomplete='off' required="true">
                                                    <span class='input-group-addon'>
                                                        <span class='glyphicon glyphicon-calendar'></span>
                                                    </span>
                                                </div>
                                            </div>
                                        

                                            <div class="col-sm-2">
                                                <label ></label>
                                                <div class="input-group" >

                                                    <button type="button" class="btn btn-success" id="generar" title="Generar datos"> <span class='glyphicon glyphicon-search'></span> </button>
                                                    
                                                </div>
                                            </div>
                                         
                                        </form>
                                    </div>
                                </div>

                                <div class="row">
                                    <!-- request -->
                                </div>

                            </div>
                        </div>
                    </div> <!-- fin class='' -->
                </div>
            <div class="clearfix"></div>
        </div>
    </div> 


  		<!-- Modal -->
		<!--div class="modal fade" id="modalAgregar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		  <div class="modal-dialog" role="document">
		    <div class="modal-content">
		      <div class="modal-header">
		        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		        <h4 class="modal-title" id="myModalLabel">Agregar / Modificar Producto</h4>
		      </div>
		      <div class="modal-body">
                <form name='frmtipo' class="form-horizontal" id="divdestino" method="post" action="<?php echo $url; ?>createHerramientas_herramientas.php" enctype="multipart/form-data">
		  
		      </div>
		      <div class="modal-footer">
		        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
		        <button type="submit" class="btn btn-primary" id="mandar">Guardar</button>
		      </div>
                </form>
		    </div>
		  </div>
		</div-->



 <?php require_once(VIEW_PATH.'footer.inc.php'); ?>

        <script type="text/javascript">
            
            $(document).ready(function()
            {
                

                $("#generar").on("click", function(event) 
                {
                    event.preventDefault();
                    var fecha_inicio = null;
                    var fecha_fin = null;

                        fecha_inicio = $("#fecha_inicio").val()
                        fecha_fin = $("#fecha_fin").val();
                    

                    if ( (fecha_inicio != "") && (fecha_fin != "") ) 
                    {
                        /*$.get("helper_herramientas.php", {consulta:consulta, clave:clave} ,function(data)
                        {
                            
                            respuesta = data;
                            if(respuesta == "SI" && id < 0)
                            {
                                alert("ESTE ARTICULO YA EXISTE EN LA BD...");
                                $("#clave").focus();
                                
                                return false;
                            }
                            else
                            {
                                $("#mandar").attr("disabled", true);
                               $("form:first").submit();
                            }
                            
                        });*/
                        alert("Calculando datos ...");
                        return false;
                    }
                    else
                    {
                        alert("Llene el rango de fechas ...");
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

                function ajaxCargaDatos(divdestino, uID, id_categoria, id_almacen)
                {
                    var ajax=creaAjax();

                    ajax.open("GET", "updateHerramientas_herramientas.php?id="+uID+"&id_categoria="+id_categoria+"&id_almacen="+id_almacen, true);
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

                $(function () 
                {
                    $('#datetimepicker1').datetimepicker({
                        format: 'YYYY-MM-DD',
                        pickTime: false,
                        autoclose: true,

                    });

                    $('#datetimepicker2').datetimepicker({
                        format: 'YYYY-MM-DD',
                        pickTime: false,
                        autoclose: true,

                    });
                });

            }); // end ready
        </script>
</body>

</html>