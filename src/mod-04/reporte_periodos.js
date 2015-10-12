//O3M//
$(document).ready(function(){
	var empresa_inicial = ($("#id_empresa").val())?$("#id_empresa").val():false;
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
        datos_tabla(id_empresa, anio);              
    });

    // $("#div_periodo").change(function () { 
    // 	var id_empresa = $("#div_empresa option:selected").val();
    //     var periodo = $("#div_periodo option:selected").val();
    //     var anio 		= (!anio)? '' : anio ;
    //     datos_tabla(id_empresa, anio, periodo);              
    // });
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
			}				
		}
    });	
}


function descargar_xls(id_empresa, anio, periodo, periodo_especial){
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
			accion : 'xls_reporte_periodo',
			id_empresa : id_empresa,
			anio : anio,
			periodo : periodo,
			periodo_especial : periodo_especial
		}
		,success: function(respuesta){		 
			if(respuesta.success){	
				window.location.href=respuesta.xls.url;
			}				
		}
    });	
}
//O3M//