<?
/**
Oreon is developped with GPL Licence 2.0 :
http://www.gnu.org/licenses/gpl.txt
Developped by : Christophe Coraboeuf

The Software is provided to you AS IS and WITH ALL FAULTS.
OREON makes no representation and gives no warranty whatsoever,
whether express or implied, and without limitation, with regard to the quality,
safety, contents, performance, merchantability, non-infringement or suitability for
any particular or intended purpose of the Software found on the OREON web site.
In no event will OREON be liable for any direct, indirect, punitive, special,
incidental or consequential damages however they may arise and even if OREON has
been previously advised of the possibility of such damages.

For information : contact@oreon.org
*/

function Create_oreon_pm_conf(& $oreon, $path)
{
	/*[GLOBAL]
		DIR_OREON=/data/apachedata/oreon
		DIR_TRAFFICMAP=/data/apachedata/oreon/include/trafficMap/average
		DIR_NAGIOS=/data/nagios
		DIR_RRDTOOL=/usr/local/rrdtool/lib/perl
		DIR_RRDTOOL_LIB=/usr/local/rrdtool/lib/perl
		NAGIOS_LIBEXEC=/data/nagios/libexec
		NAGIOS_ETC=/data/nagios/etc
	*/
		$file = $path ."oreon.conf" ;
		if ( !is_file($file)) {
			$handle = fopen($file, 'w');
			fclose($handle);
		}

	    $Nagioscfg = & $oreon->Nagioscfg;
		// We first read conf file
		$ini = readINIfile ($file, ";");
		// We modify [GLOBAL] section
		if ($oreon->optGen->get_nagios_pwd()){$ini["GLOBAL"]["DIR_NAGIOS"] = $oreon->optGen->get_nagios_pwd();}
	    if ($oreon->optGen->get_oreon_pwd()){$ini["GLOBAL"]["DIR_OREON"] = $oreon->optGen->get_oreon_pwd() ;}
	    if ($oreon->optGen->get_plugins_path()){$ini["GLOBAL"]["NAGIOS_LIBEXEC"] = $oreon->optGen->get_plugins_path() ;}
	    if ($Nagioscfg->cfg_pwd){$ini["GLOBAL"]["NAGIOS_ETC"] = $Nagioscfg->cfg_pwd ;}
	    if ($oreon->optGen->get_rrd_base_pwd()){$ini["GLOBAL"]["DIR_RRDTOOL"] = $oreon->optGen->get_rrd_base_pwd() ;}
	    if ($Nagioscfg->cfg_pwd){$ini["GLOBAL"]["DIR_RRDTOOL_LIB"] = $Nagioscfg->cfg_pwd ;}

		// We write conf file
		writeINIfile( $file ,$ini , "", "");

}


/*
Function to replace PHP's parse_ini_file() with much fewer restritions, and
a matching function to write to a .INI file, both of which are binary safe.

Version 1.0

Copyright (C) 2005 Justin Frim <phpcoder@cyberpimp.pimpdomain.com>

Sections can use any character excluding ASCII control characters and ASCII
DEL.  (You may even use [ and ] characters as literals!)

Keys can use any character excluding ASCII control characters, ASCII DEL,
ASCII equals sign (=), and not start with the user-defined comment
character.

Values are binary safe (encoded with C-style backslash escape codes) and may
be enclosed by double-quotes (to retain leading & trailing spaces).

User-defined comment character can be any non-white-space ASCII character
excluding ASCII opening bracket ([).

readINIfile() is case-insensitive when reading sections and keys, returning
an array with lower-case keys.
writeINIfile() writes sections and keys with first character capitalization.
Invalid characters are converted to ASCII dash / hyphen (-).  Values are
always enclosed by double-quotes.

writeINIfile() also provides a method to automatically prepend a comment
header from ASCII text with line breaks, regardless of whether CRLF, LFCR,
CR, or just LF line break sequences are used!  (All line breaks are
translated to CRLF)

Modified for Oreon by Christophe Coraboeuf
*/


function readINIfile ($filename, $commentchar) {
  $array1 = file($filename);
  $section = '';
  foreach ($array1 as $filedata) {
   $dataline = trim($filedata);
   $firstchar = substr($dataline, 0, 1);
   if ($firstchar!=$commentchar && $dataline!='') {
     //It's an entry (not a comment and not a blank line)
     if ($firstchar == '[' && substr($dataline, -1, 1) == ']') {
       //It's a section
       $section = strtoupper(substr($dataline, 1, -1));
     }else{
       //It's a key...
       $delimiter = strpos($dataline, '=');
       if ($delimiter > 0) {
         //...with a value
         $key = strtoupper(trim(substr($dataline, 0, $delimiter)));
         $value = trim(substr($dataline, $delimiter + 1));
         if (substr($value, 0, 1) == '"' && substr($value, -1, 1) == '"') { $value = substr($value, 1, -1); }
         $array2[$section][$key] = stripcslashes($value);
       }else{
         //...without a value
         $array2[$section][strtoupper(trim($dataline))]='';
       }
     }
   }else{
     //It's a comment or blank line.  Ignore.
   }
  }
  return $array2;
}

function writeINIfile ($filename, $array1, $commentchar, $commenttext) {
  $handle = fopen($filename, 'wb');
  if ($commenttext!='') {
   $comtext = $commentchar.
     str_replace($commentchar, "\r\n".$commentchar,
       str_replace ("\r", $commentchar,
         str_replace("\n", $commentchar,
           str_replace("\n\r", $commentchar,
             str_replace("\r\n", $commentchar, $commenttext)
           )
         )
       )
     )
   ;
   if (substr($comtext, -1, 1)==$commentchar && substr($comtext, -1, 1)!=$commentchar) {
     $comtext = substr($comtext, 0, -1);
   }
   fwrite ($handle, $comtext."\r\n");
  }
  foreach ($array1 as $sections => $items) {
   //Write the section
   if (isset($section)) { fwrite ($handle, "\r\n"); }
   //$section = ucfirst(preg_replace('/[\0-\37]|[\177-\377]/', "-", $sections));
   $section = strtoupper(preg_replace('/[\0-\37]|\177/', "-", $sections));
   fwrite ($handle, "[".$section."]\r\n");
   foreach ($items as $keys => $values) {
     //Write the key/value pairs
     $key = strtoupper(preg_replace('/[\0-\37]|=|\177/', "-", $keys));
     if (substr($key, 0, 1)==$commentchar) { $key = '-'.substr($key, 1); }
   //  if (substr($values, 0, 1) == '"' && substr($values, -1, 1) == '"') { $values = substr($values, 1, -1); }
     $value = ucfirst(addcslashes($values,''));
     fwrite ($handle, '    '.$key.'='.$value."\r\n");
   }
  }
  fclose($handle);
}






?>