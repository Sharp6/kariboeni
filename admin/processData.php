<?php
require_once('class.da.tinekeDA.php');

$myDa = new tinekeDA();

$columns = array();
$rs = $myDa->query('SELECT * FROM items LIMIT 0');
for ($i = 0; $i < $rs->columnCount(); $i++) {
	$col = $rs->getColumnMeta($i);
    $columns[] = $col['name'];
}


$fieldList = "";
$valueList = "";

foreach($columns as $column) {
	if($column != 'itemId') {
		$fieldList .= $column.",";
		$valueList .= "'".$_POST[$column]."',";
	}
}

$fieldList = rtrim($fieldList,",");
$valueList = rtrim($valueList,",");

$insertQ = "INSERT INTO items($fieldList) VALUES($valueList);";

$myDa->execute($insertQ);

$idR = $myDa->query("SELECT max(itemId) FROM items");


$idR->setFetchMode(PDO::FETCH_ASSOC);
$idR->bindColumn(1, $maxId);
$idR->fetch();

copy($_POST['imgUrl'], "../img/".$maxId.".jpg");
unlink($_POST['imgUrl']);

echo "Het item met ID " . $maxId . " werd toegevoegd in de databank.";

?>
