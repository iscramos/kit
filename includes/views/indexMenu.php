			<!-- sidebar menu -->
                    <div id="sidebar-menu" class="main_menu_side hidden-print main_menu menu_fixed">
                      <div class="menu_section">
                        <h3>General</h3>
                        <ul class="nav side-menu">
                            
                    	<?php
                    		if ($_SESSION["type"] == 1) // for administrator
                    		{
                                echo "<li>
                                        <a href='indexMain.php'>
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
                                                <a href='indexMpvsMcCritica.php'>
                                                <i class='fa fa-truck' aria-hidden='true'></i> MP vs MC (crítica)</a>
                                            </li>";
                                echo "<li>
                                        <a href='indexCumplimientoV2.php'> <i class='fa fa-area-chart' aria-hidden='true'></i> Cumplimiento v2</a>
                                    </li>";
                                   
                    		} 
                    		elseif ($_SESSION["type"] == 4) // for plásticos
                            {
                                echo "<li>
                                        <a href='indexMain.php'>
                                            <i class='fa fa-home'></i> Inicio 
                                            <span class='fa fa-chevron-down'></span>
                                        </a>
                                    </li>";
                                echo "<li><a><i class='fa fa-desktop'></i> Monitoreo <span class='fa fa-chevron-down'></span></a>
                                    <ul class='nav child_menu'>
                                        <li><a href='indexMonitoreo.php?lider=14993'>Plásticos</a></li>
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
                                        <a href='indexCumplimientoV2.php'> <i class='fa fa-area-chart' aria-hidden='true'></i> Cumplimiento v2</a>
                                    </li>";  
                            }
                            elseif ($_SESSION["type"] == 6) // for taller mecanico
                            {
                                echo "<li>
                                        <a href='indexMain.php'>
                                            <i class='fa fa-home'></i> Inicio 
                                            <span class='fa fa-chevron-down'></span>
                                        </a>
                                    </li>";
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
                                        <a href='indexCumplimientoV2.php'> <i class='fa fa-area-chart' aria-hidden='true'></i> Cumplimiento v2</a>
                                    </li>";    
                            }
                            elseif ($_SESSION["type"] == 7) // for taller hidroelectrico
                            {
                                echo "<li>
                                        <a href='indexMain.php'>
                                            <i class='fa fa-home'></i> Inicio 
                                            <span class='fa fa-chevron-down'></span>
                                        </a>
                                    </li>";
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
                                        <a href='indexCumplimientoV2.php'> <i class='fa fa-area-chart' aria-hidden='true'></i> Cumplimiento v2</a>
                                    </li>";   
                            }
                            elseif ($_SESSION["type"] == 8) // for suelos
                            {
                                echo "<li>
                                        <a href='indexMain.php'>
                                            <i class='fa fa-home'></i> Inicio 
                                            <span class='fa fa-chevron-down'></span>
                                        </a>
                                    </li>";
                                echo "<li><a><i class='fa fa-desktop'></i> Monitoreo <span class='fa fa-chevron-down'></span></a>
                                    <ul class='nav child_menu'>
                                        <li><a href='indexMonitoreo.php?lider=15113'>Suelos</a></li>
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
                                        <a href='indexCumplimientoV2.php'> <i class='fa fa-area-chart' aria-hidden='true'></i> Cumplimiento v2</a>
                                    </li>";   
                            }
                    	?>
                    </ul>
                </div>

            </div><!-- /sidebar menu --> 