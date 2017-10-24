<?php
//require_once $_SERVER["DOCUMENT_ROOT"].'/siscohistoraca2/__config.php';
require_once('includes/config.inc.php');
require_once('includes/inc.session.php');



//$bloques = Bloques::getById($id);
//print_r($bloques);
//$str="";
if( isset($_REQUEST["parametro"]) ) 
{
	$parametro = $_REQUEST["parametro"];
	if ($parametro == "MEDICIONES_CAMARA") 
	{
		//Inicio de la instancia para la exportación en Excel
		header('Content-type: application/vnd.ms-excel');
		header("Content-Disposition: attachment; filename=".$parametro.".xls");
		header("Pragma: no-cache");
		header("Expires: 0");

		echo "<table border='1'> ";
		echo "<tr >
				<td colspan='2'><img src='".$url."dist/img/naturesweet_picture.png"."' width='10%' height='10%'></td>

				<td colspan='9'><br><h2>REPORTE DE MEDICIONES DE CAMARA FRIA</h2><br><br></td>
			</tr>";

		echo "<tr> ";
            echo "<th>FECHA</th>";
            echo "<th>T. CAM (VACIA)</th>";
            echo "<th>T. CAM (CON TOMATE)</th>";
            echo "<th>HR. CAM (VACIA)</th>";
            echo "<th>HR. CAM (CON TOMATE)</th>";
            echo "<th>T. TOMATE (ENTRADA)</th>";
            echo "<th>T. TOMATE (SALIDA)</th>";
            echo "<th>NUM TARIMAS</th>";
            echo "<th>PUERTA CERRADA</th>";
            echo "<th>LONA B. UBICADA</th>";
            echo "<th>EQUIPO 7.5 ENCENDIDO</th>";
		echo "</tr> ";

		$camaras = Mediciones_camara_fria::getAll();
		foreach ($camaras as $camara) 
		{
			echo "<tr >";
                echo "<td>".date("d-M-Y H:m:s", strtotime($camara->fecha_medicion))."</td>";
                echo "<td>".$camara->temp_vacia."</td>";
                echo "<td>".$camara->temp_con_tomate."</td>";
                echo "<td>".$camara->hr_vacia."</td>";
                echo "<td>".$camara->hr_con_tomate."</td>";
                echo "<td>".$camara->temp_tomate_entrada."</td>";
                echo "<td>".$camara->temp_tomate_salida."</td>";
                echo "<td>".$camara->num_tarimas."</td>";

                if($camara->puerta_cerrada == 1)
                {
                    echo "<td style='background-color: #5cb85c; color:white;'>SI</td>";
                }
                elseif($camara->puerta_cerrada == 2)
                {
                    echo "<td style='background-color: #d9534f; color:white;'>NO</td>";
                }

                if($camara->lona_bien_ubicada == 1)
                {
                    echo "<td style='background-color: #5cb85c; color:white;'>SI</td>";
                }
                elseif($camara->lona_bien_ubicada == 2)
                {
                    echo "<td style='background-color: #d9534f; color:white;'>NO</td>";
                }

                if($camara->e_75_encendido == 1)
                {
                    echo "<td style='background-color: #5cb85c; color:white;'>SI</td>";
                }
                elseif($camara->e_75_encendido == 2)
                {
                    echo "<td style='background-color: #d9534f; color:white;'>NO</td>";
                }

               
                echo "</td>";
            echo "</tr>";
		}

		echo "</table> ";

	}
    elseif($parametro == "INVENTARIO_MATERIALES")
    {
        //Inicio de la instancia para la exportación en Excel
        //header('Content-type: application/vnd.ms-excel');
        header('application/application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        
        header("Content-Disposition: attachment; filename=".$parametro.".xls");
        header("Pragma: no-cache");
        header("Expires: 0");

        echo "<table border='1'> ";
        echo "<tr >
                <td colspan='6'><img src='".$url."dist/img/naturesweet_picture.png"."' width='10%' height='10%'></td>
                <td><br>Fecha de impresi&oacute;n<br><br></td>
                <td><br>".date("d/m/Y")."<br><br></td>
            </tr>";
        echo "<tr >
                <td colspan='8' style='text-align:center;'><br><h2>INVENTARIO DE MATERIALES</h2><br><br></td>
            </tr>";

        echo "<tr> ";
            echo "<th>CODIGO</th>";
            echo "<th>DESCRIPCION</th>";
            echo "<th>CLASE</th>";
            echo "<th>MINIMO</th>";
            echo "<th>MAXIMO</th>";
            echo "<th>STOCK</th>";
            echo "<th>ESTATUS</th>";
            echo "<th>% DISPONIBILIDAD</th>";
        echo "</tr> ";

        $almacen = Almacen_inventario::getAll();
        foreach ($almacen as $a) 
        {
            echo "<tr>";
                //echo "<th width='5px' class='spec'>$i</th>";
                echo "<td>".$a->codigo."</td>";
                echo "<td>".utf8_encode($a->descripcion)."</td>";
                echo "<td>".$a->clase."</td>";
                echo "<td>".$a->cantidad_minima."</td>";
                echo "<td>".$a->cantidad_maxima."</td>";

                if($a->stock > $a->cantidad_maxima)
                {
                    echo "<td style='text-align:right; background:#337ab7; color:white;'>".$a->stock."</td>";
                }
                elseif($a->stock >= $a->cantidad_minima && $a->stock <= $a->cantidad_maxima)
                {
                    echo "<td style='text-align:right; background:#5cb85c; color:white;'>".$a->stock."</td>";
                }
                elseif($a->stock < $a->cantidad_minima)
                {
                    if($a->stock <= 2)
                    {
                        echo "<td style='text-align:right; background:#d9534f; color:white;'>".$a->stock."</td>";
                    }
                    else
                    {
                        echo "<td style='text-align:right; background:#f0ad4e; color:white;'>".$a->stock."</td>";
                    }
                    
                }
                
                

                if($a->estatus ==  1)
                {
                    echo "<td style='text-align:center;'>A</td>";
                }
                else
                {
                    echo "<td style='text-align:center;'>NA</td>";
                }

                $porcentajeDisponible = (100 * $a->stock) / $a->cantidad_maxima; 
                $porcentajeDisponible = round($porcentajeDisponible, 1);

               
                echo "<td>".$porcentajeDisponible."</td>";
                               
            echo "</tr>";
        }

        echo "</table>";

        
    }   
}
else
{
	echo "NO DATA";
}


//echo $str;
?>