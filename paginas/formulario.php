<!DOCTYPE HTML>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<title>Diagnostico Capacitacion del CJF</title>
	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.js"></script>
	<script type="text/javascript" src="includes/ddpowerzoomer.js"></script>
 	<script type="text/javascript" src="scripts/shortcuts.js"></script>
 	<script type="text/javascript" src="js/misFunciones.js"></script>
	<link type="text/css" rel="stylesheet" href="css/estilos.css" >
	<link href="css/modal.css" rel="stylesheet" type="text/css" />

</head>
<body onload="teclas();">
	<?
		include("paginas/menu.html");
		include("includes/form_items.php");
		include("funciones/randomImages.php");
		include("funciones/Datos_Comunicacion.php");
		
		$NombreCapturista=RevisaSesion($Sesion, "identidad");

		$imgList = getImagesFromDir($root . $path);
		
		$img = getRandomFromArray($imgList);
		$exp=substr($img,0,strpos($img,' '));	

		$sql ="SELECT nombre_curso, count(*) cuenta FROM Constancias Group by nombre_curso Order By cuenta Desc";
		$total_result = @mysql_query($sql, $connection);
		for($i = 0; $row = mysql_fetch_array($total_result); $i++){
			$arr_txt['nombre_curso'][$i] = $row['nombre_curso'];
			}
		
		$sql ="SELECT organismo, count(*) cuenta FROM Constancias Group by organismo Order By cuenta Desc";
		$total_result = @mysql_query($sql, $connection);
		for($i = 0; $row = mysql_fetch_array($total_result); $i++){
			$arr_txt['organismo'][$i] = $row['organismo'];
			}
		
		$sql ="SELECT tipo_doc, count(*) cuenta FROM Constancias Group by tipo_doc Order By cuenta Desc";
		$total_result = @mysql_query($sql, $connection);
		for($i = 0; $row = mysql_fetch_array($total_result); $i++){
			$arr_txt['tipo_doc'][$i] = $row['tipo_doc'];
			}
		
		$sql ="SELECT tipo_cap, count(*) cuenta FROM Constancias Group by tipo_cap Order By cuenta Desc";
		$total_result = @mysql_query($sql, $connection);
		for($i = 0; $row = mysql_fetch_array($total_result); $i++){
			$arr_txt['tipo_cap'][$i] = $row['tipo_cap'];
			}

		$sql ="SELECT lugar, count(*) cuenta FROM Constancias Group by lugar Order By cuenta Desc";
		$total_result = @mysql_query($sql, $connection);
		for($i = 0; $row = mysql_fetch_array($total_result); $i++){
			$arr_txt['lugar'][$i] = $row['lugar'];
			}

		$sql ="SELECT modalidad, count(*) cuenta FROM Constancias Group by modalidad Order By cuenta Desc";
		$total_result = @mysql_query($sql, $connection);
		for($i = 0; $row = mysql_fetch_array($total_result); $i++){
			$arr_txt['modalidad'][$i] = $row['modalidad'];
			}

		$sql ="SELECT * FROM Padron WHERE Exp = '$exp'";
		$total_result = @mysql_query($sql, $connection);
		$row = mysql_fetch_array($total_result);

		$sql ="SELECT COUNT(*) cuenta FROM bitacora";
		$total_result = @mysql_query($sql, $connection);
		$revisados = mysql_fetch_array($total_result);		
		
		mysql_close($connection);
	
	?>
	<div id="container">
		<div id="imagen">
			<figure>
				<img id="imagen_expediente" src="<? echo $path.$img; ?>" tabindex="-1"/>	
				<figcaption><? echo $img; ?></figcaption>
			</figure>
			<br />
			<button accesskey="d" id="eliminarB" onclick="JavaScript:location.href='#confirmPopup';JavaScript:document.forms['popupForm'].motivo.focus();" tabindex="-1">
				<img src="img/bin-full.png" alt="Eliminar" width="48px" title="Eliminar"/>
			</button>
		</div>
			<button accesskey="j" id="saltarB" onclick="JavaScript:location.reload()" tabindex="-1">
					<img src="img/refresh.png" alt="Saltar" width="48px" title="Saltar" />
			</button>
		<div id="formulario">	
				<div style="padding-top:5px;vertical-align:middle;"><img src="img/user-man.png" width="32px" style="vertical-align:middle;"/>
				<? echo $NombreCapturista; ?></div>
			<fieldset>
				<legend id="lFieldset"><b>Datos Personales</b></abbr></legend>
				<label>Nombre: <b><? echo $row['NOMBRE']." ".$row['PATERNO']." ".$row['MATERNO']; ?></b></label>
				<label># Expediente: <? echo $exp; ?></label>
			</fieldset>
			<form id="capturaForm">
				<fieldset>
					<legend id="lFieldset"><b>Captura del documento de capacitación </b><abbr title="Capturar solo documentos que avalen una capacitación (Cursos, Diplomados, Etc.) Excluir aquellos donde se haya participado como instructor y aquellos que daten de antes oel 2007">✍</abbr><progress value="<? echo $revisados['cuenta'];?>" max="149688" title="Progreso general: <? echo round($revisados['cuenta']/149688*100,2);?>%"></progress></legend>
					
					<label>Fecha de inicio: <input type="date" id="sDate" name="sDate" min="2007-01-01" max="2013-06-30" onblur="actFecha()" autofocus required></label>
					<label>Fecha de termino: <input type="date" id="eDate" name="eDate" min="2007-01-01" max="2013-06-30" required></label>
								
					<? echo frm_datalist ('nombre_curso', $arr_txt, $arr_txt,'Nombre del curso: ','',"required");?>
					<? echo frm_datalist ('organismo', $arr_txt, $arr_txt,'Organismo que imparte la capacitación: ','',"required");?>
					<? echo frm_datalist ('tipo_doc', $arr_txt, $arr_txt,'Tipo de documento: ','',"required");?>
					<? echo frm_datalist ('tipo_cap', $arr_txt, $arr_txt,'Tipo de capacitación: ','',"required");?>
					<? echo frm_datalist ('modalidad', $arr_txt, $arr_txt,'Modalidad: ','',"required");?>
					<? echo frm_datalist ('lugar', $arr_txt, $arr_txt,'Lugar de impartición (Estado): ','',"");?>
					<label>Duración:<input type="number" id="duracion" name="duracion" placeholder="Horas" min="0" step="any" onkeypress="return isNumberKey(event)"></label>
					<span style="text-align:right;display:block;margin:10px;">
						<INPUT TYPE="hidden" NAME="Nombre" VALUE='<? echo $NombreCapturista; ?>' >
	        			<INPUT TYPE="hidden" NAME="Imagen" VALUE='<? echo $img; ?>' >
	        			<INPUT TYPE="hidden" NAME="Accion" VALUE="Salva">
						<button id="guardarB" accesskey="g" type="submit" form="capturaForm" formaction="index.php">
							<img src="img/disc-floopy.png" alt="Guardar" width="48px" title="Guardar" />
						</button>
					</span>
				</fieldset>
			</form>
			<details tabindex="-1">
				<summary tabindex="-1"><abbr title="Centro Nacional de Calculo">CENAC</abbr> - <abbr title="Instituto Politecnico Nacional">IPN</abbr> 2013</summary>
				<p> - por Sergio Márquez <abbr title="smarquezs@ipn.mx">✉</abbr>. Todos los derechos reservados&reg;</p>
				<p>Todo la información e imagenes de expedientes en esta web son propiedad del Consejo de la Judicatura Federal.</p>
			</details>
		</div>
	</div>

    <a href="#x" class="overlay" id="confirmPopup"></a>
    <div class="popup">
        <h2>¿Seguro quieres descartar la imagen?</h2>
        <form id="popupForm">
	        <div>
	            <label for="motivo">Por favor marca el motivo:</label>
	            <select id="motivo" name="motivo">
					<option value ="periodo">Periodo fuera de rango (antes del 2007)</option>
					<option value ="ilegible">Imagen ilegible</option>
					<option value ="sin_info" selected>Sin informacion relevante</option>
					<option value ="adjunto">Es un archivo adjunto al Diploma, Constancia o Certificado</option>
					<option value ="no_capacitacion">No avala capacitación (Ej. Ponencias, Cursos impartidos, etc.)</option>
					<option value ="no_corresponde_exp">El nombre no corresponde con el expediente registrado.</option>
				</select>
	        </div>
	        <INPUT TYPE="hidden" NAME="Nombre" VALUE='<? echo $NombreCapturista; ?>' >
	        <INPUT TYPE="hidden" NAME="Imagen" VALUE='<? echo $img; ?>' >
	        <INPUT TYPE="hidden" NAME="Accion" VALUE="Descarta">
	        <div style="text-align:center;">
		        <button id="descartarB" type="submit" form="popupForm" formaction="index.php" onclick="JavaScript:location.href='#close'">
					<img src="img/tick.png" alt="Saltar" width="48px" title="Descartar" />
				</button>
	        </div>
    	</form>
        <a class="close" href="#close"></a>
    </div>
</body>
</html>