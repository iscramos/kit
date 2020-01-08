<?php
//require_once $_SERVER["DOCUMENT_ROOT"].'/siscohistoraca2/__config.php';
require_once('includes/config.inc.php');
require_once('includes/inc.session.php');

//$bloques = Bloques::getById($id);
//print_r($bloques);
$str="";
if(isset($_REQUEST['no_zanco']) && ($_SESSION["type"] == 9 || $_SESSION["type"] == 10 ) ) // para zancos
{	
	//$mes = $_GET['mes'];
	$zanco_temporal = $_REQUEST['no_zanco'];
	
	$str.="<style type='text/css'>
    
    
#zoom {
    position: relative;
    width: 640px;
    height: auto;
    margin: 20px auto;
    border: 12px solid #fff;
    border-radius: 10px;
    box-shadow: 1px 1px 5px rgba(50,50,50 0.5);
}

/*.zoom img:hover{
  transform:scale(1.5);
  -moz-transform: scale(1.5);
  -webkit-transform:scale(1.5);
}*/
       
.zoom
{      
  overflow:hidden;
}
</style>";

    $str.="<div class='col-sm-4 text-center zoom'>";
        $str.="<h4>MODEL IV</h4> ";
        $str.="<img id='zoom_zanco' class='img img-thumbnail' src='content/partes_zancos/model4.jpg' width='100%'>";
    $str.="</div>";
    $str.="<!-- COMIENZA EL HISTORAL DE PIEZAS DAÑADAS -->";
    $str.="<div class='col-sm-8'>";
        
        $str.="<i>HISTORIAL DE PIEZAS</i>";
        $str.="<button class='btn btn-sm btn-primary pull-right' title='Añadir detalle de piezas' id='agregaPieza'>";
            $str.="<span class='glyphicon glyphicon-plus'></span>";
        $str.="</button>";
        $str.="<table class='table table-condensed table-bordered table-striped  table-hover dataTables_wrapper jambo_table bulk_action' id='piezas_tabla'> ";
            $str.="<thead>";
                $str.="<tr>";
                   $str.=" <th>REGISTRO</th>";
                    $str.="<th>PIEZA</th>";
                   $str.=" <th>DESCRIPCION</th>";
                   $str.="<th>PROBLEMA</th>";
                    $str.="</tr>";
            $str.="</thead>";
            $str.="<tbody>";
                
                        $consulta_historial = "SELECT zancos_historial_piezas.*, zancos_problemas.descripcion AS descripcion_problema, zancos_partes.descripcion AS descripcion_pieza 
                                FROM zancos_historial_piezas
                                    INNER JOIN zancos_problemas ON zancos_historial_piezas.problema = zancos_problemas.id
                                    INNER JOIN zancos_partes ON zancos_historial_piezas.parte = zancos_partes.parte
                                            WHERE zancos_historial_piezas.no_zanco = $zanco_temporal";
                        //echo $consulta_historial;
                        $zancos_historial = Zancos_historial_piezas::getAllByQuery($consulta_historial);

                        foreach ($zancos_historial as $historial) 
                        {
                           	$str.="<tr>";
                               	$str.="<td>".$historial->id_registro."</td>";
                               	$str.="<td>".$historial->parte."</td>";
                               	$str.="<td>".$historial->descripcion_pieza."</td>";
                               	$str.="<td>".$historial->descripcion_problema."</td>";
                           	$str.="</tr>";
                        }
                     
                    
                
            $str.="</tbody>";
        $str.="</table>";
    $str.="</div>";
	
	$str.="<!-- Modal -->";
        $str.="<div class='modal fade' id='modalAgregar' tabindex='-1' role='dialog' aria-labelledby='myModalLabel'>";
         $str.=" <div class='modal-dialog' role='document'>";
            $str.="<div class='modal-content'>";
              $str.="<div class='modal-header'>";
                $str.="<button type='button' class='close' data-dismiss='modal' aria-label='Close'><span aria-hidden='true'>&times;</span></button>";
                $str.="<h4 class='modal-title' id='myModalLabel'>Agregar detalles de pieza</h4>";
              $str.="</div>";
              $str.="<div class='modal-body'>";
                $str.="<form name='frmtipo' class='form-horizontal' id='respuesta'>";
          
              $str.="</div>";
              $str.="<div class='modal-footer'>";
                $str.="<button type='button' class='btn btn-default' data-dismiss='modal'>Cerrar</button>";
                $str.="<button type='button' class='btn btn-primary hidden' id='enviar' data-dismiss='modal'>Guardar</button>";
              $str.="</div>";
                $str.="</form>";
            $str.="</div>";
          $str.="</div>";
        $str.="</div>";
	
}

