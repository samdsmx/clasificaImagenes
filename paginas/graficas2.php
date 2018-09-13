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
		$sql = "SELECT p.cargo_actual, count(*) cuenta FROM padron p group by p.cargo_actual ORDER BY cuenta Desc";
		$result = mysql_query($sql, $connection);
		$cargo = "['Cargo', 'Total'],";
		while ($r = mysql_fetch_row($result)){
			$s=array_shift($r);
			$cargo .= "['".$s."',".implode(",", $r)."],";
			}
		
		/////////////////////////////////////////////////////////////
		/////////////////////////////////////////////////////////////
		$sql = "SELECT p.sexo, count(*) cuenta FROM padron p group by p.sexo ORDER BY cuenta Desc";
		$result = mysql_query($sql, $connection);
		$genero = "['Genero', 'Total'],";
		while ($r = mysql_fetch_row($result)){
			$s=array_shift($r);
			$genero .= "['".($s=='M'?'Masculino':'Femenino')."',".implode(",", $r)."],";
			}
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
		$sql = "SELECT cargo_actual,
			SUM(IF(sexo = 'M',1,0)) as Masculino,
		    SUM(IF(sexo = 'F',1,0)) as Femenino
			FROM 
		    padron WHERE cargo_actual NOT like '%MAGISTRADO%' AND cargo_actual NOT like '%JUEZ%' group by cargo_actual ORDER BY cargo_actual Desc";
		$result = mysql_query($sql, $connection);
		$cargoG = "['Cargo','Hombres','Mujeres'],";
		while ($r = mysql_fetch_row($result)){
			$s=array_shift($r);
			$cargoG .= "['".$s."',".implode(",", $r)."],";
			}
			echo $cargoG;
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
      google.load('visualization', '1.0', {'packages':['corechart','timeline']});
	  google.setOnLoadCallback(drawChart_Cargo);
	  google.setOnLoadCallback(drawChart_Genero);
	  google.setOnLoadCallback(drawChart_Edad);

 function drawChart_Cargo() {
		var data = new google.visualization.arrayToDataTable([<? echo $cargo; ?>])
        var options = {
    				   title: 'Cargo Actual',
 					   width:800,
                       height:300,
                       is3D:true               	   
                   	   //sliceVisibilityThreshold: 1/7200
                   	};
	    var chart = new google.visualization.PieChart(document.getElementById('chart_divCargo'));
        chart.draw(data, options);
        }

      function drawChart_Genero() {
		var data = new google.visualization.arrayToDataTable([<? echo $genero; ?>])
        var options = {
    				   title: 'Género',
 					   width:400,
                       height:300,
                       is3D:true               	   
                   	   //sliceVisibilityThreshold: 1/7200
                   	};
	    var chart = new google.visualization.PieChart(document.getElementById('chart_divGenero'));
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

		data = new google.visualization.arrayToDataTable([<? echo $cargoG; ?>])
        var options = {
    				   title: 'Otros Cargos por Genero',
 					   width:800,
                       height:400,
                       legend: { position: 'bottom', maxLines: 3 },
                       vAxis: {viewWindowMode: 'maximized' }
                   	};
	    var chart = new google.visualization.ColumnChart(document.getElementById('chart_divCargoG'));
        chart.draw(data, options);


		data = new google.visualization.arrayToDataTable([<? echo $lugarN; ?>])
        var options = {
    				   title: 'Lugar de Nacimiento',
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
		<div id="chart_divCargoG"></div>
				<div id="chart_divCargo"></div>
				<div id="chart_divGenero"></div>
				<div id="chart_divEdad"></div>
				<div id="chart_divEdadG"></div>
				<div id="chart_divLugarN"></div>
	</div>
</body>
</html>