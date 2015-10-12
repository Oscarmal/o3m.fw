//O3M//
$(document).ready(function(){
	scriptJs_Enter(); //Carga detección de ENTER
	$("#txtHoras").focus();
	// jquery_fecha('txtFecha',1,true,true);
	jquery_fecha_periodo('txtFecha',$("#periodo_inicio").val(),$("#periodo_fin").val(),1);
	jgrid('jGrid');
	slider_horas();
	$("#txtFecha").mask("99/99/9999",{placeholder:"dd/mm/yyyy"});
	// $("#txtHoras").mask("99",{placeholder:"00"});
	// $("#txtMinutos").mask("99",{placeholder:"00"});
});

function btnSubmit(){
	var raiz = raizPath();
	var horas = $('#txtHoras').val();
	var minutos = $('#txtMinutos').val();
	var fecha = $('#txtFecha').val();
	var p_inicio = $('#periodo_inicio').val();
	var p_fin = $('#periodo_fin').val();
	var msj = '';
	var popup_ico = "<img src='"+raiz+"common/img/popup/error.png' class='popup-ico'>&nbsp";

	if(horas == '0' && minutos == '0'){
		msj = "<div class='popup-txt'>Ingrese la cantidad de tiempo extra trabajado, por favor...</div>";
		ventana=popup('Tiempo extra',popup_ico+msj,0,0,1,'txtHoras');
		setTimeout(function(){$("#"+ventana).dialog("close");}, 2000);
		$("#txtHoras").focus();
		return false;
	}
	if(horas > 15 ){
		msj = "<div class='popup-txt'>Ingrese una cantidad de horas válida, por favor...</div>";
		ventana=popup('Tiempo extra',popup_ico+msj,0,0,1,'txtHoras');
		setTimeout(function(){$("#"+ventana).dialog("close");}, 2000);
		$("#txtHoras").focus();
		return false;
	}
	if(minutos > 59){
		msj = "<div class='popup-txt'>Ingrese una cantidad de minutos válida, por favor...</div>";
		ventana=popup('Tiempo extra',popup_ico+msj,0,0,1,'txtHoras');
		setTimeout(function(){$("#"+ventana).dialog("close");}, 2000);
		$("#txtMinutos").focus();
		return false;
	}
	if(fecha == ''){
		msj = "<div class='popup-txt'>Seleccione la fecha en la que se trabajó, por favor...</div>";
		ventana=popup('Fecha',popup_ico+msj,0,0,1,'txtFecha');
		setTimeout(function(){$("#"+ventana).dialog("close");}, 2000);
		$("#txtFecha").focus();
		return false;
	}	
	if(!validar_fecha(fecha)){
		msj = "<div class='popup-txt'>La fecha ingesada ("+fecha+") no corresponde al periodo actual del "+p_inicio+" al "+p_fin+"</div>";
		ventana=popup('Tiempo extra',popup_ico+msj,0,0,1,'txtFecha');
		setTimeout(function(){$("#"+ventana).dialog("close");}, 2000);
		$("#txtFecha").focus();
		return false;
	}
	guardar(horas, minutos, fecha);
}

function guardar(horas, minutos, fecha){		
	var modulo = $("#mod").val().toLowerCase(); // <-- Modulo actual del sistema
	var seccion = $("#sec").val();
	var id_usuario = $("#id_usuario").val();
	var raiz = raizPath();
	var ajax_url = raiz+"src/"+modulo+"/captura.php";
	popup_ico = "<img src='"+raiz+"common/img/popup/info.png' class='popup-ico'>&nbsp";
	$.ajax({
		type: 'POST',
		url: ajax_url,
		dataType: "json",
		data: {      
			auth : 1,
			modulo : modulo,
			seccion : seccion,
			accion : 'insert',
			id_usuario: id_usuario,
			horas : horas,
			minutos : minutos,
			fecha : fecha
		},
		beforeSend: function(){    
			popup_ico = "<img src='"+raiz+"common/img/popup/load.gif' valign='middle' align='texttop'>&nbsp";
			var txt = "<div class='popup-txt'>Guardando información, por favor espere...</div>";		    
		    ventana = popup('Guardando...',popup_ico+txt,0,0,3);		    
		},
		success: function(respuesta){ 
			$("#"+ventana).dialog( "close" );
			if(respuesta.success){
				popup_ico = "<img src='"+raiz+"common/img/popup/info.png' class='popup-ico'>&nbsp";	
				txt = "<div class='popup-txt'>La información ha sido guardada correctamente.</div>";
				ventana = popup('Éxito',popup_ico+txt,0,0,3);								
			}else if(respuesta.duplicado){
				popup_ico = "<img src='"+raiz+"common/img/popup/error.png' class='popup-ico'>&nbsp";
				txt = txt = "<div class='popup-txt'>Ya existe una captura para esta fecha.</div>";
				ventana = popup('Sin guardar',popup_ico+txt,0,0,3);
			}else if(!respuesta.success){
				popup_ico = "<img src='"+raiz+"common/img/popup/error.png' class='popup-ico'>&nbsp";
				txt = respuesta.message;
				ventana = popup('Error',popup_ico+txt,0,0,3);
			}				
			setTimeout(function(){location.reload(true);}, 2000);
		}
		,complete: function(){ 
			setTimeout(function(){
				$("#"+ventana).dialog("close");
				location.reload(true);
			}, 2000);
		}
    });
}

// Slider---
function slider_horas(){	
// Contruye sliders con valores iniciales
	build_slider("slider-horas", 0, 15, 0, "txtHoras");
	build_slider("slider-minutos", 0, 59, 0, "txtMinutos");
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
		// rebuild_slider(ui.value);
	  }
	});
	var valActual = $("#"+id_Objeto).slider("value");
	$("#"+idMuestra).val(valActual);
}
// ---

function validar_fecha(fecha){
// Verifica que la fecha capturada este dentro del periodo activo
	// Periodo inicio
	var p_inicio=new Date();
	var pi = $('#periodo_inicio').val().split("-");
	p_inicio.setFullYear(pi[0],pi[1]-1,pi[2]);
	// Periodo fin
	var p_fin=new Date();
	var pf = $('#periodo_fin').val().split("-");
	p_fin.setFullYear(pf[0],pf[1]-1,pf[2]);
	// Fecha capturada
	var f_capturada=new Date();
	var f = fecha.split("/");
	f_capturada.setFullYear(f[2],f[1]-1,f[0]);
	// Comparacion
	if(f_capturada>=p_inicio && f_capturada<=p_fin){
		return true;
	}else{
		return false;
	}
}

//O3M//