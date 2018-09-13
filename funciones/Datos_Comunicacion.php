<?
setcookie ("Sesion", $_COOKIE['Sesion'], time()+60*40);
$db_name = "cjf";
$connection = @mysql_connect("localhost","root","origendb") or die("Sin acceso a el servidor de BD");
$db = @mysql_select_db($db_name, $connection) or die("No se puede encontrar la BD");
/* 
Hay que utilizar esta, la comento dado que estaba con las dos
$mysqli = new mysqli("localhost", "root", "origendb", $db_name);
if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
	}
*/
@mysql_query("SET NAMES 'UTF8'", $connection);
?>