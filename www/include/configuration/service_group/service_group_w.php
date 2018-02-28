<?
/*
phpRADmin is developped with GPL Licence 2.0 :
http://www.gnu.org/licenses/gpl.txt
Developped by : Toni de la Fuente (blyx)

For information : toni@blyx.com
*/?>
<table  cellpadding="0" cellspacing="3" width="350" align='center'>
<tr>
	<td style="white-space: nowrap;" width="50%">Name :</td>
	<td class="text10b"><? echo $serviceGroups[$sg]->get_name(); ?></td>
</tr>
<tr>
	<td style="white-space: nowrap;">Alias :</td>
	<td class="text10b"><? echo $serviceGroups[$sg]->get_alias(); ?></td>
</tr>
<tr>
	<td colspan="2" class="text10b" align="center" style="padding-top: 15px;">Service(s)</td>
</tr>
<tr>
	<td colspan="2" class="text10b" align="left" style="white-space: nowrap;">
	<?
	if (isset($serviceGroups[$sg]->services))	{
		foreach ($serviceGroups[$sg]->services as $service)	{
			if ($service->get_register())	{
				echo "<li><a href='phpradmin.php?p=104&sv=" .$service->get_id(). "&o=w' class='text10' style='white-space: nowrap;";
				if (!$service->get_activate()) echo " text-decoration: line-through;'";
				echo "'>".$hosts[$service->get_host()]->get_name()." / ". $service->get_description()."</a></li>";
			}
			else
				echo "";// "<li><a href='phpradmin.php?p=125&stm_id=" .$service->get_id(). "&o=w' class='text10' style='white-space: nowrap;'>".$service->get_description()."</a></li>";
			unset($service);
		}
	}
	?>
	<br>
	</td>
</tr>
<tr>
	<td><? echo $lang['status']; ?> :</td>
	<td class="text10b">
	<?
	if ($serviceGroups[$sg]->get_activate())
		echo $lang['enable'];
	else
		echo $lang['disable'];
	?>
	</td>
<tr>
	<td valign="top" style="white-space: nowrap;">Comment :</td>
	<td class="text10b"><? echo "<textarea cols='20' rows='4' disabled>".$serviceGroups[$sg]->get_comment()."</textarea>";	?></td>
</tr>
<tr>
	<td align="center" colspan="2" height="35">
		<a href="phpradmin.php?p=105&o=c&sg=<? echo $sg ?>" class="text10bc"><? echo $lang['modify']; ?></a>&nbsp;&nbsp;&nbsp;&nbsp;
		<a href="phpradmin.php?p=105&o=d&sg=<? echo $sg ?>" class="text10bc" onclick="return confirm('<? echo $lang['confirm_removing']; ?>')"><? echo $lang['delete']; ?></a>
	</td>
</tr>
</table>