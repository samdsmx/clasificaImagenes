<?
	include("Funciones/Funciones_Seguridad.php");
	include("Funciones/Funcion_ValidacionCampos.php");
	header('Pragma: no-cache');
	header("Content-Type: text/html; charset=UTF-8");
	if ($Sesion){
		if ($CerrarSesion){
			setcookie("Sesion","", time() - 3600);
			BorraCache();
			header("Refresh: 0; URL= .");
			$Mensaje="Saliendo del sistema";
			include ("Paginas/Mensajes.html");
			die;
			}
		BorraCache();
		$acceso=RevisaSesion($Sesion, "verifica");
				switch ($Accion){
					case "Busqueda":
						include("Paginas/busqueda.php");
						include("Paginas/ayuda.php");	
						break;	
					case "Base":
						include("paginas/reporte.php");
						include("Paginas/ayuda.php");	
						break;	
					case "Estadisticas":
						include("paginas/estadisticas.php");
						include("Paginas/ayuda.php");	
						break;	
					case "Estadisticas3":
						include("paginas/estadisticas2.php");
						include("Paginas/ayuda.php");	
						break;	
					case "Estadisticas2":
						include("paginas/graficas.php");
						break;								
					case "Descarta":
						include("funciones/descarta.php");
						header("Refresh: 0; URL=index.php");
						break;
					case "Salva":
						include("funciones/salva.php");
						header("Refresh: 0; URL=index.php");
						break;
					case "Modifica":
						include("funciones/modifica.php");
						include("Paginas/Mensajes.html");
						$back = $_SERVER['HTTP_REFERER'];
						header("Refresh: 2; URL=$back");
						break;
					default:
					    $Accion="Formulario";
						include("Paginas/formulario.php");	
						include("Paginas/ayuda.php");	
						break;
					}
		}
		else{
			switch ($Accion){
				case "Autentifica":
					Autentifica($Nombre, $Password, "login");
					break;
				default:
					include("Paginas/Login.html");
					break;
				}
			}
?>