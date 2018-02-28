<?
/*
phpRADmin is developped under GPL Licence 2.0 :
http://www.gnu.org/licenses/gpl.txt or read LICENSE file.

Developed by : Toni de la Fuente (blyx) from Madrid and Alfacar (Granada), Spain  
For information : toni@blyx.com http://blyx.com

We are using Oreon for base code: http://www.oreon-project.org
We are using Dialup Admin for user management 
and many more things: http://www.freeradius.org
We are using PHPKI for Certificates management: http://phpki.sourceforge.org/ 

Thanks very much!!
*/

/*
This file contains almost all text. This method facilitate us to do a multi-language tool.
It will be easy to guess what variables are corresponding to.
*/

/*
Translated to Spanish some parts by: Ivan Fontan (chernobil@gmail.com)
*/

/* Error Code */
$lang['errCode'][-2] = "Definici&oacute;n de objeto incompleta";
$lang['errCode'][-3] = "Definici&oacute;n de objeto ya existente";
$lang['errCode'][-4] = "E-mail inv&aacute;lido, formato: xxx@xxx.xxx";
$lang['errCode'][-5] = "La Definici&oacute;n es inv&aacute;lida";
$lang['errCode'][-6] = "Escoger un Host o un Grupo de Hosts";
$lang['errCode'][-7] = "La contrase&ntilde;a es incorrecta";
$lang['errCode'][-8] = "La fecha de inicio debe ser anterior a la fecha de finalizaci&oacute;n";
$lang['errCode'][-9] = "Falta alg&uacute;n valor";
$lang['errCode'][2] = "Se ha modificado la definici&oacute;n de objeto";
$lang['errCode'][3] = "Se ha creado la definici&oacute;n de objeto";
$lang['errCode'][4] = "Se ha modificado la contrase&ntilde;a";
$lang['errCode'][5] = "Se ha duplicado el Host";

/* menu */

$lang['m_home'] = "Inicio";
$lang['m_configuration'] = "Configuraci&oacute;n";
$lang['m_monitoring'] = "Monitorizaci&oacute;n";
$lang['m_reporting'] = "Informes";
$lang['m_graphs'] = "Gr&aacute;ficas";
$lang['m_graphs_host'] = "Gr&aacute;ficas por Host";
$lang['m_bbreport'] = "Informes";
$lang['m_options'] = "Opciones";

$lang['m_host'] = "Host";
$lang['m_host_template_model'] = "Plantillas Modelo de Host";
$lang['m_hostgroup'] = "Grupos de Hosts";
$lang['m_hostgroupesc'] = "Escalado de Grupos de Hosts";
$lang['m_host_extended_info'] = "Informaci&oacute;n Extendida de Host";
$lang['m_extended_info'] = "Informacion Extendedida";
$lang['m_hostesc'] = "Escalado de Hosts";
$lang['m_host_dependencies'] = "Dependencias de Hosts";
$lang['m_service'] = "Servicios";
$lang['m_servicegroup'] = "Grupos de Servicios";
$lang['m_contact'] = "Contactos";
$lang['m_contactgroup'] = "Grupos de Contactos";
$lang['m_timeperiod'] = "Franjas Horarias";
$lang['m_command'] = "Comandos";
$lang['m_service_extended_info'] = "Informaci&oacute;n Extendida de Servicio";
$lang['m_service_dependencies'] = "Dependencias de Servicio";
$lang['m_service_template_model'] = "Plantillas Modelo de Servicio";
$lang['m_serviceesc'] = "Escalado de Servicio";
$lang['m_profile'] = "Tu perfil";
$lang['m_users_profile'] = "Perfil de Usuarios";
$lang['m_lang'] = "Idioma";
$lang['m_backup_db'] = "Copia de Seguridad de Base de Datos";
$lang['m_server_status'] = "Estado del Servidor";
$lang['m_logout'] = "Desconectar";
$lang['m_apply'] = "Aplicar";
$lang['m_histo'] = "Hist&oacute;rico";
$lang['m_tools'] = "Herramientas";
$lang['m_about'] = "Acerca de";
$lang['m_users'] = "Usuarios";
$lang['m_configuration'] = "Configuraci&oacute;n";
$lang['m_general'] = "General";
$lang['m_plugins'] = "Plugins";
$lang['m_update_oreon'] = "Portal";
$lang['update_error_connect'] = "Imposible conectarse a www.oreon.org";
$lang['m_trafficMap'] = "Mapa de Tr&aacute;fico";
$lang['m_options_report'] = "Opciones de los Informes";
$lang['m_load_nagios_files'] = "Cargar una configuraci&oacute;n de Nagios";
$lang['m_auto_detect'] = "Autodetectar";
$lang['m_notification'] = "Notificaci&oacute;n";
$lang['m_check'] = "Comprobaci&oacute;n";
$lang['m_nagios'] = "Nagios";
$lang['m_delete_selection'] = "Eliminar la selecci&oacute;n";
$lang['m_is_connected'] = "Qui&eacute;n est&aacute; conectado" ;

$lang['m_graph_template'] = "Modelo de Gr&aacute;fico";

$lang["m_host_detail"] = "Detalles de los Hosts";
$lang["m_service_detail"] = "Detalles de los Servicios";
$lang["m_hosts_problems"] = "Problemas de los Hosts";
$lang["m_services_problems"] = "Problemas de los Servicios";
$lang["m_hostgroup_detail"] = "Detalles de los Grupos de Hosts";
$lang["m_servicegroup_detail"] = "Detalles de los Grupos de Servicios";
$lang["m_status_scheduling"] = "Estado y Programaci&oacute;n";
$lang["m_status_summary"] = "Resumen de Estado";
$lang["m_status_grid"] = "Parrilla de Estado";
$lang["m_scheduling"] = "Cola de Programaci&oacute;n";
$lang["m_process_info"] = "Informaci&oacute;n de Proceso";
$lang["m_event_log"] = "Registro de Eventos";
$lang["m_downtime"] = "Tiempo de Inactividad";
$lang["m_comments"] = "Comentarios";
$lang["m_inventory"] = "Inventario";

$lang["m_report_custom"] = "Informe de Registro";
$lang["m_traffic_map"] = "Mapa de Tr&aacute;fico";

$lang["m_dev"] = "Desarrollo";
$lang["m_notifications"] = "Notifications";
$lang["m_alerts"] = "Alertes history";

/* Plugins */

$lang["plugins1"] = "Plugins eliminados";
$lang["plugins2"] = "Est&aacute;s seguro de eliminar este plugin? ";
$lang["plugins3"] = "Plugin enviado";
$lang["plugins4"] = "Ha ocurrido un error durante la grabaci&oacute;n del Plugin. Es posible que sea un problema de permisos";
$lang["plugins5"] = "Ha ocurrido un error durante la creaci&oacute;n del fichero 'oreon.conf'. Es posible que sea un problema de permisos";
$lang["plugins6"] = "Fichero generado";
$lang["plugins_add"] = "A&ntilde;adir plugins para Nagios";
$lang["plugins"] = "Plugins";
$lang["plugins_list"] = "Lista de plugins";
$lang["plugins_pm_conf"] = "Oreon.conf";
$lang["plugins_pm_conf_desc"] = "Generar el fichero de configuraci&oacute;n para Oreon.pm con la informaci&oacute;n incluida en el men&uacute; General";


