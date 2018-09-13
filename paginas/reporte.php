<!DOCTYPE HTML>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<title>Diagnostico Capacitacion del CJF</title>
	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.js"></script>
    <script type="text/javascript" src="scripts/jquery.selectlist.dev.js"></script>
	<script type="text/javascript" src="https://www.google.com/jsapi"></script>
	<link type="text/css" rel="stylesheet" href="css/estilos.css" >
	<link href="css/modal.css" rel="stylesheet" type="text/css" />
    <script type="text/javascript" src="scripts/timeline.js"></script>
    <script type="text/javascript" src="scripts/timeline-locales.js"></script>
    <link rel="stylesheet" type="text/css" href="css/timeline.css">

	<?
		include("paginas/menu.html");
		include("funciones/Datos_Comunicacion.php");
		/////////////////////////////////////////////////////////////
		$sql = "SELECT nombre_curso, COUNT(*) cuenta FROM constancias Group by nombre_curso Order by cuenta Desc";
		$result = mysql_query($sql, $connection);
		$cursos = "['Curso', 'Total'],";
		while ($r = mysql_fetch_row($result)){
			$s=array_shift($r);
			$cursos .= "['".$s."',".implode(",", $r)."],";
			}
		/////////////////////////////////////////////////////////////
		/////////////////////////////////////////////////////////////
		$sql = "SELECT organismo, COUNT(*) cuenta FROM constancias Group by organismo Order by cuenta Desc";
		$result = mysql_query($sql, $connection);
		$organismos = "['Organismo', 'Total'],";
		while ($r = mysql_fetch_row($result)){
			$s=array_shift($r);
			$organismos .= "['".$s."',".implode(",", $r)."],";
			}
		///////////////////////////////////////////////////////////////
		////////////////////////////////////////////////////////////////
		$sql = "SELECT tipo_doc, COUNT(*) cuenta FROM constancias Group by tipo_doc Order by cuenta Desc";
		$result = mysql_query($sql, $connection);
		$tipoDocs = "['Tipo', 'Total'],";
		while ($r = mysql_fetch_row($result)){
			$s=array_shift($r);
			$tipoDocs .= "['".$s."',".implode(",", $r)."],";
			}
		///////////////////////////////////////////////////////////////
		////////////////////////////////////////////////////////////////
		$sql = "SELECT tipo_cap, COUNT(*) cuenta FROM constancias Group by tipo_cap Order by cuenta Desc";
		$result = mysql_query($sql, $connection);
		$tipoCaps = "['Tipo', 'Total'],";
		while ($r = mysql_fetch_row($result)){
			$s=array_shift($r);
			$tipoCaps .= "['".$s."',".implode(",", $r)."],";
			}
		///////////////////////////////////////////////////////////////
		////////////////////////////////////////////////////////////////
		$sql = "SELECT modalidad, COUNT(*) cuenta FROM constancias Group by modalidad Order by cuenta Desc";
		$result = mysql_query($sql, $connection);
		$tipoMods = "['Tipo', 'Total'],";
		while ($r = mysql_fetch_row($result)){
			$s=array_shift($r);
			$tipoMods .= "['".$s."',".implode(",", $r)."],";
			}
		///////////////////////////////////////////////////////////////
		////////////////////////////////////////////////////////////////
		$sql = "SELECT lugar, COUNT(*) cuenta FROM constancias Group by lugar Order by cuenta Desc";
		$result = mysql_query($sql, $connection);
		$tipoLugar = "['Lugar', 'Total'],";
		while ($r = mysql_fetch_row($result)){
			$s=array_shift($r);
			$tipoLugar .= "['".$s."',".implode(",", $r)."],";
			}
		///////////////////////////////////////////////////////////////
		////////////////////////////////////////////////////////////////
		$sql = "SELECT duracion, COUNT(*) cuenta FROM constancias Group by duracion Order by duracion Asc";
		$result = mysql_query($sql, $connection);
		$duraciones = "['Horas', 'Total'],";
		while ($r = mysql_fetch_row($result)){
			$s=array_shift($r);
			$duraciones .= "['".$s."',".implode(",", $r)."],";
			}
		///////////////////////////////////////////////////////////////
		////////////////////////////////////////////////////////////////
		$sql = "SELECT fecha_ini, COUNT(*) cuenta FROM constancias Group by fecha_ini Order by fecha_ini Asc";
		$result = mysql_query($sql, $connection);
		$fechas = "['Horas', 'Total'],";
		while ($r = mysql_fetch_row($result)){
			$s=array_shift($r);
			$fechas .= "['".$s."',".implode(",", $r)."],";
			}
		///////////////////////////////////////////////////////////////
		////////////////////////////////////////////////////////////////
		$NombreCapturista=RevisaSesion($Sesion, "identidad");
		mysql_close($connection);
	?>
	<script type="text/javascript">
      google.load('visualization', '1.0', {'packages':['corechart','timeline','table']});
	  google.setOnLoadCallback(drawChart_Cursos);
	  google.setOnLoadCallback(drawChart_Organismos);
	  google.setOnLoadCallback(drawChart_TipoDocs);
	  google.setOnLoadCallback(drawChart_TipoCaps);
	  google.setOnLoadCallback(drawChart_TipoMods);
	  google.setOnLoadCallback(drawChart_TipoLugar);
      google.setOnLoadCallback(drawChart_Duraciones);
      google.setOnLoadCallback(drawChart_Fechas);
      function drawChart_Cursos() {
		var data = new google.visualization.arrayToDataTable([<? echo $cursos; ?>])
	    var chart = new google.visualization.Table(document.getElementById('chart_cursos'));
        chart.draw(data, {showRowNumber: true});
		google.visualization.events.addListener(chart, 'select',  function() {
	        var selection = chart.getSelection();
	        var item = selection[0];
	     	var str = data.getFormattedValue(item.row, 0);
    		window.open("?Accion=Busqueda&cursoS="+str+"","_self");
			});
        }
      function drawChart_Organismos() {
		var data = new google.visualization.arrayToDataTable([<? echo $organismos; ?>])
	    var chart = new google.visualization.Table(document.getElementById('chart_organismos'));
        chart.draw(data, {showRowNumber: true});
		google.visualization.events.addListener(chart, 'select',  function() {
	        var selection = chart.getSelection();
	        var item = selection[0];
	     	var str = data.getFormattedValue(item.row, 0);
    		window.open("?Accion=Busqueda&organismoS="+str+"","_self");
			});
        }
      function drawChart_TipoDocs() {
		var data = new google.visualization.arrayToDataTable([<? echo $tipoDocs; ?>])
	    var chart = new google.visualization.Table(document.getElementById('chart_TipoDocs'));
        chart.draw(data, {showRowNumber: true});
		google.visualization.events.addListener(chart, 'select',  function() {
	        var selection = chart.getSelection();
	        var item = selection[0];
	     	var str = data.getFormattedValue(item.row, 0);
    		window.open("?Accion=Busqueda&tipo_docS="+str+"","_self");
			});        
        }
     function drawChart_TipoCaps() {
		var data = new google.visualization.arrayToDataTable([<? echo $tipoCaps; ?>])
	    var chart = new google.visualization.Table(document.getElementById('chart_TipoCaps'));
        chart.draw(data, {showRowNumber: true});
		google.visualization.events.addListener(chart, 'select',  function() {
	        var selection = chart.getSelection();
	        var item = selection[0];
	     	var str = data.getFormattedValue(item.row, 0);
    		window.open("?Accion=Busqueda&tipo_capS="+str+"","_self");
			});        
        }
     function drawChart_TipoMods() {
		var data = new google.visualization.arrayToDataTable([<? echo $tipoMods; ?>])
	    var chart = new google.visualization.Table(document.getElementById('chart_TipoMods'));
        chart.draw(data, {showRowNumber: true});
		google.visualization.events.addListener(chart, 'select',  function() {
	        var selection = chart.getSelection();
	        var item = selection[0];
	     	var str = data.getFormattedValue(item.row, 0);
    		window.open("?Accion=Busqueda&modalidadS="+str+"","_self");
			});        
        }        
     function drawChart_TipoLugar() {
		var data = new google.visualization.arrayToDataTable([<? echo $tipoLugar; ?>])
	    var chart = new google.visualization.Table(document.getElementById('chart_TipoLugar'));
        chart.draw(data, {showRowNumber: true});
		google.visualization.events.addListener(chart, 'select',  function() {
	        var selection = chart.getSelection();
	        var item = selection[0];
	     	var str = data.getFormattedValue(item.row, 0);
    		window.open("?Accion=Busqueda&lugarS="+str+"","_self");
			});         
        }            
      function drawChart_Duraciones() {
		var data = new google.visualization.arrayToDataTable([<? echo $duraciones; ?>])
	    var chart = new google.visualization.Table(document.getElementById('chart_duraciones'));
        chart.draw(data, {showRowNumber: true});
		google.visualization.events.addListener(chart, 'select',  function() {
	        var selection = chart.getSelection();
	        var item = selection[0];
	     	var str = data.getFormattedValue(item.row, 0);
    		window.open("?Accion=Busqueda&duracionS="+str+"","_self");
			});    
        }     
      function drawChart_Fechas() {
		var data = new google.visualization.arrayToDataTable([<? echo $fechas; ?>])
	    var chart = new google.visualization.Table(document.getElementById('chart_fechas'));
        chart.draw(data, {showRowNumber: true});
		google.visualization.events.addListener(chart, 'select',  function() {
	        var selection = chart.getSelection();
	        var item = selection[0];
	     	var str = data.getFormattedValue(item.row, 0);
    		window.open("?Accion=Busqueda&fechaS="+str+"","_self");
			});    
        }     

    function getSelectedRow(){
        var row = undefined;
        var sel = timeline.getSelection();
        if (sel.length) {
            if (sel[0].row != undefined) {
                row = sel[0].row;
            }
        }
        return row;
    }

    function strip(html){
        var tmp = document.createElement("DIV");
        tmp.innerHTML = html;
        return tmp.textContent||tmp.innerText;
    }


  function selectHandler(e) {
      alert ('hola');
    /*ar selection = e['page'];
    alert ('hola2'+selection);
    var message = '';
    var item = selection[0];
   alert ('hola3'+item);
    message = '{row:' + item.row + ',column:' + item.column + '} = ' + str + '\n';    
    alert('You selected ' + message);*/
  }

    </script>
