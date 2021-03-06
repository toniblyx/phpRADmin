<?php
require('../../../../conf/dialup_admin/conf/config.php3');
require('../lib/functions.php3');
?>
<html>
<?php

if (is_file("../lib/sql/drivers/$config[sql_type]/functions.php3"))
	include_once("../lib/sql/drivers/$config[sql_type]/functions.php3");
else{
	echo <<<EOM
<title>User Statistics</title>
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

if ($start == '' && $stop == ''){
	$now = time();
	$stop = date($config[sql_date_format],$now);
	$now -= 604800;
	$start = date($config[sql_date_format],$now);
}
$start = da_sql_escape_string($start);
$stop = da_sql_escape_string($stop);
$pagesize = ($pagesize) ? $pagesize : 10;
if (!is_numeric($pagesize) && $pagesize != 'all')
	$pagesize = 10;
$limit = ($pagesize == 'all') ? '' : "LIMIT $pagesize";
$selected[$pagesize] = 'selected';
$order = ($order) ? $order : $config[general_accounting_info_order];
if ($order != 'desc' && $order != 'asc')
	$order = 'desc';
if ($sortby != '')
	$order_attr = ($sortby == 'num') ? 'connnum' : 'conntotduration';
else
	$order_attr = 'connnum';
if ($server != '' && $server != 'all'){
	$server = da_sql_escape_string($server);
	$server_str = "AND nasipaddress = '$server'";
}
$login_str = ($login) ? "AND username = '$login' " : '';

$selected[$order] = 'selected';
$selected[$sortby] = 'selected';

$sql_extra_query = '';
if ($config[sql_accounting_extra_query] != '')
	$sql_extra_query = sql_xlat($config[sql_accounting_extra_query],$login,$config);

?>

<head>
<title>User Statistics</title>
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
	<font color="white">User Statistics</font>&nbsp;
	</th></tr>
	</table>
</td></tr>
<tr bgcolor="888888" valign=top><td colspan=2>
	<table border=0 width=100% cellpadding=12 cellspacing=0 bgcolor="#e6e6e6" valign=top>
	<tr><td>
<?php
echo <<<EOM
<b>$start</b> up to <b>$stop</b>
EOM;
?>

<p>
	<table border=0 bordercolordark=#e6e6e6 bordercolorlight=#000000 width=100% cellpadding=2 cellspacing=0 bgcolor="#e6e6e6" valign=top>
	<tr bgcolor="#e6e6e6">
	<th>#</th><th>login</th><th>date</th><th>server</th><th>connections number</th><th>connections duration</th><th>upload</th><th>download</th>
	</tr>

<?php
$link = @da_sql_pconnect($config);
if ($link){
	$search = @da_sql_query($link,$config,
	"SELECT * FROM $config[sql_total_accounting_table]
	WHERE acctdate >= '$start' AND acctdate <= '$stop' $server_str $login_str $sql_extra_query
	ORDER BY $order_attr $order $limit;");

	if ($search){
		while( $row = @da_sql_fetch_array($search,$config) ){
			$num++;
			$acct_login = $row[username];
			if ($acct_login == '')
				$acct_login = '-';
			else
				$acct_login = "<a href=\"user_admin.php3?login=$acct_login\" title=\"Edit user $acct_login\">$acct_login</a>";
			$acct_time = $row[conntotduration];
			$acct_time = time2str($acct_time);
			$acct_conn_num = $row[connnum];
			$acct_date = $row[acctdate];
			$acct_upload = $row[inputoctets];
			$acct_download = $row[outputoctets];
			$acct_upload = bytes2str($acct_upload);
			$acct_download = bytes2str($acct_download);
			$acct_server = $da_name_cache[$row[nasipaddress]];
			if (!isset($acct_server)){
				$acct_server = @gethostbyaddr($row[nasipaddress]);
				if (!isset($da_name_cache) && $config[general_use_session] == 'yes'){
					$da_name_cache[$row[nasipaddress]] = $acct_server;
					session_register('da_name_cache');
				}
				else
					$da_name_cache[$row[nasipaddress]] = $acct_server;
			}
			if ($acct_server == '')
				$acct_server = '-';
			echo <<<EOM
			<tr align=center bgcolor="white">
				<td>$num</td>
				<td>$acct_login</td>
				<td>$acct_date</td>
				<td>$acct_server</td>
				<td>$acct_conn_num</td>
				<td>$acct_time</td>
				<td>$acct_upload</td>
				<td>$acct_download</td>
			</tr>
EOM;
		}
	}
}
echo <<<EOM
	</table>
<tr><td>
<hr>
<tr><td align="left">
	<form action="user_stats.php3" method="post" name="master">
	<table border=0>
		<tr valign="bottom">
			<td><small><b>start time</td><td><small><b>stop time</td><td><small><b>pagesize</td><td><b>sort by</td><td><b>order</td>
	<tr valign="middle"><td>
<input type="hidden" name="show" value="0">
<input type="text" name="start" size="11" value="$start"></td>
<td><input type="text" name="stop" size="11" value="$stop"></td>
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
<select name="sortby">
<option $selected[num] value="num">connections number
<option $selected[time] value="time">connections duration
</select>
</td>
<td><select name="order">
<option $selected[asc] value="asc">ascending
<option $selected[desc] value="desc">descending
</select>
</td>
EOM;
?>

<td><input type="submit" class=button value="show"></td></tr>
<tr><td>
<b>On Access Server:</b>
</td>
<td><b>User</b></td></tr>
<tr><td>
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
</td>
<td><input type="text" name="login" size="11" value="<?php echo $login ?>"></td>
</tr>
</table></td></tr></form>
</table>
</tr>
</table>
</body>
</html>
