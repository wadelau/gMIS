<?php
# extra name and function 
# wadelau@ufqi.com on Sun Jan 31 10:22:15 CST 2016
#

require("../comm/header.inc.php");


$gtbl = new GTbl($tbl, array(), $elementsep);

include("../comm/tblconf.php");

# main actions



print $out;

$out = "";
$isoput = false;

require("../comm/footer.inc.php");


?>
