<?php
//require_once $_SERVER["DOCUMENT_ROOT"].'/siscohistoraca2/__config.php';
require_once('includes/config.inc.php');
require_once('includes/inc.session.php');

//$bloques = Bloques::getById($id);
//print_r($bloques);
$str="";
if(isset($_GET['parametro']) && ($_SESSION["type"]==1 || $_SESSION["type"]==6 || $_SESSION["type"]==7)) // para el admimistrador
{   
    //$mes = $_GET['mes'];
    $ano = $_GET['ano'];

    /*$countPreventivos = Ordenesots::getAllMpByMesAnoCuentaPreventivoGeneral($ano);
    $countCorrectivos = Ordenesots::getAllMpByMesAnoCuentaCorrectivoGeneral($ano);

    $str.="<input type='number' class='hidden' value='".$countPreventivos[0]->nPreventivos."' id='nPreventivos' >";
    $str.="<input type='number' class='hidden' value='".$countCorrectivos[0]->nCorrectivos."' id='nCorrectivos' >";*/
    
    function getMinutes($fecha1, $fecha2)
    {
        $fecha1 = str_replace('/', '-', $fecha1);
        $fecha2 = str_replace('/', '-', $fecha2);
        $fecha1 = strtotime($fecha1);
        $fecha2 = strtotime($fecha2);
        return round( (($fecha2 - $fecha1) / 60) / 60, 1); //convirtiendo a horas
    }

    function nombreMes($mes)
    {
        switch ($mes) 
        {
        case 1:
            $mes = "ENERO";
            break;
        case 2:
            $mes = "FEBRERO";
            break;
        case 3:
            $mes = "MARZO";
            break;
        case 4:
            $mes = "ABRIL";
            break;
        case 5:
            $mes = "MAYO";
            break;
        case 6:
            $mes = "JUNIO";
            break;
        case 7:
            $mes = "JULIO";
            break;
        case 8:
            $mes = "AGOSTO";
            break;
        case 9:
            $mes = "SEPTIEMBRE";
            break;
        case 10:
            $mes = "OCTUBRE";
            break;
        case 11:
            $mes = "NOVIEMBRE";
            break;
        case 12:
            $mes = "DICIEMBRE";
            break;
        }

        return $mes;
        
    }


    $parametro = $_GET['parametro'];
 
    if($parametro == "DISPONIBILIDADGENERAL") // PARA LA DISPONIBILIDAD GENERAL DE TODO EL AÑO
    {
        //$str.="<h4 style='text-align:center;' >COMPORTAMIENTO DE MANTENIMIENTOS </h4>";
            $str.="<div class='row' id='graficoPorFamilia' >";
                /*$str.="<div class='col-md-12 col-md-12'>
                            <div class='panel panel-default'>
                                <div class='panel-heading'>
                                    Disponibilidad por familia
                                </div>
                                <!-- /.panel-heading -->
                                <div class='panel-body' style='font-size: 12px;'>
                                     <div id='graficoPorFamilia'></div>
                                </div>
                                <!-- /.panel-body -->
                            </div>
                            <!-- /.panel -->
                        </div>";*/
            $str.="</div><hr style='border-top: 1px dashed #8c8b8b;'>";

            $str.="<div class='row text-center'>";
                $str.="<div class='col-md-12 col-md-12'>
                            <button class='btn btn-default btn-md btn-success mesMuestra' valor='ENERO'>ENE</button>
                            <button class='btn btn-default btn-md btn-success mesMuestra' valor='FEBRERO'>FEB</button>
                            <button class='btn btn-default btn-md btn-success mesMuestra' valor='MARZO'>MAR</button>
                            <button class='btn btn-default btn-md btn-success mesMuestra' valor='ABRIL'>ABR</button>
                            <button class='btn btn-default btn-md btn-success mesMuestra' valor='MAYO'>MAY</button>
                            <button class='btn btn-default btn-md btn-success mesMuestra' valor='JUNIO'>JUN</button>
                            <button class='btn btn-default btn-md btn-success mesMuestra' valor='JULIO'>JUL</button>
                            <button class='btn btn-default btn-md btn-success mesMuestra' valor='AGOSTO'>AGO</button>
                            <button class='btn btn-default btn-md btn-success mesMuestra' valor='SEPTIEMBRE'>SEP</button>
                            <button class='btn btn-default btn-md btn-success mesMuestra' valor='OCTUBRE'>OCT</button>
                            <button class='btn btn-default btn-md btn-success mesMuestra' valor='NOVIEMBRE'>NOV</button>
                            <button class='btn btn-default btn-md btn-success mesMuestra' valor='DICIEMBRE'>DIC</button>
                        </div>";
                $str.="</div><hr style='border-top: 1px dashed #8c8b8b;'>";

            $str.="<div class='row hidden'>";
                $str.="<div class='col-md-12 col-sm-12'>
                        <div class='panel panel-default'>
                            <div class='panel-heading'>
                                Mantenimientos Totales en el mes
                            </div>
                            <!-- /.panel-heading -->
                            <div class='panel-body'>
                                 <div id='tMantenimiento'></div>
                            </div>
                            <!-- /.panel-body -->
                        </div>
                        <!-- /.panel -->
                    </div>";

                    
            $str.="</div>";
            
        $mesesdelAno = Calendario_nature::getAllMeses();
        foreach ($mesesdelAno as $mesdelano) 
        {
            $mes = $mesdelano->mes;
            //$mps = Ordenesots::getAllMpByMesAno($mes, $ano);


            $weeks = null;
            $weeks = Calendario_nature::getAllMesCount($mes);
            $weeks = $weeks[0]->weeks;

            $nombreMes = nombreMes(intval($mes));
            //echo $nombreMes;

        $str.="<table class='table table-bordered table-hover hidden todos$nombreMes' id='original' > ";

            $str.="<thead>
                    <tr>";
                $str.="<!--th style='min-width: 40px;'>#</th--> 
                        <th style='min-width: 150px;'>EQUIPO</th>
                        <th class='hidden'>A</th>
                        <th class='hidden'>B</th>
                        <th class='hidden'>C</th>
                        <th class='hidden'>D</th>
                        <th class='hidden'>E</th>
                        <th class='hidden'>F</th>
                        <th>A</th>
                        <th>B</th>
                        <th>C</th>
                        <th>D</th>
                        <th>E</th>
                        <th>F</th>

                        <th class='hidden' >IDEAL TOTAL TIME MP</th>
                        <th >REAL TOTAL TIME MP</th>
                        <th class='hidden'>EXTRA TIME MP</th>
                        <th class='hidden'>FAILS FOR EXTRA TIME MP</th>
                        <th class='hidden'>MTTR EXTRA TIME MP</th>
                        
                        <th >TIME TO REPAIR</th>
                        <th class='hidden'>TOTAL TIME TO REPAIR</th>
                        <th class='hidden'>REAL-TIME OPERATION</th>
                        <th class='hidden'>FAILS</th>
                        <th >TOTAL FAILS</th>
                        <th class='hidden'>MIDDLE TIME TO REPAIR</th>
                        <th class='hidden'>MIDDLE TIME BEFORE FAILURE</th>
                        <th >DISPONIBILITY</th>
                        <th >ACTION</th>
                        ";
            $str.="</tr>
            </thead>
            <tbody>";
            $familias = Activos_equipos::getAllFamilia();
            $mps = Ordenesots::getAllMpByMesAno($mes, $ano);
            if(count($mps) > 0)
            {
                foreach ($familias as $familia) 
                {
                    $equipos = activos_equipos::getAllEquiposFamilia($familia->familia);

                    foreach ($equipos as $equipo) 
                    {
                        //echo "entro";
                        $str.="<tr class='".$equipo->familia."'>";
                            //$str.="<!--td  class='spec'>$i</td-->";
                            $str.="<td>".$equipo->nombre_equipo."</td>";
                            
                            $idealA = null;
                            $idealB = null;
                            $idealC = null;
                            $idealD = null;
                            $idealE = null;
                            $idealF = null;

                            $realA = null;
                            $realB = null;
                            $realC = null;
                            $realD = null;
                            $realE = null;
                            $realF = null;

                            $idealTotalTimeMp = 0;
                            $realTotalTimeMp = 0;

                            $tiempoIdeal = MpIdeales::getAllInnerActivos($equipo->nombre_equipo, $mes, $ano);
                            //print_r($tiempoIdeal);

                            if(empty($tiempoIdeal))
                            {
                                $str.="<td class='idealA hidden'>
                                        <button type='button' class='btn btn-success btn-circle btn-md' title='MP ideal A'  >0</button>
                                    </td>";
                                $str.="<td class='idealB hidden'>
                                        <button type='button' class='btn btn-success btn-circle btn-md' title='MP ideal B'  >0</button>
                                    </td>";
                                $str.="<td class='idealC hidden'>
                                        <button type='button' class='btn btn-success btn-circle btn-md' title='MP ideal C'  >0</button>
                                    </td>";
                                $str.="<td class='idealD hidden'>
                                        <button type='button' class='btn btn-success btn-circle btn-md' title='MP ideal D'  >0</button>
                                    </td>";
                                $str.="<td class='idealE hidden'>
                                        <button type='button' class='btn btn-success btn-circle btn-md' title='MP ideal E'  >0</button>
                                    </td>";
                                $str.="<td class='idealF hidden'>
                                        <button type='button' class='btn btn-success btn-circle btn-md' title='MP ideal F'  >0</button>
                                    </td>";
                            }
                            else
                            {
                                foreach ($tiempoIdeal as $ideal) 
                                {
                                    $idealA = $ideal->A;
                                    $idealB = $ideal->B;
                                    $idealC = $ideal->C;
                                    $idealD = $ideal->D;
                                    $idealE = $ideal->E;
                                    $idealF = $ideal->F;
                                    //echo $ideal->id."<br>";
                                    $str.="<td class='idealA hidden'>
                                            <button type='button' class='btn btn-success btn-circle btn-md' title='MP ideal A'  >".$idealA."</button>
                                        </td>";
                                    $str.="<td class='idealB hidden'>
                                            <button type='button' class='btn btn-success btn-circle btn-md' title='MP ideal B'  >".$idealB."</button>
                                        </td>";
                                    $str.="<td class='idealC hidden'>
                                            <button type='button' class='btn btn-success btn-circle btn-md' title='MP ideal C'  >".$idealC."</button>
                                        </td>";
                                    $str.="<td class='idealD hidden'>
                                            <button type='button' class='btn btn-success btn-circle btn-md' title='MP ideal D'  >".$idealD."</button>
                                        </td>";
                                    $str.="<td class='idealE hidden'>
                                            <button type='button' class='btn btn-success btn-circle btn-md' title='MP ideal E'  >".$idealE."</button>
                                        </td>";
                                    $str.="<td class='idealF hidden'>
                                            <button type='button' class='btn btn-success btn-circle btn-md' title='MP ideal F'  >".$idealF."</button>
                                        </td>";
                                }
                                //$idealTotalTimeMp = $idealA + $idealB + $idealC + $idealD + $idealE + $idealF;
                                //echo $idealTotalTimeMp;
                            }

                            $ordenesmp = Ordenesots::getAllMpByMesAnoEquipo($mes, $ano, $equipo->nombre_equipo);

                            $encuentraA = null;
                            $encuentraB = null;
                            $encuentraC = null;
                            $encuentraD = null;
                            $encuentraE = null;
                            $encuentraF = null;
                            
                            if(empty($ordenesmp))
                            {
                                $str.="<td class='realA'>
                                    <button type='button' class='btn btn-default btn-circle btn-md' colorIdentificador='nada' title='MP real A'  >0</button>
                                </td>";
                                $str.="<td class='realB'>
                                    <button type='button' class='btn btn-default btn-circle btn-md' colorIdentificador='nada' title='MP real B'  >0</button>
                                </td>";
                                $str.="<td class='realC'>
                                    <button type='button' class='btn btn-default btn-circle btn-md' colorIdentificador='nada' title='MP real C'  >0</button>
                                </td>";
                                $str.="<td class='realD'>
                                    <button type='button' class='btn btn-default btn-circle btn-md' colorIdentificador='nada' title='MP real D'  >0</button>
                                </td>";
                                $str.="<td class='realE'>
                                    <button type='button' class='btn btn-default btn-circle btn-md' colorIdentificador='nada' title='MP real E'  >0</button>
                                </td>";
                                $str.="<td class='realF'>
                                    <button type='button' class='btn btn-default btn-circle btn-md' colorIdentificador='nada' title='MP real F'  >0</button>
                                </td>";
                            }
                            else
                            {
                                foreach ($ordenesmp as $ordenmp) 
                                {
                                    $findA = stripos($ordenmp->descripcion, "TIPO \"A\"");
                                    if ($findA !== false) 
                                    {
                                        //$realA = round(($ordenmp->tiempoReal) / 60);

                                        //$encuentraA = 1;
                                        /*echo $equipo->nombre_equipo."->".$ordenmp->fecha_inicio."..".$ordenmp->fecha_finalizacion."<br>";*/
                                        if($ordenmp->fecha_inicio == "0000-00-00 00:00:00")
                                        {
                                            $fechaHoy = null;
                                            $fechaHoy = date("Y-m-d H:i:s");
                                            if($ordenmp->fecha_inicio_programada > $fechaHoy)
                                            {
                                                $realA = 0;
                                            }
                                            else
                                            {
                                                $realA = getMinutes($ordenmp->fecha_inicio_programada, $fechaHoy);
                                            }
                                            
                                            
                                            $encuentraA = 1;
                                        }
                                        else if($ordenmp->fecha_finalizacion == "0000-00-00 00:00:00" && $ordenmp->fecha_inicio != "0000-00-00 00:00:00")
                                        {
                                            
                                            $fechaHoy = null;
                                            $fechaHoy = date("Y-m-d H:i:s");
                                            $realA = getMinutes($ordenmp->fecha_inicio, $fechaHoy);
                                            
                                            $encuentraA = 1;
                                            
                                        }
                                        else
                                        {
                                            $fechaHoy = null;
                                            $fechaHoy = date("Y-m-d H:i:s");
                                            $realA = getMinutes($ordenmp->fecha_inicio, $ordenmp->fecha_finalizacion);

                                            $encuentraA = 1;
                                        }
                                        //echo $realA;
                                    }

                                    $findB = stripos($ordenmp->descripcion, "TIPO \"B\"");
                                    if ($findB !== false) 
                                    {

                                        if($ordenmp->fecha_inicio == "0000-00-00 00:00:00")
                                        {
                                            $fechaHoy = null;
                                            $fechaHoy = date("Y-m-d H:i:s");
                                            if($ordenmp->fecha_inicio_programada > $fechaHoy)
                                            {
                                                $realB = 0;
                                            }
                                            else
                                            {
                                                $realB = getMinutes($ordenmp->fecha_inicio_programada, $fechaHoy);
                                            }
                                            
                                            $encuentraB = 1;
                                        }
                                        else if($ordenmp->fecha_finalizacion == "0000-00-00 00:00:00" && $ordenmp->fecha_inicio != "0000-00-00 00:00:00")
                                        {
                                            
                                            $fechaHoy = null;
                                            $fechaHoy = date("Y-m-d H:i:s");
                                            $realB = getMinutes($ordenmp->fecha_inicio, $fechaHoy);
                                            
                                            $encuentraB = 1;
                                            
                                        }
                                        else
                                        {
                                            $fechaHoy = null;
                                            $fechaHoy = date("Y-m-d H:i:s");
                                            $realB = getMinutes($ordenmp->fecha_inicio, $ordenmp->fecha_finalizacion);

                                            $encuentraB = 1;
                                        }
                                    }

                                    $findC = stripos($ordenmp->descripcion, "TIPO \"C\"");
                                    if ($findC !== false) 
                                    {
                                        if($ordenmp->fecha_inicio == "0000-00-00 00:00:00")
                                        {
                                            $fechaHoy = null;
                                            $fechaHoy = date("Y-m-d H:i:s");
                                            if($ordenmp->fecha_inicio_programada > $fechaHoy)
                                            {
                                                $realC = 0;
                                            }
                                            else
                                            {
                                                $realC = getMinutes($ordenmp->fecha_inicio_programada, $fechaHoy);
                                            }
                                            
                                            $encuentraC = 1;
                                        }
                                        else if($ordenmp->fecha_finalizacion == "0000-00-00 00:00:00" && $ordenmp->fecha_inicio != "0000-00-00 00:00:00")
                                        {
                                            
                                            $fechaHoy = null;
                                            $fechaHoy = date("Y-m-d H:i:s");
                                            $realC = getMinutes($ordenmp->fecha_inicio, $fechaHoy);
                                            
                                            $encuentraC = 1;
                                            
                                        }
                                        else
                                        {
                                            $fechaHoy = null;
                                            $fechaHoy = date("Y-m-d H:i:s");
                                            $realC = getMinutes($ordenmp->fecha_inicio, $ordenmp->fecha_finalizacion);

                                            $encuentraC = 1;
                                        }
                                    }

                                    $findD = stripos($ordenmp->descripcion, "TIPO \"D\"");
                                    if ($findD !== false) 
                                    {
                                        if($ordenmp->fecha_inicio == "0000-00-00 00:00:00")
                                        {
                                            $fechaHoy = null;
                                            $fechaHoy = date("Y-m-d H:i:s");
                                            if($ordenmp->fecha_inicio_programada > $fechaHoy)
                                            {
                                                $realD = 0;
                                            }
                                            else
                                            {
                                                $realD = getMinutes($ordenmp->fecha_inicio_programada, $fechaHoy);
                                            };
                                            
                                            $encuentraD = 1;
                                        }
                                        else if($ordenmp->fecha_finalizacion == "0000-00-00 00:00:00" && $ordenmp->fecha_inicio != "0000-00-00 00:00:00")
                                        {
                                            
                                            $fechaHoy = null;
                                            $fechaHoy = date("Y-m-d H:i:s");
                                            $realD = getMinutes($ordenmp->fecha_inicio, $fechaHoy);
                                            
                                            $encuentraD = 1;
                                            
                                        }
                                        else
                                        {
                                            $fechaHoy = null;
                                            $fechaHoy = date("Y-m-d H:i:s");
                                            $realD = getMinutes($ordenmp->fecha_inicio, $ordenmp->fecha_finalizacion);

                                            $encuentraD = 1;
                                        }
                                    }

                                    $findE = stripos($ordenmp->descripcion, "TIPO \"E\"");
                                    if ($findE !== false) 
                                    {
                                        if($ordenmp->fecha_inicio == "0000-00-00 00:00:00")
                                        {
                                            $fechaHoy = null;
                                            $fechaHoy = date("Y-m-d H:i:s");
                                            if($ordenmp->fecha_inicio_programada > $fechaHoy)
                                            {
                                                $realE = 0;
                                            }
                                            else
                                            {
                                                $realE = getMinutes($ordenmp->fecha_inicio_programada, $fechaHoy);
                                            }
                                        }
                                        else if($ordenmp->fecha_finalizacion == "0000-00-00 00:00:00" && $ordenmp->fecha_inicio != "0000-00-00 00:00:00")
                                        {
                                            
                                            $fechaHoy = null;
                                            $fechaHoy = date("Y-m-d H:i:s");
                                            $realE = getMinutes($ordenmp->fecha_inicio, $fechaHoy);
                                            
                                            $encuentraE = 1;
                                            
                                        }
                                        else
                                        {
                                            $fechaHoy = null;
                                            $fechaHoy = date("Y-m-d H:i:s");
                                            $realE = getMinutes($ordenmp->fecha_inicio, $ordenmp->fecha_finalizacion);

                                            $encuentraE = 1;
                                        }
                                    }

                                    $findF = stripos($ordenmp->descripcion, "TIPO \"F\"");
                                    if ($findF !== false) 
                                    {
                                        if($ordenmp->fecha_inicio == "0000-00-00 00:00:00")
                                        {
                                            $fechaHoy = null;
                                            $fechaHoy = date("Y-m-d H:i:s");
                                            if($ordenmp->fecha_inicio_programada > $fechaHoy)
                                            {
                                                $realF = 0;
                                            }
                                            else
                                            {
                                                $realF = getMinutes($ordenmp->fecha_inicio_programada, $fechaHoy);
                                            }
                                            
                                            $encuentraF = 1;
                                        }
                                        else if($ordenmp->fecha_finalizacion == "0000-00-00 00:00:00" && $ordenmp->fecha_inicio != "0000-00-00 00:00:00")
                                        {
                                            
                                            $fechaHoy = null;
                                            $fechaHoy = date("Y-m-d H:i:s");
                                            $realF = getMinutes($ordenmp->fecha_inicio, $fechaHoy);
                                            
                                            $encuentraF = 1;
                                            
                                        }
                                        else
                                        {
                                            $fechaHoy = null;
                                            $fechaHoy = date("Y-m-d H:i:s");
                                            $realF = getMinutes($ordenmp->fecha_inicio, $ordenmp->fecha_finalizacion);

                                            $encuentraF = 1;
                                        }
                                    }               
                                }

                                
                                if($encuentraA == 1 && ($realA > $idealA) ) $str.="<td class='realA' ><button class='btn btn-danger btn-circle btn-md' title='MP real A'  colorIdentificador='rojo'>".$realA."</button></td>";
                                else if($encuentraA == 1 && ($realA <= $idealA) ) $str.="<td class='realA' ><button class='btn btn-default btn-circle btn-md' title='MP real A'  colorIdentificador='nada'>".$realA."</button></td>";
                                else $str.="<td class='realA' ><button class='btn btn-default btn-circle btn-md' title='MP real A'  colorIdentificador='nada'>0</button></td>";

                                if($encuentraB == 1 && ($realB > $idealB) ) $str.="<td class='realB' ><button class='btn btn-danger btn-circle btn-md' title='MP real B'  colorIdentificador='rojo'>".$realB."</button></td>";
                                else if($encuentraB == 1 && ($realB <= $idealB) ) $str.="<td class='realB' ><button class='btn btn-default btn-circle btn-md' title='MP real B'  colorIdentificador='nada'>".$realB."</button></td>";
                                else $str.="<td class='realB' ><button class='btn btn-default btn-circle btn-md' title='MP real B'  colorIdentificador='nada'>0</button></td>";

                                if($encuentraC == 1 && ($realC > $idealC)) $str.="<td class='realC' ><button class='btn btn-danger btn-circle btn-md' title='MP real C'  colorIdentificador='rojo'>".$realC."</button></td>";
                                else if($encuentraC == 1 && ($realC <= $idealC)) $str.="<td class='realC' ><button class='btn btn-default btn-circle btn-md' title='MP real C'  colorIdentificador='nada'>".$realC."</button></td>";
                                else $str.="<td class='realC' ><button class='btn btn-default btn-circle btn-md' title='MP real C'  colorIdentificador='nada'>0</button></td>";

                                if($encuentraD == 1 && ($realD > $idealD)) $str.="<td class='realD' ><button class='btn btn-danger btn-circle btn-md' title='MP real D'  colorIdentificador='rojo'>".$realD."</button></td>";
                                else if($encuentraD == 1 && ($realD <= $idealD)) $str.="<td class='realD' ><button class='btn btn-default btn-circle btn-md' title='MP real D'  colorIdentificador='nada'>".$realD."</button></td>";
                                else $str.="<td class='realD' ><button class='btn btn-default btn-circle btn-md' title='MP real D'  colorIdentificador='nada'>0</button></td>";

                                if($encuentraE == 1 && ($realE > $idealE)) $str.="<td class='realE' ><button class='btn btn-danger btn-circle btn-md' title='MP real E'  colorIdentificador='rojo'>".$realE."</button></td>";
                                else if($encuentraE == 1 && ($realE <= $idealE)) $str.="<td class='realE' ><button class='btn btn-default btn-circle btn-md' title='MP real E'  colorIdentificador='nada'>".$realE."</button></td>";
                                else $str.="<td class='realE' ><button class='btn btn-default btn-circle btn-md' title='MP real E'  colorIdentificador='nada'>0</button></td>";

                                if($encuentraF == 1 && ($realF > $idealF)) $str.="<td class='realF' ><button class='btn btn-danger btn-circle btn-md' title='MP real F'  colorIdentificador='rojo'>".$realF."</button></td>";
                                else if($encuentraF == 1 && ($realF <= $idealF)) $str.="<td class='realF' ><button class='btn btn-default btn-circle btn-md' title='MP real F'  colorIdentificador='nada'>".$realF."</button></td>";
                                else $str.="<td class='realF' ><button class='btn btn-default btn-circle btn-md' title='MP real F'  colorIdentificador='nada'>0</button></td>";

                                
                                $realTotalTimeMp = $realA + $realB + $realC + $realD + $realE + $realF;
                            }   
                            
                            if($realA > 0)
                            {
                                $idealTotalTimeMp = $idealTotalTimeMp + $idealA;
                            }
                            if($realB > 0)
                            {
                                $idealTotalTimeMp = $idealTotalTimeMp + $idealB;
                            }
                            if($realC > 0)
                            {
                                $idealTotalTimeMp = $idealTotalTimeMp + $idealC;
                            }
                            if($realD > 0)
                            {
                                $idealTotalTimeMp = $idealTotalTimeMp + $idealD;
                            }
                            if($realE > 0)
                            {
                                $idealTotalTimeMp = $idealTotalTimeMp + $idealE;
                            }
                            if($realF > 0)
                            {
                                $idealTotalTimeMp = $idealTotalTimeMp + $idealF;
                            }
                            
                            $str.="<td class='idealTotalTimeMp hidden' >
                                <button type='button' class='btn btn-success btn-circle btn-md' title='Ideal Total Time Mp'  >".$idealTotalTimeMp."</button>
                            </td>";

                            if($realTotalTimeMp == 0)
                            {
                                $str.="<td class='realTotalTimeMp'>
                                <button type='button' class='btn btn-default btn-circle btn-md' title='Real Total Time Mp'  >".$realTotalTimeMp."</button>
                                </td>"; 
                            }
                            else
                            {
                                $str.="<td class='realTotalTimeMp'>
                                <button type='button' class='btn btn-warning btn-circle btn-md' title='Real Total Time Mp'  >".$realTotalTimeMp."</button>
                                </td>";
                            }
                             
                            
                            

                            $extraTimeMp = 0;
                            if($realTotalTimeMp > $idealTotalTimeMp)
                            {
                                $extraTimeMp = $realTotalTimeMp - $idealTotalTimeMp;
                                //echo $extraTimeMp;
                                $str.="<td class='extraTimeMp hidden'>
                                <button type='button' class='btn btn-info btn-circle btn-md' title='Extra Time Mp'  >".$extraTimeMp."</button>
                                </td>";
                            }
                            else
                            {
                                $str.="<td class='extraTimeMp hidden'>
                                <button type='button' class='btn btn-info btn-circle btn-md' title='Extra Time Mp'  >".$extraTimeMp."</button>
                                </td>";
                            }

                            // FAILS FOR EXTRA TIME MP
                            $failsForExtraTimeMp = 0;
                            if ($realA > $idealA) 
                            {
                                $failsForExtraTimeMp ++;
                            }
                            if ($realB > $idealB) 
                            {
                                $failsForExtraTimeMp ++;
                            }
                            if ($realC > $idealC) 
                            {
                                $failsForExtraTimeMp ++;
                            }
                            if ($realD > $idealD) 
                            {
                                $failsForExtraTimeMp ++;
                            }
                            if ($realE > $idealE) 
                            {
                                $failsForExtraTimeMp ++;
                            }
                            if ($realF > $idealF) 
                            {
                                $failsForExtraTimeMp ++;
                            }

                            $str.="<td class='failsForExtraTimeMp hidden' >
                                <button type='button' class='btn btn-danger btn-circle btn-md' title='Fails For Extra Time Mp'  >".$failsForExtraTimeMp."</button>
                            </td>";

                            //MTTR EXTRA TIME MP
                            $mttrExtraTimeMp = 0;
                            if($failsForExtraTimeMp > 0)
                            {
                                $mttrExtraTimeMp = round($extraTimeMp / $failsForExtraTimeMp, 1);
                            }
                            $str.="<td class='mttrExtraTimeMp hidden'>
                                <button type='button' class='btn btn-primary btn-circle btn-md' title='Mttr Extra Time Mp'  >".$mttrExtraTimeMp."</button>
                            </td>";

                            
                            //TIME TO REPAIR CORRECTIVO
                            $timeToRepair = 0;
                            $ordenesmc = Ordenesots::getAllMpByMesAnoEquipoCorrectivo($mes, $ano, $equipo->nombre_equipo);
                            $cuentaFails = 0; // pasa despues saber cuantas fallas hubo de este equipo
                            //print_r($ordenesmc);
                            //die("s");
                            if(empty($ordenesmc))
                            {
                                $str.="<td class='timeToRepair'>
                                    <button type='button' class='btn btn-default btn-circle btn-md' title='Time To Repair'  >0</button>
                                </td>";
                            }
                            else
                            {
                                foreach ($ordenesmc as $mc) 
                                {
                                    

                                    $fechaHoy = null;
                                    $fechaHoy = date("Y-m-d H:i:s");

                                    if($mc->fecha_inicio_programada <= $fechaHoy)
                                    {
                                    
                                        if($mc->fecha_inicio == "0000-00-00 00:00:00" )
                                        {
                                            $timeToRepair = $timeToRepair + getMinutes($mc->fecha_inicio_programada, $fechaHoy);
                                            $cuentaFails ++;    
                                            
                                        }
                                        else if($mc->fecha_finalizacion == "0000-00-00 00:00:00" && $mc->fecha_inicio != "0000-00-00 00:00:00" ) // para cuando no existe aún la fecha de finalización
                                        {
                                            $timeToRepair = $timeToRepair + getMinutes($mc->fecha_inicio, $fechaHoy );
                                            $cuentaFails ++;                            
                                        }
                                        else
                                        {
                                            
                                            
                                            $timeToRepair = $timeToRepair + getMinutes($mc->fecha_inicio, $mc->fecha_finalizacion);
                                            $cuentaFails ++;    
                                        }
                                    }

                                    
                                }

                                $str.="<td class='timeToRepair'>
                                    <button type='button' class='btn btn-default btn-circle btn-md' title='Time To Repair'  >".$timeToRepair."</button>
                                </td>";
                            }

                            //TOTAL TIME TO REPAIR
                            $totalTimeToRepair = 0;
                            $totalTimeToRepair = round($timeToRepair + $mttrExtraTimeMp, 1);

                            $str.="<td class='totalTimeToRepair hidden'>
                                    <button type='button' class='btn btn-success btn-circle btn-md' title='Total Time To Repair'  >".$totalTimeToRepair."</button>
                            </td>";

                            //REAL-TIME OPERATION
                            $realTimeOperation = 0;
                            $totalOperacionSemanal = Activos_equipos::getAllTiempoBaseEquipo($equipo->nombre_equipo);
                            if(count($totalOperacionSemanal) > 0)
                            {
                                
                                $realTimeOperation = round( (( ($totalOperacionSemanal->tiempoBaseOperacion * $weeks )/ 60) ) - $totalTimeToRepair, 1);
                            }

                            $str.="<td class='realTimeOperation hidden'>
                                <button type='button' class='btn btn-warning btn-circle btn-md' title='Real Time Operation'  >".$realTimeOperation."</button>
                            </td>";

                            //FAILS CORRECTIVAS
                            $fails = null;
                            $fails = $cuentaFails;
                            $str.="<td class='fails hidden'>
                                <button type='button' class='btn btn-danger btn-circle btn-md' title='Fails Corrective'  >".$fails."</button>
                            </td>";

                            //TOTAL FAILS CORRECTIVAS
                            $totalFails = 0;
                            $totalFails = $failsForExtraTimeMp + $fails;
                            $str.="<td class='totalFails'>
                                <button type='button' class='btn btn-danger btn-circle btn-md' title='Total Fails'  >".$totalFails."</button>
                            </td>";

                            //MIDDLE TIME TO REPAIR
                            $middleTimeToRepair = 0;

                            if($totalFails != 0 ) // para la division entre 0
                            {
                                $middleTimeToRepair = round($totalTimeToRepair / $totalFails, 1);
                            }
                            
                            $str.="<td class='middleTimeToRepair hidden'>
                                <button type='button' class='btn btn-success btn-circle btn-md' title='Middle Time To Repair'  >".$middleTimeToRepair."</button>
                            </td>";

                            //MIDDLE TIME BEFORE FAILURE
                            $middleTimeBeforeFailure = 0;
                            if($totalFails != 0)
                            {
                                $middleTimeBeforeFailure = round( ($realTimeOperation - $idealTotalTimeMp) / $totalFails, 1);
                            }
                            $str.="<td class='middleTimeBeforeFailure hidden'>
                                <button type='button' class='btn btn-warning btn-circle btn-md' title='Middle Time Before Failure'  >".$middleTimeBeforeFailure."</button>
                            </td>";

                            $disponibility = 0;
                            if( ($middleTimeToRepair + $middleTimeBeforeFailure) != 0 )
                            {
                                $disponibility = $middleTimeBeforeFailure / ($middleTimeToRepair + $middleTimeBeforeFailure);

                                if($disponibility > 1)
                                {
                                    $disponibility = $disponibility / 100;
                                }
                                $disponibility = round($disponibility * 100, 1);
                            }
                            else
                            {
                                $disponibility = round(1 * 100, 1); // para los porcentajes de disponibility redondeando
                            }

                            // ------------- para cuando es negativo 
                                if($disponibility < 0)
                                {
                                    $disponibility = 0;
                                }
                            // --------------

                            if($disponibility == 100 || $disponibility >= 90)
                            {
                                $str.="<td class='disponibility'>
                                            <div class='progress'>
                                              <div class='porcentaje progress-bar progress-bar-success progress-bar-striped' role='progressbar' aria-valuenow='$disponibility' aria-valuemin='0' aria-valuemax='100' style='width: $disponibility%;' data-valor='$disponibility' >$disponibility%
                                              </div>
                                            </div>
                                        </td>";
                            }
                            elseif ($disponibility  < 90 && $disponibility >= 50 ) 
                            {
                                $str.="<td class='disponibility'>
                                            <div class='progress'>
                                              <div class='porcentaje progress-bar progress-bar-warning progress-bar-striped' role='progressbar' aria-valuenow='$disponibility' aria-valuemin='0' aria-valuemax='100' style='width: $disponibility%' data-valor='$disponibility'>$disponibility%
                                              </div>
                                            </div>
                                        </td>";
                            }

                            if ($disponibility < 50 ) 
                            {
                                $str.="<td class='disponibility'>
                                            <div class='progress'>
                                              <div class='porcentaje progress-bar progress-bar-danger progress-bar-striped' role='progressbar' aria-valuenow='$disponibility' aria-valuemin='0' aria-valuemax='100' style='width: $disponibility%' data-valor='$disponibility'>$disponibility%
                                              </div>
                                            </div>
                                        </td>";
                            }
                            

                            $str.="<td>
                                            <button title='Ver mantenimientos' class='detalles_equipo_".$equipo->nombre_equipo." btn btn-info btn-md' parametroDetalle='".$equipo->nombre_equipo."'>
                                                <i class='fa fa-eye' aria-hidden='true' ></i> 
                                            </button>
                                        </td>";
                            
                            

                        $str.="</tr>";
                        //$i++;
                    }

            }
        }
            
           
        $str.="</tbody>
            </table>";

        // --- PARA HACER EL CONCENTRADO POR AREAS
        $str.="<h4 style='text-align:center;' class='hidden cabecera$nombreMes mesShow'>$nombreMes</h4>";
        $str.="<input class='total$nombreMes form-control hidden' value=''>";

        $str.="<h4 style='text-align:center;' class='totalDiponibility$nombreMes porcentaje$nombreMes mesShow hidden'>TOTAL DISPONIBILITY FOR FAMILIES </h4>";
        $str.="<table class='table table-bordered dataTables_wrapper jambo_table bulk_action familia$nombreMes mesShow hidden' id='disponibilityForFamily' style='font-size: 10px;'>";
            $str.="<thead >
                    <tr >
                        <!--th style='min-width: 20px;'>#</th--> 
                        <th >AREA</th>
                        <th class='hidden'>A</th>
                        <th class='hidden'>B</th>
                        <th class='hidden'>C</th>
                        <th class='hidden'>D</th>
                        <th class='hidden'>E</th>
                        <th class='hidden'>F</th>

                        <th>A</th>
                        <th>B</th>
                        <th>C</th>
                        <th>D</th>
                        <th>E</th>
                        <th>F</th>

                        <th class='hidden'>IDEAL TOTAL TIME MP</th>
                        <th>REAL TOTAL TIME MP</th>
                        <th class='hidden'>EXTRA TIME MP</th>
                        <th class='hidden'>FAILS FOR EXTRA TIME MP</th>
                        <th class='hidden'>MTTR EXTRA TIME MP</th>
                        
                        <th>TIME TO REPAIR</th>
                        <th class='hidden'>TOTAL TIME TO REPAIR</th>
                        <th class='hidden'>REAL-TIME OPERATION</th>
                        <th class='hidden'>FAILS</th>
                        <th>TOTAL FAILS</th>
                        <th class=''>MIDDLE TIME TO REPAIR</th>
                        <th class=''>MIDDLE TIME BEFORE FAILURE</th>
                        <th>DISPONIBILITY</th>
                        <th>ACTION</th>
                    </tr>";

            $str.="</thead>
                    <tbody>";
                        $familias = Activos_equipos::getAllFamilia();
                        $f = 1;
                        foreach ($familias as $familia) 
                        {
                            $str.="<tr>";
                                $str.="<!--td class='spec'>".$f."</td-->";
                                $str.="<td class='spec'>".$familia->familia."</td>";

                                $str.="<td class='spec  hidden ".$familia->familia."_ideal_A_familia'>
                                                <button type='button' class='btn btn-success btn-circle btn-sm' title='MP ideal A'  >
                                                
                                                </button>
                                        </td>";
                                $str.="<td class='spec  hidden ".$familia->familia."_ideal_B_familia'>
                                                <button type='button' class='btn btn-success btn-circle btn-sm' title='MP ideal B'  >

                                                </button>
                                        </td>";
                                $str.="<td class='spec hidden  ".$familia->familia."_ideal_C_familia'>
                                                <button type='button' class='btn btn-success btn-circle btn-sm' title='MP ideal C'  >

                                                </button>
                                        </td>";
                                $str.="<td class='spec  hidden ".$familia->familia."_ideal_D_familia'>
                                                <button type='button' class='btn btn-success btn-circle btn-sm' title='MP ideal D'  >

                                                </button>
                                        </td>";
                                $str.="<td class='spec  hidden ".$familia->familia."_ideal_E_familia'>
                                                <button type='button' class='btn btn-success btn-circle btn-sm' title='MP ideal E'  >

                                                </button>
                                        </td>";
                                $str.="<td class='spec  hidden ".$familia->familia."_ideal_F_familia'>
                                                <button type='button' class='btn btn-success btn-circle btn-sm' title='MP ideal F'  >

                                                </button>
                                        </td>";
                            

                            // ===============================================================
                            // TIEMPOS MC REAL
                            // ===============================================================

                                $str.="<td class='spec ".$familia->familia."_real_A_familia'>
                                                <button type='button' class='btn btn-default btn-circle btn-sm' title='MP real A'  >
                                                
                                                </button>
                                        </td>";
                                $str.="<td class='spec ".$familia->familia."_real_B_familia'>
                                                <button type='button' class='btn btn-default btn-circle btn-sm' title='MP real B'  >

                                                </button>
                                        </td>";
                                $str.="<td class='spec ".$familia->familia."_real_C_familia'>
                                                <button type='button' class='btn btn-default btn-circle btn-sm' title='MP real C'  >

                                                </button>
                                        </td>";
                                $str.="<td class='spec ".$familia->familia."_real_D_familia'>
                                                <button type='button' class='btn btn-default btn-circle btn-sm' title='MP real D'  >

                                                </button>
                                        </td>";
                                $str.="<td class='spec ".$familia->familia."_real_E_familia'>
                                                <button type='button' class='btn btn-default btn-circle btn-sm' title='MP real E'  >

                                                </button>
                                        </td>";
                                $str.="<td class='spec ".$familia->familia."_real_F_familia'>
                                                <button type='button' class='btn btn-default btn-circle btn-sm' title='MP real F'  >

                                                </button>
                                        </td>";

                            // ===============================================================
                            // idealTotalTimeMp
                            // ===============================================================
                                $str.="<td class='spec hidden ".$familia->familia."_idealTotalTimeMp_familia'>
                                                <button type='button' class='btn btn-success btn-circle btn-sm' title='Ideal Total Time Mp'  >

                                                </button>
                                        </td>";
                            // ===============================================================
                            // idealTotalTimeMp
                            // ===============================================================

                                $str.="<td class='spec ".$familia->familia."_realTotalTimeMp_familia'>
                                                <button type='button' class='btn btn-warning btn-circle btn-sm' title='Real Total Time Mp'  >

                                                </button>
                                        </td>";

                            // ===============================================================
                            // extraTimeMp
                            // ===============================================================

                                $str.="<td class='spec hidden ".$familia->familia."_extraTimeMp_familia'>
                                                <button type='button' class='btn btn-info btn-circle btn-sm' title='Extra Time Mp'  >

                                                </button>
                                        </td>";

                            // ===============================================================
                            // failsForExtraTimeMp
                            // ===============================================================

                                $str.="<td class='spec hidden ".$familia->familia."_failsForExtraTimeMp_familia'>
                                                <button type='button' class='btn btn-danger btn-circle btn-sm' title='Fails For Extra Time'  >

                                                </button>
                                        </td>";

                            // ===============================================================
                            // mttrExtraTimeMp
                            // ===============================================================

                                $str.="<td class='spec hidden ".$familia->familia."_mttrExtraTimeMp_familia'>
                                                <button type='button' class='btn btn-primary btn-circle btn-sm' title='Mttr Extra Time Mp'  >

                                                </button>
                                        </td>";

                            // ===============================================================
                            // timeToRepair
                            // ===============================================================

                                $str.="<td class='spec ".$familia->familia."_timeToRepair_familia'>
                                                <button type='button' class='btn btn-default btn-circle btn-sm' title='Time To Repair'  >

                                                </button>
                                        </td>";

                            // ===============================================================
                            // totalTimeToRepair
                            // ===============================================================

                                $str.="<td class='spec hidden ".$familia->familia."_totalTimeToRepair_familia'>
                                                <button type='button' class='btn btn-success btn-circle btn-sm' title='Total Time To Repair'  >

                                                </button>
                                        </td>";

                            // ===============================================================
                            // realTimeOperation
                            // ===============================================================

                                $str.="<td class='spec hidden ".$familia->familia."_realTimeOperation_familia'>
                                                <button type='button' class='btn btn-warning btn-circle btn-sm' title='Real Time Operation'  >

                                                </button>
                                        </td>";

                            // ===============================================================
                            // fails
                            // ===============================================================

                                $str.="<td class='spec hidden ".$familia->familia."_fails_familia'>
                                                <button type='button' class='btn btn-danger btn-circle btn-sm' title='Fails corrective'  >

                                                </button>
                                        </td>";

                            // ===============================================================
                            // totalFails
                            // ===============================================================

                                $str.="<td class='spec ".$familia->familia."_totalFails_familia'>
                                                <button type='button' class='btn btn-danger btn-circle btn-sm' title='Total Fails'  >

                                                </button>
                                        </td>";

                            // ===============================================================
                            // middleTimeToRepair
                            // ===============================================================

                                $str.="<td class='spec  ".$familia->familia."_middleTimeToRepair_familia'>
                                                <button type='button' class='btn btn-primary btn-circle btn-sm' title='Middle Time To Repair'  >

                                                </button>
                                        </td>";

                            // ===============================================================
                            // middleTimeBeforeFailure
                            // ===============================================================

                                $str.="<td class='spec  ".$familia->familia."_middleTimeBeforeFailure_familia'>
                                                <button type='button' class='btn btn-primary btn-circle btn-sm' title='Middle Time Before Failure'  >

                                                </button>
                                        </td>";
                            
                            // ===============================================================
                            // disponibility
                            // ===============================================================

                                /*$str.="<td class='spec ".$familia->familia."_disponibility_familia'>
                                                <button type='button' class='btn btn-warning btn-circle btn-md' title='Disponibility'  >

                                                </button>
                                        </td>";*/

                                $str.="<td class='spec ".$familia->familia."_disponibility_familia'>
                                    <div class='progress'>
                                      <div class='porcentaje progress-bar progress-bar-success progress-bar-striped' role='progressbar' aria-valuenow='' aria-valuemin='0' aria-valuemax='100' style='' data-valor='' >
                                      </div>
                                    </div>
                                </td>";

                                $str.="<td>
                                    <button title='Ver equipos de la familia' class='detalles_familia$nombreMes ".$familia->familia." btn btn-info btn-md btn-circle' parametroDetalle='".$familia->familia."'
                                        parametroAno='".$ano."'
                                        parametroMes='".$mes."'
                                        >
                                        <i class='fa fa-eye' aria-hidden='true' ></i> 
                                    </button>
                                </td>";

                            $str.="</tr>"; // fin del tr

                            $f++;
                        }
            $str.="</tbody>
                    <table>";
            //------------------------------------------------------------------------------
            //------------------------------------------------------------------------------
            //------------------------------------------------------------------------------

            


            $str.="<button class='regresarFamilia$nombreMes btn btn-success hidden btn-circle' title='Ver familias'>
                        <i class='fa fa-chevron-circle-up' aria-hidden='true' ></i>
                    </button>
                    
                    <div class='recibeFamilia$nombreMes hidden'></div>"; // para recibir  datos de familia
                    $str.="<hr style='border-top: 1px dashed #8c8b8b;' class='hidden'>";

            $str.="<button class='regresarEquipo$nombreMes btn btn-warning hidden btn-circle' title='Ver área'>
                        <i class='fa fa-chevron-circle-up' aria-hidden='true' ></i>
                    </button>
                    
                    <div class='recibeEquipo$nombreMes hidden'></div>"; // para recibir  datos de familia
        }

        


    }
}
else
{
    $str.="NO DATA";
}


