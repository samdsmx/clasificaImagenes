<?
function Autentifica($Nombre, $Password, $Estado){
	include("Datos_Comunicacion.php");
	$sql ="SELECT NivelSeguridad FROM Usuarios WHERE Nombre='$Nombre' AND Password='$Password'";
	$total_result = @mysql_query($sql, $connection) or die("Error #". mysql_errno() . ": " . mysql_error());
	$total_found = @mysql_num_rows($total_result);
	if ($total_found == "1"){
		$row = mysql_fetch_array($total_result);
		$NivelSeguridad=$row['NivelSeguridad'];
		switch ($Estado){
			case "login":
				$SecureCad="$Nombre@$Password";
				$SecureCad=base64_encode($SecureCad);
				//setcookie ("Sesion", $SecureCad, time()+60*60*24); //Expira en un dia
				setcookie ("Sesion", $SecureCad, time()+60*10); //Expira en diez minutos
				header("Cache-Control: no-store, no-cache, must-revalidate");
				header("Cache-Control: post-check=0, pre-check=0", false);
				header("Refresh: 0; URL= ?Accion=Formulario");
				$Mensaje= "Procesando entrada";
				include("Paginas/Mensajes.html");
				break;
			case "verifica":
				return("$NivelSeguridad");
				break;
			case "identidad":
				return("$Nombre");
				break;
			}
		}
		else{
			setcookie("Sesion","", time() - 3600);
			unset($_COOKIE[Sesion]);
			$Mensaje= "Nombre o Password incorrecto.";
			include("Paginas/Error.html");
			}
	mysql_close($connection);
	}

function RevisaSesion($DatosSesion, $verificacion){
	$SecureCad=base64_decode($DatosSesion);
	list($Nombre, $Password)= split("@", $SecureCad);
	return Autentifica($Nombre, $Password, "$verificacion");
	}

function BorraCache(){
	header("Pragma: public");
	header("Expires: 0"); 
	header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
	header("Cache-Control: no-store, no-cache, must-revalidate");
	header("Cache-Control: post-check=0, pre-check=0", false);
	header("Pragma: no-cache");
	}

function UnError($Mensaje){
	include('Paginas/Error.html');
	die();
	}
?>
