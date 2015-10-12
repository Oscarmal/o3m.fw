//O3M//
$(document).ready(function(){
	// scriptJs_Enter('autorizacion'); //Carga detección de ENTER
	jgrid('jGrid','todos');
	select_all();
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

function btnSubmit(){
	sincronizar();
}

function sincronizar(){		
	var raiz = raizPath();
	var modulo = $("#mod").val().toLowerCase(); // <-- Modulo actual del sistema
	var seccion = $("#sec").val();	
	var ajax_url = raiz+"src/"+modulo+"/admin.php";
	popup_ico = "<img src='"+raiz+"common/img/wait.gif' valign='middle' align='center'>&nbsp";
	$.ajax({
		type: 'POST',
		url: ajax_url,
		dataType: "json",
		data: {      
			auth : 1,
			modulo : modulo,
			accion : 'sincronizar'
		}
		,beforeSend: function(){ 
			popup_ico = "<img src='"+raiz+"common/img/popup/load.gif' valign='middle' align='texttop'>&nbsp";
			var txt = "Enviando petición, por favor espere...";	    	
			ventana = popup('Sincronizando...',popup_ico+txt,0,0,3);		
		}
		,success: function(respuesta){ 				
			$("#"+ventana).dialog("close");	
			if(respuesta.success){
				popup_ico = "<img src='"+raiz+"common/img/popup/info.png' class='popup-ico'>&nbsp";
				txt = "<div class='popup-txt'>La información ha sido sincronizada correctamente.</div>";
				ventana = popup('Éxito',popup_ico+txt,0,0,3);				
				setTimeout(function(){location.reload(true);}, 2000);
			}else if(respuesta.success){
				var popup_ico = "<img src='"+raiz+"common/img/popup/error.png' class='popup-ico'>&nbsp";
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
//O3M//
function alta_usuario(){
	var raiz = raizPath();
	var modulo = $("#mod").val().toLowerCase(); // <-- Modulo actual del sistema
	var seccion = $("#sec").val();	
	var ajax_url = raiz+"src/"+modulo+"/admin.php";
	var nombre			 =	$('#nombre').val();
	var apellido_paterno =	$('#apellido_paterno').val();
	var apellido_materno =	$('#apellido_materno').val();
	var correo			 =	$('#correo').val();
	var rfc				 =	$('#rfc').val();
	var nss  			 =	$('#nss').val();
	var sucursal 		 =	$('#sucursal').val();
	var puesto 			 =	$('#puesto').val();
	var no_empleado	     =	$('#no_empleado').val();
	var id_nomina	     =	$('#id_nomina').val();
	var id_empresa 		 =  $( "#empresa option:selected" ).val();
	var id_usuario 		 =  $( "#usuario option:selected" ).val();

	if(nombre==''|| apellido_paterno==''|| sucursal==''|| puesto==''|| id_empresa=='' || correo=='' || id_usuario==''){
		alert("Por favor, llene todos los campos con punto rojo.");
		return false;
	}
	if(correo!=''){
		expr = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
	    if ( !expr.test(correo) ){
	        alert("Error: La dirección de correo '" + correo + "' no es válida.");
	        return false
		}
	}
	if((no_empleado=='' || no_empleado==0)  && (id_nomina=='' || id_nomina==0)){
		alert("Debe ingresar su número CID o su número de Nómina PAE.");
		$('#id_nomina').focus();
		return false;
	}

	popup_ico = "<img src='"+raiz+"common/img/wait.gif' valign='middle' align='center'>&nbsp";

	$.ajax({
		type: 'POST',
		url: ajax_url,
		dataType: "json",
		data: {      
			auth : 1,
			modulo : modulo,
			accion : 'nuevo_usuario',
			nombre : nombre,
			apellido_paterno : apellido_paterno,
			apellido_materno : apellido_materno,
			correo : correo,
			rfc	   : rfc,
			nss    : nss,
			sucursal : sucursal,
			puesto   : puesto,
			no_empleado : no_empleado,
			id_nomina : id_nomina,
			id_empresa  : id_empresa,
			id_usuario 	: id_usuario
		}
		,beforeSend: function(){ 
			popup_ico = "<img src='"+raiz+"common/img/popup/load.gif' valign='middle' align='texttop'>&nbsp";
			var txt = "Enviando petición, por favor espere...";	    	
			ventana = popup('Sincronizando...',popup_ico+txt,0,0,3);		
		}
		,success: function(respuesta){ 				
			$("#"+ventana).dialog("close");	
			if(respuesta.success){
				popup_ico = "<img src='"+raiz+"common/img/popup/info.png' class='popup-ico'>&nbsp";
				txt = "<div class='popup-txt'>La información ha sido sincronizada correctamente.</div>";
				ventana = popup('Éxito',popup_ico+txt,0,0,3);				
				setTimeout(function(){location.reload(true);}, 2000);
			}else if(respuesta.success){
				var popup_ico = "<img src='"+raiz+"common/img/popup/error.png' class='popup-ico'>&nbsp";
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

function sincronizar_empresa(){
	var raiz = raizPath();
	var modulo = $("#mod").val().toLowerCase(); // <-- Modulo actual del sistema
	var seccion = $("#sec").val();	
	var ajax_url = raiz+"src/"+modulo+"/admin.php";
	popup_ico = "<img src='"+raiz+"common/img/wait.gif' valign='middle' align='center'>&nbsp";
	$.ajax({
		type: 'POST',
		url: ajax_url,
		dataType: "json",
		data: {      
			auth : 1,
			modulo : modulo,
			accion : 'sincronizar_empresa'
		}
		,beforeSend: function(){ 
			popup_ico = "<img src='"+raiz+"common/img/popup/load.gif' valign='middle' align='texttop'>&nbsp";
			var txt = "Enviando petición, por favor espere...";	    	
			ventana = popup('Sincronizando...',popup_ico+txt,0,0,3);		
		}
		,success: function(respuesta){ 				
			$("#"+ventana).dialog("close");	
			if(respuesta.success){
				popup_ico = "<img src='"+raiz+"common/img/popup/info.png' class='popup-ico'>&nbsp";
				txt = "<div class='popup-txt'>La información ha sido sincronizada correctamente.</div>";
				ventana = popup('Éxito',popup_ico+txt,0,0,3);				
				//setTimeout(function(){location.reload(true);}, 2000);
			}else if(respuesta.success){
				var popup_ico = "<img src='"+raiz+"common/img/popup/error.png' class='popup-ico'>&nbsp";
				txt = respuesta.error;
				ventana = popup('Error',popup_ico+txt,0,0,3);
			}							
		}
		,complete: function(){ 
		   /* setTimeout(function(){
					$("#"+ventana).dialog("close");
					location.reload(true);					
				}, 2000);*/
		}
    });
}

/**
* Layout
*/
function select_all(){
	$('#selectall').click(function(event) {  //on click 
        if(this.checked) { // check select status
            $('.chk_select').each(function() { //loop through each checkbox
                this.checked = true;  //select all checkboxes with class "checkbox1"               
            });
        }else{
            $('.chk_select').each(function() { //loop through each checkbox
                this.checked = false; //deselect all checkboxes with class "checkbox1"                       
            });         
        }
    });
}

function asigna_semana() {         
	var valores = [];
	$("input[name='check[]']:checked:enabled").each(function() {		
		// Creación de array con todos los datos capturados
		valores.push($(this).val());
	});	
	// Metemos creamos cadena con namescapes
	var separador = '|';
    var data = valores.join(separador);
    // Validación de datos
    var raiz = raizPath();
    var msj = '';
	var popup_ico = "<img src='"+raiz+"common/img/popup/error.png' class='popup-ico'>&nbsp";
    if(!data){
		msj = "<div class='popup-txt'>Seleccione algun registro por favor.</div>";
		ventana=popup('Validación',popup_ico+msj,0,0,1,'argumento');
		setTimeout(function(){$("#"+ventana).dialog("close");}, 2000);
		return false;
	}
    // alert(data);
    layout(data);
}

function layout(array){
/**
* AJAX: Genera popup para validación de semanas
*/
	$("#layout-popup").empty();
	var raiz = raizPath();
	var modulo = $("#mod").val().toLowerCase(); // <-- Modulo actual del sistema
	var seccion = $("#sec").val();	
	var ajax_url = raiz+"src/"+modulo+"/admin.php";	
	var contenidoHtml = '<div id="layout-popup"></div>';
	popup_ico = "<img src='"+raiz+"common/img/wait.gif' valign='middle' align='center'>&nbsp";
	$.ajax({
		type: 'POST',
		url: ajax_url,
		dataType: "json",
		data: {      
			auth : 1,
			modulo : modulo,
			accion : 'layout-popup',
			ids : array
		}		
		,success: function(respuesta){ 
			if(respuesta.success){
				var vistaHTML = respuesta.html;				
				ventana = popup('Asignar semana',contenidoHtml,550,250,3);
				$("#layout-popup").html(vistaHTML);
			}else if(respuesta.success){
				var popup_ico = "<img src='"+raiz+"common/img/popup/error.png' class='popup-ico'>&nbsp";
				txt = respuesta.error;
				ventana = popup('Error',popup_ico+txt,0,0,3);
			}				
		}
    });
}
// --

/*XLS*/
function xls_popup(array){
/**
* AJAX: Genera popup para validación de semanas
*/
	$("#layout-popup").empty();
	var raiz = raizPath();
	var modulo = $("#mod").val().toLowerCase(); // <-- Modulo actual del sistema
	var seccion = $("#sec").val();	
	var ajax_url = raiz+"src/"+modulo+"/admin.php";	
	var contenidoHtml = '<div id="layout-popup"></div>';
	popup_ico = "<img src='"+raiz+"common/img/wait.gif' valign='middle' align='center'>&nbsp";
	$.ajax({
		type: 'POST',
		url: ajax_url,
		dataType: "json",
		data: {      
			auth : 1,
			modulo : modulo,
			accion : 'xls-popup',
			ids : array
		}		
		,success: function(respuesta){ 
			if(respuesta.success){
				var vistaHTML = respuesta.html;				
				ventana = popup('Asignar Periodo de Nómina',contenidoHtml,550,300,3);
				$("#layout-popup").html(vistaHTML);
			}else if(respuesta.success){
				var popup_ico = "<img src='"+raiz+"common/img/popup/error.png' class='popup-ico'>&nbsp";
				txt = respuesta.error;
				ventana = popup('Error',popup_ico+txt,0,0,3);
			}				
		}
    });
}

// function genera_xls(){
// 	$("#xls-popup").empty();
// 	var raiz = raizPath();
// 	var modulo = $("#mod").val().toLowerCase(); // <-- Modulo actual del sistema
// 	var seccion = $("#sec").val();	
// 	var contenidoHtml = '<div id="xls-popup"></div>';	
// 	var ajax_url = raiz+"src/"+modulo+"/admin.php";
// 	popup_ico = "<img src='"+raiz+"common/img/wait.gif' valign='middle' align='center'>&nbsp";
// 	$.ajax({
// 		type: 'POST',
// 		url: ajax_url,
// 		dataType: "json",
// 		data: {      
// 			auth : 1,
// 			modulo : modulo,
// 			accion : 'genera-xls-nomina'
// 		}
// 		,beforeSend: function(){ 
// 			popup_ico = "<img src='"+raiz+"common/img/popup/load.gif' valign='middle' align='texttop'>&nbsp";
// 			var txt = "Generando archivo, por favor espere...";
// 	    	ventana = popup('Generando...',popup_ico+txt,0,0,3);
// 		}
// 		,success: function(respuesta){ 
// 			$("#"+ventana).dialog("close");
// 			if(respuesta.success){
// 				// Link para descargar archivo de excel
// 				popup_ico = "<img src='"+raiz+"common/img/popup/info.png' class='popup-ico'>&nbsp";
// 				var linkXls = '<div class="xls" style="height:80px;"><ul><li><a href="'+respuesta.xls+'" target="_self" title="'+respuesta.archivo+'">'+respuesta.archivo+'</a></li></ul></div>';
// 				var boton = buildBtn('btnCerrar','CERRAR','location.reload(true);');
// 				var btnCerrar = '<br/><div id="btn-xls">'+boton+'</div>';
// 				txt = "<div class='popup-txt'><p>Descargar el archivo: </p></div>";
// 				ventana = popup('Éxito',popup_ico+txt+linkXls+btnCerrar,450,300,3);	
// 			}else if(respuesta.nodata){
// 				popup_ico = "<img src='"+raiz+"common/img/popup/alert.png' valign='middle' align='texttop'>&nbsp";
// 				var txt = "No hay datos pendientes.";		    
// 			    ventana = popup('Mensaje!',popup_ico+txt,0,0,3);
// 				setTimeout(function(){
// 					// location.reload(true);
// 				}, 2000);
// 			}else{
// 				popup_ico = "<img src='"+raiz+"common/img/popup/error.png' valign='middle' align='texttop'>&nbsp";
// 				var txt = "Se ha generado un error.";		    
// 			    ventana = popup('Error!',popup_ico+txt,0,0,3);
// 				setTimeout(function(){	
// 					// location.reload(true);
// 				}, 2000);
// 			}				
// 		}
//     });
// }
function genera_xls_rebuild(accion, xls){
	$("#xls-popup").empty();
	var raiz = raizPath();
	var modulo = $("#mod").val().toLowerCase(); // <-- Modulo actual del sistema
	var seccion = $("#sec").val();	
	var contenidoHtml = '<div id="xls-popup"></div>';	
	var ajax_url = raiz+"src/"+modulo+"/admin.php";
	accion = (!accion)?'regenera-xls-nomina':accion;
	popup_ico = "<img src='"+raiz+"common/img/wait.gif' valign='middle' align='center'>&nbsp";
	$.ajax({
		type: 'POST',
		url: ajax_url,
		dataType: "json",
		data: {      
			auth : 1,
			modulo : modulo,
			accion : accion,
			xls : xls
		}
		,beforeSend: function(){ 
			popup_ico = "<img src='"+raiz+"common/img/popup/load.gif' valign='middle' align='texttop'>&nbsp";
			var txt = "Generando archivo, por favor espere...";
	    	ventana = popup('Generando...',popup_ico+txt,0,0,3);
		}
		,success: function(respuesta){ 
			$("#"+ventana).dialog("close");
			if(respuesta.success){
				// Link para descargar archivo de excel
				popup_ico = "<img src='"+raiz+"common/img/popup/info.png' class='popup-ico'>&nbsp";
				var linkXls = '<div class="xls" style="height:80px; "><ul><li><a href="'+respuesta.xls+'" target="_self" title="'+respuesta.archivo+'">'+respuesta.archivo+'</a></li></ul></div>';
				var boton = buildBtn('btnCerrar','CERRAR','location.reload(true);');
				var btnCerrar = '<br/><div id="btn-xls">'+boton+'</div>';
				txt = "<div class='popup-txt'><p>Descargar el archivo: </p></div>";
				ventana = popup('Éxito',popup_ico+txt+linkXls+btnCerrar,450,300,3);	
			}else if(respuesta.nodata){
				popup_ico = "<img src='"+raiz+"common/img/popup/alert.png' valign='middle' align='texttop'>&nbsp";
				var txt = "No hay datos pendientes.";		    
			    ventana = popup('Mensaje!',popup_ico+txt,0,0,3);
				setTimeout(function(){
					// location.reload(true);
				}, 2000);
			}else{
				popup_ico = "<img src='"+raiz+"common/img/popup/error.png' valign='middle' align='texttop'>&nbsp";
				var txt = "Se ha generado un error.";		    
			    ventana = popup('Error!',popup_ico+txt,0,0,3);
				setTimeout(function(){	
					// location.reload(true);
				}, 2000);
			}				
		}
    });
}
/*Layout*/

function supervisores(id_personal){
	/**
	* AJAX: Genera popup para validación de supervisor
	*/
		$("#layout-popup").empty();
		var raiz = raizPath();
		var modulo = $("#mod").val().toLowerCase(); // <-- Modulo actual del sistema
		var seccion = $("#sec").val();	
		var ajax_url = raiz+"src/"+modulo+"/admin.php";	
		var contenidoHtml = '<div id="layout-popup"></div>';
		popup_ico = "<img src='"+raiz+"common/img/wait.gif' valign='middle' align='center'>&nbsp";
		$.ajax({
			type: 'POST',
			url: ajax_url,
			dataType: "json",
			data: {      
				auth : 1,
				modulo : modulo,
				accion : 'supervisor-popup',
				id_personal : id_personal
			}		
			,success: function(respuesta){ 
				if(respuesta.success){
					var vistaHTML = respuesta.html;				
					ventana = popup('Supervisor',contenidoHtml,550,620,3);
					$("#layout-popup").html(vistaHTML);
				}else if(respuesta.success){
					var popup_ico = "<img src='"+raiz+"common/img/popup/error.png' class='popup-ico'>&nbsp";
					txt = respuesta.error;
					ventana = popup('Error',popup_ico+txt,0,0,3);
				}				
			}
	    });
}

function admin_usuario(id_personal){
	/**
	* AJAX: Genera popup para edicion de datos de usuario
	*/
		$("#layout-popup").empty();
		var raiz = raizPath();
		var modulo = $("#mod").val().toLowerCase(); // <-- Modulo actual del sistema
		var seccion = $("#sec").val();	
		var ajax_url = raiz+"src/"+modulo+"/admin.php";	
		var contenidoHtml = '<div id="layout-popup"></div>';
		popup_ico = "<img src='"+raiz+"common/img/wait.gif' valign='middle' align='center'>&nbsp";
		$.ajax({
			type: 'POST',
			url: ajax_url,
			dataType: "json",
			data: {      
				auth : 1,
				modulo : modulo,
				accion : 'admin-usuario-popup',
				id_personal : id_personal
			}		
			,success: function(respuesta){ 
				if(respuesta.success){
					var vistaHTML = respuesta.html;				
					ventana = popup('Modificar Usuario',contenidoHtml,600,550,3);
					$("#layout-popup").html(vistaHTML);
				}else if(respuesta.success){
					var popup_ico = "<img src='"+raiz+"common/img/popup/error.png' class='popup-ico'>&nbsp";
					txt = respuesta.error;
					ventana = popup('Error',popup_ico+txt,0,0,3);
				}				
			}
	    });
}

function admin_usuario_reset(id_personal, info_usuario){
	/**
	* AJAX: Reestablecer clave de usuario
	*/
		$("#layout-popup").empty();
		var raiz = raizPath();
		var modulo = $("#mod").val().toLowerCase(); // <-- Modulo actual del sistema
		var seccion = $("#sec").val();			
		if (confirm("Está seguro de reestablecer la clave de este usuario? \n\n"+info_usuario)) {
		    var ajax_url = raiz+"src/"+modulo+"/admin.php";	
			var contenidoHtml = '<div id="layout-popup"></div>';
		    popup_ico = "<img src='"+raiz+"common/img/wait.gif' valign='middle' align='center'>&nbsp";
			$.ajax({
				type: 'POST',
				url: ajax_url,
				dataType: "json",
				data: {      
					auth : 1,
					modulo : modulo,
					accion : 'admin-usuario-reset',
					id_personal : id_personal
				}		
				,success: function(respuesta){ 
					if(respuesta.success){
						popup_ico = "<img src='"+raiz+"common/img/popup/info.png' class='popup-ico'>&nbsp";
						txt = "<div class='popup-txt'>La clave del usuario ha sido reestablecida.</div>";
						ventana = popup('Éxito',popup_ico+txt,0,0,3);				
						setTimeout(function(){location.reload(true);}, 2000);
					}else if(respuesta.success){
						txt = respuesta.error;
						ventana = popup('Error',popup_ico+txt,0,0,3);
					}			
				}
		    });
		} else {
		    return false;
		}
		
}