echo $str;


?>
<style type="text/css">
    .cabecera1
{
    text-align: center !important;
    font-size: 16px !important;
}

.mpideal
{
    color: white;
    background: #449d44;
}
.mpreal
{
    color: black;
    background: #f3d93a;
}

#disponibilityForFamily button
{
    width: 50px !important;
}

#original button
{
    width: 50px !important;
}
</style>
<!-- jQuery -->
    <script src="<?php echo $url; ?>vendor/jquery/jquery.js"></script>
    <!-- DataTables JavaScript -->
    <!--script src="<?php echo $url; ?>vendor/datatables/js/jquery.dataTables.min.js"></script>
    <script src="<?php echo $url; ?>vendor/datatables-plugins/dataTables.bootstrap.min.js"></script>
    <script src="<?php echo $url; ?>vendor/datatables-responsive/dataTables.responsive.js"></script-->

       <!-- Flot Charts JavaScript -->
   
    <!--script src="<?php echo $url; ?>dist/js/jsapi.js"></script-->

<script type="text/javascript">


var meses = ["ENERO", "FEBRERO", "MARZO", "ABRIL", "MAYO", "JUNIO", "JULIO", "AGOSTO", "SEPTIEMBRE", "OCTUBRE", "NOVIEMBRE", "DICIEMBRE"];
var familias = ["ELECTRICA", "EMBARQUE", "FUMIGACION", "REMOLQUES", "RIEGO", "TRACTOR"];