else
{
	echo "NO REQUEST";
}


echo $str;


?>
<script type="text/javascript">
	
	$("#zoom_zanco").mlens(
    {
        imgSrc: $("#zoom_zanco").attr("data-big"),   // path of the hi-res version of the image
        lensShape: "square",                // shape of the lens (circle/square)
        lensSize: 300,                  // size of the lens (in px)
        borderSize: 4,                  // size of the lens border (in px)
        borderColor: "#233E50",                // color of the lens border (#hex)
        borderRadius: 0,                // border radius (optional, only if the shape is square)
        imgOverlay: $("#zoom_zanco").attr("data-overlay"), // path of the overlay image (optional)
        overlayAdapt: false, // true if the overlay image has to adapt to the lens size (true/false)
        zoomLevel: 1.5
    });


	$("#enviar").on("click", function(e)
    {
        

        event.preventDefault();
        var pieza_registro = null;
        var pieza_zanco = null;
        var pieza_parte = null;
        var pieza_descripcion = null;
        var pieza_problema = null;
        var pieza_problema_descripcion = null;
        var pieza_notas = null;

            pieza_registro = $("#id_registro").val();
            pieza_zanco = $("#no_zanco").val();
            pieza_parte = $("#parte").val();
            pieza_descripcion = $("#descripcion_pieza").val();
            pieza_problema = $("#problema").val();
            pieza_problema_descripcion = $("#problema option:selected").text();
            pieza_notas = $("#notas").val();

        if(pieza_registro > 0 && pieza_zanco > 0 && pieza_parte != "" && pieza_problema > 0)
        {
            $.post( "createZancos_historial.php", {pieza_registro: pieza_registro, pieza_zanco: pieza_zanco, pieza_parte: pieza_parte, pieza_problema:pieza_problema, pieza_notas: pieza_notas })
              .done(function( data ) {
                    //alert( "Data Loaded: " + data );

                    $('#piezas_tabla').append('<tr><td>'+pieza_registro+'</td><td>'+pieza_parte+'</td><td>'+pieza_descripcion+'</td><td>'+pieza_problema_descripcion+'</td></tr>');

                    alert(data);
              });
            
        }
        else
        {
            return false;
        }
            
    });

    $("#agregaPieza").on("click", function(e)
    {
        event.preventDefault();
            var v = 0;

            ajaxCargaDatos("respuesta", v );
    });

    function ajaxCargaDatos(divdestino, uID)
    {
        var ajax=creaAjax();

        ajax.open("GET", "updateZancos_piezas.php?id="+uID, true);
        ajax.onreadystatechange=function() 
        { 
            if (ajax.readyState==1)
            {
              // Mientras carga ponemos un letrerito que dice "Verificando..."
              $('#'+divdestino).html='Cargando...';
            }
            if (ajax.readyState==4)
            {
              // Cuando ya terminó, ponemos el resultado
                var str =ajax.responseText; 
                            
                $('#'+divdestino).html(''+str+'');
                $("#modalAgregar").modal("show");
    
            } 
        }
        ajax.send(null);
    }
</script>