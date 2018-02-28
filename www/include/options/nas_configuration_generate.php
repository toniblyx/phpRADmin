<?php

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

include_once ("class/Oreon.class.php");
include_once ("phpradmin.conf.php");

$oreon_db = new OreonDatabase($conf_pra["host"], $conf_pra["user"], $conf_pra["password"], $conf_pra["db"]);

$values = $oreon_db ->getnasconfiguration();


// Generate naslist.conf file

$naslist_file = $oreon->optGen->get_phpradmin_pwd() .'conf/dialup_admin/conf/naslist.conf';

// vaciamos el archivo
$vaciado ="";
if (!$handle = fopen($naslist_file, 'w+')) {
         	echo "Cannot open file ($naslist_file)";
         	exit;
   		}
if (fwrite($handle, $vaciado) === FALSE) {
       		echo "Cannot write to file ($naslist_file)";
       		exit;
   		}

	while ($row=mysql_fetch_array($values))
			{
	$content =	"nas".$row["id"]."_name: ". $row["nasname"]. "\n"
			  . "nas".$row["id"]."_model: ". $row["description"]. "\n"
			  . "nas".$row["id"]."_ip: ". $row["nasname"]. "\n"
			  . "nas".$row["id"]."_port_num: ". $row["ports"]. "\n"
			  . "nas".$row["id"]."_community: ". $row["community"]. "\n"
			//. "nas".$row["id"]."_finger_type: ". $row["database"]. "\n"
			  . "nas".$row["id"]."_type: ". $row["type"]. "\n\n";
		  
		// Let's make sure the file exists and is writable first.
		if (is_writable($naslist_file)) {
   		// w = write, a = append (I use w to generate entire document.)
   		if (!$handle = fopen($naslist_file, 'a+')) {
         	echo "Cannot open file ($naslist_file)";
         	exit;
   		}
   		// Write $content to our opened file.
   		if (fwrite($handle, $content) === FALSE) {
       		echo "Cannot write to file ($naslist_file)";
       		exit;
   		}
   		fclose($handle);
		} else {
		print "<br><font color='red'>" . "The file $naslist_file do not exist or is not writable" . "</font><br>";
		}
	  }
	print "<font color='green'>" . "Success, configuration has been saved to file ($naslist_file)" . "</font><br>";

// Generate clients.conf file
$values = $oreon_db ->getnasconfiguration();


// vaciamos el archivo

$clients_file = $oreon->optGen->get_radius_pwd() .'clients.conf';
$vaciado ="";

if (!$handle = fopen($clients_file, 'w+')) {
         	echo "Cannot open file ($clients_file)";
         	exit;
   		}
if (fwrite($handle, $vaciado) === FALSE) {
       		echo "Cannot write to file ($clients_file)";
       		exit;
   		}
	while ($row=mysql_fetch_array($values))
			{
	$content =	"client ". $row["nasname"]. " {\n"
		  	  . "\tsecret = ". $row["secret"]. "\n"
		  	  . "\tshortname = ". $row["shortname"]. "\n"
			  . "\tnastype = ". $row["type"]. "\n"
			  . "}\n\n";
	
	// Let's make sure the file exists and is writable first.
	if (is_writable($clients_file)) {
    // w = write, a = append (I use w to generate entire document.)
    if (!$handle = fopen($clients_file, 'a+')) {
         echo "Cannot open file ($clients_file)";
         exit;
 	}
   	// Write $content to our opened file.
   	if (fwrite($handle, $content) === FALSE) {
       echo "Cannot write to file ($clients_file)";
       exit;
   	}
   	fclose($handle);
	} else {
	print "<br><font color='red'>" . "The file $clients_file do not exist or is not writable" . "</font><br>";
	}
}
	print "<font color='green'>" . "Success, configuration has been saved to file ($clients_file)" . "</font><br>";

?> 