/* index100 */

$lang['ind_infos'] = "En esta secci&oacute;n se pueden configurar todas las caracter&iacute;sticas de Nagios";
$lang['ind_detail'] = "Los recursos est&aacute;n enlazados, cuidado cuando se modifiquen o se eliminen, ya que los que est&eacute;n relacionados tambi&eacute;n se modificar&aacute;n/eliminar&aacute;n.";

/* index */

$lang['ind_first'] = "Ya est&aacute;s conectado a OREON, primero se debe cerrar la sesi&oacute;n<br>Si esta es la &uacute;nica ventana, pulsa <br><a href='?disconnect=1' class='text11b'>aqu&iacute;</a>";

/* alt main */

$lang['am_intro'] = "monitorizando ahora :";
$lang['host_health'] = "Estado de los Hosts";
$lang['service_health'] = "Estado de los Servicios";
$lang['network_health'] = "Estado de la Red";
$lang['am_hg_vdetail'] = "Ver detalles de los Grupos de Hosts";
$lang['am_sg_vdetail'] = "Ver detalles de los Grupos de Servicios";
$lang['am_hg_detail'] = "Detalles de los Grupos de Hosts";
$lang['am_sg_detail'] = "Detalles de los Grupos de Servicios";

/* Monitoring */

$lang['mon_last_update'] = "&Uacute;ltima actualizaci&oacute;n :";
$lang['mon_up'] = "OPERATIVO";
$lang['mon_down'] = "INOPERATIVO";
$lang['mon_unreachable'] = "INACCESIBLE";
$lang['mon_ok'] = "OK";
$lang['mon_critical'] = "CR&Iacute;TICO";
$lang['mon_warning'] = "ADVERTENCIA";
$lang['mon_pending'] = "PENDIENTE";
$lang['mon_unknown'] = "DESCONOCIDO";
$lang['mon_status'] = "Estado";
$lang['mon_ip'] = "IP";
$lang['mon_last_check'] = "&Uacute;ltima Comprobaci&oacute;n";
$lang['mon_next_check'] = "Pr&oacute;xima Comprobaci&oacute;n";
$lang['mon_active_check'] = "Comprobaci&oacute;n Activa";
$lang['mon_duration'] = "Duraci&oacute;n";
$lang['mon_retry'] = "Reintentar";
$lang['mon_status_information'] = "Informaci&oacute;n del Estado";
$lang['mon_service_overview_fah'] = "Visi&oacute;n General para todos los Grupos de Hosts";
$lang['mon_service_overview_fas'] = "Visi&oacute;n General para todos los Grupos de Servicios";
$lang['mon_status_summary_foh'] = "Resumen de Estado para todos los Grupos de Hosts";
$lang['mon_status_grid_fah'] = "Parrilla de Estado para todos los Grupos de Hosts";
$lang['mon_sv_hg_detail1'] = "Detalles de los Servicios";
$lang['mon_sv_hg_detail2'] = "para Grupo de Hosts";
$lang['mon_sv_hg_detail3'] = "para Host";
$lang['mon_host_status_total'] = "Estado de Hosts (Total)";
$lang['mon_service_status_total'] = "Estado de Servicios (Total)";
$lang['mon_scheduling'] = "Cola de Programaci&oacute;n";
$lang['mon_actions'] = "Acciones";
$lang['mon_active'] = "ACTIVO";
$lang['mon_inactive'] = "INACTIVO";
$lang['mon_request_submit_host'] = "La petici&oacute;n ha sido enviada. <br><br> Ser&aacute;s redireccionado a la p&aacute;gina del Host.";
$lang['Details'] = "Detalles";

/* Monitoring command */

