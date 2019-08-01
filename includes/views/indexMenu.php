			<!-- sidebar menu -->
                    <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
                      <div class="menu_section" >
                        <h3>General</h3>
                        <ul class="nav side-menu">
                            
                    	<?php
                    		if ($_SESSION["type"] == 1) // for administrator
                    		{
                                /*echo "<li>
                                        <a href='indexMain.php'>
                                            <i class='fa fa-home'></i> Inicio 
                                            <span class='fa fa-chevron-down'></span>
                                        </a>
                                    </li>";*/
                                echo "<li><a><i class='fa fa-desktop'></i> Monitoreo <span class='fa fa-chevron-down'></span></a>
                                    <ul class='nav child_menu'>
                                        <li><a href='indexMonitoreo.php?lider=239'>Hidroeléctrico</a></li>
                                        <li><a href='indexMonitoreo.php?lider=41185'>Mécanico</a></li>
                                        <li><a href='indexMonitoreo.php?lider=14993'>Plásticos</a></li>
                                        <li><a href='indexMonitoreo.php?lider=15113'>Suelos</a></li>
                                    </ul>
                                  </li>";

                                 // para la nueva disponibilidad
                                echo "<li><a><i class='fa fa-sitemap'></i> Big Data <span class='fa fa-chevron-down'></span></a>
                                    <ul class='nav child_menu'>
                                        <li><a href='indexDisponibilidadPlantas.php'>Plantas</a></li>
                                        <li><a href='indexDisponibilidadAnos.php'>Años</a></li>
                                        <li><a href='indexDisponibilidadMeses.php'>Meses</a></li>
                                        <li><a href='indexDisponibilidadSemanas.php'>Semanas</a></li>
                                        <li><a href='indexDisponibilidadCalendarios.php'>Días</a></li>
                                        <li><a href='indexDisponibilidadActivos.php'>Activos</a></li>
                                        <li><a href='indexDisponibilidadToperacional.php'>Tiempo operacional</a></li>
                                        <li><a href='indexDisponibilidadTestimado.php'>Tiempo estimado</a></li>
                                        <li><a href='indexDisponibilidadData.php'>Data</a></li>
                                        <li><a href='indexDisponibilidadCalcular.php'>Calcular disp.</a></li>
                                    </ul>
                                  </li>";

                                 // para el pago por actividades
                                echo "<li><a><i class='fa fa-usd'></i>Actividades <span class='fa fa-chevron-down'></span></a>
                                    <ul class='nav child_menu'>
                                        <li><a href='indexRecursosActividades.php'>Actividades</a></li>
                                        <li><a href='indexRecursosAsociados.php'>Asociados</a></li>
                                        <li><a href='indexRecursosBonosSemanales.php'>Bono semanal</a></li>
                                        <li><a href='indexRecursosBonosApoyos.php'>Bono apoyo</a></li>
                                        <li><a href='indexRecursosDepartamentos.php'>Departamentos</a></li>
                                        <li><a href='indexRecursosInvernaderos.php'>Invernaderos</a></li>
                                        <li><a href='indexRecursosPuestos.php'>Puestos</a></li>
                                    </ul>
                                  </li>";
                                 
                                echo "<li>
                                        <a href='indexEquiposCriticosTarget.php'>
                                            <i class='fa fa-exclamation-triangle'></i> Eq. Parados 
                                        </a>
                                    </li>";
                                echo "<li>
                                        <a href='indexPlanner.php'>
                                            <i class='fa fa-calendar' aria-hidden='true'></i></i> Planner
                                        </a>
                                    </li>";
                                echo "<li>
                                        <a href='indexUsers.php'><i class='fa fa-users fa-fw'></i> Usuarios</a>
                                    </li>";
                                echo "<li>
                                        <a href='indexActivosEquipos.php'><i class='fa fa-car fa-fw'></i> Activos</a>
                                    </li>";
                                echo "<li>
                                            <a href='indexMpIdeal.php'><i class='fa fa-clock-o'></i> Tiempo MP</a>
                                        </li>";
                                echo "<li>
                                            <a href='indexDisponibilidad.php'><i class='fa fa-line-chart' aria-hidden='true'></i>Disponibilidad</a>
                                        </li>";
                                echo "<li>
                                        <a href='indexMpvsMc.php'>
                                                <i class='fa fa-bar-chart' aria-hidden='true'></i>MP vs MC (*)</a>
                                            </li>";
                                echo "<li>
                                                <a href='indexMpvsMcCritica.php'>
                                                <i class='fa fa-truck' aria-hidden='true'></i> MP vs MC (crítica)</a>
                                            </li>";
                                echo "<li>
                                        <a href='indexCumplimientoV2.php'> <i class='fa fa-area-chart' aria-hidden='true'></i> Cumplim. v2</a>
                                    </li>";
                                /*echo "<li>
                                        <a href='indexAsignadosEquipos.php'> <i class='fa fa-user-secret' aria-hidden='true'></i> Asignación</a>
                                    </li>";*/
                                echo "<li>
                                        <a href='indexAnalisis.php'> <i class='fa fa-pie-chart' aria-hidden='true'></i> Análisis</a>
                                    </li>";

                                

                                
                                   
                    		} 
                    		elseif ($_SESSION["type"] == 4) // for plásticos
                            {
                                /*echo "<li>
                                        <a href='indexMain.php'>
                                            <i class='fa fa-home'></i> Inicio 
                                            <span class='fa fa-chevron-down'></span>
                                        </a>
                                    </li>";*/
                                echo "<li><a><i class='fa fa-desktop'></i> Monitoreo <span class='fa fa-chevron-down'></span></a>
                                    <ul class='nav child_menu'>
                                        <li><a href='indexMonitoreo.php?lider=14993'>Plásticos</a></li>
                                    </ul>
                                  </li>";
                                echo "<li>
                                        <a href='indexMpvsMc.php'>
                                                <i class='fa fa-bar-chart' aria-hidden='true'></i>MP vs MC (*)</a>
                                            </li>";
                               
                                echo "<li>
                                        <a href='indexCumplimientoV2.php'> <i class='fa fa-area-chart' aria-hidden='true'></i> Cumplim. v2</a>
                                    </li>";  


                            }
                            elseif ($_SESSION["type"] == 5) // for almacen
                            {
                                echo "<li><a><i class='fa fa-wrench'></i> ADMIN <span class='fa fa-chevron-down'></span></a>
                                    <ul class='nav child_menu'>
                                        <li><a href='indexHerramientas_almacenes.php'>Almacenes</a></li>
                                        <li><a href='indexHerramientas_categorias.php'>Categorías</a></li>
                                        <li><a href='indexHerramientas_proveedores.php'>Proveedores</a></li>
                                        <li><a href='indexHerramientas_udm.php'>Unidades de medida</a></li>
                                        <li><a href='indexHerramientas_herramientas.php'>Artículos / piezas</a></li>
                                        <li><a href='indexHerramientas_entradas.php'>Entrada piezas</a></li>
                                    </ul>
                                  </li>";

                                  echo "<li>
                                            <a href='indexHerramientas_articulos.php'><i class='fa fa-suitcase' aria-hidden='true'></i>Artículos préstamo</a>
                                        </li>";

                                    echo "<li>
                                            <a href='indexHerramientas_salidas.php'><i class='fa fa-shopping-bag' aria-hidden='true'></i>Artículos salidas</a>
                                        </li>";

                                    echo "<li>
                                            <a href='indexHerramientas_movimientos.php'><i class='fa fa-credit-card' aria-hidden='true'></i>Movimientos</a>
                                        </li>";
                                    
                                    echo "<li>
                                            <a href='indexHerramientas_asociado.php'><i class='fa fa-search' aria-hidden='true'></i>Asociado</a>
                                        </li>";
                            }
                            elseif ($_SESSION["type"] == 6) // for taller mecanico
                            {
                                /*echo "<li>
                                        <a href='indexMain.php'>
                                            <i class='fa fa-home'></i> Inicio 
                                            <span class='fa fa-chevron-down'></span>
                                        </a>
                                    </li>";*/
                                echo "<li><a><i class='fa fa-desktop'></i> Monitoreo <span class='fa fa-chevron-down'></span></a>
                                    <ul class='nav child_menu'>
                                        <li><a href='indexMonitoreo.php?lider=41185'>Mecánico</a></li>
                                    </ul>
                                  </li>";
                                echo "<li>
                                            <a href='indexDisponibilidad.php'><i class='fa fa-line-chart' aria-hidden='true'></i>Disponibilidad</a>
                                        </li>";
                                echo "<li>
                                        <a href='indexMpvsMc.php'>
                                                <i class='fa fa-bar-chart' aria-hidden='true'></i>MP vs MC (*)</a>
                                            </li>";
                                echo "<li>
                                                <a href='indexMpvsMcCritica.php'>
                                                <i class='fa fa-truck' aria-hidden='true'></i> MP vs MC (crítica)</a>
                                            </li>";
                                echo "<li>
                                        <a href='indexCumplimientoV2.php'> <i class='fa fa-area-chart' aria-hidden='true'></i> Cumplim. v2</a>
                                    </li>";    

                                echo "<li>
                                        <a href='indexAsignadosEquipos.php'> <i class='fa fa-user-secret' aria-hidden='true'></i> Asignación</a>
                                    </li>";
                                echo "<li>
                                        <a href='indexAnalisis.php'> <i class='fa fa-pie-chart' aria-hidden='true'></i> Análisis</a>
                                    </li>";

                                echo "<li>
                                        <a href='indexSegregacion.php?lider=41185'> <i class='fa fa-clock-o' aria-hidden='true'></i> Segregación</a>
                                    </li>";
                            }
                            elseif ($_SESSION["type"] == 7) // for taller hidroelectrico
                            {
                                /*echo "<li>
                                        <a href='indexMain.php'>
                                            <i class='fa fa-home'></i> Inicio 
                                            <span class='fa fa-chevron-down'></span>
                                        </a>
                                    </li>";*/
                                echo "<li><a><i class='fa fa-desktop'></i> Monitoreo <span class='fa fa-chevron-down'></span></a>
                                    <ul class='nav child_menu'>
                                        <li><a href='indexMonitoreo.php?lider=239'>Hidroeléctrico</a></li>
                                    </ul>
                                  </li>";
                                echo "<li>
                                            <a href='indexDisponibilidad.php'><i class='fa fa-line-chart' aria-hidden='true'></i>Disponibilidad</a>
                                        </li>";
                                echo "<li>
                                        <a href='indexMpvsMc.php'>
                                                <i class='fa fa-bar-chart' aria-hidden='true'></i>MP vs MC (*)</a>
                                            </li>";
                                echo "<li>
                                                <a href='indexMpvsMcCritica.php'>
                                                <i class='fa fa-truck' aria-hidden='true'></i> MP vs MC (crítica)</a>
                                            </li>";
                                echo "<li>
                                        <a href='indexCumplimientoV2.php'> <i class='fa fa-area-chart' aria-hidden='true'></i> Cumplim. v2</a>
                                    </li>";   
                                echo "<li>
                                        <a href='indexAsignadosEquipos.php'> <i class='fa fa-user-secret' aria-hidden='true'></i> Asignación</a>
                                    </li>";
                                echo "<li>
                                        <a href='indexAnalisis.php'> <i class='fa fa-pie-chart' aria-hidden='true'></i> Análisis</a>
                                    </li>";
                                echo "<li>
                                        <a href='indexMedicionesRebombeo.php'> <i class='fa fa-calculator' aria-hidden='true'></i> Mediciones rebombeo</a>
                                    </li>";

                                echo "<li>
                                        <a href='indexSegregacion.php?lider=239'> <i class='fa fa-clock-o' aria-hidden='true'></i> Segregación</a>
                                    </li>";
                            }
                            elseif ($_SESSION["type"] == 8) // for suelos
                            {
                                /*echo "<li>
                                        <a href='indexMain.php'>
                                            <i class='fa fa-home'></i> Inicio 
                                            <span class='fa fa-chevron-down'></span>
                                        </a>
                                    </li>";*/
                                echo "<li><a><i class='fa fa-desktop'></i> Monitoreo <span class='fa fa-chevron-down'></span></a>
                                    <ul class='nav child_menu'>
                                        <li><a href='indexMonitoreo.php?lider=15113'>Suelos</a></li>
                                    </ul>
                                  </li>";
                                /*echo "<li>
                                            <a href='indexDisponibilidad.php'><i class='fa fa-line-chart' aria-hidden='true'></i>Disponibilidad</a>
                                        </li>";
                                echo "<li>
                                        <a href='indexMpvsMc.php'>
                                                <i class='fa fa-bar-chart' aria-hidden='true'></i>MP vs MC (*)</a>
                                            </li>";
                                echo "<li>
                                                <a href='indexMpvsMcCritica.php'>
                                                <i class='fa fa-truck' aria-hidden='true'></i> MP vs MC (crítica)</a>
                                            </li>";
                                echo "<li>
                                        <a href='indexCumplimientoV2.php'> <i class='fa fa-area-chart' aria-hidden='true'></i> Cumplim. v2</a>
                                    </li>"; */  
                                 // para el pago por actividades
                                echo "<li><a><i class='fa fa-usd'></i>Actividades <span class='fa fa-chevron-down'></span></a>
                                    <ul class='nav child_menu'>
                                        
                                        <li><a href='indexRecursosBonosSemanales.php'>Bono semanal</a></li>
                                        <li><a href='indexRecursosBonosApoyos.php'>Bono apoyo</a></li>
                                    </ul>
                                  </li>";
                            }

                            elseif ($_SESSION["type"] == 9) // for zancos
                            {
                                echo "<li><a><i class='fa fa-wrench'></i> ADMIN <span class='fa fa-chevron-down'></span></a>
                                    <ul class='nav child_menu'>
                                        <li><a href='indexZancos_acciones.php'>Acciones</a></li>
                                        <li><a href='indexZancos_ghs.php'>GH</a></li>
                                        <li><a href='indexZancos_lideres.php'>Líderes</a></li>
                                        <li><a href='indexZancos_tamanos.php'>Tamaños</a></li>
                                        <li><a href='indexZancos_problemas.php'>Problemas</a></li>
                                        <li><a href='indexZancos_bd.php'>BD</a></li>
                                    </ul>
                                  </li>";

                                  echo "<li>
                                            <a href='indexZancos_movimientos.php'><i class='fa fa-arrows' aria-hidden='true'></i>Movimientos</a>
                                        </li>";
                                echo "<li><a><i class='fa fa-file-text'></i> REPORTES <span class='fa fa-chevron-down'></span></a>
                                    <ul class='nav child_menu'>
                                        <li><a href='indexZancos_reportes_mayor.php'> > 1.5 años</a></li>
                                        <li><a href='indexZancos_reportes_desfase.php'>Desfasados</a></li>
                                        <li><a href='indexZancos_reportes_historial.php'>Piezas</a></li>
                                    </ul>
                                  </li>";

                                echo "<li>
                                            <a href='indexZancos_dashboard.php'><i class='fa fa-desktop' aria-hidden='true'></i>Dashboard</a>
                                        </li>";
                                
                            }
                    	?>
                    </ul>
                </div>

            </div><!-- /sidebar menu --> 

           