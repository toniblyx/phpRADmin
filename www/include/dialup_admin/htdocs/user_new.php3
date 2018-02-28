<?php
require('../../../../conf/dialup_admin/conf/config.php3');
if ($show == 1){
	header("Location: user_admin.php3?login=$login");
	exit;
}
require('../lib/attrshow.php3');
require('../lib/defaults.php3');

if ($config[general_lib_type] == 'sql' && $config[sql_use_operators] == 'true'){
	$colspan=2;
	$show_ops=1;
}else{
	$show_ops = 0;
	$colspan=1;
}

?>

<html>
<head>
<title>New user creation page</title>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo $config[general_charset]?>">
<link rel="stylesheet" href="style.css">
</head>
<body link="black" alink="black">

<?php
include("password_generator.jsc");
?>

<center>
<table border=0 width=540 cellpadding=1 cellspacing=1>
<tr valign=top>
<td width=340></td>
<td bgcolor="888888" width=200>
	<table border=0 width=100% cellpadding=2 cellspacing=0>
	<tr bgcolor="#aaaaaa" align=right valign=top><th>
	<font color="white">User Preferences for new user</font>&nbsp;
	</th></tr>
	</table>
</td></tr>
<tr bgcolor="888888" valign=top><td colspan=2>
	<table border=0 width=100% cellpadding=12 cellspacing=0 bgcolor="#e6e6e6" valign=top>
	<tr><td>
   
<?php
if ($create == 1){
	if (is_file("../lib/$config[general_lib_type]/user_info.php3"))
		include("../lib/$config[general_lib_type]/user_info.php3");
	if ($user_exists != "no"){
		echo <<<EOM
<b>The username <i>$login</i> already exists in the user database</b>
EOM;
	}
	else{
		if (is_file("../lib/$config[general_lib_type]/create_user.php3"))
			include("../lib/$config[general_lib_type]/create_user.php3");
		require("../lib/defaults.php3");
		if (is_file("../lib/$config[general_lib_type]/user_info.php3"))
			include("../lib/$config[general_lib_type]/user_info.php3");
	}
}
?>
   <form method=post>
      <input type=hidden name=create value="0">
      <input type=hidden name=show value="0">
	<table border=0 bordercolordark=#e6e6e6 bordercolorlight=#000000 width=100% cellpadding=2 cellspacing=0 bgcolor="#e6e6e6" valign=top>
<?php
	echo <<<EOM
	<tr>
		<td align=right colspan=$colspan bgcolor="#e6e6e6">
		Username
		</td><td>
		<input type=text name="login" value="$login" size=35>
		</td>
	</tr>
	<tr>
		<td align=right colspan=$colspan bgcolor="#e6e6e6">
		Password
		</td><td>
		<input type=text name="passwd" size=15>
		<input type="button" class=button value="Auto/Password" OnClick="generatepassword(this.form.passwd,8);">
		</td>
	</tr>
EOM;
	if ($config[general_lib_type] == 'sql'){
		if (isset($member_groups))
			$selected[$member_groups[0]] = 'selected';
		echo <<<EOM
	<tr>
		<td align=right colspan=$colspan bgcolor="#e6e6e6">
		Group
		</td><td>
		<select name="Fgroup">
EOM;
		foreach ($member_groups as $group)
			echo "<option value=\"$group\" $selected[$group]>$group\n";

		echo <<<EOM
		</select>
		</td>
	</tr>
EOM;
	}
	if ($config[general_lib_type] == 'ldap' ||
	($config[general_lib_type] == 'sql' && $config[sql_use_user_info_table] == 'true')){
		echo <<<EOM
	<tr>
		<td align=right colspan=$colspan bgcolor="#e6e6e6">
		Name (First Name Surname)
		</td><td>
		<input type=text name="Fcn" value="$cn" size=35>
		</td>
	</tr>
	<tr>
		<td align=right colspan=$colspan bgcolor="#e6e6e6">
		Mail
		</td><td>
		<input type=text name="Fmail" value="$mail" size=35>
		</td>
	</tr>
	<tr>
		<td align=right colspan=$colspan bgcolor="#e6e6e6">
		Department
		</td><td>
		<input type=text name="Fou" value="$ou" size=35>
		</td>
	</tr>
	<tr>
		<td align=right colspan=$colspan bgcolor="#e6e6e6">
		Home Phone
		</td><td>
		<input type=text name="Fhomephone" value="$homephone" size=35>
		</td>
	</tr>
	<tr>
		<td align=right colspan=$colspan bgcolor="#e6e6e6">
		Work Phone
		</td><td>
		<input type=text name="Ftelephonenumber" value="$telephonenumber" size=35>
		</td>
	</tr>
	<tr>
		<td align=right colspan=$colspan bgcolor="#e6e6e6">
		Mobile Phone
		</td><td>
		<input type=text name="Fmobile" value="$mobile" size=35>
		</td>
	</tr>
EOM;
	}
	foreach($show_attrs as $key => $desc){
		$name = $attrmap["$key"];
		if ($name == 'none')
			continue;
		$oper_name = $name . '_op';
		$val = ($item_vals["$key"][0] != "") ? $item_vals["$key"][0] : $default_vals["$key"][0];
		print <<<EOM
<tr>
<td align=right bgcolor="#e6e6e6">
$desc
</td>
EOM;

		if ($show_ops)
			print <<<EOM
<td>
<select name=$oper_name>
<option selected value="=">=
<option value=":=">:=
<option value="+=">+=
<option value="==">==
<option value="!=">!=
<option value=">">&gt;
<option value=">=">&gt;=
<option value="<">&lt;
<option value="<=">&lt;=
<option value="=~">=~
<option value="!~">!~

</select>
</td>
EOM;

		print <<<EOM
<td>
<input type=text name="$name" value="$val" size=35>
</td>
</tr>
EOM;
	}
?>
	</table>
    <div align="center"><a href="help/operators_help.html" target=operators_help onclick=window.open("help/operators_help.html","operators_help","width=600,height=600,toolbar=no,scrollbars=yes,resizable=yes") title="Operators Help Page"><font color="blue">Operators Help </font></a>
    </div>
    <p><br>
        <input type=submit class=button value="Create" OnClick="this.form.create.value=1"> 
      <input type=submit class=button value="Show User" OnClick="this.form.show.value=1">&nbsp;    </p>
    </form>

	</td></tr>
</table>
</tr>
</table>
</body>
</html>
