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
            <h3 class="text-center" > Medidores</h3>
            
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
                                $buscarBomba = "CO-BMU";
                                $resultado = strpos($equipo->activo, $buscarBomba);
                                 
                                if($resultado !== FALSE)
                                {
                                    echo "<option value='".$equipo->activo."' class='medidor' >".$equipo->descripcion."</option>";
                                }

                                $buscarComedor = "CO-COM";
                                $resultado = strpos($equipo->activo, $buscarComedor);
                                 
                                if($resultado !== FALSE)
                                {
                                    echo "<option value='".$equipo->activo."' class='medidor' >".$equipo->descripcion."</option>";
                                }

                                
                                $buscarPozo = "CO-POZ";
                                $resultado = strpos($equipo->activo, $buscarPozo);
                                 
                                if($resultado !== FALSE)
                                {
                                    echo "<option value='".$equipo->activo."' class='medidor' >".$equipo->descripcion."</option>";
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
                <div class="form-group">
                    <label> MES</label>
                    <?php
                        $fechaConsultaFormateada = date("m-d");
                        $dia = date("Y-m-d");
                        $calendarios = Disponibilidad_calendarios::getByDia($dia);
                        $mes = $calendarios[0]->mes;
                        $mes_nombre = $calendarios[0]->mes_nombre;
                    ?>
                    <select class="form-control input-sm" id="mes">
                        <option value='<?php echo $mes; ?>' style="display: none;"><?php echo $mes_nombre; ?></option>
                        <?php
                            //$semanas = Disponibilidad_semanas::getAllByOrden("semana", "ASC");
                            $meses = Disponibilidad_meses::getAllByOrden("mes", "ASC");
                            //print_r($semanas);
                            foreach ($meses as $m)
                            {
                                echo "<option value='".$m->mes."' >".$m->mes_nombre."</option>";
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
                <div style="text-align: center;" id="medidores">

                </div><!-- fin del div center -->
            
              </div>
            </div>
          </div>  
        </div>

 

 <?php require_once(VIEW_PATH.'footer.inc.php'); ?>
        <script type="text/javascript">

            $(document).ready(function()
            {
                $("#verDisponibilidad").on("click", function(event) 
                {   
                    event.preventDefault();
                    var mes = null;
                    var ano = null;
                    var equipo = null;
                    var tipo = null;
                    var total = 0;
                        $("#medidores").html("");
                        mes = $("#mes").val();
                        ano = $("#ano").val();
                        equipo = $("#equipo").val();
                        tipo = 3; // para medidores


                    var medicion_dia_pasado = 0;

                        google.charts.load('current', {'packages':['corechart']});
                        //google.charts.load("visualization", "1", {packages:["line"]});

                        $.get("apiMedidor.php", {consulta:"CONSULTA_MEDICION", tipo:tipo, ano:ano, mes:mes, equipo:equipo} ,function(data)
                        {
                          medicion_dia_pasado = data;
                          //alert(medicion_dia_pasado);

                          $('#medidores').html('<div style="text-align:center;"><img src="dist/img/loading.gif"/></div>');
                          google.charts.setOnLoadCallback(drawMedidores);
                        }); 
                                

                        function drawMedidores()
                        {
                            

                            var constructorMedidores = [['DIA / HORA',  'METROS CUBICOS CONSUMIDOS', {type:'string', role:'annotation'}]];

                            $.getJSON("helperGrafico.php?tipo="+tipo+"&ano="+ano+"&mes="+mes+"&equipo="+equipo, function(result)
                            {
                                $.each(result, function(i, field)
                                {
                                   
                                    var valor_consumo = 0;
                                    dia = field['fechaLectura'];
                                    equipito = field['equipo'];
                                    convertida = new Date(dia);
                                    dia_formato = convertida.format("d/m/Y");
                                    comentarios = field['comentarios'];
                                    reinicio = field['reinicio'];
                                    m_consumidos = parseFloat(field['m_consumidos']);

                                    if(equipito != "CO-BMU-009")
                                    {
                                        m_consumidos = m_consumidos * 10;
                                    }
                                    
                                        
                                    
                                    

                                    if(reinicio == 1)
                                    {
                                        valor_consumo = m_consumidos
                                        medicion_dia_pasado = m_consumidos;
                                        comentarios = " "+comentarios;
                                    }
                                    else
                                    {
                                        valor_consumo = m_consumidos - medicion_dia_pasado;
                                        medicion_dia_pasado = m_consumidos;
                                    }
                                    

                                    //console.log(dia_formato);
                                    constructorMedidores.push([dia_formato, valor_consumo, valor_consumo+comentarios]);
                                    total = total + valor_consumo;
                                    
                                    /*console.log("v_min = "+field['v_min'] +" v_max= " + field['v_max'] + " l1_l2 = "+field['voltaje_l1_l2']);*/
                                });// fin de each result

                                

                                // ----------------------- PARA los MEDIDORES -----------------------------------

                                var dataMedidores = google.visualization.arrayToDataTable(constructorMedidores);

                                var optionsMedidores = {
                                    chart: {
                                      //title: 'MEDICIONES DE AMPERAJE',
                                      subtitle: equipo,
                                      type: 'number'
                                    },
                                    fontSize: 11,
                                    title: total + ' METROS CUBICOS EN EL MES',
                                    pointSize: 5,
                                    curveType: 'function',
                                    legend: { position: 'bottom' },
                                    //width: 315,
                                    height: 500,
                                    colors: ["#21893D", "#C42937", "#2A8294", "#DAAB1D", "#3A5ED6"]
                                    // colores verde, rojo
                                  };
                               

                                //var chart = new google.charts.Line(document.getElementById('amperaje'));
                                var chart = new google.visualization.AreaChart(document.getElementById('medidores'));

                                    chart.draw(dataMedidores, optionsMedidores);

                            }); // fin de getJson
                        }// fin del draw

                    
                });

            }); // end ready
        </script>

  </body>
</html>




