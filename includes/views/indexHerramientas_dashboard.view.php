 <?php require_once(VIEW_PATH.'header.inc.php');
 ?>

    <style type="text/css">
        .panel-moradito
        {
            border: 1px solid #8E44AD !important;
        }
        .panel-moradito .panel-heading
        {
            background: #8E44AD;
            color: white;
            border: 5px !important;
        }
        .panel-moradito .panel-body
        {
            /*background: #ECF0F1;*/
            color: black;
        }
        .progress .progress-bar 
        {
            position: initial;
            /*overflow: hidden;*/
            line-height: 20px;
        }
    </style>
        
         <!-- page content -->
        <div class="right_col" role="main">
            <div class="">
                <div class="page-title">
                    <div class="title_left">
                        <h3>Productos (dashboard)...</h3>
                    </div>
                    <div class="title_right pull-right">
                        <a href="indexHerramientas_herramientas.php" class="btn btn-default">
                            <i class="fa fa-plus" aria-hidden="true"></i> Producto
                        </a>
                        <a href="indexHerramientas_transacciones.php" class="btn btn-default" title="Ver historial de movimientos">
                            <i class="fa fa-plus" aria-hidden="true"></i> Despacho
                        </a>
                        <a href="indexHerramientas_movimientos_actualizar.php?action=NEW&reg=0&mov=0&clave=0" class="btn btn-default">
                            <i class="fa fa-plus" aria-hidden="true"></i> Préstamo
                        </a>
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
                                <div style="text-align: center;">
                                    <h3>Al: </b> <?php echo $fecha_hoy; ?> </h3>
                                    <h4>WK:  <?php echo $semana_actual; ?> </h4>
                                </div>
                                <br>
                                <?php
                                foreach ($categorias as $cate) 
                                {
                                    $total = 0;
                                    $p_prestados = 0;
                                    $p_disponibles = 0;

                                    $retirados = 0;
                                    foreach ($herramientas_retirados as $r) 
                                    {
                                        if($r->id_categoria == $cate->id)
                                        {
                                            $retirados = $r->retirados;
                                        }
                                    }

                                    $prestados = 0;
                                    foreach ($herramientas_prestadas as $p) 
                                    {
                                        if($p->id_categoria == $cate->id)
                                        {
                                            $prestados = $p->prestados;
                                        }
                                    }

                                    $disponibles = 0;
                                    foreach ($herramientas_disponibles as $d) 
                                    {
                                        if($d->id_categoria == $cate->id)
                                        {
                                            $disponibles = $d->disponibles;
                                        }
                                    }

                                    $stock = 0;
                                    foreach ($herramientas_stock as $s) 
                                    {
                                        if($s->id_categoria == $cate->id)
                                        {
                                            $stock = $s->stock;
                                        }
                                    }

                                    $disponibles = $disponibles + $stock;
                                    $total = $disponibles + $prestados;

                                    if($total > 0)
                                    {
                                        $p_prestados = round( (($prestados * 100 ) / $total), 2);
                                        $p_disponibles = round( (($disponibles * 100 ) / $total), 2);
                                        //echo $p_disponibles."<br>";
                                    }
                                    

                                    //echo "<br>".$p_disponibles;
                                    echo "<div class='col-sm-4'>";
                                        echo "<div class='panel panel-default'>";
                                            echo "<div class='panel-heading'>".$cate->categoria."</div>";
                                                echo "<div class='panel-body'>";
                                                    /*<p>Aquí va el texto----</p>*/
                                                    echo "<div class='row'>";
                                                        echo "<div class='col col-md-12'>";
                                                            echo "<button class='btn btn-danger btn-sm pull-right' type='button'>
                                                              Retirados <span class='badge'>".$retirados."</span>
                                                            </button><br>";

                                                            echo "<span class='pull-left strong'>Total</span><br>";
                                                             echo "<div class='progress'>";
                                                                echo "<div class='progress-bar progress-bar-primary' role='progressbar' aria-valuenow='100' aria-valuemin='0' aria-valuemax='100' style='width:100%'>".$total."</div>";
                                                            echo "</div>";
                                                        
                                                            /*echo "Disponibles <span class='pull-right strong'>+ 30%</span>";
                                                            echo "<div class='progress'>";
                                                                echo "<div class='progress-bar progress-bar-success' role='progressbar' aria-valuenow='30'aria-valuemin='0' aria-valuemax='100' style='width:30%'>".$disponibles."</div>";
                                                            echo "</div>";*/

                                                            echo "<span class='pull-left strong'>Prestadas</span>";
                                                            echo "<span class='pull-right strong'>Disponibles</span>";
                                                            echo "<br>";
                                                            echo "<div class='progress'>";
                                                                echo "<div class='progress-bar progress-bar-warning' style='width: ".$p_prestados."%'>".$prestados."
                                                                  </div>";

                                                                echo "<div class='progress-bar progress-bar-success' style='width: ".$p_disponibles."%'>".$disponibles."
                                                                  </div>";
                                                            echo "</div>";
                                                            
                                                    echo "</div>";
                                                echo "</div>";
                                            echo "</div>"; // fin del panel body
                                        echo "</div>"; // fin del panel
                                    echo "</div>"; // fin del col-sm-4
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
		<div class="modal fade bs-example-modal-lg" id="modalAgregar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		  <div class="modal-dialog modal-lg" role="document">
		    <div class="modal-content">
		      <div class="modal-header">
		        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		        <h4 class="modal-title" id="myModalLabel">Zancos</h4>
		      </div>
		      <div class="modal-body">
                    <div id="divdestino">
		            </div>
		      </div>
		      <div class="modal-footer" style="text-align: center;">
                <button type="button" class="btn btn-success" data-dismiss="modal">Cerrar</button>
              </div>
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
                
       

                $(".ver").on("click", function(event) 
                { 
                    event.preventDefault();
                    var consulta = null;
                    var tamano = null;
                    var titulo = null;
                        consulta = $(this).attr("consulta");
                        tamano = $(this).attr("tamano");
                        titulo = consulta.toLowerCase();

                    ajaxCargaDatos("divdestino", consulta, tamano, titulo);

                
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

                function ajaxCargaDatos(divdestino, c, t, nombre)
                {
                    var ajax=creaAjax();

                    ajax.open("GET", "helper_zancos_details.php?consulta="+c+"&tamano="+t, true);
                    ajax.onreadystatechange=function() 
                    { 
                        if (ajax.readyState==1)
                        {
                          // Mientras carga ponemos un letrerito que dice "Verificando..."
                          $('#'+divdestino).html("<img src='dist/img/load_2019.gif'>");
                        }
                        if (ajax.readyState==4)
                        {
                          // Cuando ya terminó, ponemos el resultado
                            var str =ajax.responseText; 
                            
                            $("#myModalLabel").text("Zancos "+ nombre);                        
                            $('#'+divdestino).html(''+str+'');
                            $("#modalAgregar").modal("show");
                
                        } 
                    }
                    ajax.send(null);
                }

                

            }); // end ready

            

        </script>
</body>

</html>