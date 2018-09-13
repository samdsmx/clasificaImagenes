<!DOCTYPE HTML>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<title>Diagnostico Capacitacion del CJF</title>
	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.js"></script>
	<script type="text/javascript" src="includes/ddtf.js"></script>
    <script type="text/javascript" src="scripts/jquery.selectlist.dev.js"></script>
	<script type="text/javascript" src="https://www.google.com/jsapi"></script>
	<link type="text/css" rel="stylesheet" href="css/estilos.css" >
	<link type="text/css" rel="stylesheet" href="css/table.css" >
    <link href="css/modal.css" rel="stylesheet" type="text/css" />
    <script type="text/javascript">
		var cont = 0; 
		var seleccion = "";
		jQuery(document).ready(function($){
			$('#myTable').ddTableFilter(); //https://github.com/rbayliss/Dropdown-Table-Filter/blob/master/README.md
		});
		$(document).ready(function($) { 
	    	$("input[name='campo[]']").click(function(){
	        	if ($(this).is(':checked')) {               		
	            	$("input[id='"+this.value+"']").attr("disabled", false);               
	                }               
	               	else if ($(this).not(':checked')) {   	                 	
	                    var remove = '';                             	
                        $("input[id='"+this.value+"']").attr ('value', remove);
                        $("input[id='"+this.value+"']").attr("disabled", true);                            
	                    }           
	 			}); 

	    	$("#motivo").change(function(){
	        	if (this.value=='captura'){
					$("#otherTable td").show();
	        		}
	        		else{
						$("#otherTable td").hide();
	        			}
	 			}); 
	    	});

		 $(function() {
	        $("table tr:nth-child(odd)").addClass("odd-row");
			$("table td:first-child, table th:first-child").addClass("first");
			$("table td:last-child, table th:last-child").addClass("last");
			});

		function contar() {
			cont=0;
			seleccion = "";
			$("#modificaForm input[type='checkbox']").attr('checked', false);
			$("#modificaForm input[type='text']").val(""); 
			$("#modificaForm input[type='number']").val(""); 
			$("#modificaForm #motivo").val("Captura"); 
			$("#modificaForm input[type='text']").attr("disabled", true); 
			for (var i=0;i < document.forms[0].elements.length;i++){
	     		var elemento = document.forms[0].elements[i];
	    		if (elemento.type == "checkbox" && elemento.id != "chk1"){		
		     		if (elemento.checked){
					if (cont>=1)
						seleccion=seleccion+","+elemento.value;
						else
							seleccion=elemento.value;
					cont= cont +1;
					}
				}
			}
			if (cont == 0)
				alert ("No hay ningun caso seleccionado para modificar");
				else{
					$("#myResults span").html(cont);
					$("#documentos").val(seleccion);
					location.href='#modificarPopup';
					}
			}

	</script>
	<?
		include("paginas/menu.html");
		include("funciones/Datos_Comunicacion.php");
		include("includes/form_items.php");
		$NombreCapturista=RevisaSesion($Sesion, "identidad");
		$qry="";
		if (isset($cursoS) && $cursoS != ""){
			$qry="nombre_curso = '".$cursoS."' ";
			}
		if (isset($organismoS) && $organismoS != ""){
			$qry="organismo = '".$organismoS."' ";
			}
		if (isset($tipo_docS) && $tipo_docS != ""){
			$qry="tipo_doc = '".$tipo_docS."' ";
			}
		if (isset($tipo_capS) && $tipo_capS != ""){
			$qry="tipo_cap = '".$tipo_capS."' ";
			}
		if (isset($lugarS) && $lugarS != ""){
			$qry="lugar = '".$lugarS."' ";
			}
		if (isset($modalidadS) && $modalidadS != ""){
			$qry="modalidad = '".$modalidadS."' ";
			}			
		if (isset($duracionS) && $duracionS != ""){
			$qry="duracion = '".$duracionS."' ";
			}			
		if (isset($fechaS) && $fechaS != ""){
			$qry="fecha_ini = '".$fechaS."' ";
			}			
		if ($qry != ""){
			$qry="WHERE ".$qry;
			}
		$table="<table id='myTable' name='myTable' cellspacing='0' style='text-align:center;'>
					<tr>
						<th class='skip-filter'></th>
  						<th>Seleccionar</th>
  						<th>Imagen</th>
  						<th>Curso</th>
						<th>Organismo</th>
						<th>Tipo doc</th>
						<th>Tipo cap</th>
						<th>Modalidad</th>
						<th>Lugar</th>
						<th>Duracion</th>
						<th>Fecha ini</th>
						<th>Fecha fin</th>  						
						<th>Datos Captura</th> 
					</tr>
  					";
  		$sql ="SELECT c.*, b.* FROM constancias c, bitacora b ".$qry." AND b.documento=c.documento LIMIT 0,400";
		$total_result = @mysql_query($sql, $connection) or die("Error #". mysql_errno() . ": " . mysql_error());
		$i=0;
		while ($row = mysql_fetch_array($total_result)){
			$i++;
			$table.="<tr>
						<td>$i</td>
      					<td>".frm_check('documentos',$row[documento])."</td>
      					<td><img id='$row[documento]' src='exp_capturados/$row[documento]' width='80px'/></td>
						<td>$row[nombre_curso]</td>
						<td>$row[organismo]</td>
						<td>$row[tipo_doc]</td>
						<td>$row[tipo_cap]</td>
						<td>$row[modalidad]</td>
						<td>$row[lugar]</td>
						<td>$row[duracion]</td>
						<td>$row[fecha_ini]</td>
						<td>$row[fecha_fin]</td>
						<td>$row[usuario]</td>
    				</tr>";
			}
  		$table.="</table>";

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

		$sql ="SELECT modalidad, count(*) cuenta FROM Constancias Group by modalidad Order By cuenta Desc";
		$total_result = @mysql_query($sql, $connection);
		for($i = 0; $row = mysql_fetch_array($total_result); $i++){
			$arr_txt['modalidad'][$i] = $row['modalidad'];
			}

		$sql ="SELECT lugar, count(*) cuenta FROM Constancias Group by lugar Order By cuenta Desc";
		$total_result = @mysql_query($sql, $connection);
		for($i = 0; $row = mysql_fetch_array($total_result); $i++){
			$arr_txt['lugar'][$i] = $row['lugar'];
			}

		mysql_close($connection);
		?>
