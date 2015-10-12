//O3M//
$(document).ready(function(){
	jgrid('jGrid');
});

function ok(Objeto){
/**
* Detecta seleccion SI/NO y muestra imagen cambiando la clase
*/
//alert(Objeto);
var Id = Objeto.id.split("_");
	$('#ico-'+Id[1]).removeClass();
	if(Objeto.value=='no'){
		var Valor = false;
		var ClaseCss = 'ico-autorizacion-no';
		var Texto = 'Rechazado';
	 	$('#muestra_'+Id[1]).show();
	 	$('#asig_'+Id[1]).val('1');
	}else if(Objeto.value){
		var Valor = true;
		var ClaseCss = 'ico-autorizacion-si';
		var Texto = 'Autorizado';
		$('#muestra_'+Id[1]).hide();
		$('#asig_'+Id[1]).val('0');
		 $('#muestra_'+Id[1]).val("");
	}else{
		var Valor = false;
		var ClaseCss = 'ico-autorizacion';
		var Texto = 'Pendiente';
		$('#muestra_'+Id[1]).hide();
		$('#muestra_'+Id[1]).val("");
		$('#asig_'+Id[1]).val('0');
	}
	$('#ok_'+Id[1]).prop('checked', Valor);
	$('#ico-'+Id[1]).addClass(ClaseCss);
	$('#ico-'+Id[1]).attr('title', Texto);
}

function obtenerCampos(valor){
/**
* Obtiene los datos seleccionados de un grid
*/
	// Mostrar todos los registros del Grid
    $('#jGridViewsList option:contains("Todos")').prop('selected', true);
	$("#jGridViewsList").change();
	// Obtener todos los Selects capturados
	var separador = '|';
    var valores = '';
    var id = '';
    var j=1;
    /*if(valor==4){
    	$(".campos").each(function(){
	       if($(this).val()!=''){
	          valores = valores + separador +  $(this).serialize() + '='+$("#id_empresa_"+j).val() + '=' + $("#id_personal_"+j).val() + '=' + $("#horas_rechazadas_"+j).val() + '='+ $("#horas_dobles_"+j).val() + '='+ $("#horas_triples_"+j).val()+ '='+ $("#empleado_num_"+j).val();
	       }
	       j++;
	    });
    }
    else{*/
    	$(".campos").each(function(){
	       if($(this).val()!=''){
	       	var val = $(this).serialize().split("_");
	       	var val2 = val[1].split("=");
	          valores = valores + separador  +  $(this).serialize()+ '_' + $('#muestra_'+val2[0]).val();
	       }
	       j++;
	    });
    //}
    // Metemos resultados a un array
    var array = valores.split(separador);
    array.splice(0, 1);	// Quita indice 0 que no trae datos
    var data = array.join(separador);
    // Mostrar el mínimo de registros en el Grid
    $('#jGridViewsList option[value="10"]').prop('selected', true);
	$("#jGridViewsList").change(); 
	if(valor==1){
		guardar_autorizacion_1(data);
	}
	else if(valor==2){
		guardar_autorizacion_2(data);
	}
	else if(valor==3){
		guardar_autorizacion_3(data);
	}
	else if(valor==4){
		guardar_autorizacion_4(data);
	}
	else if(valor==5){
		guardar_autorizacion_5(data);
	}
}

/**
* Autorización nivel 1
*/
function popup_autorizacion_1(id_horas_extra){
/**
* AJAX: Genera popup para validación de hotras extra
*/
	$("#layout-popup").empty();
	var raiz = raizPath();
	var modulo = $("#mod").val().toLowerCase(); // <-- Modulo actual del sistema
	var seccion = $("#sec").val();	
	var ajax_url = raiz+"src/"+modulo+"/autorizacion.php";	
	var contenidoHtml = '<div id="layout-popup"></div>';
	popup_ico = "<img src='"+raiz+"common/img/wait.gif' valign='middle' align='center'>&nbsp";
	$.ajax({
		type: 'POST',
		url: ajax_url,
		dataType: "json",
		data: {      
			auth : 1,
			modulo : modulo,
			accion : 'autorizacion1-popup',
			id_horas_extra : id_horas_extra
		}		
		,success: function(respuesta){ 
			if(respuesta.success){
				var vistaHTML = respuesta.html;				
				ventana = popup('Autorización nivel 1',contenidoHtml,550,550,3);
				$("#layout-popup").html(vistaHTML);
			}else if(respuesta.success){
				var popup_ico = "<img src='"+raiz+"common/img/popup/error.png' class='popup-ico'>&nbsp";
				txt = respuesta.error;
				ventana = popup('Error',popup_ico+txt,0,0,3);
			}				
		}
    });
}
/*1*/


