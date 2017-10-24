<?php require_once(VIEW_PATH.'header.inc.php'); 


/*$dir="http://cgaf.ucol.mx/SGR/servicio/catuorg";
$client = new SoapClient(null,array('location' => "$dir",'uri' => 'urn:webservices',));*/

if(isset($_GET["idInf"])){
	$idInf=$_GET["idInf"];
	
}else{
	$idInf="";
}


?>

<section class="container">

	<?php
	//if(isset($_GET["idLinea"])){
	?>
	<div class="row">
      	<div class="col-sm-12">
      		<button type="button" class="btn btn-success btn-md pull-right" id="agregaConsulta">
  				<span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Agregar archivo / URL</button>
  			</button>
  		<input class="form-control hidden" type="text" id="pasarInforme" name='pasarInforme' value='<?php echo $idInf; ?>'>
      </div>
    </div>
	<?php
	//}
	?>

<div id="content" class="row">
	<div class="col-sm-3" id="menu" >
		<?php include(VIEW_PATH.'indexMenu.php'); ?>
	</div>

	
	<div class="col-sm-9">
		<h4><?php echo($informes->nombre); ?></h4>
		
		    	<br>
		    	<table class='table table-bordered table-condensed' id="pagina">
			        <thead>
			            <tr><th>#</th><!--th>Etiqueta del archivo</th--><th>Fecha</th> <?php if($consultas[0]->etiqueta != 'modulos') { ?><th>Rubro</th> <?php } ?> <th>Agrupado en</th><th>Archivo / URL</th><th>P&uacute;blico</th><th width='195'>Acciones</th></tr>
			        </thead>
			    	<tbody>

					<?php 
					$i=1;
					foreach($consultas as $consulta): 
					{
						$atributo = "";
						if($consulta->estatus == 'True')
						{
							$atributo.="checked";
						} 
						else
						{
							$atributo."";
						}
						echo "<tr campoid={$consulta->id}>";
			        	echo "<th width='5px' class='spec'>$i</th>";
			        	//echo "<td>".$consulta->etiquetaArchivo."</td>";
			        	echo "<td>".$consulta->fecha."</td>";
			        	if($consultas[0]->etiqueta != 'modulos') 
			        	{
			        		echo "<td>".$consulta->rubro."</td>";
			        	}	
			        	echo "<td>".$consulta->nombre_del_grupo."</td>";
			        	if($consulta->etiquetaArchivo != '')
			        	{
			        		echo "<td><a href='".$consulta->url."' target='_blank'>".$consulta->etiquetaArchivo."</a></td>";
			        	}
			        	else
			        	{
			        		echo "<td><a href='".$urlDatos.$consulta->archivo."' target='_blank'>".$consulta->nomArchivo."</a></td>";
			        	}
			        	
			        	echo "<td><input type='checkbox' ".$atributo." disabled></td>";
			        	
			        	echo "<td><button type='button' data-toggle='modal' data-target='#modalVer' class='paraConsulta btn btn-info btn-md' valorConsulta={$consulta->id} valorId_cat={$consulta->id_cat_informe}>Ver</button>&nbsp;";
			        	echo "<button type='button'  class='btn btn-warning btn-md axnedt' valorConsultado={$consulta->id}>Editar</button>&nbsp;";
	        			echo "<button type='button'  class='btn btn-danger btn-md axndel' data-toggle='confirmation'>Borrar</button></td>";
			        	
						echo "</tr>";
			        	$i++;
			    	}
			     	endforeach;
			   	 	?>
			    	</tbody>
			    </table>
	</div>

</div> 
</section>

<!-- Modal -->
<?php
//if(isset($_GET["idLinea"])){
?>

<div class="modal fade" id="modalAgregarConsulta" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
    	<div class="modal-content">
	        <div class="modal-header">
	            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
	            <h3 id="myModalLabel">Agregar tipo</h3>
	        </div>
	        <div class="modal-body">
	        	<form name='frmtipo' class="form-horizontal" id="divdestino" method="post" action="<?php echo $url; ?>createConsultas.php" enctype="multipart/form-data">

			

	
	        </div>
	      	<div class="modal-footer from-group">
	      		<input type="hidden" id="ID_usuario" name="ID_usuario" value='<?php echo($_SESSION['Login']['id'])?>'>
	      		<input type="hidden" id="idC" name="idC" >
	        	<button type="submit" class="btn btn-success">Aceptar</button>
	            <button class="btn btn-danger" data-dismiss="modal" aria-hidden="true">Cancelar</button>
	      	</div>
	      </form>	        
	    </div>
	</div>
  
</div>
<?php 
//}
?>



<div class="modal fade" id="modalVer" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
    	<div class="modal-content">
	        <div class="modal-header ">
	            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
	            <h3 id="myModalLabel">Ver tipo</h3>
	        </div>
	        <div class="modal-body">
	        	<form name='' class="form-horizontal" method="post" action="" id="regresaConsulta">
	        		   	
	        
	        </div>
	      	<div class="modal-footer from-group">
	            <button class="btn btn-danger" data-dismiss="modal" aria-hidden="true">Cancelar</button>
	      	</div>
	      	   </form>     
	    </div>
	</div>
</div>

