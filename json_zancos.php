<?php
//require_once $_SERVER["DOCUMENT_ROOT"].'/siscohistoraca2/__config.php';
require_once('includes/config.inc.php');
require_once('includes/inc.session.php');

if(isset($_REQUEST['consulta']) && ($_SESSION["type"] == 9 || $_SESSION["type"] == 10 ) ) // para zancos
{
    $consulta = $_REQUEST["consulta"];
    if($consulta == "PARETO_PIEZAS")
    {


        $q = "SELECT count(zancos_historial_piezas.parte) AS veces, zancos_partes.parte AS parte
                FROM zancos_historial_piezas
                    INNER JOIN zancos_partes ON zancos_historial_piezas.parte = zancos_partes.parte
                    GROUP BY zancos_historial_piezas.parte 
                        ORDER BY veces DESC
                            LIMIT 10";

        $contenedor = Zancos_historial_piezas::getAllByQuery($q);

        header('Content-type: application/json; charset=utf-8');
        echo json_encode($contenedor, JSON_FORCE_OBJECT);

    }
    else if($consulta == "PARETO_PROBLEMAS")
    {


        $q = "SELECT count(zancos_historial_piezas.problema) AS veces, zancos_problemas.descripcion AS descripcion
                FROM zancos_historial_piezas
                    INNER JOIN zancos_problemas ON zancos_historial_piezas.problema = zancos_problemas.id
                    GROUP BY zancos_historial_piezas.problema
                        ORDER BY veces DESC
                            LIMIT 10";

        $contenedor = Zancos_historial_piezas::getAllByQuery($q);

        header('Content-type: application/json; charset=utf-8');
        echo json_encode($contenedor, JSON_FORCE_OBJECT);

    }
    else
    {
        redirect_to('index.php');
    }
}
else
{
    redirect_to('index.php');
}

?>