<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Kit NS V2.0</title>

    <!-- Bootstrap -->
    <link href="vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <!-- NProgress -->
    <link href="vendors/nprogress/nprogress.css" rel="stylesheet">
    <!-- iCheck -->
    <link href="vendors/iCheck/skins/flat/green.css" rel="stylesheet">
     <!-- Datatables -->
    <link href="vendors/datatables.net-bs/css/dataTables.bootstrap.min.css" rel="stylesheet">
    <link href="vendors/datatables.net-buttons-bs/css/buttons.bootstrap.min.css" rel="stylesheet">
    <link href="vendors/datatables.net-fixedheader-bs/css/fixedHeader.bootstrap.min.css" rel="stylesheet">
    <link href="vendors/datatables.net-responsive-bs/css/responsive.bootstrap.min.css" rel="stylesheet">
    <link href="vendors/datatables.net-scroller-bs/css/scroller.bootstrap.min.css" rel="stylesheet">
    <!-- bootstrap-progressbar -->
    <link href="vendors/bootstrap-progressbar/css/bootstrap-progressbar-3.3.4.min.css" rel="stylesheet">
    <!-- JQVMap -->
    <link href="vendors/jqvmap/dist/jqvmap.min.css" rel="stylesheet"/>
    <!-- bootstrap-daterangepicker -->
    <link href="vendors/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet">

    <!-- Custom Theme Style -->
    <link href="build/css/custom.min.css" rel="stylesheet">


    <link rel="stylesheet" type="text/css" href="<?php echo $url; ?>dist/css/naturesweet.css">

    <link rel="stylesheet" type="text/css" href="<?php echo $url; ?>dist/slick/slick.css">
    <link rel="stylesheet" type="text/css" href="<?php echo $url; ?>dist/slick/slick-theme.css">

    <link rel="stylesheet" type="text/css" href="<?php echo $url; ?>dist/css/star-rating.css">
     <link rel="stylesheet" type="text/css" href="<?php echo $url; ?>dist/css/bootstrap-social.css">
  </head>

<body class="footer_fixed nav-md"> 
    <div class="container body">
        <div class="main_container">
            <div class="col-md-3 left_col">
                <div class="left_col scroll-view">
                    <div class="navbar nav_title" style="border: 0;">
                        <a href="indexMain.php" class="site_title">
                            <img width="80%" src="<?php echo $url; ?>dist/img/naturesweet_picture.png">
                        </a>
                    </div>

                    <div class="clearfix"></div>
                    <br />

                    <?php
                      include(VIEW_PATH.'indexMenu.php')
                    ?>

                    

                </div>
            </div>

            <!-- top navigation -->
            <div class="top_nav">
              <div class="nav_menu">
                <nav>
                  <div class="nav toggle">
                    
                    <a id="menu_toggle"><i class="fa fa-bars"></i>  </a>
                  </div>

                  <ul class="nav navbar-nav navbar-right">
                    <li class="">
                      <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                        <img src="" alt=""><?php echo $_SESSION["usr_nombre"]; ?>
                        <span class=" fa fa-angle-down"></span>
                      </a>
                        <ul class="dropdown-menu dropdown-usermenu pull-right">
                            <li>
                                <a href="<?php echo $url;?>lib/logout.php"><i class="fa fa-sign-out pull-right"></i> Cerrar sesi&oacute;n</a>
                            </li>
                        </ul>
                    </li>

                    <li role="presentation" class="dropdown">
                      <a href="javascript:;" class="dropdown-toggle info-number" data-toggle="dropdown" aria-expanded="false">
                        <i class="fa fa-envelope-o"></i>
                        <span class="badge bg-green">1</span>
                      </a>
                      <ul id="menu1" class="dropdown-menu list-unstyled msg_list" role="menu">
                        <li>
                            <a>
                                <span class="image"><img src="<?php echo $url; ?>dist/img/naturesweet_picture.png" alt="Profile Image" /></span>
                                <span>
                                    <span>Admin</span>
                                    <span class="time">Hoy</span>
                                </span>
                                <span class="message">
                                    Nueva versi&oacute;n del kit de mantenimiento...
                                </span>
                            </a>
                        </li>
                        
                      </ul>
                    </li>
                  </ul>
                </nav>
              </div>
            </div>
            <!-- /top navigation -->
