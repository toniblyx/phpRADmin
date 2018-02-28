<?
/*
Oreon is developped with GPL Licence 2.0 :
http://www.gnu.org/licenses/gpl.txt
Developped by : Toni de la Fuente (blyx)
For information : toni@blyx.com
*/

Class TabEventLog
{
	var $tab;
	var $tab_hour;
	
	function TabEventLog($options, $log){
		$this->tab = array();
		$this->tab_hour = array();
		for ($i = 0; $str = fgets($log); $i++){
			$this->tab[$i] = new Event_log();
			$this->tab[$i]->read_line($str, $options).
			$this->tab_hour[date("G", $this->tab[$i]->time_event)] = 1;
		}
	}
}

Class Event_log
{
	var $time_event;
	var $status;
	var $output;
	var $type;
	var $ti;
	var $host;
	var $service;
	var $str;
	
	function Event_log()
	{
		$this->time_event = "";
		$this->status = "";
		$this->output = "";
		$this->type = "";
		$this->ti = 0;
		$this->str = "";
	}
	
	function read_line($line, $options)
	{
		if (preg_match("/^\[([0-9]*)\] ([A-Za-z0-9\:\.\'\"\-\_\;\/\=\%\\\ \,\!\)\(\[\]\{\}]+)/", $line, $matches))
			$time = $matches[1];
		if ($this->ti != date("G", $time))
			$i = 0;
		$res = preg_split("/:/", $matches[2], 2);
		$this->time_event = $time;
		if (isset($res[1])) 
			$this->output = $res[1];
		$this->type = $res[0];
		if (isset($options[4]) && !strncmp($this->type, "HOST NOTIFICATION", 17)){
			unset($res);
			$res1 = preg_split("/;/", $this->output);			
			$this->host = $res1[0];
			$this->service = "";
			$this->status = $res1[1];
			$this->output = $res1[4];
			$this->str = "";
		} else if (isset($options[0]) && !strncmp($this->type, "HOST ALERT", 10)){
			unset($res);
			$res1 = preg_split("/;/", $this->output);			
			$this->host = $res1[0];
			$this->service = "";
			$this->status = $res1[1];
			$this->output = $res1[4];
			$this->str = "";
		} else if (isset($options[4]) && !strcmp($this->type, "SERVICE NOTIFICATION")){
			unset($res);
			$res = preg_split("/;/", $this->output);			
			$this->host = $res[0];
			$this->service = $res[1];
			$this->status = $res[2];
			$this->output = $res[5];
			$this->str = "";
		} else if (isset($options[0]) && !strncmp($this->type, "SERVICE ALERT", 13)){
			unset($res);
			$res = preg_split("/;/", $this->output);			
			$this->host = $res[0];
			$this->service = $res[1];
			$this->status = $res[2];
			$this->output = $res[5];
			$this->str = "";
		} else if (isset($options[3]) && !strncmp($this->type, "Error", 5)) {
			$this->str = "";	
		} else if (isset($options[1]) && !strncmp($this->type, "Warn", 4)) {
			$this->str = "";	
		} else if (!strncmp($this->type, "Auto-save", 9)) { 
			$this->output = $this->type;
			$this->str = "";	
		} else if (isset($options[2]) && !strncmp($this->type, "EXTERNAL COMMAND", 16)) {
			$this->str = "";	
		} else if (!strncmp($this->type, "HOST DOWNTIME ALERT", 19) || !strncmp($this->type, "SERVICE DOWNTIME ALERT", 22)) { 
			$this->output = $this->type;
			$this->str = "";	
		} else if (!strncmp($this->type, "LOG ROTATION", 12)) { 
			$this->output = $this->type;
			$this->str = "";	
		} else if (!strncmp($this->type, "Successfully shutdown", strlen("Successfully shutdown")) || !strncmp($this->type, "Nagios", strlen("Nagios")) 
			|| !strncmp($this->type, "Finished daemonizing", strlen("Finished daemonizing")) || !strncmp($this->type, "Caught SIGTERM", strlen("Caught SIGTERM"))) { 
			$this->output = $this->type;
			$this->str = "";	
		} else {
			$this->str = "|" . $line . "|";
			$this->type = "";
			return false;
		}
		$this->ti = date("G", $time);			
	}
}

class Logs
{
	// Attributes

	var $log_h;
	var $log_p;
	
	// nb list host status
	var $host;
	// nb list sevice status
	var $sv;
	//	Nagios is running ?
	var $status_proc;
	
