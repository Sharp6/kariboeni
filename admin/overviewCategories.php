<?php
require_once('../class.da.tinekeDA.php');

$categoryNames = array();
$categoryIncomes = array();
$categoryItems = array();
$categoryPotentials = array();
$categoryNumberOfSoldItems = array();

$catDa = new tinekeDA();

$catResult = $catDa->query("SELECT categoryId, categoryName FROM categories");
$catResult->setFetchMode(PDO::FETCH_ASSOC);
$catResult->bindColumn(1, $catId);
$catResult->bindColumn(2, $catName);
while($catResult->fetch()) {
	$categoryNames[$catId] = $catName;
}

$itemsResult = $catDa->query("SELECT categoryId, count(*), SUM(prijs) FROM items GROUP BY categoryId");
$itemsResult->setFetchMode(PDO::FETCH_ASSOC);
$itemsResult->bindColumn(1, $catId);
$itemsResult->bindColumn(2, $numItems);
$itemsResult->bindColumn(3, $catPotential);
while($itemsResult->fetch()) {
	$categoryItems[$catId] = $numItems;
  $categoryPotentials[$catId] = $catPotential;
}

$itemResult = $catDa->query("SELECT items.categoryId,COUNT(*), SUM(items.prijs) FROM biedingen LEFT JOIN items ON items.itemId = biedingen.itemId GROUP BY items.categoryId");
$itemResult->setFetchMode(PDO::FETCH_ASSOC);
$itemResult->bindColumn(1, $catId);
$itemResult->bindColumn(2, $catItemsSold);
$itemResult->bindColumn(3, $catIncome);
while($itemResult->fetch()) {
  $categoryIncomes[$catId] = $catIncome;
  $categoryNumberOfSoldItems[$catId] = $catItemsSold;
}

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" href="../../assets/ico/favicon.ico">

    <script src="../../js/jquery-2.1.1.min.js"></script>
    <script src="../../js/bootstrap.min.js"></script>
    <script src="js/chart.js"></script>


    <title>Kariboeni PopUp Store - Admin</title>

    <!-- Bootstrap core CSS -->
    <link href="../../css/bootstrap.min.css" rel="stylesheet">

    <link href="css/admin.css" rel="stylesheet">
  </head>
<body>

<script type="text/javascript">
$(document).ready(function () {
  $('.nav li').removeClass('active');
  $('#categories').addClass('active');
});
</script>

  <?php require_once("adminHeader.php"); ?>
  <div class="container mainContainer">

    <h1>Overzicht volgens categorie</h1>
<div class="panel-group" id="categoryAccordion">

<?php
foreach($categoryNames as $id => $name) {
	?>

  <div class="panel panel-default">
    <div class="panel-heading">
      <h4 class="panel-title">
        <a data-toggle="collapse" data-parent="#categoryAccordion" href="#catPanel<?php echo $id; ?>">
	  <?php echo $name; ?>
	  <span class="badge">Totaal: <?php if(isset($categoryItems[$id])){ echo $categoryItems[$id]; } else { echo "0"; } ?></span>
    <span class="badge">Verkocht: <?php if(isset($categoryNumberOfSoldItems[$id])){ echo $categoryNumberOfSoldItems[$id]; } else { echo "0"; } ?></span>
	</a>
      </h4>
    </div>
    <div id="catPanel<?php echo $id; ?>" class="panel-collapse collapse">
      <div class="panel-body">
        <p>De totale prijs van de <?php if(isset($categoryItems[$id])){ echo $categoryItems[$id]; } else { echo "0"; } ?> items uit deze categorie is <?php if(isset($categoryPotentials[$id])){ echo $categoryPotentials[$id]; } else { echo "0"; } ?> euro.</p>
        <p>Het inkomen van de <?php if(isset($categoryNumberOfSoldItems[$id])){ echo $categoryNumberOfSoldItems[$id]; } else { echo "0"; } ?> verkochtte items van deze categorie is <?php if(isset($categoryIncomes[$id])){ echo $categoryIncomes[$id]; } else { echo "0"; } ?> euro.
      </div>
    </div>
  </div>

	<?php
}

?>

</div> <!-- Einde accordion //-->

<div>
  <canvas id="categoryChart" width="400" height="400"></canvas>
</div>
</div>

<script>
<?php
echo "var labelList = [";
$catNames="";
foreach($categoryNames as $id => $name) {
  $catNames .= "'".$name."',";
}
echo trim($catNames,",");
echo "];";
?>
(function() {
  <?php
  echo "var labelList = [";
  $catNames="";
  foreach($categoryNames as $id => $name) {
    $catNames .= "'".$name."',";
  }
  echo trim($catNames,",");
  echo "];";

  echo "var opbrengstData = [";
  $opbrengsten="";
  foreach($categoryNames as $id => $name) {
    if(isset($categoryIncomes[$id])){ 
      $opbrengsten .= $categoryIncomes[$id]; 
    } else { 
      $opbrengsten .= "0"; 
    }
    $opbrengsten .= ",";
  }
  echo trim($opbrengsten,",");
  echo "];";
  ?>
  var catData = {
    labels: labelList,
    datasets: [
      {
        label: "Opbrengst per categorie",
        fillColor: "rgba(220,220,220,0.5)",
        strokeColor: "rgba(220,220,220,0.8)",
        highlightFill: "rgba(220,220,220,0.75)",
        highlightStroke: "rgba(220,220,220,1)",
        data: opbrengstData
      }

    ]
  };

  var ctx = $("#categoryChart").get(0).getContext("2d");
  var myCatChart = new Chart(ctx).Bar(catData,{scaleShowGridLines:true});

})();

</script>
</body>
</html>