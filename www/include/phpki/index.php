<?php

include('./config.php');
include(STORE_DIR.'/config/config.php');
include('./include/common.php');
include('./include/my_functions.php');

$stage = gpvar('stage');

switch($stage) {

case 'dl_root':
	upload("$config[cacert_pem]", "$config[ca_prefix]cacert.crt", 'application/x-x509-ca-cert');
	break;

case 'dl_crl':
	upload("$config[cacrl_der]", "$config[ca_prefix]cacrl.crl", 'application/pkix-crl');
	break;

default:
	printHeader('public');

	?>
	<br>
	<br>
	<center>
	<table class=menu width=500><th class=menu colspan=2><big>PUBLIC CONTENT MENU<big></th>
	
	<tr><td style="text-align: center; vertical-align: middle; font-weight: bold;" width=35%>
	<a href=search.php>Search for a Certificate</a></td>
	<td>This option allows you to find another member's e-mail address and download her public 
	digital certificate so that you may send encrypted messages to her.</td></tr>
	
	<tr><td style="text-align: center; vertical-align: middle; font-weight: bold;">
	<a href=<?=$PHP_SELF?>?stage=dl_root>Download Our Root Certificate</a></td>
	<td>You must download and install our "Root" certificate before you can use any of the 
	certificates issued here. <a href=help.php target=_help>Read the online help</a> 
	documentation to learn more about this.</td></tr>
	
	<tr><td style="text-align: center; vertical-align: middle; font-weight: bold;">
	<a href=<?=$PHP_SELF?>?stage=dl_crl>Download Our Certificate Revocation List</a></td>
	<td>The official list of certificates which have been revoked by this site. 
	Installation and use of this list is optional. Some e-mail programs will check this list 
	for you automagically. </td></tr>
	
	</table>
	</center>
	<br><br>
	<?

	printFooter();
}

?>
