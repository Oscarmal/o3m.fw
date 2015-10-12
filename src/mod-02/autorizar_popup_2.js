//O3M//
$(document).ready(function(){
	slider_horas();
});

function slider_horas(){	
// Contruye sliders con valores iniciales	
	var tiempoextra = $("#tiempoextra").val();	
	var tiempo = tiempoextra.split(':');
	var horas = tiempo[0];
	var minutos = tiempo[1];
	$('#restan_horas').val(horas);
	$('#restan_minutos').val(minutos);
	build_slider("slider-horas", horas, horas, 0, "horas");
	build_slider("slider-minutos", minutos, minutos, 0, "minutos");
	// btn_onoff();
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
	var tiempoextra = $("#tiempoextra").val();	
	var tiempo = tiempoextra.split(':');
	var maximo_horas = parseInt(tiempo[0]);
	var maximo_minutos = parseInt(tiempo[1]);

	var horas = (parseInt($('#horas').val())<10)?'0'+parseInt($('#horas').val()):parseInt($('#horas').val());
	var minutos = (parseInt($('#minutos').val())<10)?'0'+parseInt($('#minutos').val()):parseInt($('#minutos').val());

	var tiempoextra_final = horas+':'+minutos;

	// restan
	$('#tiempoextra_final').val(tiempoextra_final);
}

function btnSubmit(){
	var raiz = raizPath();
	var tiempoextra = $("#tiempoextra").val();
	var tiempo = tiempoextra.split(':');
	var horas = parseInt($('#horas').val());
	var minutos = parseInt($('#minutos').val());
	var argumento = $('#argumento').val();
	var msj = '';
	var popup_ico = "<img src='"+raiz+"common/img/popup/error.png' class='popup-ico'>&nbsp";

	if((horas<tiempo[0] || minutos<tiempo[1]) && argumento==''){
		msj = "<div class='popup-txt'>Agregue el argumento para el tiempo rechazado.</div>";
		ventana=popup('Validación',popup_ico+msj,0,0,1,'argumento');
		setTimeout(function(){$("#"+ventana).dialog("close");}, 2000);
		$("#argumento").focus();
		return false;
	}
	obtenerCampos();
}

function obtenerCampos(){
	var id_horas_extra = $("#id_horas_extra").val();
	var dobles = parseInt($('#dobles').val());
	var triples = parseInt($('#triples').val());
	var rechazadas = parseInt($('#rechazadas').val());
	var horas = parseInt($('#horas').val());
	var minutos = parseInt($('#minutos').val());
	var argumento = $('#argumento').val();
	var fecha = $("#fecha").val(); 
	var f = fecha.split('/');
	var anio = f[2];
	// Creación de array con todos los datos capturados
	var array = [
		'id_horas_extra=' + id_horas_extra,
		'dobles=' + dobles,
		'triples=' + triples,
		'rechazadas=' + rechazadas,
		'horas=' + horas,
		'minutos=' + minutos,
		'argumento=' + argumento
	];    
	// Metemos creamos cadena con namescapes
	var separador = '|';
    var data = array.join(separador);
    // 
	guardar(data);
}

function guardar(array){
	var modulo = $("#mod").val().toLowerCase();
	var seccion = $("#sec").val();
	var raiz = raizPath();
	var ajax_url = raiz+"src/"+modulo+"/autorizacion.php";
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
				accion : 'autorizacion2-guardar',
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