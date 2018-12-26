<?php 
  require_once(VIEW_PATH.'header.inc.php');
  
    //include(VIEW_PATH.'indexMenu.php');
 ?>
  
  <!-- page content -->
  <div class="right_col" role="main">
    <!-- top tiles -->
    <div class="row tile_count">
      
      <div class="col-md-2 col-sm-2 col-xs-2 tile_stats_count">
        <span class="count_top"><i class="fa fa-clock-o"></i> Week</span>
        <?php 
          $fechaConsulta = date("d/m/Y");
          $fechaConsultaFormateada = date("m-d");
          $semanaActual = Calendario_nature::getSemanaByFecha($fechaConsultaFormateada);
          echo "<div class='count green'>".$semanaActual[0]->semana."</div>";
          echo "<span class='count_bottom'> ".$fechaConsulta."</span>";
          
          echo "<input class='form-control hidden' name='parametroSemana' id='parametroSemana' value='".$semanaActual[0]->semana."'>";

        ?>
        
 
      </div>

      <div class="col-md-4 col-sm-4 col-xs-4 tile_stats_count">
        <span class="count_top"><i class="fa fa-folder-open"></i> Archivo de carga (ordenes.xlsx)</span>
        
          <form name="importa" action="importar.php" method="POST" enctype="multipart/form-data">
             <div class='form-group'>
                  <div class='col-sm-10'>  
                      <input type='file' id='archivo' name='archivo' onChange='extensionCHK(this);' required>
                      <button type="submit" class="btn btn-success btn-xs"> <span class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></span> Cargar...</button>
                  </div>
              </div>
              <div class='form-group hidden' >
                  <label class='col-sm-2 control-label' >Líder</label>
                  <div class="col-sm-10">
                      <input type="number" class='form-control hidden' name='lider' id='lider' value='<?php echo $lider; ?>'>
                  </div>
              </div>
              
          </form>
  
      </div>

      <div class="col-md-6 col-sm-6 col-xs-6 tile_stats_count">
        <span class="count_top"><i class="fa fa-hand-o-down"></i> Elige el tipo de disponibilidad + parámetros...</span>
        <div class="row">
            <div class="col-lg-12 text-left">
                
                <a type="button" class="btn  btn-social btn-xs muestraAnual btn-github">
                    <i class="fa fa-calendar" aria-hidden="true"></i> Anual
                </a>
                <a type="button" class="btn  btn-social btn-xs muestraMes btn-github">
                    <i class="fa fa-calendar-check-o" aria-hidden="true"></i> Mensual
                </a>
            </div>
        </div>
        <div class="row verAnual hidden">
            <div class="col-lg-12 text-left">
               <form class='form-inline'>
                    <div class="form-group">
                        <select class="form-control input-sm" id="ano">
                            <option value='<?php echo date('Y'); ?>' style="display: none;"><?php echo date('Y'); ?></option>
                            <option value='2016' ">2016</option>
                            <option value='2017' ">2017</option>
                            <option value='2018' ">2018</option>
                        </select>
                    </div>
                    <button type="button" class="btn btn-success btn-circle btn-sm" title="Traer registros" id="verDisponibilidadGeneral"><i class="fa fa-database"></i>
                </button>
                </form>
            </div>
                    
        </div>
        <!-- /.row -->
        <div class="row verMes hidden">
            <div class="col-lg-12 text-left">
                <form class='form-inline'>
                    <div class="form-group">
                        <select class="form-control input-sm" id="mes">
                            <option value='<?php echo date('m');?>' style="display: none;">
                            <?php
                                $meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
                                echo $meses[date('n')-1];
                            ?>
                                
                            </option>
                            <option value='01' ">Enero</option>
                            <option value='02' ">Febrero</option>
                            <option value='03' ">Marzo</option>
                            <option value='04' ">Abril</option>
                            <option value='05' ">Mayo</option>
                            <option value='06' ">Junio</option>
                            <option value='07' ">Julio</option>
                            <option value='08' ">Agosto</option>
                            <option value='09' ">Septiembre</option>
                            <option value='10' ">Octubre</option>
                            <option value='11' ">Noviembre</option>
                            <option value='12' ">Diciembre</option>

                        </select>
                    </div>

                    <div class="form-group">
                        <select class="form-control input-sm" id="ano">
                            <option value='<?php echo date('Y'); ?>' style="display: none;"><?php echo date('Y'); ?></option>
                            <option value='2016' ">2016</option>
                            <option value='2017' ">2017</option>
                            <option value='2018' ">2018</option>
                        </select>
                    </div>
                    <button type="button" class="btn btn-success btn-circle btn-sm" title="Traer registros" id="verDisponibilidadMes"><i class="fa fa-database"></i>
                </button>
                </form>
            </div>
            <!-- /.col-lg-12 -->
        </div>
        <!-- /.row -->
  
      </div>


      
    <!-- /top tiles -->

    <div class="row loading efecto">
      <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="dashboard_graph">

          <div class="row x_title">
            <div class="col-md-6">
              <h3>Disponibilidad general</h3>
            </div>
            
          </div>

          <div class="col-md-12 col-sm-12 col-xs-12 table-responsive" id="disponibilidadMes">
            <!-- El contenido -->
            

          </div>
          <div class="col-md-12 col-sm-12 col-xs-12 table-responsive" id="disponibilidadGeneral">
            <!-- El contenido -->
            

          </div>

          <!-- /.row -->
                              

          <div class="clearfix"></div>
        </div>
      </div>

    </div>
    <br />      

  </div>

                  

  		
 <?php require_once(VIEW_PATH.'footer.inc.php'); ?>

         <script type="text/javascript">
            //$('[data-toggle="tooltip"]').tooltip();
            /*$('[data-toggle="confirmation"]').confirmation(
            {
                title: '¿Eliminar?',
                btnOkLabel : '<i class="icon-ok-sign icon-white"></i> Si',
                      
                onConfirm: function(event) {
                  var idR = $(this).parents("tr").attr("campoid");
                  window.location.href='deleteUser.php?id='+idR;
                },
            });*/

            $(document).ready(function()
            {
                $(".muestraAnual").click(function(event) 
                {
                    event.preventDefault();
                    //alert("entro anual");
                    $("#disponibilidadGeneral").html("");
                    $("#disponibilidadMes").html("");
                    $(".verAnual").removeClass("hidden");
                    $(".verMes").addClass("hidden");
                });

                $(".muestraMes").click(function(event) 
                {
                    event.preventDefault();
                    //alert("entro mes");
                    $("#disponibilidadGeneral").html("");
                    $("#disponibilidadMes").html("");
                    $(".verAnual").addClass("hidden");
                    $(".verMes").removeClass("hidden");
                });

                $("#verDisponibilidadGeneral").click(function(event) 
                {
                    event.preventDefault();
                    var ano = $("#ano").val();
                    var parametro = "DISPONIBILIDADGENERAL";

                    //Añadimos la imagen de carga en el contenedor
                    $('#disponibilidadGeneral').html('<div style="text-align:center;"><img  src="dist/img/loading.gif"/></div>');
                  
                    $.get("helperDisponibilidadGeneral.php", {parametro:parametro, ano:ano} ,function(data)
                    {
                        $("#disponibilidadGeneral").html(data);
                    });
                    
                });


                $("#verDisponibilidadMes").click(function(event) 
                {
                    event.preventDefault();
                    var mes = $("#mes").val();
                    var ano = $("#ano").val();
                    var parametro = "DISPONIBILIDADMES";

                    //Añadimos la imagen de carga en el contenedor
                    $('#disponibilidadMes').html('<div style="text-align:center;"><img  src="dist/img/loading.gif"/></div>');
                  
                    $.get("helperDisponibilidadMes.php", {parametro:parametro, mes:mes, ano:ano} ,function(data)
                    {
                        $("#disponibilidadMes").html(data);
                    });
                    
                });// fin de disponibilidad

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

                    ajax.open("GET", "updateUser.php?id="+uID, true);
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

                $("#mensaje").show(function showAlert() {
                    $(".alert").alert();
                    $(".alert").fadeTo(2000, 700).slideUp(700, function(){
                   $(".alert").slideUp(2000);
                    });   
                });

            }); // end ready
        </script>

        <script type="text/javascript">
        function extensionCHK(campo)
        {
            var src = campo.value;
            var log = src.length;
            
            /*var pdf = log - 3;
            var wpdf = src.substring(pdf, log);
                wpdf = wpdf.toUpperCase();*/

            // para .XLSX
            var xlsx = log - 4;
            var wsubc = src.substring(xlsx, log);
                wsubc = wsubc.toUpperCase();
          
          //this.files[0].size gets the size of your file.
          var tamano = $("#archivo")[0].files[0].size;
          
          if (tamano > 10485760)
          {
            //alert('El archivo a subir debe ser menor a 1MB');
            $("#archivo").val("");
            $("#mensaje").removeClass("hidden");
            $("#tam").text("El archivo pesa más de 10MB.");
          
          }

          else if(wsubc!='XLSX')
          {
            //alert('El archivo a subir debe ser una imagen JPG, o PDF');
            $("#archivo").val("");
            $("#mensaje").removeClass("hidden");
            $("#ext").text("El archivo debe ser un XLSX");
            
          }
          else
          {
            $("#mensaje").addClass("hidden");
            $("#tam").text("");
            $("#ext").text("");
            
          }
        }
    </script>
</body>

</html>