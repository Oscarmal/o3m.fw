//O3M//
$(document).ready(function(){
	slider_semana();
});

function reset_slider(){
	$('#btnGuardar').hide();
	slider_semana();		
}

function slider_semana(valor){
	valor = (!valor)?0:valor;
	build_slider("slider-semana", valor, 5, 0, "semana");
	btn_onoff();
}

function btn_onoff(){
	var semana = $("#semana").val();
	if (semana==0 ) {
		$('#btnGuardar').hide();
	}else{
		$('#btnGuardar').show();
	}
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
		btn_onoff();
	  }
	});
	var valActual = $("#"+id_Objeto).slider("value");
	$("#"+idMuestra).val(valActual);
}

function btnSubmit(){
	var raiz = raizPath();
	var msj = '';
	var popup_ico = "<img src='"+raiz+"common/img/popup/error.png' class='popup-ico'>&nbsp";
	if(semana<=0){
		msj = "<div class='popup-txt'>Seleccione la semana correspondiente al periodo.</div>";
		popup('Validación',popup_ico+msj,0,0,1,'horas');
		$("#semana").focus();
		return false;
	}	
	obtenerCampos();
}

function obtenerCampos(){
	var ids = $("#ids").val();
	var anio = $('#periodo_anio').val();	
	var periodo = parseInt($('#periodo').val());
	var periodo_especial = $('#periodo_especial').val();
	var semana = parseInt($('#semana').val());
	// Creación de array con todos los datos capturados
	ids = ids.split('|').join(',');
	var array = [
		'ids=' + ids,
		'anio=' + anio,		
		'periodo=' + periodo,
		'periodo_especial=' + periodo_especial,
		'semana=' + semana
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