<div class="modal fade" id="modalAgregarGrupo" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
    	<div class="modal-content">
	        <div class="modal-header">
	            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
	            <h3 id="myModalLabel">Agregar grupo</h3>
	        </div>
	        <div class="modal-body">
	        	<form class="form-horizontal"name="formNuevo" id="formNuevo" >

					<div class='form-group'>
						<label class='col-sm-2 control-label' for='inputNombre'>Nombre</label>
						<div class='col-sm-6'>
							<input type="text" class="form-control" name="nombre_del_grupo" id="nombre_del_grupo" value="" autocomplete="off" required >
						</div>
					</div>
	
	        </div>
	      	<div class="modal-footer from-group">
	        	<button type="submit" class="btn btn-success">Aceptar</button>
	            <button class="btn btn-danger" id='cierraGrupo' data-dismiss="modal" aria-hidden="true">Cancelar</button>
	      	</div>
	      </form>	        
	    </div>
	</div>
  
</div>



<!-- Termina modal -->



<script type="text/javascript">

$('[data-toggle="confirmation"]').confirmation(
{
	title: 'Estas seguro de querer borrar el registro?',
	btnOkLabel : '<i class="icon-ok-sign icon-white"></i> Si',
				
	onConfirm: function(event) {
		var idR = $(this).parents("tr").attr("campoid");
		var idI = $("#pasarInforme").val();
		window.location.href='deleteConsultas.php?id='+idR+"&idI="+idI;
		},
	
});



$(document).ready(function() 
{



		$("#modalAgregarGrupo").on("hide",function()
		{
			var encender = $("#lleva").attr("encender");

			if (encender == 0)
			{
			 	var v = 0;
			 	var informe = $("#pasarInforme").val();
				ajaxCargaDatos("divdestino", v, informe);
			}
			else if(encender > 0)
			{
				var v = encender;
				var informe = 0;
				
				$("#idC").val(v);
				ajaxCargaDatos("divdestino", v );
			}
			
			//$("#modalAgregarConsulta").modal("show");
		});



		// para pasar el idTipo a la ventana modalAgregarTipo
		// para pasar el idTipo a la ventana modalAgregarTipo
		$(".paraConsulta").click(function() { //$("body").delegate('.paratarea', 'click')

			var v = $(this).attr('valorConsulta');
			$.get("AX_checaConsultas.php", {idConsulta:v} ,function(data){
  					
  					$("#regresaConsulta").html(data);
  					//$("#modalVer").modal("show");
			});
				
		});

				// para agregar un nuevo tipo
		$("#agregaConsulta").click(function(event) { //$("body").delegate('.paratarea', 'click')
			event.preventDefault();
			var v = 0;
			var informe = $("#pasarInforme").val();

			ajaxCargaDatos("divdestino", v, informe);
			/*$.get("updateUsuario.php", {id:v} ,function(data){
  					
  					$("#valoresUsers").html(data);
  					$("#modalAgregarUsuario").modal("show");
			});*/
				
		});

	            // para pasar el idLinea a la ventana modalAgregarIntegrante
		$(".axnedt").on('click',function(event) { //$("body").delegate('.paratarea', 'click')
				event.preventDefault();
				var v = $(this).attr('valorConsultado');
				var informe = 0;
				
				$("#idC").val(v);

				ajaxCargaDatos("divdestino", v, informe );
				
				/*$.get("updateUsuario.php", {id:v} ,function(data){
	  					
	  					$("#valoresUsers").html(data);
	  					$("#modalAgregarUsuario").modal("show");
	  					$("#myModalLabel").text('Editar usuario');
				});*/
					
		});

		$("#formNuevo").submit(function(event)
		{
			event.preventDefault();
			datos=$("#formNuevo").serialize();
			$.post("<?php echo $url; ?>datoGrupo.php",datos,function(data)
			{
				$("#modalAgregarGrupo").modal("hide"); 
				
				
			});
			return false;
		});
		/*function nuevo(){    
			alert("hay");
			datos=$("formNuevo").serialize();
			$.post("<?php echo $url; ?>datoGrupo.php",datos,function(data){
				$("#modalAgregarGrupo").modal("hide"); 
				$("#modalAgregarConsulta").modal("show"); 
			});
			
			return false;	
		} */


		function creaAjax()
		{
			var objetoAjax=false;
			try {
				/*Para navegadores distintos a internet explorer*/
				objetoAjax = new ActiveXObject("Msxml2.XMLHTTP");
			} catch (e)
			{
				try {
					/*Para explorer*/
					objetoAjax = new ActiveXObject("Microsoft.XMLHTTP");
				} catch (E) {
					objetoAjax = false;
					}
				}
			if (!objetoAjax && typeof XMLHttpRequest!='undefined') {
				objetoAjax = new XMLHttpRequest();
			}
			return objetoAjax;
		}

			function ajaxCargaDatos(divdestino, uID, idI)
		{
				//alert(uID+' Ok');
				var ajax=creaAjax();

				if (uID > 0)
				{
				  	$("#myModalLabel").text('Editar archivo');
				}
				else
				{
				  	$("#myModalLabel").text('Agregar archivo');
				}

				if (uID == 0 && idI > 0)
				{
					//alert(uID + idI);
					ajax.open("GET", "updateConsulta.php?idC=0&idI="+idI, true);
				}
				else
				{
					ajax.open("GET", "updateConsulta.php?idI=0&idC="+uID, true);
				}
				
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
				  	  	$("#modalAgregarConsulta").modal("show");
	  	  	
					} 
				}
				ajax.send(null);
		}



        $('#pagina').dataTable(
          {
            "iDisplayLength": 10,
            "aLengthMenu": [[10, 20, 50], [10, 20, 50]],
            "oLanguage": {
            "sLengthMenu": "_MENU_ Registros por p&aacute;gina"
            } 
          });

});
	


</script>
            

       

<?php require_once(VIEW_PATH.'footer.inc.php'); ?>