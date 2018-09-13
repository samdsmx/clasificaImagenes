<?
	include("Datos_Comunicacion.php");
	if (@rename("expedientes/".$Imagen, "exp_capturados/".$Imagen)){
		$duracion = !empty($duracion) ? "'$duracion'" : "NULL";
		$sql ="INSERT INTO Constancias (fecha_ini,fecha_fin,nombre_curso,organismo,tipo_doc,tipo_cap,duracion,documento,lugar) 
							VALUES ('$sDate','$eDate','$nombre_curso','$organismo','$tipo_doc','$tipo_cap',$duracion,'$Imagen','$lugar')";
		$total_result = @mysql_query($sql, $connection) or die("Error #". mysql_errno() . ": " . mysql_error());

		$sql ="INSERT INTO Bitacora (Usuario,Accion,Documento) VALUES (\"$Nombre\",'Captura',\"$Imagen\")";
		$total_result = @mysql_query($sql, $connection) or die("Error #". mysql_errno() . ": " . mysql_error());
		
		}
	mysql_close($connection);
?>