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

    <title>Kit NS v2.0</title>
    <link rel="shortcut icon" type="image/png" href="https://1aswz6617n62bekj52vicjtb-wpengine.netdna-ssl.com/wp-content/uploads/2016/07/favicons.png">

    <!-- Bootstrap Core CSS -->
    <link href="dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="dist/css/naturesweet.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="dist/css/sb-admin-2.css" rel="stylesheet">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    <style type="text/css">
        
        body {
                background-image: url("dist/img/image_main.jpg");
                background-color: #cccccc;
                background-repeat: no-repeat;
                background-attachment: fixed;
                background-size: cover;
                background-position: center center;


            }
            .outer
            {
                display: table;
                position: absolute;
                height: 100%;
                width: 100%;
                display: flex;
                justify-content: center;
                align-items: center;
            }
            .middle
            {
                display: table-cell;
                vertical-align: middle;
                justify-content: center
            }
            .inner
            {
                margin-left: auto;
                margin-right: auto;
                min-height: 300px;
                min-width: 320px;
                /*max-width: 412px;*/
                width: calc(100% - 40px);
                padding: 15px;
                margin-bottom: 28px;
                background-color: #fff;
                -webkit-box-shadow: 0 2px 3px rgba(0,0,0,0.55);
                -moz-box-shadow: 0 2px 3px rgba(0,0,0,0.55);
                box-shadow: 0 2px 3px rgba(0,0,0,0.55);
                border: 1px solid #818c94;
                border: 1px solid rgba(0,0,0,0.4);
            }
            .inner img
            {
                width: 60px;
            }
            #pie
            {
                position: fixed;
                bottom: 0;
                width: 100%;
                overflow: visible;
                z-index: 99;
                clear: both;
                background-color: rgba(0,0,0,0.6);
                color: white;
                font-size: 12px;
                text-align: right;
            }
            #pie span
            {
                color: #fff;
                font-size: 12px;
                line-height: 28px;
                white-space: nowrap;
                display: inline-block;
                margin-left: 16px;
                margin-right: 16px
            }
    </style>
</head>

<body >

    <div class="outer">
        <div class="middle">
            <!--div class="row-fluid"-->
            	
                <div class="col-md-4 col-md-4 col-md-4-offset inner">
                	<img src="<?php echo $url."dist/img/naturesweet_picture.png"; ?>"  alt="Responsive image"><b style="color: #969696;"> Planta Colima</b>
                    <img src="<?php echo $url."dist/img/infor-logo.png"; ?>" class='pull-right' style='width: 36px;'  alt="Responsive image">
                    <hr>
                	<h4>Kit de mantenimiento v2</h4>

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
    							
    							echo "<div class='alert alert-danger' role='alert' id='mensaje'>
    								  <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
    								  <strong>Mensaje!</strong> <br>
    								  							$email no tiene acceso al sistema
    								  							<br> o sus datos son incorrectos.
    								</div>";
    							//die();
    						}
    					}
    				?>
                    
                    <form role="form" action="" method="post">
                        <fieldset>
                            <div class="form-group">
                                <input class="form-control" placeholder="Usuario" name="email" type="text" autocomplete="off" required value="" autofocus>
                            </div>
                            <div class="form-group">
                                <input class="form-control" placeholder="Password" name="password" type="password" autocomplete="of" required value="">
                            </div>
                            <!-- Change this to a button or input when using this as a form -->
                            <button type="submit" class="btn btn-md btn-success btn-block">Ingresar</button>
                        </fieldset>
                   	</form>
                </div>
            <!--/div-->
        </div>
    </div>

    <div id="pie"> 
        <span >© 2017 NatureSweet | Planta Colima</span>
    </div>

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

        $(".imagenPrincipal").css("height", "100%");
               
    });
</script>
</body>

</html>
