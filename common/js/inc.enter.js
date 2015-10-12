$(document).ready(function(){
    // Detectar ENTER
    $(document).keypress(function(e) {
       
        var user =$('#validation').val();
        	if(user==undefined || user==''){	
        		 if(e.which == 13) {
        			btnSubmit();
        		}
        	}
    });
});

function test(){
    alert('Script externo cargado!');
}