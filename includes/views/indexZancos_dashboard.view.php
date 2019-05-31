 <?php require_once(VIEW_PATH.'header.inc.php');
 ?>
   
    </style>        
         <!-- page content -->
        <div class="right_col" role="main">
            <div class="">
                <div class="page-title">
                    <div class="title_left">
                        <h3>Zancos (dashboard)...</h3>
                    </div>
                    <div class="title_right pull-right">
                        
                          
                       
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
                                                <?php echo count($zancos_total) + count($zancos_stock); ?>
                                            </h3>
                                        </td>
                                        <td style="vertical-align:middle; text-align: center;">
                                            <i class="fa fa-angle-double-right fa-2x" aria-hidden="true"></i>
                                        </td>
                                        <td>
                                            <table class="table table-bordered table-condensed">
                                                <?php 
                                                    foreach ($zancos_tamanos as $t) 
                                                    {
                                                        $x = 0;
                                                        echo "<tr>";
                                                            echo "<td>".$t->tamano."</td>";
                                                            foreach ($zancos_total as $total) 
                                                            {
                                                                if ($total->tamano == $t->id) 
                                                                {
                                                                    $x++;
                                                                }
                                                            }
                                                            foreach ($zancos_stock as $stock) 
                                                            {
                                                                if ($stock->tamano == $t->id) 
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
                                                <?php echo count($zancos_activo); ?>
                                            </h3>
                                        </td>
                                        <td style="vertical-align:middle; text-align: center;">
                                            <i class="fa fa-angle-double-right fa-2x" aria-hidden="true"></i>
                                        </td>
                                        <td>
                                            <table class="table table-bordered table-condensed" >
                                                <?php 
                                                    foreach ($zancos_tamanos as $t) 
                                                    {
                                                        $x = 0;
                                                        echo "<tr>";
                                                            echo "<td>".$t->tamano."</td>";
                                                            foreach ($zancos_activo as $activo) 
                                                            {
                                                                if ($activo->tamano == $t->id) 
                                                                {
                                                                    $x++;
                                                                }
                                                            }
                                                            echo "<td style='text-align:right;'><button class='btn btn-sm ver' style='background: #218838; color:white; width:50px; ' title='Ver zancos'>".$x."</button></td>";
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
                                            <h3 style="color: black;">CAMPO</h3>
                                        </td>
                                        <td style="background: #E0A800; color: black;  vertical-align:middle; text-align: center;" >
                                            <h3>
                                                <?php echo count($zancos_campo); ?>
                                            </h3>
                                        </td>
                                        <td style="vertical-align:middle; text-align: center; ">
                                            <i class="fa fa-angle-double-right fa-2x" aria-hidden="true"></i>
                                        </td>
                                        <td>
                                            <table class="table table-bordered table-condensed">
                                                <?php 
                                                    foreach ($zancos_tamanos as $t) 
                                                    {
                                                        $x = 0;
                                                        echo "<tr>";
                                                            echo "<td>".$t->tamano."</td>";
                                                            foreach ($zancos_campo as $campo) 
                                                            {
                                                                if ($campo->tamano == $t->id) 
                                                                {
                                                                    $x++;
                                                                }
                                                            }
                                                            echo "<td style='text-align:right;'><button class='btn btn-sm ver' style='background: #E0A800; color: black; width:50px; ' title='Ver zancos'>".$x."</button></td>";
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
                                                            foreach ($zancos_campo as $campo) 
                                                            {
                                                                if ($campo->zona == $z->zona) 
                                                                {
                                                                    $y++;
                                                                }
                                                            }
                                                            echo "<td style='color: black' >".$y."</td>";
                                                            
                                                        } 
                                                    ?>
                                                </tr>
                                                <?php 
                                                    foreach ($zancos_tamanos as $t) 
                                                    {
                                                        echo "<tr>";
                                                            echo "<td>".$t->tamano."</td>";
                                                            foreach ($zancos_zonas as $z)
                                                            {
                                                                
                                                                $w = 0;
                                                                foreach ($zancos_campo as $campo) 
                                                                {
                                                                    if ( ($campo->zona == $z->zona) && ($campo->tamano == $t->id) ) 
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
                                            <i class="fa fa-calendar-times-o fa-3x" aria-hidden="true" style="color: #C82333;"></i>
                                            <h3 style="color: black;">DESFASE</h3>
                                        </td>
                                        <td style="background: #C82333; color: white; vertical-align:middle; text-align: center;" >
                                            <h3>
                                                <?php echo count($zancos_desfase); ?>
                                            </h3>
                                        </td>
                                        <td style="vertical-align:middle; text-align: center; ">
                                            <i class="fa fa-angle-double-right fa-2x" aria-hidden="true"></i>
                                        </td>
                                        <td>
                                            <table class="table table-bordered table-condensed">
                                                <?php 
                                                    foreach ($zancos_tamanos as $t) 
                                                    {
                                                        $x = 0;
                                                        echo "<tr>";
                                                            echo "<td>".$t->tamano."</td>";
                                                            foreach ($zancos_desfase as $desfase) 
                                                            {
                                                                if ($desfase->tamano == $t->id) 
                                                                {
                                                                    $x++;
                                                                }
                                                            }
                                                            echo "<td style='text-align:right;'><button class='btn btn-sm ver' style='background: #C82333; color:white; width:50px; ' title='Ver zancos'>".$x."</button></td>";
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
                                                <tr style="background: #C82333; color: white;">
                                                    <td> TAMANOS / ZONAS</td>
                                                    <?php
                                                        foreach ($zancos_zonas as $z)
                                                        {
                                                            
                                                            echo "<td>".$z->zona."</td>";
                                                            
                                                        } 
                                                    ?>
                                                </tr>
                                                <tr style="border-bottom: 2px solid #C82333;">
                                                    <td> * </td>
                                                    <?php
                                                        foreach ($zancos_zonas as $z)
                                                        {
                                                            
                                                            $y = 0;
                                                            foreach ($zancos_desfase as $desfase) 
                                                            {
                                                                if ($desfase->zona == $z->zona) 
                                                                {
                                                                    $y++;
                                                                }
                                                            }
                                                            echo "<td style='color: #C82333;' >".$y."</td>";
                                                            
                                                        } 
                                                    ?>
                                                </tr>
                                                <?php 
                                                    foreach ($zancos_tamanos as $t) 
                                                    {
                                                        echo "<tr>";
                                                            echo "<td>".$t->tamano."</td>";
                                                            foreach ($zancos_zonas as $z)
                                                            {
                                                                
                                                                $w = 0;
                                                                foreach ($zancos_desfase as $desfase) 
                                                                {
                                                                    if ( ($desfase->zona == $z->zona) && ($desfase->tamano == $t->id) ) 
                                                                    {
                                                                        $w++;
                                                                    }
                                                                }

                                                                if($w > 0)
                                                                {
                                                                    echo "<td style=' background: #F8D7DA; color: black;' >".$w."</td>";
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
                                                <?php echo count($zancos_servicio); ?>
                                            </h3>
                                        </td>
                                        <td style="vertical-align:middle; text-align: center;">
                                            <i class="fa fa-angle-double-right fa-2x" aria-hidden="true"></i>
                                        </td>
                                        <td>
                                            <table class="table table-bordered table-condensed">
                                                <?php 
                                                    foreach ($zancos_tamanos as $t) 
                                                    {
                                                        $x = 0;
                                                        echo "<tr>";
                                                            echo "<td>".$t->tamano."</td>";
                                                            foreach ($zancos_servicio as $servicio) 
                                                            {
                                                                if ($servicio->tamano == $t->id) 
                                                                {
                                                                    $x++;
                                                                }
                                                            }
                                                            echo "<td style='text-align:right;'><button class='btn btn-sm ver' style='background: #0069D9; color: white; width:50px; ' title='Ver zancos'>".$x."</button></td>";
                                                        echo "</tr>";
                                                    }
                                                ?>
                                            </table>
                                        </td>
                                        <td colspan="2"></td>
                                    </tr>

                                    <tr>
                                        
                                        <td style="vertical-align:middle; text-align: center;">
                                            <i class="fa fa-home fa-3x" aria-hidden="true" style="color: #5A6268;"></i>
                                            <h3 style="color: black;">STOCK</h3>
                                        </td>
                                        <td style="background: #5A6268; color: white; vertical-align:middle; text-align: center;">
                                            <h3>
                                                <?php echo count($zancos_stock); ?>
                                            </h3>
                                        </td>
                                        <td style="vertical-align:middle; text-align: center;">
                                            <i class="fa fa-angle-double-right fa-2x" aria-hidden="true"></i>
                                        </td>
                                        <td>
                                            <table class="table table-bordered table-condensed">
                                                <?php 
                                                    foreach ($zancos_tamanos as $t) 
                                                    {
                                                        $x = 0;
                                                        echo "<tr>";
                                                            echo "<td>".$t->tamano."</td>";
                                                            foreach ($zancos_stock as $s) 
                                                            {
                                                                if ($s->tamano == $t->id) 
                                                                {
                                                                    $x++;
                                                                }
                                                            }
                                                            echo "<td style='text-align:right;'><button class='btn btn-sm ver' style='background: #5A6268; color: white; width:50px; ' title='Ver zancos'>".$x."</button></td>";
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
                                                <?php echo count($zancos_mayores); ?>
                                            </h3>
                                        </td>
                                        <td style="vertical-align:middle; text-align: center;">
                                            <i class="fa fa-angle-double-right fa-2x" aria-hidden="true"></i>
                                        </td>
                                        <td>
                                            <table class="table table-bordered table-condensed">
                                                <?php 
                                                    foreach ($zancos_tamanos as $t) 
                                                    {
                                                        $x = 0;
                                                        echo "<tr>";
                                                            echo "<td>".$t->tamano."</td>";

                                                            foreach ($zancos_mayores as $m) 
                                                            {
                                                                if ($m->tamano == $t->id) 
                                                                {
                                                                    $x++;
                                                                }
                                                            }
                                                            echo "<td style='text-align:right;'><button class='btn btn-sm ver' style='background: #138496; color: white; width:50px; ' title='Ver zancos'>".$x."</button></td>";
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
                                                <?php echo count($zancos_retirados); ?>
                                            </h3>
                                        </td>
                                        <td style="vertical-align:middle; text-align: center;">
                                            <i class="fa fa-angle-double-right fa-2x" aria-hidden="true"></i>
                                        </td>
                                        <td>
                                            <table class="table table-bordered table-condensed">
                                                <?php 
                                                    foreach ($zancos_tamanos as $t) 
                                                    {
                                                        $x = 0;
                                                        echo "<tr>";
                                                            echo "<td>".$t->tamano."</td>";

                                                            foreach ($zancos_retirados as $r) 
                                                            {
                                                                if ($r->tamano == $t->id) 
                                                                {
                                                                    $x++;
                                                                }
                                                            }
                                                            echo "<td style='text-align:right;'><button class='btn btn-sm ver' style='background: #563D7C; color: white; width:50px; ' title='Ver zancos'>".$x."</button></td>";
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
		        <h4 class="modal-title" id="myModalLabel">Zancos</h4>
		      </div>
		      <div class="modal-body">
                    <div id="divdestino">
		            </div>
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
                        consulta = "NUEVO";

                    ajaxCargaDatos("divdestino", consulta );
                
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

                function ajaxCargaDatos(divdestino, c)
                {
                    var ajax=creaAjax();

                    ajax.open("GET", "helper_zancos_details.php?consulta="+c, true);
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

                

            }); // end ready
        </script>
</body>

</html>