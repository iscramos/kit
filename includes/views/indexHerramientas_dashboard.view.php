 <?php require_once(VIEW_PATH.'header.inc.php');
 ?>
        
         <!-- page content -->
        <div class="right_col" role="main">
            <div class="">
                <div class="page-title">
                    <div class="title_left">
                        <h3>Almacén (dashboard)...</h3>
                    </div>
                    <div class="title_right pull-right">
                        <a href="indexHerramientas_herramientas.php" class="btn btn-default" title="Alta de productos">
                            <i class="fa fa-plus" aria-hidden="true"></i> Producto
                        </a>
                        <a href="indexHerramientas_salidas.php" class="btn btn-default" title="Despachar productos">
                            <i class="fa fa-plus" aria-hidden="true"></i> Despacho
                        </a>
                        <a href="indexHerramientas_movimientos_actualizar.php?action=NEW&reg=0&mov=0&clave=0" class="btn btn-default" title="Préstamos">
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
                                <table class="table table-condensed table-striped">
                                    <tr>
                                        
                                        <td style="vertical-align:middle; text-align: center;">
                                            <i class="fa fa-database fa-3x" aria-hidden="true" style="color: #2DB67C;"></i>
                                            <h3 style="color: black;">TOTAL</h3>
                                        </td>
                                        <td style="background: #2DB67C; color:white; vertical-align:middle; text-align: center;">
                                            <h3>
                                                <?php echo count($herramientas_disponibles) + count($herramientas_prestadas) + count($herramientas_servicio) + count($herramientas_stock); ?>
                                            </h3>
                                        </td>
                                        <td style="vertical-align:middle; text-align: center;">
                                            <i class="fa fa-angle-double-right fa-2x" aria-hidden="true"></i>
                                        </td>
                                        <td>
                                            <table class="table table-bordered table-condensed">
                                                <?php 
                                                    foreach ($categorias as $c) 
                                                    {
                                                        $x = 0;
                                                        echo "<tr>";
                                                            echo "<td>".$c->categoria."</td>";
                                                            foreach ($herramientas_disponibles as $d) 
                                                            {
                                                                if ($d->id_categoria == $c->id) 
                                                                {
                                                                    $x++;
                                                                }
                                                            }
                                                            foreach ($herramientas_prestadas as $p) 
                                                            {
                                                                if ($p->id_categoria == $c->id) 
                                                                {
                                                                    $x++;
                                                                }
                                                            }

                                                            foreach ($herramientas_servicio as $s) 
                                                            {
                                                                if ($s->id_categoria == $c->id) 
                                                                {
                                                                    $x++;
                                                                }
                                                            }

                                                            foreach ($herramientas_stock as $stock) 
                                                            {
                                                                if ($stock->id_categoria == $c->id) 
                                                                {
                                                                    $x++;
                                                                }
                                                            }
                                                            echo "<td style='text-align:right;'><button class='btn btn-sm' style='background: #2DB67C; color:white; width:50px; ' title='Ver zancos'>".$x."</button></td>";
                                                        echo "</tr>";
                                                    }
                                                ?>
                                            </table>
                                        </td>
                                        <td colspan="2"></td>
                                    </tr>
                                    <tr>
                                        
                                        <td style="vertical-align:middle; text-align: center;">
                                            <i class="fa fa-thumbs-up fa-3x" aria-hidden="true" style="color: #218838;"></i>
                                            <h3 style="color: black;">DISPONIBLES</h3>
                                        </td>
                                        <td style="background: #218838; color:white; vertical-align:middle; text-align: center;">
                                            <h3>
                                                <?php echo count($herramientas_disponibles) + count($herramientas_stock); ?>
                                            </h3>
                                        </td>
                                        <td style="vertical-align:middle; text-align: center;">
                                            <i class="fa fa-angle-double-right fa-2x" aria-hidden="true"></i>
                                        </td>
                                        <td>
                                            <table class="table table-bordered table-condensed" >
                                                <?php 
                                                    foreach ($categorias as $c) 
                                                    {
                                                        $x = 0;
                                                        echo "<tr>";
                                                            echo "<td>".$c->categoria."</td>";
                                                            foreach ($herramientas_disponibles as $d) 
                                                            {
                                                                if ($d->id_categoria == $c->id) 
                                                                {
                                                                    $x++;
                                                                    
                                                                }
                                                            }

                                                            foreach ($herramientas_stock as $s) 
                                                            {
                                                                if ($s->id_categoria == $c->id) 
                                                                {
                                                                    $x++;
                                                                }
                                                            }
                                                            echo "<td style='text-align:right;'><button consulta='DISPONIBLES' categoria='".$c->id."' class='btn btn-sm ver' style='background: #218838; color:white; width:50px; ' title='Ver zancos'>".$x."</button></td>";
                                                        echo "</tr>";
                                                    }
                                                ?>
                                            </table>
                                        </td>
                                        <td colspan="2"></td>
                                    </tr>
                                    <tr>
                                        
                                        <td style="vertical-align:middle; text-align: center;">
                                            <i class="fa fa-industry fa-3x" aria-hidden="true" style="color: #E0A800;"></i>
                                            <h3 style="color: black;">PRESTADAS</h3>
                                        </td>
                                        <td style="background: #E0A800; color: black;  vertical-align:middle; text-align: center;" >
                                            <h3>
                                                <?php echo count($herramientas_prestadas); ?>
                                            </h3>
                                        </td>
                                        <td style="vertical-align:middle; text-align: center; ">
                                            <i class="fa fa-angle-double-right fa-2x" aria-hidden="true"></i>
                                        </td>
                                        <td>
                                            <table class="table table-bordered table-condensed">
                                                <?php 
                                                    foreach ($categorias as $c) 
                                                    {
                                                        $x = 0;
                                                        echo "<tr>";
                                                            echo "<td>".$c->categoria."</td>";
                                                            foreach ($herramientas_prestadas as $p) 
                                                            {
                                                                if ($p->id_categoria == $c->id) 
                                                                {
                                                                    $x++;
                                                                }
                                                            }
                                                            echo "<td style='text-align:right;'><button consulta='CAMPO' categoria='".$c->id."' 
                                                            class='btn btn-sm ver' style='background: #E0A800; color: black; width:50px; ' title='Ver zancos'>".$x."</button></td>";
                                                        echo "</tr>";
                                                    }
                                                ?>
                                            </table>
                                        </td>
                                        <td style="vertical-align:middle; text-align: center;">
                                            <i class="fa fa-angle-double-right fa-2x" aria-hidden="true"></i>
                                        </td>
                                        <td>
                                            <table class="table table-bordered table-condensed">
                                                <tr style="background: #E0A800; color: black;">
                                                    <td> TAMANOS / ZONAS</td>
                                                    <?php
                                                        foreach ($zancos_zonas as $z)
                                                        {
                                                            
                                                            echo "<td>".$z->zona."</td>";
                                                            
                                                        } 
                                                    ?>
                                                </tr>
                                                <tr style="border-bottom: 2px solid #E0A800;;">
                                                    <td> * </td>
                                                    <?php
                                                        foreach ($zancos_zonas as $z)
                                                        {
                                                            
                                                            $y = 0;
                                                            foreach ($herramientas_prestadas as $p) 
                                                            {
                                                                if ($p->zona == $z->zona) 
                                                                {
                                                                    $y++;
                                                                }
                                                            }
                                                            echo "<td style='color: black' >".$y."</td>";
                                                            
                                                        } 
                                                    ?>
                                                </tr>
                                                <?php 
                                                    foreach ($categorias as $c) 
                                                    {
                                                        echo "<tr>";
                                                            echo "<td>".$c->categoria."</td>";
                                                            foreach ($zancos_zonas as $z)
                                                            {
                                                                
                                                                $w = 0;
                                                                foreach ($herramientas_prestadas as $p) 
                                                                {
                                                                    if ( ($p->zona == $z->zona) && ($p->id_categoria == $c->id) ) 
                                                                    {
                                                                        $w++;
                                                                    }
                                                                }

                                                                if($w > 0)
                                                                {
                                                                    echo "<td style=' background: #FFF3CD; color: black;' >".$w."</td>";
                                                                }
                                                                else
                                                                {
                                                                    echo "<td  >".$w."</td>";
                                                                }
                                                                
                                                            } 
                                                        echo "</tr>";
                                                    }
                                                ?>
                                            </table>
                                        </td>
                                    </tr>


                                    <tr>
                                        
                                        <td style="vertical-align:middle; text-align: center;">
                                            <i class="fa fa-wrench fa-3x" aria-hidden="true" style="color: #0069D9;"></i>
                                            <h3 style="color: black;">SERVICIO</h3>
                                        </td>
                                        <td style="background: #0069D9; color: white; vertical-align:middle; text-align: center;">
                                            <h3>
                                                <?php echo count($herramientas_servicio); ?>
                                            </h3>
                                        </td>
                                        <td style="vertical-align:middle; text-align: center;">
                                            <i class="fa fa-angle-double-right fa-2x" aria-hidden="true"></i>
                                        </td>
                                        <td>
                                            <table class="table table-bordered table-condensed">
                                                <?php 
                                                    foreach ($categorias as $c) 
                                                    {
                                                        $x = 0;
                                                        echo "<tr>";
                                                            echo "<td>".$c->categoria."</td>";
                                                            foreach ($herramientas_servicio as $s) 
                                                            {
                                                                if ($s->id_categoria == $c->id) 
                                                                {
                                                                    $x++;
                                                                }
                                                            }
                                                            echo "<td style='text-align:right;'><button consulta='SERVICIO' categoria='".$c->id."' class='btn btn-sm ver' style='background: #0069D9; color: white; width:50px; ' title='Ver registros'>".$x."</button></td>";
                                                        echo "</tr>";
                                                    }
                                                ?>
                                            </table>
                                        </td>
                                        <td colspan="2"></td>
                                    </tr>

                                    <tr>
                                        
                                        <td style="vertical-align:middle; text-align: center;">
                                            <i class="fa fa-heartbeat fa-3x" aria-hidden="true" style="color: #138496;"></i>
                                            <h3 style="color: black;">MAYOR A 1.5 AÑOS</h3>
                                        </td>
                                        <td style="background: #138496; color: white; vertical-align:middle; text-align: center;">
                                            <h3>
                                                <?php echo count($herramientas_mayores); ?>
                                            </h3>
                                        </td>
                                        <td style="vertical-align:middle; text-align: center;">
                                            <i class="fa fa-angle-double-right fa-2x" aria-hidden="true"></i>
                                        </td>
                                        <td>
                                            <table class="table table-bordered table-condensed">
                                                <?php 
                                                    foreach ($categorias as $c) 
                                                    {
                                                        $x = 0;
                                                        echo "<tr>";
                                                            echo "<td>".$c->categoria."</td>";

                                                            foreach ($herramientas_mayores as $m) 
                                                            {
                                                                if ($m->id_categoria == $c->id) 
                                                                {
                                                                    $x++;
                                                                }
                                                            }
                                                            echo "<td style='text-align:right;'><button consulta='MAYOR A 1.5 AÑOS' categoria='".$c->id."' class='btn btn-sm ver' style='background: #138496; color: white; width:50px; ' title='Ver registros'>".$x."</button></td>";
                                                        echo "</tr>";
                                                    }
                                                ?>
                                            </table>
                                        </td>
                                        <td colspan="2"></td>
                                    </tr>

                                    <tr>
                                        
                                        <td style="vertical-align:middle; text-align: center;">
                                            <i class="fa fa-times fa-3x" aria-hidden="true" style="color: #563D7C;"></i>
                                            <h3 style="color: black;">RETIRADOS</h3>
                                        </td>
                                        <td style="background: #563D7C; color: white; vertical-align:middle; text-align: center;">
                                            <h3>
                                                <?php echo count($herramientas_retirados); ?>
                                            </h3>
                                        </td>
                                        <td style="vertical-align:middle; text-align: center;">
                                            <i class="fa fa-angle-double-right fa-2x" aria-hidden="true"></i>
                                        </td>
                                        <td>
                                            <table class="table table-bordered table-condensed">
                                                <?php 
                                                    foreach ($categorias as $c) 
                                                    {
                                                        $x = 0;
                                                        echo "<tr>";
                                                            echo "<td>".$c->categoria."</td>";

                                                            foreach ($herramientas_retirados as $r) 
                                                            {
                                                                if ($r->id_categoria == $c->id) 
                                                                {
                                                                    $x++;
                                                                }
                                                            }
                                                            echo "<td style='text-align:right;'><button consulta='RETIRADOS' categoria='".$c->id."' class='btn btn-sm ver' style='background: #563D7C; color: white; width:50px; ' title='Ver registros'>".$x."</button></td>";
                                                        echo "</tr>";
                                                    }
                                                ?>
                                            </table>
                                        </td>
                                        <td colspan="2"></td>
                                    </tr>
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
        <div class="modal fade bs-example-modal-lg" id="modalAgregar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
          <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Productos</h4>
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
                    var categoria = null;
                    var titulo = null;
                        consulta = $(this).attr("consulta");
                        categoria = $(this).attr("categoria");
                        titulo = consulta.toLowerCase();

                    ajaxCargaDatos("divdestino", consulta, categoria, titulo);

                
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

                    ajax.open("GET", "helper_herramientas_details.php?consulta="+c+"&categoria="+t, true);
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
                            
                            $("#myModalLabel").text("Herramientas "+ nombre);                        
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