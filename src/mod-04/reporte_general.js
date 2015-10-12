//O3M//
$(document).ready(function(){
	var empresa_inicial = ($("#id_empresa").val())?$("#id_empresa").val():false;
	datos_grafico01('grafico01', empresa_inicial);
	anios_empresa(empresa_inicial);
	tabla_acordeon();

	$("#div_empresa").change(function () { 
        var id_empresa = $("#div_empresa option:selected").val();
        anios_empresa(id_empresa);
        datos_tabla(id_empresa);
    });

    $("#div_anio").change(function () { 
    	var id_empresa = $("#div_empresa option:selected").val();
        var anio = $("#div_anio option:selected").val();
        datos_grafico01('grafico01', id_empresa, anio); 
        datos_tabla(id_empresa, anio);              
    });

    $("#div_periodo").change(function () { 
    	var id_empresa = $("#div_empresa option:selected").val();
        var periodo = $("#div_periodo option:selected").val();
        var anio 		= (!anio)? '' : anio ;
        datos_grafico01('grafico01', id_empresa, anio, periodo); 
        datos_tabla(id_empresa, anio, periodo);              
    });
});

function tabla_acordeon(){
	$('[id*=tabla-detalles]').slideToggle(300);
	$(".arrow").click(function(e){
		var id = e.target.id;
		var n = id.split('-');
		var detalles = 'tabla-detalles-'+n[1];
		$('#'+detalles).slideToggle(300);
		$('#'+id).toggleClass("up");
	});
}

function datos_tabla(id_empresa, anio, periodo){
	var id_empresa 	= (!id_empresa)? '' : id_empresa ;
	var anio 		= (!anio)? '' : anio ;
	var periodo 	= (!periodo)? '' : periodo ;
	var modulo = $("#mod").val().toLowerCase(); // <-- Modulo actual del sistema
	var seccion = $("#sec").val();
	var raiz = raizPath();
	var ajax_url = raiz+"src/"+modulo+"/reportes.php";
	$.ajax({
		type: 'POST',
		url: ajax_url,
		dataType: "json",
		data: {      
			auth : 1,
			modulo : modulo,
			seccion : seccion,
			accion : 'rebuild_reporte01',
			id_empresa : id_empresa,
			anio : anio,
			periodo : periodo
		}
		,success: function(respuesta){ 
		if(respuesta.success){
				$('#tbl_grupos tbody').empty();
				$('#tbl_grupos tbody').append(respuesta.tabla);
				tabla_acordeon();
			}				
		}
    });	
}

