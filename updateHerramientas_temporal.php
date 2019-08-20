<?php
//require_once $_SERVER["DOCUMENT_ROOT"].'/siscohistoraca2/__config.php';
require_once('includes/config.inc.php');
require_once('includes/inc.session.php');


if(isset($_GET["consulta"]))
{
	$consulta = $_GET["consulta"];
	$str = "";
	
	if($consulta == "PIEZAS_BUSQUEDA")
	{
		$codigo_asociado = $_GET["codigo_asociado"];
	
		
			

		$sql = "SELECT herramientas_herramientas.*, herramientas_udm.descripcion AS udm_descripcion, herramientas_stock.stock AS stock
					FROM herramientas_herramientas
						INNER JOIN herramientas_udm ON herramientas_herramientas.id_udm = herramientas_udm.id
						LEFT JOIN herramientas_stock ON herramientas_herramientas.clave = herramientas_stock.clave
							WHERE  herramientas_herramientas.activaStock = 1 ";
					
		$piezas = Herramientas_herramientas::getAllByQuery($sql);

		if (count($piezas) > 0) 
		{
			
			
			$i = 1;
			foreach ($piezas as $p) 
			{
				$str.="<tr>";
					$str.="<td>".$i."</td>";
					$str.="<td>".$p->clave."</td>";
					$str.="<td>".$p->descripcion."</td>";
					$str.="<td>".$p->udm_descripcion."</td>";
					$str.="<td>".$p->stock."</td>";
					$str.="<td>";

						if($p->stock != "" || $p->stock > 0)
						{

								$str.="<button type='button' valueCodigo='".$codigo_asociado."' valueEnvia='".$p->clave."' valueDescripcion='".$p->descripcion."' class='btn btn-success add_temporal' title='Agregar producto' data-dismiss='modal'> <span class='fa fa-plus'></span> </button>";
						}
					$str.="</td>";
				$str.="</tr>";

				$i++;
			}
		}
		else
		{
			$str = "<h5 style='text-align:center; '>PRODUCTO NO ENCONTRADO EN LA BD...</h5>";
		}			
	}
}
else
{
	redirect_to('lib/logout.php');
}

echo $str;
?>

<script type='text/javascript'>
	

	$('.add_temporal').on('click', function(e)
	{
	    event.preventDefault();
	    var clave = null;
	    var codigo = null;
	    var cantidad = null;

	        clave = $(this).attr('valueEnvia');
	        codigo = $(this).attr('valueCodigo');
	        cantidad = 1;
	        consulta = "VALIDA_STOCK";

	        $("#mensaje").html(null);

	    if(clave != '')
	    {
	        /*$.post( 'createHerramienta_transaccion_temporal.php', {clave: clave, cantidad: cantidad, codigo: codigo })
	          .done(function( data )
	          {

	                $("#mensaje").text("Artículo agregado...");
	                $("#mensaje").removeClass();
	                $("#mensaje").addClass('alert alert-success');
	                $("#mensaje").alert();
                    $("#mensaje").fadeTo(1000, 700).slideUp(700, function(){
                    $("#mensaje").slideUp(1000);
                    });

                    $("#articulos_ingresados").html(data);
	          });*/


	          $.post( 'helper_herramientas.php', {clave: clave, cantidad: cantidad, codigo: codigo, consulta: consulta })
              .done(function( data )
              {
                if(data == "SI")
                {
                    $("#mensaje").text("Producto agregado...");
                    $("#mensaje").removeClass();
                    $("#mensaje").addClass('alert alert-success');
                    $("#mensaje").alert();
                    $("#mensaje").fadeTo(1000, 700).slideUp(700, function(){
                    $("#mensaje").slideUp(1000);
                    });

                    $("#articulos_ingresados").html(data);


                    $.post( 'createHerramienta_transaccion_temporal.php', {clave: clave, cantidad: cantidad, codigo: codigo })
                      .done(function( data )
                      {

                            $("#mensaje").text("Producto agregado...");
                            $("#mensaje").removeClass();
                            $("#mensaje").addClass('alert alert-success');
                            $("#mensaje").alert();
                            $("#mensaje").fadeTo(1000, 700).slideUp(700, function(){
                            $("#mensaje").slideUp(1000);
                            });

                            $("#articulos_ingresados").html(data);
                      });
                }
                else
                {
                    $("#mensaje").text("PRODUCTO NO AGREGADO / SUPERA EL STOCK");
                    $("#mensaje").removeClass();
                    $("#mensaje").addClass('alert alert-warning');
                    $("#mensaje").alert();
                    $("#mensaje").fadeTo(1000, 700).slideUp(700, function(){
                    $("#mensaje").slideUp(1000);
                    });
                }

                    
              });
                        

	        
	    }
	    else
	    {
	        return false;
	    }
	        
	});

</script>