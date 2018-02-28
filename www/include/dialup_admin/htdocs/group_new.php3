<?php
require('../../../../conf/dialup_admin/conf/config.php3');
if ($show == 1){
	header("Location: group_admin.php3?login=$login");
	exit;
}

if ($config[general_lib_type] != 'sql'){
	echo <<<EOM
<title>New group creation page</title>
<meta http-equiv="Content-Type" content="text/html; charset=$config[general_charset]">
<link rel="stylesheet" href="style.css">
</head>
<body link="black" alink="black">
<center>
<b>This page is only available if you are using sql as general library type</b>
</body>
</html>
EOM;
        exit();
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
<title>New group creation page</title>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo $config[general_charset]?>">
<link rel="stylesheet" href="style.css">
</head>
<body link="black" alink="black">
<center>
 

<br>
<table border=0 width=540 cellpadding=1 cellspacing=1>
<tr valign=top>
<td width=340></td>
<td bgcolor="888888" width=200>
	<table border=0 width=100% cellpadding=2 cellspacing=0>
	<tr bgcolor="#aaaaaa" align=right valign=top><th>
	<font color="white">Preferences for new group</font>&nbsp;
	</th></tr>
	</table>
</td></tr>
<tr bgcolor="888888" valign=top><td colspan=2>
	<table border=0 width=100% cellpadding=12 cellspacing=0 bgcolor="#e6e6e6" valign=top>
	<tr><td>
   
<?php
if (is_file("../lib/$config[general_lib_type]/group_info.php3"))
	include("../lib/$config[general_lib_type]/group_info.php3");
if ($create == 1){
	if ($group_exists != "no"){
		echo <<<EOM
<b>The group <i>$login</i> already exists in the group database</b>
EOM;
	}
	else{
		if (is_file("../lib/$config[general_lib_type]/create_group.php3"))
			include("../lib/$config[general_lib_type]/create_group.php3");
		if (is_file("../lib/$config[general_lib_type]/group_info.php3"))
			include("../lib/$config[general_lib_type]/group_info.php3");
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
		Group name
		</td><td>
		<input type=text name="login" value="$login" size=35>
		</td>
	</tr>
	<tr>
		<td align=right colspan=$colspan bgcolor="#e6e6e6">
		First member(s)<br>Separate group members<br> by whitespace or newline
		</td><td>
		<textarea name=members cols="15" wrap="PHYSICAL" rows=5></textarea>
		</td>
	</tr>
		
EOM;
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
<br>
<input type=submit class=button value="Create" OnClick="this.form.create.value=1">
<br><br>
<input type=submit class=button value="Show Group" OnClick="this.form.show.value=1">
</form>
	</td></tr>
</table>
</tr>
</table>
</body>
</html>
