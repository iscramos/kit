			<!-- sidebar menu -->
                    <div id="sidebar-menu" class="main_menu_side hidden-print main_menu menu_fixed">
                      <div class="menu_section">
                        <h3>General</h3>
                        <ul class="nav side-menu">
                            
                    	<?php
                    		if ($_SESSION["type"] == 1) // for administrator
                    		{
                                echo "<li>
                                        <a>
                                            <i class='fa fa-home'></i> Inicio 
                                            <span class='fa fa-chevron-down'></span>
                                        </a>
                                    </li>";
                                echo "<li><a><i class='fa fa-desktop'></i> Monitoreo <span class='fa fa-chevron-down'></span></a>
                                    <ul class='nav child_menu'>
                                        <li><a href='indexMonitoreo.php?lider=239'>Hidroeléctrico</a></li>
                                        <li><a href='indexMonitoreo.php?lider=41185'>Mécanico</a></li>
                                        <li><a href='indexMonitoreo.php?lider=14993'>Plásticos</a></li>
                                        <li><a href='indexMonitoreo.php?lider=15113'>Suelos</a></li>
                                    </ul>
                                  </li>";
                                echo "<li>
                                        <a href='indexEquiposCriticosTarget.php'>
                                            <i class='fa fa-exclamation-triangle'></i> Equipos parados 
                                            <span class='fa fa-chevron-down'></span>
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
                                        <a href='indexCumplimientoV2.php'> <i class='fa fa-area-chart' aria-hidden='true'></i> Cumplimiento v2</a>
                                    </li>";
                                        
                                /*echo "<li>";
                                    echo "<a href='indexMain.php'><i class='fa fa-gitlab fa-fw'></i> ADMINISTRADOR</a>";
                                echo "</li>";
                    		 	echo "<li>";
                    		 		echo "<a href='indexUsers.php'><i class='fa fa-users fa-fw'></i> Usuarios</a>";
                    		 	echo "</li>";

                                echo "<li>";
                                    echo "<a href='indexActivosEquipos.php'><i class='fa fa-car fa-fw'></i> Equipos por familia</a>";
                                echo "</li>";
                                echo "<li>";
                                    echo "<a href='#'><i class='fa fa-tasks fa-fw'></i> Disponibilidad <span class='fa arrow'></span></a>";
                                    echo "<ul class='nav nav-second-level'>
                                            <li>
                                                <a href='indexDashboardCritico.php'>Dashboard (crítico)</a>
                                            </li>
                                    		<li>
                                                <a href='indexMpIdeal.php'>Equipos (Tiempo ideal)</a>
                                            </li>
                                            <li>
                                                <a href='indexOt.php'>OT'S</a>
                                            </li>
                                            <!--li>
                                                <a href='indexMp.php'>Mantenimiento preventivo</a>
                                            </li-->
                                            <li>
                                                <a href='indexDisponibilidad.php'>Disponibilidad</a>
                                            </li>
                                            <li>
                                                <a href='indexMpvsMc.php'>MP vs MC (*)</a>
                                            </li>
                                            <li>
                                                <a href='indexMpvsMcCritica.php'>MP vs MC (crítica)</a>
                                            </li>
                                            <li>
                                                <a href='indexMonitoreo.php?lider=239'>Monitoreo hidroeléctrico</a>
                                            </li>
                                            <li>
                                                <a href='indexMonitoreo.php?lider=41185'>Monitoreo mécanico</a>
                                            </li>
                                            <li>
                                                <a href='indexMonitoreo.php?lider=14993'>Monitoreo plásticos</a>
                                            </li>
                                            <li>
                                                <a href='indexMonitoreo.php?lider=15113'>Monitoreo suelos</a>
                                            </li>
                                        </ul>";
                                echo "</li>";
                                echo "<li>";
                                    echo "<a href='#'><i class='fa fa-globe' aria-hidden='true'></i></i> Visualizador <span class='fa arrow'></span></a>";
                                    echo "<ul class='nav nav-second-level'>
                                            <li>
                                                <a href='indexEquiposCriticosTarget.php'>Equipos críticos</a>
                                            </li>
                                            
                                        </ul>";
                                echo "</li>";
                                echo "<li>";
                                    echo "<a href='#'><i class='fa fa-barcode fa-fw'></i> Almacén <span class='fa arrow'></span></a>";
                                    echo "<ul class='nav nav-second-level'>
                                            <li>
                                                <a href='indexAlmacen.php'>Inventario</a>
                                            </li>
                                            
                                        </ul>";
                                echo "</li>";
                                echo "<li>";
                                    echo "<a href='indexHerramientas_categorias.php'><i class='fa fa-wrench fa-fw'></i> Herramientas</a>";
                                echo "</li>";


                                echo "<li>";
                                    echo "<a href='indexMedicionesCamara.php'><i class='fa fa-line-chart fa-fw'></i> Mediciones de cámara fría</a>";
                                echo "</li>"; */
                                   
                    		} 
                    		elseif ($_SESSION["type"] == 3) // for embarque
                    		{
                    			echo "<li>";
                                    echo "<a href='indexMain.php'><i class='fa fa-gitlab fa-fw'></i> EMBARQUE</a>";
                                echo "</li>";
                                echo "<li>";
                                    echo "<a href='indexMedicionesCamara.php'><i class='fa fa-line-chart fa-fw'></i> Mediciones de cámara fría</a>";
                                echo "</li>";     
                    		}
                            elseif ($_SESSION["type"] == 4) // for plásticos
                            {
                                echo "<li>";
                                    echo "<a href='#'><i class='fa fa-tasks fa-fw'></i> Disponibilidad <span class='fa arrow'></span></a>";
                                    echo "<ul class='nav nav-second-level'>
                                            <!--li>
                                                <a href='indexOt.php'>OT'S</a>
                                            </li>
                                            
                                            <li>
                                                <a href='indexDisponibilidad.php'>Disponibilidad</a>
                                            </li>
                                            <li>
                                                <a href='indexMpvsMc.php'>MP vs MC (*)</a>
                                            </li>
                                            <li>
                                                <a href='indexMpvsMcCritica.php'>MP vs MC (crítica)</a>
                                            </li-->
                                            <li>
                                                <a href='indexMonitoreo.php?lider=14993'>Monitoreo plásticos</a>
                                            </li>
                                        </ul>";
                                echo "</li>";    
                            }
                            elseif ($_SESSION["type"] == 5) // for almacen
                            {
                               echo "<li>";
                                    echo "<a href='#'><i class='fa fa-barcode fa-fw'></i> Almacén <span class='fa arrow'></span></a>";
                                    echo "<ul class='nav nav-second-level'>
                                            <li>
                                                <a href='indexAlmacen.php'>Inventario</a>
                                            </li>
                                            
                                        </ul>";
                                echo "</li>";   
                            }
                            elseif ($_SESSION["type"] == 6) // for taller mecanico
                            {
                                echo "<li>";
                                    echo "<a href='#'><i class='fa fa-tasks fa-fw'></i> Disponibilidad <span class='fa arrow'></span></a>";
                                    echo "<ul class='nav nav-second-level'>
                                            <li>
                                                <a href='indexOt.php'>OT'S</a>
                                            </li>
                                            
                                            <li>
                                                <a href='indexDisponibilidad.php'>Disponibilidad</a>
                                            </li>
                                            <li>
                                                <a href='indexMpvsMc.php'>MP vs MC (*)</a>
                                            </li>
                                            <li>
                                                <a href='indexMpvsMcCritica.php'>MP vs MC (crítica)</a>
                                            </li>
                                            <li>
                                                <a href='indexMonitoreo.php?lider=41185'>Monitoreo mecánico</a>
                                            </li>
                                        </ul>";
                                echo "</li>";    
                            }
                            elseif ($_SESSION["type"] == 7) // for taller hidroelectrico
                            {
                                echo "<li>";
                                    echo "<a href='#'><i class='fa fa-tasks fa-fw'></i> Disponibilidad <span class='fa arrow'></span></a>";
                                    echo "<ul class='nav nav-second-level'>
                                            <li>
                                                <a href='indexOt.php'>OT'S</a>
                                            </li>
                                            
                                            <li>
                                                <a href='indexDisponibilidad.php'>Disponibilidad</a>
                                            </li>
                                            <li>
                                                <a href='indexMpvsMc.php'>MP vs MC (*)</a>
                                            </li>
                                            <li>
                                                <a href='indexMpvsMcCritica.php'>MP vs MC (crítica)</a>
                                            </li>
                                            <li>
                                                <a href='indexMonitoreo.php?lider=239'>Monitoreo hidroeléctrico</a>
                                            </li>
                                        </ul>";
                                echo "</li>";    
                            }
                            elseif ($_SESSION["type"] == 8) // for suelos
                            {
                                echo "<li>";
                                    echo "<a href='#'><i class='fa fa-tasks fa-fw'></i> Disponibilidad <span class='fa arrow'></span></a>";
                                    echo "<ul class='nav nav-second-level'>
                                            <!--li>
                                                <a href='indexOt.php'>OT'S</a>
                                            </li>
                                            
                                            <li>
                                                <a href='indexDisponibilidad.php'>Disponibilidad</a>
                                            </li>
                                            <li>
                                                <a href='indexMpvsMc.php'>MP vs MC (*)</a>
                                            </li>
                                            <li>
                                                <a href='indexMpvsMcCritica.php'>MP vs MC (crítica)</a>
                                            </li-->
                                            <li>
                                                <a href='indexMonitoreo.php?lider=15113'>Monitoreo suelos</a>
                                            </li>
                                        </ul>";
                                echo "</li>";    
                            }
                    	?>
                    </ul>
                </div>

            </div><!-- /sidebar menu --> 