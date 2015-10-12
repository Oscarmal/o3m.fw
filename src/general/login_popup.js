function contrasenia(accion){
	if(accion=='primer_logueo'){primer_logueo();}
	else if(accion=='contrasenia_popup'){contrasenia_popup();}
	else if(accion=='contrasenia_cambio'){contrasenia_cambio();}
}

function primer_logueo(){	
	var modulo 	      = $("#mod").val().toLowerCase(); // <-- Modulo actual del sistema
	var seccion 	  = $("#sec").val();
	var raiz 		  = raizPath();
	var ajax_url 	  = raiz+"src/"+modulo+"/login.php";
	var pass  		  = $("#pass").val();
	var confirm  	  = $("#confirm").val();
	
	if(pass==''){
		alert('No puede estar ningún campo vacío');
		return false;
	}
	if(pass!=confirm){
		alert('La contraseña no coincide. Favor de Verificar.');
		return false;
	}	
	$.ajax({
		type: 'POST',
		url: ajax_url,
		dataType: "json",
		data: {      
			auth    : 1,
			modulo  : modulo,
			accion 	: 'primer_logueo',
			s 	    : seccion,
			pass   	: pass
		},
		beforeSend: function(){
			popup_ico = "<img src='"+raiz+"common/img/popup/load.gif' valign='middle' align='texttop'>&nbsp";
			txt = "Actualizando información, por favor espere...";
		    ventana=popup('Autentificando',popup_ico+txt,0,0,3);  		    
		},
		success: function(respuesta){ 
			if(respuesta.success==='logueo'){
				$("#"+ventana).dialog("close");
				var vistaHTML = respuesta.url;
				ventana = popup('Primer Ingreso - Asigne su contraseña',contenidoHtml,450,300,3);
				$("#logueo-popup").html(vistaHTML);
			}
			else if(respuesta.success==='igual'){
				alert('La contraseña no puede ser registrada, intente con una diferente.');
				$("#pass").val('');
				$("#confirm").val('');
				$("#"+ventana).dialog("close");
				return false;
			}
			else if(respuesta.success){
				setTimeout(function(){	$(location).attr('href', respuesta.url)	}, 2000);
			}
		},
		complete: function(){    			
		    $("#popups-alerts").empty();
		}
    });
}

function contrasenia_popup(){
	var modulo 	      = 'general'; // <-- Modulo actual del sistema
	var seccion 	  = $("#sec").val();
	var raiz 		  = raizPath();
	var ajax_url 	  = raiz+"src/"+modulo+"/login.php";
	var contenidoHtml = '<div id="layout-popup"></div>';
	$.ajax({
		type: 'POST',
		url: ajax_url,
		dataType: "json",
		data: {      
			auth    : 1,
			modulo  : modulo,
			accion 	: 'contrasenia_popup',
			s 	    : seccion
		},
		success: function(respuesta){ 
			if(respuesta.success){
				var vistaHTML = respuesta.html;
				ventana = popup('Cambio de Contraseña',contenidoHtml,450,280,3);
				$("#layout-popup").html(vistaHTML);
			}else if(respuesta.success){
				var popup_ico = "<img src='"+raiz+"common/img/popup/error.png' class='popup-ico'>&nbsp";
				txt = respuesta.error;
				ventana = popup('Error',popup_ico+txt,0,0,3);
			}
		},
		complete: function(){    			
		    $("#popups-alerts").empty();
		}
    });
}

function contrasenia_cambio(){
	var modulo 	   	= 'general'; // <-- Modulo actual del sistema
	var seccion 	= $("#sec").val();
	var raiz 		= raizPath();
	var ajax_url 	= raiz+"src/"+modulo+"/login.php";
	var pass  		= $("#pass").val();
	var confirm  	= $("#confirm").val();
	
	if(pass==''){
		alert('No puede estar ningún campo vacío');
		return false;
	}	
	if(pass!=confirm){
		alert('La contraseña no coincide. Favor de Verificar.');
		return false;
	}	
	$.ajax({
		type: 'POST',
		url: ajax_url,
		dataType: "json",
		data: {      
			auth    : 1,
			modulo  : modulo,
			accion 	: 'contrasenia_cambio',
			s 	    : seccion,
			pass   	: pass
		},
		beforeSend: function(){
			popup_ico = "<img src='"+raiz+"common/img/popup/load.gif' valign='middle' align='texttop'>&nbsp";
			txt = "Actualizando información, por favor espere...";
		    ventana=popup('Autentificando',popup_ico+txt,0,0,3);  		    
		},
		success: function(respuesta){ 
			if(respuesta.success==='logueo'){
				$("#"+ventana).dialog("close");
				var vistaHTML = respuesta.url;
				ventana = popup('Primer Ingreso',contenidoHtml,450,300,3);
				$("#logueo-popup").html(vistaHTML);
			}
			else if(respuesta.success){
				setTimeout(function(){	$(location).attr('href', respuesta.url)	}, 2000);
			}
		},
		complete: function(){    			
		    $("#popups-alerts").empty();
		}
    });
}