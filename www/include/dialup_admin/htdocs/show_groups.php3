<?php
require('../../../../conf/dialup_admin/conf/config.php3');
?>
<html>
<?php

if (is_file("../lib/sql/drivers/$config[sql_type]/functions.php3"))
	include_once("../lib/sql/drivers/$config[sql_type]/functions.php3");
else{
	echo <<<EOM
<title>User Groups</title>
<meta http-equiv="Content-Type" content="text/html; charset=$config[general_charset]">
<link rel="stylesheet" href="style.css">
</head>
<body link="black" alink="black">
<center>
<b>Could not include SQL library functions. Aborting</b>
</body>
</html>
EOM;
	exit();
}
?>
<head>
<title>User Groups</title>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo $config[general_charset]?>">
<link rel="stylesheet" href="style.css">
</head>
<body link="black" alink="black">
<center>
 

<br><br>
<table border=0 width=540 cellpadding=1 cellspacing=1>
<tr valign=top>
<td width=55%></td>
<td bgcolor="888888" width=45%>
	<table border=0 width=100% cellpadding=2 cellspacing=0>
	<tr bgcolor="#aaaaaa" align=right valign=top><th>
	<font color="white">User Groups</font>&nbsp;
	</th></tr>
	</table>
</td></tr>
<tr bgcolor="888888" valign=top><td colspan=2>
	<table border=0 width=100% cellpadding=12 cellspacing=0 bgcolor="#e6e6e6" valign=top>
	<tr><td>
<p>
	<table border=0 bordercolordark=#e6e6e6 bordercolorlight=#000000 width=100% cellpadding=2 cellspacing=0 bgcolor="#e6e6e6" valign=top>
	<tr bgcolor="#e6e6e6">
	<th>#</th><th>group</th><th># of members</th>
	</tr>

<?php
$link = @da_sql_pconnect($config);
if ($link){
	$search = @da_sql_query($link,$config,
	"SELECT COUNT(*) as counter,groupname,MAX(username) AS usersample FROM $config[sql_usergroup_table] GROUP BY groupname;");
	if ($search){
		if (@da_sql_num_rows($search,$config)){
			while( $row = @da_sql_fetch_array($search,$config) ){
				$num++;
				$group = $row[groupname];
				$num_members = $row[counter];
				if ($row[usersample] == "") $num_members--;
				echo <<<EOM
		<tr align=center>
			<td>$num</td>
			<td><a href="group_admin.php3?login=$group" title="Edit group $group">$group</a></td>
			<td>$num_members</td>
		</tr>
EOM;
			}
		}
		else
			echo "<b>Could not find any groups</b><br>\n";
	}
	else
		echo "<b>Database query failed: " . da_sql_error($link,$config) . "</b><br>\n";
}
else
	echo "<b>Could not connect to SQL database</b><br>\n";
?>
	</table>
</table>
</tr>
</table>
</body>
</html>