</head>
<body>
	
	<div id="container">
		
		<div id="formulario" style="margin:50px 5% 10px 5%; width:90%; text-align:center; ">	
			<fieldset>
				<legend id="lFieldset"><b>Resultados</b></abbr></legend>
				<div style="width:100%;text-align:left;">
					<div style="vertical-align:middle;float: left;padding-top:10px;">
						<img src="img/user-man.png" width="32px" style="vertical-align:middle;"/>
						<? echo $NombreCapturista; ?>
					</div>
					<div style="text-align:right;padding-right:10px;padding-bottom:10px;">
						<button id="editarB" onclick="contar();">
							<img src="img/configuration.png" alt="Editar" width="48px" title="Editar" />
						</button>
					</div>
				</div>
				<form id="formRes">
					<div style="padding:4px;">
						<?
							echo $table;		
						?>
					</div>
				</form>			
			</fieldset>
			
			<details tabindex="-1">
				<summary tabindex="-1"><abbr title="Centro Nacional de Calculo">CENAC</abbr> - <abbr title="Instituto Politecnico Nacional">IPN</abbr> 2013</summary>
				<p> - por Sergio Márquez <abbr title="smarquezs@ipn.mx">✉</abbr>. Todos los derechos reservados&reg;</p>
				<p>Todo la información e imagenes de expedientes en esta web son propiedad del Consejo de la Judicatura Federal.</p>
			</details>
		</div>
		
	</div>

		<a href="#x" class="overlay" id="modificarPopup"></a>
		<div class="popup">
        <div id="myResults"><h2>Modificar <span></span> imagen(es)</h2></div>
        <form id="modificaForm">
	        <table id="otherTable" name="otherTable">
	        	<tr><th colspan="2">Motivo:</th><th>
		        	<select id="motivo" name="motivo">
						<option value ="captura" selected>Captura</option>
						<option value ="periodo">Periodo fuera de rango (antes del 2007)</option>
						<option value ="ilegible">Imagen ilegible</option>
						<option value ="sin_info">Sin informacion relevante</option>
						<option value ="adjunto">Es un archivo adjunto al Diploma, Constancia o Certificado</option>
						<option value ="no_capacitacion">No avala capacitación (Ej. Ponencias, Cursos impartidos, etc.)</option>
						<option value ="no_corresponde_exp">El nombre no corresponde con el expediente registrado.</option>
					</select>
				</th></tr>
	        	<tr><td width="50px"><input type="checkbox" name="campo[]" value="nombre_curso"></td><td>Curso:</td><td><? echo frm_datalist2 ('nombre_curso', $arr_txt, $arr_txt,'Curso: ','','disabled');?></td></tr>
				<tr><td width="50px"><input type="checkbox" name="campo[]" value="organismo"></td><td>Organismo:</td><td><? echo frm_datalist2 ('organismo', $arr_txt, $arr_txt,'Organismo: ','','disabled');?></td></tr>	        	
				<tr><td width="50px"><input type="checkbox" name="campo[]" value="tipo_doc"></td><td>Documento:</td><td><? echo frm_datalist2 ('tipo_doc', $arr_txt, $arr_txt,'Tipo de documento: ','','disabled');?></td></tr>	        	
				<tr><td width="50px"><input type="checkbox" name="campo[]" value="tipo_cap"></td><td>Capacitación:</td><td><? echo frm_datalist2 ('tipo_cap', $arr_txt, $arr_txt,'Tipo de capacitación: ','','disabled');?></td></tr>	        	
				<tr><td width="50px"><input type="checkbox" name="campo[]" value="modalidad"></td><td>Modalidad:</td><td><? echo frm_datalist2 ('modalidad', $arr_txt, $arr_txt,'Modalidad: ','','disabled');?></td></tr>	        	
				<tr><td width="50px"><input type="checkbox" name="campo[]" value="lugar"></td><td>Lugar:</td><td><? echo frm_datalist2 ('lugar', $arr_txt, $arr_txt,'Lugar de impartición (Estado): ','','disabled');?></td></tr>	        	
				<tr><td width="50px"><input type="checkbox" name="campo[]" value="duracion"></td><td>Duración:</td><td><input type="number" id="duracion" name="duracion" placeholder="Horas" min="0" step="any" onkeypress="return isNumberKey(event)" disabled></td></tr>	        														        
				<tr><td width="50px"><input type="checkbox" name="campo[]" value="fecha_ini"></td><td>Fec. Inicio:</td><td><input type="date" id="fecha_ini" name="fecha_ini" min="2007-01-01" max="2013-06-30" disabled></tr>	        														        
				<tr><td width="50px"><input type="checkbox" name="campo[]" value="fecha_fin"></td><td>Fec. Termino:</td><td><input type="date" id="fecha_fin" name="fecha_fin" min="2007-01-01" max="2013-06-30" disabled></td></tr>	        														        				
	        </table>
	        <br/>
	        <INPUT TYPE="hidden" id="documentos" NAME="documentos" VALUE="aaa">
			<INPUT TYPE="hidden" NAME="Nombre" VALUE='<? echo $NombreCapturista; ?>' >
	       	<INPUT TYPE="hidden" NAME="Accion" VALUE="Modifica">
	        <div style="text-align:center;">
		        <button id="modificarB" type="submit" form="modificaForm" formaction="index.php" onclick="JavaScript:location.href='#close';">
					<img src="img/tick.png" alt="Modificar" width="48px" title="Modificar" />
				</button>
	        </div>
    	</form>
        <a class="close" href="#close"></a>
    </div>
</body>
</html>