//O3M//
$(document).ready(function(){
	slider_semana();
	slider_horas();
	$('#reload').click(function(){
		reset_slider();	
	});
});

function reset_slider(){
	$('#btnGuardar').hide();
	slider_semana();
	slider_horas();			
}

function slider_semana(valor){
	valor = (!valor)?0:valor;
	build_slider("slider-semana", valor, 5, 0, "semana");
	btn_onoff();
}

function btn_onoff(){
	var semana = $("#semana").val();
	var restan = $('#restan').val();
	if (semana==0 || restan!=0) {
		$('#btnGuardar').hide();
	}else{
		$('#btnGuardar').show();
	}
}

function slider_horas(){	
// Contruye sliders con valores iniciales	
	var horas 			 = parseInt($("#horas").val());	
	$('#restan').val(horas);
	var restan = parseInt($('#restan').val());
	
	// **Cálculo auto** //
	var horas_acumuladas = parseInt($("#tot_horas").val());
	/*I Diario*/
	var dobles = (horas>3) ? 3 : horas;
	var triples = (horas-dobles>=1) ?  horas-dobles : 0 ;
	/*II Acumulado*/
	if(horas_acumuladas>9){
		dobles = 0;
		triples = horas;
	}
	else if(horas_acumuladas+dobles>9){
		dobles = 9 - horas_acumuladas;
		triples = horas - dobles;
	}
	// ****Fin***** //

	// 	Aplica
	restan = horas - (dobles + triples);
	horas = parseInt(horas);
	$('#restan').val(restan);
	build_slider("slider-dobles", dobles, dobles, 0, "dobles");
	build_slider("slider-triples", triples, triples, 0, "triples");
	build_slider("slider-rechazadas", 0, 0, 0, "rechazadas");
	btn_onoff();
}

function build_slider(id_Objeto, valor, max, min, idMuestra) {
// Funcion para contruir un slider
	valor = parseInt(valor);
	$("#"+id_Objeto).slider({
	  range: "min",
	  value: valor,
	  min: min,
	  max: max,
	  step: 1,
      animate: 100,
	  slide: function(event, ui) {
	    $("#"+idMuestra).val(ui.value);
	  },
	  stop: function(event,ui){
		rebuild_slider(ui.value);
	  }
	});
	var valActual = $("#"+id_Objeto).slider("value");
	$("#"+idMuestra).val(valActual);
}

function rebuild_slider(horas){
// Validacion de valores y recontruccion de sliders
	var maximo = parseInt($('#horas').val());
	var dobles = parseInt($('#dobles').val());
	var triples = parseInt($('#triples').val());
	var rechazadas = parseInt($('#rechazadas').val());
	var restan = maximo-(dobles+triples+rechazadas);
	var val = 0;
	if(restan){
		// dobles
		if(dobles < restan)
			$('#slider-dobles').slider( "option", "max", restan );
		// triples
		if(triples < restan)
			// val = restan+triple;
			$('#slider-triples').slider( "option", "max", restan );
		// rechazadas
		if(rechazadas < restan)
			$('#slider-rechazadas').slider( "option", "max", restan );			
	}else{
		$('#slider-dobles').slider( "option", "max", dobles );
		$('#slider-triples').slider( "option", "max", triples );
		$('#slider-rechazadas').slider( "option", "max", rechazadas );
	}
	// restan
	$('#restan').val(restan);
	// Boton Guardar
	btn_onoff();
}

function btnSubmit(){
	var raiz = raizPath();
	var maximo = parseInt($('#horas').val());
	var dobles = parseInt($('#dobles').val());
	var triples = parseInt($('#triples').val());
	var rechazadas = parseInt($('#rechazadas').val());
	var restan = maximo-(dobles+triples+rechazadas);
	var msj = '';
	var popup_ico = "<img src='"+raiz+"common/img/popup/error.png' class='popup-ico'>&nbsp";
	if(restan!=0){
		msj = "<div class='popup-txt'>Aún tiene <b>"+restan+"</b> horas por asignar en este registro...</div>";
		popup('Validación',popup_ico+msj,0,0,1,'horas');
		$("#horas").focus();
		return false;
	}	
	if(semana<=0){
		msj = "<div class='popup-txt'>Seleccione la semana correspondiente al periodo.</div>";
		popup('Validación',popup_ico+msj,0,0,1,'horas');
		$("#semana").focus();
		return false;
	}	
	obtenerCampos();
}

function obtenerCampos(){
	var id_horas_extra = $("#id_horas_extra").val();
	var dobles = parseInt($('#dobles').val());
	var triples = parseInt($('#triples').val());
	var rechazadas = parseInt($('#rechazadas').val());
	var semana_iso = $("#semana_iso").val();
	var anio = $('#periodo_anio').val();	
	var periodo = parseInt($('#periodo').val());
	var periodo_especial = $('#periodo_especial').val();
	var semana = parseInt($('#semana').val());
	// Creación de array con todos los datos capturados
	var array = [
		'id_horas_extra=' + id_horas_extra,
		'anio=' + anio,		
		'periodo=' + periodo,
		'periodo_especial=' + periodo_especial,
		'semana=' + semana,
		'dobles=' + dobles,
		'triples=' + triples,
		'rechazadas=' + rechazadas
	];    
	// Metemos creamos cadena con namescapes
	var separador = '|';
    var data = array.join(separador);
    //     
	guardar(data);
}

function guardar(array){
/**
* Envía datos para guardarlos en BD
*/
	var modulo = $("#mod").val().toLowerCase();
	var seccion = $("#sec").val();
	var raiz = raizPath();
	var ajax_url = raiz+"src/"+modulo+"/admin.php";
	popup_ico = "<img src='"+raiz+"common/img/wait.gif' valign='middle' align='center'>&nbsp";
	if(array){
		$.ajax({
			type: 'POST',
			url: ajax_url,
			dataType: "json",
			data: {      
				auth : 1,
				modulo : modulo,
				seccion : seccion,
				accion : 'layout-guardar',
				datos : array
			}
			,beforeSend: function(){ 
				popup_ico = "<img src='"+raiz+"common/img/popup/load.gif' valign='middle' align='texttop'>&nbsp";
				var txt = "Guardando información, por favor espere...";
		    	ventana = popup('Guardando...',popup_ico+txt,0,0,3);		    	
			}
			,success: function(respuesta){ 
				$("#"+ventana).dialog("close");
				if(respuesta.success){
					popup_ico = "<img src='"+raiz+"common/img/popup/info.png' class='popup-ico'>&nbsp";
					txt = "<div class='popup-txt'>La información ha sido guardada correctamente.</div>";
					ventana = popup('Éxito',popup_ico+txt,0,0,3);				
					setTimeout(function(){location.reload(true);}, 2000);
				}else if(respuesta.success){
					txt = respuesta.error;
					ventana = popup('Error',popup_ico+txt,0,0,3);
				}				
			}
			,complete: function(){ 
				setTimeout(function(){
					$("#"+ventana).dialog("close");
					location.reload(true);
				}, 2000);
			}
	    });
	}else{
		popup_ico = "<img src='"+raiz+"common/img/popup/alert.png' valign='middle' align='texttop'>&nbsp";
		var txt = "No hay datos para guardar.";		    
	    ventana = popup('Mensaje!',popup_ico+txt,0,0,3);
		setTimeout(function(){			
			location.reload(true);
		}, 2000);
	}
}


//O3M//