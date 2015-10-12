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

function check_on_edit(id){
	id = id.split('_');
	id = id[1];
	$('#check_'+id).attr('checked', true);
}

function actualizar_supervisores() {         
	var data = [];
	var objeto = [];
	$("input[name='check[]']:checked:enabled").each(function() {		
		var id_personal = $(this).val();
		var sucursal	= $('#sucursal_'+id_personal).val();
		var cid 		= $('#cid_'+id_personal).val();
		var mail 		= $('#mail_'+id_personal).val();
		var nivel1 		= $('#nivel1_'+id_personal).val();
		var nivel2 		= $('#nivel2_'+id_personal).val();
		var nivel3 		= $('#nivel3_'+id_personal).val();

		objeto = {
					id_personal : id_personal,
					sucursal: sucursal,
					cid 	: cid,
					mail 	: mail,
					nivel1 	: nivel1,
					nivel2 	: nivel2,
					nivel3 	: nivel3
				};
		data.push(objeto);
	});	
    // alert(dump_var(data));
    enviar(data);
}

function enviar(objeto){
/**
* AJAX: Envia objeto a PHP
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
			accion : 'supervisores-actualizar',
			datos : objeto
		}		
		,beforeSend: function(){ 
			popup_ico = "<img src='"+raiz+"common/img/popup/load.gif' valign='middle' align='texttop'>&nbsp";
			var txt = "Guardando datos, por favor espere...";	    	
			ventana = popup('Guardando...',popup_ico+txt,0,0,3);		
		}
		,success: function(respuesta){ 				
			$("#"+ventana).dialog("close");	
			if(respuesta.success){
				popup_ico = "<img src='"+raiz+"common/img/popup/info.png' class='popup-ico'>&nbsp";
				txt = "<div class='popup-txt'>La información ha sido actualizada correctamente.</div>";
				ventana = popup('Éxito',popup_ico+txt,0,0,3);				
				// setTimeout(function(){location.reload(true);}, 2000);
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