</head>
<body>
	<div id="container">
		<div id="formulario" style="margin:50px 5% 10px 5%; width:90%; ">	
			<fieldset>
				<legend id="lFieldset"><b>Reporte</b></abbr></legend>
				<div style="padding-top:5px;vertical-align:middle;"><img src="img/user-man.png" width="32px" style="vertical-align:middle;"/>
				<? echo $NombreCapturista; ?></div>
				<br/>
				<div id="chart_cursos"></div>
				<div id="chart_organismos"></div>
				<div id="chart_TipoDocs"></div>
				<div id="chart_TipoCaps"></div>
				<div id="chart_TipoMods"></div>
				<div id="chart_TipoLugar"></div>
				<div id="chart_duraciones"></div>
				<div id="chart_fechas"></div>
				<br/>
			</fieldset>
			
			<details tabindex="-1">
				<summary tabindex="-1"><abbr title="Centro Nacional de Calculo">CENAC</abbr> - <abbr title="Instituto Politecnico Nacional">IPN</abbr> 2013</summary>
				<p> - por Sergio Márquez <abbr title="smarquezs@ipn.mx">✉</abbr>. Todos los derechos reservados&reg;</p>
				<p>Todo la información e imagenes de expedientes en esta web son propiedad del Consejo de la Judicatura Federal.</p>
			</details>
		</div>
	</div>
</body>
</html>