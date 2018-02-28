<?php
echo <<<EOM
	<tr><td align=center bgcolor="#e6e6e6">
	Server
	</td><td>	
	<b>$lastlog_server_name</b> ($lastlog_server_ip)
	</td></tr>
	<tr><td align=center bgcolor="#e6e6e6">
	Server Port
	</td><td>
	$lastlog_server_port
	</td></tr>
	<tr><td align=center bgcolor="#e6e6e6">
	Workstation
	</td><td>
	$lastlog_callerid
	</td></tr>
	<tr><td align=center bgcolor="#e6e6e6">
	Upload
	</td><td>
	$lastlog_input
	</td></tr>
	<tr><td align=center bgcolor="#e6e6e6">
	Download
	</td><td>
	$lastlog_output
	</td></tr>
EOM;
?>
