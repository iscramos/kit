<?php
   include('includes/config.inc.php');
   ini_set("session.cookie_lifetime", "3600"); 
   ini_set("session.gc_maxlifetime", "3600"); 
   session_start();
   
   $user_check = $_SESSION['login_user'];
   
   $usu = Usuarios::buscaUsuarioByEmail($user_check);
  // $ses_sql = mysqli_query($db,"select username from admin where username = '$user_check' ");
   
   //$row = mysqli_fetch_array($ses_sql,MYSQLI_ASSOC);
   
   $login_session = $usu[0]->email;
   
   if(!isset($_SESSION['login_user']))
   {
      //header("location:index.php");
      header("location:404.php");
   }
?>