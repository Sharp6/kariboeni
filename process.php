<?php
require_once('class.da.tinekeDA.php');

$myDa = new tinekeDA();

$columns = array();
$rs = $myDa->query('SELECT * FROM biedingen LIMIT 0');
for ($i = 0; $i < $rs->columnCount(); $i++) {
	$col = $rs->getColumnMeta($i);
    $columns[] = $col['name'];
}

$fieldList = "";
$valueList = "";

foreach($columns as $column) {
	if($column != 'biedingId') {
		if(isset($_POST[$column])) {
			$fieldList .= $column.",";
			$valueList .= "'".$_POST[$column]."',";
		}
	}
}

$fieldList = rtrim($fieldList,",");
$valueList = rtrim($valueList,",");

// TODO: controleer eerst of dit item nog niet verkocht is.
$uq = "SELECT * FROM biedingen WHERE itemId = '".$_POST["itemId"]."'";
$uniquenessResult = $myDa->query($uq);

if($uniquenessResult->rowCount() == 0) {
	$insertQ = "INSERT INTO biedingen($fieldList) VALUES($valueList);";
	echo $myDa->execute($insertQ);
} else {
	echo "Dit item werd reeds verkocht. Heeft u misschien reeds op de 'Plaats bestelling'-knop geduwd? Neem voor een bevestiging contact op met de beheerder van de website.";
}



?>