$lang['mon_hg_commands'] = "Comandos de Grupo de Hosts";
$lang['mon_h_commands'] = "Comandos de Host";
$lang['mon_sg_commands'] = "Comandos de Grupo de Servicios";
$lang['mon_s_commands'] = "Comandos de Servicios";
$lang['mon_no_stat_for_host'] = "No hay estad&iacute;sticas para este Host.<br><br> Se deber&aacute;n generar los ficheros de configuraci&oacute;n.";
$lang['mon_no_stat_for_service'] = "No hay estad&iacute;sticas para este Servicio.<br><br> Se deber&aacute;n generar los ficheros de configuraci&oacute;n.";
$lang['mon_hg_cmd1'] = "Parada programada para todos los Hosts de este Grupo de Hosts";
$lang['mon_hg_cmd2'] = "Parada programada para todos los Servicios de este Grupo de Hosts";
$lang['mon_hg_cmd3'] = "Activar notificaciones para todos los Hosts de este Grupo de Hosts";
$lang['mon_hg_cmd4'] = "Desactivar notificaciones para todos los Hosts de este Grupo de Hosts";
$lang['mon_hg_cmd5'] = "Activar notificaciones para todos los Servicios de este Grupo de Hosts";
$lang['mon_hg_cmd6'] = "Desactivar notificaciones para todos los Servicios de este Grupo de Hosts";
$lang['mon_hg_cmd7'] = "Activar comprobaciones para todos los Servicios de este Grupo de Hosts";
$lang['mon_hg_cmd8'] = "Desactivar comprobaciones para todos los Servicios de este Grupo de Hosts";
$lang['mon_host_state_info'] = "Informaci&oacute;n del Estado del Host";
$lang['mon_host_status'] = "Estado del Host";
$lang['mon_status_info'] = "Informaci&oacute;n del Estado";
$lang['mon_last_status_check'] = "&Uacute;ltima Comprobaci&oacute;n del Estado";
$lang['mon_status_data_age'] = "Antig&uuml;edad de los Datos del Estado";
$lang['mon_current_state_duration'] = "Duraci&oacute;n del Estado Actual";
$lang['mon_last_host_notif'] = "&Uacute;ltima Notificaci&oacute;n de Host";
$lang['mon_current_notif_nbr'] = "N&uacute;mero de Notificaci&oacute;n Actual";
$lang['mon_is_host_flapping'] = "Est&aacute; este Host entrando en Estado de P&aacute;nico?";
$lang['mon_percent_state_change'] = "Porcentaje de Cambio de Estado";
$lang['mon_is_sched_dt'] = "Hay Parada Programada ?";
$lang['mon_last_update'] = "&Uacute;ltima Actualizaci&oacute;n";
$lang['mon_sch_imm_cfas'] = "Programa comprobaci&oacute;n inmediata de todos los servicios";
$lang['mon_sch_dt'] = "Programar parada";
$lang['mon_dis_notif_fas'] = "Desactivar notificaciones para todos los servicios";
$lang['mon_enable_notif_fas'] = "Activar notificaciones para todos los servicios";
$lang['mon_dis_checks_fas'] = "Desactivar comprobaciones para todos los servicios";
$lang['mon_enable_checks_fas'] = "Activar comprobaciones para todos los servicios";
$lang['mon_service_state_info'] = "Informaci&oacute;n del Estado del Servicio";
$lang['mon_service_status'] = "Estado del Servicio";
$lang['mon_current_attempt'] = "Intento Actual";
$lang['mon_state_type'] = "Tipo de Estado";
$lang['mon_last_check_type'] = "Tipo de la &Uacute;ltima Comprobaci&oacute;n";
$lang['mon_last_check_time'] = "Hora de la &Uacute;ltima Comprobaci&oacute;n";
$lang['mon_next_sch_active_check'] = "Pr&oacute;xima Comprobaci&oacute;n Activa Programada";
$lang['mon_last_service_notif'] = "&Uacute;ltima Notificaci&oacute;n de Servicio";
$lang['mon_is_service_flapping'] = "Est&aacute; este Servicio entrando en Estado de P&aacute;nico ?";
$lang['mon_percent_state_change'] = "Porcentaje de Cambio de Estado";
$lang['mon_checks_for_service'] = "Comprobaciones de este servicio";
$lang['mon_accept_pass_check'] = "aceptando comprobaciones pasivas para este servicio";
$lang['mon_notif_service'] = "notificaciones para este servicio";
$lang['mon_eh_service'] = "manipulador de eventos para este servicio";
$lang['mon_fp_service'] = "detecci&oacute;n de estado de p&aacute;nico para este servicio";
$lang['mon_submit_pass_check_service'] = "Enviar resultado de comprobaci&oacute;n pasiva para este servicio";
$lang['mon_sch_dt_service'] = "Programar parada para este servicio";
$lang['mon_service_check_executed'] = "Comprobaciones de Servicio en Ejecuci&oacute;n";
$lang['mon_passive_service_check_executed'] = "Comprobaciones Pasivas de Servicio Aceptadas";
$lang['mon_eh_enabled'] = "Manipulador de Eventos Activado";
$lang['mon_obess_over_services'] = "Comprobaci&oacute;n obsesiva sobre los Servicios";
$lang['mon_fp_detection_enabled'] = "Detecci&oacute;n de Estado de P&aacute;nico Activada";
$lang['mon_perf_data_process'] = "Datos de Rendimiento Proces&aacute;ndose";
$lang['mon_request_submit_host'] = "La petici&oacute;n ha sido grabada <br><br> Ser&aacute;s redireccionado a la p&aacute;gina del Host.";
$lang['mon_process_infos'] = "Informaciones de Proceso";
$lang['mon_process_start_time'] = "Hora de inicio del Programa";
$lang['mon_total_run_time'] = "Tiempo Total de Funcionamiento";
$lang['mon_last_ext_command_check'] = "&Uacute;ltima Comprobaci&oacute;n Externa de Comando";
$lang['mon_last_log_file_rotation'] = "&Uacute;ltima Rotaci&oacute;n de Fichero de Registro";
$lang['mon_nagios_pid'] = "PID de Nagios";
$lang['mon_process_cmds'] = "Comandos del Proceso";
$lang['mon_stop_nagios_proc'] = "Parar el Proceso de Nagios";
$lang['mon_start_nagios_proc'] = "Iniciar el Proceso de Nagios";
$lang['mon_restart_nagios_proc'] = "Reiniciar el Proceso de Nagios";
$lang['mon_proc_options'] = "Opciones del Proceso";
$lang['mon_notif_enabled'] = "Notificaciones Activadas";
$lang['mon_notif_disabled'] = "Notifications Disabled";
$lang['mon_service_check_disabled'] = "Service Check Disabled";
$lang['mon_service_check_passice_only'] = "Passive Check Only";
$lang['mon_service_view_graph'] = "View graph";
$lang['mon_service_sch_check'] = "Schedule an immediate check of this service";

/* comments */

$lang['cmt_service_comment'] = "Comentarios de Servicio";
$lang['cmt_host_comment'] = "Comentarios de Host";
$lang['cmt_addH'] = "A&ntilde;adir un comentario de Host";
$lang['cmt_addS'] = "A&ntilde;adir un comentario de Servicio";
$lang["cmt_added"] = "Comentario a&ntilde;adido satisfact&oacute;riamente. <br><br>Pulsa <a href='./phpradmin.php?p=307' class='text11b'>aqu&iacute;</a> para regresar a la p&aacute;gina de comentarios.";
$lang["cmt_del"] = "Comentario eliminado satisfact&oacute;riamente. <br><br>Pulsa <a href='./phpradmin.php?p=307' class='text11b'>aqu&iacute;</a> para regresar a la p&aacute;gina de comentarios.";
$lang["cmt_del_all"] = "Todos los comentarios eliminados satisfact&oacute;riamente. <br><br>Pulsa <a href='./phpradmin.php?p=307' class='text11b'>aqu&iacute;</a> para regresar a la p&aacute;gina de comentarios.";
$lang['cmt_host_name'] = "Nombre del Host";
$lang['cmt_entry_time'] = "Hora de Entrada";
$lang['cmt_author'] = "Autor";
$lang['cmt_comment'] = "Comentario";
$lang['cmt_persistent'] = "Persistente";
$lang['cmt_actions'] = "Acciones";

/* downtime */

$lang['dtm_addH'] = "A&ntilde;adir una parada programada de Host";
$lang['dtm_addS'] = "A&ntilde;adir una parada programada de Servicio";
$lang['dtm_addHG'] = "A&ntilde;adir una parada programada de Grupo de Hosts";
$lang['dtm_added'] = "Parada programada a&ntilde;adida satisfact&oacute;riamente. <br><br>Pulsa <a href='./phpradmin.php?p=308' class='text11b'>aqu&iacute;</a> para regresar a la p&aacute;gina de paradas programadas.";
$lang['dtm_del'] = "Parada programada eliminada satisfact&oacute;riamente. <br><br>Pulsa <a href='./phpradmin.php?p=308' class='text11b'>aqu&iacute;</a> para regresar a la p&aacute;gina de paradas programadas.";
$lang['dtm_start_time'] = "Hora de Inicio";
$lang['dtm_end_time'] = "Hora de Fin";
$lang['dtm_fixed'] = "Fijado";
$lang['dtm_duration'] = "Duraci&oacute;n";
$lang['dtm_sch_dt_fht'] = "Programar parada tambi&eacute;n para los Hosts";
$lang['dtm_host_downtimes'] = "Paradas Programadas de Host";
$lang['dtm_service_downtimes'] = "Paradas Programadas de Servicio";
$lang['dtm_dt_no_file'] = "No se ha encontrado el fichero de Paradas Programadas";
$lang['dtm_host_delete'] = "Delete host downtime";