$.each(meses, function(key2, value2)
{
    var mes = value2;
    //alert(mes);
    //var mes = "ENERO";

    
    $.each(familias, function( key, value ) 
    {
        //alert( key + ": " + value );
        var familia = value;
        var suma = 0;
            //alert(mes);
            //alert(".todos"+mes+" ."+familia+" td.idealA button");

        var idealA = 0;
        var idealB = 0;
        var idealC = 0;
        var idealD = 0;
        var idealE = 0;
        var idealF = 0;

        $( ".todos"+mes+" ."+familia+" td.idealA button" ).each(function() 
        {
            var valor = parseFloat($(this).text()).toFixed(1);
            suma = (parseFloat(suma) + parseFloat(valor)).toFixed(1);
            idealA = parseFloat(valor) + parseFloat(idealA);

        });
        if(suma > 0)
        {
            $(".familia"+mes+" ."+familia+"_ideal_A_familia button").text(suma);
        }
        else
        {
            $(".familia"+mes+" ."+familia+"_ideal_A_familia button").text(0);
        }
        

        suma = 0;
        $(".todos"+mes+" ."+familia+" td.idealB button" ).each(function() 
        {
            var valor = parseFloat($(this).text()).toFixed(1);
            suma = (parseFloat(suma) + parseFloat(valor)).toFixed(1);
            idealB = parseFloat(valor) + parseFloat(idealB);
            
        });
        if(suma > 0)
        {
            $(".familia"+mes+" ."+familia+"_ideal_B_familia button").text(suma);
        }
        else
        {
            $(".familia"+mes+" ."+familia+"_ideal_B_familia button").text(0);
        }


        suma = 0;
        $( ".todos"+mes+" ."+familia+" td.idealC button" ).each(function() 
        {
            var valor = parseFloat($(this).text()).toFixed(1);
            suma = (parseFloat(suma) + parseFloat(valor)).toFixed(1);
            idealC = parseFloat(valor) + parseFloat(idealC);
            
        });
        if(suma > 0)
        {
            $(".familia"+mes+" ."+familia+"_ideal_C_familia button").text(suma);
        }
        else
        {
            $(".familia"+mes+" ."+familia+"_ideal_C_familia button").text(0);
        }


        suma = 0;
        $( ".todos"+mes+" ."+familia+" td.idealD button" ).each(function() 
        {
            var valor = parseFloat($(this).text()).toFixed(1);
            suma = (parseFloat(suma) + parseFloat(valor)).toFixed(1);
            idealD = parseFloat(valor) + parseFloat(idealD);
        });
        if(suma > 0)
        {
            $(".familia"+mes+" ."+familia+"_ideal_D_familia button").text(suma);
        }
        else
        {
            $(".familia"+mes+" ."+familia+"_ideal_D_familia button").text(0);
        }


        suma = 0;
        $( ".todos"+mes+" ."+familia+" td.idealE button" ).each(function() 
        {
            var valor = parseFloat($(this).text()).toFixed(1);
            suma = (parseFloat(suma) + parseFloat(valor)).toFixed(1);
            idealE = parseFloat(valor) + parseFloat(idealE); 
        });
        
        if(suma > 0)
        {
            $(".familia"+mes+" ."+familia+"_ideal_E_familia button").text(suma);
        }
        else
        {
            $(".familia"+mes+" ."+familia+"_ideal_E_familia button").text(0);
        }

        suma = 0;
        $( ".todos"+mes+" ."+familia+" td.idealF button" ).each(function() 
        {
            var valor = parseFloat($(this).text()).toFixed(1);
            suma = (parseFloat(suma) + parseFloat(valor)).toFixed(1);
            idealF = parseFloat(valor) + parseFloat(idealF);
        });
        
        if(suma > 0)
        {
            $(".familia"+mes+" ."+familia+"_ideal_F_familia button").text(suma);
        }
        else
        {
            $(".familia"+mes+" ."+familia+"_ideal_F_familia button").text(0);
        }

        
        // EMPIEZAN LOS MP REALES
        suma = 0;
        detectaRojo = 0;
        $( ".todos"+mes+" ."+familia+" td.realA button" ).each(function() 
        {
            var valor = parseFloat($(this).text()).toFixed(1);
            suma = (parseFloat(suma) + parseFloat(valor)).toFixed(1);

            var color = $(this).attr("colorIdentificador");
            if (color == "rojo" ) 
            {
                detectaRojo ++;                
            }
        });
        
        //console.log(familia+"mes"+familia+"_real_A_familia button"+ suma+ " - " + idealA);
        if(suma > 0 && detectaRojo > 0)
        {
            $(".familia"+mes+" ."+familia+"_real_A_familia button").text(suma);
            $(".familia"+mes+" ."+familia+"_real_A_familia button").removeClass("btn-default");
            $(".familia"+mes+" ."+familia+"_real_A_familia button").addClass("btn-danger");
        }
        else if(suma > 0 && detectaRojo == 0)
        {
            $(".familia"+mes+" ."+familia+"_real_A_familia button").text(suma);
        }
        else
        {
            $(".familia"+mes+" ."+familia+"_real_A_familia button").text(0);

            //$(".familia"+mes+" ."+familia+"_real_F_familia button").removeClass("btn-danger");
            $(".familia"+mes+" ."+familia+"_real_A_familia button").addClass("btn-default");
        }

        suma = 0;
        detectaRojo = 0;
        $( ".todos"+mes+" ."+familia+" td.realB button" ).each(function() 
        {
            var valor = parseFloat($(this).text()).toFixed(1);
            suma = (parseFloat(suma) + parseFloat(valor)).toFixed(1);

            var color = $(this).attr("colorIdentificador");
            if (color == "rojo" ) 
            {
                detectaRojo ++;                
            }
        });
        if(suma > 0 && detectaRojo > 0)
        {
            $(".familia"+mes+" ."+familia+"_real_B_familia button").text(suma);
            $(".familia"+mes+" ."+familia+"_real_B_familia button").removeClass("btn-default");
            $(".familia"+mes+" ."+familia+"_real_B_familia button").addClass("btn-danger");
        }
        else if(suma > 0 && detectaRojo == 0)
        {
            $(".familia"+mes+" ."+familia+"_real_B_familia button").text(suma);
        }
        else
        {
            $(".familia"+mes+" ."+familia+"_real_B_familia button").text(0);

            //$(".familia"+mes+" ."+familia+"_real_F_familia button").removeClass("btn-danger");
            $(".familia"+mes+" ."+familia+"_real_B_familia button").addClass("btn-default");
        }

        suma = 0;
        detectaRojo = 0;
        $( ".todos"+mes+" ."+familia+" td.realC button" ).each(function() 
        {
            var valor = parseFloat($(this).text()).toFixed(1);
            suma = (parseFloat(suma) + parseFloat(valor)).toFixed(1);

            var color = $(this).attr("colorIdentificador");
            if (color == "rojo" ) 
            {
                detectaRojo ++;                
            }
        });
        if(suma > 0 && detectaRojo > 0)
        {
            $(".familia"+mes+" ."+familia+"_real_C_familia button").text(suma);
            $(".familia"+mes+" ."+familia+"_real_C_familia button").removeClass("btn-default");
            $(".familia"+mes+" ."+familia+"_real_C_familia button").addClass("btn-danger");
        }
        else if(suma > 0 && detectaRojo == 0)
        {
            $(".familia"+mes+" ."+familia+"_real_C_familia button").text(suma);
        }
        else
        {
            $(".familia"+mes+" ."+familia+"_real_C_familia button").text(0);

            //$(".familia"+mes+" ."+familia+"_real_F_familia button").removeClass("btn-danger");
            $(".familia"+mes+" ."+familia+"_real_C_familia button").addClass("btn-default");
        }

        suma = 0;
        detectaRojo = 0;
        $( ".todos"+mes+" ."+familia+" td.realD button" ).each(function() 
        {
            var valor = parseFloat($(this).text()).toFixed(1);
            suma = (parseFloat(suma) + parseFloat(valor)).toFixed(1);

            var color = $(this).attr("colorIdentificador");
            if (color == "rojo" ) 
            {
                detectaRojo ++;                
            }
            
        });
        if(suma > 0 && detectaRojo > 0)
        {
            $(".familia"+mes+" ."+familia+"_real_D_familia button").text(suma);
            $(".familia"+mes+" ."+familia+"_real_D_familia button").removeClass("btn-default");
            $(".familia"+mes+" ."+familia+"_real_D_familia button").addClass("btn-danger");
        }
        else if(suma > 0 && detectaRojo == 0)
        {
            $(".familia"+mes+" ."+familia+"_real_D_familia button").text(suma);
        }
        else
        {
            $(".familia"+mes+" ."+familia+"_real_D_familia button").text(0);

            //$(".familia"+mes+" ."+familia+"_real_F_familia button").removeClass("btn-danger");
            $(".familia"+mes+" ."+familia+"_real_D_familia button").addClass("btn-default");
        }

        suma = 0;
        detectaRojo = 0;
        $( ".todos"+mes+" ."+familia+" td.realE button" ).each(function() 
        {
            var valor = parseFloat($(this).text()).toFixed(1);
            suma = (parseFloat(suma) + parseFloat(valor)).toFixed(1);

            var color = $(this).attr("colorIdentificador");
            if (color == "rojo" ) 
            {
                detectaRojo ++;                
            }
        });
        if(suma > 0 && detectaRojo > 0)
        {
            $(".familia"+mes+" ."+familia+"_real_E_familia button").text(suma);
            $(".familia"+mes+" ."+familia+"_real_E_familia button").removeClass("btn-default");
            $(".familia"+mes+" ."+familia+"_real_E_familia button").addClass("btn-danger");
        }
        else if(suma > 0 && detectaRojo == 0)
        {
            $(".familia"+mes+" ."+familia+"_real_E_familia button").text(suma);
        }
        else
        {
            $(".familia"+mes+" ."+familia+"_real_E_familia button").text(0);

            //$(".familia"+mes+" ."+familia+"_real_F_familia button").removeClass("btn-danger");
            $(".familia"+mes+" ."+familia+"_real_E_familia button").addClass("btn-default");
        }

        suma = 0;
        detectaRojo = 0;
        $( ".todos"+mes+" ."+familia+" td.realF button" ).each(function() 
        {
            var valor = parseFloat($(this).text()).toFixed(1);
            suma = (parseFloat(suma) + parseFloat(valor)).toFixed(1);
            
            var color = $(this).attr("colorIdentificador");
            if (color == "rojo" ) 
            {
                detectaRojo ++;
                /*if (mes == "ENERO" && familia == "RIEGO")
                {
                    console.log(valor+"->"+detectaRojo);    
                }*/                
            }
        });

        if(suma > 0 && detectaRojo > 0)
        {
            $(".familia"+mes+" ."+familia+"_real_F_familia button").text(suma);
            $(".familia"+mes+" ."+familia+"_real_F_familia button").removeClass("btn-default");
            $(".familia"+mes+" ."+familia+"_real_F_familia button").addClass("btn-danger");
        }
        else if(suma > 0 && detectaRojo == 0)
        {
            $(".familia"+mes+" ."+familia+"_real_F_familia button").text(suma);
        }
        else
        {
            $(".familia"+mes+" ."+familia+"_real_F_familia button").text(0);

            //$(".familia"+mes+" ."+familia+"_real_F_familia button").removeClass("btn-danger");
            $(".familia"+mes+" ."+familia+"_real_F_familia button").addClass("btn-default");
        }
        /*if(suma > 0 && suma > idealF)
        {
            $(".familia"+mes+" ."+familia+"_real_F_familia button").text(suma);
            $(".familia"+mes+" ."+familia+"_real_F_familia button").removeClass("btn-default");
            $(".familia"+mes+" ."+familia+"_real_F_familia button").addClass("btn-danger");
        }
        else if(suma > 0 && suma <= idealF)
        {
            $(".familia"+mes+" ."+familia+"_real_F_familia button").text(suma);
        }
        else
        {
            $(".familia"+mes+" ."+familia+"_real_F_familia button").text(0);

            $(".familia"+mes+" ."+familia+"_real_F_familia button").removeClass("btn-warning");
            $(".familia"+mes+" ."+familia+"_real_F_familia button").addClass("btn-default");
        }*/

        // PARA idealTotalTimeMp
        suma = 0;
        $( ".todos"+mes+" ."+familia+" td.idealTotalTimeMp button" ).each(function() 
        {
            var valor = parseFloat($(this).text()).toFixed(1);
            suma = (parseFloat(suma) + parseFloat(valor)).toFixed(1);
        });
        if(suma > 0)
        {
            $(".familia"+mes+" ."+familia+"_idealTotalTimeMp_familia button").text(suma);
        }
        else
        {
            $(".familia"+mes+" ."+familia+"_idealTotalTimeMp_familia button").text(0);
        }

        // PARA realTotalTimeMp
        suma = 0;
        $( ".todos"+mes+" ."+familia+" td.realTotalTimeMp button" ).each(function() 
        {
            var valor = parseFloat($(this).text()).toFixed(1);
            suma = (parseFloat(suma) + parseFloat(valor)).toFixed(1);
        });
        if(suma > 0)
        {
            $(".familia"+mes+" ."+familia+"_realTotalTimeMp_familia button").text(suma);
        }
        else
        {
            $(".familia"+mes+" ."+familia+"_realTotalTimeMp_familia button").text(0);

            $(".familia"+mes+" ."+familia+"_realTotalTimeMp_familia button").removeClass("btn-warning");
            $(".familia"+mes+" ."+familia+"_realTotalTimeMp_familia button").addClass("btn-default");
        }

        // PARA extraTimeMp
        suma = 0;
        $( ".todos"+mes+" ."+familia+" td.extraTimeMp button" ).each(function() 
        {
            var valor = parseFloat($(this).text()).toFixed(1);
            suma = (parseFloat(suma) + parseFloat(valor)).toFixed(1);

        });
        
        if(suma > 0)
        {
            $(".familia"+mes+" ."+familia+"_extraTimeMp_familia button").text(suma);
        }
        else
        {
            $(".familia"+mes+" ."+familia+"_extraTimeMp_familia button").text(0);
        }

        // PARA failsForExtraTimeMp
        suma = 0;
        $( ".todos"+mes+" ."+familia+" td.failsForExtraTimeMp button" ).each(function() 
        {
            var valor = parseFloat($(this).text()).toFixed(1);
            suma = (parseFloat(suma) + parseFloat(valor)).toFixed(1);

        });
        
        if(suma > 0)
        {
            $(".familia"+mes+" ."+familia+"_failsForExtraTimeMp_familia button").text(suma);
        }
        else
        {
            $(".familia"+mes+" ."+familia+"_failsForExtraTimeMp_familia button").text(0);
        }

        // PARA mttrExtraTimeMp
        suma = 0;
        $( ".todos"+mes+" ."+familia+" td.mttrExtraTimeMp button" ).each(function() 
        {
            var valor = parseFloat($(this).text()).toFixed(1);
            suma = (parseFloat(suma) + parseFloat(valor)).toFixed(1);

        });
        
        if(suma > 0)
        {
            $(".familia"+mes+" ."+familia+"_mttrExtraTimeMp_familia button").text(suma);
        }
        else
        {
            $(".familia"+mes+" ."+familia+"_mttrExtraTimeMp_familia button").text(0);
        }

        // PARA timeToRepair
        suma = 0;
        $( ".todos"+mes+" ."+familia+" td.timeToRepair button" ).each(function() 
        {
            var valor = parseFloat($(this).text()).toFixed(1);
            suma = (parseFloat(suma) + parseFloat(valor)).toFixed(1);

        });
        
        if(suma > 0)
        {
            $(".familia"+mes+" ."+familia+"_timeToRepair_familia button").text(suma);
        }
        else
        {
            $(".familia"+mes+" ."+familia+"_timeToRepair_familia button").text(0);
        }

        // PARA timeToRepair
        suma = 0;
        $( ".todos"+mes+" ."+familia+" td.totalTimeToRepair button" ).each(function() 
        {
            var valor = parseFloat($(this).text()).toFixed(1);
            suma = (parseFloat(suma) + parseFloat(valor)).toFixed(1);

        });
        if(suma > 0)
        {
            $(".familia"+mes+" ."+familia+"_totalTimeToRepair_familia button").text(suma);
        }
        else
        {
            $(".familia"+mes+" ."+familia+"_totalTimeToRepair_familia button").text(0);
        }


        // PARA realTimeOperation
        suma = 0;
        $( ".todos"+mes+" ."+familia+" td.realTimeOperation button" ).each(function() 
        {
            var valor = parseFloat($(this).text()).toFixed(1);
            suma = (parseFloat(suma) + parseFloat(valor)).toFixed(1);
        });
        
        if(suma > 0)
        {
            $(".familia"+mes+" ."+familia+"_realTimeOperation_familia button").text(suma);
        }
        else
        {
            $(".familia"+mes+" ."+familia+"_realTimeOperation_familia button").text(0);
        }

        // PARA fails
        suma = 0;
        $( ".todos"+mes+" ."+familia+" td.fails button" ).each(function() 
        {
            var valor = parseFloat($(this).text()).toFixed(1);
            suma = (parseFloat(suma) + parseFloat(valor)).toFixed(1);
        });
        
        if(suma > 0)
        {
            $(".familia"+mes+" ."+familia+"_fails_familia button").text(suma);
        }
        else
        {
            $(".familia"+mes+" ."+familia+"_fails_familia button").text(0);
        }

        // PARA totalFails
        suma = 0;
        $( ".todos"+mes+" ."+familia+" td.totalFails button" ).each(function() 
        {
            var valor = parseInt($(this).text());
            suma = (parseInt(suma) + parseInt(valor));
            
        });
        
        if(suma > 0)
        {
            $(".familia"+mes+" ."+familia+"_totalFails_familia button").text(suma);
        }
        else
        {
            $(".familia"+mes+" ."+familia+"_totalFails_familia button").text(0);

            $(".familia"+mes+" ."+familia+"_totalFails_familia button").removeClass("btn-danger");
            $(".familia"+mes+" ."+familia+"_totalFails_familia button").addClass("btn-default");
        }

        // PARA middleTimeToRepair
        suma = 0;
        $( ".todos"+mes+" ."+familia+" td.middleTimeToRepair button" ).each(function() 
        {
            var valor = parseFloat($(this).text()).toFixed(1);
            suma = (parseFloat(suma) + parseFloat(valor)).toFixed(1);
        });
        
        if(suma > 0)
        {
            $(".familia"+mes+" ."+familia+"_middleTimeToRepair_familia button").text(suma);
        }
        else
        {
            $(".familia"+mes+" ."+familia+"_middleTimeToRepair_familia button").text(0);
        }

        // PARA middleTimeBeforeFailure
        suma = 0;
        $( ".todos"+mes+" ."+familia+" td.middleTimeBeforeFailure button" ).each(function() 
        {
            var valor = parseFloat($(this).text()).toFixed(1);
            suma = (parseFloat(suma) + parseFloat(valor)).toFixed(1);
        });
        
        if(suma > 0)
        {
            $(".familia"+mes+" ."+familia+"_middleTimeBeforeFailure_familia button").text(suma);
        }
        else
        {
            $(".familia"+mes+" ."+familia+"_middleTimeBeforeFailure_familia button").text(0);
        }

        // PARA disponibility
        suma = 0;
        contador = 0;
        promedio = 0;
        $( ".todos"+mes+" ."+familia+" td.disponibility div.porcentaje" ).each(function() 
        {
            var valor = parseFloat($(this).attr("data-valor")).toFixed(1);
            suma = (parseFloat(suma) + parseFloat(valor)).toFixed(1);
            contador ++;
        });
        
        promedio = parseFloat(suma / contador).toFixed(2);

        if (promedio == 100.00)
        {
            promedio = parseInt(promedio);
        }
        if(promedio > 0)
        {
            $(".familia"+mes+" ."+familia+"_disponibility_familia div.porcentaje").text(promedio+"%");
            $(".familia"+mes+" ."+familia+"_disponibility_familia div.porcentaje").attr("aria-valuenow", promedio);
            $(".familia"+mes+" ."+familia+"_disponibility_familia div.porcentaje").attr("data-valor", promedio);
            $(".familia"+mes+" ."+familia+"_disponibility_familia div.porcentaje").css("width", promedio+"%");
        }
        else
        {
            $(".familia"+mes+" ."+familia+"_disponibility_familia div.porcentaje").text(0+"%");
            $(".familia"+mes+" ."+familia+"_disponibility_familia div.porcentaje").attr("aria-valuenow", 0);
            $(".familia"+mes+" ."+familia+"_disponibility_familia div.porcentaje").attr("data-valor", 0);
            $(".familia"+mes+" ."+familia+"_disponibility_familia div.porcentaje").css("width", 0+"%");
        }
            

    }); 


    // --------------------------------------------------------------------------------------
    // PARA totalDiponibility fuera del ciclo de la familia
    // --------------------------------------------------------------------------------------
    var suma = 0;
    var contador = 0;
    var promedio = 0;
    $(".familia"+mes+" div.porcentaje" ).each(function() 
    {
        var valor = parseFloat($(this).attr("data-valor")).toFixed(2);
        suma = (parseFloat(suma) + parseFloat(valor)).toFixed(2);
        //alert(suma);
        contador ++;
    });
    promedio = parseFloat(suma / contador).toFixed(2);
    //console.log(promedio);
    if (promedio == 100.00)
    {
        promedio = parseInt(promedio);
    }
    if(promedio > 0)
    {
        $(".totalDiponibility"+mes).text("TOTAL DISPONIBILITY FOR FAMILY = "+promedio+"%");
        /*$("."+familia+"_disponibility_familia div.porcentaje").attr("aria-valuenow", promedio);
        $("."+familia+"_disponibility_familia div.porcentaje").attr("data-valor", promedio);
        $("."+familia+"_disponibility_familia div.porcentaje").css("width", promedio+"%");*/
        $(".total"+mes).val(promedio);
    }
    else
    {
        $(".totalDiponibility"+mes).text("TOTAL DISPONIBILITY FOR FAMILY = "+0+"%");
        $(".total"+mes).val(0);
    }
    

});


    

    


    
</script>


