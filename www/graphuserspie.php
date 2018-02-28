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

include ("include/Artichow/class/jpgraph.php");
include ("include/Artichow/class/jpgraph_pie.php");
include ("include/Artichow/class/jpgraph_pie3d.php");
include_once ("class/Oreon.class.php");
include_once ("phpradmin.conf.php");

$oreon_db = new OreonDatabase($conf_pra["host"], $conf_pra["user"], $conf_pra["password"], $conf_pra["db"]);
$table = "userinfo";

//este si es valido
$total_users_in_db = $oreon_db ->getTotalRowsInTable($table);
//$total_users_in_db = 500;

//login users from DB (SELECT COUNT(*) FROM radacct¿?;)
$login_users = 2;
//logoff users total_users_in_db - login_users
$logoff_users = ($total_users_in_db - $login_users);
//percent
$percent_login = ($login_users * 100 / $total_users_in_db);
$percent_logoff = ( 100 - $percent_login );
$data = array($percent_login,$percent_logoff);
//$data = array(12,88);

$graph = new PieGraph(350,170,"auto");
$graph->SetShadow();
//$graph->title->Set( $lang['pra_total_users_in_db']":" $total_users_in_db);
$graph->title->Set("Total users in Data Base: $total_users_in_db");

$graph->title->SetFont(FF_FONT1,FS_BOLD);
$p1 = new PiePlot3D($data);
$p1->ExplodeSlice( 1);
$p1->SetLabelType( "PIE_VALUE_ABS");
$p1->SetSize(0.40);
$p1->SetCenter(0.33);
$p1->SetSliceColors(array('green','blue')); 
$p1->setLegends(array(
		"LogIN Users: $login_users",
        "LogOUT Users: $logoff_users",
));

$graph->Add($p1);
$graph->Stroke();

?>