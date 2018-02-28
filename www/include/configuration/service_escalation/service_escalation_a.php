<?
/*
phpRADmin is developped with GPL Licence 2.0 :
http://www.gnu.org/licenses/gpl.txt
Developped by : Toni de la Fuente (blyx)

For information : toni@blyx.com
*/if (isset($_POST["se"]))
	$se = & $_POST["se"];
?>

<form action="" method="post">
<table border="0" cellpadding="3" cellspacing="3">
	<tr>
		<td valign="top"><? echo $lang['h']; ?><font color='red'>*</font></td>
		<td class="text10b" valign="top">
			<select name="se[host_host_id]" onChange="this.form.submit();">
				<option value=""></option>
				<?
				foreach ($hosts as $host)	{
					if ($host->get_register())	{
						echo "<option value='".$host->get_id()."'";
						if (isset($_POST["se"]) && ($host->get_id() == $se["host_host_id"]))
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
			<select name="se[service_service_id]" <? if (!isset($_POST["se"])) echo " disabled"; ?>>
				<?
				if (isset($se["host_host_id"]) && isset($hosts[$se["host_host_id"]]->services))
					foreach ($hosts[$se["host_host_id"]]->services as $service)	{
						if ($service->get_register())
							echo "<option value='".$service->get_id()."'>".$service->get_description()."</option>";
						unset($service);
					}
				?>
			</select>
		</td>
	</tr>
	<tr>
		<td colspan="2">
			<div align="center" class="text10b">
				Contact Groups <font color='red'>*</font>
			</div>
			<table border="0" align="center">
				<tr>
					<td align="left" style="padding: 3px;">
						<select name="selectContactGroupBase" size="8" <? if (!isset($_POST["se"])) echo " disabled"; ?> multiple>
						<?
							if (isset($contactGroups))
								foreach ($contactGroups as $contactGroup)	{
									echo "<option value='".$contactGroup->get_id()."'>".$contactGroup->get_name()."</option>";
									unset($contactGroup);
								}
						?>
						</select>
					</td>
					<td style="padding-left: 5px; padding-right: 5px;" valign="middle" align="center">
						<input type="button" name="add" value="<? echo $lang['add']; ?>" onClick="Moove(this.form.selectContactGroupBase,this.form.selectContactGroup)" <? if (!isset($_POST["se"])) echo " disabled"; ?>><br><br><br>
						<input type="button" name="remove" value="<? echo $lang['delete']; ?>" onClick="Moove(this.form.selectContactGroup,this.form.selectContactGroupBase)" <? if (!isset($_POST["se"])) echo " disabled"; ?>>
					</td>
					<td>
						<select id="selectContactGroup" name="selectContactGroup[]" size="8" multiple <? if (!isset($_POST["se"])) echo " disabled"; ?>>
						</select>
					</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td valign="top" nowrap>First notification<font color='red'>*</font></td>
		<td class="text10b" valign="top"><input size="5" type="text" name="se[se_first_notification]" value="" <? if (!isset($_POST["se"])) echo " disabled"; ?>></td>
	</tr>
	<tr>
		<td valign="top" nowrap>Last notification<font color='red'>*</font></td>
		<td class="text10b" valign="top"><input size="5" type="text" name="se[se_last_notification]" value="" <? if (!isset($_POST["se"])) echo " disabled"; ?>></td>
	</tr>
	<tr>
		<td valign="top" nowrap>Notification interval<font color='red'>*</font></td>
		<td class="text10b" valign="top"><input size="5" type="text" name="se[se_notification_interval]" value="" <? if (!isset($_POST["se"])) echo " disabled"; ?>> <? echo " * ".$oreon->Nagioscfg->get_interval_length()." ".$lang["time_sec"]; ?></td>
	</tr>
	<? if (!strcmp ($oreon->user->get_version(), 2)) { ?>
	<tr>
		<td class="text10">escalation_period</td>
		<td align="left" style="padding: 3px;">
			<select name="se[timeperiod_tp_id]" <? if (!isset($_POST["se"])) echo " disabled"; ?>>
				<option value=""></option>
			<?
				if (isset($timeperiods))
					foreach ($timeperiods as $timeperiod)	{
						echo "<option value='".$timeperiod->get_id()."'>".$timeperiod->get_name()."</option>";
						unset($timeperiod);
					}
			?>
			</select>
		</td>
	</tr>
	<tr>
		<td class="text10">escalation_options</td>
		<td align="left" style="padding: 3px;" nowrap>
			<input ONMOUSEOVER="montre_legende('Warning', '');" ONMOUSEOUT="cache_legende();" name="se[se_escalation_options_w]" type="checkbox" value="w" <? if (!isset($_POST["se"])) echo " disabled"; ?>> w -
			<input ONMOUSEOVER="montre_legende('Unknown', '');" ONMOUSEOUT="cache_legende();" name="se[se_escalation_options_u]" type="checkbox" value="u" <? if (!isset($_POST["se"])) echo " disabled"; ?>> u -
			<input ONMOUSEOVER="montre_legende('Critical', '');" ONMOUSEOUT="cache_legende();" name="se[se_escalation_options_c]" type="checkbox" value="c" <? if (!isset($_POST["se"])) echo " disabled"; ?>> c -
			<input ONMOUSEOVER="montre_legende('OK/Recovery', '');" ONMOUSEOUT="cache_legende();" name="se[se_escalation_options_r]" type="checkbox" value="r" <? if (!isset($_POST["se"])) echo " disabled"; ?>> r
		</td>
	</tr><? } ?>
	<tr>
		<td align="left">
			<? echo $lang['required']; ?>&nbsp;&nbsp;
		</td>
		<td align="center">
			<input type="submit" name="AddSE" value="<? echo $lang['save']; ?>" onClick="selectAll(this.form.selectContactGroup);" <? if (!isset($_POST["se"])) echo " disabled"; ?>>
		</td>
	</tr>
</table>
</form>