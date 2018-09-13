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
		$sql = "SELECT usuario,
			SUM(IF(accion = 'Captura',1,0)) as Captura,
		    SUM(IF(accion = 'sin_info',1,0)) as sin_info,
		    SUM(IF(accion = 'periodo',1,0)) as periodo,
			SUM(IF(accion = 'no_capacitacion',1,0)) as no_capacitacion,
		    SUM(IF(accion = 'adjunto',1,0)) as adjunto, 
		    SUM(IF(accion = 'ilegible',1,0)) as ilegible,
			SUM(IF(accion = 'no_corresponde_exp',1,0)) as no_corresponde_exp 
			FROM 
		    bitacora group by usuario ORDER BY COUNT(usuario) Desc";
		$result = mysql_query($sql, $connection);
		$col = "['Usuario', 'Captura', 'sin_info', 'periodo', 'no_capacitacion', 'adjunto', 'ilegible', 'no_corresponde_exp'],";
		while ($r = mysql_fetch_row($result)){
			$s=array_shift($r);
			$col .= "['".$s."',".implode(",", $r)."],";
			}
		/////////////////////////////////////////////////////////////
		/////////////////////////////////////////////////////////////
		$sql = "SELECT accion, COUNT(*) cuenta FROM bitacora Group by accion Order by cuenta Desc";
		$result = mysql_query($sql, $connection);
		$tipo_doc = "['Tipo', 'Total'],";
		while ($r = mysql_fetch_row($result)){
			$s=array_shift($r);
			$tipo_doc .= "['".$s."',".implode(",", $r)."],";
			}
		/////////////////////////////////////////////////////////////
		/////////////////////////////////////////////////////////////
		$sql = "SELECT usuario, COUNT(*) cuenta FROM bitacora Group by usuario Order by cuenta Desc";
		$result = mysql_query($sql, $connection);
		$usuarioPie = "['Usuario', 'Total'],";
		while ($r = mysql_fetch_row($result)){
			$s=array_shift($r);
			$usuarioPie .= "['".$s."',".implode(",", $r)."],";
			}
		/////////////////////////////////////////////////////////////
		//////////////////////////////////////////////////////////////////
		$sql = "SELECT TRIM(usuario) usuario, DAY( Fecha ) dia, MONTH( fecha ) mes, YEAR( fecha ) ano, HOUR( fecha ) hora, MIN( MINUTE( fecha ) ) minuto_min, MAX( MINUTE( fecha ) ) minuto_max, COUNT( * ) cant
		        FROM bitacora 
		        GROUP BY hora, dia, mes, ano, usuario
		        ORDER BY usuario, id";
		$result = mysql_query($sql, $connection);
		$timeline2="";
		while ($r = mysql_fetch_array($result)){
		    $timeline2 .= "[".
		        "new Date(".$r['ano'].",".($r['mes']-1).",".$r['dia'].",".$r['hora'].",".$r['minuto_min'].",0),".
		        "new Date(".$r['ano'].",".($r['mes']-1).",".$r['dia'].",".$r['hora'].",".$r['minuto_max'].",59),".
		        "'',"."'".$r['usuario']."',"."''".
		        "],";
		    }
		$timeline2=substr($timeline2, 0, -1);
		///////////////////////////////////////////////////////////////
		$sql ="SELECT COUNT(*) cuenta FROM bitacora";
		$total_result = @mysql_query($sql, $connection);
		$revisados = mysql_fetch_array($total_result);
		///////////////////////////////////////////////////////////////
		////////////////////////////////////////////////////////////////
		$NombreCapturista=RevisaSesion($Sesion, "identidad");
		mysql_close($connection);
	?>
	<script type="text/javascript">
      google.load('visualization', '1.0', {'packages':['corechart','timeline']});
      google.setOnLoadCallback(drawChart_DocxUsu);
	  google.setOnLoadCallback(drawChart_Doc);
	  google.setOnLoadCallback(drawChart_Usu);
	  google.setOnLoadCallback(drawVisualization);
      function drawChart_DocxUsu() {
		var data = new google.visualization.arrayToDataTable([<? echo $col; ?>])
        var options = {
    				   title: 'Tipo de documentos revisados por Usuario',
      				   isStacked: true,
                       height:500,
                       chartArea: {width: "55%"},
                   	   backgroundColor:'#f0f0f0'
                   	};
	    var chart = new google.visualization.ColumnChart(document.getElementById('chart_div'));
        chart.draw(data, options);
        }
      function drawChart_Doc() {
		var data = new google.visualization.arrayToDataTable([<? echo $tipo_doc; ?>])
        var options = {
    				   title: 'Tipo de documentos revisados',
                   	   backgroundColor:'#f0f0f0',
                   	   height:300,
                   	   pieResidueSliceLabel: 'Otros'
                   	   //sliceVisibilityThreshold: 1/7200
                   	};
	    var chart = new google.visualization.PieChart(document.getElementById('chart_div2'));
        chart.draw(data, options);
        }
      function drawChart_Usu() {
		var data = new google.visualization.arrayToDataTable([<? echo $usuarioPie; ?>])
        var options = {
    				   title: 'Cantidad de documentos revisados por Usuarios',
                       height:300,
                   	   backgroundColor:'#f0f0f0',
                   	   pieResidueSliceLabel: 'Otros'
                   	};
	    var chart = new google.visualization.PieChart(document.getElementById('chart_div3'));
        chart.draw(data, options);
        }
    var timeline = undefined;
    var data = undefined;
    function drawVisualization() {
        data = new google.visualization.DataTable();
        data.addColumn({ type: 'datetime', id: 'start' });
        data.addColumn({ type: 'datetime', id: 'end' });
        data.addColumn('string', 'content');
        data.addColumn('string', 'group');
        data.addColumn('string', 'className');
        data.addRows([<? echo $timeline2; ?>]);
        // specify options
        var options = {
            width:  "95%",
            axisOnTop: true,
            editable: false,
            locale: "es",
            showNavigation: true
        };
        // Instantiate our timeline object.
        timeline = new links.Timeline(document.getElementById('mytimeline'));
        timeline.draw(data, options);
        var start = new Date(now.getTime() - 4 * 60 * 60 * 100);
        var end = new Date(now.getTime() + 8 * 60 * 60 * 100);
        timeline.setVisibleChartRange(start, end);
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


    </script>
</head>
<body>
	<div id="container">
		<div id="formulario" style="margin:50px 5% 10px 5%; width:90%; ">	
			<fieldset>
				<legend id="lFieldset"><b>Estadisticas</b></abbr></legend>
				<div style="padding-top:5px;vertical-align:middle;"><img src="img/user-man.png" width="32px" style="vertical-align:middle;"/>
				<? echo $NombreCapturista; ?></div>
				<br/>
				<label>Progreso General: <progress style="width:90%;" value="<? echo $revisados['cuenta'];?>" max="149688" title="Progreso general: <? echo round($revisados['cuenta']/149688*100,2);?>%"></progress></label>
				<div id="chart_div"></div>
				<div id="chart_div2"></div>
				<div id="chart_div3"></div>
				<div id="mytimeline"></div>
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