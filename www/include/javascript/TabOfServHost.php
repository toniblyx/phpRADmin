<?
/*
phpRADmin is developped with GPL Licence 2.0 :
http://www.gnu.org/licenses/gpl.txt
Developped by : Toni de la Fuente (blyx)

For information : toni@blyx.com
*/?>
<SCRIPT language='javascript'>
function commands_arg(sel)	{
	var command_name = Array(<? echo count($oreon->commands); ?>);
	var command_line = Array(<? echo count($oreon->commands); ?>);
	var command_back = Array(2);
	<?
	foreach ($oreon->commands as $command)	{
		if (!strcmp($command->get_type(), "2"))	{
			$command->set_line(preg_replace("/(-{1,2}S(erviceId)? [\$-a-z0-9]+)$/", "", $command->get_line()));
			echo "command_name[".$command->get_id()."] = '".$command->get_name()."';\n";
			$str_command_line = preg_replace("/(\$ARG\d{1,2}\$)/", "<b>${1}<\/b>",$command->get_line());
			echo "command_line[".$command->get_id()."] = '".(preg_replace("/'/", "\\'",$str_command_line))."';\n";
		}
		unset($command);
	}
	?>
	command_back[0] = command_name[sel];
	command_back[1] = command_line[sel];
	return (command_back);
}
</SCRIPT>