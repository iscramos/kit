 <?php require_once(VIEW_PATH.'header.inc.php');
 ?>

<style type="text/css">
    .perfil
    {
        text-align: center !important;
        text-align: -webkit-center !important;
    }
    .a_imagen
    {
        font-size: 16px;
        font-weight: bold;
    }
    .img_description
    {
        font-size: 12px;
    }
    
    
    .image_outer_container{
        margin-top: auto !important;
        margin-bottom: auto !important;
        border-radius: 50% !important;
        position: relative !important;
        width: max-content !important;
       }

       .image_inner_container{
        border-radius: 50% !important;
        padding: 5px !important;
        background: #833ab4 !important; 
        background: -webkit-linear-gradient(to bottom, #fcb045, #fd1d1d, #833ab4) !important; 
        background: linear-gradient(to bottom, #fcb045, #fd1d1d, #833ab4) !important;
       }
       .image_inner_container img
       {
        height: 140px !important;
        width: 140px !important;
        border-radius: 50% !important;
        border: 5px solid white !important;

       }

       .image_outer_container .green_icon{
         background-color: #4cd137 !important;
         position: absolute !important;
         right: 30px !important;
         bottom: 0px !important;
         height: 30px !important;
         width: 30px !important;
         border: 5px solid white !important;
         border-radius: 50% !important;
       }

       .alert {
          height: 20px !important;
              margin-top: 20px !important;
              margin-bottom: 0px !important;
              padding: 0px !important;
        }
</style>
         <!-- page content -->
        <div class="right_col" role="main">
            <div class="">
                <div class="page-title">
                    <div class="title_left">
                        <h3>Productos (despacho)...</h3>
                    </div>
                    <div class="title_right ">
                        <div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search">
                        </div>
                    </div>

                </div>

                <div class="clearfix"></div>

                <div class="row">
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="x_panel">
                            <div class="x_title">
                                <h2><i class="fa fa-cogs"></i> Visualización <small>del registro</small></h2>

                                <ul class="nav navbar-right panel_toolbox">
                                  <li>
                                    <a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                                  </li>
                                </ul>
                                <div class="clearfix"></div>
                            </div>
                            <div class="x_content">


                                <!-- aqui va el contenido -->
                                    

                                    
                                        
                                    <div class="row perfil">
                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            
                                                    <div class="d-flex justify-content-center h-100">
                                                        <div class="image_outer_container">
                                                            <div class="green_icon"></div>
                                                            <div class="image_inner_container">
                                                                <img src="<?php echo $a_imagen; ?>">
                                                            </div>
                                                        </div>
                                                    </div>
                                                
                                                    <div class="title">
                                                        <a class='a_imagen'><?php echo $a_nombre; ?></a>
                                                    </div>
                                                    <div class="img_description"><?php echo $a_codigo.$a_puesto.$a_estatus; ?> </div>
                                                    <div class="img_description"><?php echo $a_departamento; ?></div>
                                                    <div class="img_description"><?php echo $a_lider; ?></div>
                                                    <input type="text"  class="hidden" id="codigo_asociado" value="<?php echo $codigo; ?>">
                                                    <input type="text"  class="hidden" id="nombre" value="<?php echo $a_nombre; ?>">
                                                    
                                                
                                            
                                        </div>


                                            <?php
                                                    
                                                //echo "<img  class='imagenPerfil img-circle' src='../col2/ch/perfils/".$codigo.".jpg' class='img-rounded'>";
                                                
                                            ?>
                                        
                                        
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-sm-4">
                                            <label ></label>
                                            <div class="input-group " style="margin-bottom: 0px;">
                                                <input type="text" name="clave" id="clave" class="form-control" value="" autofocus="autofocus" autocomplete="off" required="">
                                                <span class="input-group-btn">
                                                    <button type="button" class="btn btn-default" id="buscar" title="Buscar artículo"> <span class='glyphicon glyphicon-search'></span> </button>
                                                </span>
                                            </div>
                                        </div>

                                        <div class="form-group col-sm-4 pull-center" style="text-align: -webkit-center;" >
                                            <div id="mensaje" >
                                                    
                                            </div>
                                        </div>

                                        <div class="form-group col-sm-4 pull-right" style="text-align: -webkit-right;">
                                            <label ></label>
                                            <div class="input-group" style="margin-bottom: 0px;">
                                                <button type="button" class="btn btn-danger" id="cancelar" title="Cancelar movimiento"> <span class='fa fa-close'></span> cancelar</button>

                                                <button type="button" class="btn btn-success" id="aprobar" title="Cerrar movimiento"> <span class='glyphicon glyphicon-ok'></span> aprobar</button>
                                                
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">

                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <table class="table table-condensed table-bordered table-striped table-hover  dataTables_wrapper jambo_table bulk_action" id="temporal_tabla">
                                                <thead>
                                                    <tr>
                                                        <!--th>#</th-->
                                                        <th>Clave</th>
                                                        <th>Descripcion</th>
                                                        <th>Cantidad</th>
                                                        <th>Acción</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="articulos_ingresados">
                                                    <?php
                                                        foreach ($temporales as $t) 
                                                        {
                                                            echo "<tr>";
                                                                echo "<td>".$t->clave."</td>";
                                                                echo "<td>".$t->descripcion."</td>";
                                                                echo "<td>".$t->cantidad."</td>";
                                                                echo "<td><button class='btn btn-danger btn-sm eliminar_articulo' c='".$t->clave."'>Eliminar</button></td>";
                                                                
                                                            echo "</tr>";
                                                        }
                                                    ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div id="recibeData" style="text-align: center;">
                                        <!-- aquí irá el resultado de la búsqueda--> 
                                    </div>
                                    

                            
                                

                            </div>
                        </div>
                    </div> <!-- fin class='' -->
                </div>
            <div class="clearfix"></div>
        </div>
    </div> 


  		<!-- Modal -->
		<div class="modal fade bs-example-modal-lg" id="modalAgregar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		  <div class="modal-dialog modal-lg" role="document">
		    <div class="modal-content">
		      <div class="modal-header">
		        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		        <h4 class="modal-title" id="myModalLabel">Productos para despacho</h4>
		      </div>
		      <div class="modal-body" id="divdestino">   
                
                        <!-- contenido -->
                    
		  
		      </div>
		      <div class="modal-footer">
		        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
		        
		      </div>
                
		    </div>
		  </div>
		</div>



 <?php require_once(VIEW_PATH.'footer.inc.php'); ?>

        <script type="text/javascript">


            $(document).ready(function()
            {
                
                $('.eliminar_articulo').on('click', function(e)
                {
                    var codigo_asociado = null;
                    var clave = null;

                        codigo_asociado = $("#codigo_asociado").val() 
                        clave = $(this).attr("c"); 
                        $("#mensaje").html(null);
                        tipo = "UNITARIO";

                    $.post( 'deleteHerramienta_temporal.php', {codigo_asociado: codigo_asociado, clave: clave, tipo: tipo})
                    .done(function( data )
                    {

                        $("#mensaje").text("Producto eliminado...");
                        $("#mensaje").removeClass();
                        $("#mensaje").addClass('alert alert-danger');
                        $("#mensaje").alert();
                        $("#mensaje").fadeTo(1000, 700).slideUp(700, function(){
                        $("#mensaje").slideUp(1000);
                        });

                        $("#articulos_ingresados").html(data);
                    });
                });

                $('#cancelar').on('click', function(e)
                {
                    var codigo_asociado = null;
                        codigo_asociado = $("#codigo_asociado").val(); 
                        $("#mensaje").html(null);
                        tipo = "TODO";
                    $.post( 'deleteHerramienta_temporal.php', {codigo_asociado: codigo_asociado, tipo: tipo})
                    .done(function( data )
                    {

                        $("#mensaje").text("Productos eliminados...");
                        $("#mensaje").removeClass();
                        $("#mensaje").addClass('alert alert-danger');
                        $("#mensaje").alert();
                        $("#mensaje").fadeTo(1000, 700).slideUp(700, function(){
                        $("#mensaje").slideUp(1000);
                        });

                        $("#articulos_ingresados").html(data);
                    });
                });

                $("#aprobar").on("click", function(e)
                {
                    
                    
                    var codigo_asociado = null;
                    var nombre = null;
                        codigo_asociado = $("#codigo_asociado").val();
                        nombre = $("#nombre").val();
                    //var parametro = "ARTICULOS_ENTREGA";

                    var nFilas = null;
                        nFilas = $("#temporal_tabla tr").length;
                        //alert(nFilas);

                    if(codigo_asociado > 0 && nFilas > 1)
                    {
                        
                        /*url = "helperExport.php?codigo_asociado="+codigo_asociado+"&parametro="+parametro;
                        window.open(url, '_blank');*/

                        $.post( 'createHerramienta_transaccion.php', {codigo_asociado: codigo_asociado, nombre:nombre})
                        .done(function( data )
                        {

                            $("#mensaje").text("Transacción completada, ver detalles en menú despachos...");
                            $("#mensaje").removeClass();
                            $("#mensaje").addClass('alert alert-success');
                            $("#mensaje").alert();
                            $("#mensaje").fadeTo(1000, 700).slideUp(700, function(){
                            $("#mensaje").slideUp(1000);
                            });

                            $("#articulos_ingresados").html(data);

                            
                        });

                        
                    }
                    else
                    {
                        $("#mensaje").text("Ingrese productos...");
                        $("#mensaje").removeClass();
                        $("#mensaje").addClass('alert alert-info');
                        $("#mensaje").alert();
                        $("#mensaje").fadeTo(1000, 700).slideUp(700, function(){
                        $("#mensaje").slideUp(1000);
                        });
                    }
                    
                    return false;
                    
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

                $("#buscar").on("click", function(e)
                {
                    var codigo_asociado = null;
                        codigo_asociado = $("#codigo_asociado").val();
                    consulta = "PIEZAS_BUSQUEDA";
                    ajaxCargaDatos("divdestino", consulta, codigo_asociado);
                });

                // para buscar zancos por enter
                $( "#clave" ).keypress(function( event ) 
                {
                    var clave = $(this).val();

                    if (event.which == 13 && clave != "") 
                    {
                        event.preventDefault();
                        var clave = null;
                        var codigo = null;
                        var cantidad = null;

                            clave = $(this).val();
                            codigo = $("#codigo_asociado").val();
                            cantidad = 1;
                            consulta = "VALIDA_STOCK";

                            $("#mensaje").html(null);

                        $.post( 'helper_herramientas.php', {clave: clave, cantidad: cantidad, codigo: codigo, consulta: consulta })
                          .done(function( data )
                          {
                            if(data == "SI")
                            {
                                /*$("#mensaje").text("Producto agregado...");
                                $("#mensaje").removeClass();
                                $("#mensaje").addClass('alert alert-success');
                                $("#mensaje").alert();
                                $("#mensaje").fadeTo(1000, 700).slideUp(700, function(){
                                $("#mensaje").slideUp(1000);
                                });

                                $("#articulos_ingresados").html(data);*/


                                $.post( 'createHerramienta_transaccion_temporal.php', {clave: clave, cantidad: cantidad, codigo: codigo })
                                  .done(function( data )
                                  {

                                        $("#mensaje").text("Producto agregado...");
                                        $("#mensaje").removeClass();
                                        $("#mensaje").addClass('alert alert-success');
                                        $("#mensaje").alert();
                                        $("#mensaje").fadeTo(1000, 700).slideUp(700, function(){
                                        $("#mensaje").slideUp(1000);
                                        });

                                        $("#articulos_ingresados").html(data);
                                  });
                            }
                            else
                            {
                                $("#mensaje").text("PRODUCTO NO AGREGADO / SUPERA EL STOCK");
                                $("#mensaje").removeClass();
                                $("#mensaje").addClass('alert alert-warning');
                                $("#mensaje").alert();
                                $("#mensaje").fadeTo(1000, 700).slideUp(700, function(){
                                $("#mensaje").slideUp(1000);
                                });
                            }

                                
                          });
                        
                            
                        $(this).val(null);
                    }

                });

                function ajaxCargaDatos(divdestino, consulta, codigo_asociado)
                {
                    var ajax = creaAjax();

                    ajax.open("GET", "updateHerramientas_temporal.php?consulta="+consulta+"&codigo_asociado="+codigo_asociado, true);
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
                };

                $('.dataTables-example').DataTable({
                    'lengthMenu': [[10, -1], [10, 'Todo']],  
                    'language':{
                        oPaginate: {
                            'sNext' : 'Siguiente',
                            'sPrevious': 'Anterior'
                        },
                        'search': 'Buscar ',
                        'sNext': 'Siguiente',
                        'sPrevious': 'Anterior',
                        'lengthMenu': '_MENU_ Registros por página',
                        'zeroRecords': 'Nada encontrado',
                        'info': 'Mostrando página _PAGE_ de _PAGES_',
                        'infoEmpty': 'No registros disponibles',
                        'infoFiltered': '(filtrado de _MAX_ registros totales)'
                    }
                });
                

            }); // end ready
        </script>
</body>

</html>