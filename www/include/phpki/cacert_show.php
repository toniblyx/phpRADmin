<?php


include('./config.php');
include('./include/my_functions.php');
include('./include/common.php');

?>
<style type="text/css">
<!--
.styleca {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-weight: bold;
}
.style3 {color: #0000FF}
.style4 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 12px; }
.style5 {font-family: "Courier New", Courier, monospace; font-size: 12px; }
.style7 {font-family: Verdana, Arial, Helvetica, sans-serif; font-weight: bold; font-size: 12px; }
-->
</style>


<center>
<span class="style7">CA Certificate</span>
<p class="style4">Copy and paste to a cacert.pem file as your needs. Remember to include <span class="style3">-----BEGIN CERTIFICATE-----</span> and <span class="style3">-----END CERTIFICATE-----</span> tags.</p>
<form>
<textarea name=cacert cols=70 rows=24 readonly class="style5">
<?
readfile("../conf/phpki-store/CA/certs/cacert.pem");
?>
</textarea>
</form>
</center>
<p>


