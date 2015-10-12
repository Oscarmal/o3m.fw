//O3M//
$(document).ready(function(){
	$("#txtUsuario").focus();
	scriptJs_Enter(); //Carga detección de ENTER
});

function btnSubmit(){
	var raiz = raizPath();
	var usuario = $('#txtUsuario').val();
	var clave = $('#txtClave').val();
	var msj = '';
	var popup_ico = "<img src='"+raiz+"common/img/popup/error.png' valign='middle' align='texttop'>&nbsp";
	if(usuario == ''){		
		msj = 'Ingrese su Usuario, por favor...';
		ventana=popup('Usuario',popup_ico+msj,450,0,3,'txtUsuario');
		setTimeout(function(){$("#"+ventana).dialog("close");}, 2000);
		$("#txtUsuario").focus();
		return false;
	}
	if(clave == ''){
		msj = 'Ingrese su Clave, por favor...';
		ventana=popup('Clave',popup_ico+msj,450,0,3,'txtClave');
		setTimeout(function(){$("#"+ventana).dialog("close");}, 2000);
		$("#txtClave").focus();
		return false;
	}	
	login(usuario, clave);
}

function login(usuario, clave){
	var modulo 	      = $("#mod").val().toLowerCase(); // <-- Modulo actual del sistema
	var seccion 	  = $("#sec").val();
	var raiz 		  = raizPath();
	var ajax_url 	  = raiz+"src/"+modulo+"/login.php";
	var contenidoHtml = '<div id="logueo-popup"></div>';
	$.ajax({
		type: 'POST',
		url: ajax_url,
		dataType: "json",
		data: {      
			auth    : 1,
			modulo  : modulo,
			s 	    : seccion,
			accion	: 'login-perfiles',
			usuario : usuario,
			clave   : clave
		},
		beforeSend: function(){
			popup_ico = "<img src='"+raiz+"common/img/popup/load.gif' valign='middle' align='texttop'>&nbsp";
			txt = "Validando credenciales, por favor espere...";
		    ventana=popup('Autentificando',popup_ico+txt,460,0,3);  		    
		},
		success: function(respuesta){ 
			if(respuesta.success=='primer-logueo'){				
				$("#"+ventana).dialog("close");
				var vistaHTML = respuesta.html;
				ventana = popup('Primer Ingreso - Asigne su contraseña',contenidoHtml,450,280,3);
				$("#logueo-popup").html(vistaHTML);
			}else if(respuesta.success=='autorizado'){
				setTimeout(function(){	$(location).attr('href', respuesta.url)	}, 2000);
			}else if(respuesta.success=='popup'){
				$("#"+ventana).dialog("close");
				var vistaHTML = respuesta.html;	
				ventana = popup('Selección de perfil',contenidoHtml,600,200,3);
				$("#logueo-popup").html(vistaHTML);
			}
			else {
				setTimeout(function(){	$(location).attr('href', respuesta.url)	}, 2000);	
			}
		},
		complete: function(){    			
		    $("#popups-alerts").empty();
		}
    });
}

function perfil(id_usuario){
	var modulo 	      = $("#mod").val().toLowerCase(); // <-- Modulo actual del sistema
	var seccion 	  = $("#sec").val();
	var raiz 		  = raizPath();
	var ajax_url 	  = raiz+"src/"+modulo+"/login.php";
	var contenidoHtml = '<div id="logueo-popup"></div>';
	$.ajax({
		type: 'POST',
		url: ajax_url,
		dataType: "json",
		data: {      
			auth    : 1,
			modulo  : modulo,
			s 	    : seccion,
			accion	: 'login-perfil-select',
			id_usuario : id_usuario
		},
		success: function(respuesta){ 
			if(respuesta){
				$(location).attr('href', respuesta.url);
			}
		}
    });
}
//O3M//