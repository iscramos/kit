 <?php require_once(VIEW_PATH.'header.inc.php');
      
 ?>        
            <!-- /.navbar-static-side -->
        </nav>

        <div id="page-wrapper">

            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Detalles de semana <?php echo $semana; ?> por líder</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-12">
                    
                            <?php
                                

                                $nsOrfanel = 41185;
                                $nsHumberto = 239;

                                $totalMPOrfanel = 0;
                                $otrosMPOrfanel = 0;
                                $totalMPTerminadosOrfanel = 0;
                                $totalMPPendientesOrfanel = 0;
                                $totalMCOrfanel = 0;
                                $otrosMCOrfanel = 0;
                                $totalMCTerminadosOrfanel = 0;
                                $totalMCPendientesOrfanel = 0;
                                $cumplimientoMPOrfanel = 0;
                                $cumplimientoMCOrfanel = 0;
                                $promedioSemanalOrfanel = 0;
                                $promedioSemanalAcumuladoOrfanel = 0;


                                $totalMPHumberto = 0;
                                $otrosMPHumberto = 0;
                                $totalMPTerminadosHumberto = 0;
                                $totalMPPendientesHumberto = 0;
                                $totalMCHumberto = 0;
                                $otrosMCHumberto = 0;
                                $totalMCTerminadosHumberto = 0;
                                $totalMCPendientesHumberto = 0;
                                $cumplimientoMPHumberto = 0;
                                $cumplimientoMCHumberto = 0;
                                $promedioSemanalHumberto = 0;
                                $promedioSemanalAcumuladoHumberto = 0;


                                foreach ($ordenes as $orden) 
                                {
                                    // ORFANEL
                                    /*if ($orden->tipo == "Mant. preventivo" && $orden->responsable == $nsOrfanel) 
                                    {
                                        $totalMPOrfanel ++;
                                    }*/
                                    if ($orden->tipo == "Mant. preventivo" && $orden->responsable == $nsOrfanel
                                        && ($orden->estado == 'Cerrado sin ejecutar'
                                           || $orden->estado == 'Cierre Lider Mtto'
                                            || $orden->estado == 'Ejecutado'
                                            || $orden->estado == 'Espera de equipo'
                                            || $orden->estado == 'Espera de refacciones'
                                            || $orden->estado == 'Programada' 
                                            || $orden->estado == 'Terminado' ) 
                                        ) 
                                    {
                                        $totalMPOrfanel ++;
                                    }

                                    if ($orden->tipo == "Mant. preventivo" && $orden->responsable == $nsOrfanel
                                        && ($orden->estado == 'Cancelado'
                                            || $orden->estado == 'Rechazado'
                                            || $orden->estado == 'Solic. de trabajo' ) 
                                        ) 
                                    {
                                        $otrosMPOrfanel ++;
                                    }

                                    /*if ($orden->tipo == "Mant. preventivo" && $orden->estado == "Terminado" && $orden->responsable == $nsOrfanel) 
                                    {
                                        $totalMPTerminadosOrfanel ++;
                                    }*/

                                    if ($orden->tipo == "Mant. preventivo"  && $orden->responsable == $nsOrfanel
                                        && ($orden->estado == 'Terminado'
                                            || $orden->estado == 'Cerrado sin ejecutar')
                                        ) 
                                    {
                                        $totalMPTerminadosOrfanel ++;
                                    }
                                    

                                    /*if ($orden->tipo == "Mant. preventivo" && $orden->estado != "Terminado" && $orden->responsable == $nsOrfanel) 
                                    {
                                        $totalMPPendientesOrfanel ++;
                                    }*/

                                    if ($orden->tipo == "Mant. preventivo"  && $orden->responsable == $nsOrfanel
                                        && ($orden->estado == 'Programada' 
                                            || $orden->estado == 'Cierre Lider Mtto'
                                            || $orden->estado == 'Ejecutado'
                                            || $orden->estado == 'Espera de equipo'
                                            || $orden->estado == 'Espera de refacciones')
                                        &&  $orden->estado != 'Cancelado'
                                        ) 
                                    {
                                        $totalMPPendientesOrfanel ++;
                                    }

                                    

                                    if ($orden->responsable == $nsOrfanel
                                        && ($orden->tipo =='Correctivo planeado' || $orden->tipo == 'Correctivo de emergencia')
                                        && ($orden->estado == 'Cerrado sin ejecutar'
                                            || $orden->estado == 'Cierre Lider Mtto'
                                            || $orden->estado == 'Ejecutado'
                                            || $orden->estado == 'Espera de equipo'
                                            || $orden->estado == 'Espera de refacciones'
                                            || $orden->estado == 'Programada' 
                                            || $orden->estado == 'Terminado' )
                                        ) 
                                    {
                                        $totalMCOrfanel ++;
                                    }

                                    if ($orden->responsable == $nsOrfanel
                                        && ($orden->tipo =='Correctivo planeado' || $orden->tipo == 'Correctivo de emergencia')
                                        && ($orden->estado == 'Cancelado'
                                            || $orden->estado == 'Rechazado'
                                            || $orden->estado == 'Solic. de trabajo' ) 
                                        ) 
                                    {

                                        $otrosMCOrfanel ++;
                                    }

                                    /*if (($orden->tipo == "Correctivo de emergencia" || $orden->tipo == "Correctivo planeado") && $orden->estado == "Terminado" && $orden->responsable == $nsOrfanel) 
                                    {
                                        $totalMCTerminadosOrfanel ++;
                                    }*/

                                    if (($orden->tipo == "Correctivo de emergencia" || $orden->tipo == "Correctivo planeado")  && $orden->responsable == $nsOrfanel
                                            && ($orden->estado == 'Terminado'
                                                || $orden->estado == 'Cerrado sin ejecutar')
                                        ) 
                                    {
                                        $totalMCTerminadosOrfanel ++;
                                    }

                                    /*if (($orden->tipo == "Correctivo de emergencia" || $orden->tipo == "Correctivo planeado") && $orden->estado != "Terminado" && $orden->responsable == $nsOrfanel) 
                                    {
                                        $totalMCPendientesOrfanel ++;
                                    }*/

                                    if (($orden->tipo == "Correctivo de emergencia" || $orden->tipo == "Correctivo planeado") && $orden->responsable == $nsOrfanel
                                            && ($orden->estado == 'Programada' 
                                                || $orden->estado == 'Cierre Lider Mtto'
                                                || $orden->estado == 'Ejecutado'
                                                || $orden->estado == 'Espera de equipo'
                                                || $orden->estado == 'Espera de refacciones')
                                            &&  $orden->estado != 'Cancelado'
                                        ) 
                                    {
                                        $totalMCPendientesOrfanel ++;
                                    }

                                    // HUMBERTO
                                    /*if ($orden->tipo == "Mant. preventivo" && $orden->responsable == $nsHumberto) 
                                    {
                                        $totalMPHumberto ++;
                                    }

                                    if ($orden->tipo == "Mant. preventivo" && $orden->estado == "Terminado" && $orden->responsable == $nsHumberto) 
                                    {
                                        $totalMPTerminadosHumberto ++;
                                    }

                                    if ($orden->tipo == "Mant. preventivo" && $orden->estado != "Terminado" && $orden->responsable == $nsHumberto) 
                                    {
                                        $totalMPPendientesHumberto ++;
                                    }

                                    if ( ($orden->tipo == "Correctivo de emergencia" || $orden->tipo == "Correctivo planeado") && $orden->responsable == $nsHumberto) 
                                    {
                                        $totalMCHumberto ++;
                                    }

                                    if (($orden->tipo == "Correctivo de emergencia" || $orden->tipo == "Correctivo planeado") && $orden->estado == "Terminado" && $orden->responsable == $nsHumberto) 
                                    {
                                        $totalMCTerminadosHumberto ++;
                                    }

                                    if (($orden->tipo == "Correctivo de emergencia" || $orden->tipo == "Correctivo planeado") && $orden->estado != "Terminado" && $orden->responsable == $nsHumberto) 
                                    {
                                        $totalMCPendientesHumberto ++;
                                    }*/

                                    if ($orden->tipo == "Mant. preventivo" && $orden->responsable == $nsHumberto
                                        && ($orden->estado == 'Cerrado sin ejecutar'
                                           || $orden->estado == 'Cierre Lider Mtto'
                                            || $orden->estado == 'Ejecutado'
                                            || $orden->estado == 'Espera de equipo'
                                            || $orden->estado == 'Espera de refacciones'
                                            || $orden->estado == 'Programada' 
                                            || $orden->estado == 'Terminado' ) 
                                        ) 
                                    {
                                        $totalMPHumberto ++;
                                    }

                                    if ($orden->tipo == "Mant. preventivo" && $orden->responsable == $nsHumberto
                                        && ($orden->estado == 'Cancelado'
                                            || $orden->estado == 'Rechazado'
                                            || $orden->estado == 'Solic. de trabajo' ) 
                                        ) 
                                    {
                                        $otrosMPHumberto ++;
                                    }

                                    if ($orden->tipo == "Mant. preventivo"  && $orden->responsable == $nsHumberto
                                        && ($orden->estado == 'Terminado'
                                            || $orden->estado == 'Cerrado sin ejecutar')
                                        ) 
                                    {
                                        $totalMPTerminadosHumberto ++;
                                    }

                                    if ($orden->tipo == "Mant. preventivo"  && $orden->responsable == $nsHumberto
                                        && ($orden->estado == 'Programada' 
                                            || $orden->estado == 'Cierre Lider Mtto'
                                            || $orden->estado == 'Ejecutado'
                                            || $orden->estado == 'Espera de equipo'
                                            || $orden->estado == 'Espera de refacciones')
                                        &&  $orden->estado != 'Cancelado'
                                        ) 
                                    {
                                        $totalMPPendientesHumberto ++;
                                    }

                                    if ( $orden->responsable == $nsHumberto
                                        && ($orden->tipo =='Correctivo planeado' || $orden->tipo == 'Correctivo de emergencia')
                                        && ($orden->estado == 'Cerrado sin ejecutar'
                                            || $orden->estado == 'Cierre Lider Mtto'
                                            || $orden->estado == 'Ejecutado'
                                            || $orden->estado == 'Espera de equipo'
                                            || $orden->estado == 'Espera de refacciones'
                                            || $orden->estado == 'Programada' 
                                            || $orden->estado == 'Terminado' )
                                        ) 
                                    {
                                        $totalMCHumberto ++;
                                    }

                                    if ($orden->responsable == $nsHumberto
                                        && ($orden->tipo =='Correctivo planeado' || $orden->tipo == 'Correctivo de emergencia')
                                        && ($orden->estado == 'Cancelado'
                                            || $orden->estado == 'Rechazado'
                                            || $orden->estado == 'Solic. de trabajo' ) 
                                        ) 
                                    {

                                        $otrosMCHumberto ++;
                                    }

                                    if (($orden->tipo == "Correctivo de emergencia" || $orden->tipo == "Correctivo planeado") && $orden->responsable == $nsHumberto
                                        && ($orden->estado == 'Terminado'
                                                || $orden->estado == 'Cerrado sin ejecutar')
                                        ) 
                                    {
                                        $totalMCTerminadosHumberto ++;
                                    }

                                    if (($orden->tipo == "Correctivo de emergencia" || $orden->tipo == "Correctivo planeado") && $orden->responsable == $nsHumberto
                                        && ($orden->estado == 'Programada' 
                                                || $orden->estado == 'Cierre Lider Mtto'
                                                || $orden->estado == 'Ejecutado'
                                                || $orden->estado == 'Espera de equipo'
                                                || $orden->estado == 'Espera de refacciones')
                                            &&  $orden->estado != 'Cancelado'
                                        ) 
                                    {
                                        $totalMCPendientesHumberto ++;
                                    }
                                }

                                /*$cumplimientoMPOrfanel = ($totalMPTerminadosOrfanel / ($totalMPOrfanel + $nPendientesAnoAnteriorMPOrfanel) * 100);*/
                                if($totalMPOrfanel > 0)
                                {
                                    $cumplimientoMPOrfanel = ($totalMPTerminadosOrfanel / $totalMPOrfanel) * 100;
                                    $cumplimientoMPOrfanel = round($cumplimientoMPOrfanel, 1);
                                }
                                
                                if( ($totalMCOrfanel + $nPendientesAnoAnteriorMCOrfanel) > 0)
                                {
                                    $cumplimientoMCOrfanel = ($totalMCTerminadosOrfanel / ($totalMCOrfanel + $nPendientesAnoAnteriorMCOrfanel) * 100);
                                
                                    $cumplimientoMCOrfanel = round($cumplimientoMCOrfanel, 1);
                                }
                                

                                if($totalMCOrfanel > 0)
                                {
                                    $promedioSemanalOrfanel = ($cumplimientoMPOrfanel + ( ($totalMCTerminadosOrfanel / $totalMCOrfanel ) * 100) )/2 ;
                                    $promedioSemanalOrfanel = round($promedioSemanalOrfanel, 1);
                                }
                                

                                $promedioSemanalAcumuladoOrfanel = ($cumplimientoMPOrfanel + $cumplimientoMCOrfanel) /2 ;
                                $promedioSemanalAcumuladoOrfanel = round($promedioSemanalAcumuladoOrfanel, 1);

                                /*$cumplimientoMPHumberto = ($totalMPTerminadosHumberto / ($totalMPHumberto + $nPendientesAnoAnteriorMPHumberto) * 100);*/
                                if($totalMPHumberto > 0)
                                {
                                    $cumplimientoMPHumberto = ($totalMPTerminadosHumberto / $totalMPHumberto) * 100;
                                    $cumplimientoMPHumberto = round($cumplimientoMPHumberto, 1);
                                }
                                
                                if (($totalMCHumberto + $nPendientesAnoAnteriorMCHumberto) > 0)
                                {
                                    $cumplimientoMCHumberto = ($totalMCTerminadosHumberto / ($totalMCHumberto + $nPendientesAnoAnteriorMCHumberto) * 100);
                                    $cumplimientoMCHumberto = round($cumplimientoMCHumberto, 1);
                                }
                                

                                if ($totalMCHumberto > 0)
                                {
                                    $promedioSemanalHumberto = ($cumplimientoMPHumberto + ( ($totalMCTerminadosHumberto / $totalMCHumberto ) * 100) )/2 ;
                                    $promedioSemanalHumberto = round($promedioSemanalHumberto, 1);
                                }
                                

                                $promedioSemanalAcumuladoHumberto = ($cumplimientoMPHumberto + $cumplimientoMCHumberto) /2 ;
                                $promedioSemanalAcumuladoHumberto = round($promedioSemanalAcumuladoHumberto, 1);

                                
                            ?>
                    <input type="text" id="fechaInicio" class='form-control hidden' value='<?php echo $fechaInicio; ?>'>
                    <input type="text" id="fechaFinalizacion" class='form-control hidden' value='<?php echo $fechaFinalizacion; ?>'>
                    
                    <div class='alert alert-success' role='alert' id='mensaje'>
                                  <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
                                  <strong>Nota!</strong> Para ver más detalles de las órdenes de trabajo, haga click sobre el número correspondiente.
                                </div>


                    <h4 class='text-center'>ING. ORFANEL RENDON RAMIREZ</h4>
                    <table class='table table-bordered orfanel' style='font-size: 12px;'>
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
                                <td class='bg-info'>
                                    <a title='Ver detalles de órdenes' href='#' class='detallesOrdenes' tipo='totalMP' lider='<?php echo $nsOrfanel?>'><?php echo $totalMPOrfanel; ?></a>
                                </td>
                                <td style='background: #5b4282; color:white;'>
                                    <a title='Ver detalles de órdenes' href='#' class='detallesOrdenes' tipo='otrosMP' lider='<?php echo $nsOrfanel?>'><?php echo $otrosMPOrfanel; ?></a>
                                </td>
                                <td class='bg-success'>
                                    <a title='Ver detalles de órdenes' href='#' class='detallesOrdenes' tipo='terminadoMP' lider='<?php echo $nsOrfanel?>'><?php echo $totalMPTerminadosOrfanel; ?></a>
                                </td>
                                <td class='bg-warning'>
                                    <a title='Ver detalles de órdenes' href='#' class='detallesOrdenes' tipo='pendienteMP' lider='<?php echo $nsOrfanel?>'><?php echo $totalMPPendientesOrfanel; ?></a>
                                </td>
                                <!--td class='bg-danger'>
                                    <?php echo $nPendientesAnoAnteriorMPOrfanel; ?>
                                </td-->
                                <td >
                                    <?php echo $cumplimientoMPOrfanel; ?> %
                                </td>

                                <td class='bg-info'>
                                    <a title='Ver detalles de órdenes' href='#' class='detallesOrdenes' tipo='totalMC' lider='<?php echo $nsOrfanel?>'><?php echo $totalMCOrfanel; ?></a>
                                </td>
                                <td style='background: #5b4282; color:white;'>
                                    <a title='Ver detalles de órdenes' href='#' class='detallesOrdenes' tipo='otrosMC' lider='<?php echo $nsOrfanel?>'> <?php echo $otrosMCOrfanel ;?></a>
                                </td>
                                <td class='bg-success'>
                                    <a title='Ver detalles de órdenes' href='#' class='detallesOrdenes' tipo='terminadoMC' lider='<?php echo $nsOrfanel?>'><?php echo $totalMCTerminadosOrfanel; ?></a>
                                </td>
                                <td class='bg-warning'>
                                    <a title='Ver detalles de órdenes' href='#' class='detallesOrdenes' tipo='pendienteMC' lider='<?php echo $nsOrfanel?>'><?php echo $totalMCPendientesOrfanel; ?></a>
                                </td>
                                <td class='bg-danger'>
                                    <?php echo $nPendientesAnoAnteriorMCOrfanel; ?>
                                </td>
                                <td >
                                    <?php echo $cumplimientoMCOrfanel; ?> %
                                </td>

                            </tr>
                            <tr class='bg-primary'>
                                <td colspan='10' class='text-right'>PROMEDIO SEMANAL MP Y MC (SIN ACUMULACION)</td>
                                <td>
                                    <div class="input-group col-xs-6">
                                        <input type="text" class='form-control' value='<?php echo $promedioSemanalOrfanel; ?>' readonly>
                                        <div class="input-group-addon">%</div>
                                </td>
                            </tr>
                            <tr class='bg-primary'>
                                <td colspan='10' class='text-right'>PROMEDIO SEMANAL MP Y MC (CON ACUMULACION)</td>
                                <td>
                                    <div class="input-group col-xs-6">
                                        <input type="text" class='form-control' value='<?php echo $promedioSemanalAcumuladoOrfanel; ?>' readonly>
                                        <div class="input-group-addon">%</div>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>

                    <h4 class='text-center'>ING. HUMBERTO CERVANTES RODRIGUEZ</h4>
                    <table class='table table-bordered humberto' style='font-size: 12px;'>
                        <thead class='bg-primary'>
                            <tr>
                                <th style='background:#5cb85c; color:white;'>TOTAL MP</th>
                                <th style='background:#5cb85c; color:white;'>OTROS MP</th>
                                <th style='background:#5cb85c; color:white;'>TERMINADOS MP</th>
                                <th style='background:#5cb85c; color:white;'>PENDIENTES MP</th>
                                <!--th style='background:#5cb85c; color:white; '>+ MP</th-->
                                <th style='background:#5cb85c; color:white; '>% CMTO.</th>


                                <th style='background:#f0ad4e; color:white; '>TOTAL MC</th>
                                <th style='background:#f0ad4e; color:white; '>OTROS MC</th>
                                <th style='background:#f0ad4e; color:white; '>TERMINADOS MC</th>
                                <th style='background:#f0ad4e; color:white; '>PENDIENTES MC</th> 
                                <th style='background:#f0ad4e; color:white; '>+ MC</th>
                                <th style='background:#f0ad4e; color:white; '>% CMTO.</th>                                
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                
                                <td class='bg-info'>
                                    <a title='Ver detalles de órdenes' href='#' class='detallesOrdenes' tipo='totalMP' lider='<?php echo $nsHumberto?>'> <?php echo $totalMPHumberto; ?></a>
                                </td>
                                <td style='background: #5b4282; color:white;'>
                                    <a title='Ver detalles de órdenes' href='#' class='detallesOrdenes' tipo='otrosMP' lider='<?php echo $nsHumberto?>'> <?php echo $otrosMPHumberto ;?></a>
                                </td>
                                <td class='bg-success'>
                                    <a title='Ver detalles de órdenes' href='#' class='detallesOrdenes' tipo='terminadoMP' lider='<?php echo $nsHumberto?>'> <?php echo $totalMPTerminadosHumberto; ?></a>
                                </td>
                                <td class='bg-warning'>
                                    <a title='Ver detalles de órdenes' href='#' class='detallesOrdenes' tipo='pendienteMP' lider='<?php echo $nsHumberto?>'> <?php echo $totalMPPendientesHumberto; ?></a>
                                </td>
                                <!--td class='bg-danger'>
                                    <?php echo $nPendientesAnoAnteriorMPHumberto; ?>
                                </td-->
                                <td >
                                    <?php echo $cumplimientoMPHumberto; ?> %
                                </td>

                                <td class='bg-info'>
                                    <a title='Ver detalles de órdenes' href='#' class='detallesOrdenes' tipo='totalMC' lider='<?php echo $nsHumberto?>'> <?php echo $totalMCHumberto; ?></a>
                                </td>
                                <td style='background: #5b4282; color:white;'>
                                    <a title='Ver detalles de órdenes' href='#' class='detallesOrdenes' tipo='otrosMC' lider='<?php echo $nsHumberto?>'> <?php echo $otrosMCHumberto ;?></a>
                                </td>
                                <td class='bg-success'>
                                    <a title='Ver detalles de órdenes' href='#' class='detallesOrdenes' tipo='terminadoMC' lider='<?php echo $nsHumberto?>'> <?php echo $totalMCTerminadosHumberto; ?></a>
                                </td>
                                <td class='bg-warning'>
                                    <a title='Ver detalles de órdenes' href='#' class='detallesOrdenes' tipo='pendienteMC' lider='<?php echo $nsHumberto?>'> <?php echo $totalMCPendientesHumberto; ?></a>
                                </td>
                                <td class='bg-danger'>
                                    <?php echo $nPendientesAnoAnteriorMCHumberto; ?>
                                </td>
                                <td >
                                    <?php echo $cumplimientoMCHumberto; ?> %
                                </td>
                            </tr>
                            <tr class='bg-primary'>
                                <td colspan='10' class='text-right'>PROMEDIO SEMANAL MP Y MC (SIN ACUMULACION)</td>
                                <td >
                                    <div class="input-group col-xs-6">
                                        <input type="text" class='form-control' value='<?php echo $promedioSemanalHumberto; ?>' readonly>
                                        <div class="input-group-addon">%</div>
                                    </div>
                                </td>
                            </tr>
                            <tr class='bg-primary'>
                                <td colspan='10' class='text-right '>PROMEDIO SEMANAL MP Y MC (CON ACUMULACION)</td>
                                <td >
                                    <div class="input-group col-xs-6">
                                        <input type="text" class='form-control' value='<?php echo $promedioSemanalAcumuladoHumberto; ?>' readonly>
                                        <div class="input-group-addon">%</div>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>

                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->

            
            
        </div>
        <!-- /#page-wrapper -->


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
   <!-- Flot Charts JavaScript -->
    <script src="<?php echo $url; ?>dist/js/loader.js"></script>
    <script src="<?php echo $url; ?>dist/js/jsapi.js"></script>
    <script type="text/javascript">
        $(document).ready(function()
        {
            $("#page-wrapper").css("margin", 0);
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

    google.charts.load("visualization", "1", {packages:["corechart","bar"]});
    google.charts.setOnLoadCallback(drawPorMes);
     
    
    function drawPorMes()
    {
        var meses = ["ENERO", "FEBRERO", "MARZO", "ABRIL", "MAYO", "JUNIO", "JULIO", "AGOSTO", "SEPTIEMBRE", "OCTUBRE", "NOVIEMBRE", "DICIEMBRE"];

        var constructor = [['',  'TOTAL', 'Preventivos', 'Correctivos']];
        $.each(meses, function( key, value ) 
        {
            var mes = value;
    
                var porcentajePreventivo = 0;
                var porcentajeCorrectivo = 0;

                porcentajeMes = 0;
                //promedio = 0;

            $( ".totalMesPreventivo"+mes).each(function() 
            {
               porcentajePreventivo = $(".valorMP"+mes).val();
               porcentajeCorrectivo = $(".valorMC"+mes).val();
               //console.log(porcentajePreventivo);
               
            });
            porcentajePreventivo = parseFloat(porcentajePreventivo);
            porcentajeCorrectivo = parseFloat(porcentajeCorrectivo);

            porcentajeMes = parseFloat( (porcentajePreventivo + porcentajeCorrectivo) / 2 );

            


            /*contadorPreventivo = parseInt(contadorPreventivo);
            contadorCorrectivo = parseInt(contadorPreventivo);*/
            /*constructor.push([mes, porcentajePreventivo, porcentajeCorrectivo, porcentajeMes]);*/

            constructor.push([mes, porcentajeMes, porcentajePreventivo, porcentajeCorrectivo]);
        });

        var data = google.visualization.arrayToDataTable(constructor);

        var options = {
            
          chart: {
            //title: 'Company Performance',
            subtitle: 'Cumplimiento mensual de MP vs MC',

          },
          bars: 'vertical',
          vAxis: {
                //format: 'percent',
                 //textStyle: { color: '#94511A'},
                title: '% de cumplimiento',
                
                format: '#\'%\''

                //format: '#',
                //viewWindow: {min: 0, max: 85},
                //gridlines:{count:5},
                
                
            },
          height: 315,
          /*width:400,*/
          colors: ['#337ab7', '#5cb85c', '#f0ad4e']
        };

        var chart = new google.charts.Bar(document.getElementById('graficaActualizada'));

        chart.draw(data, google.charts.Bar.convertOptions(options));

    }
            
            // ----------------------------------------------------------------

        }); // end ready


        $( window ).load(function() 
        {
             
    


    
    

        });

    </script>




<script type="text/javascript">
    
    </script>



</body>

</html>