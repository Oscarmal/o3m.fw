//O3M//
$(document).ready(function(){

});

function btnSubmit(){
	var raiz = raizPath();
	var msj = '';
	var anio = $('#periodo_anio').val();	
	var periodo = $('#periodo').val();
	var periodo_especial = $('#periodo_especial').val();
	var popup_ico = "<img src='"+raiz+"common/img/popup/error.png' class='popup-ico'>&nbsp";
	if(anio=="" || anio<=0){
		msj = "<div class='popup-txt'>Ingrese el año del Periodo de Nómina.</div>";
		ventana = popup('Validación',popup_ico+msj,0,0,1,'periodo_anio');
		setTimeout(function(){$("#"+ventana).dialog("close");}, 2000);
		$("#periodo_anio").focus();
		return false;
	}
	if(periodo=="" || periodo<=0){
		msj = "<div class='popup-txt'>Ingrese el Periodo de Nómina.</div>";
		ventana = popup('Validación',popup_ico+msj,0,0,1,'periodo');
		setTimeout(function(){$("#"+ventana).dialog("close");}, 2000);
		$("#periodo").focus();
		return false;
	}	
	genera_xls();
}

function genera_xls(){
	$("#xls-popup").empty();
	var raiz = raizPath();
	var modulo = $("#mod").val().toLowerCase(); // <-- Modulo actual del sistema
	var seccion = $("#sec").val();	
	var anio = $('#periodo_anio').val();	
	var periodo = parseInt($('#periodo').val());
	var periodo_especial = $('#periodo_especial').val();
	var contenidoHtml = '<div id="xls-popup"></div>';	
	var ajax_url = raiz+"src/"+modulo+"/admin.php";
	popup_ico = "<img src='"+raiz+"common/img/wait.gif' valign='middle' align='center'>&nbsp";
	$.ajax({
		type: 'POST',
		url: ajax_url,
		dataType: "json",
		data: {      
			auth : 1,
			modulo : modulo,
			accion : 'genera-xls-nomina',
			anio : anio,
			periodo : periodo,
			periodo_especial : periodo_especial
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
				var linkXls = '<div class="xls" style="height:80px;"><ul><li><a href="'+respuesta.xls+'" target="_self" title="'+respuesta.archivo+'">'+respuesta.archivo+'</a></li></ul></div>';
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


//O3M//