<?
	include("../funciones/Datos_Comunicacion.php");


	/*
	$sql = "SELECT duracion, fecha_ini, fecha_fin FROM constancias WHERE nombre_curso = 'Actualización Legislativa' GROUP BY duracion, fecha_ini, fecha_fin";
	$total_result = @mysql_query($sql, $connection);
		for($i = 0; $row = mysql_fetch_array($total_result); $i++){
			$sql2 = "SELECT nombre_curso, count(*) cuent FROM constancias WHERE nombre_curso != 'Actualización Legislativa' AND duracion = '".$row['duracion']."' AND fecha_ini = '".$row['fecha_ini']."' AND fecha_fin = '".$row['fecha_fin']."' GROUP BY nombre_curso ORDER BY cuent DESC";
			$total_result2 = @mysql_query($sql2, $connection);
			$row2 = mysql_fetch_array($total_result2);

			$sql3="UPDATE constancias SET nombre_curso = '".$row2['nombre_curso']."' WHERE nombre_curso = 'Actualización Legislativa' AND duracion = '".$row['duracion']."' AND fecha_ini = '".$row['fecha_ini']."' AND fecha_fin = '".$row['fecha_fin']."'";
			@mysql_query($sql3, $connection);

			echo $sql3 . "<BR/>";
			}
			*/
	
$sql = "SELECT nombre_curso, modalidad, duracion, fecha_ini, fecha_fin FROM constancias WHERE modalidad = 'Presencial' AND lugar = 'Estado de México' GROUP BY nombre_curso, modalidad, duracion, fecha_ini, fecha_fin";
$total_result = @mysql_query($sql, $connection);
		for($i = 0; $row = mysql_fetch_array($total_result); $i++){
				$sql2 = "SELECT lugar, count(*) cuent FROM constancias WHERE modalidad = 'Presencial' AND lugar != 'Estado de México' AND nombre_curso = '".$row['nombre_curso']."' AND duracion = '".$row['duracion']."' AND fecha_ini = '".$row['fecha_ini']."' AND fecha_fin = '".$row['fecha_fin']."' GROUP BY lugar ORDER BY cuent DESC";
				$total_result2 = @mysql_query($sql2, $connection);
				$row2 = mysql_fetch_array($total_result2);
				if ($row2['lugar'] != ''){
					$sql3="UPDATE constancias SET lugar = '".$row2['lugar']."' WHERE modalidad = 'Presencial' AND lugar = 'Estado de México' AND nombre_curso = '".$row['nombre_curso']."' AND duracion = '".$row['duracion']."' AND fecha_ini = '".$row['fecha_ini']."' AND fecha_fin = '".$row['fecha_fin']."'";
					@mysql_query($sql3, $connection);
					}
				else{
					$sql3="Nada";
					}
			

			echo $sql3 . "<BR/>";
			}
	mysql_close($connection);
?>