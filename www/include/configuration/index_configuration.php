<?
/*
phpRADmin is developped with GPL Licence 2.0 :
http://www.gnu.org/licenses/gpl.txt
Developped by : Toni de la Fuente (blyx)

For information : toni@blyx.com
*/if (!isset($oreon))
		exit();		
	
?>
<div style="padding-top: 50px;text-align:center;" class="text12">
<? echo $lang['ind_infos']; ?>
	<br><br>
<? echo $lang['ind_detail']; ?>
<br>
</div>
<div style="padding-top: 50px;text-align:center;" class="text12">
<?
// Creation des check-Warning pour la creation des confs de nagios
	if (count($oreon->hosts) <= 0)
	{
		if (!count($oreon->contacts) || !count($oreon->contactGroups) || !count($oreon->time_periods)){
			print '<table align="center"><tr><td>Vous ne possedez pas le minimum requis pour pouvoir commencer &agrave; configurer vos hosts. Avant de cr&eacute;er vos hosts, il faut que vous cr&eacute;&eacute;iez au moins : <br><ul>';
			if (!count($oreon->time_periods))
				print "<li>1 Timeperiod</li>";  
			if (!count($oreon->contacts))
				print "<li>1 Contact</li>";  						
			if (!count($oreon->contactGroups))
				print "<li>1 Contactgroup</li></ul>";  			
			print "</td></tr></table>";
		}
	}
?>
</div>