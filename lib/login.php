<?php
require_once('../includes/config.inc.php');
   session_start();

   
   if($_SERVER["REQUEST_METHOD"] == "POST") 
   {
      // username and password sent from form 
      //die("dd");
      $myusername = $_POST['username'];
      $mypassword = $_POST['password']; 
      
      $usr_correo = Usuarios::buscaUsuarioByEmail($myusername);
					
		//$iniciarSesion='<a href="'.$url.'lib/logout.php" class="navbar-link">Salir</a>';
      
      // If result matched $myusername and $mypassword, table row must be 1 row
		
      if(isset($usr_correo[0]))
      {
						$_SESSION['Login']['id']=$usr_correo[0]->id;
						$_SESSION["tipo"]=1;
						//$_SESSION["nivel"]=$usr_correo[0]->nivel;
						$_SESSION["usr_nombre"]=$usr_correo[0]->nombre;
						$_SESSION['login_user'] = $myusername;
						//$_SESSION['salir']='<a href="'.$url.'lib/logout.php" class="navbar-link">Salir</a>';
         
         				//header("location: ../indexMain.php");
						

						
						
					}else{
						$_SESSION['Login']['id']=0;
						//session_unset();
						
						echo "<div style='background-color: #f0ad4e; padding: 15px 20px; text-align: center; color: #fff; font-family: \".Helvetica Neue\",Helvetica,Arial,sans-serif;'><img src='https://wayf.ucol.mx/imglogin/UdClog.png'><br>Correo $myusername NO tiene permiso en sitio<br>$iniciarSesion</div>";
						die();
					}
   }
?>