/* cmd externe */

$lang['cmd_utils'] = '&Uacute;til';
$lang["cmd_send"] = "Se ha enviado el comando";
$lang["cmd_ping"] = "Ping";
$lang["cmd_traceroute"] = "Traceroute.";

/* actions & recurrent text */

$lang['home'] = "Inicio";
$lang['oreon'] = "Oreon";
$lang['add'] = "A&ntilde;adir";
$lang['dup'] = "Duplicar";
$lang['save'] = "Guardar";
$lang['modify'] = "Modificar";
$lang['delete'] = "Eliminar";
$lang['update'] = "Actualizar";
$lang['ex'] = "Ejemplo ";
$lang['name'] = "Nombre ";
$lang['alias'] = "Alias ";
$lang['user'] = "Usuario ";
$lang['here'] = "aqu&iacute;";
$lang['this'] = "este";
$lang['confirm_removing'] = "Est&aacute;s seguro de querer eliminar este elemento?";
$lang['confirm_update'] = "Est&aacute;s seguro de actualizar el mapa de tr&aacute;fico?";
$lang['file_exist'] = "Lo sentimos, el fichero ya existe.";
$lang['uncomplete_form'] = "Formulario incompleto o inv&aacute;lido";
$lang['none'] = "ninguno/a";
$lang['already_logged'] = "Ya est&aacute;s conectado a OREON, primero se debe cerrar la sesi&oacute;n<br>Si esta es &uacute;nica ventana, pulsa <br><a href='?disconnect=1' class='text11b'>aqu&iacute;</a>";
$lang['not_allowed'] = "No te est&aacute; permitido acceder a esta p&aacute;gina";
$lang['usage_stats'] = "Uso de las estad&iacute;sicas";
$lang['check'] = "Selecciona";
$lang['uncheck'] = "Deselecciona";
$lang['options'] = "Opciones";
$lang['status'] = "Estado";
$lang['status_options'] = "Estado y opciones";
$lang['details'] = "Detalles";
$lang['back'] = "Volver";
$lang['view'] = "Ver";
$lang['choose'] = "Escoger";
$lang['enable'] = "Activado";
$lang['disable'] = "Desactivado";
$lang['yes'] = "S&iacute;";
$lang['no'] = "No";
$lang['description'] = "Descripci&oacute;n";
$lang['page'] = "P&aacute;gina";
$lang['required'] = "<font color='red'>*</font> requerido";
$lang['nbr_per_page'] = "Nº por p&aacute;gina";
$lang['reset'] = "Resetear";
$lang['time_sec'] = "seg";
$lang['time_min'] = "min";
$lang['time_hours'] = " Hours ";
$lang['time_days'] = " Days ";
$lang['size'] = "Tama&ntilde;o";

/* host */

$lang['h_available'] = "Hosts Disponibles";
$lang['h'] = "Host ";
$lang['h_services'] = "Servicio(s) Asociado(s)";
$lang['h_hostgroup'] = "Grupo(s) de Hosts Asociado(s)";
$lang['h_dependancy'] = "Pertenencia a Grupos de Hosts ";
$lang['h_nbr_dup'] = "Cantidad a duplicar";

/* extended host infos */

$lang['ehi'] = "Informaci&oacute;n Extendida de Host";
$lang['ehi_available'] = "Informaci&oacute;n extendida disponible para Hosts ";
$lang['ehi_notes'] = "Nota";
$lang['ehi_notes_url'] = "Direcci&oacute;n de Notas";
$lang['ehi_action_url'] = "URL de Acci&oacute;n";
$lang['ehi_icon_image'] = "Imagen/Icono";
$lang['ehi_icon_image_alt'] = "ALT de Imagen/Icono";

/* host template model*/

$lang['htm_available'] = "Plantilla(s) Modelo(s) de Host(s) disponible(s)";
$lang['htm'] = "Plantillas Modelo de Host ";
$lang['htm_use'] = "Usar una Plantilla Modelo de Host";
$lang['htm_stats1'] = "Esta Plantilla Modelo est&aacute; siendo usada por ";

/* host group */

$lang['hg_title'] = "Grupos de Hosts ";
$lang['hg_available'] = "Grupo(s) de Hosts disponible(s)";
$lang['hg'] = "Grupo(s) de Hosts";
$lang['hg_belong'] = "Grupo(s) de Host perteneciente(s)";

/* host group escalation */

$lang['hge'] = "Escalado de Grupo de Hosts";
$lang['hge_available'] = "Escalado de Grupo(s) de Hosts disponible(s)";

/* host escalation */

$lang['he'] = "Escalado de Host";
$lang['he_available'] = "Escalado(s) de Host disponible(s)";

/* host dependencies */

$lang['hd'] = "Dependencias de Host";
$lang['hd_available'] = "dependencia(s) de Host disponible(s)";
$lang['hd_dependent'] = "Host Dependiente";

/* host template model */

$lang['htm'] = "Plantillas Modelo de Host";
$lang['htm_u'] = "Usar como Plantilla Modelo de Host";
$lang['htm_v'] = "Usar Plantilla en la monitorizaci&oacute;n del Host";

/* service escalation */

$lang['se'] = "Escalado de Servicio";
$lang['se_available'] = "Escalado(s) de Servicio disponible(s)";

/* service */

$lang['s_ping_response'] = "respuesta del ping";
$lang['s_logged_users'] = "usuarios conectados";
$lang['s_free_disk_space'] = "espacio libre de disco";
$lang['s_available'] = "Servicios Disponibles";
$lang['s_contact_groups'] = "Grupos de Contacto :";
$lang['s'] = "Servicio";

/* extended service infos */

$lang['esi'] = "Informaciones Extendidas de Servicio";
$lang['esi_available'] = "Informacion(es) Extendidas de Servicio disponible(s) ";
$lang['esi_notes'] = "Nota";
$lang['esi_notes_url'] = "Direcci&oacute;n de Notas";
$lang['esi_action_url'] = "URL de Acci&oacute;n";
$lang['esi_icon_image'] = "Imagen/Icono";
$lang['esi_icon_image_alt'] = "ALT de Imagen/Icono";

/* service template model*/

$lang['stm_available'] = "Plantilla(s) Modelo(s) de Servicio(s) disponible(s)";
$lang['stm'] = "Plantillas Modelo de Servicio ";
$lang['stm_use'] = "Usar una Plantilla Modelo de Servicio";
$lang['stm_stats1'] = "Esta Plantilla Modelo est&aacute; siendo usada por ";

/* service dependencies */

$lang['sd'] = "Dependencia de Servicio";
$lang['sd_available'] = "Dependencias de Servicio disponibles";
$lang['sd_dependent'] = "Servicio Dependiente";

/* service group*/

$lang['sg_available'] = "Grupo de Servicios Disponible";
$lang['sg'] = "Grupo de Servicios";

