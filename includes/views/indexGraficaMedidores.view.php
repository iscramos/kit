 <?php require_once(VIEW_PATH.'header.inc.php');
    //include(VIEW_PATH.'indexMenu.php');
 ?>
    <style>
      #map {
        height: 600px;
        width: 100%;

    }
    .gm-style .gm-ui-hover-effect { 
    display: none; /* <-- this will generally work on the fly. */ 
    visibility: hidden; /* this 2 lines below are just for hard hiding. :) */ 
    opacity: 0; 
}

    </style>
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
                                    <select class="form-control input-sm" id="mes" onchange="cambiaMes(0, 0)">
                                        
                                        <?php
                                            //$semanas = Disponibilidad_semanas::getAllByOrden("semana", "ASC");
                                            $meses = Disponibilidad_meses::getAllByOrden("mes", "ASC");
                                            //print_r($semanas);
                                            foreach ($meses as $m)
                                            {
                                                if($m->mes == $mes)
                                                {
                                                    echo "<option value='".$m->mes."' style='display:none;' selected>".$m->mes_nombre."</option>";
                                                }
                                                echo "<option value='".$m->mes."' >".$m->mes_nombre."</option>";

                                            }
                                        ?>
                                    </select>
                                </div>
                            </form>
                            <br><br>
                        </div>
                    
                    
                </div>

                <div class="clearfix"></div>

                <div class="row">
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="x_panel">
                            <div class="x_title">
                                <h2><i class="fa fa-cogs"></i> Gráficos de medidores<small>por mes</small></h2>
                                <ul class="nav navbar-right panel_toolbox">
                                  <li>
                                    <a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                                  </li>
                                </ul>
                                <div class="clearfix"></div>
                            </div>
                            <div class="x_content">           
                                <!-- aqui va el contenido -->

                                <div  id="map" >   
                                    <!-- /.table-responsive -->
                                </div>
                                              

                            </div>
                        </div>
                    </div> <!-- fin class='' -->
                </div>
            <div class="clearfix"></div>
        </div>


  		
        


 <?php require_once(VIEW_PATH.'footer.inc.php'); ?>

         


    <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAevpIKtBlObRNSWIf52sVig_b1JZ6-qFE&callback=initMap">
    </script> 
    <script>
      function cambiaMes(tipo, adicional)
      {
        
          
          initMap();
      }
          function initMap() {
              
              $("#map").html("");
              var uluru = {lat: 19.337795, lng: -103.800213};
              var map = new google.maps.Map(document.getElementById('map'), {
                  zoom: 15.5,
                  center: uluru,
                  mapTypeId: 'satellite',
                  panControl: true,
                  zoomControl: true,
                  mapTypeControl: true,
                  scaleControl: true,
                  streetViewControl: true,
                  overviewMapControl: true,
              });
              
              var mes = $("#mes").val();
              var ano = $("#ano").val();

              
              //console.log("Ano: "+ano +"Mes: " + mes);

              //alert("semana: "+wk+" año: "+ano+"Parametro: "+param+"adicional: "+adicional);

              $.post("helperMedidores.php", {mes: mes, ano: ano}, function (data) {
                  mydatos = JSON.parse(data);
                  
                  for (i = 0; i < mydatos.length; i++)
                  {
                      var latLng = new google.maps.LatLng(mydatos[i].latitud, mydatos[i].longitud);
                      var contentString = mydatos[i].contentString;
                      var descripcion = mydatos[i].descripcion;

                      //alert(url_base);
                      
                      var icono = "dist/img/icono_medidor.png";
                         
                      var infoWindow = new google.maps.InfoWindow(
                        {
                            closeBoxURL : ""
                        });
                      var marker = new google.maps.Marker({
                          position: latLng,
                          map: map,
                          icon: icono,
                          //title: descripcion,
                      });
                      

                      // Creating a closure to retain the correct data, notice how I pass the current data in the loop into the closure (marker, data)
                      /*(function(marker, contentString) {

                        // Attaching a click event to the current marker
                        google.maps.event.addListener(marker, "click", function(e) {
                          infoWindow.setContent(contentString);
                          infoWindow.open(map, marker);
                        });
                        //infowindow.open(map, contentString);


                      })(marker, contentString);*/

                        infoWindow.setContent(contentString);
                          infoWindow.open(map, marker);


                          //marker.infowindow.close(map, marker);

                          
                        

                  }
                  

              });


              
              // var marker = new google.maps.Marker({
              //   position: uluru,
              // map: map
              //});
              return false;
          }
        </script>
</body>

</html>