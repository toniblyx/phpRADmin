<?php
require('../../../../conf/dialup_admin/conf/config.php3');
$selected[$search_IN] = 'selected';
$selected[$radius_attr] = 'selected';
$max = ($max_results) ? $max_results : 40;
?>
<html>
<head>
<title>Find User Page</title>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo $config[general_charset]?>">
<link rel="stylesheet" href="style.css">
</head>
<body link="black" alink="black">
<center>
 
<table border=0 width=400 cellpadding=0 cellspacing=2>
</table>
<br>
<table border=0 width=540 cellpadding=1 cellspacing=1>
<tr valign=top>
<td width=340></td>
<td bgcolor="888888" width=200>
	<table border=0 width=100% cellpadding=2 cellspacing=0>
	<tr bgcolor="#aaaaaa" align=right valign=top><th>
	<font color="white">Find User Page</font>&nbsp;
	</th></tr>
	</table>
</td></tr>
<tr bgcolor="888888" valign=top><td colspan=2>
	<table border=0 width=100% cellpadding=12 cellspacing=0 bgcolor="#e6e6e6" valign=top>
	<tr><td>

<?php
if ($find_user == 1){
	if (is_file("../lib/$config[general_lib_type]/find.php3"))
		include("../lib/$config[general_lib_type]/find.php3");
	if (isset($found_users)){
		$num = 0;
		$msg .= <<<EOM
<p>
        <table border=0 bordercolordark=#e6e6e6 bordercolorlight=#000000 width=100% cellpadding=2 cellspacing=0 bgcolor="#e6e6e6" valign=top>
        <tr bgcolor="#e6e6e6">
        <th>#</th><th>user</th>
        </tr>
EOM;
		foreach ($found_users as $user){
			if ($user == '')
				$user = '-';
			$num++;
			$msg .= <<<EOM
			<tr align=center>
			 	<td>$num</td>
				<td><a href="user_admin.php3?login=$user" title="Edit user $user">$user</a></td>
			</tr>
EOM;
		}
		$msg .= "</table>\n";
	}
	else
		$msg = "<b>No users found</b><br>\n";
}
?>
   <form method=post>
      <input type=hidden name=find_user value="0">
	<table border=0 bordercolordark=#e6e6e6 bordercolorlight=#000000 width=100% cellpadding=2 cellspacing=0 bgcolor="#e6e6e6" valign=top>
<tr>
<td align=right bgcolor="#e6e6e6">
Search Criteria
</td>
<td>

<?php
echo <<<EOM
<select name="search_IN" editable onChange="this.form.submit();">
<option $selected[name]  value="name">User Full Name
<option $selected[ou] value="ou">User Department
<option $selected[radius] value="radius">User Radius Attribute
EOM;
?>

</select>
</td>
</tr>
<?php
if ($search_IN == 'radius'){
	require('../lib/attrshow.php3');
	echo <<<EOM
<tr>
<td align=right bgcolor="#e6e6e6">
RADIUS Attribute
</td>
<td>
<select name="radius_attr" editable>
EOM;
	foreach($show_attrs as $key => $desc)
		echo "<option $selected[$key] value=\"$key\">$desc\n";		
	echo <<<EOM
</select>
</td>
</tr>
EOM;
}
?>
<tr>
<td align=right bgcolor="#e6e6e6">
Criteria Contains
</td>
<td>
<input type=text name="search" value="<?php echo $search ?>" size=25>
</td>
</tr>
<tr>
<td align=right bgcolor="#e6e6e6">
Max Results
</td>
<td>
<input type=text name="max_results" value="<?php echo $max ?>" size=25>
</td>
</tr>
	</table>
<br>
<input type=submit class=button value="Find User" OnClick="this.form.find_user.value=1">
</form>
<?php
if ($find_user == 1){
	echo <<<EOM
<br>
$msg
EOM;
}
?>
	</td></tr>
</table>
</tr>
</table>
</body>
</html>