/* contact */

$lang['c_available'] = "Contacto(s) disponible(s)";
$lang['c'] = "Contacto";
$lang['c_use'] = "Este Contacto se utiliza en los Grupos de Contactos :";

/* contact group */

$lang['cg_title'] = "Grupo de Contactos";
$lang['cg_available'] = "Grupo de Contactos disponibles";
$lang['cg'] = "Grupo de Contactos";
$lang['cg_related'] = " se utiliza con ";

/* time period */

$lang['tp_title'] = "Franja Horaria";
$lang['tp_notifications'] = "notificaciones ";
$lang['tp_service_check'] = "comprobaci&oacute;n de servicio ";
$lang['tp_name'] = "nombre de Franja Horaria";
$lang['tp_alias'] = "Alias ";
$lang['tp_sunday'] = "Domingo ";
$lang['tp_monday'] = "Lunes ";
$lang['tp_tuesday'] = "Martes ";
$lang['tp_wednesday'] = "Mi&eacute;rcoles ";
$lang['tp_thursday'] = "Jueves ";
$lang['tp_friday'] = "Viernes ";
$lang['tp_saturday'] = "S&aacute;bado ";
$lang['tp_available'] = "Franjas Horarias disponibles";
$lang['tp'] = "Franja(s) Horaria(s) ";
$lang['tp_more_ex'] = " se usa como Comando de Comprobaci&oacute;n en los siguientes Hosts :";
$lang['tp_more_ex2'] ="se usa como Manipulador de Eventos en los siguientes Hosts :";

/* command */

$lang['cmd_title'] = "Comando";
$lang['cmd_notifications'] = " Notificaciones de Servicio ";
$lang['cmd_service_check'] = "Comprobaci&oacute;n de Servicio ";
$lang['cmd_event'] = "Manipulador de Eventos de Servicio ";
$lang['cmd_host_check'] = "Comprobaci&oacute;n de Host ";
$lang['cmd_host_notifications'] = "Notificaciones de Host ";
$lang['cmd_host_event_handler'] = "Manipulador de Eventos de Host ";
$lang['cmd_comment'] = "Las definiciones de Comandos pueden contener macros, pero hay que estar seguro de incluir s&oacute;lo macros &quot;v&aacute;lidas&quot; para las circunstancias en que se va a usar el comando.";
$lang['cmd_macro_infos'] = "M&aacute;s informaci&oacute;n acerca de macros se pueden encontrar aqu&iacute; :";
$lang['ckcmd_available'] = "Comando(s) de Comprobaci&oacute;n disponible(s)";
$lang['ntcmd_available'] = "Comando(s) de Notificaci&oacute;n disponible(s)";
$lang['cmd_name'] = "Nombre del Comando";
$lang['cmd_line'] = "L&iacute;nea de Comandos ";
$lang['cmd'] = "Comando(s) ";
$lang['cmd_more_ex'] = " se usa como Comando de Comprobaci&oacute;n en lo siguientes Hosts :";
$lang['cmd_more_ex2'] =" se usa como Manipulador de Eventos en los siguientes Hosts :";
$lang['cmd_type'] = "Tipo de Comando";

/* Load Nagios CFG */

$lang['nfc_generated_by_oreon'] = "Los ficheros han sido generados con Oreon ?";
$lang['nfc_targz'] = "Se debe cargar un archivo tar.gz";
$lang['nfc_limit'] = "Para cargar una configuraci&oacute;n de Nagios, se debe :<ul><li>Especificar al menos los ficheros misccommands.cfg y checkcommands.cfg</li><li>El resto de definiciones pueden estar en cualquier otro archivo.</li><li>Oreon no utiliza las caracter&iacute;sticas de ahorro de tiempo de Nagios</li></ul>";
$lang['nfc_enum'] = "Hosts, servicios, contactos, comandos, escalados, plantillas....";
$lang['nfc_ncfg'] = "Nagios.cfg";
$lang['nfc_rcfg'] = "Resource.cfg";
$lang['nfc_ncfgFile'] = "fichero Nagios.cfg";
$lang['nfc_rcfgFile'] = "fichero Resource.cfg";
$lang['nfc_fileUploaded'] = "Ficheros cargados correctamente";
$lang['nfc_extractComplete'] = "Extracci&oacute;n Completada";
$lang['nfc_unzipComplete'] = "Unzip Completado";
$lang['nfc_unzipUncomplete'] = "Unzip Incompleto";
$lang['nfc_uploadComplete'] = "Carga Completada";

/* profile */

$lang['profile_h_name'] = "Nombre";
$lang['profile_h_contact'] = "Contacto";
$lang['profile_h_location'] = "Localizaci&oacute;n";
$lang['profile_h_uptime'] = "Tiempo activo";
$lang['profile_h_os'] = "Sistema Operativo";
$lang['profile_h_interface'] = "Interficie";
$lang['profile_h_ram'] = "Memoria";
$lang['profile_h_disk'] = "Disco";
$lang['profile_h_software'] = "Software";
$lang['profile_h_update'] = "actualizaci&oacute;n de Windows";
$lang['profile_s_network'] = "Por red";
$lang['profile_s_os'] = "Por sistema operativo";
$lang['profile_s_software'] = "Por software";
$lang['profile_s_update'] = "Por actualizaci&oacute;n de Windows";
$lang['profile_s_submit'] = "buscar";
$lang['profile_o_system'] = "Sistema";
$lang['profile_o_network'] = "Red";
$lang['profile_o_storage'] = "Almacenamiento";
$lang['profile_o_software'] = "Software";
$lang['profile_o_live_update'] = "Actualizaci&oacute;n en vivo";
$lang['profile_h_ip'] = "IP";
$lang['profile_h_speed'] = "Velocidad";
$lang['profile_h_mac'] = "Mac";
$lang['profile_h_status'] = "Estado";
$lang['profile_h_used_space'] = "Espacio utilizado";
$lang['profile_h_size'] = "Tama&ntilde;o";
$lang['profile_h_partition'] = "Partici&oacute;n";
$lang['profile_h_list_host'] = "Seleccione el servidor";
$lang['profile_menu_list'] = "Hosts";
$lang['profile_menu_search'] = "Buscar";
$lang['profile_menu_options'] = "Inventario";
$lang['profile_search_results'] = "Resultados de la b&uacute;squeda";
$lang['profile_title_partition'] = "Partici&oacute;n";
$lang['profile_title_size'] = "Tama&ntilde;o";
$lang['profile_title_used_space'] = "Espacio utilizado";
$lang['profile_title_free_space'] = "Espacio libre";
$lang['profile_error_snmp'] = "El demonio SNMP no parece estar en ejecuci&oacute;n en el Host de destino";

/* db */

