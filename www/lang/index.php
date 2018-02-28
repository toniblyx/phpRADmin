<? 
/*
phpRADmin is developped under GPL Licence 2.0 :
http://www.gnu.org/licenses/gpl.txt or read LICENSE file.

Developed by : Toni de la Fuente (blyx) from Madrid and Alfacar (Granada), Spain  
For information : toni@blyx.com http://blyx.com

We are using Oreon for base code: http://www.oreon-project.org
We are using Dialup Admin for user management 
and many more things: http://www.freeradius.org
We are using PHPKI for Certificates management: http://phpki.sourceforge.org/ 

Thanks very much!!
*/
?>
<html>
<head>
<title> Traduction </title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>

<body>
<center><a href="./index.php?file=en.php"> EN </a> - <a href="./index.php?file=es.php"> FR </a></center>
<?

if (isset($_GET["file"])){
	include_once($_GET["file"]);
foreach ($lang as $key => $value )
	print $key . " : " . $value . "<br><br>";
}
?>
</body>
</html>
