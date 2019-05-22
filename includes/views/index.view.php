 <?php require_once(VIEW_PATH.'header.inc.php');

      require_once(SITE_ROOT.'proapp_top_ten.php'); // para el envío del correo de mayor incidencia de equipos críticos.
    //include(VIEW_PATH.'indexMenu.php');
 ?>

            
        <!-- page content -->
        <div class="right_col" role="main">
          <!-- top tiles -->
          <div class="row tile_count">
            
          </div>
          <!-- /top tiles -->

          <div class="row" style="text-align: center;">
            <div class="col-lg-offset-2 col-lg-8 col-md-offset-2 col-md-col-sm-12">
                   
           
              <img src="<?php echo $url."dist/img/naturesweet_picture.png"; ?>" class="img-responsive" alt="Responsive image" style="margin: 0 auto;">
              <h1>+</h1>
              <img src="<?php echo $url."dist/img/infor-logo.png"; ?>" class="img-responsive" alt="Responsive image" style="margin: 0 auto;">
              <hr>
              <h1 class=''>Planta Colima</h1>
              <h4>Última Actualización: 27/06/2018</h4>
          
            </div>

          </div>
          <br />

  
          <div id="modalBodyCentroCarga"></div> 

 <?php require_once(VIEW_PATH.'footer.inc.php'); ?>

  <script type="text/javascript">
    // codigo para el envío de correos
    function mandarMails() 
    {
      //alert("hola");
      asunto = 'RESUMEN SEMANAL EQUIPOS CRITICOS';
      body = '<?php echo $variableHTML; ?>';
      mails = <?php echo json_encode($arrays); ?>;
      subTitulo = '<?php echo "Mantenimiento"; ?>';
      if(body == "NO SEND")
      {
        return true;
      }
      else
      {
        $.post("http://192.168.167.231/ns/mails/index.php",
              {mails: mails, asunto: asunto, body: body, subTitulo: subTitulo}, function (data) {
          $("#modalBodyCentroCarga").html(data);
          //console.log("Correo enviado");
      });
      }
      
    }
    //mandarMails();
  </script>
  </body>
</html>