$lang['db_cannot_open'] = "No se puede abrir el fichero :";
$lang['db_cannot_write'] = "Imposible escribir en el fichero :";
$lang['db_genesis'] = "Generar ficheros de configuraci&oacute;n";
$lang['db_file_state'] = "Estado actual de los ficheros generados :";
$lang['db_create_backup'] = "Se deber&iacute;a hacer una copia de seguridad antes de crear el nuevo fichero de configuraci&oacute;n";
$lang['db_create'] = "Crear Base de Datos";
$lang['db_generate'] = "Generar";
$lang['db_nagiosconf_backup'] = "Copia de Seguridad de la configuraci&oacute;n de Nagios ";
$lang['db_backup'] = "Copia de Seguridad de todas las bases de datos de Oreon";
$lang['db_nagiosconf_backup_on_server'] = "Copia de Seguridad de la configuraci&oacute;n de Nagios en el servidor.";
$lang['db_backup_spec_users'] = "copia de seguridad la configuraci&oacute;n de usuario ";
$lang['db_insert_new_database'] = "Insertar una nueva base de datos";
$lang['db_reset_old_conf'] = "Cargar una antigua configuraci&oacute;n guardada";
$lang['db_extract'] = "Extraer";
$lang['db_execute'] = "Ejecutar";
$lang['db_save'] = "Guardar";
$lang["DB_status"] = "DataBase Statistics";
$lang["db_lenght"] = "Lenght";
$lang["db_nb_entry"] = "Entries Number";
$lang["db_datafree"] = "Free Data";

/* user */

$lang['u_list'] = "Lista de usuarios";
$lang['u_admin_list'] = "Lista de administradores";
$lang['u_sadmin_list'] = "Lista de super administradores";
$lang['u_user'] = "Usuario";
$lang['u_administrator'] = "Administrador";
$lang['u_sadministrator'] = "Super administrador";
$lang['u_profile'] = "Tu perfil";
$lang['u_new_profile'] = "Nuevo perfil";
$lang['u_some_profile'] = "Perfil para ";
$lang['u_name'] = "Nombre ";
$lang['u_lastname'] = "Apellido ";
$lang['u_login'] = "Usuario ";
$lang['u_passwd'] = "Contrase&ntilde;a ";
$lang['u_cpasswd'] = "Cambiar contrase&ntilde;a";
$lang['u_ppasswd'] = "Confirmar contrase&ntilde;a ";
$lang['u_email'] = "E-mail ";
$lang['u_lang'] = "Idioma escogido ";
$lang['u_status'] = "Estado ";
$lang['u_delete_profile'] = "eliminar este perfil";

/* lang */

$lang['lang_infos'] = "Ya existe ";
$lang['lang_infos2'] = "diferentes idiomas listos para ser utilizados.";
$lang['lang_infos3'] = "Si se desea utilizar uno nuevo se debe cargar un fichero mediante el siguiente formulario";
$lang['lang_detail'] = "Este fichero debe tener los mismos campos que";
$lang['lang_detail2'] = "en el idioma escogido";

/* bug resolver */

$lang['bug_infos'] = "En esta p&aacute;gina se pueden eliminar todas las relaciones entre los recursos y el contenido de la base de datos que puede contener errores si hay un bug.";
$lang['bug_action'] = "Pulsar aqu&iacute; si se quiere resetear la base de datos si se encuentran errores en el paso de test; gracias por reportar el paso en el que fall&oacute;.";
$lang['bug_kick'] = "Resetear";

/* Parseenevlog */

$lang['hours'] = "Horas";

/* Log report */

$lang['add_report'] = "Se ha a&ntilde;adido el informe";
$lang['change_report'] = "Se ha modificado el informe";
$lang['add_reportHost'] = "Se ha a&ntilde;adido un nuevo Host";
$lang['add_reportService'] = "Se ha a&ntilde;adido el Servicio";
$lang['daily_report'] = "Informe diario(escoger formato)";
$lang['report_select_host'] = "seleccionar Host";
$lang['report_select_service'] = "uno de sus servicios (no requerido)";
$lang['report_select_period'] = "seleccionar un per&iacute;odo";
$lang['report_sp'] = "per&iacute;odo de inicio";
$lang['report_ep'] = "per&iacute;odo de fin";
$lang['report_generate_pdf'] = "Generar informe en PDF";
$lang['custom_start_date'] = "fecha de inicio a medida";
$lang['custom_end_date'] = "fecha de fin a medida";
$lang['report_change_host'] = "cambiar Host";
$lang['custom_report'] = "Informe a medida";
$lang['report_color_up'] = "Color OPERATIVO";
$lang['report_color_down'] = "Color INOPERATIVO";
$lang['report_color_unreachable'] = "Color INACCESIBLE";
$lang['report_color_ok'] = "Color OK";
$lang['report_color_warning'] = "Color ADVERTENCIA";
$lang['report_color_critical'] = "Color CR&Iacute;TICO";
$lang['report_color_unknown'] = "Color DESCONOCIDO";
$lang['report_kindof_report'] = "Hay tres tipos de informes";
$lang['report_daily_report'] = "Informe del estado actual de Nagios";
$lang['report_daily_report_explain'] = "Interpreta este fichero :";
$lang['report_daily_report_availability'] = "Disponible en los siguientes formatos :";
$lang['report_spec_info'] = "Informe de informaci&oacute;n espec&iacute;fica";
$lang['report_spec_info_explain'] = "Se puede comprobar inmediatamente un Host o su(s) Servicio(s) asociado(s) de este modo :";
$lang['report_spec_info_ex1'] = "Estado del Host durante determinado per&iacute;odo";
$lang['report_spec_info_ex2'] = "Estado del Servicio durante determinado per&iacute;odo";
$lang['report_spec_info_ex3'] = "Todos los estados de los Servicios asociados a un Host durante un determinado per&iacute;odo";
$lang['available'] = "Disponible en los siguientes formatos :";
$lang['report_cont_info'] = "Informe de continuidad";
$lang['report_cont_info_explain'] = "Utilizado si se quiere obtener informaci&oacute;n en cada intervalo que se haya seleccionado, funciona de este modo :";
$lang['report_cont_info_ex1'] = "notificaci&oacute;n diaria por correo del estado del d&iacute;a anterior de el/los Host(s)/Servicios(s) seleccionados";
$lang['report_cont_info_ex2'] = "notificaci&oacute;n semanal por correo del estado de la semana anterior de el/los Host(s)/Servicios(s) seleccionados";
$lang['report_cont_info_ex3'] = "notificaci&oacute;n mensual por correo del estado del mes anterior de el/los Host(s)/Servicios(s) seleccionados";
$lang['report_logs_explain'] = "Los ficheros de log se reinician cada vez que se apaga Nagios";

/* Traffic Map */

