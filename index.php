<?php  
	require_once('includes/config.inc.php');
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Kit NS v3.0</title>
    <link rel="shortcut icon" type="image/png" href="https://1aswz6617n62bekj52vicjtb-wpengine.netdna-ssl.com/wp-content/uploads/2016/07/favicons.png">

    <!-- Bootstrap Core CSS -->
    <link href="dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="dist/css/naturesweet.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="dist/css/sb-admin-2.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    <style type="text/css">
            body
            {


                display: flex;
                align-items: center;
                padding-top: 40px;
                padding-bottom: 40px;
                background-color: #f5f5f5;
                /*background-color: #272424;*/

                background-image: url("dist/img/mapa.png");
                /*background-color: #cccccc;*/
                background-repeat: no-repeat;
                /*background-attachment: fixed;*/
                background-size: cover;
                /*background-position:  inherit;*/
               

            }
            .formulario 
            {
                    width: 100%;
                    max-width: 330px;
                    padding: 15px;
                    margin: auto;
            }

           .formulario .form-control 
           {
                  position: relative;
                  box-sizing: border-box;
                  height: auto;
                  padding: 10px;
                  font-size: 16px;
            }

            .formulario .form-control:focus 
            {
                  z-index: 2;
            }

            .formulario input[type="text"] {
              margin-bottom: -1px;
              border-bottom-right-radius: 0;
              border-bottom-left-radius: 0;
            }
            .formulario input[type="password"] {
              margin-bottom: 10px;
              border-top-left-radius: 0;
              border-top-right-radius: 0;
            }
            .linea
            {

                clear: both;
                margin: 0;
                height: .15em; 
                width: 70%;

            }

            .footer 
            {
                  position: absolute;
                  bottom: 0;
                  width: 100%;
                  /* Set the fixed height of the footer here */
                  height: 60px;
                  background-color: #25733A;
                  color: white;
            }
            
            .container .texto-footer 
            {
                  margin: 15px 0;
            }

            .container .texto-footer a 
            {
                  color: white;
                    padding-right: 10px;
                    text-decoration: none;
            }
            .text-muted 
            {
                 margin: 15px 0;
                color: #6c757d!important;
            }
                            
    </style>
</head>

<body >

    
            <div class="container text-center">	
                	<!--b style="color: #969696;"> Planta Colima</b-->
                    
                    
                	

                	<?php
                		session_start();

    					$iniciarSesion='<a href="'.$url.'lib/logout.php" class="navbar-link">Salir</a>';
    					if($_SERVER["REQUEST_METHOD"] == "POST") // 10.171.0.55
    					{
    				      	// username and password sent from form 
    				      	//die("dd");
    				      	$email = trim($_POST['email']);
    				      	$password = trim($_POST['password']); 
    					    
    					    $password = base64_encode($password);

    					    $usr_correo = Usuarios::buscaUsuarioByEmailPassword($email, $password);
    					      
    					     // If result matched $email and $mypassword, table row must be 1 row	
    					     if(isset($usr_correo[0]))
    					     {
    							$_SESSION['Login']['id']=$usr_correo[0]->id;
    							$_SESSION["type"] = $usr_correo[0]->type;
    							//$_SESSION["nivel"]=$usr_correo[0]->nivel;
    							//$_SESSION["administrador"]=$usr_correo[0]->administrador;
    							$_SESSION["usr_nombre"] = $usr_correo[0]->name;
    							$_SESSION['login_user'] = $usr_correo[0]->email;
    							//$_SESSION['salir']='<a href="'.$url.'lib/logout.php" class="navbar-link">Salir</a>';

    							header("location: indexMain.php");
    							
    						}else
    						{
    							//$_SESSION['Login']['id']=0;
    							//session_unset();
    							
    							echo "<div class='alert alert-danger' id='mensaje'>
    								    Verifique sus datos.
    								</div>";
    							//die();
    						}
    					}
    				?>
                    <img src="<?php echo $url."dist/img/logo_2018.png"; ?>" width="img-responsive">
                    <br>
                    <img class="linea" src="<?php echo $url."dist/img/home_bkg.png"; ?>" >
                    <h3 class="text-center" >Kit de mantenimiento v3</h3>

                    <form role="form" action="" method="post" class="text-center formulario">
                            
                            <input class="form-control " placeholder="Usuario" name="email" type="text" autocomplete="off" required value="" type="text" autofocus="">
                            
                           
                            <input class="form-control " placeholder="Password" name="password" type="password" autocomplete="off" required value="">
                            
                            <!-- Change this to a button or input when using this as a form -->
                            <button type="submit" class="btn  btn-primary btn-block btn-lg" >Ingresar</button>
                            <p class="text-muted">© 2018</p>
                   	</form>

                
            </div> <!-- cierra container -->
        

            <footer class="footer">
                <div class="container">
                    <p class="texto-footer">
                        <a  href="mapa.php" title="Ver mapa de fugas" > 
                            <i class="fa fa-globe fa-2x"> </i> 
                       </a>
                       <a  href="layout_invernaderos.php" title="Ver layout invernaderos">
                            <i class="fa fa-street-view fa-2x"> </i> 
                        </a>
                        <a  href="pbi.php" title="Ver análisis pbi">
                            <i class="fa fa-bar-chart fa-2x"> </i> 
                        </a>
                        <a href="https://eam.inforcloudsuite.com/web/base/logindisp?tenant=NATURESWEET_PRD" title="Infor EAM">
                            <img src="<?php echo $url."dist/img/infor-logo.png"; ?>" class='pull-right' width="36px;">
                        </a>
                    </p>
                        
                </div>
            </footer>

    <!-- jQuery -->
    <script src="dist/js/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="dist/js/bootstrap.min.js"></script>

    

<script type="text/javascript">
    $(document).ready(function(){
        $("#mensaje").show(function showAlert() {
                    $(".alert").alert();
                    $(".alert").fadeTo(2000, 700).slideUp(700, function(){
                   $(".alert").slideUp(2000);
                    });   
                });

        //$("body").css("height", "100%");
               
    });
</script>
</body>

</html>
