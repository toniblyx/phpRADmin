<?
/*
Oreon is developped with GPL Licence 2.0 :
http://www.gnu.org/licenses/gpl.txt
Developped by : Toni de la Fuente (blyx)
For information : toni@blyx.com
*/

function Create_miscommands( $oreon, $path)
{
  	$handle = create_file( $path ."misccommands.cfg", $oreon->user->get_firstname(), $oreon->user->get_lastname());
	if (!isset($oreon->commands) && !count($oreon->commands))	{
		return ;
	} else {
		$i = 0;
		$str = NULL;
		foreach ($oreon->commands as $cmd)	{ 
			if (!strcmp($cmd->get_type(), "1")){
				$str .= "# '" . $cmd->get_name() . "' command definition " . $i . "\n";
				$str .= "define command{\n";
				if ($cmd->get_name()){$str .= print_line("command_name", $cmd->get_name());}
				if ($cmd->get_line()){
					$tmp_str = $cmd->get_line();
					$tmp_str = str_replace("@MAIL_PROG@", $oreon->optGen->get_mailer(), $tmp_str);
					$tmp_str = str_replace("@VERSION@", $oreon->user->get_version() . ".X", $tmp_str);
					$str .= print_line("command_line", $tmp_str);
					unset($tmp_str);
				}
				$str .= "}\n\n"; 
				$i++;
				unset($cmd);
			}
		}
	}
  	write_in_file($handle, $str, $path . "misccommands.cfg");
  	fclose($handle);
}

function Create_command( $oreon, $path)
{
	$handle = create_file( $path ."checkcommands.cfg", $oreon->user->get_firstname(), $oreon->user->get_lastname());
	if (!isset($oreon->commands) && !count($oreon->commands))	{
		return ;
	} else {
		$i = 0;
		$str = NULL;
		foreach ($oreon->commands as $cmd)	{ 
			if (!strcmp($cmd->get_type(), "2")){
				$str .= "# '" . $cmd->get_name() . "' command definition " . $i . "\n";
				$str .= "define command{\n";
				if ($cmd->get_name()){$str .= print_line("command_name", $cmd->get_name());}
				if ($cmd->get_line()){$str .= print_line("command_line", $cmd->get_line());}
				$str .= "}\n\n"; 
				$i++;
			}
			unset($cmd);
		}
	}
	write_in_file($handle, $str, $path . "checkcommands.cfg");
  	fclose($handle);
}
?>