<!-- ------------------------------------------------ -->
<!-- ------------------------------------------------ -->
<!-- PARA LA GRÁFICA DE MANTENIMIENTOS TOTALES EN EL MES -->
<!-- ------------------------------------------------ -->
<!-- ------------------------------------------------ -->
<script type="text/javascript">
      google.charts.load('current', {'packages':['corechart', 'bar']});
      //google.charts.setOnLoadCallback(drawChart);
      google.charts.setOnLoadCallback(drawChartFamily);
      //google.charts.setOnLoadCallback(drawSeriesChart);
      //google.charts.setOnLoadCallback(mantenimientosFamilia);
      //google.charts.setOnLoadCallback(drawStuff);

      function drawChart() 
      {
        var nPreventivos = parseInt($("#nPreventivos").val());
        var nCorrectivos = parseInt($("#nCorrectivos").val());

        var data = google.visualization.arrayToDataTable([
          ['Task', 'Mantenimientos por Mes'],
          ['MP',     nPreventivos],
          ['MC',      nCorrectivos]
        ]);

        var options = {
          title: 'Mantenimientos Por Mes'
        };

        var chart = new google.visualization.PieChart(document.getElementById('tMantenimiento'));

        chart.draw(data, options);
      }


    function drawChartFamily() 
    {
        //var constructor = [];
        var enero = $(".totalENERO").val();
        var febrero = $(".totalFEBRERO").val();
        var marzo = $(".totalMARZO").val();
        var abril = $(".totalABRIL").val();
        var mayo = $(".totalMAYO").val();
        var junio = $(".totalJUNIO").val();
        var julio = $(".totalJULIO").val();
        var agosto = $(".totalAGOSTO").val();
        var septiembre = $(".totalSEPTIEMBRE").val();
        var octubre = $(".totalOCTUBRE").val();
        var noviembre = $(".totalNOVIEMBRE").val();
        var diciembre = $(".totalDICIEMBRE").val();

        //alert(enero);
        enero = parseFloat(enero);
        febrero = parseFloat(febrero);
        marzo = parseFloat(marzo);
        abril = parseFloat(abril);
        mayo = parseFloat(mayo);
        junio = parseFloat(junio);
        julio = parseFloat(julio);
        agosto = parseFloat(agosto);
        septiembre = parseFloat(septiembre);
        octubre = parseFloat(octubre);
        noviembre = parseFloat(noviembre);
        diciembre = parseFloat(diciembre);



        /*constructor = [['MES', '% disponibilidad']];

        $.each(meses, function( key, value ) 
        {
            $(".total"+value).each(function() 
            {
                
                var valor = parseFloat($(this).val()).toFixed(1);
                    if (valor == 100.0) 
                    {

                        valor = 100;
                    }
                    if(valor == 0.0)
                    {
                        valor = 0;
                    }

                    


                constructor.push([value, valor]);
            });
        
        });*/
        var data = google.visualization.arrayToDataTable([
          ['', '% disponibilidad', {role:'annotation'}],
          ['ENERO', enero, enero],
          ['FEBRERO', febrero, febrero],
          ['MARZO', marzo, marzo],
          ['ABRIL', abril, abril],
          ['MAYO', mayo, mayo],
          ['JUNIO', junio, junio],
          ['JULIO', julio, julio],
          ['AGOSTO', agosto, agosto],
          ['SEPTIEMBRE', septiembre, septiembre],
          ['OCTUBRE', octubre, octubre],
          ['NOVIEMBRE', noviembre, noviembre],
          ['DICIEMBRE', diciembre, diciembre]
        ]); 

        var options = {
            chart: {
            //title: 'Nature Sweet',
            subtitle: 'Disponibilidad mensual'

          },
          bars: 'vertical',
           colors: ['#449d44', '#ec971f'],
           height: 315,
           vAxis: {
                    title: '% de disponibilidad',
                    //format: '#\'%\''
                    format:"decimal"

                    } // Required for Material Bar Charts.
        };

        var chart = new google.visualization.ColumnChart(document.getElementById('graficoPorFamilia'));
        chart.draw(data, google.charts.Bar.convertOptions(options));
    }

    // PARA LOS DETALLES DE LOS EQUIPOS
    $(".detalles_familiaENERO").on('click', function(event)
    {
        var fam = null;
        var mes = null;
        var ano = null;

        event.preventDefault();
        fam = $(this).attr("parametroDetalle");
        mesesito = $(this).attr("parametroMes");
        anito = $(this).attr("parametroAno");
        param = "FAMILIA";
        nombreMes = "ENERO";
        
        $(".recibeFamiliaENERO").html('<img style="text-align:center;" src="dist/img/loading.gif"/>');
        $.get("helperDisponibilidadParametros.php", {param:param, fam:fam, mes:mesesito, ano:anito, nombreMes:nombreMes} ,function(data)
        {
            $(".recibeFamiliaENERO").html(data);
            $(".recibeFamiliaENERO").removeClass("hidden");
            $(".totalDiponibilityENERO").addClass("hidden");
            //$("#disponibilityForFamily").addClass("hidden");
            $(".familiaENERO").addClass("hidden");

            $(".regresarFamiliaENERO").removeClass("hidden");
        });

        $(".mesMuestra").attr("disabled", "disabled");
    });

    $(".regresarFamiliaENERO").on('click', function(event)
    {
        //
        event.preventDefault();
        $(".recibeFamiliaENERO").addClass("hidden");
        $(".totalDiponibilityENERO").removeClass("hidden");
        $(".familiaENERO").removeClass("hidden");
        $(".regresarFamiliaENERO").addClass("hidden");

        $(".mesMuestra").removeAttr("disabled");

    });

    // FEBRERO
    $(".detalles_familiaFEBRERO").on('click', function(event)
    {
        var fam = null;
        var mes = null;
        var ano = null;

        event.preventDefault();
        fam = $(this).attr("parametroDetalle");
        mesesito = $(this).attr("parametroMes");
        anito = $(this).attr("parametroAno");
        param = "FAMILIA";
        nombreMes = "FEBRERO";
        
        $(".recibeFamiliaFEBRERO").html('<img style="text-align:center;" src="dist/img/loading.gif"/>');
        $.get("helperDisponibilidadParametros.php", {param:param, fam:fam, mes:mesesito, ano:anito, nombreMes:nombreMes} ,function(data)
        {
            $(".recibeFamiliaFEBRERO").html(data);
            $(".recibeFamiliaFEBRERO").removeClass("hidden");
            $(".totalDiponibilityFEBRERO").addClass("hidden");
            //$("#disponibilityForFamily").addClass("hidden");
            $(".familiaFEBRERO").addClass("hidden");

            $(".regresarFamiliaFEBRERO").removeClass("hidden");
        });

        $(".mesMuestra").attr("disabled", "disabled");
    });

    $(".regresarFamiliaFEBRERO").on('click', function(event)
    {
        //
        event.preventDefault();
        $(".recibeFamiliaFEBRERO").addClass("hidden");
        $(".totalDiponibilityFEBRERO").removeClass("hidden");
        $(".familiaFEBRERO").removeClass("hidden");
        $(".regresarFamiliaFEBRERO").addClass("hidden");

        $(".mesMuestra").removeAttr("disabled");

    });

    //MARZO

    $(".detalles_familiaMARZO").on('click', function(event)
    {
        event.preventDefault();

        nombreMes = "MARZO";
        var fam = null;
        var mes = null;
        var ano = null;

        
        fam = $(this).attr("parametroDetalle");
        mesesito = $(this).attr("parametroMes");
        anito = $(this).attr("parametroAno");
        param = "FAMILIA";
        
        $(".recibeFamilia"+nombreMes).html('<img style="text-align:center;" src="dist/img/loading.gif"/>');
        $.get("helperDisponibilidadParametros.php", {param:param, fam:fam, mes:mesesito, ano:anito, nombreMes:nombreMes} ,function(data)
        {
            $(".recibeFamilia"+nombreMes).html(data);
            $(".recibeFamilia"+nombreMes).removeClass("hidden");
            $(".totalDiponibility"+nombreMes).addClass("hidden");
            //$("#disponibilityForFamily").addClass("hidden");
            $(".familia"+nombreMes).addClass("hidden");

            $(".regresarFamilia"+nombreMes).removeClass("hidden");
        });

        $(".mesMuestra").attr("disabled", "disabled");
    });

    $(".regresarFamiliaMARZO").on('click', function(event)
    {
        //
        event.preventDefault();
        nombreMes = "MARZO";
        $(".recibeFamilia"+nombreMes).addClass("hidden");
        $(".totalDiponibility"+nombreMes).removeClass("hidden");
        $(".familia"+nombreMes).removeClass("hidden");
        $(".regresarFamilia"+nombreMes).addClass("hidden");

        $(".mesMuestra").removeAttr("disabled");

    });

    // ABRIL
    $(".detalles_familiaABRIL").on('click', function(event)
    {
        event.preventDefault();

        nombreMes = "ABRIL";
        var fam = null;
        var mes = null;
        var ano = null;

        
        fam = $(this).attr("parametroDetalle");
        mesesito = $(this).attr("parametroMes");
        anito = $(this).attr("parametroAno");
        param = "FAMILIA";
        
        $(".recibeFamilia"+nombreMes).html('<img style="text-align:center;" src="dist/img/loading.gif"/>');
        $.get("helperDisponibilidadParametros.php", {param:param, fam:fam, mes:mesesito, ano:anito, nombreMes:nombreMes} ,function(data)
        {
            $(".recibeFamilia"+nombreMes).html(data);
            $(".recibeFamilia"+nombreMes).removeClass("hidden");
            $(".totalDiponibility"+nombreMes).addClass("hidden");
            //$("#disponibilityForFamily").addClass("hidden");
            $(".familia"+nombreMes).addClass("hidden");

            $(".regresarFamilia"+nombreMes).removeClass("hidden");
        });

        $(".mesMuestra").attr("disabled", "disabled");
    });

    $(".regresarFamiliaABRIL").on('click', function(event)
    {
        //
        event.preventDefault();
        nombreMes = "ABRIL";
        $(".recibeFamilia"+nombreMes).addClass("hidden");
        $(".totalDiponibility"+nombreMes).removeClass("hidden");
        $(".familia"+nombreMes).removeClass("hidden");
        $(".regresarFamilia"+nombreMes).addClass("hidden");

        $(".mesMuestra").removeAttr("disabled");

    });

    // MAYO
    $(".detalles_familiaMAYO").on('click', function(event)
    {
        event.preventDefault();

        nombreMes = "MAYO";
        var fam = null;
        var mes = null;
        var ano = null;

        
        fam = $(this).attr("parametroDetalle");
        mesesito = $(this).attr("parametroMes");
        anito = $(this).attr("parametroAno");
        param = "FAMILIA";
        
        $(".recibeFamilia"+nombreMes).html('<img style="text-align:center;" src="dist/img/loading.gif"/>');
        $.get("helperDisponibilidadParametros.php", {param:param, fam:fam, mes:mesesito, ano:anito, nombreMes:nombreMes} ,function(data)
        {
            $(".recibeFamilia"+nombreMes).html(data);
            $(".recibeFamilia"+nombreMes).removeClass("hidden");
            $(".totalDiponibility"+nombreMes).addClass("hidden");
            //$("#disponibilityForFamily").addClass("hidden");
            $(".familia"+nombreMes).addClass("hidden");

            $(".regresarFamilia"+nombreMes).removeClass("hidden");
        });

        $(".mesMuestra").attr("disabled", "disabled");
    });

    $(".regresarFamiliaMAYO").on('click', function(event)
    {
        //
        event.preventDefault();
        nombreMes = "MAYO";
        $(".recibeFamilia"+nombreMes).addClass("hidden");
        $(".totalDiponibility"+nombreMes).removeClass("hidden");
        $(".familia"+nombreMes).removeClass("hidden");
        $(".regresarFamilia"+nombreMes).addClass("hidden");

        $(".mesMuestra").removeAttr("disabled");

    });

    // JUNIO
    $(".detalles_familiaJUNIO").on('click', function(event)
    {
        event.preventDefault();

        nombreMes = "JUNIO";
        var fam = null;
        var mes = null;
        var ano = null;

        
        fam = $(this).attr("parametroDetalle");
        mesesito = $(this).attr("parametroMes");
        anito = $(this).attr("parametroAno");
        param = "FAMILIA";
        
        $(".recibeFamilia"+nombreMes).html('<img style="text-align:center;" src="dist/img/loading.gif"/>');
        $.get("helperDisponibilidadParametros.php", {param:param, fam:fam, mes:mesesito, ano:anito, nombreMes:nombreMes} ,function(data)
        {
            $(".recibeFamilia"+nombreMes).html(data);
            $(".recibeFamilia"+nombreMes).removeClass("hidden");
            $(".totalDiponibility"+nombreMes).addClass("hidden");
            //$("#disponibilityForFamily").addClass("hidden");
            $(".familia"+nombreMes).addClass("hidden");

            $(".regresarFamilia"+nombreMes).removeClass("hidden");
        });

        $(".mesMuestra").attr("disabled", "disabled");
    });

    $(".regresarFamiliaJUNIO").on('click', function(event)
    {
        //
        event.preventDefault();
        nombreMes = "JUNIO";
        $(".recibeFamilia"+nombreMes).addClass("hidden");
        $(".totalDiponibility"+nombreMes).removeClass("hidden");
        $(".familia"+nombreMes).removeClass("hidden");
        $(".regresarFamilia"+nombreMes).addClass("hidden");

        $(".mesMuestra").removeAttr("disabled");

    });

    // JULIO
    $(".detalles_familiaJULIO").on('click', function(event)
    {
        event.preventDefault();

        nombreMes = "JULIO";
        var fam = null;
        var mes = null;
        var ano = null;

        
        fam = $(this).attr("parametroDetalle");
        mesesito = $(this).attr("parametroMes");
        anito = $(this).attr("parametroAno");
        param = "FAMILIA";
        
        $(".recibeFamilia"+nombreMes).html('<img style="text-align:center;" src="dist/img/loading.gif"/>');
        $.get("helperDisponibilidadParametros.php", {param:param, fam:fam, mes:mesesito, ano:anito, nombreMes:nombreMes} ,function(data)
        {
            $(".recibeFamilia"+nombreMes).html(data);
            $(".recibeFamilia"+nombreMes).removeClass("hidden");
            $(".totalDiponibility"+nombreMes).addClass("hidden");
            //$("#disponibilityForFamily").addClass("hidden");
            $(".familia"+nombreMes).addClass("hidden");

            $(".regresarFamilia"+nombreMes).removeClass("hidden");
        });

        $(".mesMuestra").attr("disabled", "disabled");
    });

    $(".regresarFamiliaJULIO").on('click', function(event)
    {
        //
        event.preventDefault();
        nombreMes = "JULIO";
        $(".recibeFamilia"+nombreMes).addClass("hidden");
        $(".totalDiponibility"+nombreMes).removeClass("hidden");
        $(".familia"+nombreMes).removeClass("hidden");
        $(".regresarFamilia"+nombreMes).addClass("hidden");

        $(".mesMuestra").removeAttr("disabled");

    });

    // AGOSTO
    $(".detalles_familiaAGOSTO").on('click', function(event)
    {
        event.preventDefault();

        nombreMes = "AGOSTO";
        var fam = null;
        var mes = null;
        var ano = null;

        
        fam = $(this).attr("parametroDetalle");
        mesesito = $(this).attr("parametroMes");
        anito = $(this).attr("parametroAno");
        param = "FAMILIA";
        
        $(".recibeFamilia"+nombreMes).html('<img style="text-align:center;" src="dist/img/loading.gif"/>');
        $.get("helperDisponibilidadParametros.php", {param:param, fam:fam, mes:mesesito, ano:anito, nombreMes:nombreMes} ,function(data)
        {
            $(".recibeFamilia"+nombreMes).html(data);
            $(".recibeFamilia"+nombreMes).removeClass("hidden");
            $(".totalDiponibility"+nombreMes).addClass("hidden");
            //$("#disponibilityForFamily").addClass("hidden");
            $(".familia"+nombreMes).addClass("hidden");

            $(".regresarFamilia"+nombreMes).removeClass("hidden");
        });

        $(".mesMuestra").attr("disabled", "disabled");
    });

    $(".regresarFamiliaAGOSTO").on('click', function(event)
    {
        //
        event.preventDefault();
        nombreMes = "AGOSTO";
        $(".recibeFamilia"+nombreMes).addClass("hidden");
        $(".totalDiponibility"+nombreMes).removeClass("hidden");
        $(".familia"+nombreMes).removeClass("hidden");
        $(".regresarFamilia"+nombreMes).addClass("hidden");

        $(".mesMuestra").removeAttr("disabled");

    });

    // SEPTIEMBRE
    $(".detalles_familiaSEPTIEMBRE").on('click', function(event)
    {
        event.preventDefault();

        nombreMes = "SEPTIEMBRE";
        var fam = null;
        var mes = null;
        var ano = null;

        
        fam = $(this).attr("parametroDetalle");
        mesesito = $(this).attr("parametroMes");
        anito = $(this).attr("parametroAno");
        param = "FAMILIA";
        
        $(".recibeFamilia"+nombreMes).html('<img style="text-align:center;" src="dist/img/loading.gif"/>');
        $.get("helperDisponibilidadParametros.php", {param:param, fam:fam, mes:mesesito, ano:anito, nombreMes:nombreMes} ,function(data)
        {
            $(".recibeFamilia"+nombreMes).html(data);
            $(".recibeFamilia"+nombreMes).removeClass("hidden");
            $(".totalDiponibility"+nombreMes).addClass("hidden");
            //$("#disponibilityForFamily").addClass("hidden");
            $(".familia"+nombreMes).addClass("hidden");

            $(".regresarFamilia"+nombreMes).removeClass("hidden");
        });

        $(".mesMuestra").attr("disabled", "disabled");
    });

    $(".regresarFamiliaSEPTIEMBRE").on('click', function(event)
    {
        //
        event.preventDefault();
        nombreMes = "SEPTIEMBRE";
        $(".recibeFamilia"+nombreMes).addClass("hidden");
        $(".totalDiponibility"+nombreMes).removeClass("hidden");
        $(".familia"+nombreMes).removeClass("hidden");
        $(".regresarFamilia"+nombreMes).addClass("hidden");

        $(".mesMuestra").removeAttr("disabled");

    });

    // OCTUBRE
    $(".detalles_familiaOCTUBRE").on('click', function(event)
    {
        event.preventDefault();

        nombreMes = "OCTUBRE";
        var fam = null;
        var mes = null;
        var ano = null;

        
        fam = $(this).attr("parametroDetalle");
        mesesito = $(this).attr("parametroMes");
        anito = $(this).attr("parametroAno");
        param = "FAMILIA";
        
        $(".recibeFamilia"+nombreMes).html('<img style="text-align:center;" src="dist/img/loading.gif"/>');
        $.get("helperDisponibilidadParametros.php", {param:param, fam:fam, mes:mesesito, ano:anito, nombreMes:nombreMes} ,function(data)
        {
            $(".recibeFamilia"+nombreMes).html(data);
            $(".recibeFamilia"+nombreMes).removeClass("hidden");
            $(".totalDiponibility"+nombreMes).addClass("hidden");
            //$("#disponibilityForFamily").addClass("hidden");
            $(".familia"+nombreMes).addClass("hidden");

            $(".regresarFamilia"+nombreMes).removeClass("hidden");
        });

        $(".mesMuestra").attr("disabled", "disabled");
    });

    $(".regresarFamiliaOCTUBRE").on('click', function(event)
    {
        //
        event.preventDefault();
        nombreMes = "OCTUBRE";
        $(".recibeFamilia"+nombreMes).addClass("hidden");
        $(".totalDiponibility"+nombreMes).removeClass("hidden");
        $(".familia"+nombreMes).removeClass("hidden");
        $(".regresarFamilia"+nombreMes).addClass("hidden");

        $(".mesMuestra").removeAttr("disabled");

    });

    // NOVIEMBRE
    $(".detalles_familiaNOVIEMBRE").on('click', function(event)
    {
        event.preventDefault();

        nombreMes = "NOVIEMBRE";
        var fam = null;
        var mes = null;
        var ano = null;

        
        fam = $(this).attr("parametroDetalle");
        mesesito = $(this).attr("parametroMes");
        anito = $(this).attr("parametroAno");
        param = "FAMILIA";
        
        $(".recibeFamilia"+nombreMes).html('<img style="text-align:center;" src="dist/img/loading.gif"/>');
        $.get("helperDisponibilidadParametros.php", {param:param, fam:fam, mes:mesesito, ano:anito, nombreMes:nombreMes} ,function(data)
        {
            $(".recibeFamilia"+nombreMes).html(data);
            $(".recibeFamilia"+nombreMes).removeClass("hidden");
            $(".totalDiponibility"+nombreMes).addClass("hidden");
            //$("#disponibilityForFamily").addClass("hidden");
            $(".familia"+nombreMes).addClass("hidden");

            $(".regresarFamilia"+nombreMes).removeClass("hidden");
        });
        $(".mesMuestra").attr("disabled", "disabled");
    });

    $(".regresarFamiliaNOVIEMBRE").on('click', function(event)
    {
        //
        event.preventDefault();
        nombreMes = "NOVIEMBRE";
        $(".recibeFamilia"+nombreMes).addClass("hidden");
        $(".totalDiponibility"+nombreMes).removeClass("hidden");
        $(".familia"+nombreMes).removeClass("hidden");
        $(".regresarFamilia"+nombreMes).addClass("hidden");

        $(".mesMuestra").removeAttr("disabled");

    });

    // DICIEMBRE
    $(".detalles_familiaDICIEMBRE").on('click', function(event)
    {
        event.preventDefault();

        nombreMes = "DICIEMBRE";
        var fam = null;
        var mes = null;
        var ano = null;

        
        fam = $(this).attr("parametroDetalle");
        mesesito = $(this).attr("parametroMes");
        anito = $(this).attr("parametroAno");
        param = "FAMILIA";
        
        $(".recibeFamilia"+nombreMes).html('<img style="text-align:center;" src="dist/img/loading.gif"/>');
        $.get("helperDisponibilidadParametros.php", {param:param, fam:fam, mes:mesesito, ano:anito, nombreMes:nombreMes} ,function(data)
        {
            $(".recibeFamilia"+nombreMes).html(data);
            $(".recibeFamilia"+nombreMes).removeClass("hidden");
            $(".totalDiponibility"+nombreMes).addClass("hidden");
            //$("#disponibilityForFamily").addClass("hidden");
            $(".familia"+nombreMes).addClass("hidden");

            $(".regresarFamilia"+nombreMes).removeClass("hidden");
        });
        $(".mesMuestra").attr("disabled", "disabled");
    });

    $(".regresarFamiliaDICIEMBRE").on('click', function(event)
    {
        //
        event.preventDefault();
        nombreMes = "DICIEMBRE";
        $(".recibeFamilia"+nombreMes).addClass("hidden");
        $(".totalDiponibility"+nombreMes).removeClass("hidden");
        $(".familia"+nombreMes).removeClass("hidden");
        $(".regresarFamilia"+nombreMes).addClass("hidden");

        $(".mesMuestra").removeAttr("disabled");

    });

    //$("#original").css("font-size", "12px");
    // PARA MOSTRAR EL MES 
    $(".mesMuestra").on("click", function(event)
    {
        event.preventDefault();

        var valorMes = $(this).attr("valor");
        $(".mesShow").addClass("hidden");

        $(".cabecera"+valorMes).removeClass("hidden");
        $(".porcentaje"+valorMes).removeClass("hidden");
        $(".familia"+valorMes).removeClass("hidden");
        
    });



</script>



