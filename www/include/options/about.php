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
	if (!isset($oreon))
		exit();
?>
<table border="0">
	<tr>
		<td align="left">
			<div style="margin-bottom:15px;"><font class='text12b'>phpRADmin Version <? include "./include/version/version.php"; ?></font></div>

			<div class="tabTableTitle">&nbsp;&nbsp;&nbsp;phpRADmin coreteam</div>
			<div class="tabTableHome">
			<ul>
				<li><a href="mailto:toni@blyx.com" class="text10">Toni de la Fuente
				    (blyx) </a></li>
			</ul>
			</div>
			<ul>
			  <p>I have used   <strong>Oreon</strong> code as framework,<br />
			  <strong>Dialup Admin</strong> to manage users/clients, <br />
			  <strong>PHPKI</strong> to manage certs and <br />
			  <strong>phpconfig</strong> (from <a href="http://www.voip-info.org/wiki/index.php?page=Asterisk+gui+phpconfig">Asterisk</a> project) to edit some files. </p>
			  <p>Thanks to the <strong>Free Software</strong> world.</p>
			  <p>Thanks	to dmescal,	vaquer0,	dmartin, syvic, drico for their support. </p>
			</ul>
			<div class="tabTableTitle" style="margin-top:12px;">&nbsp;&nbsp;&nbsp;Oreon</div>
		    <div class="tabTableHome">
				A web based administration interface for Nagios <br />
				monitoring server written in PHP<br />
			<ul>
				Authors:				  <br />
				<li><a href="http://www.oreon-project.org" class="text10">Thanks to Oreon
				    Project</a></li>
				<li><a href="mailto:ccoraboeuf@oreon.org" class="text10">Christophe Coraboeuf
				    (Wistof)</a></li>
				<li><a href="mailto:jmathis@oreon.org" class="text10">Julien Mathis (Julio)</a></li>
				<li><a href="mailto:rlemerlus@oreon.org" class="text10">Romain Le Merlus (rom)</a></li>
			</ul>
			</div>
			<div class="tabTableTitle" style="margin-top:12px;">&nbsp;&nbsp;&nbsp;Dialup Admin</div>
		    <div class="tabTableHome">
				A web based administration interface for the FreeRADIUS <br />
				radius server written in PHP4<br />
				Copyright (C) 2001,2002 Kostas Kalevras<br />
			<ul>
				Authors:				  <br />
				<li><a href="http://www.freeradius.org" class="text10">Thanks to FreeRADIUS
				    Project</a></li>
				<li>Kostas Kalevras (kkalev at noc.ntua.gr)</li>			  
				<li>Basilis Pappas (vpappas at noc.ntua.gr)</li>
				<li>Panagiotis Christias (christia at noc.ntua.gr)</li>
				<li>Thanasis Duitsis (aduitsis at noc.ntua.gr)</li>
			</ul>
	        </div>
			<div class="tabTableTitle" style="margin-top:12px;">&nbsp;&nbsp;&nbsp;PHPKI</div>
		    <div class="tabTableHome">
				A web based administration interface for OpenSSL <br />
				to manage a CA server written in PHP<br />
			<ul>
				Authors:				  <br />
				<li><a href="http://phpki.sourceforge.org" class="text10">Thanks to PHPKI
				    Project</a></li>
				<li>Eddie Roadcap (eddie at chazbear.com)</li>			  
			</ul>
	        </div>
		</td>
	</tr>
</table>
