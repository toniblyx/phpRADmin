<?
/*
phpRADmin is developped with GPL Licence 2.0 :
http://www.gnu.org/licenses/gpl.txt
Developped by : Toni de la Fuente (blyx)

For information : toni@blyx.com
*/if (isset($_POST["sd"]))
	$sd = & $_POST["sd"];
?>
<form action="" method="post">
<table border="0" cellpadding="3" cellspacing="3">
	<tr>
		<td valign="top" nowrap><? echo $lang['h']; ?><font color='red'>*</font></td>
		<td class="text10b" valign="top">
			<select name="sd[host_host_id]" onChange="this.form.submit();">
				<option value=""></option>
				<?
				foreach ($hosts as $host)	{
					if ($host->get_register())	{
						echo "<option value='".$host->get_id()."'";
						if (isset($_POST["sd"]) && ($host->get_id() == $sd["host_host_id"]))
							echo " selected";
						echo ">".$host->get_name()."</option>";
					}
					unset($host);
				}
				?>
			</select>
		</td>
	</tr>
	<tr>
		<td valign="top"><? echo $lang['s']; ?><font color='red'>*</font></td>
		<td class="text10b" valign="top">
			<select name="sd[service_service_id]">
				<option value=""></option>
				<?
				if (isset($sd["host_host_id"]) && isset($hosts[$sd["host_host_id"]]->services))
					foreach ($hosts[$sd["host_host_id"]]->services as $service)	{
						if ($service->get_register())	{
							echo "<option value='".$service->get_id()."'";
							if (isset($_POST["sd"]) && ($service->get_id() == $sd["service_service_id"]))
								echo " selected";
							echo ">".$service->get_description()."</option>";
						}
						unset($service);
					}
				?>
			</select>
		</td>
	</tr>
	<tr>
		<td valign="top" nowrap><? echo $lang['h']; ?> dependent<font color='red'>*</font></td>
		<td class="text10b" valign="top">
			<select name="sd[host_host_id2]" onChange="this.form.submit();">
				<option value=""></option>
				<?
				foreach ($hosts as $host)	{
					if ($host->get_register())	{
						echo "<option value='".$host->get_id()."'";
						if (isset($_POST["sd"]) && ($host->get_id() == $sd["host_host_id2"]))
							echo " selected";
						echo ">".$host->get_name()."</option>";
					}
					unset($host);
				}
				?>
			</select>
		</td>
	</tr>
	<tr>
		<td valign="top"><? echo $lang['s']; ?> dependent<font color='red'>*</font></td>
		<td class="text10b" valign="top">
			<select name="sd[service_service_id2]">
				<option value=""></option>
				<?
				if (isset($sd["host_host_id"]) && isset($hosts[$sd["host_host_id2"]]->services))
					foreach ($hosts[$sd["host_host_id2"]]->services as $service)	{
						if ($service->get_register())	{
							echo "<option value='".$service->get_id()."'";
							if (isset($_POST["sd"]) && ($service->get_id() == $sd["service_service_id2"]))
								echo " selected";
							echo ">".$service->get_description()."</option>";
						}
						unset($service);
					}
				?>
			</select>
		</td>
	</tr>
	<? if (!strcmp ($oreon->user->get_version(), 2)) { ?>
	<tr>
		<td valign="top" nowrap>Inherits parent</td>
		<td class="text10b" valign="top" nowrap>
			<input name="sd[sd_inherits_parent]" type="radio" value="1"> Yes -
			<input name="sd[sd_inherits_parent]" type="radio" value="0"> No -
			<input name="sd[sd_inherits_parent]" type="radio" value="2" checked> Nothing
		</td>
	</tr>
	<? } ?>
	<tr>
		<td valign="top" nowrap>Execution failure criteria</td>
		<td class="text10b" valign="top" nowrap>
			<input ONMOUSEOVER="montre_legende('OK', '');" ONMOUSEOUT="cache_legende();" name="sd[sd_execution_failure_criteria_o]" type="checkbox" value="o" id="sd_execution_failure_criteria_o"> o -
			<input ONMOUSEOVER="montre_legende('Warning', '');" ONMOUSEOUT="cache_legende();" name="sd[sd_execution_failure_criteria_w]" type="checkbox" value="w" id="sd_execution_failure_criteria_w"> w -
			<input ONMOUSEOVER="montre_legende('Unknown', '');" ONMOUSEOUT="cache_legende();" name="sd[sd_execution_failure_criteria_u]" type="checkbox" value="u" id="sd_execution_failure_criteria_u"> u -
			<input ONMOUSEOVER="montre_legende('Critical', '');" ONMOUSEOUT="cache_legende();" name="sd[sd_execution_failure_criteria_c]" type="checkbox" value="c" id="sd_execution_failure_criteria_c"> c -
			<input ONMOUSEOVER="montre_legende('None', '');" ONMOUSEOUT="cache_legende();" name="sd[sd_execution_failure_criteria_n]" type="checkbox" value="n" onClick="enabledOptionsCheck(sd_execution_failure_criteria_o);enabledOptionsCheck(sd_execution_failure_criteria_w);enabledOptionsCheck(sd_execution_failure_criteria_u);enabledOptionsCheck(sd_execution_failure_criteria_c);"> n
		</td>
	</tr>
	<tr>
		<td valign="top" nowrap>Notification failure criteria</td>
		<td class="text10b" valign="top" nowrap>
			<input ONMOUSEOVER="montre_legende('OK', '');" ONMOUSEOUT="cache_legende();" name="sd[sd_notification_failure_criteria_o]" type="checkbox" value="o" id="sd_notification_failure_criteria_o"> o -
			<input ONMOUSEOVER="montre_legende('Warning', '');" ONMOUSEOUT="cache_legende();" name="sd[sd_notification_failure_criteria_w]" type="checkbox" value="w" id="sd_notification_failure_criteria_w"> w -
			<input ONMOUSEOVER="montre_legende('Unknown', '');" ONMOUSEOUT="cache_legende();" name="sd[sd_notification_failure_criteria_u]" type="checkbox" value="u" id="sd_notification_failure_criteria_u"> u -
			<input ONMOUSEOVER="montre_legende('Critical', '');" ONMOUSEOUT="cache_legende();" name="sd[sd_notification_failure_criteria_c]" type="checkbox" value="c" id="sd_notification_failure_criteria_c"> c -
			<input ONMOUSEOVER="montre_legende('None', '');" ONMOUSEOUT="cache_legende();" name="sd[sd_notification_failure_criteria_n]" type="checkbox" value="n" onClick="enabledOptionsCheck(sd_notification_failure_criteria_c);enabledOptionsCheck(sd_notification_failure_criteria_u);enabledOptionsCheck(sd_notification_failure_criteria_w);enabledOptionsCheck(sd_notification_failure_criteria_o);"> n
		</td>
	</tr>
	<tr>
		<td align="left">
			<? echo $lang['required']; ?>&nbsp;&nbsp;
		</td>
		<td align="center">
			<input type="submit" name="AddSD" value="<? echo $lang['save']; ?>">
		</td>
	</tr>
</table>
</form>