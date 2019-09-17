<?php
    require_once('includes/config.inc.php');
    require_once(VIEW_PATH.'headerGeneral.inc.php');
    //include(VIEW_PATH.'indexMenu.php');
    // creamos una sesión publica
    session_start();
    $email = "invitado";
    $password = 123; 
                  
    $password = base64_encode($password);

    $usr_correo = Usuarios::buscaUsuarioByEmailPassword($email, $password);
      
    // If result matched $email and $mypassword, table row must be 1 row 
    if(isset($usr_correo[0]))
    {
      $_SESSION['Login']['id']=$usr_correo[0]->id;
      $_SESSION["type"] = $usr_correo[0]->type;
      $_SESSION["usr_nombre"] = $usr_correo[0]->name;
      $_SESSION['login_user'] = $usr_correo[0]->email;
    }
    // termina inicializacion

  $fecha_hoy = date("Y-m-d");
  $calendarios = Disponibilidad_calendarios::getByDia($fecha_hoy);
  $semana_actual = $calendarios[0]->semana;

  $consulta = "SELECT * FROM disponibilidad_activos WHERE activo LIKE 'CO-BMU%'
                      OR activo LIKE 'CO-COM%'
                      OR activo LIKE 'CO-POZ%'
                      AND organizacion = 'COL' ORDER BY activo ASC";

  $equipos = Disponibilidad_activos::getAllByQuery($consulta);

  
    //print_r($años);
 ?>
      
            
        <!-- page content -->
        <div class="" role="main" >
          
          <div class='container text-center'>
            <h3 class="text-center" > SISPA</h3>
            
            <?php
              include(VIEW_PATH.'indexMenu_public_hidro.php')
            ?>
          </div>
          
            
          <div class="col-md-12 col-sm-12 col-xs-12">
              <form class='form-inline pull-right' style="padding-bottom: 10px;">
                                
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

                <button type="button" class="btn btn-success btn-sm" title="Traer registros" id="ver"><i class="fa fa-search"></i>
                </button>
            </form>

            <div class="x_panel">
                  
              <div class="x_content">
                <!-- aqui va el contenido -->
                <div  id="analisis">

                </div><!-- fin del div center -->
            
              </div>
            </div>
          </div>  
        </div>

 

 <?php require_once(VIEW_PATH.'footer.inc.php'); ?>
        <script type="text/javascript">

            $(document).ready(function()
            {
                $("#ver").on("click", function(event) 
                {
                    event.preventDefault();
                    var semana = $("#semana").val();
                    var ano = $("#ano").val();
                    var parametro = "SISPA";

                    //Añadimos la imagen de carga en el contenedor
                    $('#analisis').html('<div style="text-align:center;"><img src="dist/img/loading.gif"/></div>');
                  
                    $.get("helperMedidoresDatos.php", {parametro:parametro, semana:semana, ano:ano}, function(data)
                    {
                        $("#analisis").html(data);
                    });
                    
                });

            }); // end ready
        </script>

  </body>
</html>




