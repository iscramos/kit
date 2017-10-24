<?php
//require_once $_SERVER["DOCUMENT_ROOT"].'/siscohistoraca2/__config.php';
require_once('includes/config.inc.php');
require_once('includes/inc.session.php');

$str = "";
$anos = array(2016, 2017);
$semanas = array(1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30, 31, 32, 33, 34, 35, 36, 37, 38, 39, 40, 42, 42, 43, 44, 45, 46, 47, 48, 49, 50, 51, 52);

if(isset($_GET["id"]))
{
	$id = $_GET["id"];

	
	if($id > 0)
	{
		$dashboard = ArchivosDashboard::getById($id);

		$str.="<div class='form-group hidden'>
						<label class='col-sm-3 control-label'>ID</label>
						<div class='col-sm-4'>
							<input type='number' class='form-control' id='id' name='id' value='".$id."' readonly>
						</div>
				</div>";

		$str.="<div class='form-group'>
						<label class='col-sm-3 control-label'>Año</label>
						<div class='col-sm-4'>
							<select class='form-control' id='ano' name='ano' required>
								<option value='".$dashboard->ano."' style='display:none;'>".$dashboard->ano."</option>";
								foreach ($anos as $ano) 
								{
									$str.="<option value='".$ano."'>".$ano."</option>";
								}
							$str.="</select>
						</div>
				</div>";

		$str.="<div class='form-group'>
						<label class='col-sm-3 control-label'>Fecha de reporte</label>
						<div class='col-sm-4'>
							
				                <div class='input-group date' id='datetimepicker1'>
				                    <input type='text' name='fechaReporte' id='fechaReporte' class='form-control' value='". date("d-m-Y", strtotime($dashboard->fechaReporte) )."' required>
				                    <span class='input-group-addon'>
				                        <span class='glyphicon glyphicon-calendar'></span>
				                    </span>
				                </div>
				            
						</div>
				</div>";
		$str.="<div class='form-group'>
						<label class='col-sm-3 control-label'>Semana</label>
						<div class='col-sm-4'>
							<select class='form-control' id='semana' name='semana' required>
								<option value='".$dashboard->semana."' style='display:none;'>".$dashboard->semana."</option>";
								foreach ($semanas as $semana) 
								{
									$str.="<option value='".$semana."'>".$semana."</option>";
								}
							$str.="</select>
						</div>
				</div>";
		$str.="<div class='form-group hidden'>
					<label class='col-sm-2 control-label' for='inputArchivoTemp'>Archivo</label>
					<div class='col-sm-6'>
					
						<input type='text'  class='form-control' id='archivoTemp' name='archivoTemp' value='".$dashboard->archivo."'>
					</div>
				</div>";
		$str.="<div class='form-group'>
						<label class='col-sm-3 control-label'>Etiqueta</label>
						<div class='col-sm-9'>
							<input type='text' class='form-control' id='etiqueta' name='etiqueta' value='".$dashboard->etiqueta."' autocomplete='off' required='required'>
						</div>
				</div>";
		$str.="<div class='form-group'>
                            <label class='col-sm-3 control-label' >Archivo de carga</label>
                            <div class='col-sm-9'> 
                            	<label class='col-sm-6 control-label muestra' for='inputArchivo'>".$dashboard->archivo."</label><br><br>
                                <input type='file' id='archivo' name='archivo' onChange='extensionCHK(this);' >
                                <font size='1' color='gray'>(Archivos soportados: *.PDF)</font>
                                <p><font size='1' color='red'>Tama&ntilde;o m&aacute;ximo: 10 MB.</font></p>
                            </div>
                        </div>
                        <div class='form-group hidden' id='mensaje'>
                            <label class='col-sm-3 control-label' ></label>
                            <div class='col-sm-9 alert alert-danger' role='alert'>
                                <span class='glyphicon glyphicon-exclamation-sign' aria-hidden='true'></span>
                                <span id='ext'></span>
                                <span id='tam'></span>
                            </div>
                        </div>";
	}
	else
	{

		$str.="<div class='form-group hidden'>
						<label class='col-sm-3 control-label'>ID</label>
						<div class='col-sm-4'>
							<input type='number' class='form-control' id='id' name='id' value='".$id."' readonly>
						</div>
				</div>";

		$str.="<div class='form-group'>
						<label class='col-sm-3 control-label'>Año</label>
						<div class='col-sm-4'>
							<select class='form-control' id='ano' name='ano' required>
								<option value='' style='display:none;'>Seleccione un año</option>";
								foreach ($anos as $ano) 
								{
									$str.="<option value='".$ano."'>".$ano."</option>";
								}
							$str.="</select>
						</div>
				</div>";

		$str.="<div class='form-group'>
						<label class='col-sm-3 control-label'>Fecha de reporte</label>
						<div class='col-sm-4'>
							
				                <div class='input-group date' id='datetimepicker1'>
				                    <input type='text' name='fechaReporte' id='fechaReporte' class='form-control' required>
				                    <span class='input-group-addon'>
				                        <span class='glyphicon glyphicon-calendar'></span>
				                    </span>
				                </div>
				            
						</div>
				</div>";
		$str.="<div class='form-group'>
						<label class='col-sm-3 control-label'>Semana</label>
						<div class='col-sm-4'>
							<select class='form-control' id='semana' name='semana' required>
								<option value='' style='display:none;'>Seleccione una semana</option>";
								foreach ($semanas as $semana) 
								{
									$str.="<option value='".$semana."'>".$semana."</option>";
								}
							$str.="</select>
						</div>
				</div>";

		$str.="<div class='form-group'>
						<label class='col-sm-3 control-label'>Etiqueta</label>
						<div class='col-sm-9'>
							<input type='text' class='form-control' id='etiqueta' name='etiqueta' value='' autocomplete='off' required='required'>
						</div>
				</div>";
		$str.="<div class='form-group'>
                            <label class='col-sm-3 control-label' >Archivo de carga</label>
                            <div class='col-sm-9'>  
                                <input type='file' id='archivo' name='archivo' onChange='extensionCHK(this);' required>
                                <font size='1' color='gray'>(Archivos soportados: *.PDF)</font>
                                <p><font size='1' color='red'>Tama&ntilde;o m&aacute;ximo: 10 MB.</font></p>
                            </div>
                        </div>
                        <div class='form-group hidden' id='mensaje'>
                            <label class='col-sm-3 control-label' ></label>
                            <div class='col-sm-9 alert alert-danger' role='alert'>
                                <span class='glyphicon glyphicon-exclamation-sign' aria-hidden='true'></span>
                                <span id='ext'></span>
                                <span id='tam'></span>
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
    $('#datetimepicker1').datetimepicker({
	 	//viewMode: 'years',
    	format: 'DD-MM-YYYY',
    	pickTime: false
	});

	function extensionCHK(campo)
        {
            var src = campo.value;
            var log = src.length;
            
            var pdf = log - 3;
            var wpdf = src.substring(pdf, log);
                wpdf = wpdf.toUpperCase();

            // para .XLSX
            /*var xlsx = log - 3;
            var wsubc = src.substring(xlsx, log);
                wsubc = wsubc.toUpperCase();*/
          
          //this.files[0].size gets the size of your file.
          var tamano = $("#archivo")[0].files[0].size;
          
          if (tamano > 10485760)
          {
            //alert('El archivo a subir debe ser menor a 1MB');
            $("#archivo").val("");
            $("#mensaje").removeClass("hidden");
            $("#tam").text("El archivo pesa más de 10MB.");
          
          }

          else if(wpdf!='PDF')
          {
            //alert('El archivo a subir debe ser una imagen JPG, o PDF');
            $("#archivo").val("");
            $("#mensaje").removeClass("hidden");
            $("#ext").text("El archivo debe ser un .PDF");
            
          }
          else
          {
            $("#mensaje").addClass("hidden");
            $("#tam").text("");
            $("#ext").text("");
            
          }
        }
</script>