function datos_grafico01(idObjeto, id_empresa, anio, periodo){	
/*
* Grafica Conceptos por Año
*/	
	var id_empresa 	= (!id_empresa)? '' : id_empresa ;
	var anio 		= (!anio)? '' : anio ;
	var periodo 	= (!periodo)? '' : periodo ;
	var modulo 		= $("#mod").val().toLowerCase(); // <-- Modulo actual del sistema
	var seccion 	= $("#sec").val();
	var raiz 		= raizPath();
	var ajax_url 	= raiz+"src/"+modulo+"/reportes.php";
	$.ajax({
		type: 'POST',
		url: ajax_url,
		dataType: "json",
		data: {      
			auth : 1,
			modulo : modulo,
			seccion : seccion,
			accion : 'grafico01',
			id_empresa: id_empresa,
			anio: anio,
			periodo : periodo
		}
		,success: function(respuesta){ 				
			if(respuesta.success){
				// alert(dump_var(respuesta));				
				var anios = new Array();
				var series = new Array();
				var valores = new Array();
				var pie_data = new Array();
				var t1 = new Array();
				var t2 = new Array();
				var t3 = new Array();
				var t4 = new Array();
				var t5 = new Array();
				var totales = new Array();

				// Valores Barras
			    if(respuesta.regs>1){			    	
					$.each(respuesta.datos, function(i, val) {	
						anios[i] = val.anio_fecha;				      

			        	t1.push(parseFloat(val.autorizadas_porcentaje));
			        	t2.push(parseFloat(val.rechazadas_porcentaje));
			        	t3.push(parseFloat(val.pendientes_porcentaje));			        	
			        	t4.push(parseFloat(val.pagadas_porcentaje));
			        	t5.push(parseFloat(val.capturadas_porcentaje));
				    });
				    valores[0] = t1;
				    valores[1] = t2;
				    valores[2] = t3;
				    valores[3] = t4;
				    valores[4] = t5;
				    var empresa = respuesta.datos[0]['empresa'];
				}else{
					var val = respuesta.datos;
					anios = [val.anio_fecha.toString()];			 

		        	valores[0]=[parseFloat(val.autorizadas_porcentaje)];
		        	valores[1]=[parseFloat(val.rechazadas_porcentaje)];
		        	valores[2]=[parseFloat(val.pendientes_porcentaje)];
		        	valores[3]=[parseFloat(val.pagadas_porcentaje)];
		        	var empresa = respuesta.datos['empresa'];		        	
				}

				// Nombre de Barras
				var series_nombre = ['Autorizadas','Rechazadas','Pendientes','Pagadas'/*,'Capturadas'*/];

				// Nombre de categorias (Años)
				var categorias = anios;				

				$.each(series_nombre, function(i) {
				// Array de Barras
					series[i] = {
			        		type: 'column',
				            name: series_nombre[i],
				            data: valores[i] 
					};	
				});

				// Valores Pie
	        	// totales[3] = respuesta.totales['capturadas'];
	        	totales[0] = respuesta.totales['autorizadas'];
	        	totales[1] = respuesta.totales['rechazadas'];
	        	totales[2] = respuesta.totales['pendientes'];
	        	totales[3] = respuesta.totales['pagadas'];
				$.each(series_nombre, function(i) {
				// Array de Pie
					pie_data[i] = {
				            name: series_nombre[i],
				            y: (totales[i]),
				            color: Highcharts.getOptions().colors[i]
					};

				});
		        var pie = {
		        	type: 'pie',
		            name: 'Horas totales',
		        	center: [30, 10],
		            size: 100,
		            showInLegend: false,
		            dataLabels: {
		                enabled: false
		            },
		            data: pie_data
		        };
				series.push(pie);

				// Average
				// average = {
		  //           type: 'spline',
		  //           name: 'Average',
		  //           data: pie_data,
		  //           dataLabels: {
		  //               enabled: true
		  //           },
		  //           marker: {
		  //               lineWidth: 2,
		  //               lineColor: Highcharts.getOptions().colors[4],
		  //               fillColor: 'white'
		  //           }
		  //       };
		  //       series.push(average);

				// Array con valores finales para Gráfica
				var graficas = series;

			/* GRAFICA */
				$(function () {
				    $('#'+idObjeto).highcharts({
				        title: {
				            text:  "Horas extra por Año"
				        }
				        ,
				        subtitle: {
				            text: empresa
				        },
				        credits: {
				        	enabled: true,
				            text: fechaHoy(0,0,1)+' | ISolution.mx',
				            href: 'http://www.isolution.mx'
				        },
				        xAxis: {
				            categories: categorias,
				            labels: {
				                overflow: 'justify'
				            }
				            ,title: {
				                text: 'Años Transcurridos'
				            }
				        },
						yAxis: {
							labels: {
				                format: '{value} Hrs',
				                overflow: 'justify'
				            },
				            title: {
				                text: 'Horas'
				            }
						}
						,
				        labels: {
				            items: [{
				                html: 'Total de Horas Extra',
				                style: {
				                    left: '-5px',
				                    top: '-45px',
				                    color: (Highcharts.theme && Highcharts.theme.textColor) || 'black'
				                }
				            }]
				        }
				        ,
				        plotOptions: {
				            series: {
				                borderWidth: 0,
				                dataLabels: {
			                     	enabled: true,
									// borderRadius: 5,
									// backgroundColor: 'rgba(214, 235, 235, 0.5)',
									// borderWidth: 1,
									// borderColor: '#AAA',
									// y: -6
				                }		
				            }
				        }
				        ,
				        series: graficas
				    });
				});
			/* FIN --- */

			}else if(respuesta.success){
				return false;
			}				
		}
    });
}

