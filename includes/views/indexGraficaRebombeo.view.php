 <?php require_once(VIEW_PATH.'header.inc.php');
    //include(VIEW_PATH.'indexMenu.php');
 ?>

        <!-- page content -->
        <div class="right_col" role="main">
            <div class="">
                <div class="page-title">
                    <!--div class="col-md-12 col-sm-12 col-xs-12">
                        <h3>Gráficos por equipo...</h3>
                    </div-->
                    
                        <div class="col-md-12 col-sm-12 col-xs-12  pull-right ">
                            <form class='form-inline pull-right'>
                                <div class="form-group">
                                    <select class="form-control input-sm" id="tipo" >
                                        <option value="0" style="display: none;">Seleccione medición</option>
                                        <?php
                                            foreach ($tipos as $tipo) 
                                            {
                                                echo "<option value='".$tipo->id."'>".$tipo->descripcion."</option>";
                                            }
                                        ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <select class="form-control input-sm" id="equipo" >
                                        <option value="0" style="display: none;">Seleccione un equipo</option>
                                        <option value="0" >Seleccione un equipo</option>
                                        <?php
                                            foreach ($equipos as $equipo) 
                                            {
                                                $buscarBomba = "CO-BMU";
                                                $resultado = strpos($equipo->activo, $buscarBomba);
                                                 
                                                if($resultado !== FALSE)
                                                {
                                                    echo "<option value='".$equipo->activo."' class='medidor voltaje modoActiva hidden' >".$equipo->descripcion."</option>";
                                                }

                                                $buscarComedor = "CO-COM";
                                                $resultado = strpos($equipo->activo, $buscarComedor);
                                                 
                                                if($resultado !== FALSE)
                                                {
                                                    echo "<option value='".$equipo->activo."' class='medidor modoActiva hidden' >".$equipo->descripcion."</option>";
                                                }

                                                
                                                $buscarPozo = "CO-POZ";
                                                $resultado = strpos($equipo->activo, $buscarPozo);
                                                 
                                                if($resultado !== FALSE)
                                                {
                                                    echo "<option value='".$equipo->activo."' class='nivel voltaje medidor modoActiva hidden' >".$equipo->descripcion."</option>";
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
                            <br><br>
                        </div>
                    
                    
                </div>

                <div class="clearfix"></div>

                <div class="row">
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="x_panel">
                            <div class="x_title">
                                <h2><i class="fa fa-cogs"></i> Gráficos <small>por equipo</small></h2>
                                <ul class="nav navbar-right panel_toolbox">
                                  <li>
                                    <a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                                  </li>
                                </ul>
                                <div class="clearfix"></div>
                            </div>
                            <div class="x_content">           
                                <!-- aqui va el contenido -->

                                <div class="row" id="voltaje" width="100%">   
                                    <!-- /.table-responsive -->
                                </div> 
                                <br>
                                <hr>
                                <br>
                                <div class="row" id="amperaje" width="100%">   
                                    <!-- /.table-responsive -->
                                </div> 
                                <br>
                                <br>
                                <div class="row" id="niveles" width="100%">   
                                    <!-- /.table-responsive -->
                                </div> 
                                <br>
                                <br>
                                <div class="row" id="medidores" width="100%">   
                                    <!-- /.table-responsive -->
                                </div> 


                                <div class="row" id="amperaje_options" width="100%">   
                                    <!-- /.table-responsive -->
                                </div> 
                                <br>
                                              

                            </div>
                        </div>
                    </div> <!-- fin class='' -->
                </div>
            <div class="clearfix"></div>
        </div>


  		
        


 <?php require_once(VIEW_PATH.'footer.inc.php'); ?>

         <script type="text/javascript">

            $("#tipo").on("change", function()
            {
                var tipo = null;
                tipo = $("#tipo").val();
                

                $("#modoActiva").addClass("hidden"); // para los options de los equipos al iniciar o en un cambio
                $("#amperaje").html("");
                $("#voltaje").html("");
                $("#niveles").html("");
                $("#medidores").html("");

                $(".voltaje").addClass("hidden");
                $(".nivel").addClass("hidden");
                $(".medidor").addClass("hidden");

                if(tipo == 1) // voltaje y corriente
                {   
                    $("#equipo option:first").prop('selected','selected');

                    $(".voltaje").removeClass("hidden");
                   //$(".voltaje").removeClass("hidden");

                }
                else if(tipo == 2) // niveles
                {
                    $("#equipo option:first").prop('selected','selected');

                    $(".nivel").removeClass("hidden");
                    //$(".nivel").removeClass("hidden");
                }
                else if(tipo == 3) // medidores
                {
                    $("#equipo option:first").prop('selected','selected');

                    $(".medidor").removeClass("hidden");
                    //$(".medidor").removeClass("hidden");
                }

            })

            $(document).ready(function()
            {
                $("#verDisponibilidad").on("click", function(event) 
                {
                    event.preventDefault();
                    var mes = null;
                    var ano = null;
                    var equipo = null;
                    var tipo = null;


                        mes = $("#mes").val();
                        ano = $("#ano").val();
                        equipo = $("#equipo").val();
                        tipo = $("#tipo").val();

                    var medicion_dia_pasado = 0;

                    if(tipo == 0)
                    {
                        alert("¡SELECCIONE UNA MEDICION!");
                        return false;
                    }
                    else if(equipo == 0)
                    {
                        alert("¡SELECCIONE UN EQUIPO!");
                        return false;
                    }
                    else
                    {
                        //Añadimos la imagen de carga en el contenedor
                       // $('#cumplimiento').html('<div style="text-align:center;"><img src="dist/img/loading.gif"/></div>');
                        //$('#analisis').html('<div style="text-align:center;"><img src="dist/img/loading.gif"/></div>');
                      
                              google.charts.load('current', {'packages':['corechart']});
                              //google.charts.load("visualization", "1", {packages:["line"]});
                              if(tipo == 1) // para voltaje y amperaje
                              {
                                //Añadimos la imagen de carga en el contenedor
                                $('#amperaje').html('<div style="text-align:center;"><img src="dist/img/loading.gif"/></div>');
                                $('#voltaje').html('<div style="text-align:center;"><img src="dist/img/loading.gif"/></div>');
                                google.charts.setOnLoadCallback(drawChart);

                              }
                              else if(tipo == 2) // para los niveles
                              {
                                //Añadimos la imagen de carga en el contenedor
                                $('#niveles').html('<div style="text-align:center;"><img src="dist/img/loading.gif"/></div>');
                                    google.charts.setOnLoadCallback(drawNiveles);
                              }
                              else // para los medidores
                              { 
                              //Añadimos la imagen de carga en el contenedor

                                $.get("apiMedidor.php", {consulta:"CONSULTA_MEDICION", tipo:tipo, ano:ano, mes:mes, equipo:equipo} ,function(data)
                                            {
                                                medicion_dia_pasado = data;
                                                //alert(medicion_dia_pasado);

                                                $('#medidores').html('<div style="text-align:center;"><img src="dist/img/loading.gif"/></div>');
                                                google.charts.setOnLoadCallback(drawMedidores);
                                            }); 
                                
                              }
                              
                              

                        function drawChart()
                        {

                            var constructorVoltaje = [['DIA / HORA',  'MIN', 'MAX', 'L1_L2', 'L2_L3', 'L1_L3']];
                            var constructorAmperaje = [['DIA / HORA',  'MIN', 'MAX', 'L1', 'L2', 'L3']];

                            $.getJSON("helperGrafico.php?tipo="+tipo+"&ano="+ano+"&mes="+mes+"&equipo="+equipo, function(result)
                            {
                                    
                                $.each(result, function(i, field)
                                {
                                    dia = field['fechaLectura'] ;
                                    v_min = parseFloat(field['volt_nomi_bajo'] );
                                    v_max = parseFloat(field['volt_nomi_alto'] );
                                    v_l1_l2 = parseFloat(field['voltaje_l1_l2'] );
                                    v_l2_l3 = parseFloat(field['voltaje_l2_l3'] );
                                    v_l1_l3 = parseFloat(field['voltaje_l1_l3'] );

                                    amp_min = parseFloat(field['amp_min'] );
                                    amp_max = parseFloat(field['amp_max'] );
                                    amp_l1 = parseFloat(field['amperaje_l1'] );
                                    amp_l2 = parseFloat(field['amperaje_l2'] );
                                    amp_l3 = parseFloat(field['amperaje_l3'] );


                                    constructorVoltaje.push([dia, v_min, v_max, v_l1_l2, v_l2_l3, v_l1_l3]);
                                    constructorAmperaje.push([dia, amp_min, amp_max, amp_l1, amp_l2, amp_l3]);
                                
                                    /*console.log("v_min = "+field['v_min'] +" v_max= " + field['v_max'] + " l1_l2 = "+field['voltaje_l1_l2']);*/
                                });// fin de each result

                                var data = google.visualization.arrayToDataTable(constructorVoltaje);

                                var options = {

                                    chart: {
                                      //title: 'MEDICIONES DE VOLTAJE',
                                      subtitle: equipo,
                                      type: 'number',

                                      
                                    },
                                    title: 'MEDICIONES DE VOLTAJE',
                                    fontSize: 11,
                                    pointSize: 5,
                                    curveType: 'function',
                                    legend: { position: 'bottom' },
                                    //width: 315,
                                    height: 500,
                                    colors: ["#21893D", "#C42937", "#2A8294", "#DAAB1D", "#3A5ED6"]
                                    // colores verde, rojo
                                  };
                                  
                               

                                //var chart = new google.charts.Line(document.getElementById('voltaje'));
                                var chart = new google.visualization.LineChart(document.getElementById('voltaje'));

                                chart.draw(data, options);

                                // ----------------------- PARA EL AMPERAJE -----------------------------------

                                var dataAmperaje = google.visualization.arrayToDataTable(constructorAmperaje);

                                var optionsAmperaje = {
                                    chart: {
                                      //title: 'MEDICIONES DE AMPERAJE',
                                      subtitle: equipo,
                                      type: 'number',
                                    },
                                    fontSize: 11,
                                    title: 'MEDICIONES DE AMPERAJE',
                                    pointSize: 5,
                                    curveType: 'function',
                                    legend: { position: 'bottom' },
                                    //width: 315,
                                    height: 500,
                                    colors: ["#21893D", "#C42937", "#2A8294", "#DAAB1D", "#3A5ED6"]
                                    // colores verde, rojo
                                  };
                               

                                //var chart = new google.charts.Line(document.getElementById('amperaje'));
                                var chart = new google.visualization.LineChart(document.getElementById('amperaje'));

                                    chart.draw(dataAmperaje, optionsAmperaje);

                            }); // fin de getJson
                        }// fin del draw

                        function drawNiveles()
                        {

                            
                            var constructorNiveles = [['DIA / HORA',  'NIVEL ESTATICO', 'NIVEL DINAMICO']];

                            $.getJSON("helperGrafico.php?tipo="+tipo+"&ano="+ano+"&mes="+mes+"&equipo="+equipo, function(result)
                            {
                                    
                                $.each(result, function(i, field)
                                {
                                    dia = field['fechaLectura'] ;
                                    nivel_estatico = parseFloat(field['nivel_estatico'] );
                                    nivel_dinamico = parseFloat(field['nivel_dinamico'] );


                                    
                                    constructorNiveles.push([dia, nivel_estatico, nivel_dinamico]);
                                
                                    /*console.log("v_min = "+field['v_min'] +" v_max= " + field['v_max'] + " l1_l2 = "+field['voltaje_l1_l2']);*/
                                });// fin de each result

                                

                                // ----------------------- PARA los NIVELES -----------------------------------

                                var dataNiveles = google.visualization.arrayToDataTable(constructorNiveles);

                                var optionsNiveles = {
                                    chart: {
                                      //title: 'MEDICIONES DE AMPERAJE',
                                      subtitle: equipo,
                                      type: 'number',
                                    },
                                    fontSize: 11,
                                    title: 'MEDICIONES DE NIVELES',
                                    pointSize: 5,
                                    curveType: 'function',
                                    legend: { position: 'bottom' },
                                    //width: 315,
                                    height: 500,
                                    colors: ["#21893D", "#C42937", "#2A8294", "#DAAB1D", "#3A5ED6"]
                                    // colores verde, rojo
                                  };
                               

                                //var chart = new google.charts.Line(document.getElementById('amperaje'));
                                var chart = new google.visualization.LineChart(document.getElementById('niveles'));

                                    chart.draw(dataNiveles, optionsNiveles);

                            }); // fin de getJson
                        }// fin del draw

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

                                    if(equipito == "CO-BMU-009")
                                    {
                                        m_consumidos = parseFloat(field['m_consumidos']);
                                    }
                                    else
                                    {
                                        m_consumidos = parseFloat(field['m_consumidos'] * 10 );
                                    }
                                    

                                    if(reinicio == 1)
                                    {
                                        valor_consumo = m_consumidos
                                        medicion_dia_pasado = 0;
                                        comentarios = " "+comentarios;
                                    }
                                    else
                                    {
                                        valor_consumo = m_consumidos - medicion_dia_pasado;
                                        medicion_dia_pasado = m_consumidos;
                                    }
                                    

                                    //console.log(medicion_dia_pasado);
                                    constructorMedidores.push([dia_formato, valor_consumo, valor_consumo+comentarios]);
                                    
                                    
                                    /*console.log("v_min = "+field['v_min'] +" v_max= " + field['v_max'] + " l1_l2 = "+field['voltaje_l1_l2']);*/
                                });// fin de each result

                                

                                // ----------------------- PARA los MEDIDORES -----------------------------------

                                var dataMedidores = google.visualization.arrayToDataTable(constructorMedidores);

                                var optionsMedidores = {
                                    chart: {
                                      //title: 'MEDICIONES DE AMPERAJE',
                                      subtitle: equipo,
                                      type: 'number',
                                    },
                                    fontSize: 11,
                                    title: 'MEDICIONES DE METROS CUBICOS CONSUMIDOS',
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


                    }
                    
                    
                });

            }); // end ready
        </script>
</body>

</html>