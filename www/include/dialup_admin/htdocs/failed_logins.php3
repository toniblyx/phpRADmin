<?php
require('../../../../conf/dialup_admin/conf/config.php3');
require('../lib/attrshow.php3');
?>
<html>
<?php

if (is_file("../lib/sql/drivers/$config[sql_type]/functions.php3"))
	include_once("../lib/sql/drivers/$config[sql_type]/functions.php3");
else{
	echo <<<EOM
<title>Failed logins</title>
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

$now = time();
if ($last == 0)
	$last = ($config[general_most_recent_fl]) ? $config[general_most_recent_fl] : 5;
$start = $now - ($last*60);
$now_str = date($config[sql_full_date_format],$now);
$prev_str = date($config[sql_full_date_format],$start);

$now_str = da_sql_escape_string($now_str);
$prev_str = da_sql_escape_string($prev_str);

$pagesize = ($pagesize) ? $pagesize : 10;
if (!is_numeric($pagesize) && $pagesize != 'all')
	$pagesize = 10;
$limit = ($pagesize == 'all') ? '' : "LIMIT $pagesize";
$selected[$pagesize] = 'selected';
$order = ($order != '') ? $order : $config[general_accounting_info_order];
if ($order != 'desc' && $order != 'asc')
	$order = 'desc';
$selected[$order] = 'selected';
if ($callerid != ''){
	$callerid = da_sql_escape_string($callerid);
	$callerid_str = "AND callingstationid = '$callerid'";
}
if ($server != '' && $server != 'all'){
	$server = da_sql_escape_string($server);
	$server_str = "AND nasipaddress = '$server'";
}

?>

<head>
<title>Failed Logins</title>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo $config[general_charset]?>">
<link rel="stylesheet" href="style.css">
</head>
<body link="black" alink="black">
<center>
 
<table border=0 width=400 cellpadding=0 cellspacing=2>
</table>
<br>
<table border=0 width=840 cellpadding=1 cellspacing=1>
<tr valign=top>
<td width=65%></td>
<td bgcolor="888888" width=35%>
	<table border=0 width=100% cellpadding=2 cellspacing=0>
	<tr bgcolor="#aaaaaa" align=right valign=top><th>
	<font color="white">Failed Logins</font>&nbsp;
	</th></tr>
	</table>
</td></tr>
<tr bgcolor="888888" valign=top><td colspan=2>
	<table border=0 width=100% cellpadding=12 cellspacing=0 bgcolor="#e6e6e6" valign=top>
	<tr><td>
<?php
echo <<<EOM
<b>$prev_str</b> up to <b>$now_str</b>
EOM;
?>

<p>
	<table border=0 bordercolordark=#e6e6e6 bordercolorlight=#000000 width=100% cellpadding=2 cellspacing=0 bgcolor="#e6e6e6" valign=top>
	<tr bgcolor="#e6e6e6">
	<th>#</th><th>login</th>
<?php
if ($acct_attrs['fl'][2] != '') echo "<th>" . $acct_attrs['fl'][2] . "</th>\n";
if ($acct_attrs['fl'][7] != '') echo "<th>" . $acct_attrs['fl'][7] . "</th>\n";
if ($acct_attrs['fl'][8] != '') echo "<th>" . $acct_attrs['fl'][8] . "</th>\n";
if ($acct_attrs['fl'][9] != '') echo "<th>" . $acct_attrs['fl'][9] . "</th>\n";
$sql_extra_query = '';
if ($config[sql_accounting_extra_query] != '')
	$sql_extra_query = sql_xlat($config[sql_accounting_extra_query],$login,$config);
?>
	</tr>

<?php
$link = @da_sql_pconnect($config);
if ($link){
	$search = @da_sql_query($link,$config,
	"SELECT acctstoptime,username,nasipaddress,nasportid,acctterminatecause,callingstationid
	FROM $config[sql_accounting_table]
	WHERE acctstoptime <= '$now_str' AND acctstoptime >= '$prev_str'
	AND (acctterminatecause LIKE 'Login-Incorrect%' OR
	acctterminatecause LIKE 'Invalid-User%' OR
	acctterminatecause LIKE 'Multiple-Logins%') $callerid_str $server_str $sql_extra_query
	ORDER BY acctstoptime $order $limit;");
	if ($search){
		while( $row = @da_sql_fetch_array($search,$config) ){
			$num++;
			$acct_login = $row[username];
			if ($acct_login == '')
				$acct_login = '-';
			else
				$acct_login = "<a href=\"user_admin.php3?login=$acct_login\" title=\"Edit user $acct_login\">$acct_login</a>";
			$acct_time = $row[acctstoptime];
			$acct_server = $row[nasipaddress];
			if ($acct_server != ''){
				$acct_server = $da_name_cache[$acct_server];
				if (!isset($acct_server)){
					$acct_server = $row[nasipaddress];
					$acct_server = @gethostbyaddr($acct_server);
					if (!isset($da_name_cache) && $config[general_use_session] == 'yes'){
						$da_name_cache[$row[nasipaddress]] = $acct_server;
						session_register('da_name_cache');
					}
					else
						$da_name_cache[$row[nasipaddress]] = $acct_server;
				}
			}
			else
				$acct_server = '-';
			$acct_server = "$acct_server:$row[nasportid]";
			$acct_terminate_cause = "$row[acctterminatecause]";
			if ($acct_terminate_cause == '')
				$acct_terminate_cause = '-';
			$acct_callerid = "$row[callingstationid]";
			if ($acct_callerid == '')
				$acct_callerid = '-';
			echo <<<EOM
			<tr align=center bgcolor="white">
				<td>$num</td>
				<td>$acct_login</td>
EOM;
				if ($acct_attrs['fl'][2] != '') echo "<td>$acct_time</td>\n";
				if ($acct_attrs['fl'][2] != '') echo "<td>$acct_server</td>\n";
				if ($acct_attrs['fl'][2] != '') echo "<td>$acct_terminate_cause</td>\n";
				if ($acct_attrs['fl'][2] != '') echo "<td>$acct_callerid</td>\n";
				echo "</tr>\n";
		}
	}
	else
		echo "<b>Database query failed: " . da_sql_error($link,$config) . "</b><br>\n";
}
else
	echo "<b>Could not connect to SQL database</b><br>\n";
echo <<<EOM
	</table>
<tr><td>
<hr>
<tr><td align="left">
	<form action="failed_logins.php3" method="get" name="master">
	<table border=0>
		<tr valign="bottom">
			<td><small><b>time back (mins)</td><td><small><b>pagesize</td><td><small><b>caller id</td><td><b>order</td>
	<tr valign="middle"><td>
<input type="text" name="last" size="11" value="$last"></td>
<td><select name="pagesize">
<option $selected[5] value="5" >05
<option $selected[10] value="10">10
<option $selected[15] value="15">15
<option $selected[20] value="20">20
<option $selected[40] value="40">40
<option $selected[80] value="80">80
<option $selected[all] value="all">all
</select>
</td>
<td>
<input type="text" name="callerid" size="11" value="$callerid"></td>
<td><select name="order">
<option $selected[asc] value="asc">older first
<option $selected[desc] value="desc">recent first
</select>
</td>
EOM;
?>

<td><input type="submit" class=button value="show"></td></tr>
<tr><td>
<b>On Access Server:</b>
</td></tr><tr><td>
<select name="server">
<?php
foreach ($nas_list as $nas){
	$name = $nas[name];
	$servers[$name] = $nas[ip];
}
ksort($servers);
foreach ($servers as $name => $ip){
	if ($server == $ip)
		echo "<option selected value=\"$ip\">$name\n";
	else
		echo "<option value=\"$ip\">$name\n";
}
if ($server == '' || $server == 'all')
	echo "<option selected value=\"all\">all\n";
else
	echo "<option value=\"all\">all\n";
?>
</select>
</td></tr>
</table></td></tr></form>
</table>
</tr>
</table>
</body>
</html>
