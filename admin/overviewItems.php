<?php
require_once('../class.da.tinekeDA.php');

$itemDa = new tinekeDA();

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
    

    <title>Kariboeni PopUp Store - Admin</title>

    <!-- Bootstrap core CSS -->
    <link href="../../css/bootstrap.min.css" rel="stylesheet">

    <link href="css/admin.css" rel="stylesheet">
  </head>
<body>

<script type="text/javascript">
$(document).ready(function () {
  $('.nav li').removeClass('active');
  $('#items').addClass('active');
});
</script>

  <?php require_once("adminHeader.php"); ?>
  <div class="container mainContainer">

    <h1>Overzicht verkochtte items</h1>
<table class="table">
<?php 
$itemResult = $itemDa->query("SELECT biedingen.naamBieder,biedingen.klas,biedingen.telefoon,biedingen.email,items.titel,items.beschrijving,items.prijs, categories.categoryName, items.itemId FROM biedingen LEFT JOIN items ON items.itemId = biedingen.itemId LEFT JOIN categories ON items.catId = categories.catId");
$itemResult->setFetchMode(PDO::FETCH_ASSOC);
$itemResult->bindColumn(1, $naamBieder);
$itemResult->bindColumn(2, $klas);
$itemResult->bindColumn(3, $telefoon);
$itemResult->bindColumn(4, $email);
$itemResult->bindColumn(5, $titel);
$itemResult->bindColumn(6, $beschrijving);
$itemResult->bindColumn(7, $prijs);
$itemResult->bindColumn(8, $catNaam);
$itemResult->bindColumn(9, $itemId);
while($itemResult->fetch()) {
  ?>
  <tr>
   <td>
    <a href="#modal-<?php echo $itemId; ?>" data-toggle="modal">
    <?php 
   echo $titel."</a>";
   if($beschrijving != "" && $beschrijving != " ") {
    echo " (".$beschrijving.")";
   } ?>
   </td>
   <td>€<?php echo $prijs; ?></td>
   <td><?php echo $naamBieder; ?></td>
  </tr>

  <div class="modal fade" id="modal-<?php echo $itemId; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title" id="myModalLabel"><?php echo $titel; ?></h4>
      </div>
      <div class="modal-body">
        <?php echo $beschrijving; ?>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>
  <?php
}

?>
</table>
</div>

</body>
</html>