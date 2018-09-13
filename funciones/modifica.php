<?
	include("Datos_Comunicacion.php");
	$Mensaje = "";
	if (strcmp($motivo,"captura")==0){
		if ($campo <> null || count($campo)>0 ){
			$sql = "UPDATE Constancias SET ";
			$flag=0;
			foreach ($campo as $value) {
				if ($$value <> '' || $$value <> null){
					$sql.=$value." = '".$$value."', ";
					$flag++;
					}
				}
			if($flag>0){	
				$sql = substr($sql,0,-2)." WHERE ";
				$docs=explode(",",$documentos);
				foreach ($docs as $value) {
					$sql.="documento = '".$value."' OR ";
					}
				$sql = substr($sql,0,-3);
				$total_result = @mysql_query($sql, $connection) or die("Error #". mysql_errno() . ": " . mysql_error());
				$mod = mysql_affected_rows();
				if ($mod>0){
					$sql ="INSERT INTO Cambios (Usuario,Qry) VALUES ('$Nombre',\"$sql\")";
					$total_result = @mysql_query($sql, $connection) or die("Error #". mysql_errno() . ": " . mysql_error());
					}
				$Mensaje = "Se han modificado ".$mod." registros";
				}
				else{
					$Mensaje = "Nada que modificar (Campos Vacios)";	
					}
			}
			else{
				$Mensaje = "Nada que modificar";
				}
		}
		else{
			$sql = "UPDATE Bitacora SET accion = '".$motivo."' WHERE ";
			$docs=explode(",",$documentos);
			foreach ($docs as $value) {
				$sql.="documento = '".$value."' OR ";
				}
			$sql = substr($sql,0,-3);
			$total_result = @mysql_query($sql, $connection) or die("Error #". mysql_errno() . ": " . mysql_error());
			$mod = mysql_affected_rows();			
			if ($mod>0){
					$sql ="INSERT INTO Cambios (Usuario,Qry) VALUES ('$Nombre',\"$sql\")";
					$total_result = @mysql_query($sql, $connection) or die("Error #". mysql_errno() . ": " . mysql_error());
					}

			$sql = "DELETE FROM Constancias WHERE ";
			$docs=explode(",",$documentos);
			foreach ($docs as $value) {
				$sql.="documento = '".$value."' OR ";
				}
			$sql = substr($sql,0,-3);
			$total_result = @mysql_query($sql, $connection) or die("Error #". mysql_errno() . ": " . mysql_error());
			$mod = mysql_affected_rows();			
			if ($mod>0){
					$sql ="INSERT INTO Cambios (Usuario,Qry) VALUES ('$Nombre',\"$sql\")";
					$total_result = @mysql_query($sql, $connection) or die("Error #". mysql_errno() . ": " . mysql_error());
					}

			$docs=explode(",",$documentos);
			foreach ($docs as $Imagen) {
				@rename("exp_capturados/".$Imagen, "exp_desc/".$motivo."/".$Imagen);
				}
			$Mensaje = "Se han modificado ".$mod." registros";
			}
	mysql_close($connection);
?>