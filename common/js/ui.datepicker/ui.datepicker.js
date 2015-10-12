function jquery_fecha(id_objeto, formato, todaylimit, minLimit){
    switch(formato) {
        case 1: formato = 'dd/mm/yy'; break;
        default:formato = 'yy-mm-dd'; break;
    }
    todaylimit = (!todaylimit)?'':'0';
    var today1 = new Date();
    if(!minLimit){        
        var d1 = today1.getDate();
        var m1 = today1.getMonth(); 
        var y1 = today1.getFullYear()-99;
        
    }else{        
        var minMonth = 0;
        var minDay = 15;
        var d1 = today1.getDate()-minDay;
        var m1 = today1.getMonth()-minMonth; 
        var y1 = today1.getFullYear();
    }
    var minLimit = new Date(y1,m1,d1);

    $.datepicker.regional['es'] = {
         closeText: 'Cerrar',
         prevText: '<< Anterior',
         nextText: 'Siguiente >>',
         currentText: 'Hoy',
         monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
         monthNamesShort: ['Ene','Feb','Mar','Abr', 'May','Jun','Jul','Ago','Sep', 'Oct','Nov','Dic'],
         dayNames: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],
         dayNamesShort: ['Dom','Lun','Mar','Mié','Juv','Vie','Sáb'],
         dayNamesMin: ['Do','Lu','Ma','Mi','Ju','Vi','Sá'],
         weekHeader: 'Sm',
         dateFormat: formato,
         firstDay: 0,
         isRTL: false,
         showMonthAfterYear: false,
         yearSuffix: '',
         maxDate: todaylimit,
         minDate: minLimit,
         showAnim: "fadeIn" 
         };
    $.datepicker.setDefaults($.datepicker.regional['es']);
    $(function () {
        $("#"+id_objeto).datepicker();
    });
}

function jquery_fecha_periodo(id_objeto,inicio, fin, formato){
    switch(formato) {
        case 1: formato = 'dd/mm/yy'; break;
        default:formato = 'yy-mm-dd'; break;
    }

    if(inicio){
        /*CALENDARIO DE PERIODOS*/
        // Fecha actual
        var fec_hoy = new Date();
        // Fecha de inicio del periodo 
        var fec_inicio = new Date();
        fec_inicio.setTime(Date.parse(inicio));
        fec_inicio.setDate(fec_inicio.getDate() + 1);
        // Fecha final del periodo
        var fec_fin = new Date();
        fec_fin.setTime(Date.parse(fin));
        fec_fin.setDate(fec_fin.getDate() + 1);
        // Valida que la fecha final del periodo no sea mayor a la fecha actual
        if((Date.parse(fec_fin)) > (Date.parse(fec_hoy))){
            fec_fin = fec_hoy;
        }
        /*FIN DE CALENDARIO DE PERIODOS*/
    }else{
        var today1 = new Date();       
        var minMonth = 0;
        var minDay = 14;
        var d1 = today1.getDate()-minDay;
        var m1 = today1.getMonth()-minMonth; 
        var y1 = today1.getFullYear();
        var fec_inicio = new Date(y1,m1,d1);
        var fec_fin = new Date();
    }

    $.datepicker.regional['es'] = {
         closeText: 'Cerrar',
         prevText: '<< Anterior',
         nextText: 'Siguiente >>',
         currentText: 'Hoy',
         monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
         monthNamesShort: ['Ene','Feb','Mar','Abr', 'May','Jun','Jul','Ago','Sep', 'Oct','Nov','Dic'],
         dayNames: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],
         dayNamesShort: ['Dom','Lun','Mar','Mié','Juv','Vie','Sáb'],
         dayNamesMin: ['Do','Lu','Ma','Mi','Ju','Vi','Sá'],
         weekHeader: 'Sm',
         dateFormat: formato,
         firstDay: 0,
         isRTL: false,
         showMonthAfterYear: false,
         yearSuffix: '',
         maxDate: fec_fin,
         minDate: fec_inicio,
         showAnim: "fadeIn" 
         };
    $.datepicker.setDefaults($.datepicker.regional['es']);
    $(function () {
        $("#"+id_objeto).datepicker();
    });
}
/*O3M*/