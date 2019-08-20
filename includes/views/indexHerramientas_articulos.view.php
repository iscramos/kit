 <?php require_once(VIEW_PATH.'header.inc.php');
 ?>

 <style type="text/css">
     
    #arriba 
    {
        display:none;
        
        background:#024959;
        font-size:14px;
        color:#fff;
        cursor:pointer;
        position: fixed;
        bottom:100px;
        right:20px;
    }
 </style>

<link href="dist/css/scrolito.css" rel="stylesheet">
            
          <!-- page content -->
        <div class="right_col" role="main">
            <div class="">
                <div class="page-title">
                    <div class="title_left">
                        <h3>Mis productos...</h3>
                    
                </div>
                    <div class="title_right ">
                        <div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right">
                            <div class="input-group">
                                <input type="text" name="clave" id="clave" class="form-control" value="">
                                <span class="input-group-btn">
                                    <button type='button' class='btn btn-primary' id='buscar_articulo' title='Buscar artículo'> 
                                        <span class='glyphicon glyphicon-search'></span> 
                                    </button>
                                </span>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="clearfix"></div>

                <div class="d-none d-lg-block">
                    <div class="col-sm-12" >
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
                                        echo "<a class='list-group-item categoria' href='#' id_categoria='".$categoria->id."' >".$categoria->categoria."</a>";
                                    }
                                ?>
                            </div>

                            <div class="list-group noborder" id="filtro-marcas" >
                                <h5 class="list-group-title" > FILTRAR POR MARCA</h5>
                                <div class=" scrollbar" id="style-3"  >
                                    <div class="list-group-items force-overflow" id="marcas">

                                        <?php
                                            foreach ($herramientas_proveedores as $marcas) 
                                            {
                                                echo "<div class='list-group-item' >";
                                                    echo "<div class='radio'>";
                                                        echo "<label>";
                                                            echo "<input type='radio' name='radioMarcas' class='marquitas' value='".$marcas->id."'>
                                                                ".$marcas->descripcion;
                                                        echo "</label>";
                                                    echo "</div>";
                                                echo "</div>";
                                            }
                                        ?>
                                        
                                                          
                                                          
                                    </div>
                                </div>
                            </div>
                            <br>
                            

                        </div>

                    </div>
                    <div class="col-md-10 col-sm-10 col-xs-10">
                        <div class="x_panel" style="margin-bottom: 40px;">
                            <div class="x_title">
                                <h2><i class="fa fa-cogs"></i> Productos <small>en el sistema</small></h2>

                                <ul class="nav navbar-right panel_toolbox">
                                  <li>
                                    <a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                                  </li>
                                </ul>
                                <div class="clearfix"></div>
                            </div>
                            <div class="x_content" id="contenedor" style="text-align: center;">

                                
                            </div>
                            <div>
                                <a  id="arriba" class="btn">
                                    <i class="fa fa-arrow-circle-up fa-lg" aria-hidden="true"></i>
                                </a>
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
		        <h4 class="modal-title" id="myModalLabel">Prestar producto</h4>
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
                $("#arriba").click(function()
                {
                    $("body, html").animate({
                        scrollTop: '0px'
                    }, 300);
                });

                $(window).scroll(function()
                {
                    if( $(this).scrollTop() > 0 ){
                        $("#arriba").slideDown(300);
                    } else {
                        $("#arriba").slideUp(300);
                    }
                });

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
                    var id_categoria = null;
                    var categoria = null;

                        id_categoria = $(this).attr("id_categoria");
                        categoria = $(this).text();
                        consulta = "PRODUCTOS_CATEGORIA";

                        $('input[name="radioMarcas"]').prop('checked', false);
                        $(".categoriaActiva").text(categoria);
                        $("#contenedor").html("<img style='text-align:center;' src='dist/img/load_2019.gif'>");

                        $.post( "helper_herramientas.php", { consulta: consulta, id_categoria: id_categoria })
                          .done(function( data ) 
                          {
                            $("#contenedor").html(data);
                        });
                });

                $(".marquitas").on("click", function()
                {
                    var id_marca = null;
                    var marca = null;

                        id_marca = $(this).val();
                        marca = $(this).parents("label").text().trim();
                        consulta = "PRODUCTOS_MARCA";

                        $(".categoriaActiva").text(marca);
                        $("#contenedor").html("<img style='text-align:center;' src='dist/img/load_2019.gif'>");

                        $.post( "helper_herramientas.php", { consulta: consulta, id_marca: id_marca })
                          .done(function( data ) 
                          {
                            $("#contenedor").html(data);
                        });
                });


                $("#buscar_articulo").on("click", function()
                {   
                    var clave = null;
                        clave = $("#clave").val();
                        consulta = "ARTICULO";
                    
                    if (clave != "") 
                    {
                        $(".categoriaActiva").text("");
                        $('input[name="radioMarcas"]').prop('checked', false);
                        $("#contenedor").html("<img style='text-align:center;' src='dist/img/load_2019.gif'>");

                        $.post( "helper_herramientas.php", { consulta: consulta, clave:clave })
                          .done(function( data ) 
                          {
                            $("#contenedor").html(data);
                        });
                    }
                    else
                    {
                        alert("CAPTURE LA CLAVE DEL PRODUCTO...");
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