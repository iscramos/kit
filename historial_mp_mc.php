<?php 
    require_once('includes/config.inc.php');
    require_once(VIEW_PATH.'headerGeneral.inc.php');
    //include(VIEW_PATH.'indexMenu.php');

    $años = Disponibilidad_anos::getAllByOrden("ano", "DESC");
    $actual = date("Y");
    //print_r($años);
 ?>
  <style type="text/css">
    #graficaHistorica
    {
      padding: 10px;
    }
  </style>     
            
        <!-- page content -->
        <div class="right_col" role="main">
          
          <div class='container text-center'>
            <h3 class="text-center" > Historial de mantenimientos preventivos y correctivos</h3>
              <form class="form-inline">
                <div class="form-group ">

                  <select class="form-control" id="ano">
                    <option value="0" style="display: none;">Seleccione un año</option>
                    <?php
                      foreach ($años as $a) 
                      {
                        
                          echo "<option value='".$a->ano."'>".$a->ano."</option>";
                        
                        
                      }
                    ?>
                  </select>
                </div>
              </form>
          </div>
          
            
          <br>
            <div width="100%" id="graficaHistorica"></div>
              
        </div>
          

          

         

 

 <?php require_once(VIEW_PATH.'footer.inc.php'); ?>
        <script type="text/javascript">

               $("#ano").on("change", function() 
                {
                    
                    //var mes = $("#mes").val();
                    //alert("hay me encanta");
                    $('#graficaHistorica').html('<div style="text-align:center;"><img src="dist/img/load_2019.gif"/></div>');
                    google.charts.load("visualization", "1", {packages:["corechart"]});
                    google.charts.setOnLoadCallback(drawPorHistorico);

                    function drawPorHistorico()
                    {
                      // Para crear la gráfica de cumplimiento histórico
                      var anoParametro = $("#ano").val();
                      var meses = ["ENERO", "FEBRERO", "MARZO", "ABRIL", "MAYO", "JUNIO", "JULIO", "AGOSTO", "SEPTIEMBRE", "OCTUBRE", "NOVIEMBRE", "DICIEMBRE"];
                      var constructorHistorico = [['',  'TOTAL', 'Preventivos', 'Correctivos',  { role: 'annotation' }, { role: 'annotation' }, { role: 'annotation' }]];

                      $.getJSON("api_mp_mc_historico.php?ano="+anoParametro, function(result)
                      {
                        $.each(meses, function(key, value)
                        {
                          var mesHistorico = "";
                          var mes = value;

                          var porcentajePreventivo = 0;
                          var porcentajeCorrectivo = 0;

                          var porcentajeMesMp = 0;
                          var porcentajeMesMc = 0;
                          var porcentajeMesTotal = 0;
                          var cuentaSemana = 0;
                          // COMPARANDO MESES
                          $.each(result, function(i, field)
                              {
                                if (field['mes'] == '01')
                                {
                                  mesHistorico = "ENERO";
                                }
                                else if(field['mes'] == '02')
                                {
                                  mesHistorico = "FEBRERO";
                                }
                                else if(field['mes'] == '03')
                                {
                                  mesHistorico = "MARZO";
                                }
                                else if(field['mes'] == '04')
                                {
                                  mesHistorico = "ABRIL";
                                }
                                else if(field['mes'] == '05')
                                {
                                  mesHistorico = "MAYO";
                                }
                                else if(field['mes'] == '06')
                                {
                                  mesHistorico = "JUNIO";
                                }
                                else if(field['mes'] == '07')
                                {
                                  mesHistorico = "JULIO";
                                }
                                else if(field['mes'] == '08')
                                {
                                  mesHistorico = "AGOSTO";
                                }
                                else if(field['mes'] == '09')
                                {
                                  mesHistorico = "SEPTIEMBRE";
                                }
                                else if(field['mes'] == '10')
                                {
                                  mesHistorico = "OCTUBRE";
                                }
                                else if(field['mes'] == '11')
                                {
                                  mesHistorico = "NOVIEMBRE";
                                }
                                else if(field['mes'] == '12')
                                {
                                  mesHistorico = "DICIEMBRE";
                                }

                                //console.log(mesHistorico);
                                if(mesHistorico == mes)
                                {
                                   porcentajePreventivo = parseFloat(field['cumplimientomp']) + parseFloat(porcentajePreventivo);
                                   porcentajeCorrectivo = parseFloat(field['cumplimientomc']) + parseFloat(porcentajeCorrectivo);

                                  cuentaSemana++;

                                }
                          
                                //console.log("ano = "+field['ano'] +" mes= " + field['mes'] + " semana= "+field['semana']);
                              });// fin de each result

                          if(porcentajePreventivo > 0)
                          {
                            porcentajeMesMp = porcentajePreventivo / cuentaSemana;  
                          }
                          else
                          {
                            porcentajeMesMp = parseFloat(porcentajePreventivo);
                          }

                          if(porcentajeCorrectivo > 0)
                          {
                            porcentajeMesMc = porcentajeCorrectivo / cuentaSemana;
                          }
                          else
                          {
                            porcentajeMesMc = parseFloat(porcentajeCorrectivo);
                          }
                              
                              
                          
                            porcentajeMesTotal = parseFloat( (porcentajeMesMp + porcentajeMesMc) / 2 );
                          
                              

                              //console.log(porcentajeMesTotal);

                              constructorHistorico.push([mes, porcentajeMesTotal, porcentajeMesMp, porcentajeMesMc,  porcentajeMesTotal, porcentajeMesMp, porcentajeMesMc]);

                              

                        });// fin de each mes

                        var data = google.visualization.arrayToDataTable(constructorHistorico);


                        var view = new google.visualization.DataView(data);
                            view.setColumns([0, 1, 
                                                {
                                                    calc: "stringify",
                                                    sourceColumn: 1,
                                                    type: "string",
                                                    role: "annotation"
                                                }, 2, {
                                                    calc: "stringify",
                                                    sourceColumn: 2,
                                                    type: "string",
                                                    role: "annotation"
                                                },
                                                3, {
                                                    calc: "stringify",
                                                    sourceColumn: 3,
                                                    type: "string",
                                                    role: "annotation"
                                                  }
                                            ]);

                            var options = {
                              //isStacked: true, barras acostadas
                              bar: {groupWidth: "90%"},
                              legend: { position: "bottom" },
                              
                              chart: {
                                //title: 'Company Performance',
                                subtitle: 'Cumplimiento mensual de MP vs MC Histórico',

                              },
                              bars: 'vertical',
                              vAxis: {
                                  //title: '% de cumplimiento',
                                  format: '#\'%\''
                                  
                                  
                              },
                              fontSize: 12,
                              height: 480,
                              'chartArea': {'width': '90%', 'height': '80%'},
                              colors: ['#337ab7', '#5cb85c', '#f0ad4e']
                            };

                            var chart = new google.visualization.ColumnChart(document.getElementById('graficaHistorica'));

                            chart.draw(view, options);

                        }); // fin de getJson
                      

                    }
                    
                });// fin de disponibilidad
  
           
        </script>

  </body>
</html>




