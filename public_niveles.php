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
            <h3 class="text-center" > Niveles de agua</h3>
            
            <?php
              include(VIEW_PATH.'indexMenu_public_hidro.php')
            ?>
          </div>
          
            
          <div class="col-md-12 col-sm-12 col-xs-12">
              <form class='form-inline pull-right' style="padding-bottom: 10px;">
                    
                <div class="form-group">
                    <select class="form-control input-sm" id="equipo" >
                        
                        <?php
                            foreach ($equipos as $equipo) 
                            {
                                
                                $buscarPozo = "CO-POZ";
                                $resultado = strpos($equipo->activo, $buscarPozo);
                                 
                                if($resultado !== FALSE)
                                {
                                    echo "<option value='".$equipo->activo."' class='nivel' >".$equipo->descripcion."</option>";
                                }
                            }
                        ?>
                    </select>
                </div>
                <div class="form-group">
                    <?php
                        $anos = Disponibilidad_anos::getAllByOrden("ano", "DESC");
                    ?>
                    <label>A&Ntilde;O </label>
                    <select class="form-control input-sm" id="ano">
                        <option value='<?php echo date('Y'); ?>' style="display: none;"><?php echo date('Y'); ?></option>
                        <?php
                            foreach ($anos as $ano) 
                            {
                                echo "<option value='".$ano->ano."'>".$ano->ano."</option>";
                            }
                        ?>
                    </select>
                </div>
                <button type="button" class="btn btn-success btn-sm" title="Traer registros" id="verDisponibilidad"><i class="fa fa-search"></i>
                </button>
              </form>

            <div class="x_panel">
                  
              <div class="x_content">
                <!-- aqui va el contenido -->
                <div style="text-align: center;" id="niveles">

                </div><!-- fin del div center -->
            
              </div>
            </div>
          </div>  
        </div>

 

 <?php require_once(VIEW_PATH.'footer.inc.php'); ?>
        <script type="text/javascript">

            $(document).ready(function()
            {   
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

                $("#verDisponibilidad").on("click", function(event) 
                {
                    event.preventDefault();
                    var ano = null;
                    var equipo = null;
                    var tipo = null;

                        $("#medidores").html("");
                        ano = $("#ano").val();
                        equipo = $("#equipo").val();
                        consulta = "CONSULTA_NIVELES_MENSUAL_ANUAL";

                        google.charts.load('current', {'packages':['corechart']});
                        //google.charts.load("visualization", "1", {packages:["line"]});

                        $('#niveles').html('<div style="text-align:center;"><img src="dist/img/loading.gif"/></div>');
                        google.charts.setOnLoadCallback(drawNiveles);     

                        function drawNiveles()
                        {
                            

                            var constructorNiveles = [['MES',  'NIVEL ESTATICO', {type:'string', role:'annotation'}, 'NIVEL DINAMICO',  {type:'string', role:'annotation'}]];

                            $.getJSON("helperGrafico.php?ano="+ano+"&equipo="+equipo+"&consulta="+consulta, function(result)
                            {
                                $.each(result, function(i, field)
                                {
                                    var n_mes = "null";
                                    var nivel_estatico = null;
                                    var nivel_dinamico = null;

                                    dia = field['f_formateada'];
                                    consulta = "RECIBO_DIA_DEVUELVO_MES";
                                   
                                   
                                    
                                    $.ajax({
                                        type : "GET",
                                        url : "helperGrafico.php",
                                        responseTime : 20000,
                                        async: false,
                                        data : {
                                            consulta : consulta,
                                            dia : dia,
                                            equipo : equipo
                                      },
                                      success : function( data ){
                                        
                                            n_mes = data; 
                                            
                                            
                                            //console.log( "First Method Data Saved: " , data ); 
                                            //console.log( "First Method Data Saved: " , nivel_estatico );
                                            //console.log( "First Method Data Saved: " , nivel_dinamico ); 
                                            
                                             
                                            nivel_estatico = parseFloat(field['nivel_estatico'] );
                                            nivel_dinamico = parseFloat(field['nivel_dinamico'] ); 
                                            constructorNiveles.push([n_mes, nivel_estatico, nivel_estatico, nivel_dinamico, nivel_dinamico]);
                                                        
                                           
                                      }
                                    });

                                    /*console.log("v_min = "+field['v_min'] +" v_max= " + field['v_max'] + " l1_l2 = "+field['voltaje_l1_l2']);*/
                                });// fin de each result

                                

                                // ----------------------- PARA LOS NIVELES -----------------------------------

                                var dataNiveles = google.visualization.arrayToDataTable(constructorNiveles);

                                var optionsNiveles = {
                                    chart: {
                                      //title: "asdasdd",
                                      subtitle: equipo,
                                      //type: 'number',
                                    },
                                    fontSize: 11,
                                    title: 'NIVELES ESTATICOS Y DINAMICOS POR MES',
                                    pointSize: 5,
                                    curveType: 'function',
                                    legend: { position: 'bottom' },
                                    //width: 315,
                                    height: 500,
                                    colors: ["#21893D", "#C42937", "#2A8294", "#DAAB1D", "#3A5ED6"]
                                    // colores verde, rojo
                                  };
                               

                                //var chart = new google.charts.Line(document.getElementById('amperaje'));
                                var chart = new google.visualization.AreaChart(document.getElementById('niveles'));

                                    chart.draw(dataNiveles, optionsNiveles);

                            }); // fin de getJson
                        }// fin del draw

                    
                });

            }); // end ready
        </script>

  </body>
</html>




