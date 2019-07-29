<?php
    require_once('includes/config.inc.php');
    require_once(VIEW_PATH.'headerGeneral.inc.php');
    //include(VIEW_PATH.'indexMenu.php');
    // creamos una sesión publica
    session_start();
    $email = "invitado";
    $password = 123; 
                  
    $password = base64_encode($password);

    $usr_correo = Usuarios::buscaUsuarioByEmailPassword($email, $password);
      
    // If result matched $email and $mypassword, table row must be 1 row 
    if(isset($usr_correo[0]))
    {
      $_SESSION['Login']['id']=$usr_correo[0]->id;
      $_SESSION["type"] = $usr_correo[0]->type;
      $_SESSION["usr_nombre"] = $usr_correo[0]->name;
      $_SESSION['login_user'] = $usr_correo[0]->email;
    }
    // termina inicializacion

  $fecha_hoy = date("Y-m-d");
  $calendarios = Disponibilidad_calendarios::getByDia($fecha_hoy);
  $semana_actual = $calendarios[0]->semana;

  $zancos_tamanos = Zancos_tamanos::getAllByOrden("id", "ASC");

  $consulta = "SELECT * FROM zancos_ghs GROUP BY zona ORDER BY zona ASC";
  $zancos_zonas = Zancos_ghs::getAllByQuery($consulta);
  
  $consulta = "SELECT m.*, zancos_tamanos.tamano AS tamano_descripcion

      FROM zancos_movimientos m
      INNER JOIN
      (
          SELECT max(id_registro) reg, no_zanco
          FROM zancos_movimientos
          GROUP BY no_zanco
      ) m2
        ON m.no_zanco = m2.no_zanco
        INNER JOIN zancos_tamanos ON m.tamano = zancos_tamanos.id
        AND m.id_registro = m2.reg
        AND m.tipo_movimiento = 2";
  $zancos_retirados = Zancos_movimientos::getAllByQuery($consulta); 
  
  $consulta = "SELECT m.*, zancos_tamanos.tamano AS tamano_descripcion, zancos_tamanos.limite_semana, zancos_bd.id AS id, zancos_acciones.accion AS accion_descripcion, zancos_acciones.id AS id_accion, m2.fecha_activacion_o_baja as f_activacion

      FROM zancos_movimientos m
      INNER JOIN
      (
          SELECT max(id_registro) reg, no_zanco, fecha_activacion_o_baja
          FROM zancos_movimientos
                
          GROUP BY no_zanco
      ) m2
        ON m.no_zanco = m2.no_zanco
        INNER JOIN zancos_acciones ON m.tipo_movimiento = zancos_acciones.id
        INNER JOIN zancos_tamanos ON m.tamano = zancos_tamanos.id
        INNER JOIN zancos_bd ON m.no_zanco = zancos_bd.no_zanco
        AND m.id_registro = m2.reg
              AND m.tipo_movimiento <> 2
        AND (DATEDIFF('$fecha_hoy', m2.fecha_activacion_o_baja) ) > (547.88)
        order by m.id_registro desc";
    //echo $consulta;   
  $zancos_mayores = Zancos_movimientos::getAllByQuery($consulta);
  //print_r($zancos_mayores);

  $consulta = "SELECT * FROM zancos_bd
          WHERE no_zanco NOT IN 
            (SELECT no_zanco
                          FROM zancos_movimientos
                        )
                    /*AND no_zanco > 0*/";
  $zancos_stock = Zancos_bd::getAllByQuery($consulta);

  //echo "<pre>"; print_r($zancos_stock); echo "</pre>";

  $consulta = "SELECT m.*, zancos_tamanos.tamano AS tamano_descripcion

      FROM zancos_movimientos m
      INNER JOIN
      (
          SELECT max(id_registro) reg, no_zanco
          FROM zancos_movimientos
          GROUP BY no_zanco
      ) m2
        ON m.no_zanco = m2.no_zanco
        INNER JOIN zancos_tamanos ON m.tamano = zancos_tamanos.id
        AND m.id_registro = m2.reg
        AND m.tipo_movimiento = 3
        AND m.fecha_entrega <> 0
              AND m.fecha_servicio = 0";
  $zancos_servicio = Zancos_bd::getAllByQuery($consulta);


  $consulta = "SELECT m.*, zancos_tamanos.tamano AS tamano_descripcion

      FROM zancos_movimientos m
      INNER JOIN
      (
          SELECT max(id_registro) reg, no_zanco
          FROM zancos_movimientos
          GROUP BY no_zanco
      ) m2
        ON m.no_zanco = m2.no_zanco
        INNER JOIN zancos_tamanos ON m.tamano = zancos_tamanos.id
        AND m.id_registro = m2.reg
        AND m.tipo_movimiento = 3
        AND m.fecha_entrega = 0
        AND (DATEDIFF('$fecha_hoy', m.fecha_salida) ) > (m.tiempo_limite * 7)";

  $zancos_desfase = Zancos_bd::getAllByQuery($consulta);

  $consulta = "SELECT m.*, zancos_tamanos.tamano AS tamano_descripcion

      FROM zancos_movimientos m
      INNER JOIN
      (
          SELECT max(id_registro) reg, no_zanco
          FROM zancos_movimientos
          GROUP BY no_zanco
      ) m2
        ON m.no_zanco = m2.no_zanco
        INNER JOIN zancos_tamanos ON m.tamano = zancos_tamanos.id
        AND m.id_registro = m2.reg
        AND m.tipo_movimiento = 3
        AND m.fecha_entrega = 0";
  $zancos_campo = Zancos_bd::getAllByQuery($consulta);

  $consulta = "SELECT m.*, zancos_tamanos.tamano AS tamano_descripcion

      FROM zancos_movimientos m
      INNER JOIN
      (
          SELECT max(id_registro) reg, no_zanco
          FROM zancos_movimientos
          GROUP BY no_zanco
      ) m2
        ON m.no_zanco = m2.no_zanco
        INNER JOIN zancos_tamanos ON m.tamano = zancos_tamanos.id
        AND m.id_registro = m2.reg
        AND (m.tipo_movimiento = 1
            OR (m.tipo_movimiento = 3
              AND m.fecha_servicio <> 0) )";
  $zancos_activo = Zancos_bd::getAllByQuery($consulta);

  $consulta = "SELECT m.*, zancos_tamanos.tamano AS tamano_descripcion

      FROM zancos_movimientos m
      INNER JOIN
      (
          SELECT max(id_registro) reg, no_zanco
          FROM zancos_movimientos
          GROUP BY no_zanco
      ) m2
        ON m.no_zanco = m2.no_zanco
        INNER JOIN zancos_tamanos ON m.tamano = zancos_tamanos.id
        AND m.id_registro = m2.reg
        AND (m.tipo_movimiento = 1                                /*disponible*/
            OR (m.tipo_movimiento = 3 AND m.fecha_servicio <> 0)                  /*disponible*/
            OR (m.tipo_movimiento = 3 AND m.fecha_entrega = 0)                  /*campo*/
            OR (m.tipo_movimiento = 3 AND m.fecha_entrega <> 0 AND m.fecha_servicio = 0)        /*servicio*/
            )";
  $zancos_total = Zancos_bd::getAllByQuery($consulta);
    //print_r($años);
 ?>
      
            
        <!-- page content -->
        <div class="" role="main" >
          
          <div class='container text-center'>
            <h3 class="text-center" > Zancos (dashboard)</h3>
            
            <?php
                      include(VIEW_PATH.'indexMenu_public_zancos.php')
                    ?>
          </div>
          
            
          <br>
          <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                  
              <div class="x_content">
                <!-- aqui va el contenido -->
                <div style="text-align: center;">
                    <h3>Al: </b> <?php echo $fecha_hoy; ?> </h3>
                    <h4>WK:  <?php echo $semana_actual; ?> </h4>
                </div>
                <table class="table table-condensed table-striped">
                    <tr>
                        
                        <td style="vertical-align:middle; text-align: center;">
                            <i class="fa fa-database fa-3x" aria-hidden="true" style="color: #2DB67C;"></i>
                            <h3 style="color: black;">TOTAL</h3>
                        </td>
                        <td style="background: #2DB67C; color:white; vertical-align:middle; text-align: center;">
                            <h3>
                                <?php echo count($zancos_total) + count($zancos_stock); ?>
                            </h3>
                        </td>
                        <td style="vertical-align:middle; text-align: center;">
                            <i class="fa fa-angle-double-right fa-2x" aria-hidden="true"></i>
                        </td>
                        <td>
                            <table class="table table-bordered table-condensed">
                                <?php 
                                    foreach ($zancos_tamanos as $t) 
                                    {
                                        $x = 0;
                                        echo "<tr>";
                                            echo "<td>".$t->tamano."</td>";
                                            foreach ($zancos_total as $total) 
                                            {
                                                if ($total->tamano == $t->id) 
                                                {
                                                    $x++;
                                                }
                                            }
                                            foreach ($zancos_stock as $stock) 
                                            {
                                                if ($stock->tamano == $t->id) 
                                                {
                                                    $x++;
                                                }
                                            }
                                            echo "<td style='text-align:right;'><button class='btn btn-sm' style='background: #2DB67C; color:white; width:50px; ' title='Ver zancos'>".$x."</button></td>";
                                        echo "</tr>";
                                    }
                                ?>
                            </table>
                        </td>
                        <td colspan="2"></td>
                    </tr>
                    <tr>
                        
                        <td style="vertical-align:middle; text-align: center;">
                            <i class="fa fa-thumbs-up fa-3x" aria-hidden="true" style="color: #218838;"></i>
                            <h3 style="color: black;">DISPONIBLES</h3>
                        </td>
                        <td style="background: #218838; color:white; vertical-align:middle; text-align: center;">
                            <h3>
                                <?php echo count($zancos_activo); ?>
                            </h3>
                        </td>
                        <td style="vertical-align:middle; text-align: center;">
                            <i class="fa fa-angle-double-right fa-2x" aria-hidden="true"></i>
                        </td>
                        <td>
                            <table class="table table-bordered table-condensed" >
                                <?php 
                                    foreach ($zancos_tamanos as $t) 
                                    {
                                        $x = 0;
                                        echo "<tr>";
                                            echo "<td>".$t->tamano."</td>";
                                            foreach ($zancos_activo as $activo) 
                                            {
                                                if ($activo->tamano == $t->id) 
                                                {
                                                    $x++;
                                                }
                                            }
                                            echo "<td style='text-align:right;'><button consulta='DISPONIBLES' tamano='".$t->id."' class='btn btn-sm ver' style='background: #218838; color:white; width:50px; ' title='Ver zancos'>".$x."</button></td>";
                                        echo "</tr>";
                                    }
                                ?>
                            </table>
                        </td>
                        <td colspan="2"></td>
                    </tr>
                    <tr>
                        
                        <td style="vertical-align:middle; text-align: center;">
                            <i class="fa fa-industry fa-3x" aria-hidden="true" style="color: #E0A800;"></i>
                            <h3 style="color: black;">CAMPO</h3>
                        </td>
                        <td style="background: #E0A800; color: black;  vertical-align:middle; text-align: center;" >
                            <h3>
                                <?php echo count($zancos_campo); ?>
                            </h3>
                        </td>
                        <td style="vertical-align:middle; text-align: center; ">
                            <i class="fa fa-angle-double-right fa-2x" aria-hidden="true"></i>
                        </td>
                        <td>
                            <table class="table table-bordered table-condensed">
                                <?php 
                                    foreach ($zancos_tamanos as $t) 
                                    {
                                        $x = 0;
                                        echo "<tr>";
                                            echo "<td>".$t->tamano."</td>";
                                            foreach ($zancos_campo as $campo) 
                                            {
                                                if ($campo->tamano == $t->id) 
                                                {
                                                    $x++;
                                                }
                                            }
                                            echo "<td style='text-align:right;'><button consulta='CAMPO' tamano='".$t->id."' 
                                            class='btn btn-sm ver' style='background: #E0A800; color: black; width:50px; ' title='Ver zancos'>".$x."</button></td>";
                                        echo "</tr>";
                                    }
                                ?>
                            </table>
                        </td>
                        <td style="vertical-align:middle; text-align: center;">
                            <i class="fa fa-angle-double-right fa-2x" aria-hidden="true"></i>
                        </td>
                        <td>
                            <table class="table table-bordered table-condensed">
                                <tr style="background: #E0A800; color: black;">
                                    <td> TAMANOS / ZONAS</td>
                                    <?php
                                        foreach ($zancos_zonas as $z)
                                        {
                                            
                                            echo "<td>".$z->zona."</td>";
                                            
                                        } 
                                    ?>
                                </tr>
                                <tr style="border-bottom: 2px solid #E0A800;;">
                                    <td> * </td>
                                    <?php
                                        foreach ($zancos_zonas as $z)
                                        {
                                            
                                            $y = 0;
                                            foreach ($zancos_campo as $campo) 
                                            {
                                                if ($campo->zona == $z->zona) 
                                                {
                                                    $y++;
                                                }
                                            }
                                            echo "<td style='color: black' >".$y."</td>";
                                            
                                        } 
                                    ?>
                                </tr>
                                <?php 
                                    foreach ($zancos_tamanos as $t) 
                                    {
                                        echo "<tr>";
                                            echo "<td>".$t->tamano."</td>";
                                            foreach ($zancos_zonas as $z)
                                            {
                                                
                                                $w = 0;
                                                foreach ($zancos_campo as $campo) 
                                                {
                                                    if ( ($campo->zona == $z->zona) && ($campo->tamano == $t->id) ) 
                                                    {
                                                        $w++;
                                                    }
                                                }

                                                if($w > 0)
                                                {
                                                    echo "<td style=' background: #FFF3CD; color: black;' >".$w."</td>";
                                                }
                                                else
                                                {
                                                    echo "<td  >".$w."</td>";
                                                }
                                                
                                            } 
                                        echo "</tr>";
                                    }
                                ?>
                            </table>
                        </td>
                    </tr>

                    <tr>
                        
                        <td style="vertical-align:middle; text-align: center;">
                            <i class="fa fa-calendar-times-o fa-3x" aria-hidden="true" style="color: #C82333;"></i>
                            <h3 style="color: black;">DESFASE</h3>
                        </td>
                        <td style="background: #C82333; color: white; vertical-align:middle; text-align: center;" >
                            <h3>
                                <?php echo count($zancos_desfase); ?>
                            </h3>
                        </td>
                        <td style="vertical-align:middle; text-align: center; ">
                            <i class="fa fa-angle-double-right fa-2x" aria-hidden="true"></i>
                        </td>
                        <td>
                            <table class="table table-bordered table-condensed">
                                <?php 
                                    foreach ($zancos_tamanos as $t) 
                                    {
                                        $x = 0;
                                        echo "<tr>";
                                            echo "<td>".$t->tamano."</td>";
                                            foreach ($zancos_desfase as $desfase) 
                                            {
                                                if ($desfase->tamano == $t->id) 
                                                {
                                                    $x++;
                                                }
                                            }
                                            echo "<td style='text-align:right;'><button consulta='DESFASE' tamano='".$t->id."' class='btn btn-sm ver' style='background: #C82333; color:white; width:50px; ' title='Ver zancos'>".$x."</button></td>";
                                        echo "</tr>";
                                    }
                                ?>
                            </table>
                        </td>
                        <td style="vertical-align:middle; text-align: center;">
                            <i class="fa fa-angle-double-right fa-2x" aria-hidden="true"></i>
                        </td>
                        <td>
                            <table class="table table-bordered table-condensed">
                                <tr style="background: #C82333; color: white;">
                                    <td> TAMANOS / ZONAS</td>
                                    <?php
                                        foreach ($zancos_zonas as $z)
                                        {
                                            
                                            echo "<td>".$z->zona."</td>";
                                            
                                        } 
                                    ?>
                                </tr>
                                <tr style="border-bottom: 2px solid #C82333;">
                                    <td> * </td>
                                    <?php
                                        foreach ($zancos_zonas as $z)
                                        {
                                            
                                            $y = 0;
                                            foreach ($zancos_desfase as $desfase) 
                                            {
                                                if ($desfase->zona == $z->zona) 
                                                {
                                                    $y++;
                                                }
                                            }
                                            echo "<td style='color: #C82333;' >".$y."</td>";
                                            
                                        } 
                                    ?>
                                </tr>
                                <?php 
                                    foreach ($zancos_tamanos as $t) 
                                    {
                                        echo "<tr>";
                                            echo "<td>".$t->tamano."</td>";
                                            foreach ($zancos_zonas as $z)
                                            {
                                                
                                                $w = 0;
                                                foreach ($zancos_desfase as $desfase) 
                                                {
                                                    if ( ($desfase->zona == $z->zona) && ($desfase->tamano == $t->id) ) 
                                                    {
                                                        $w++;
                                                    }
                                                }

                                                if($w > 0)
                                                {
                                                    echo "<td style=' background: #F8D7DA; color: black;' >".$w."</td>";
                                                }
                                                else
                                                {
                                                    echo "<td  >".$w."</td>";
                                                }
                                                
                                                
                                            } 
                                        echo "</tr>";
                                    }
                                ?>
                            </table>
                        </td>
                    </tr>

                    <tr>
                        
                        <td style="vertical-align:middle; text-align: center;">
                            <i class="fa fa-wrench fa-3x" aria-hidden="true" style="color: #0069D9;"></i>
                            <h3 style="color: black;">SERVICIO</h3>
                        </td>
                        <td style="background: #0069D9; color: white; vertical-align:middle; text-align: center;">
                            <h3>
                                <?php echo count($zancos_servicio); ?>
                            </h3>
                        </td>
                        <td style="vertical-align:middle; text-align: center;">
                            <i class="fa fa-angle-double-right fa-2x" aria-hidden="true"></i>
                        </td>
                        <td>
                            <table class="table table-bordered table-condensed">
                                <?php 
                                    foreach ($zancos_tamanos as $t) 
                                    {
                                        $x = 0;
                                        echo "<tr>";
                                            echo "<td>".$t->tamano."</td>";
                                            foreach ($zancos_servicio as $servicio) 
                                            {
                                                if ($servicio->tamano == $t->id) 
                                                {
                                                    $x++;
                                                }
                                            }
                                            echo "<td style='text-align:right;'><button consulta='SERVICIO' tamano='".$t->id."' class='btn btn-sm ver' style='background: #0069D9; color: white; width:50px; ' title='Ver zancos'>".$x."</button></td>";
                                        echo "</tr>";
                                    }
                                ?>
                            </table>
                        </td>
                        <td colspan="2"></td>
                    </tr>

                    <tr>
                        
                        <td style="vertical-align:middle; text-align: center;">
                            <i class="fa fa-home fa-3x" aria-hidden="true" style="color: #5A6268;"></i>
                            <h3 style="color: black;">STOCK</h3>
                        </td>
                        <td style="background: #5A6268; color: white; vertical-align:middle; text-align: center;">
                            <h3>
                                <?php echo count($zancos_stock); ?>
                            </h3>
                        </td>
                        <td style="vertical-align:middle; text-align: center;">
                            <i class="fa fa-angle-double-right fa-2x" aria-hidden="true"></i>
                        </td>
                        <td>
                            <table class="table table-bordered table-condensed">
                                <?php 
                                    foreach ($zancos_tamanos as $t) 
                                    {
                                        $x = 0;
                                        echo "<tr>";
                                            echo "<td>".$t->tamano."</td>";
                                            foreach ($zancos_stock as $s) 
                                            {
                                                if ($s->tamano == $t->id) 
                                                {
                                                    $x++;
                                                }
                                            }
                                            echo "<td style='text-align:right;'><button consulta='STOCK' tamano='".$t->id."' class='btn btn-sm ver' style='background: #5A6268; color: white; width:50px; ' title='Ver zancos'>".$x."</button></td>";
                                        echo "</tr>";
                                    }
                                ?>
                            </table>
                        </td>
                        <td colspan="2"></td>
                    </tr>

                    <tr>
                        
                        <td style="vertical-align:middle; text-align: center;">
                            <i class="fa fa-heartbeat fa-3x" aria-hidden="true" style="color: #138496;"></i>
                            <h3 style="color: black;">MAYOR A 1.5 AÑOS</h3>
                        </td>
                        <td style="background: #138496; color: white; vertical-align:middle; text-align: center;">
                            <h3>
                                <?php echo count($zancos_mayores); ?>
                            </h3>
                        </td>
                        <td style="vertical-align:middle; text-align: center;">
                            <i class="fa fa-angle-double-right fa-2x" aria-hidden="true"></i>
                        </td>
                        <td>
                            <table class="table table-bordered table-condensed">
                                <?php 
                                    foreach ($zancos_tamanos as $t) 
                                    {
                                        $x = 0;
                                        echo "<tr>";
                                            echo "<td>".$t->tamano."</td>";

                                            foreach ($zancos_mayores as $m) 
                                            {
                                                if ($m->tamano == $t->id) 
                                                {
                                                    $x++;
                                                }
                                            }
                                            echo "<td style='text-align:right;'><button consulta='MAYOR A 1.5 AÑOS' tamano='".$t->id."' class='btn btn-sm ver' style='background: #138496; color: white; width:50px; ' title='Ver zancos'>".$x."</button></td>";
                                        echo "</tr>";
                                    }
                                ?>
                            </table>
                        </td>
                        <td colspan="2"></td>
                    </tr>

                    <tr>
                        
                        <td style="vertical-align:middle; text-align: center;">
                            <i class="fa fa-times fa-3x" aria-hidden="true" style="color: #563D7C;"></i>
                            <h3 style="color: black;">RETIRADOS</h3>
                        </td>
                        <td style="background: #563D7C; color: white; vertical-align:middle; text-align: center;">
                            <h3>
                                <?php echo count($zancos_retirados); ?>
                            </h3>
                        </td>
                        <td style="vertical-align:middle; text-align: center;">
                            <i class="fa fa-angle-double-right fa-2x" aria-hidden="true"></i>
                        </td>
                        <td>
                            <table class="table table-bordered table-condensed">
                                <?php 
                                    foreach ($zancos_tamanos as $t) 
                                    {
                                        $x = 0;
                                        echo "<tr>";
                                            echo "<td>".$t->tamano."</td>";

                                            foreach ($zancos_retirados as $r) 
                                            {
                                                if ($r->tamano == $t->id) 
                                                {
                                                    $x++;
                                                }
                                            }
                                            echo "<td style='text-align:right;'><button consulta='RETIRADOS' tamano='".$t->id."' class='btn btn-sm ver' style='background: #563D7C; color: white; width:50px; ' title='Ver zancos'>".$x."</button></td>";
                                        echo "</tr>";
                                    }
                                ?>
                            </table>
                        </td>
                        <td colspan="2"></td>
                    </tr>
                </table>
            
              <!-- /.table-responsive -->
              </div>
            </div>
          </div>  
        </div>


          
        <!-- Modal -->
        <div class="modal fade bs-example-modal-lg" id="modalAgregar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
          <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Zancos</h4>
              </div>
              <div class="modal-body">
                        <div id="divdestino">
                    </div>
              </div>
              <div class="modal-footer" style="text-align: center;">
                    <button type="button" class="btn btn-success" data-dismiss="modal">Cerrar</button>
                  </div>
            </div>
          </div>
        </div>
          

         

 

 <?php require_once(VIEW_PATH.'footer.inc.php'); ?>
        <script type="text/javascript">
          $(document).ready(function()
            {
                
       

                $(".ver").on("click", function(event) 
                { 
                    event.preventDefault();
                    var consulta = null;
                    var tamano = null;
                    var titulo = null;
                        consulta = $(this).attr("consulta");
                        tamano = $(this).attr("tamano");
                        titulo = consulta.toLowerCase();

                    ajaxCargaDatos("divdestino", consulta, tamano, titulo);

                
                });

                

                function creaAjax()
                {
                    var objetoAjax=false;
                    try {
                        /*Para navegadores distintos a internet explorer*/
                        objetoAjax = new ActiveXObject("Msxml2.XMLHTTP");
                    } catch (e)
                    {
                        try {
                            /*Para explorer*/
                            objetoAjax = new ActiveXObject("Microsoft.XMLHTTP");
                        } catch (E) {
                            objetoAjax = false;
                            }
                        }
                    if (!objetoAjax && typeof XMLHttpRequest!='undefined') {
                        objetoAjax = new XMLHttpRequest();
                    }
                    return objetoAjax;
                }

                function ajaxCargaDatos(divdestino, c, t, nombre)
                {
                    var ajax=creaAjax();

                    ajax.open("GET", "helper_zancos_details.php?consulta="+c+"&tamano="+t, true);
                    ajax.onreadystatechange=function() 
                    { 
                        if (ajax.readyState==1)
                        {
                          // Mientras carga ponemos un letrerito que dice "Verificando..."
                          $('#'+divdestino).html("<img src='dist/img/load_2019.gif'>");
                        }
                        if (ajax.readyState==4)
                        {
                          // Cuando ya terminó, ponemos el resultado
                            var str =ajax.responseText; 
                            
                            $("#myModalLabel").text("Zancos "+ nombre);                        
                            $('#'+divdestino).html(''+str+'');
                            $("#modalAgregar").modal("show");
                
                        } 
                    }
                    ajax.send(null);
                }

                

            }); // end ready
        </script>

  </body>
</html>




