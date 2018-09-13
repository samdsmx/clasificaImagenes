<?
function RevisarNombre($Nombre){	
	if (eregi("^[a-z 0-9-]+$", $Nombre) & strlen($Nombre)<70){
		return ("OK");
		}
		else{
			return ("Error");
			}
	}

function RevisarPassword($Password){		
	if (eregi("^[a-z0-9-]+$", $Password) & strlen($Password)<11){
		return ("OK");
		}
		else{
			return ("Error");
			}
}

function RevisarFecha($Fecha){		
	if (eregi("^[0-9]{1,2}\/[0-9]{1,2}\/[0-9]{1,4}$", $Fecha)  || strlen($Fecha)==0){
		return ("OK");
		}
		else{
			return ("Error");
			}
}

function RevisarEmail($Email){		
	if (eregi("^[a-z0-9@._-]*$", $Email) || strlen($Email)==0){
		return ("OK");
		}
		else{
			return ("Error");
			}
}
?>
