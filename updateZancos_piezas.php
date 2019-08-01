<?php
//require_once $_SERVER["DOCUMENT_ROOT"].'/siscohistoraca2/__config.php';
require_once('includes/config.inc.php');
require_once('includes/inc.session.php');


if(isset($_GET["id"]))
{
	$id = $_GET["id"];
	$str = "";
	
	if($id > 0)
	{
		$str.="";
	}
	else
	{
		
		$problemas = Zancos_problemas::getAllByOrden("descripcion", "ASC");
		$piezas = Zancos_partes::getAllByOrden("id", "ASC");

		$str.="<div class='form-group hidden'>
						<label class='col-sm-4 control-label'>ID</label>
						<div class='col-sm-8'>
							<input type='number' class='form-control input-sm' id='id' name='id' value='' readonly>
						</div>
				</div>";
		
		$str.="<div class='form-group'>
                        <label class='col-sm-4 control-label text-success'>Parte buscada</label>
						<div class='col-sm-8'>
                            <select class='form-control' name='valor_buscado' id='valor_buscado' required='required'>
								<option value='' style='display:none;'>Seleccione</option>";
								foreach ($piezas as $p) 
								{
									
									$str.="<option value='".$p->parte."' >".$p->descripcion."</option>";
									
									
								}
							$str.="</select>
                        </div>
                    </div>";


        $str.="<div class='form-group'>
						<label class='col-sm-4 control-label'>Imagen</label>
						<div class='col-sm-8'>
							<img class='img-thumbnail' id='img' width='150px' height='150px'>
						</div>
				</div>";

        $str.="<div class='form-group'>
						<label class='col-sm-4 control-label'>Parte</label>
						<div class='col-sm-8'>
							<input type='text' class='form-control input-sm' id='parte' name='parte' value='' autocomplete='off' required='required' readonly>
						</div>
				</div>";

		$str.="<div class='form-group'>
						<label class='col-sm-4 control-label'>Descripcion </label>
						<div class='col-sm-8'>
							<input type='text' class='form-control input-sm' id='descripcion_pieza' name='descripcion_pieza' value='' autocomplete='off' required='required' readonly>
						</div>
				</div>";

		$str.="<div class='form-group'>
						<label class='col-sm-4 control-label'>Problema</label>
						<div class='col-sm-8'>
							<select class='form-control input-sm' name='problema' id='problema' required='required'>
								<option value='' style='display:none;'>Seleccione</option>";
								foreach ($problemas as $t) 
								{
									if($t->id != 1)
									{
										$str.="<option value='".$t->id."' >".$t->descripcion."</option>";
									}
									
								}
							$str.="</select>
						</div>
				</div>";
		$str.="<div class='form-group'>
						<label class='col-sm-4 control-label'>Notas </label>
						<div class='col-sm-8'>
							<textarea class='form-control' rows='2' name='notas' id='notas'></textarea>
						</div>
				</div>";
	}
}
else
{
	redirect_to('lib/logout.php');
}

echo $str;
?>

<script type="text/javascript">
	$("#valor_buscado").on('change', function(event) 
    {
        event.preventDefault();
        /* Act on the event */
        var valor_buscado = null;
            valor_buscado = $("#valor_buscado").val();
            consulta = "PIEZAS_DETALLES_IMAGEN";
        if (valor_buscado != "") 
        {
            $.get("helper_zancos.php", {consulta:consulta, valor_buscado:valor_buscado} ,function(data)
            { 
            	var str = data;

            	if(data == "NO")
            	{
            		alert("PIEZA NO ENCONTRADA...");
            		$("#enviar").addClass('hidden');
            		return false;
            	}
            	else
            	{
            		var n = str.split("&");
                    
	                var parte = n[0];
	                var descripcion = n[1];
	                var img = n[2];

	                	img = "content/partes_zancos/"+img;

	                $("#parte").val(parte);
	            	$("#descripcion_pieza").val(descripcion);
	            	$("#img").attr("src", img);
	                $("#enviar").removeClass('hidden');
            	}

            });
        }
        else
        {
            $("#enviar").addClass('hidden');
            return false;
        }
    });
</script>