$lang['tm_update'] = "Se ha actualizado el Mapa de Tr&aacute;fico";
$lang['tm_available'] = "Mapa de Tr&aacute;fico disponible";
$lang['tm_add'] = "A&ntilde;adir Mapa de Tr&aacute;fico";
$lang['tm_modify'] = "Modificar Mapa de Tr&aacute;fico";
$lang['tm_delete'] = "Mapa de Tr&aacute;fico eliminado";
$lang['tm_addHost'] = "Se ha a&ntilde;adido un nuevo Host al Mapa de Tr&aacute;fico";
$lang['tm_changeHost'] = "Se ha modificado el Host";
$lang['tm_deleteHost'] = "Se ha eliminado el Host";
$lang['tm_addRelation'] = "Se ha a&ntilde;adido una nueva relaci&oacute;n";
$lang['tm_changeRelation'] = "Se ha modificado la relaci&oacute;n";
$lang['tm_deleteRelation'] = "Se ha eliminado la relaci&oacute;n";
$lang['tm_hostServiceAssociated'] = "Hosts con el servicio check_traffic (comprobaci&oacute;n de tr&aacute;fico) asociado";
$lang['tm_checkTrafficAssociated'] = "Check_traffic asociado";
$lang['tm_other'] = "Otros recursos (sin check_traffic)";
$lang['tm_networkEquipment'] = "Equipamiento de Red";
$lang['tm_selected'] = "seleccionado";
$lang['tm_maxBWIn'] = "M&aacute;ximo ancho de banda posible Entrada (Kbps)";
$lang['tm_maxBWOut'] = "M&aacute;ximo ancho de banda posible de Salida (Kbps)";
$lang['tm_background'] = "Imagen de fondo";

/* Graphs */

$lang['graph'] = "Gr&aacute;fica";
$lang['graphs'] = "Gr&aacute;ficas";
$lang['g_title'] = "Gr&aacute;ficas";
$lang['g_available'] = "Gr&aacute;ficas disponibles";
$lang['g_path'] = "Ruta de la base de datos de RRDtool";
$lang['g_imgformat'] = "Formato de la imagen";
$lang['g_verticallabel'] = "Etiqueta vertical";
$lang['g_width'] = "Tama&ntilde;o de la imagen - anchura";
$lang['g_height'] = "Tama&ntilde;o de la imagen - altura";
$lang['g_lowerlimit'] = "L&iacute;mite inferior";
$lang['g_Couleurs'] = "Colores : ";
$lang['g_ColGrilFond'] = "Color de fondo de la gr&aacute;fica central";
$lang['g_ColFond'] = "Color de fondo";
$lang['g_ColPolice'] = "Color de la tipograf&iacute;a";
$lang['g_ColGrGril'] = "Color de la rejilla principal";
$lang['g_ColPtGril'] = "Color de la rejilla secundaria";
$lang['g_ColContCub'] = "Color del cubo";
$lang['g_ColArrow'] = "Color de la opci&oacute;n de la flecha";
$lang['g_ColImHau'] = "Imagen superior - color";
$lang['g_ColImBa'] = "Imagen inferior - color";
$lang['g_dsname'] = "Nombre del origen de datos";
$lang['g_ColDs'] = "Color del origen de datos";
$lang['g_flamming'] = "Color de las llamas";
$lang['g_Area'] = "&Aacute;rea";
$lang['g_tickness'] = "Grosor";
$lang['g_gprintlastds'] = "Muestra el &uacute;ltimo valor calculado";
$lang['g_gprintminds'] = "Muestra el m&iacute;nimo valor calculado";
$lang['g_gprintaverageds'] = "Muestra la media del valor calculado";
$lang['g_gprintmaxds'] = "Muestra el m&aacute;ximo del valor calculado";
$lang['g_graphorama'] = "GraphsVision";
$lang['g_graphoramaerror'] = "The date of beginning must be lower than the completion date";
$lang['g_date_begin'] = "Hora de inicio";
$lang['g_date_end'] = "Hora de fin";
$lang['g_hours'] = "Horas";
$lang['g_number_per_line'] = "N&uacute;mero por l&iacute;nea";
$lang['g_height'] = "Altura";
$lang['g_width'] = "Anchura";
$lang['g_basic_conf'] = "Configuraci&oacute;n b&aacute;sica :";
$lang['g_ds'] = "Origen de datos";
$lang['g_current'] = "Actual";
$lang['g_lday'] = "&Uacute;ltimo d&iacute;a";
$lang['g_lweek'] = "&Uacute;ltima semana";
$lang['g_lyear'] = "&Uacute;ltimo a&ntilde;o";
$lang['g_see'] = "Ver gr&aacute;fica asociada";
$lang['g_from'] = "De ";
$lang['g_to'] = " A ";
$lang['g_current'] = "Actual:";
$lang['g_average'] = "Media:";
$lang['g_no_graphs'] = "Gr&aacute;ficas indisponibles";
$lang['g_no_access_file'] = "El fichero %s es inaccesible";

/* Graph Models */

$lang['gmod'] =  "Propiedades b&aacute;sicas";
$lang['gmod_ds'] =  "Origen de datos";
$lang['gmod_available'] = "Modelos de propiedades gr&aacute;ficas disponibles";
$lang['gmod_ds_available'] = "Modelos de origen de datos de gr&aacute;ficas disponibles";
$lang['gmod_use_model'] = "Utilizar un modelo";

/* Colors */
$lang['colors'] =  "Colors";
$lang['hexa'] =  "Color in hexadecimal";

/* Nagios.cfg */

$lang['nagios_save'] = "Se ha guardado la configuraci&oacute;n.<br> Se debe reiniciar Nagios para que la nueva configuraci&oacute;n tenga efecto.";

/* Ressources.cfg */

$lang['resources_example'] = "Ejemplo de fichero de recursos";
$lang['resources_add'] = "A&ntilde;adir un nuevo recurso";
$lang['resources_new'] = "Se ha a&ntilde;adido un nuevo recurso";

/* lca */

$lang['lca_user'] = "Usuario :";
$lang['lca_user_access'] = "tiene acceso a ";
$lang['lca_profile'] = "perfil";
$lang['lca_user_restriction'] = "Usuario con restricciones de acceso";
$lang['lca_access_comment'] = "Habilitar acceso a los Comentarios :";
$lang['lca_access_downtime'] = "Habilitar acceso a Inactividad :";
$lang['lca_access_watchlog'] = "Habilitar acceso a ver archivos de log :";
$lang['lca_access_trafficMap'] = "Habilitar acceso a ver el mapa de tr&aacute;fico :";
$lang['lca_access_processInfo'] = "Habilitar acceso a la informaci&oacute;n del proceso :";
$lang['lca_add_user_access'] = "A&ntilde;adir atributos a un usuario";
$lang['lca_apply_restrictions'] = "Aplicar restricciones";
$lang['lca_action_on_profile'] = 'Actions';

/* History */

$lang['log_detail'] = "Detalles del archivo de log para ";

/* General Options */