function datos_grafico02(idObjeto, id_empresa, anio){	
	var id_empresa 	= (!id_empresa)? '' : id_empresa ;
	var anio 		= (!anio)? '' : anio ;
	var modulo 		= $("#mod").val().toLowerCase(); // <-- Modulo actual del sistema
	var seccion 	= $("#sec").val();
	var raiz 		= raizPath();
	var ajax_url 	= raiz+"src/"+modulo+"/reportes.php";
	$.ajax({
		type: 'POST',
		url: ajax_url,
		dataType: "json",
		data: {      
			auth : 1,
			modulo : modulo,
			seccion : seccion,
			accion : 'grafico01',
			id_empresa: id_empresa,
			anio: anio
		}
		,success: function(respuesta){ 				
			if(respuesta.success){
				alert(dump_var(respuesta));
				var anios = new Array();
				var series = new Array();
				var valores = new Array();
				var categorias = ['Capturadas','Autorizadas','Rechazadas','Pendientes'];
				var pie_data = new Array();
				if(respuesta.regs>1){
					$.each(respuesta.datos, function(i, val) {	
						anios[i] = val.anio_fecha;
				        valores[i] = [
			        		parseInt(val.horas_capturadas), 
			        		parseInt(val.horas_autorizadas), 
			        		parseInt(val.horas_rechazadas),
			        		parseInt(val.horas_pendientes)
			        	];
				        series[i] = {
			        		type: 'column',
				            name: anios[i],
				            data: valores[i]
					    };				        
				    });
				}else{
					var val = respuesta.datos;
					anios = val.anio_fecha.toString();			        
			        valores = [
		        		parseInt(val.horas_capturadas), 
		        		parseInt(val.horas_autorizadas),
		        		parseInt(val.horas_rechazadas), 
		        		parseInt(val.horas_pendientes)
		        	];
			        series = [{
		        		type: 'column',
			            name: anios,
			            data: valores
				    }];
				}
				
				// Pie
				pie_data = [{		            
	                name: anios,
	                y: valores[0],
	                color: Highcharts.getOptions().colors[0]		            
		        }];
		        var pie = {
		        	type: 'pie',
		            name: 'Horas totales',
		        	center: [30, 10],
		            size: 100,
		            showInLegend: false,
		            dataLabels: {
		                enabled: false
		            },
		            data: pie_data
		        };
				series.push(pie);

			    // alert(dump_var(series));
			    
			    // Original
			    series_ = [{
				            type: 'column',
				            name: 'Empresa 1',
				            data: [3, 2]
				        }
				        , {
				            type: 'column',
				            name: 'Empresa 2',
				            data: [2, 3]
				        }
				        , {
				            type: 'column',
				            name: 'Empresa 3',
				            data: [4, 3]
				        }
				        , {
				            type: 'spline',
				            name: 'Average',
				            data: [3, 2.67],
				            marker: {
				                lineWidth: 2,
				                lineColor: Highcharts.getOptions().colors[3],
				                fillColor: 'white'
				            }
				        }
				        , {
				            type: 'pie',
				            name: 'Horas totales',
				            data: [{
				                name: 'Empresa 1',
				                y: 5,
				                color: Highcharts.getOptions().colors[0] // Jane's color
				            }, {
				                name: 'Empresa 2',
				                y: 5,
				                color: Highcharts.getOptions().colors[1] // John's color
				            }, {
				                name: 'Empresa 3',
				                y: 7,
				                color: Highcharts.getOptions().colors[2] // Joe's color
				            }],
				            center: [30, 10],
				            size: 100,
				            showInLegend: false,
				            dataLabels: {
				                enabled: false
				            }
				        }
				        ];
				    alert(dump_var(series));

				// Valores
			    var graficas = series;

			// GRAFICA
				$(function () {
				    $('#'+idObjeto).highcharts({
				        title: {
				            text: 'Horas extra por Año'
				        },
				        credits: {
				        	enabled: true,
				            text: 'ISolution.mx',
				            href: 'http://www.isolution.mx'
				        },
				        xAxis: {
				            // categories: anios
				            categories: categorias
				        },
				        labels: {
				            items: [{
				                html: 'Total de Horas Extra',
				                style: {
				                    left: '7px',
				                    top: '-45px',
				                    color: (Highcharts.theme && Highcharts.theme.textColor) || 'black'
				                }
				            }]
				        },
				        series: graficas
				    });
				});
			// FIN ---

			}else if(respuesta.success){
				return false;
			}				
		}
    });
}

function anios_empresa(id_empresa){
	var modulo = $("#mod").val().toLowerCase(); // <-- Modulo actual del sistema
	var seccion = $("#sec").val();
	var raiz = raizPath();
	var ajax_url = raiz+"src/"+modulo+"/reportes.php";
	$.ajax({
		type: 'POST',
		url: ajax_url,
		dataType: "json",
		data: {      
			auth : 1,
			modulo : modulo,
			seccion : seccion,
			accion : 'rebuild_sel_anio',
			id_empresa : id_empresa
		}
		,success: function(respuesta){		 
		if(respuesta.success){	
				$('#div_anio').html(respuesta.sel_anio);
				datos_grafico01('grafico01', id_empresa);
			}				
		}
    });	
}

//O3M//