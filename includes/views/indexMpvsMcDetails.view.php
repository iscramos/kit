 <?php require_once(VIEW_PATH.'header.inc.php'); 
       
 ?>         
        <div class="right_col" role="main"> 
            <div class="">
                <div class="page-title">
                    <div class="title_left">
                        <h3>Detalles de semana <?php echo $semana; ?> por líder</h3>
                    </div>
                 </div>

                <div class="clearfix"></div>           
        

        

                <div class="row">
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="x_panel">
                            <div class="x_title">
                                <h2><i class="fa fa-cogs"></i> Datos <small>en el sistema</small></h2>
                                <ul class="nav navbar-right panel_toolbox">
                                  <li>
                                    <a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                                  </li>
                                </ul>
                                <div class="clearfix"></div>
                            </div>
                            <div class="x_content table-responsive">           
                                <!-- aqui va el contenido -->

                                <?php
                                    $dias = ["DOMINGO", "LUNES", "MARTES", "MIERCOLES", "JUEVES", "VIERNES", "SABADO"];
                                    //print_r($lideres);
                                    foreach ($lideres as $lider) 
                                    {   
                                        $nombreLider = "";
                                        if($lider == 41185)
                                        {
                                            $nombreLider = "ORFANEL RENDON RAMIREZ";
                                        }
                                        if($lider == 239)
                                        {
                                            $nombreLider = "HUMBERTO CERVANTES";
                                        }
                                        if($lider == 14993)
                                        {
                                            $nombreLider = "MIGUEL TADEO";
                                        }
                                        if($lider == 15113)
                                        {
                                            $nombreLider = "ANTONIO VIRGEN";
                                        }

                                        echo "<div class='row'>";
                                            echo "<h4 class='text-center'> ".$nombreLider."</h4>";
                                            echo "<div id='mp_".$lider."' class='col-xs-12 col-md-6'></div>";
                                            echo "<div id='mc_".$lider."' class='col-xs-12 col-md-6'></div>";
                                        echo "</div>";
                                        echo "<hr>";
                                    }
                                ?>

                                
                                <div class='alert alert-success' role='alert' id='mensaje'>
                                  <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
                                  <strong>Nota!</strong> Para ver más detalles de las órdenes de trabajo, haga click sobre el número correspondiente.
                                </div>
                                <?php
                                    // ---- para sacar la semana en la que estamos
                                        $hoy = date("Y-m-d");
                                        $semanaA = Disponibilidad_calendarios::getByDia($hoy);
                                        $semanaActual = $semanaA[0]->semana;

                                        $consultaDiaPendiente = Disponibilidad_calendarios::getMinDia();
                                        $diaInicioPendiente = $consultaDiaPendiente[0]->dia;
                                        $diaFinPendiente = strtotime("-1 day", strtotime($fechaFinalizacion));
                                        $diaFinPendiente = date("Y-m-d", $diaFinPendiente);
                                        
                                        /*echo "Fecha de incio: ".$diaInicioPendiente;
                                        echo "<br>";
                                        echo "Fecha de finalizacion: ".$diaFinPendiente;*/
                                    // fin de la semana actual
                                    
                                    foreach ($lideres as $lider) 
                                    {
                                        //echo $lider;
                                        $responsable = $lider;

                                        $totalMP = 0;
                                        $otrosMP = 0;
                                        $totalMPTerminados = 0;
                                        $totalMPPendientes = 0;
                                        $totalMC = 0;
                                        $otrosMC = 0;
                                        $totalMCTerminados = 0;
                                        $totalMCPendientes = 0;
                                        $cumplimientoMP = 0;
                                        $cumplimientoMC = 0;
                                        $promedioSemanal = 0;
                                        $promedioSemanalAcumulado = 0;

                                        // este pequeño codigo es para traernos el acumulado
                                        $nPendientesAnoAnteriorMP = 0;
                                        $nPendientesAnoAnteriorMC = 0;
                                        $pendientesMP = 0;
                                        $pendientesMC = 0;

                                        
                                        $consulta = "SELECT count(ot) AS nPendientesMP 
                                                        FROM disponibilidad_data 
                                                        WHERE ( fecha_finalizacion_programada BETWEEN '$diaInicioPendiente' AND '$diaFinPendiente')
                                                        AND tipo = 'Mant. preventivo'
                                                        AND (estado = 'Programada' 
                                                            OR estado = 'Cierre Lider Mtto'
                                                            OR estado = 'Ejecutado'
                                                            OR estado = 'Espera de equipo'
                                                            OR estado = 'Espera de refacciones'
                                                            OR estado = 'Falta de mano de obra'
                                                            OR estado = 'Condiciones ambientales'
                                                            OR estado = 'Abierta')
                                                        AND responsable = $responsable";
                                        $pendientesMP = Disponibilidad_data::getAllByQuery($consulta);

                                        $consulta = "SELECT count(ot) AS nPendientesMC 
                                                            FROM disponibilidad_data 
                                                            WHERE ( fecha_finalizacion_programada BETWEEN '$diaInicioPendiente' AND '$diaFinPendiente') 
                                                            AND (tipo <> 'Mant. preventivo') 
                                                            AND (estado = 'Programada' 
                                                                OR estado = 'Cierre Lider Mtto' 
                                                                OR estado = 'Ejecutado' 
                                                                OR estado = 'Espera de equipo' 
                                                                OR estado = 'Espera de refacciones'
                                                                OR estado = 'Falta de mano de obra'
                                                                OR estado = 'Condiciones ambientales'
                                                                OR estado = 'Abierta'
                                                                OR estado = 'Solic. de trabajo')
                                                            AND responsable = $responsable";

                                        $pendientesMC = Disponibilidad_data::getAllByQuery($consulta);  
                                        
                                        
                                        
                                        
                                        /*$nuevaSemana = 0;
                                        if($semana == 1)
                                        {
                                            $traerSemana = Calendario_nature::getMaxSemana();
                                            $temporal_inicio = $traerSemana[0]->fecha_inicio;
                                            $temporal_fin = $traerSemana[0]->fecha_fin;

                                            $anoNuevo = $ano - 1;
                                            if($ano > 2016)
                                            {
                                                $fechaInicioAnoAnterior = $anoNuevo."-01-01";
                                                $fechaFinalizacionAnoAnterior = $anoNuevo."-".$temporal_fin;

                                                $consulta = "SELECT count(orden_trabajo) AS nPendientesMP 
                                                            FROM ordenesots 
                                                            WHERE ( fecha_finalizacion_programada BETWEEN '$fechaInicioAnoAnterior' AND '$fechaFinalizacionAnoAnterior')
                                                            AND tipo = 'Mant. preventivo'
                                                            AND (estado = 'Programada' 
                                                                OR estado = 'Cierre Lider Mtto'
                                                                OR estado = 'Ejecutado'
                                                                OR estado = 'Espera de equipo'
                                                                OR estado = 'Espera de refacciones'
                                                                OR estado = 'Falta de mano de obra'
                                                                OR estado = 'Abierta')
                                                            AND responsable = $responsable";

                                                $pendientesMP = Ordenesots::getAllConsulta($consulta);

                                                $consulta = "SELECT count(orden_trabajo) AS nPendientesMC 
                                                            FROM ordenesots 
                                                            WHERE ( fecha_finalizacion_programada BETWEEN '$fechaInicioAnoAnterior' AND '$fechaFinalizacionAnoAnterior') 
                                                            AND (tipo <> 'Mant. preventivo') 
                                                            AND (estado = 'Programada' 
                                                                OR estado = 'Cierre Lider Mtto' 
                                                                OR estado = 'Ejecutado' 
                                                                OR estado = 'Espera de equipo' 
                                                                OR estado = 'Espera de refacciones'
                                                                OR estado = 'Falta de mano de obra'
                                                                OR estado = 'Abierta'
                                                                OR estado = 'Solic. de trabajo')
                                                            AND responsable = $responsable";

                                                $pendientesMC = Ordenesots::getAllConsulta($consulta);
                                                // -----------------------------------------------------------------------
                                            }
                                            //print_r($pendientesAnoAnteriorMP);

                                            
                                        }
                                        elseif($semana > 1)
                                        {
                                            $semanaNueva = $semana - 1;
                                            $traerSemana = Calendario_nature::getAllSemana($semanaNueva);
                                            $temporal_inicio = $traerSemana[0]->fecha_inicio;
                                            $temporal_fin = $traerSemana[0]->fecha_fin;

                                            $anoNuevo = $ano - 1;
                                            if ($ano > 2016) 
                                            {
                                                $fechaInicioAnoAnterior = $anoNuevo."-01-01";
                                                $fechaFinalizacionAnoAnterior = $ano."-".$temporal_fin;

                                                $consulta = "SELECT count(orden_trabajo) AS nPendientesMP 
                                                            FROM ordenesots 
                                                            WHERE ( fecha_finalizacion_programada BETWEEN '$fechaInicioAnoAnterior' AND '$fechaFinalizacionAnoAnterior')
                                                            AND tipo='Mant. preventivo'
                                                            AND (estado = 'Programada' 
                                                                OR estado = 'Cierre Lider Mtto'
                                                                OR estado = 'Ejecutado'
                                                                OR estado = 'Espera de equipo'
                                                                OR estado = 'Espera de refacciones'
                                                                OR estado = 'Falta de mano de obra'
                                                                OR estado = 'Abierta')
                                                            AND responsable = $responsable";

                                                $pendientesMP = Ordenesots::getAllConsulta($consulta);

                                                $consulta = "SELECT count(orden_trabajo) AS nPendientesMC 
                                                            FROM ordenesots 
                                                            WHERE ( fecha_finalizacion_programada BETWEEN '$fechaInicioAnoAnterior' AND '$fechaFinalizacionAnoAnterior') 
                                                            AND (tipo <> 'Mant. preventivo') 
                                                            AND (estado = 'Programada' 
                                                                OR estado = 'Cierre Lider Mtto' 
                                                                OR estado = 'Ejecutado' 
                                                                OR estado = 'Espera de equipo' 
                                                                OR estado = 'Espera de refacciones'
                                                                OR estado = 'Falta de mano de obra'
                                                                OR estado = 'Abierta'
                                                                OR estado = 'Solic. de trabajo')
                                                            AND responsable = $responsable";

                                                $pendientesMC = Ordenesots::getAllConsulta($consulta);
                                            }
                                            else
                                            {
                                                $fechaInicioAnoAnterior = $ano."-01-01";
                                                $fechaFinalizacionAnoAnterior = $ano."-".$temporal_fin;

                                                $consulta = "SELECT count(orden_trabajo) AS nPendientesMP 
                                                            FROM ordenesots 
                                                            WHERE ( fecha_finalizacion_programada BETWEEN '$fechaInicioAnoAnterior' AND '$fechaFinalizacionAnoAnterior')
                                                            AND tipo='Mant. preventivo'
                                                            AND (estado = 'Programada' 
                                                                OR estado = 'Cierre Lider Mtto'
                                                                OR estado = 'Ejecutado'
                                                                OR estado = 'Espera de equipo'
                                                                OR estado = 'Espera de refacciones'
                                                                OR estado = 'Falta de mano de obra'
                                                                OR estado = 'Abierta')
                                                            AND responsable = $responsable";

                                                $pendientesMP = Ordenesots::getAllConsulta($consulta);

                                                $consulta = "SELECT count(orden_trabajo) AS nPendientesMC 
                                                            FROM ordenesots 
                                                            WHERE ( fecha_finalizacion_programada BETWEEN '$fechaInicioAnoAnterior' AND '$fechaFinalizacionAnoAnterior') 
                                                            AND (tipo <>'Mant. preventivo') 
                                                            AND (estado = 'Programada' 
                                                                OR estado = 'Cierre Lider Mtto' 
                                                                OR estado = 'Ejecutado' 
                                                                OR estado = 'Espera de equipo' 
                                                                OR estado = 'Espera de refacciones'
                                                                OR estadio = 'Falta de mano de obra'
                                                                OR estado = 'Abierta'
                                                                OR estado = 'Solic. de trabajo')
                                                            AND responsable = $responsable";

                                                $pendientesMC = Ordenesots::getAllConsulta($consulta);
                                                // -----------------------------------------------------------------------
                                            }
                                            

                                            
                                        }*/

                                        if($pendientesMP != 0 )
                                        {
                                            //echo "entro";
                                            $nPendientesAnoAnteriorMP = $pendientesMP[0]->nPendientesMP;
                                        }
                                        if($pendientesMC != 0 )
                                        {
                                            $nPendientesAnoAnteriorMC = $pendientesMC[0]->nPendientesMC;
                                        }

                                        
                                        echo "<div class='row text-center'>
                                                    Mantenimientos preventivos <span class='badge badge-success'>".$nPendientesAnoAnteriorMP."</span>
                                                    Mantenimientos correctivos <span class='badge badge-warning'>".$nPendientesAnoAnteriorMC." </span>
                                                    históricos pendentes
                                                </div>"; 
                                        
                                        // termina acumulado
                                        $mp_pro_domingo = 0;
                                        $mp_pro_lunes = 0;
                                        $mp_pro_martes = 0;
                                        $mp_pro_miercoles = 0;
                                        $mp_pro_jueves = 0;
                                        $mp_pro_viernes = 0;
                                        $mp_pro_sabado = 0;

                                        $mp_rea_domingo = 0;
                                        $mp_rea_lunes = 0;
                                        $mp_rea_martes = 0;
                                        $mp_rea_miercoles = 0;
                                        $mp_rea_jueves = 0;
                                        $mp_rea_viernes = 0;
                                        $mp_rea_sabado = 0;

                                        $mc_pro_domingo = 0;
                                        $mc_pro_lunes = 0;
                                        $mc_pro_martes = 0;
                                        $mc_pro_miercoles = 0;
                                        $mc_pro_jueves = 0;
                                        $mc_pro_viernes = 0;
                                        $mc_pro_sabado = 0;

                                        $mc_rea_domingo = 0;
                                        $mc_rea_lunes = 0;
                                        $mc_rea_martes = 0;
                                        $mc_rea_miercoles = 0;
                                        $mc_rea_jueves = 0;
                                        $mc_rea_viernes = 0;
                                        $mc_rea_sabado = 0;

                                        $mc_pen_domingo = 0;
                                        $mc_pen_lunes = 0;
                                        $mc_pen_martes = 0;
                                        $mc_pen_miercoles = 0;
                                        $mc_pen_jueves = 0;
                                        $mc_pen_viernes = 0;
                                        $mc_pen_sabado = 0;
                                        foreach ($ordenes as $orden) 
                                        {
                                            $dia_fin = $orden->fecha_finalizacion_programada;
                                            $nombreDiaFin = $dias[date('w', strtotime($dia_fin))];
                                            
                                            if ($orden->tipo == "Mant. preventivo" && $orden->responsable == $responsable
                                                && ($orden->estado == 'Cierre Lider Mtto'
                                                    || $orden->estado == 'Ejecutado'
                                                    || $orden->estado == 'Espera de equipo'
                                                    || $orden->estado == 'Espera de refacciones'
                                                    || $orden->estado == 'Falta de mano de obra'
                                                    || $orden->estado == 'Condiciones ambientales'
                                                    || $orden->estado == 'Abierta'
                                                    || $orden->estado == 'Programada' 
                                                    || $orden->estado == 'Terminado' ) 
                                                ) 
                                            {
                                                $totalMP ++;

                                                if($nombreDiaFin == "DOMINGO") $mp_pro_domingo ++;
                                                if($nombreDiaFin == "LUNES") $mp_pro_lunes ++;
                                                if($nombreDiaFin == "MARTES") $mp_pro_martes ++;
                                                if($nombreDiaFin == "MIERCOLES") $mp_pro_miercoles ++;
                                                if($nombreDiaFin == "JUEVES") $mp_pro_jueves ++;
                                                if($nombreDiaFin == "VIERNES") $mp_pro_viernes ++;
                                                if($nombreDiaFin == "SABADO") $mp_pro_sabado ++;
                                                //echo "entro_".$lider."_dia_".$nombreDiaFin."<br>";
                                            }

                                            if ($orden->tipo == "Mant. preventivo" && $orden->responsable == $responsable
                                                && ($orden->estado == 'Cancelado'
                                                    || $orden->estado == 'Rechazado'
                                                    || $orden->estado == 'Cerrado sin ejecutar' ) 
                                                ) 
                                            {
                                                $otrosMP ++;
                                            }

                                            if ($orden->tipo == "Mant. preventivo"  && $orden->responsable == $responsable
                                                && ($orden->estado == 'Terminado')                                                
                                                ) 
                                            {
                                                $totalMPTerminados ++;

                                                if($nombreDiaFin == "DOMINGO" && date("Y-m-d", strtotime($orden->fecha_finalizacion_programada)) >= date("Y-m-d", strtotime($orden->fecha_finalizacion)) ) $mp_rea_domingo ++;
                                                if($nombreDiaFin == "LUNES"  && date("Y-m-d", strtotime($orden->fecha_finalizacion_programada)) >= date("Y-m-d", strtotime($orden->fecha_finalizacion)) ) $mp_rea_lunes ++;
                                                if($nombreDiaFin == "MARTES"  && date("Y-m-d", strtotime($orden->fecha_finalizacion_programada)) >= date("Y-m-d", strtotime($orden->fecha_finalizacion)) ) $mp_rea_martes ++;
                                                if($nombreDiaFin == "MIERCOLES"  && date("Y-m-d", strtotime($orden->fecha_finalizacion_programada)) >= date("Y-m-d", strtotime($orden->fecha_finalizacion)) ) $mp_rea_miercoles ++;
                                                if($nombreDiaFin == "JUEVES"  && date("Y-m-d", strtotime($orden->fecha_finalizacion_programada)) >= date("Y-m-d", strtotime($orden->fecha_finalizacion)) ) $mp_rea_jueves ++;
                                                if($nombreDiaFin == "VIERNES"  && date("Y-m-d", strtotime($orden->fecha_finalizacion_programada)) >= date("Y-m-d", strtotime($orden->fecha_finalizacion)) ) $mp_rea_viernes ++;
                                                if($nombreDiaFin == "SABADO"  && date("Y-m-d", strtotime($orden->fecha_finalizacion_programada)) >= date("Y-m-d", strtotime($orden->fecha_finalizacion)) ) $mp_rea_sabado ++;
                                            }

                                            if ($orden->tipo == "Mant. preventivo"  && $orden->responsable == $responsable
                                                && ($orden->estado == 'Programada' 
                                                    || $orden->estado == 'Cierre Lider Mtto'
                                                    || $orden->estado == 'Ejecutado'
                                                    || $orden->estado == 'Espera de equipo'
                                                    || $orden->estado == 'Espera de refacciones'
                                                    || $orden->estado == 'Falta de mano de obra'
                                                    || $orden->estado == 'Condiciones ambientales'
                                                    || $orden->estado == 'Abierta')
                                                ) 
                                            {
                                                $totalMPPendientes ++;
                                            }

                                            

                                            if ($orden->responsable == $responsable
                                                && ($orden->tipo != 'Mant. preventivo')
                                                && ($orden->estado == 'Cierre Lider Mtto'
                                                    || $orden->estado == 'Ejecutado'
                                                    || $orden->estado == 'Espera de equipo'
                                                    || $orden->estado == 'Espera de refacciones'
                                                    || $orden->estado == 'Falta de mano de obra'
                                                    || $orden->estado == 'Condiciones ambientales'
                                                    || $orden->estado == 'Abierta'
                                                    || $orden->estado == 'Solic. de trabajo'
                                                    || $orden->estado == 'Programada' 
                                                    || $orden->estado == 'Terminado' )
                                                ) 
                                            {
                                                $totalMC ++;

                                                if($nombreDiaFin == "DOMINGO") $mc_pro_domingo ++;
                                                if($nombreDiaFin == "LUNES") $mc_pro_lunes ++;
                                                if($nombreDiaFin == "MARTES") $mc_pro_martes ++;
                                                if($nombreDiaFin == "MIERCOLES") $mc_pro_miercoles ++;
                                                if($nombreDiaFin == "JUEVES") $mc_pro_jueves ++;
                                                if($nombreDiaFin == "VIERNES") $mc_pro_viernes ++;
                                                if($nombreDiaFin == "SABADO") $mc_pro_sabado ++;

                                            }

                                            if ($orden->responsable == $responsable
                                                && ($orden->tipo != 'Mant. preventivo')
                                                && ($orden->estado == 'Cancelado'
                                                    || $orden->estado == 'Rechazado'
                                                    || $orden->estado == 'Cerrado sin ejecutar' ) 
                                                ) 
                                            {

                                                $otrosMC ++;
                                            }

                                            /*if (($orden->tipo == "Correctivo de emergencia" || $orden->tipo == "Correctivo planeado") && $orden->estado == "Terminado" && $orden->responsable == $ns) 
                                            {
                                                $totalMCTerminados ++;
                                            }*/

                                            if (($orden->tipo != 'Mant. preventivo')  && $orden->responsable == $responsable
                                                    && ($orden->estado == 'Terminado')
                                                ) 
                                            {
                                                $totalMCTerminados ++;

                                                if($nombreDiaFin == "DOMINGO" && date("Y-m-d", strtotime($orden->fecha_finalizacion_programada)) >= date("Y-m-d", strtotime($orden->fecha_finalizacion)) ) $mc_rea_domingo ++;
                                                if($nombreDiaFin == "LUNES"  && date("Y-m-d", strtotime($orden->fecha_finalizacion_programada)) >= date("Y-m-d", strtotime($orden->fecha_finalizacion)) ) $mc_rea_lunes ++;
                                                if($nombreDiaFin == "MARTES"  && date("Y-m-d", strtotime($orden->fecha_finalizacion_programada)) >= date("Y-m-d", strtotime($orden->fecha_finalizacion)) ) $mc_rea_martes ++;
                                                if($nombreDiaFin == "MIERCOLES"  && date("Y-m-d", strtotime($orden->fecha_finalizacion_programada)) >= date("Y-m-d", strtotime($orden->fecha_finalizacion)) ) $mc_rea_miercoles ++;
                                                if($nombreDiaFin == "JUEVES"  && date("Y-m-d", strtotime($orden->fecha_finalizacion_programada)) >= date("Y-m-d", strtotime($orden->fecha_finalizacion)) ) $mc_rea_jueves ++;
                                                if($nombreDiaFin == "VIERNES"  && date("Y-m-d", strtotime($orden->fecha_finalizacion_programada)) >= date("Y-m-d", strtotime($orden->fecha_finalizacion)) ) $mc_rea_viernes ++;
                                                if($nombreDiaFin == "SABADO"  && date("Y-m-d", strtotime($orden->fecha_finalizacion_programada)) >= date("Y-m-d", strtotime($orden->fecha_finalizacion)) ) $mc_rea_sabado ++;
                                            }

                                            /*if (($orden->tipo == "Correctivo de emergencia" || $orden->tipo == "Correctivo planeado") && $orden->estado != "Terminado" && $orden->responsable == $ns) 
                                            {
                                                $totalMCPendientes ++;
                                            }*/

                                            if (($orden->tipo != 'Mant. preventivo') && ($orden->responsable == $responsable)
                                                    && ($orden->estado == 'Programada' 
                                                        || $orden->estado == 'Cierre Lider Mtto'
                                                        || $orden->estado == 'Ejecutado'
                                                        || $orden->estado == 'Espera de equipo'
                                                        || $orden->estado == 'Espera de refacciones'
                                                        || $orden->estado == 'Falta de mano de obra'
                                                        || $orden->estado == 'Condiciones ambientales'
                                                        || $orden->estado == 'Abierta'
                                                        || $orden->estado == 'Solic. de trabajo')
                                                ) 
                                            {
                                                $totalMCPendientes ++;

                                                if($nombreDiaFin == "DOMINGO") $mc_pen_domingo ++;
                                                if($nombreDiaFin == "LUNES") $mc_pen_lunes ++;
                                                if($nombreDiaFin == "MARTES") $mc_pen_martes ++;
                                                if($nombreDiaFin == "MIERCOLES") $mc_pen_miercoles ++;
                                                if($nombreDiaFin == "JUEVES") $mc_pen_jueves ++;
                                                if($nombreDiaFin == "VIERNES") $mc_pen_viernes ++;
                                                if($nombreDiaFin == "SABADO") $mc_pen_sabado ++;
                                            }

                                            

                                            
                                        }// fin del foreach ordenes
                                        

                                        /*$cumplimientoMP = ($totalMPTerminados / ($totalMP + $nPendientesAnoAnteriorMP) * 100);*/
                                        if($totalMP > 0)
                                        {
                                            $cumplimientoMP = ($totalMPTerminados / $totalMP) * 100;
                                            $cumplimientoMP = round($cumplimientoMP, 1);
                                        }
                                        
                                        if( ($totalMC + $nPendientesAnoAnteriorMC) > 0)
                                        {
                                            $cumplimientoMC = ($totalMCTerminados / ($totalMC + $nPendientesAnoAnteriorMC) * 100);
                                        
                                            $cumplimientoMC = round($cumplimientoMC, 1);
                                        }
                                        

                                        if($totalMC > 0)
                                        {
                                            $promedioSemanal = ($cumplimientoMP + ( ($totalMCTerminados / $totalMC ) * 100) )/2 ;
                                            $promedioSemanal = round($promedioSemanal, 1);
                                        }
                                        
                                        // para cuando no existen mp o mc, para un lider en la semana
                                            if($semana <= $semanaActual && $totalMP == 0){ $cumplimientoMP = 100; }
                                            if($semana <= $semanaActual && $totalMC == 0 && $nPendientesAnoAnteriorMC == 0){ $cumplimientoMC = 100; $promedioSemanal = 100;}
                                        // ----------------------------------------------------------

                                        $promedioSemanalAcumulado = ($cumplimientoMP + $cumplimientoMC) /2 ;
                                        $promedioSemanalAcumulado = round($promedioSemanalAcumulado, 1);


                                        $nombreLider = "";
                                        if($responsable == 41185)
                                        {
                                            $nombreLider = "ORFANEL RENDON RAMIREZ";
                                        }
                                        if($responsable == 239)
                                        {
                                            $nombreLider = "HUMBERTO CERVANTES";
                                        }
                                        if($responsable == 14993)
                                        {
                                            $nombreLider = "MIGUEL TADEO";
                                        }
                                        if($responsable == 15113)
                                        {
                                            $nombreLider = "ANTONIO VIRGEN";
                                        }

                                        // PARA EL ACUMULADO
                                            $mc_pro_domingo = $mc_pro_domingo + $nPendientesAnoAnteriorMC;
                                            $mc_pro_lunes = $mc_pro_lunes + $mc_pen_domingo;
                                            $mc_pro_martes = $mc_pro_martes + $mc_pen_lunes;
                                            $mc_pro_miercoles = $mc_pro_miercoles + $mc_pen_martes;
                                            $mc_pro_jueves = $mc_pro_jueves + $mc_pen_miercoles;
                                            $mc_pro_viernes = $mc_pro_viernes + $mc_pen_jueves;
                                            $mc_pro_sabado = $mc_pro_sabado + $mc_pen_viernes;
                                        //
                                        /*echo "DOMINGO:".$pro_domingo.", LUNES:".$pro_lunes.", MARTES:".$pro_martes.", MIERCOLES:".$pro_miercoles.", JUEVES:".$pro_jueves.", VIERNES:".$pro_viernes.", SABADO:".$pro_sabado;*/


                                        echo "<input id='mp_pro_domingo_".$lider."' value='".$mp_pro_domingo."' class='hidden  form-control'>";
                                        echo "<input id='mp_pro_lunes_".$lider."' value='".$mp_pro_lunes."' class='hidden  form-control'>";
                                        echo "<input id='mp_pro_martes_".$lider."' value='".$mp_pro_martes."' class='hidden  form-control'>";
                                        echo "<input id='mp_pro_miercoles_".$lider."' value='".$mp_pro_miercoles."' class='hidden  form-control'>";
                                        echo "<input id='mp_pro_jueves_".$lider."' value='".$mp_pro_jueves."' class='hidden  form-control'>";
                                        echo "<input id='mp_pro_viernes_".$lider."' value='".$mp_pro_viernes."' class='hidden  form-control'>";
                                        echo "<input id='mp_pro_sabado_".$lider."' value='".$mp_pro_sabado."' class='hidden form-control'>";

                                        echo "<input id='mp_rea_domingo_".$lider."' value='".$mp_rea_domingo."' class='hidden form-control'>";
                                        echo "<input id='mp_rea_lunes_".$lider."' value='".$mp_rea_lunes."' class='hidden form-control'>";
                                        echo "<input id='mp_rea_martes_".$lider."' value='".$mp_rea_martes."' class='hidden form-control'>";
                                        echo "<input id='mp_rea_miercoles_".$lider."' value='".$mp_rea_miercoles."' class='hidden form-control'>";
                                        echo "<input id='mp_rea_jueves_".$lider."' value='".$mp_rea_jueves."' class='hidden form-control'>";
                                        echo "<input id='mp_rea_viernes_".$lider."' value='".$mp_rea_viernes."' class='hidden form-control'>";
                                        echo "<input id='mp_rea_sabado_".$lider."' value='".$mp_rea_sabado."' class='hidden form-control'>";

                                        echo "<input id='mc_pro_domingo_".$lider."' value='".$mc_pro_domingo."' class='hidden form-control'>";
                                        echo "<input id='mc_pro_lunes_".$lider."' value='".$mc_pro_lunes."' class='hidden form-control'>";
                                        echo "<input id='mc_pro_martes_".$lider."' value='".$mc_pro_martes."' class='hidden form-control'>";
                                        echo "<input id='mc_pro_miercoles_".$lider."' value='".$mc_pro_miercoles."' class='hidden form-control'>";
                                        echo "<input id='mc_pro_jueves_".$lider."' value='".$mc_pro_jueves."' class='hidden form-control'>";
                                        echo "<input id='mc_pro_viernes_".$lider."' value='".$mc_pro_viernes."' class='hidden form-control'>";
                                        echo "<input id='mc_pro_sabado_".$lider."' value='".$mc_pro_sabado."' class='hidden form-control'>";

                                        echo "<input id='mc_rea_domingo_".$lider."' value='".$mc_rea_domingo."' class='hidden form-control'>";
                                        echo "<input id='mc_rea_lunes_".$lider."' value='".$mc_rea_lunes."' class='hidden form-control'>";
                                        echo "<input id='mc_rea_martes_".$lider."' value='".$mc_rea_martes."' class='hidden form-control'>";
                                        echo "<input id='mc_rea_miercoles_".$lider."' value='".$mc_rea_miercoles."' class='hidden form-control'>";
                                        echo "<input id='mc_rea_jueves_".$lider."' value='".$mc_rea_jueves."' class='hidden form-control'>";
                                        echo "<input id='mc_rea_viernes_".$lider."' value='".$mc_rea_viernes."' class='hidden form-control'>";
                                        echo "<input id='mc_rea_sabado_".$lider."' value='".$mc_rea_sabado."' class='hidden form-control'>";

                                        echo "<h4 class='text-center'>".$nombreLider."</h4>
                                        <table class='table table-hover table-condensed' style='font-size: 12px;'>
                                            <thead >
                                                <tr>
                                                    <th style='background:#5cb85c; color:white;'>TOTAL MP</th>
                                                    <th style='background:#5cb85c; color:white;'>OTROS MP</th>
                                                    <th style='background:#5cb85c; color:white;'>TERMINADOS MP</th>
                                                    <th style='background:#5cb85c; color:white;'>PENDIENTES MP</th>
                                                    <!--th style='background:#5cb85c; color:white;'>+ MP</th-->
                                                    <th style='background:#5cb85c; color:white;'>% CMTO.</th>
                                                    
                                                    

                                                    <th style='background:#f0ad4e; color:white; '>TOTAL MC</th>
                                                    <th style='background:#f0ad4e; color:white;'>OTROS MC</th>
                                                    <th style='background:#f0ad4e; color:white; '>TERMINADOS MC</th>
                                                    <th style='background:#f0ad4e; color:white; '>PENDIENTES MC</th>
                                                    <th style='background:#f0ad4e; color:white; '>+ MC</th>
                                                    <th style='background:#f0ad4e; color:white; '>% CMTO.</th>                                 
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td class='bg-success'>
                                                        <a title='Ver detalles de órdenes' href='#' class='detallesOrdenes' tipo='totalMP' lider='".$responsable."'>".$totalMP."</a>
                                                    </td>
                                                    <td class='bg-success'>
                                                        <a title='Ver detalles de órdenes' href='#' class='detallesOrdenes' tipo='otrosMP' lider='".$responsable."'>".$otrosMP."</a>
                                                    </td>
                                                    <td class='bg-success'>
                                                        <a title='Ver detalles de órdenes' href='#' class='detallesOrdenes' tipo='terminadoMP' lider='".$responsable."'>".$totalMPTerminados."</a>
                                                    </td>
                                                    <td class='bg-success'>
                                                        <a title='Ver detalles de órdenes' href='#' class='detallesOrdenes' tipo='pendienteMP' lider='".$responsable."'>".$totalMPPendientes."</a>
                                                    </td>
                                                    <!--td class='bg-success'>
                                                        <?php echo $nPendientesAnoAnteriorMP; ?>
                                                    </td-->
                                                    <th class='bg-success'>
                                                        ".$cumplimientoMP." %
                                                    </th>

                                                    <td class='bg-warning'>
                                                        <a title='Ver detalles de órdenes' href='#' class='detallesOrdenes' tipo='totalMC' lider='".$responsable."'>".$totalMC."</a>
                                                    </td>
                                                    <td class='bg-warning'>
                                                        <a title='Ver detalles de órdenes' href='#' class='detallesOrdenes' tipo='otrosMC' lider='".$responsable."'>".$otrosMC."</a>
                                                    </td>
                                                    <td class='bg-warning'>
                                                        <a title='Ver detalles de órdenes' href='#' class='detallesOrdenes' tipo='terminadoMC' lider='".$responsable."'>".$totalMCTerminados."</a>
                                                    </td>
                                                    <td class='bg-warning'>
                                                        <a title='Ver detalles de órdenes' href='#' class='detallesOrdenes' tipo='pendienteMC' lider='".$responsable."'>".$totalMCPendientes."</a>
                                                    </td>
                                                    <td class='bg-warning'>
                                                        ".$nPendientesAnoAnteriorMC."
                                                    </td>
                                                    <th class='bg-warning'>
                                                        ".$cumplimientoMC." %
                                                    </th>

                                                </tr>
                                                <tr >
                                                    <td colspan='10' class='text-right'>PROMEDIO SEMANAL MP Y MC (SIN ACUMULACION)</td>
                                                    <th>
                                                        ".$promedioSemanal." %
                                                    </th>
                                                </tr>
                                                <tr >
                                                    <td colspan='10' class='text-right'>PROMEDIO SEMANAL MP Y MC (CON ACUMULACION)</td>
                                                    <th style='background:#FFFF00;'>
                                                        ".$promedioSemanalAcumulado." %
                                                    </th>
                                                </tr>
                                            </tbody>
                                        </table>";
                                    } // fin del foreach lideres
                                    
                                    
                                ?>
                                        <input type="text" id="fechaInicio" class='form-control hidden' value='<?php echo $fechaInicio; ?>'>
                                        <input type="text" id="fechaFinalizacion" class='form-control hidden' value='<?php echo $fechaFinalizacion; ?>'>
                                              

                            </div>
                        </div>
                    </div> <!-- fin class='' -->
                </div>
                <div class="clearfix"></div>
            </div>

            


            <!-- Modal -->
            <div class="modal fade bs-example-modal-lg" id="modalDetalles" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
              <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Detalles de órdenes</h4>
                  </div>
                  <div class="modal-body" >
                    
                    <div class='table-responsive' id='recibeDetalles'>
                        
                    </div>

                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                  </div>
                    
                </div>
              </div>
            </div>



 <?php require_once(VIEW_PATH.'footer.inc.php'); ?> 
  
    <script type="text/javascript">
        $(document).ready(function()
        {
            $(".left_col").addClass("hidden", "hidden");
            $(".top_nav").css("margin-left", 0);
            $(".right_col").css("margin-left", 0);
            $(".toggle").addClass("hidden", "hidden");
           

            $(".detallesOrdenes").on("click", function(event) 
            {
                event.preventDefault();

                var fechaInicio = null;
                var fechaFinalizacion = null;
                var lider = null;
                var tipo = null;

                var fechaInicio = $("#fechaInicio").val();
                var fechaFinalizacion = $("#fechaFinalizacion").val();
                var lider = $(this).attr("lider");
                var tipo = $(this).attr("tipo");

                //console.log(fechaInicio + fechaFinalizacion + lider +tipo);

                //Añadimos la imagen de carga en el contenedor
                $("#modalDetalles").modal("show");
                $('#recibeDetalles').html('<div style="text-align:center;"><img src="dist/img/loading.gif"/></div>');
              
                $.get("helperMpvsMcDetails.php", {fechaInicio:fechaInicio, fechaFinalizacion:fechaFinalizacion, lider:lider, tipo:tipo} ,function(data)
                {
                    $("#recibeDetalles").html(data);
                });
                
            });// fin de disponibilidad

            // ----------------------------------------------------------------

            

        }); // end ready

        /*var semanas = ["ENERO", "FEBRERO", "MARZO", "ABRIL", "MAYO", "JUNIO", "JULIO", "AGOSTO", "SEPTIEMBRE", "OCTUBRE", "NOVIEMBRE", "DICIEMBRE"];*/

        var lideres = [41185, 239, 14993, 15113];
        // PARA LAS GRAFICAS LINEALES
        google.charts.load('current', {'packages':['corechart' ]});
        google.charts.setOnLoadCallback(drawChart);

        function drawChart() 
        {
            $.each(lideres, function(key, value)
            {
                var lider = value;
                
                var mp_pro_domingo = 0;
                var mp_pro_lunes = 0;
                var mp_pro_martes = 0;
                var mp_pro_miercoles = 0;
                var mp_pro_jueves = 0;
                var mp_pro_viernes = 0;
                var mp_pro_sabado = 0;

                var mp_rea_domingo = 0;
                var mp_rea_lunes = 0;
                var mp_rea_martes = 0;
                var mp_rea_miercoles = 0;
                var mp_rea_jueves = 0;
                var mp_rea_viernes = 0;
                var mp_rea_sabado = 0;

                var mc_pro_domingo = 0;
                var mc_pro_lunes = 0;
                var mc_pro_martes = 0;
                var mc_pro_miercoles = 0;
                var mc_pro_jueves = 0;
                var mc_pro_viernes = 0;
                var mc_pro_sabado = 0;

                var mc_rea_domingo = 0;
                var mc_rea_lunes = 0;
                var mc_rea_martes = 0;
                var mc_rea_miercoles = 0;
                var mc_rea_jueves = 0;
                var mc_rea_viernes = 0;
                var mc_rea_sabado = 0;

                var mp_pro_total = 0;

                    mp_pro_domingo = parseInt($("#mp_pro_domingo_"+lider).val());
                    mp_pro_lunes = parseInt($("#mp_pro_lunes_"+lider).val());
                    mp_pro_martes = parseInt($("#mp_pro_martes_"+lider).val());
                    mp_pro_miercoles = parseInt($("#mp_pro_miercoles_"+lider).val());
                    mp_pro_jueves = parseInt($("#mp_pro_jueves_"+lider).val());
                    mp_pro_viernes = parseInt($("#mp_pro_viernes_"+lider).val());
                    mp_pro_sabado = parseInt($("#mp_pro_sabado_"+lider).val());


                    /*mp_pro_total = mp_pro_domingo + mp_pro_lunes + mp_pro_martes + mp_pro_miercoles + mp_pro_jueves + mp_pro_viernes + mp_pro_sabado;*/

                    mp_rea_domingo = parseInt($("#mp_rea_domingo_"+lider).val());
                    mp_rea_lunes = parseInt($("#mp_rea_lunes_"+lider).val());
                    mp_rea_martes = parseInt($("#mp_rea_martes_"+lider).val());
                    mp_rea_miercoles = parseInt($("#mp_rea_miercoles_"+lider).val());
                    mp_rea_jueves = parseInt($("#mp_rea_jueves_"+lider).val());
                    mp_rea_viernes = parseInt($("#mp_rea_viernes_"+lider).val());
                    mp_rea_sabado = parseInt($("#mp_rea_sabado_"+lider).val());

                    mc_pro_domingo = parseInt($("#mc_pro_domingo_"+lider).val());
                    mc_pro_lunes = parseInt($("#mc_pro_lunes_"+lider).val());
                    mc_pro_martes = parseInt($("#mc_pro_martes_"+lider).val());
                    mc_pro_miercoles = parseInt($("#mc_pro_miercoles_"+lider).val());
                    mc_pro_jueves = parseInt($("#mc_pro_jueves_"+lider).val());
                    mc_pro_viernes = parseInt($("#mc_pro_viernes_"+lider).val());
                    mc_pro_sabado = parseInt($("#mc_pro_sabado_"+lider).val());

                    mc_rea_domingo = parseInt($("#mc_rea_domingo_"+lider).val());
                    mc_rea_lunes = parseInt($("#mc_rea_lunes_"+lider).val());
                    mc_rea_martes = parseInt($("#mc_rea_martes_"+lider).val());
                    mc_rea_miercoles = parseInt($("#mc_rea_miercoles_"+lider).val());
                    mc_rea_jueves = parseInt($("#mc_rea_jueves_"+lider).val());
                    mc_rea_viernes = parseInt($("#mc_rea_viernes_"+lider).val());
                    mc_rea_sabado = parseInt($("#mc_rea_sabado_"+lider).val());

                    //alert(pro_domingo);

                var dataMp = google.visualization.arrayToDataTable([
                  ['DAY', 'PROGRAMADO', {type:'number', role:'annotation'}, 'REALIZADO', {type:'number', role:'annotation'}],
                  ['Dom',  mp_pro_domingo, mp_pro_domingo, mp_rea_domingo, mp_rea_domingo],
                  ['Lun',  mp_pro_lunes, mp_pro_lunes, mp_rea_lunes, mp_rea_lunes],
                  ['Mar',  mp_pro_martes, mp_pro_martes, mp_rea_martes, mp_rea_martes],
                  ['Mie',  mp_pro_miercoles, mp_pro_miercoles, mp_rea_miercoles, mp_rea_miercoles],
                  ['Jue',  mp_pro_jueves, mp_pro_jueves, mp_rea_jueves, mp_rea_jueves],
                  ['Vie',  mp_pro_viernes, mp_pro_viernes, mp_rea_viernes, mp_rea_viernes],
                  ['Sab',  mp_pro_sabado, mp_pro_sabado, mp_rea_sabado, mp_rea_sabado]
                ]);

                var optionsMp = {
                  title: 'MP PREVENTIVOS',
                  //hAxis: {/*title: 'DIA', */ titleTextStyle: {color: '#44c2a6'}},
                  vAxis: {minValue: 0},
                  height: 300,
                  colors: ['#66CCB6', '#5CB85C'],
                  legend: { position: 'bottom' }
                };

                var chartMp = new google.visualization.AreaChart(document.getElementById('mp_'+lider));
                chartMp.draw(dataMp, optionsMp);


                

                    

                var dataMc = google.visualization.arrayToDataTable([
                  ['DAY', 'PROGRAMADO', {type:'number', role:'annotation'}, 'REALIZADO', {type:'number', role:'annotation'}],
                  ['Dom',  mc_pro_domingo, mc_pro_domingo, mc_rea_domingo, mc_rea_domingo],
                  ['Lun',  mc_pro_lunes, mc_pro_lunes, mc_rea_lunes, mc_rea_lunes],
                  ['Mar',  mc_pro_martes, mc_pro_martes, mc_rea_martes, mc_rea_martes],
                  ['Mie',  mc_pro_miercoles, mc_pro_miercoles, mc_rea_miercoles, mc_rea_miercoles],
                  ['Jue',  mc_pro_jueves, mc_pro_jueves, mc_rea_jueves, mc_rea_jueves],
                  ['Vie',  mc_pro_viernes, mc_pro_viernes, mc_rea_viernes, mc_rea_viernes],
                  ['Sab',  mc_pro_sabado, mc_pro_sabado, mc_rea_sabado, mc_rea_sabado]
                ]);

                var optionsMc = {
                  title: 'MP CORRECTIVOS',
                  hAxis: {/*title: 'DIA', */ titleTextStyle: {color: '#44c2a6'}},
                  vAxis: {minValue: 0},
                  height: 300,
                  colors: ['#F3D93B', '#F0AE4E'],
                  legend: { position: 'bottom' }
                };

                var chartMc = new google.visualization.AreaChart(document.getElementById('mc_'+lider));
                chartMc.draw(dataMc, optionsMc);
            });

            
        }
    </script>





</body>

</html>