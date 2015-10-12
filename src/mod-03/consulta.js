//O3M//
$(document).ready(function(){
	scriptJs_Enter(); //Carga detección de ENTER
	jquery_fecha('txtFecha');
	jgrid('jGrid');
});

function popup_override(id_horas_extra, dobles, triples, rechazadas){
/**
* AJAX: Genera popup para validación de hotras extra
*/
	$("#layout-popup").empty();
	var raiz = raizPath();
	var modulo = $("#mod").val().toLowerCase(); // <-- Modulo actual del sistema
	var seccion = $("#sec").val();	
	var ajax_url = raiz+"src/"+modulo+"/consulta.php";	
	var contenidoHtml = '<div id="layout-popup"></div>';
	popup_ico = "<img src='"+raiz+"common/img/wait.gif' valign='middle' align='center'>&nbsp";
	$.ajax({
		type: 'POST',
		url: ajax_url,
		dataType: "json",
		data: {      
			auth : 1,
			modulo : modulo,
			accion : 'popup-override',
			id_horas_extra : id_horas_extra,
			dobles : parseInt(dobles),
			triples : parseInt(triples),
			rechazadas : parseInt(rechazadas)
		}		
		,success: function(respuesta){ 
			if(respuesta.success){
				var vistaHTML = respuesta.html;				
				ventana = popup('Layout',contenidoHtml,550,650,3);
				$("#layout-popup").html(vistaHTML);
			}else if(respuesta.success){
				var popup_ico = "<img src='"+raiz+"common/img/popup/error.png' class='popup-ico'>&nbsp";
				txt = respuesta.error;
				ventana = popup('Error',popup_ico+txt,0,0,3);
			}				
		}
    });
}

function descargar_xls(tipo){
	var modulo = $("#mod").val().toLowerCase(); // <-- Modulo actual del sistema
	var seccion = $("#sec").val();
	var raiz = raizPath();
	var ajax_url = raiz+"src/"+modulo+"/consulta.php";
	switch(tipo) {
	    case 1: var accion = 'xls_consulta_autorizaciones'; break;
	    case 2: var accion = 'xls_seguimiento_autorizaciones'; break;
	    case 3: var accion = 'xls_seguimiento_pendientes'; break;
	}
	$.ajax({
		type: 'POST',
		url: ajax_url,
		dataType: "json",
		data: {      
			auth : 1,
			modulo : modulo,
			seccion : seccion,
			accion : accion
		}
		,success: function(respuesta){		 
			if(respuesta.success){	
				window.location.href=respuesta.xls.url;
			}				
		}
    });	
}

//O3M//