<?
/*
Oreon is developped with GPL Licence 2.0 :
http://www.gnu.org/licenses/gpl.txt
Developped by : Toni de la Fuente (blyx)
For information : toni@blyx.com
*/

function Create_timeperiod(& $oreon, $path)
{
	$handle = create_file($path ."timeperiods.cfg", $oreon->user->get_firstname(), $oreon->user->get_lastname());
	if (!isset($oreon->time_periods) && !count($oreon->time_periods))	{
		return ;
	} else {
		$time_periods = & $oreon->time_periods;
		$i = 0;
		$str = NULL;
		foreach ($time_periods as $time_period)	{
			$str .= "# '" . $time_period->get_name() . "' timeperiod definition " . $i . "\n";
			$str .= "define timeperiod{\n";
			if ($time_period->get_name()){$str .= print_line("timeperiod_name", $time_period->get_name());}
			if ($time_period->get_alias()){$str .= print_line("alias", $time_period->get_alias());}
			if ($time_period->get_monday()){$str .= print_line("monday", $time_period->get_monday());}
			if ($time_period->get_tuesday()){$str .= print_line("tuesday", $time_period->get_tuesday());}
			if ($time_period->get_wednesday()){$str .= print_line("wednesday", $time_period->get_wednesday());}
			if ($time_period->get_thursday()){$str .= print_line("thursday", $time_period->get_thursday());}
			if ($time_period->get_friday()){$str .= print_line("friday", $time_period->get_friday());}
			if ($time_period->get_saturday()){$str .= print_line("saturday", $time_period->get_saturday());}
			if ($time_period->get_sunday()){$str .= print_line("sunday", $time_period->get_sunday());}
			$str .= "}\n\n";
			$i++;
			unset($time_period);
		}
	}
  	write_in_file($handle, $str, $path ."timeperiods.cfg");
	fclose($handle);
}
?>