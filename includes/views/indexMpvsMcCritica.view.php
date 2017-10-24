 <?php require_once(VIEW_PATH.'header.inc.php');
    include(VIEW_PATH.'indexMenu.php');
 ?>

            
            <!-- /.navbar-static-side -->
        </nav>

        <div id="page-wrapper">

            <div class="row">
                <div class="col-lg-12">
                    <br>
                    <button class="btn btn-primary btn-md expandir" title="Expandir"> <i class="fa fa-expand" aria-hidden="true"></i> </button>

                    <button class="btn btn-primary btn-md contraer hidden" title="Contraer"> <i class="fa fa-compress" aria-hidden="true"></i> </button>
                    <h1 class="page-header">MP vs MC (Críticos)</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default" style='border-color: #d43f3a !important;'>
                        <div class="panel-heading text-right" style='background-color: #d43f3a !important;
    color: white !important;'>
                            <form class='form-inline'>
                                

                                <div class="form-group">
                                    <select class="form-control" id="ano">
                                        <option value='<?php echo date('Y'); ?>' style="display: none;"><?php echo date('Y'); ?></option>
                                        <option value='2016' ">2016</option>
                                        <option value='2017' ">2017</option>
                                    </select>
                                </div>
                                <button type="button" class="btn btn-success btn-circle btn-md" title="Traer registros" id="verDisponibilidad"><i class="fa fa-database"></i>
                            </button>
                            </form>
                            
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="table-responsive" id="disponibilidad" >
                            
                            <!-- /.table-responsive -->
                            </div>
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->

            
           
            
        </div>
        <!-- /#page-wrapper -->


  		



 <?php require_once(VIEW_PATH.'footer.inc.php'); ?>

         <script type="text/javascript">
           
           

            $(document).ready(function()
            {
                $("#verDisponibilidad").click(function(event) 
                {
                    event.preventDefault();
                    var mes = $("#mes").val();
                    var ano = $("#ano").val();
                    var parametro = "MPvsMC";
                    var valorPlantel = $(this).attr('valorPlantel');

                    //Añadimos la imagen de carga en el contenedor
                    $('#disponibilidad').html('<div style="text-align:center;"><img src="dist/img/loading.gif"/></div>');
                  
                    $.get("helperMp_Mc_critica.php", {parametro:parametro, mes:mes, ano:ano} ,function(data)
                    {
                        $("#disponibilidad").html(data);
                    });
                    
                });// fin de disponibilidad

                

                $('.dataTables-example').DataTable({
                //responsive: true,
                "language":{
                    "oPaginate": {
                        "sNext" : "Siguiente",
                        "sPrevious": "Anterior"
                    },
                    "search": "Buscar ",
                    "sNext": "Siguiente",
                    "sPrevious": "Anterior",
                    "lengthMenu": "_MENU_ Registros por página",
                    "zeroRecords": "Nada encontrado",
                    "info": "Mostrando página _PAGE_ de _PAGES_",
                    "infoEmpty": "No registros disponibles",
                    "infoFiltered": "(filtrado de _MAX_ registros totales)"
                }
            });

            }); // end ready
        </script>
</body>

</html>