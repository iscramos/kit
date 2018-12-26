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
          </div>
          
          
          
            
            
            <div class=" embed-responsive embed-responsive-16by9">
              
              <iframe class="embed-responsive-item"  src="https://app.powerbi.com/view?r=eyJrIjoiMDM2NDE4NGItNmVlNS00NmUzLTgxZDYtNjczYTAxOWEzZWIyIiwidCI6IjM1ZjM2ZTgyLTFhNDQtNGUyMi04NzliLWJhYmZmYjQzNjAwNiIsImMiOjR9" frameborder="0" allowFullScreen="true" ></iframe>
              
              </div>
              
          </div>
          

          

         

 

 <?php require_once(VIEW_PATH.'footer.inc.php'); ?>


  </body>
</html>




