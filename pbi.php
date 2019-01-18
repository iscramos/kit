<?php 
    require_once('includes/config.inc.php');
    require_once(VIEW_PATH.'headerGeneral.inc.php');
    //include(VIEW_PATH.'indexMenu.php');
    $años = Disponibilidad_anos::getAllByOrden("ano", "DESC");
    $actual = date("Y");
 ?>
     <style>
      #map {
        height: 600px;
        width: 100%;
    }
    /*iframe 
    {
      
      width:  100%;
      height: 60em;
      margin: 0;
    }*/

    /*@media only screen and (max-width: 600px) 
    {
        .expand 
        {
          width:  100%;
          height: 400px;
          margin: 0;
        }
    }*/

    .embed-responsive-16by9 {
    padding-bottom: 35.25% !important;
}

    </style>
            
        <!-- page content -->
        <div class="right_col" role="main">
          
          <div class='container'>
            <h3 class="text-center" ><i class="fa fa-bar-chart fa-2x" aria-hidden="true"></i> Power BI Naturesweet Planta Colima</h3>
              <form class="form-inline text-center">
                <div class="form-group ">

                  <select class="form-control" id="ano">>
                    <?php
                      foreach ($años as $a) 
                      {
                        if($actual != $a->ano)
                        {
                          echo "<option value='".$a->ano."'>".$a->ano."</option>";
                        }
                        else
                        {
                          echo "<option value='".$actual."' selected>".$actual."</option>";
                        }
                        
                      }
                    ?>
                  </select>
                </div>
              </form>
          </div>
          
          <br>
          
            
            
            <div class=" embed-responsive embed-responsive-16by9 pbi">
              
              <iframe class="embed-responsive-item hidden pbi_2018"  src="https://app.powerbi.com/view?r=eyJrIjoiMDM2NDE4NGItNmVlNS00NmUzLTgxZDYtNjczYTAxOWEzZWIyIiwidCI6IjM1ZjM2ZTgyLTFhNDQtNGUyMi04NzliLWJhYmZmYjQzNjAwNiIsImMiOjR9" frameborder="0" allowFullScreen="true" ></iframe>

              <iframe class="embed-responsive-item  pbi_2019"src="https://app.powerbi.com/view?r=eyJrIjoiZTBmZjlkZjItZmNiZi00MDU0LTgxYjAtNGI1YzU5NjA2NjFhIiwidCI6IjM1ZjM2ZTgyLTFhNDQtNGUyMi04NzliLWJhYmZmYjQzNjAwNiIsImMiOjR9" frameborder="0" allowFullScreen="true"></iframe>
              
              </div>
              
          </div>
          

          

         

 

 <?php require_once(VIEW_PATH.'footer.inc.php'); ?>

      <script type="text/javascript">
        $("#ano").on("change", function() 
        {
          var ano = $(this).val();
          if(ano == 2018)
          {
            $(".pbi_2018").removeClass("hidden");
            $(".pbi_2019").addClass("hidden");
          }
          else if (ano == 2019)
          {
            $(".pbi_2018").addClass("hidden");
            $(".pbi_2019").removeClass("hidden");
          }
          else
          {
            alert("NO DATA: SELECCIONE OTRO AÑO...")
            $(".pbi_2018").addClass("hidden");
            $(".pbi_2019").addClass("hidden");
          }
          
        });
      </script>
  </body>
</html>




