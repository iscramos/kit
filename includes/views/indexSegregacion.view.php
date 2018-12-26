 <?php require_once(VIEW_PATH.'header.inc.php');
    //include(VIEW_PATH.'indexMenu.php');
 ?>

        <!-- page content -->
        <div class="right_col" role="main">
            <div class="">
                <div class="page-title">
                    <div class="title_left">
                        <h3>Segregación de horas semanales...</h3>
                    </div>
                    <div class="title_right ">
                        <div class="col-md-8 col-sm-8 col-xs-12  pull-right ">
                            <form class='form-inline pull-right'>
                                <div class="form-group hidden">
                                    <input type="number" name="lider" id="lider" class="form-control input-sm" value="<?php echo $lider; ?>" >
                                </div>
                                <div class="form-group">
                                    <label>A&Ntilde;O </label>
                                    <select class="form-control input-sm" id="ano">
                                        <option value='<?php echo date('Y'); ?>' style="display: none;"><?php echo date('Y'); ?></option>

                                        <?php
                                            foreach ($anos as $ano) 
                                            {
                                                echo "<option value='".$ano->ano."' >".$ano->ano."</option>";
                                            }
                                        ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label> WK</label>
                                    <?php
                                        $fechaConsultaFormateada = date("m-d");
                                        $dia = date("Y-m-d");
                                        $calendarios = Disponibilidad_calendarios::getByDia($dia);
                                        $semanaHoy = $calendarios[0]->semana;
                                    ?>
                                    <select class="form-control input-sm" id="semana">
                                        <option value='<?php echo $semanaHoy; ?>' style="display: none;"><?php echo $semanaHoy; ?></option>
                                        <?php
                                            $semanas = Disponibilidad_semanas::getAllByOrden("semana", "ASC");
                                            //print_r($semanas);
                                            foreach ($semanas as $semana)
                                            {
                                                echo "<option value='".$semana->semana."' >".$semana->semana."</option>";
                                            }
                                        ?>
                                    </select>
                                </div>

                                <button type="button" class="btn btn-success btn-sm" title="Traer registros" id="verDisponibilidad"><i class="fa fa-search"></i>
                                </button>
                            </form>
                        </div>
                    </div>

                </div>

                <div class="clearfix"></div>

                <div class="row">
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="x_panel">
                            <div class="x_title">
                                <h2><i class="fa fa-cogs"></i> Datos <small>en el sistema</small></h2>
                                <ul class="nav navbar-right panel_toolbox">
                                  <li>
                                    <a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                                  </li>
                                </ul>
                                <div class="clearfix"></div>
                            </div>
                            <div class="x_content">           
                                <!-- aqui va el contenido -->

                                <div class="row" id="analisis" >   
                                    <!-- /.table-responsive -->
                                </div> 
                                              

                            </div>
                        </div>
                    </div> <!-- fin class='' -->
                </div>
            <div class="clearfix"></div>
        </div>


  		
        


 <?php require_once(VIEW_PATH.'footer.inc.php'); ?>

         <script type="text/javascript">

            $(document).ready(function()
            {
                $("#verDisponibilidad").on("click", function(event) 
                {
                    event.preventDefault();
                    var lider =  $("#lider").val();
                    var semana = $("#semana").val();
                    var ano = $("#ano").val();
                    var parametro = "ANALISIS";

                    //Añadimos la imagen de carga en el contenedor
                    $('#analisis').html('<div style="text-align:center;"><img src="dist/img/loading.gif"/></div>');
                  
                    $.get("helperSegregacion.php", {parametro:parametro, semana:semana, ano:ano, lider:lider} ,function(data)
                    {
                        $("#analisis").html(data);
                    });
                    
                });

            }); // end ready
        </script>
</body>

</html>