	var $Host_health;
	var $Service_health;	
	// Operations
	
	function Logs(&$oreon)	{
		$this->log_h = array();
		// init value for host
		$this->host["UP"] = 0;
		$this->host["DOWN"] = 0;
		$this->host["PENDING"] = 0;
		$this->host["UNREACHABLE"] = 0;
		$this->host["UNKNOWN"] = 0;
		// init value for service 
		$this->sv["OK"] = 0;
		$this->sv["CRITICAL"] = 0;
		$this->sv["PENDING"] = 0;
		$this->sv["WARNING"] = 0;
		$this->sv["UNKNOWN"] = 0;
		
		$this->Host_health = 100 ;
		$this->Service_health = 100;
		
		$this->loadLogs($oreon);
	}	
	
	function Set_Host_health()	{
		$total_host = $this->host["DOWN"] + $this->host["UNREACHABLE"] + $this->host["UP"];
		if ($this->host["DOWN"] != 0){
			$percentage = ($this->host["DOWN"] + $this->host["UNREACHABLE"]) / $total_host * 100;
			$this->Host_health = 100 - $percentage; // * $this->host["UP"];
		} else 
			$this->Host_health = 100;
	}
	
	function Set_Service_health()	{
		$total_service = $this->sv["OK"] + $this->sv["CRITICAL"] + $this->sv["WARNING"] + $this->sv["UNKNOWN"] + $this->sv["PENDING"]; 
		$critical = $this->sv["CRITICAL"] + $this->sv["WARNING"] + $this->sv["PENDING"];
		if ($critical != 0){
			$percentage = $critical / $total_service * 100;
			$this->Service_health = 100 - $percentage;
		} else 
			$this->Service_health = 100;
	}
	
	function loadLogs(&$oreon)	{
		if (file_exists($oreon->Nagioscfg->stt_file)){
			$log_file = fopen($oreon->Nagioscfg->stt_file, "r");
			$this->log_p->status_proc = 1;
		} else {
			if (file_exists($oreon->Nagioscfg->get_state_retention_file()))
				$log_file = fopen($oreon->Nagioscfg->get_state_retention_file(), "r");
			 else
				$log_file = 0;
			$this->log_p->status_proc = 0;
		}
		// init table
		$host = array();
		$host_services = array();
		// Create hash table 
		if (isset($oreon->hosts))
			foreach ($oreon->hosts as $h){
				if ($h->get_register())	{
					$host[$h->get_name()] = $h->get_id();
					$host_services[$h->get_name()] = array();
					if (isset($h->services))
						foreach ($h->services as $s)	
							if ($s->get_register())	{
								$host_services[$h->get_name()][$s->get_description()] = $s->get_id();
								unset($s);
							}
				}
				unset($h);
			}
		// Read 
		if ($log_file)
		while ($str = fgets($log_file))		{
			// set last update 
			$last_update = date("d-m-Y h:i:s");
			if (!preg_match("/^\#.*/", $str)){
				// get service stat
				if (preg_match("/^[\[\]0-9\ ]* SERVICE[.]*/", $str)){
					$log = split(";", $str);
					if (isset($host[$log["1"]]) && isset($host_services[$log["1"]][$log["2"]]) && $oreon->is_accessible($host[$log["1"]])){
						$this->sv[$log["3"]]++;
						$this->log_h[$host[$log["1"]]]->log_s[$host_services[$log["1"]][$log["2"]]] = new Log_s($host_services[$log["1"]][$log["2"]], $log);
					}
					unset($log);
				}	
				// get host stat
				if (preg_match("/^[\[\]0-9]* HOST[.]*/", $str)){
					$log = split(";", $str);
					if (isset($host[$log["1"]]) && $oreon->is_accessible($host[$log["1"]])){
						$this->host[$log["2"]]++;
						$this->log_h[$host[$log["1"]]] = new Log_h($host[$log["1"]], $log);
					}
					unset($log);
				}
				if (preg_match("/^[\[\]0-9]* PROGRAM[.]*/", $str)){
					$log = split(";", $str);
					$this->log_p = new Log_p($log, $this->log_p->status_proc);
					unset($log);
				}	
			}
			unset($str);
		}
		$oreon->user->Host_health = $this->Set_Host_health();
		$oreon->user->Service_health = $this->Set_Service_health();
		unset($host);
		unset($host_services);
	}
}

class Log_p
{

  // Attributes
  
