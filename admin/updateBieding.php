<?php
require_once('class.da.tinekeDA.php');

$myDa = new tinekeDA();

$itemId = $_POST["itemId"];

if(isset($_POST["betaald-".$itemId])) {
	if($_POST["betaald-".$itemId] == on) {
		$betaald = 1;
	} else {
		$betaald = 0;
	}	
} else {
	$betaald = 0;
}

$q = "UPDATE biedingen SET betaald = '".$betaald."', opmerking = '".$_POST["opmerkingen-".$itemId]."' WHERE itemId = '".$itemId."'";
echo $myDa->execute($q);

?>