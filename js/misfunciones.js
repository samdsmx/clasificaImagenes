jQuery(document).ready(function($){ //fire on DOM ready
	$('#imagen_expediente').addpowerzoom();
	$('#paises').selectList();
	$('#revokeButton').click(disconnectUser);
})

function seleccionar(elemento) {
   var combo = document.forms["popupForm"].motivo;
   var cantidad = combo.length;
   for (i = 0; i < cantidad; i++) {
      if (combo[i].value == elemento) {
         combo[i].selected = true;
      }   
   }
   location.href='#confirmPopup';
   combo.focus();
}

function isNumberKey(evt) {
    var charCode = (evt.which) ? evt.which : event.keyCode;
    if (charCode != 46 && charCode > 31
    && (charCode < 48 || charCode > 57))
        return false;
    return true;
}

function actFecha(){
	$('#eDate').val($('#sDate').val()) ;
	document.forms["capturaForm"].eDate.focus();
	}

function mydump(arr,level) {
    var dumped_text = "";
    if(!level) level = 0;

    var level_padding = "";
    for(var j=0;j<level+1;j++) level_padding += "    ";

    if(typeof(arr) == 'object') {  
        for(var item in arr) {
            var value = arr[item];

            if(typeof(value) == 'object') { 
                dumped_text += level_padding + "'" + item + "' ...\n";
                dumped_text += mydump(value,level+1);
            } else {
                dumped_text += level_padding + "'" + item + "' => \"" + value + "\"\n";
            }
        }
    } else { 
        dumped_text = "===>"+arr+"<===("+typeof(arr)+")";
    }
    return dumped_text;
}


function teclas(){
	shortcut("Alt+A",function(){
		seleccionar('adjunto');
		});
	shortcut("Alt+P",function(){
		seleccionar('periodo');
		});
	shortcut("Alt+I",function(){
		seleccionar('ilegible');
		});
	shortcut("Alt+S",function(){
		seleccionar('sin_info');
		});
	shortcut("Alt+N",function(){
		seleccionar('no_capacitacion');
		});
	shortcut("Alt+C",function(){
		seleccionar('no_corresponde_exp');
		});	
	shortcut("esc",function(){
		location.href='#close';
		document.forms["capturaForm"].sDate.focus();
		});
	}
