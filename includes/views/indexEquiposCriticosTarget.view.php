 <?php require_once(VIEW_PATH.'header.inc.php');
    
 ?>

        <!-- page content -->
        <div class="right_col" role="main">
            <div class="">
                <div class="page-title">
                    <div class="title_left">
                        <h3>Equipos parados...</h3>
                    </div>

                </div>

                <div class="clearfix"></div>

                <div class="row">
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="x_panel">
                            <div class="x_title">
                                <h2><i class="fa fa-cogs"></i> Mantenimientos <small>correctivos</small></h2>
                                <ul class="nav navbar-right panel_toolbox">
                                  <li>
                                    <a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                                  </li>
                                </ul>
                                <div class="clearfix"></div>
                            </div>
                            <div class="x_content">


                                <?php
                                    $consulta = "SELECT * FROM disponibilidad_data
                                                    WHERE tipo <> 'Mant. preventivo'
                                                        AND (estado = 'Ejecutado'
                                                            OR estado = 'Programada'
                                                            OR estado = 'Abierta'
                                                            OR estado = 'Falta mano de obra'
                                                            OR estado = 'Espera de refacciones'
                                                            OR estado = 'Espera de equipo' )
                                                        ORDER BY fecha_inicio_programada ASC";
                                    $ordenes = Disponibilidad_data::getAllByQuery($consulta); // Para las ordenes no terminadas
                                    
                                    //print_r($ordenes);
                                    foreach ($activos_equipos as $critico) 
                                    {
                                        //$no_ot = 0;
                                        $enciendeParado = 0;
                                        $colorEstatus = "";

                                        foreach ($ordenes as $ot) 
                                        {
                                            if($ot->equipo == $critico->activo)
                                            {
                                                
                                                //echo $ot["equipo"]."<br>";
                                                $enciendeParado = 1;
                                            
                                            }
                                        }


                                        if ($enciendeParado == 1)
                                        {

                                            //$colorEstatus = "bs-callout bs-callout-red";
                                            echo "<div class='col-xs-6 col-sm-2 col-md-2'>";
                                            echo "<div  style='margin-bottom: 20px; border: 1px solid #ddd; border-radius: 4px;'>";
                                                if(strpos($critico->activo, 'CO-TRC') !== false)
                                                {
                                                    echo "<img src='".$url."dist/img/tractor.png' alt='...' class='img-responsive'>";
                                                }
                                                else if(strpos($critico->descripcion, 'CO-CAM') !== false)
                                                {
                                                     echo "<img src='".$url."dist/img/volteo.png' alt='...' class='img-responsive'>";
                                                }
                                                else if($critico->familia == "FUMIGACION")
                                                {
                                                    echo "<img src='".$url."dist/img/parihuela.png' alt='...' class='img-responsive'>";
                                                }
                                                else if(strpos($critico->activo, 'CO-TOL') !== false)
                                                {
                                                     echo "<img src='".$url."dist/img/tolva.png' alt='...' class='img-responsive'>";
                                                }
                                                else if(strpos($critico->activo, 'CO-GEN') !== false)
                                                {
                                                     echo "<img src='".$url."dist/img/generador.png' alt='...' class='img-responsive'>";
                                                }
                                                else if(strpos($critico->activo, 'CO-TRA-0') !== false)
                                                {
                                                     echo "<img src='".$url."dist/img/transformador.png' alt='...' class='img-responsive'>";
                                                }
                                                else if(strpos($critico->activo, 'CO-ENF') !== false)
                                                {
                                                     echo "<img src='".$url."dist/img/camara.png' alt='...' class='img-responsive'>";
                                                }
                                                else if(strpos($critico->activo, 'CO-MON') !== false)
                                                {
                                                     echo "<img src='".$url."dist/img/montacargas.png' alt='...' class='img-responsive'>";
                                                }
                                                else if(strpos($critico->activo, 'CO-SEC') !== false)
                                                {
                                                     echo "<img src='".$url."dist/img/lavadora.png' alt='...' class='img-responsive'>";
                                                }
                                                else if(strpos($critico->activo, 'CO-POZ') !== false)
                                                {
                                                     echo "<img src='".$url."dist/img/pozo.png' alt='...' class='img-responsive'>";
                                                }
                                                else if(strpos($critico->activo, 'CO-COR') !== false)
                                                {
                                                     echo "<img src='".$url."dist/img/controlador.png' alt='...' class='img-responsive'>";
                                                }
                                                else if(strpos($critico->activo, 'CO-CIS') !== false)
                                                {
                                                     echo "<img src='".$url."dist/img/cisterna.png' alt='...' class='img-responsive'>";
                                                }
                                                else if(strpos($critico->activo, 'CO-TRA-PER') !== false)
                                                {
                                                     echo "<img src='".$url."dist/img/tarima_personal.png' alt='...' class='img-responsive'>";
                                                }
                                                else if(strpos($critico->activo, 'CO-TRA-PLM') !== false)
                                                {
                                                     echo "<img src='".$url."dist/img/tarima_plana.png' alt='...' class='img-responsive'>";
                                                }
                                                else if(strpos($critico->activo, 'CO-MEZ') !== false)
                                                {
                                                     echo "<img src='".$url."dist/img/mezclador.png' alt='...' class='img-responsive'>";
                                                }
                                                else if(strpos($critico->activo, 'CO-BMU') !== false)
                                                {
                                                     echo "<img src='".$url."dist/img/bomba.png' alt='...' class='img-responsive'>";
                                                }
                                                else
                                                {
                                                    echo "<img src='' alt='...' class='img-responsive'>";
                                                }
                                                
                                                echo "<div class='caption'> ";
                                                    echo "<p style='font-size:10px;'>".$critico->activo."</p>";
                                                    //echo "<p style='font-size:9px;'>".utf8_encode($critico->descripcion)."</p>";
                                                    echo "<p>
                                                            <a href='#' class='btn btn-primary btn-xs detalles' equipo='".$critico->activo."' role='button' title='".$critico->descripcion."'>Detalles</a> 
                                                            <!--a href='#' class='btn btn-default' role='button'>Button</a-->
                                                        </p>";
                                                echo "</div>";
                                            echo "</div>";
                                        echo "</div>"; 
                                        }
                                        /*else
                                        {
                                            $colorEstatus = "bs-callout bs-callout-success";
                                        }*/
                                          
                                    }
                                ?>

                            </div> <!-- fin del x-content -->
                        </div>
                    </div>
                </div> <!-- fin class='' -->
          </div>
          <div class="clearfix"></div>
        </div> 
        <!-- /page content -->

        


  		<!-- Modal -->
		<div class="modal fade" id="modalDetalles" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		  <div class="modal-dialog modal-lg" role="document">
		    <div class="modal-content">
		      <div class="modal-header">
		        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		        <h4 class="modal-title" id="myModalLabel">Detalles de parada</h4>
		      </div>
		      <div class="modal-body" id="divdestino">
                
		      
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
             

                $(".detalles").on("click", function(event) 
                { 
                    event.preventDefault();
                    var v = 0;
                        v = $(this).attr("equipo");
                        //alert(v);
                    ajaxCargaDatos("divdestino", v);
                
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

                    ajax.open("GET", "helperDetallesCritico.php?equipo="+uID, true);
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
                            $("#modalDetalles").modal("show");
                
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
        });
    </script>

    </body>
</html>