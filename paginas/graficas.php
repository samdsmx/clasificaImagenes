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
		$sql = "SELECT p.ESCOLARIDAD, count(*) cuenta FROM padron p group by p.ESCOLARIDAD ORDER BY cuenta Desc";
		$result = mysql_query($sql, $connection);
		$grado = "['Grado Académico', 'Total'],";
		while ($r = mysql_fetch_row($result)){
			$s=array_shift($r);
			$grado .= "['".$s."',".implode(",", $r)."],";
			}
		
		/////////////////////////////////////////////////////////////
		/////////////////////////////////////////////////////////////
$cod['MX-DIF']='Distrito Federal';
$cod['MX-AGU']='Aguascalientes';
$cod['MX-BCN']='Baja California';
$cod['MX-BCS']='Baja California Sur';
$cod['MX-CAM']='Campeche';
$cod['MX-COA']='Coahuila de Zaragoza';
$cod['MX-COL']='Colima';
$cod['MX-CHP']='Chiapas';
$cod['MX-CHH']='Chihuahua';
$cod['MX-DUR']='Durango';
$cod['MX-GUA']='Guanajuato';
$cod['MX-GRO']='Guerrero';
$cod['MX-HID']='Hidalgo';
$cod['MX-JAL']='Jalisco';
$cod['MX-MEX']='Estado de México';
$cod['MX-MIC']='Michoacán de Ocampo';
$cod['MX-MOR']='Morelos';
$cod['MX-NAY']='Nayarit';
$cod['MX-NLE']='Nuevo León';
$cod['MX-OAX']='Oaxaca';
$cod['MX-PUE']='Puebla';
$cod['MX-QUE']='Querétaro';
$cod['MX-ROO']='Quintana Roo';
$cod['MX-SLP']='San Luis Potosí';
$cod['MX-SIN']='Sinaloa';
$cod['MX-SON']='Sonora';
$cod['MX-TAB']='Tabasco';
$cod['MX-TAM']='Tamaulipas';
$cod['MX-TLA']='Tlaxcala';
$cod['MX-VER']='Veracruz de Ignacio de la Llave';
$cod['MX-YUC']='Yucatán';
$cod['MX-ZAC']='Zacatecas';
		///////
		$sql = "SELECT p.lugar, count(*) cuenta FROM constancias p group by p.lugar ORDER BY cuenta Desc";
		$result = mysql_query($sql, $connection);
		$cursos = "['City', 'Total'],";
		while ($r = mysql_fetch_row($result)){
			$s=array_shift($r);

			$s=array_search($s, $cod);
			if ($s){
				$cursos .= "['".$s."',".implode(",", $r)."],";
				}
			}
		echo $cursos.'<BR/>';
		/////////////////////////////////////////////////////////////
		/////////////////////////////////////////////////////////////
		$sql = "SELECT LEFT( FECHA_NACIMIENTO, 4 ) YEAR, COUNT( * ) FROM padron GROUP BY YEAR ORDER BY YEAR DESC";
		$result = mysql_query($sql, $connection);
		$edad = "['Edad', 'Total'],";
		while ($r = mysql_fetch_row($result)){
			$s=array_shift($r);
			$edad .= "['".(2013-intval($s))." años',".implode(",", $r)."],";
			}
		/////////////////////////////////////////////////////////////
		/////////////////////////////////////////////////////////////
		$sql = "SELECT escolaridad,
			SUM(IF(sexo = 'M',1,0)) as Masculino,
		    SUM(IF(sexo = 'F',1,0)) as Femenino
			FROM 
		    padron group by escolaridad ORDER BY escolaridad Desc";
		$result = mysql_query($sql, $connection);
		$gradoG = "['Grado','Hombres','Mujeres'],";
		while ($r = mysql_fetch_row($result)){
			$s=array_shift($r);
			$gradoG .= "['".$s."',".implode(",", $r)."],";
			}
			
		/////////////////////////////////////////////////////////////
		/////////////////////////////////////////////////////////////
		$sql = "SELECT LEFT( FECHA_NACIMIENTO, 4 ) YEAR,
			SUM(IF(sexo = 'M',1,0)) as Masculino,
		    SUM(IF(sexo = 'F',1,0)) as Femenino
			FROM 
		    padron group by YEAR ORDER BY YEAR Desc";
		$result = mysql_query($sql, $connection);
		$edadG = "['Edad','Hombres','Mujeres'],";
		while ($r = mysql_fetch_row($result)){
			$s=array_shift($r);
			$edadG .= "['".(2013-intval($s))." años',".implode(",", $r)."],";
			}
		/////////////////////////////////////////////////////////////
		/////////////////////////////////////////////////////////////
		$sql = "SELECT LUGAR_NACIMIENTO, COUNT( * ) cuenta FROM padron WHERE LUGAR_NACIMIENTO <> '' GROUP BY LUGAR_NACIMIENTO HAVING cuenta > 3 ORDER BY cuenta DESC";
		$result = mysql_query($sql, $connection);
		$lugarN = "['Estado', 'Total'],";
		while ($r = mysql_fetch_row($result)){
			$s=array_shift($r);
			$lugarN .= "['".$s."',".implode(",", $r)."],";
			}
		/////////////////////////////////////////////////////////////
		mysql_close($connection);
	?>
	<script type="text/javascript">
      google.load('visualization', '1.0', {'packages':['corechart','timeline','geochart']});
	  google.setOnLoadCallback(drawChart_Grado);
	  google.setOnLoadCallback(drawChart_DH);
	  google.setOnLoadCallback(drawChart_Edad);

 function drawChart_Grado() {
		var data = new google.visualization.arrayToDataTable([<? echo $grado; ?>])
        var options = {
    				   title: 'Grado Actual',
 					   width:800,
                       height:300,
                       is3D:true               	   
                   	   //sliceVisibilityThreshold: 1/7200
                   	};
	    var chart = new google.visualization.PieChart(document.getElementById('chart_divGrado'));
        chart.draw(data, options);
        }

      function drawChart_DH() {
		var data = new google.visualization.arrayToDataTable([<? echo $cursos; ?>])
        var options = {
        		region: 'MX',
        		resolution: 'provinces',
        		/*sizeAxis: { minValue: 0, maxValue: 5000 },
        		displayMode: 'markers',*/
        		colorAxis: {colors: ['#00ffff', '#ff0000']}
                   	};
	    var chart = new google.visualization.GeoChart(document.getElementById('chart_divDH'));
        chart.draw(data, options);
        }
      function drawChart_Edad() {
		var data = new google.visualization.arrayToDataTable([<? echo $edad; ?>])
        var options = {
    				   title: 'Edad',
 					   width:400,
                       height:300,
                       vAxis: {viewWindowMode: 'maximized' },
                       colors: ['orange'],
                       legend: 'none'
                   	};
	    var chart = new google.visualization.ColumnChart(document.getElementById('chart_divEdad'));
        chart.draw(data, options);

		data = new google.visualization.arrayToDataTable([<? echo $edadG; ?>])
        var options = {
    				   title: 'Edad por Genero',
 					   width:800,
                       height:400,
                       legend: { position: 'bottom', maxLines: 3 },
                       vAxis: {viewWindowMode: 'maximized' }
                   	};
	    var chart = new google.visualization.ColumnChart(document.getElementById('chart_divEdadG'));
        chart.draw(data, options);

		data = new google.visualization.arrayToDataTable([<? echo $gradoG; ?>])
        var options = {
    				   title: 'Grado Académico por Genero',
 					   width:800,
                       height:400,
                       legend: { position: 'bottom', maxLines: 3 },
                       vAxis: {viewWindowMode: 'maximized' }
                   	};
	    var chart = new google.visualization.ColumnChart(document.getElementById('chart_divGradoG'));
        chart.draw(data, options);


		data = new google.visualization.arrayToDataTable([<? echo $cursos; ?>])
        var options = {
    				   title: 'Tipos de Capacitaciones principales',
    				   height:1000,
    				   colors: ['orange'],
    				   vAxis: { textStyle: {fontSize: 12}, viewWindowMode: 'maximized' },
                       legend: 'none'
                   	};
	    var chart = new google.visualization.BarChart(document.getElementById('chart_divLugarN'));
        chart.draw(data, options);


        }

    </script>
</head>
<body>
	<div>
				<div id="chart_divGradoG"></div>
				<div id="chart_divGrado"></div>
				<div id="chart_divDH"></div>
				<div id="chart_divEdad"></div>
				<div id="chart_divEdadG"></div>
				<div id="chart_divLugarN"></div>
	</div>
</body>
</html>