	var $program_start;
	var $nagios_pid;
	var $daemon_mode;
	var $last_command_check;
	var $last_log_rotation;
	var $enable_notifications;
	var $execute_service_checks;
	var $accept_passive_service_checks;
	var $enable_event_handlers;
	var $obsess_over_services;
	var $enable_flap_detection;
	var $process_performance_data;
	var $status_proc;

  // Operations

	function Log_p(& $log, $status_proc)
	{
		$this->program_start = $log['1'];
		$this->nagios_pid = $log['2'];
		$this->daemon_mode = $log['3'];
		$this->last_command_check = $log['4'];
		$this->last_log_rotation = $log['5'];
		$this->enable_notifications = $log['6'];
		$this->execute_service_checks = $log['7'];
		$this->accept_passive_service_checks = $log['8'];
		$this->enable_event_handlers = $log['9'];
		$this->obsess_over_services = $log['10'];
		$this->enable_flap_detection = $log['11'];
		$this->process_performance_data = $log['13'];
		$this->status_proc = $status_proc;		
	}
		
  // Get
  
	function get_program_start(){
		return $this->program_start;
	}
	
	function get_nagios_pid(){ 
		return $this->nagios_pid;
	}
	function get_daemon_mode(){
		return $this->daemon_mode;
	}
	
	function get_last_command_check(){
		return $this->last_command_check;
	}
	
	function get_last_log_rotation(){
		return $this->last_log_rotation;
	}
	
	function get_enable_notifications(){
		return $this->enable_notifications;
	}
	
	function get_execute_service_checks(){
		return $this->execute_service_checks;
	}
	
	function get_accept_passive_service_checks(){
		return $this->accept_passive_service_checks;
	}
	
	function get_enable_event_handlers(){
		return $this->enable_event_handlers;
	}
	
	function get_obsess_over_services(){	
		return $this->obsess_over_services;
	}
	
	function get_enable_flap_detection(){
		return $this->enable_flap_detection;
	}
	
	function get_process_performance_data(){
		return $this->process_performance_data;
  	}
	
	function get_status_proc(){
		return $this->status_proc;
  	}
	
} /* end class log program */

class Log_h
{

  // Attributes
	
	var $id;
	var $name;
	var $status;
	var $last_check;
	var $last_stat;
	var $acknowledged;
	var $last_notifi;
	var $curr_not_number;
	var $flapping;
	var $percent_stat_change;
	var $sch_downtime_death;
	var $output;
	var $log_s;
	var $en;
	var $time;
	
	
  // Operations

	function Log_h($id, & $log)
	{
		$this->id = $id;
		$this->name = $log['1'];
		$this->status = $log['2'];
		$this->last_check = $log['3'];
		$this->last_stat = $log['4'];
		$this->acknowledged = $log['5'];
		$this->last_notifi = $log['9'];
		$this->curr_not_number = $log['10'];
		$this->flapping = $log['15'];
		$this->percent_stat_change = $log['16'];
		$this->sch_downtime_death = $log['17'];
		$this->percent_stat_change = $log['19'];
		$this->output = $log['20'];
		$this->log_s = array();	
		$this->en = array(	'not_en' => $log['11'],
							'ev_handler_en' => $log['12'],
							'checks_en' => $log['13'], 
							'flap_detect_en' => $log['14'], 
							'failure_prediction_en' => $log['18']);
		$this->time = array('time_up' => $log['6'],
							'time_down' => $log['7'],
							'time_unrea' => $log['8']);
	}

  		
  // Get
  
	function get_id(){
		return $this->id;}
	function get_name(){
		return $this->name;}
	function get_status(){
		return $this->status;}
	function get_last_check(){
		return $this->last_check;}
	function get_last_stat(){
		return $this->last_stat;}
	function get_acknowledged(){
		return $this->acknowledged;}
	function get_time_up(){
		return $this->time['time_up'];}
	function get_time_down(){
		return $this->time['time_down'];}
	function get_time_unrea(){
		return $this->time['time_unrea'];}
	function get_last_notifi(){
		return $this->last_notifi;}
	function get_curr_not_number(){
		return $this->curr_not_number;}
	function get_not_en(){
		return $this->en['not_en'];}
	function get_ev_handler_en(){
		return $this->en['ev_handler_en'];}
	function get_checks_en(){
		return $this->en['checks_en'];}
	function get_flap_detect_en(){
		return $this->en['flap_detect_en'];}
	function get_flapping(){
		return $this->flapping;}
	function get_percent_stat_change(){
		return $this->percent_stat_change;}
	function get_sch_downtime_death(){
		return $this->sch_downtime_death;}
	function get_failure_prediction_en(){
		return $this->en['failure_prediction_en'];}
	function get_output(){
		return $this->output;}
	
} /* end class log hosts */