/**
* Autorización nivel 2
*/
function popup_autorizacion_2(id_horas_extra){
/**
* AJAX: Genera popup para validación de hotras extra
*/
	$("#layout-popup").empty();
	var raiz = raizPath();
	var modulo = $("#mod").val().toLowerCase(); // <-- Modulo actual del sistema
	var seccion = $("#sec").val();	
	var ajax_url = raiz+"src/"+modulo+"/autorizacion.php";	
	var contenidoHtml = '<div id="layout-popup"></div>';
	popup_ico = "<img src='"+raiz+"common/img/wait.gif' valign='middle' align='center'>&nbsp";
	$.ajax({
		type: 'POST',
		url: ajax_url,
		dataType: "json",
		data: {      
			auth : 1,
			modulo : modulo,
			accion : 'autorizacion2-popup',
			id_horas_extra : id_horas_extra
		}		
		,success: function(respuesta){ 
			if(respuesta.success){
				var vistaHTML = respuesta.html;				
				ventana = popup('Autorización nivel 2',contenidoHtml,550,550,3);
				$("#layout-popup").html(vistaHTML);
			}else if(respuesta.success){
				var popup_ico = "<img src='"+raiz+"common/img/popup/error.png' class='popup-ico'>&nbsp";
				txt = respuesta.error;
				ventana = popup('Error',popup_ico+txt,0,0,3);
			}				
		}
    });
}
/*2*/


/**
* Autorización nivel 3
*/
function popup_autorizacion_3(id_horas_extra){
/**
* AJAX: Genera popup para validación de hotras extra
*/
	$("#layout-popup").empty();
	var raiz = raizPath();
	var modulo = $("#mod").val().toLowerCase(); // <-- Modulo actual del sistema
	var seccion = $("#sec").val();	
	var ajax_url = raiz+"src/"+modulo+"/autorizacion.php";	
	var contenidoHtml = '<div id="layout-popup"></div>';
	popup_ico = "<img src='"+raiz+"common/img/wait.gif' valign='middle' align='center'>&nbsp";
	$.ajax({
		type: 'POST',
		url: ajax_url,
		dataType: "json",
		data: {      
			auth : 1,
			modulo : modulo,
			accion : 'autorizacion3-popup',
			id_horas_extra : id_horas_extra
		}		
		,success: function(respuesta){ 
			if(respuesta.success){
				var vistaHTML = respuesta.html;				
				ventana = popup('Autorización nivel 3',contenidoHtml,550,550,3);
				$("#layout-popup").html(vistaHTML);
			}else if(respuesta.success){
				var popup_ico = "<img src='"+raiz+"common/img/popup/error.png' class='popup-ico'>&nbsp";
				txt = respuesta.error;
				ventana = popup('Error',popup_ico+txt,0,0,3);
			}				
		}
    });
}
/*3*/


/**
* Autorización nivel 4
*/
function btnSubmit_autorizacion_4(){
	obtenerCampos(4);
}

function guardar_autorizacion_4(array){
/**
* AJAX: Envia datoa para guardar en tabla
*/
	var modulo = $("#mod").val().toLowerCase(); // <-- Modulo actual del sistema
	var seccion = $("#sec").val();
	var raiz = raizPath();
	var ajax_url = raiz+"src/"+modulo+"/autorizacion.php";
	popup_ico = "<img src='"+raiz+"common/img/wait.gif' valign='middle' align='center'>&nbsp";
	var valores = array.split('|');
	var envio= true;
	$.each(valores,function(indice, valor){
       	var valor1 = valores[indice].split('=');
       	var id = valor1[0].split('_');
       	var validacion= $('#asig_'+id[1]).val();
       if(validacion=='1'){
       		var validation = $('#muestra_'+id[1]).val();
	       	if(validation==''){
	       		alert('No puede estar el argumento vacío');
	       		envio= false;
	       	}
       }
    });
    if(envio){
    	if(array){
			$.ajax({
				type: 'POST',
				url: ajax_url,
				dataType: "json",
				data: {      
					auth : 1,
					modulo : modulo,
					seccion : seccion,
					accion : 'guardar_autorizacion_4',
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
						txt = "<div class='popup-txt'><p>La información ha sido guardada correctamente. </p></div>";
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
    else{
    	return false;
    }
}
/*4*/


/**
* Autorización nivel 5
*/
function btnSubmit_autorizacion_5(){
	obtenerCampos(5);
}

function guardar_autorizacion_5(array){
/**
* AJAX: Envia datoa para guardar en tabla
*/
	var modulo = $("#mod").val().toLowerCase(); // <-- Modulo actual del sistema
	var seccion = $("#sec").val();
	var raiz = raizPath();
	var ajax_url = raiz+"src/"+modulo+"/autorizacion.php";
	popup_ico = "<img src='"+raiz+"common/img/wait.gif' valign='middle' align='center'>&nbsp";
	var valores = array.split('|');
	var envio= true;
	$.each(valores,function(indice, valor){
       	var valor1 = valores[indice].split('=');
       	var id = valor1[0].split('_');
       	var validacion= $('#asig_'+id[1]).val();
       if(validacion=='1'){
       		var validation = $('#muestra_'+id[1]).val();
	       	if(validation==''){
	       		alert('No puede estar el argumento vacío');
	       		envio= false;
	       	}
       }
    });
    if(envio){
    	if(array){
			$.ajax({
				type: 'POST',
				url: ajax_url,
				dataType: "json",
				data: {      
					auth : 1,
					modulo : modulo,
					seccion : seccion,
					accion : 'guardar_autorizacion_5',
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
						txt = "<div class='popup-txt'><p>La información ha sido guardada correctamente. </p></div>";
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
    else{
    	return false;
    }
}
/*5*/

//O3M//