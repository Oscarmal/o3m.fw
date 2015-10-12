//O3M//
$(document).ready(function(){
	// Chosen
	var config = {
      '.chosen-select'           : {},
      '.chosen-select-deselect'  : {allow_single_deselect:true},
      '.chosen-select-no-single' : {disable_search_threshold:10},
      '.chosen-select-no-results': {no_results_text:'No existe el valor buscado!'},
      '.chosen-select-width'     : {width:"95%"}
    }
    for (var selector in config) {
      $(selector).chosen(config[selector]);
    }
    // fin Chosen
});

function guardar_supervisor(){
	
	var nivel1	 		 =  $( "#nivel1 option:selected" ).val();
	var nivel2	 		 =  $( "#nivel2 option:selected" ).val();
	var nivel3	 		 =  $( "#nivel3 option:selected" ).val();
	var nivel4	 		 =  $( "#nivel4 option:selected" ).val();
	var nivel5	 		 =  $( "#nivel5 option:selected" ).val();
	var nivel;
	var raiz = raizPath();
	var modulo = $("#mod").val().toLowerCase(); // <-- Modulo actual del sistema
	var seccion = $("#sec").val();	
	var ajax_url = raiz+"src/"+modulo+"/admin.php";	
	var id_personal = $('#id_personal').val();
	var id_empresa 	= $('#id_empresa').val();
	popup_ico = "<img src='"+raiz+"common/img/wait.gif' valign='middle' align='center'>&nbsp";
	
	$.ajax({
			type: 'POST',
			url: ajax_url,
			dataType: "json",
			data: {      
				auth : 1,
				modulo : modulo,
				seccion : seccion,
				accion : 'supervisor-guardar',
				nivel : nivel,
				id_personal : id_personal,
				id_empresa 	: id_empresa,
				nivel1 : nivel1,
				nivel2 : nivel2,
				nivel3 : nivel3,
				nivel4 : nivel4,
				nivel5 : nivel5
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
}

function modificar_usuario(){
	var raiz = raizPath();
	var modulo = $("#mod").val().toLowerCase(); // <-- Modulo actual del sistema
	var seccion = $("#sec").val();	
	var ajax_url = raiz+"src/"+modulo+"/admin.php";	
	var nombre			 =	$('#nombre').val();
	var apellido_paterno =	$('#apellido_paterno').val();
	var apellido_materno =	$('#apellido_materno').val();
	var correo			 =	$('#correo').val();
	var sucursal 		 =	$('#sucursal').val();
	var no_empleado	     =	$('#no_empleado').val();
	var id_nomina	     =	$('#id_nomina').val();
	var id_empresa 		 =  $("#id_empresa").val();
	var id_personal 	 =  $("#id_personal").val();;
	popup_ico = "<img src='"+raiz+"common/img/wait.gif' valign='middle' align='center'>&nbsp";
	
	$.ajax({
			type: 'POST',
			url: ajax_url,
			dataType: "json",
			data: {      
				auth : 1,
				modulo : modulo,
				seccion : seccion,
				accion : 'modificar-usuario',
				nombre : nombre,
				apellido_paterno : apellido_paterno,
				apellido_materno : apellido_materno,
				correo : correo,
				sucursal : sucursal,
				no_empleado : no_empleado,
				id_nomina : id_nomina,
				id_empresa  : id_empresa,
				id_personal : id_personal
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
}