<?php 
    require_once('includes/config.inc.php');
    require_once(VIEW_PATH.'headerGeneral.inc.php');
    //include(VIEW_PATH.'indexMenu.php');
 ?>
     <style>
      #map {
        height: 600px;
        width: 100%;
    }
    iframe 
    {
      max-width: 100%;
      height: 600PX;
    }

    </style>
            
        <!-- page content -->
        <div class="right_col" role="main">
          
          <div class='container'>
            <h3 class="text-center" ><i class="fa fa-map-o fa-2x" aria-hidden="true"></i> Layout de invernaderos Naturesweet Planta Colima</h3>
          </div>
          
          
          
          <br />
            
            <div class="col-xs-12 col-sm-12 col-md-12">
              <div class="google-maps">
                  <iframe src="https://www.google.com/maps/d/embed?mid=1vPoXJvKIc9ojdpXkEI-VvkjmGnPMkHNG&key=AIzaSyDKjMrdiEy8lb6bUZyrkS6Ns9fKJ1bOB_U&z=16" width="100%" height="600" >
                  
                  </iframe>
              </div>
            </div>
          <br />

          

         

 

 <?php require_once(VIEW_PATH.'footer.inc.php'); ?>
            

          
         <script async defer
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAevpIKtBlObRNSWIf52sVig_b1JZ6-qFE&callback=initMap">
      </script> 
      <script>
      function cambiaWK(tipo, adicional)
      {
        //alert("tipo = "+tipo+" adicional = "+adicional);
          $("#parametrito").val(tipo); // 1 = Terminadas, 2 = Sin terminar
          $("#adicional").val(adicional); // 1 = Terminadas, 2 = Sin terminar

          /*if(tipo == 0 && adicional == 0)
          {
            $().
          }*/

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
              
              wk = $("#MyWK2").val();
              ano = $("#ano").val();
              param = $("#parametrito").val();
              adicional = $("#adicional").val();
              if(param == 0 && adicional == 0)
              {
                $("#filtro").children().first().prop('selected', true);
                $("#parametro").children().first().prop('selected', true);
              }
              if(param > 0)
              {
                $("#filtro").children().first().prop('selected', true);
              }
              

              //alert("semana: "+wk+" año: "+ano+"Parametro: "+param+"adicional: "+adicional);

              $.post("helperFugas.php", {wk: wk, ano: ano, param:param, adicional:adicional}, function (data) {
                  mydatos = JSON.parse(data);
                  
                  for (i = 0; i < mydatos.length; i++)
                  {
                      var latLng = new google.maps.LatLng(mydatos[i].latitud, mydatos[i].longitud);
                      var contentString = mydatos[i].contentString;
                      var descripcion = mydatos[i].descripcion;

                      //alert(url_base);
                      if (mydatos[i].estado == "Terminado" || mydatos[i].estado == "Ejecutado") {
                          var icono = "dist/img/Map-Marker-Ball-Chartreuse-icon.png";
                      } else {
                          var icono = "dist/img/Map-Marker-Ball-Pink-icon.png";
                          //alert(icono);
                      }
                      var infoWindow = new google.maps.InfoWindow();
                      var marker = new google.maps.Marker({
                          position: latLng,
                          map: map,
                          icon: icono,
                          title: descripcion
                      });

                      // Creating a closure to retain the correct data, notice how I pass the current data in the loop into the closure (marker, data)
                      (function(marker, contentString) {

                        // Attaching a click event to the current marker
                        google.maps.event.addListener(marker, "click", function(e) {
                          infoWindow.setContent(contentString);
                          infoWindow.open(map, marker);
                        });


                      })(marker, contentString);
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




