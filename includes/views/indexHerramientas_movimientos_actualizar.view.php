 <?php require_once(VIEW_PATH.'header.inc.php');
 ?>

         <!-- page content -->
        <div class="right_col" role="main">
            <div class="">
                <div class="page-title">
                    <div class="title_left">
                        <h3>Herramientas (movimientos)...</h3>
                    </div>
                    <div class="title_right ">
                        <div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search">
                        </div>
                    </div>

                </div>

                <div class="clearfix"></div>

                <div class="row">
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="x_panel">
                            <div class="x_title">
                                <h2><i class="fa fa-cogs"></i> Visualización <small>del registro</small></h2>

                                <ul class="nav navbar-right panel_toolbox">
                                  <li>
                                    <a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                                  </li>
                                </ul>
                                <div class="clearfix"></div>
                            </div>
                            <div class="x_content">


                                <!-- aqui va el contenido -->
                               <form class="col-sm-8 col-sm-offset-2" name="frmtipo" id="divdestino" method="post" action="<?php echo $url; ?>createHerramientas_movimientos.php">
                                    

                                    <?php
                                    if ($action == "NEW") // PARA CUANDO ACTIVAMOS UN REGISTRO
                                    {
                                    ?>    

                                        
                                        <div class="row">
                                            <div class="form-group col-sm-4 imagenArt" style="text-align: center;">
                                                <img src='dist/img/no_disponible.png ' width='100px' height='90px'>
                                                
                                            </div>
                                            <div class="form-group  col-sm-8">
                                                <label >CLAVE / CODIGO DE BARRAS</label>
                                                <div class="input-group " style="margin-bottom: 0px;">
                                                    <input type="text" name="clave" id="clave" class="form-control" value="" required="required" onkeyup="javascript:this.value=this.value.toUpperCase();">
                                                    <span class="input-group-btn">
                                                        <button type="button" class="btn btn-primary" id="buscar" title="Buscar artículo"> <span class='glyphicon glyphicon-search'></span> </button>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                        <div id="recibeData" style="text-align: center;">
                                            <!-- aquí irá el resultado de la búsqueda--> 
                                        </div>
                                    
                                        

                                            

                                    <?php
                                    }
                                    else if ($action == "NEW_CON_ART") // PARA CUANDO ACTIVAMOS UN REGISTRO
                                    {
                                    ?>    

                                        
                                        <div class="row">
                                            <div class="form-group  col-sm-4" style="text-align: center;">
                                                <?php
                                                    if($articulo->archivo != "")
                                                    {

                                                        echo "<img src='".$contentRead.$articulo->archivo."' width='100px' height='90px'>";
                                                    }
                                                    else
                                                    {
                                                        echo "<img src='dist/img/no_disponible.png' width='100px' height='90px'>";
                                                    }
                                                ?>
                                                
                                            </div>
                                            <div class="form-group  col-sm-8">
                                                <label >CLAVE / CODIGO DE BARRAS</label>
                                                <input type="text" name="clave" id="clave" class="form-control" value="<?php echo $articulo->clave; ?>" required="required" readonly="true">
                                            </div>
                                        </div>
                                        
                                        
                                    <div style="text-align: center;">    
                                        
                                        <div class="row">
                                            <div class="form-group col-sm-12" >
                                                <label style="font-size: large; text-align: right;">No de registro: <b style="color: orangered;"><?php echo $registro_autoincrementa; ?> </b></label>
                                                <input type="number" class="form-control hidden" name="id_registro" id="id_registro" value="" autocomplete=""  readonly="true">
                                            </div>
                                        </div>
                                        <div class="row">
                                            
                                            <div class='form-group col-sm-12' style='text-align: right; background: #233e50;'>
                                                <div style="color: white; float: left; text-align: left;" class="col-sm-8">
                                                    <h6 style="color: #F3D93A;" id="departamento"></h6>
                                                    <h6 style="color: #F3D93A;" id="puesto"></h6>
                                                    <h6 style="color: #F3D93A;" id="estatus"></h6>
                                                    <h6 style="color: #F3D93A;" id="lider"></h6>
                                                </div>

                                                <label id="fechaActual" class="hidden"><?php echo date("Y-m-d"); ?></label>
                                                <img  class='imagenPerfil img-circle' src='dist/img/avatar.jpg' width='80px'; height='80px;' style='border:3px solid white; margin: 5px;'>
                                                
                                            </div>
                                        </div>
                                    
                                        <div class="row">
                                            <div class="form-group col-sm-4 hidden">   
                                                <label >Tamaño</label>
                                                <input type="number" class="form-control" name="tamano" id="tamano" value=""readonly="true">
                                            </div>

                                            <div class="form-group col-sm-4 ">   
                                                <label >Tamaño</label>
                                                <input type="text" class="form-control" name="descripcion" id="descripcion" value="" autocomplete="" readonly="true">
                                            </div>

                                            <div class="form-group col-sm-4">   
                                                <label >Límite semanal</label>
                                                <input type="number" class="form-control" name="tiempo_limite" id="tiempo_limite" value="" autocomplete="" readonly="true">
                                            </div> 
                                            <div class="form-group col-sm-4">
                                                <label >Tipo de movimiento</label>
                                                <select class="form-control" name="tipo_movimiento" id="tipo_movimiento" required="required" >
                                                    
                                                    <?php
                                                        foreach ($herramientas_acciones as $a) 
                                                        {
                                                            if($a->id == 3)
                                                            {
                                                                echo "<option value='".$a->id."' style='display:none;'>".$a->accion."</option>";
                                                            }
                                                        }
                                                    ?>
                                                </select>
                                            </div> 
                                        </div>

                                        <!-- SEGUNDA LINEA -->
                                        <div class='row'>
                                            <div class='form-group col-sm-4'>
                                                <label >Invernadero</label>
                                                <select class='form-control' name='gh' id='gh' required='required'>
                                                    <option value='' style='display: none;'>Seleccione</option>";
                                                    <?php
                                                        foreach ($herramientas_ghs as $g) 
                                                        {
                                                            echo "<option value='".$g->gh."' valorZona='".$g->zona."'>".$g->gh."</option>";
                                                        }
                                                    ?>     
                                                   
                                                </select>
                                            </div>

                                            <div class='form-group col-sm-4'>
                                                <label >Zona</label>
                                                <input type='text' class='form-control' name='zona' id='zona' value=''  required='required' readonly='true'>
                                            </div>

                                            <div class='form-group'>
                                                <div class='col-sm-4'>
                                                    <label >Fecha activación / baja</label>
                                                    <div class='input-group date' id='datetimepicker1' style='pointer-events: none;'>
                                                        <input type='text' name='fecha_activacion_o_baja' id='fecha_activacion_o_baja' class='form-control' value='' autocomplete='off' readonly='true'>
                                                        <span class='input-group-addon'>
                                                            <span class='glyphicon glyphicon-calendar'></span>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class='row'>
                                            <div class='form-group col-sm-4'>
                                                <label >Código asociado</label>
                                                <div class='input-group' style='margin-bottom: 0px;'>
                                                    <input type='number' name='ns_salida_lider' id='ns_salida_lider' class='form-control' value='' required='required'>
                                                    <span class='input-group-btn'>
                                                        <button type='button' class='btn btn-primary' id='buscar_asociado' title='Buscar zanco'> <span class='glyphicon glyphicon-search'></span> </button>
                                                    </span>
                                                </div>
                                            </div>

                                            <div class='form-group col-sm-4'>
                                                <label >Nombre asociado</label>
                                                <input type='text' class='form-control' name='nombre_lider_salida' id='nombre_lider_salida' value='' autocomplete='' required readonly='true'>
                                            </div>


                                            <div class='form-group'>
                                                <div class='col-sm-4'>
                                                    <label >Fecha salida</label>
                                                    <div class='input-group date' id='datetimepicker2' >
                                                        <input type='text' name='fecha_salida' id='fecha_salida' class='form-control' value='' autocomplete='off' required="true">
                                                        <span class='input-group-addon'>
                                                            <span class='glyphicon glyphicon-calendar'></span>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class='row'>
                                            <div class='form-group col-sm-4'>
                                                <label >Semana salida</label>
                                                <input type='number' class='form-control' name='wk_salida' id='wk_salida' value='' autocomplete='' required readonly='true'>
                                            </div>

                                            <div class='form-group col-sm-4'>
                                                <label >Semanas desfase</label>
                                                <input type='number' class='form-control' name='wk_desfase' id='wk_desfase' value='' autocomplete='' required readonly='true'>
                                            </div>

                                            <div class='form-group'>
                                                <div class='col-sm-4'>
                                                    <label >Fecha entrega</label>
                                                    <div class='input-group date' id='datetimepicker3' >
                                                        <input type='text' name='fecha_entrega' id='fecha_entrega' class='form-control' value='' autocomplete='off' >
                                                        <span class='input-group-addon'>
                                                            <span class='glyphicon glyphicon-calendar'></span>
                                                        </span>
                                                    </div>
                                                </div>  
                                            </div>
                                        </div>

                                        <div class='row'>
                                            <div class='form-group col-sm-4'>
                                                <label >Semana entrega</label>
                                                <input type='number' class='form-control' name='wk_entrega' id='wk_entrega' value='' autocomplete='' required readonly='true'>
                                            </div>

                                            <div class='form-group'>
                                                <div class='col-sm-4'>
                                                    <label >Fecha servicio</label>
                                                    <div class='input-group date' id='datetimepicker4'>
                                                        <input type='text' name='fecha_servicio' id='fecha_servicio' class='form-control' value='' autocomplete='off' >
                                                        <span class='input-group-addon'>
                                                            <span class='glyphicon glyphicon-calendar'></span>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class='form-group col-sm-4'>
                                                <label >Problema</label>
                                                <select class='form-control' name='descripcion_problema' id='descripcion_problema' readonly='true' >
                                                    <option value='' style='display: none;' >Seleccione</option>
                                                    <?php
                                                        foreach ($herramientas_problemas as $p) 
                                                        {
                                                            echo "<option value='".$p->id."'>".$p->descripcion."</option>";  
                                                        }
                                                    ?> 
                                                </select>
                                            </div>
                                        </div>

                                            

                                    <?php
                                    }
                                    elseif ($action == "EDIT") 
                                    {
                                    ?>

                                        
                                            
                                        
                                        <div class="row">
                                            <div class="form-group  col-sm-4" style="text-align: center;">
                                                <?php
                                                    if($herramientas_movimientos[0]->archivo != "")
                                                    {

                                                        echo "<img src='".$contentRead.$herramientas_movimientos[0]->archivo."' width='100px' height='90px'>";
                                                    }
                                                    else
                                                    {
                                                        echo "<img src='dist/img/no_disponible.png' width='100px' height='90px'>";
                                                    }
                                                ?>
                                                
                                            </div>
                                            <div class="form-group  col-sm-8">
                                                <label >CLAVE / CODIGO DE BARRAS</label>
                                                <input type="text" name="clave" id="clave" class="form-control" value="<?php echo $herramientas_movimientos[0]->clave; ?>" required="required" readonly="true">
                                            </div>
                                        </div>
                                        
                                    <div style="text-align: center;">    
                                        
                                        <div class="row">
                                            <div class="form-group col-sm-12" >
                                                <label style="font-size: large; text-align: right;">No de registro: <b style="color: orangered;"><?php echo $herramientas_movimientos[0]->id_registro; ?> </b></label>
                                                <input type="number" class="form-control hidden" name="id_registro" id="id_registro" value="<?php echo $herramientas_movimientos[0]->id_registro; ?>" autocomplete=""  readonly="true">
                                            </div>
                                        </div>
                                        <div class="row">

                                            <?php
                                                $direccion0 = "http://192.168.167.231/proapp/ws/?asociado=".$herramientas_movimientos[0]->ns_salida_lider;
                                                $json_asociado = file_get_contents($direccion0);
                                                $asociadoData = json_decode($json_asociado, true);

                                                $a_departamento = null;
                                                $a_puesto = null;
                                                $a_estatus = null;
                                                $a_lider = null;

                                                if(count($asociadoData) > 0)
                                                {
                                                    $a_departamento = "Departamento: ".$asociadoData[0]['departamento'];
                                                    $a_puesto = "Puesto: ".$asociadoData[0]['puesto'];
                                                    $a_estatus = "Estatus:".$asociadoData[0]['status'];
                                                    $a_lider = "Líder: ".$asociadoData[0]['lider'];
                                                }
                                            ?>
                                           
                                            <div class='form-group col-sm-12' style='text-align: right; background: #233e50;'>
                                                <div style="color: white; float: left; text-align: left;" class="col-sm-8">
                                                    <h6 style="color: #F3D93A;" id="departamento"><?php echo $a_departamento; ?></h6>
                                                    <h6 style="color: #F3D93A;" id="puesto"><?php echo $a_puesto; ?></h6>
                                                    <h6 style="color: #F3D93A;" id="estatus"><?php echo $a_estatus; ?></h6>
                                                    <h6 style="color: #F3D93A;" id="lider"><?php echo $a_lider; ?></h6>
                                                </div>

                                                <label id="fechaActual" class="hidden"><?php echo date("Y-m-d"); ?></label>

                                                <?php
                                                    if(isset($herramientas_movimientos[0]->ns_salida_lider) > 0)
                                                    {
                                                        
                                                        echo "<img  class='imagenPerfil img-circle' src='../col2/ch/perfils/".$herramientas_movimientos[0]->ns_salida_lider.".jpg' width='80px'; height='80px;' style='border:3px solid white; margin: 5px;'>";
                                                    }
                                                    else
                                                    {
                                                        echo "<img  class='imagenPerfil img-circle' src='dist/img/avatar.jpg' width='80px'; height='80px;' style='border:3px solid white; margin: 5px;'>";
                                                    }
                                                ?>
                                                
                                                
                                            </div>
                                        </div>
                                    
                                        <div class="row">
                                            <div class="form-group col-sm-4 hidden">   
                                                <label >Tamaño</label>
                                                <input type="number" class="form-control" name="tamano" id="tamano" value=""readonly="true">
                                            </div>

                                            <div class="form-group col-sm-4 ">   
                                                <label >Tamaño</label>
                                                <input type="text" class="form-control" name="descripcion" id="descripcion" value="" autocomplete="" readonly="true">
                                            </div>

                                            <div class="form-group col-sm-4">   
                                                <label >Límite semanal</label>
                                                <input type="number" class="form-control" name="tiempo_limite" id="tiempo_limite" value="" autocomplete="" readonly="true">
                                            </div> 
                                            <div class="form-group col-sm-4">
                                                <label >Tipo de movimiento</label>
                                                <select class="form-control" name="tipo_movimiento" id="tipo_movimiento" required="required" readonly="true">
                                                    
                                                    <?php
                                                        foreach ($herramientas_acciones as $a) 
                                                        {
                                                            if($a->id == $herramientas_movimientos[0]->tipo_movimiento)
                                                            {
                                                                echo "<option value='".$a->id."' style='display:none;'>".$a->accion."</option>";
                                                            }
                                                        }
                                                    ?>
                                                </select>
                                            </div> 
                                        </div>
                                        <!-- SEGUNDA LINEA -->
                                        
                                        
                                        <div class="row">
                                            <div class="form-group col-sm-4">
                                                <label >Invernadero</label>
                                                <select class="form-control" name="gh" id="gh" required="required">
                                                    <option value="<?php echo $herramientas_movimientos[0]->gh; ?>" style="display: none;"><?php echo $herramientas_movimientos[0]->gh; ?></option>
                                                    <?php
                                                        foreach ($herramientas_ghs as $g) 
                                                        {
                                                            echo "<option value='".$g->gh."' valorZona='".$g->zona."'>".$g->gh."</option>";
                                                        } 
                                                    ?>
                                              </select>
                                            </div>

                                            <div class="form-group col-sm-4">
                                                <label >Zona</label>
                                                <input type="text" class="form-control" name="zona" id="zona" value="<?php echo $herramientas_movimientos[0]->zona; ?>" autocomplete="" required="required" readonly="true">
                                            </div>

                                            
                                            <div class="form-group col-sm-4">
                                                <label >Fecha activación / baja</label>
                                                <input type='text' name='fecha_activacion_o_baja' id='fecha_activacion_o_baja' class='form-control' value="" readonly="true" autocomplete="off">
                                            </div>
                                        </div>

                                        <!-- TERCERA LINEA -->
                                        <div class="row">
                                            <div class="form-group col-sm-4">
                                                <label >Código asociado</label>
                                                <div class="input-group " style="margin-bottom: 0px;">
                                                    <input type="number" name="ns_salida_lider" id="ns_salida_lider" class="form-control" value="<?php echo $herramientas_movimientos[0]->ns_salida_lider; ?>" required="required">
                                                    <span class="input-group-btn">
                                                        <button type="button" class="btn btn-primary" id="buscar_asociado" title="Buscar zanco"> <span class='glyphicon glyphicon-search'></span> </button>
                                                    </span>
                                                </div>
                                            </div>

                                            <div class="form-group col-sm-4">
                                                <label >Nombre asociado</label>
                                                <input type="text" class="form-control" name="nombre_lider_salida" id="nombre_lider_salida" value="<?php echo $herramientas_movimientos[0]->nombre_lider_salida; ?>" autocomplete="" required readonly="true">
                                            </div>

                                            <?php
                                                $f_salida = null;
                                                $w_salida = null;

                                                $f_entrega = null;
                                                $w_entrega = null;

                                                $f_servicio = null;

                                                if($herramientas_movimientos[0]->fecha_salida > 0)
                                                {
                                                   $f_salida = $herramientas_movimientos[0]->fecha_salida;
                                                   $w_salida = $herramientas_movimientos[0]->wk_salida;
                                                }

                                                if($herramientas_movimientos[0]->fecha_entrega > 0)
                                                {
                                                   $f_entrega = $herramientas_movimientos[0]->fecha_entrega;
                                                   $w_entrega = $herramientas_movimientos[0]->wk_entrega;
                                                }

                                                if($herramientas_movimientos[0]->fecha_servicio > 0)
                                                {
                                                   $f_servicio = $herramientas_movimientos[0]->fecha_servicio;
                                                }
                                            ?>
                                            <div class="form-group">
                                                <div class='col-sm-4'>
                                                    <label >Fecha salida</label>
                                                    <div class='input-group date' id='datetimepicker2'>
                                                        <input type='text' name='fecha_salida' id='fecha_salida' class='form-control' value="<?php echo $f_salida; ?>" autocomplete="off" required>
                                                        <span class='input-group-addon'>
                                                            <span class='glyphicon glyphicon-calendar'></span>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="form-group col-sm-4">
                                                <label >Semana salida</label>
                                                <input type="number" class="form-control" name="wk_salida" id="wk_salida" value="<?php echo $w_salida; ?>" autocomplete="" required readonly="true">
                                            </div>

                                            <?php 
                                                if($herramientas_movimientos[0]->fecha_entrega > 0 && $herramientas_movimientos[0]->fecha_salida > 0)
                                                {

                                                    echo "<div class='form-group col-sm-4'>
                                                            <label >Semanas desfase</label>
                                                            <input type='number' class='form-control' name='wk_desfase' id='wk_desfase' value='' autocomplete='' required readonly='true'>
                                                        </div>";
                                                }
                                                else
                                                {
                                                    // aquí sacamos el desfase
                                                    $fechaHoy = date_create(date("Y-m-d"));
                                                    $f_salida = date_create($herramientas_movimientos[0]->fecha_salida);

                                                    $d_dias = date_diff($fechaHoy, $f_salida);
                                                    $d_dias = $d_dias->format('%a');
                                                    $semanas_limite = 0;/*$herramientas_movimientos[0]->limite_semana;*/
                                                    $semanas_convertidas = $d_dias / 7;
                                                    $semanas_convertidas = round($semanas_convertidas, 2);
                                                    
                                                    if($semanas_convertidas > $semanas_limite)
                                                    {
                                                        $diferencia_semanas = $semanas_convertidas - $semanas_limite;
                                                        

                                                        echo "<div class='form-group col-sm-4'>
                                                            <label >Semanas desfase</label>
                                                            <input type='number' class='form-control' name='wk_desfase' id='wk_desfase' value='".$diferencia_semanas."' autocomplete='' required readonly='true'>
                                                        </div>";   
                                                    }
                                                    else
                                                    {
                                                        echo "<div class='form-group col-sm-4'>
                                                            <label >Semanas desfase</label>
                                                            <input type='number' class='form-control' name='wk_desfase' id='wk_desfase' value='' autocomplete='' required readonly='true'>
                                                        </div>";
                                                    }

                                                    
                                                    
                                                    
                                                }
                                            ?>
                                            

                                            <div class="form-group">
                                                <div class='col-sm-4'>
                                                    <label >Fecha entrega</label>
                                                    <div class='input-group date' id='datetimepicker3'>
                                                        <input type='text' name='fecha_entrega' id='fecha_entrega' class='form-control' value="<?php echo $f_entrega; ?>" autocomplete="off">
                                                        <span class='input-group-addon'>
                                                            <span class='glyphicon glyphicon-calendar'></span>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- QUINTA LINEA -->
                                        <div class="row">
                                            <div class="form-group col-sm-4">
                                                <label >Semana entrega</label>
                                                <input type="number" class="form-control" name="wk_entrega" id="wk_entrega" value="<?php echo $w_entrega; ?>" autocomplete="" required readonly="true">
                                            </div>

                                            <div class="form-group">
                                                <div class='col-sm-4'>
                                                    <label >Fecha servicio</label>
                                                    <div class='input-group date' id='datetimepicker4'>
                                                        <input type='text' name='fecha_servicio' id='fecha_servicio' class='form-control' value="<?php echo $f_servicio; ?>" autocomplete="off">
                                                        <span class='input-group-addon'>
                                                            <span class='glyphicon glyphicon-calendar'></span>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            
                                            <div class="form-group col-sm-4">
                                                <label >Problema</label>
                                                <select class="form-control" name="descripcion_problema" id="descripcion_problema">
                                                    
                                                    <?php
                                                        if($herramientas_movimientos[0]->descripcion_problema <= 0)
                                                        {
                                                            echo "<option value='' style='display: none;' >Seleccione</option>";
                                                        }
                                                        foreach ($herramientas_problemas as $p) 
                                                        {
                                                            if($herramientas_movimientos[0]->descripcion_problema == $p->id )
                                                            {
                                                                echo "<option value='".$herramientas_movimientos[0]->descripcion_problema."' style='display: none;' selected='selected'>$p->descripcion</option>";
                                                            }
                                                            
                                                            echo "<option value='".$p->id."'>".$p->descripcion."</option>";
                                                        } 
                                                    ?>
                                              </select>
                                            </div>
                                        </div>
                                        


                                    <?php        
                                    }
                                    ?>
                                
                                </div>    

                                    <div class="form-group">
                                        <div class="col-sm-12" style="text-align: center;">
                                            <br>
                                            <a class="btn btn-default" href="indexHerramientas_movimientos.php">Cancelar</a>
                                            <?php  
                                                if ($action == "NEW") // PARA CUANDO ACTIVAMOS UN REGISTRO
                                                {
                                                    echo '<button type="submit" id="guardar" class="btn btn-success hidden" >Guardar</button>';
                                                }
                                                elseif ($action == "EDIT" || "NEW_CON_ART") 
                                                {
                                                    echo '<button type="submit" id="guardar" class="btn btn-success " >Guardar</button>';
                                                }

                                            ?>
                                            
                                        </div>
                                     </div>

                            
                                </form>

                            </div>
                        </div>
                    </div> <!-- fin class='' -->
                </div>
            <div class="clearfix"></div>
        </div>
    </div> 


  		<!-- Modal -->
		<div class="modal fade" id="modalAgregar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		  <div class="modal-dialog" role="document">
		    <div class="modal-content">
		      <div class="modal-header">
		        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		        <h4 class="modal-title" id="myModalLabel">Agregar / Modificar zanco</h4>
		      </div>
		      <div class="modal-body">
                <form name='frmtipo' class="form-horizontal" id="divdestino" method="post" action="<?php echo $url; ?>createZancos_bd.php">
		  
		      </div>
		      <div class="modal-footer">
		        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
		        <button type="submit" class="btn btn-primary">Guardar</button>
		      </div>
                </form>
		    </div>
		  </div>
		</div>



 <?php require_once(VIEW_PATH.'footer.inc.php'); ?>

        <script type="text/javascript">

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

            $("#buscar").on("click", function(e)
                {
                    e.preventDefault();
                    var clave = null;
                        clave = $("#clave").val();
                        $("#tamano").val(null);
                        $("#descripcion").val(null);
                        $("#tiempo_limite").val(null);

                    if(clave != "")
                    {
                       
                        $("#recibeData").html("<img style='text-align:center;' src='dist/img/load_2019.gif'>");
                        $(".imagenArt").html("<img style='text-align:center;' src='dist/img/load_2019.gif'>");
                        var ajax = creaAjax();
                        ajax.open("GET", "helper_herramientas.php?consulta=NUEVO&clave="+clave, true);
                        ajax.onreadystatechange=function() 
                        { 
                            if (ajax.readyState==1)
                            {
                              // Mientras carga ponemos un letrerito que dice "Verificando..."
                              DestinoMsg.innerHTML='Verificando...';
                            }
                            if (ajax.readyState==4)
                            {
                                // Cuando ya terminó, ponemos el resultado
                                var str = ajax.responseText;
                                
                                if(str == '*NO ENCONTRADO*')
                                {
                                    $("#recibeData").text("Al parecer este artículo no está registrado en la Base de Datos...");
                                    $(".imagenArt").html("<img src='dist/img/no_disponible.png' width='100px' height='90px'>");
                                    //return false;
                                }
                                else
                                {
                                    $.get("helper_herramientas.php", {consulta:"IMAGEN", clave:clave} ,function(data)
                                    { 
                                        $(".imagenArt").html(data);
                                    });

                                    $("#recibeData").html(str);
                                    $("#guardar").removeClass("hidden");
                                    //return false;
                                }         
                              
                            } 
                        }
                        ajax.send(null);
                    }
                    else
                    {
                        return false;
                    }
                });

            // para buscar zancos por enter
            $("#clave").keypress(function( event ) 
            {
                
              if (event.which == 13) 
              {
                return false;
              }
            });

            $(document).ready(function()
            {

                $("#gh").on('change', function(event) 
                {
                    var zona = null;
                        zona = $('option:selected', this).attr('valorZona');
                        $("#zona").val(zona);
                });

                $("#buscar_asociado").on("click", function()
                {   
                    var ns_salida_lider = null;
                        ns_salida_lider = $("#ns_salida_lider").val();
                        
                    
                    if (ns_salida_lider > 0) 
                    {
                        $(".imagenPerfil").attr("src", "dist/img/load_2019.gif");
                        var ajax=creaAjax();

                        ajax.open("GET", "helper_herramientas.php?consulta=ASOCIADO&codigo="+ns_salida_lider, true);
                        ajax.onreadystatechange=function() 
                        { 
                            if (ajax.readyState==1)
                            {
                              // Mientras carga ponemos un letrerito que dice "Verificando..."
                              DestinoMsg.innerHTML='Verificando...';
                            }
                            if (ajax.readyState==4)
                            {
                                // Cuando ya terminó, ponemos el resultado
                                var str = ajax.responseText;
                                var n = str.split("&");
                                    
                                var nombre = n[1];
                                var departamento = n[2];
                                var puesto = n[3];
                                var lider = n[4];
                                var estatus = n[5];
                               
                              
                                if(str == '*NO ENCONTRADO*')
                                {
                                    $("#nombre_lider_salida").val(null);
                                    $("#ns_salida_lider").val(null);
                                    $(".imagenPerfil").attr("src", "dist/img/avatar.jpg");
                                    $("#departamento").text("Departamento: ");
                                    $("#puesto").text("Puesto: ");
                                    $("#lider").text("Líder: ");
                                    $("#estatus").text("Estatus: ");
                                    alert("Asociado no encontrado...");
                                }
                                else
                                {
                                    $("#nombre_lider_salida").val(nombre);
                                    $(".imagenPerfil").attr("src", "../col2/ch/perfils/"+ns_salida_lider+".jpg");
                                    $("#departamento").text("Departamento: "+departamento);
                                    $("#puesto").text("Puesto: "+puesto);
                                    $("#lider").text("Líder: "+lider);
                                    $("#estatus").text("Estatus: "+estatus);
                                    
                                }         
                              
                            } 
                        }
                        ajax.send(null);
                        return false;
                    }
                    else
                    {
                        return false;
                    }
                    
                });


                $("#ns_salida_lider").keypress(function(event)
                {   
                    if (event.which == 13) 
                    {
                        return false;
                    }
                    
                });


                $("#datetimepicker2").on("change", function() 
                {
                    var consulta = "WK";
                    var fecha_salida = null;
                        fecha_salida = $("#fecha_salida").val();
                    
                    $.get("helper_herramientas.php", {consulta:consulta, fecha:fecha_salida} ,function(data)
                    { 
                        $("#wk_salida").val(data);
                    });

                    var tiempo_limite = $("#tiempo_limite").val();
                    var day = $("#fechaActual").text();
                    var diferencia =  Math.floor(( Date.parse(day) - Date.parse(fecha_salida) ) / (1000 * 60 * 60 * 24));
                          
                    var semanitas = (diferencia / 7);
                    var desfase = 0.0; 
                    if(tiempo_limite < semanitas)
                    {
                        desfase = (semanitas - tiempo_limite).toFixed(1);
                    }

                    $("#wk_desfase").val(desfase);
                });

                $("#datetimepicker3").on("change", function() 
                {
                    var consulta = "WK";
                    var fecha_salida = null;
                        fecha_salida = $("#fecha_entrega").val();
                    
                    $.get("helper_herramientas.php", {consulta:consulta, fecha:fecha_salida} ,function(data)
                    {
                        
                        $("#wk_entrega").val(data);
                    });
                });

                $(function () 
                {
                    $('#datetimepicker1').datetimepicker({
                        format: 'YYYY-MM-DD',
                        pickTime: false,
                        autoclose: true,

                    });

                    $('#datetimepicker2').datetimepicker({
                        format: 'YYYY-MM-DD',
                        pickTime: false,
                        autoclose: true,

                    });

                    $('#datetimepicker3').datetimepicker({
                        format: 'YYYY-MM-DD',
                        pickTime: false,
                        autoclose: true,

                    });

                    $('#datetimepicker4').datetimepicker({
                        format: 'YYYY-MM-DD',
                        pickTime: false,
                        autoclose: true,

                    });
                });


                $("#divdestino").submit(function() 
                {
                    $("#guardar").attr("disabled", "true");
                });

            }); // end ready
        </script>
</body>

</html>