class Log_s
{

  // Attributes

	var $id;
	var $host_name;
	var $description;
	var $status;
	var $retry;
	var $stat_type;
	var $last_check;
	var $next_check;
	var $check_type;
	var $accept_passive_check;
	var $last_change;
	var $pb_aknowledged;
	var $last_hard_stat;
	var $last_not_time;
	var $current_not_nb;
	var $latency;
	var $exec_time;
	var $percent_stat_change;
	var $scheduled_downtime_depth;
	var $process_perf_date;
	var $Output;
	var $en;
	var $time;
		
  // Operations

  function Log_s($id, & $log)
  {
  	$this->id = $id;
	$this->host_name = $log[1];
	$this->description = $log[2];
	$this->status = $log[3];
	$this->retry = $log[4];
	$this->stat_type = $log[5];
	$this->last_check = $log[6];
	$this->next_check = $log[7];
	$this->check_type = $log[8];
	$this->accept_passive_check = $log[10];
	$this->last_change = $log[12];
	$this->pb_aknowledged = $log[13];
	$this->last_hard_stat = $log[14];
	$this->last_not_time = $log[19];
	$this->current_not_nb = $log[20];
	$this->latency = $log[22];
	$this->exec_time = $log[23];
	$this->percent_stat_change = $log[26];
	$this->scheduled_downtime_depth = $log[27];
	$this->process_perf_date = $log[29];
	$this->Output = $log[31];
	$this->en = array(	'checks_en' => $log[9], 
						'ev_handler_en' => $log[11], 
						'not_en' => $log[21], 
						'flap_en' => $log[24], 
						'Failure_prediction_en' => $log[28], 
						'sv_is_flapping' => $log[25], 
						'obsess_over_service' => $log[30]);
	$this->time = array('ok' => $log[15],
						'unknown' => $log[16],
						'warning' => $log[17],
						'critical' => $log[18], 
						'total_running' => $log[15]+$log[16]+$log[17]+$log[18]);
 }
 
  // Get
  
	function get_id(){
		return $this->id;}  
	function get_host_name(){
		return $this->host_name;}
	function get_host_id(){
		return $this->host_host_id;}
	function get_description(){
		return $this->description;}
	function get_status(){
		return $this->status;}
	function get_retry(){
		return $this->retry;	}
	function get_stat_type(){
		return $this->stat_type;}
	function get_last_check(){
		return $this->last_check;}
	function get_next_check(){
		return $this->next_check;}
	function get_check_type(){
		return $this->check_type;}
	function get_checks_en(){
		return $this->en['checks_en'];}
	function get_accept_passive_check(){
		return $this->accept_passive_check;}
	function get_ev_handler_en(){
		return $this->en['ev_handler_en'];}
	function get_last_change(){
		return $this->last_change;}
	function get_pb_aknowledged(){
		return $this->pb_aknowledged;}
	function get_last_hard_stat(){
		return $this->last_hard_stat;}
	function get_time_ok(){
		return $this->time['ok'];}
	function get_time_unknown(){
		return $this->time['unknown'];}
	function get_time_warning(){
		return $this->time['warning'];}
	function get_time_critical(){
		return $this->time['critical'];}
	function get_duration(){
		return $this->time['total_running'];}
	function get_last_not_time(){
		return $this->last_not_time;}
	function get_current_not_nb(){
		return $this->current_not_nb;}
	function get_not_en(){
		return $this->en['not_en'];}
	function get_latency(){
		return $this->latency;}
	function get_exec_time(){
		return $this->exec_time;}
	function get_flap_en(){
		return $this->en['flap_en'];}
	function get_sv_is_flapping(){
		return $this->en['sv_is_flapping'];}
	function get_percent_stat_change(){
		return $this->percent_stat_change;}
	function get_scheduled_downtime_depth(){
		return $this->scheduled_downtime_depth;}
	function get_Failure_prediction_en(){
		return $this->en['Failure_prediction_en'];}
	function get_process_perf_date(){
		return $this->process_perf_date;}
	function get_obsess_over_service(){
		return $this->en['obsess_over_service'];}
	function get_Output(){
		return $this->Output;}
  
} /* end class log services */
?>