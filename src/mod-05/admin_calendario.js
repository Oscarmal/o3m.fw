//O3M//
$(document).ready(function(){
	scriptJs_Enter(); //Carga detección de ENTER
	jquery_fecha('fecha_inicio',1,false,false); //jquery_fecha(id_objeto, formato, todaylimit, minLimit)
	jquery_fecha('fecha_fin',1,false,false);

	// // Acordeon
	$('[id*=tabla-detalles]').slideToggle(300);
	$(".arrow").click(function(e){
		var id = e.target.id;
		var n = id.split('-');
		var detalles = 'tabla-detalles-'+n[1];
		$('#'+detalles).slideToggle(300);
		$('#'+id).toggleClass("up");
	});
   
});

function btnSubmit(){
	var raiz = raizPath();
	var tipo = $('#tipo').val();
	var fecha_inicio = $('#fecha_inicio').val();
	var msj = '';
	var popup_ico = "<img src='"+raiz+"common/img/popup/error.png' class='popup-ico'>&nbsp";
	if(!tipo){
		msj = "<div class='popup-txt'>Seleccione el tipo de evento, por favor...</div>";
		ventana=popup('Horas extra',popup_ico+msj,0,0,1,'tipo');
		setTimeout(function(){$("#"+ventana).dialog("close");}, 2000);
		$("#tipo").focus();
		return false;
	}
	if(!fecha_inicio){
		msj = "<div class='popup-txt'>Ingrese la fecha de inicio, por favor...</div>";
		ventana=popup('Fecha',popup_ico+msj,0,0,1,'fecha_inicio');
		setTimeout(function(){$("#"+ventana).dialog("close");}, 2000);
		$("#fecha_inicio").focus();
		return false;
	}	
	guardar();
}

function guardar(){		
	var modulo = $("#mod").val().toLowerCase(); // <-- Modulo actual del sistema
	var seccion = $("#sec").val();
	var id_usuario = $("#id_usuario").val();
	var tipo = $('#tipo option:selected').val();
	var fecha_inicio = $('#fecha_inicio').val();
	var fecha_fin = $('#fecha_fin').val();
	var empresa = $('#empresa option:selected').val();
	var raiz = raizPath();
	var ajax_url = raiz+"src/"+modulo+"/admin.php";
	popup_ico = "<img src='"+raiz+"common/img/popup/info.png' class='popup-ico'>&nbsp";
	$.ajax({
		type: 'POST',
		url: ajax_url,
		dataType: "json",
		data: {      
			auth : 1,
			modulo : modulo,
			seccion : seccion,
			accion : 'calendario-guardar-fecha',
			id_usuario: id_usuario,
			tipo : tipo,
			fecha_inicio : fecha_inicio,
			fecha_fin : fecha_fin,
			empresa : empresa
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
//O3M//