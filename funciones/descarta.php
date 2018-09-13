<?
	include("Datos_Comunicacion.php");
	if (@rename("expedientes/".$Imagen, "exp_desc/".$motivo."/".$Imagen)){
		$sql ="INSERT INTO Bitacora (Usuario,Accion,Documento) VALUES (\"$Nombre\",\"$motivo\",\"$Imagen\")";
		$total_result = @mysql_query($sql, $connection) or die("Error #". mysql_errno() . ": " . mysql_error());
		}
	mysql_close($connection);
?>