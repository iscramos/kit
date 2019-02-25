 <?php require_once(VIEW_PATH.'header.inc.php');
 ?>

<link href="dist/css/scrolito.css" rel="stylesheet">
            
          <!-- page content -->
        <div class="right_col" role="main">
            <div class="">
                <div class="page-title">
                    <div class="title_left">
                        <h3>Mis artículos...</h3>
                    
                </div>
                    <div class="title_right ">
                        <div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search">
                          <div class="input-group pull-right">
                            
                            
                          </div>
                        </div>
                    </div>

                </div>

                <div class="clearfix"></div>

                <div class="d-none d-lg-block">
                    <div class="col-12" >
                        <nav >
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item ">
                                    <a href="#" >Inicio</a>
                                </li>
                                <li class="breadcrumb-item active categoriaActiva">

                                </li>
                            </ol>
                        </nav>
                    </div>
                </div>


                <div class="row">
                    <div class="col-md-2 col-sm-2 col-xs-2">
                        <div id="filtro-productos-md" class="second-level-navbar">

                            <div class="list-group noborder" >
                                <h5 class="list-group-title pt-0" >CATEGORIAS</h5>
                                <?php
                                    foreach ($herramientas_categorias as $categoria) 
                                    {
                                        echo "<a class='list-group-item categoria' href='#' >".$categoria->categoria."</a>";
                                    }
                                ?>
                            </div>

                            <div class="list-group noborder" id="filtro-marcas" >
                                <h5 class="list-group-title" >Filtrar por marca</h5>
                                <div class=" scrollbar" id="style-3"  >
                                    <div class="list-group-items force-overflow"  >

                                        <?php
                                            foreach ($herramientas_proveedores as $marcas) 
                                            {
                                                echo "<div class='list-group-item' >";
                                                    echo "<div class='radio'>";
                                                        echo "<label>";
                                                            echo "<input type='radio' name='optionsRadios' id='optionsRadios2' value='option2'>
                                                                ".$marcas->descripcion;
                                                        echo "</label>";
                                                    echo "</div>";
                                                echo "</div>";
                                            }
                                        ?>
                                        
                                                          
                                                          
                                    </div>
                                </div>
                            </div>

                            <div class="list-group noborder" >
                                <h5 class="list-group-title pt-0" >TOP TEN</h5>
                                <?php
                                    
                                ?>
                            </div>

                        </div>

                    </div>
                    <div class="col-md-10 col-sm-10 col-xs-10">
                        <div class="x_panel" style="margin-bottom: 40px;">
                            <div class="x_title">
                                <h2><i class="fa fa-cogs"></i> Artículos <small>en el sistema</small></h2>
                                <ul class="nav navbar-right panel_toolbox">
                                  <li>
                                    <a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                                  </li>
                                </ul>
                                <div class="clearfix"></div>
                            </div>
                            <div class="x_content">

                                <?php
                                    foreach ($herramientas_herramientas as $articulo) 
                                    {
                                        echo "<div class='col-sm-2 col-md-3'>
                                            <div class='thumbnail' style=' padding:0px!important'>
                                              <img style='width:140; height:100px;'  src='content/".$articulo->archivo."' >
                                                <div class='caption' style='height:90px; padding: 3px 3px !important;'>
                                                    <h5 style='margin-bottom:0px; margin-top:0px;'>".$articulo->clave."</h5>
                                                    <p style='font-size:11px;'>".$articulo->descripcion."</p>
                                                    <br>
                                                    <p style='margin-bottom:15px !important;'>";
                                                        

                                                        if($articulo->estatus != 1)
                                                        {
                                                            echo "<a href='#' class='btn btn-success btn-xs pull-right prestar' id_herramienta='".$articulo->id."' role='button' title='Prestar Articulo'>PRESTAR
                                                            </a>";
                                                        }
                                                        echo "<a href='indexHerramientas_prestamos.php?id_herramienta=".$articulo->id."' class='btn btn-warning btn-xs pull-right ' role='button' title='Ver préstamos'>HISTORIAL
                                                        </a>";
                                                    echo "</p> 
                                                  </div>
                                            </div>
                                        </div>";
                                    }

                                ?>

                                
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
		        <h4 class="modal-title" id="myModalLabel">Prestar artículo</h4>
		      </div>
		      <div class="modal-body">
                <form name='frmtipo' class="form-horizontal" id="divdestino" method="post" action="<?php echo $url; ?>createHerramientas_prestamos.php">
		  
		      </div>
		      <div class="modal-footer">
		        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
		        <button type="submit" class="btn btn-primary">Prestar</button>
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
                $(".prestar").on("click", function(event) 
                { 
                    event.preventDefault();
                    var v = 0;
                    var id_herramienta = 0;
                        id_herramienta = $(this).attr("id_herramienta");

                    ajaxCargaDatos("divdestino", v, id_herramienta);
                
                });

                /*$(".optionEdit").on("click", function(event) 
                { 
                    event.preventDefault();
                    var v = 0;
                        v = $(this).attr("valueEdit");

                    var id_herramienta = 0;
                        id_herramienta = $("#id_herramienta").val();

                        //console.log(v);

                    ajaxCargaDatos("divdestino", v, id_herramienta);
                
                });*/


                $(".categoria").on("click", function()
                {
                    var categoria = null;
                        categoria = $(this).text();

                        $(".categoriaActiva").text(categoria);
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