$lang["opt_gen"] = "Opciones Generales";
$lang["nagios_version"] = "Versi&oacute;n de Nagios : ";
$lang["oreon_path"] = "Directorio de instalaci&oacute;n de Oreon";
$lang["oreon_path_tooltip"] = "Where Oreon is installed ?";
$lang["nagios_path"] = "Directorio de instalaci&oacute;n de Nagios";
$lang["nagios_path_tooltip"] = "Where is Nagios folder ?";
$lang["refresh_interface"] = "Refresco de la interficie";
$lang["refresh_interface_tooltip"] = "Frontend reload frequency";
$lang["snmp_com"] = "Comunidad SNMP";
$lang["snmp_com_tooltip"] = "Default SNMP community";
$lang["snmp_version"] = "Versi&oacute;n de SNMP";
$lang["snmp_path"] = "Directorio de instalaci&oacute;n de SNMP";
$lang["snmp_path_tooltip"] = "Where are snmpwalk and snmpget binary ?";
$lang["cam_color"] = "Colores del Pastel";
$lang["for_hosts"] = "Para Hosts";
$lang["for_services"] = "Para Servicios";
$lang["rrd_path"] = "Ruta de RRDTools/rrdtool";
$lang["rrd_path_tooltip"] = "Where rrdtool is installed ?";
$lang["rrd_base_path"] = "Localizaci&oacute;n ra&iacute;z de RRDTool";
$lang["rrd_base_path_tooltip"] = "Where the rrd databases are generated ?";
$lang["mailer"] = "Servidor de Correo";
$lang["mailer_tooltip"] = "Where mail binary is installed ?";
$lang["opt_gen_save"] = "Opciones generales guardadas.<br>No se necesita generar los ficheros.";
$lang["session_expire"] = "Tiempo de expiraci&oacute;n de sesi&oacute;n";
$lang["session_expire_unlimited"] = "ilimitado";
$lang["binary_path"] = "Ruta de los binarios de Nagios";
$lang["binary_path_tooltip"] = "Where is Nagios binary ?";
$lang["images_logo_path"] = "Ruta de las im&aacute;genes de Nagios";
$lang["images_logo_path_tooltip"] = "Where are Nagios pictures ?";
$lang["plugins_path"] = "Ruta de los Plugins de Nagios";
$lang["plugins_path_tooltip"] = "Where are Nagios plugins installed ?";
$lang["path_error_legend"] = "Color de los errores";
$lang["invalid_path"] = "El directorio o el fichero no existen";
$lang["executable_binary"] = "El fichero no es ejecutable";
$lang["writable_path"] = "No se puede escribir en el directorio o fichero";
$lang["readable_path"] = "The directory is not readable";
$lang["rrdtool_version"] = "Versi&oacute;n de RRDTool";
$lang["sudo_path"] = "Ruta de los binarios de Nmap";
$lang["sudo_path_tooltip"] = "Where is nmap binary ?";

/* Auto Detect */

$lang['ad_title'] = "B&uacute;squeda autom&aacute;tica de Hosts";
$lang['ad_title2'] = "B&uacute;squeda autom&aacute;tica";
$lang['ad_ser_result'] = "La b&uacute;squeda autom&aacute;tica descubri&oacute; los siguientes Servicios : ";
$lang['ad_ser_result2'] = " Esta lista no es exhaustiva y s&oacute;lo incluye<br> las redes de servicio que tienen abierto un puerto de red en el Host.";
$lang['ad_infos1'] = "Para la b&uacute;squeda autom&aacute;tica,<br>rellene los campos con :";
$lang['ad_infos2'] = "Una direcci&oacute;n IP (ex : 192.168.1.45),";
$lang['ad_infos3'] = "Un rango de IP's (ex : 192.168.1.1-254),";
$lang['ad_infos4'] = "Una lista de IP's :";
$lang['ad_infos5'] = "192.168.1.1,24,38";
$lang['ad_infos6'] = "192.168.*.*";
$lang['ad_infos7'] = "192.168.10-34.23-25,29-32";
$lang['ad_ip'] = "IP";
$lang['ad_res_result'] = "Resultado de la b&uacute;squeda";
$lang['ad_found'] = "encontrado(s)";
$lang['ad_number'] = "N&uacute;mero";
$lang['ad_dns'] = "DNS";
$lang['ad_actions'] = "Acciones";
$lang['ad_port'] = "Puerto";
$lang['ad_name'] = "Nombre";

/* Export DB */

$lang['edb_file_already_exist'] = "El fichero ya existe, introduzca un nombre diferente para la copia de seguridad";
$lang['edb_file_move'] = "Ficheros movidos";
$lang['edb_file_ok'] = "Ficheros generados y movidos";
$lang['edb_file_nok'] = "Error durante la generaci&oacute;n o el cambio de ubicaci&oacute;n de los ficheros";
$lang['edb_restart'] = "Reinicio del Host";
$lang['edb_save'] = "Hacer una copia de seguridad";
$lang['edb_nagios_restart'] = "Reiniciar Nagios";
$lang['edb_nagios_restart_ok'] = "Nagios reiniciado";
$lang['edb_restart'] = "Reiniciar";

/* User_online */

$lang["wi_user"] = "Usuarios";
$lang["wi_where"] = "Localizaci&oacute;n";
$lang["wi_last_req"] = "&Uacute;ltima petici&oacute;n";

/* Reporting */

$lang["pie_unavailable"] = "Pastel no disponible en este momento";

/* Configuration Stats */

$lang['conf_stats_category'] = "Categor&iacute;a";

/* Pictures */

$lang["pict_title"] = "Im&aacute;genes de Informaci&oacute;n Extendida de Oreon";
$lang["pict_new_image"] = "Nueva imagen (s&oacute;lo .png)";

/* About */

$lang["developped"] = "Desarrollado por";

/* Live Report */

$lang["lr_available"] = "Hosts Disponibles";
$lang["live_report"] = "Informes en vivo";
$lang["bbreporting"] = "Informes";
$lang["lr_host"] = "Host :";
$lang["lr_alias"] = "Alias :";
$lang["lr_ip"] = "Direcci&oacute;n IP :";
$lang["lr_view_services"] = "Ver los detalles de los Servicios para el Host";
$lang["lr_configure_host"] = "Configurar el Host";
$lang["lr_details_host"] = "Ver la informaci&oacute;n del Host";

/* Date and Time Format */

$lang["date_format"] = "A/m/d";
$lang["time_format"] = "H:m:s";
$lang["header_format"] = "A/m/d G:i";
$lang["date_time_format"] = "A/m/d - H:m:s";
$lang["date_time_format_status"] = "A/m/d H:m:s";
$lang["date_time_format_g_comment"] = "A/m/d H:m";

/* */

$lang["top"] = "Arriba";
$lang["event"] = "Eventos";
$lang["date"] = "Fecha";
$lang["pel_l_details"] = "Detalles del fichero de log para ";
$lang["pel_sort"] = "Filtros";
$lang["pel_alerts_title"] = "Alerts for ";
$lang["pel_notify_title"] = "Notifications for ";

/* PHPRADMIN */

$lang['generated'] = "Página generada en";

?>