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

  $(".saveBtn").click(function(){
        var myModal = $(this).closest('.modal-content');
        
        $.ajax({
            type: "POST",
            url: "updateBieding.php",
            data: myModal.find('form').serialize(),
            success: function(msg){
                myModal.find('div.submitResult').html(msg); 
                myModal.find('div.submitResult').addClass('alert-success');
            },
            error: function(){
                alert("failure during ajax.");
            }
        });
    });

});
</script>

  <?php require_once("adminHeader.php"); ?>
  <div class="container mainContainer">

    <h1>Overzicht verkochte items - <?php echo date('d M Y'); ?></h1>
<table class="table">
<?php 
$itemResult = $itemDa->query("SELECT biedingen.naamBieder,biedingen.klas,biedingen.telefoon,biedingen.email,items.titel,items.beschrijving,items.prijs, categories.categoryName, items.itemId, biedingen.betaald, biedingen.opmerking, biedingen.typeKoper, biedingen.contactLeerling FROM biedingen LEFT JOIN items ON items.itemId = biedingen.itemId LEFT JOIN categories ON items.categoryId = categories.categoryId");
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
$itemResult->bindColumn(10, $betaald);
$itemResult->bindColumn(11, $opmerking);
$itemResult->bindColumn(12, $typeKoper);
$itemResult->bindColumn(13, $contactLeerling);

$inKas = 0;
$opbrengst = 0;

while($itemResult->fetch()) {
  if($betaald == 1) {
    $inKas += $prijs;
  }
  $opbrengst += $prijs;
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
   <td><?php if($betaald == 1) {echo "<span class='badge'>betaald</span>";} ?></td>
  </tr>

  <div class="modal fade" id="modal-<?php echo $itemId; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title" id="myModalLabel"><?php echo $titel; ?></h4>
      </div>
      <div class="modal-body">
        <h3>Status verkoop</h3>
        <form class="form-horizontal" id="<?php echo $itemId; ?>Form">
          <input type="hidden" id="itemId" name="itemId" value="<?php echo $itemId; ?>" />
          <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
              <div class="checkbox">
                <label>
                  <input name="betaald-<?php echo $itemId; ?>" id="betaald-<?php echo $itemId; ?>" type="checkbox" <?php if($betaald == 1) { echo " checked";} ?>> Afgehaald en betaald
                </label>
              </div>
            </div>
          </div>

          <div class="form-group">
            <label for="opmerkingen-<?php echo $itemId; ?>" class="col-sm-2 control-label">Opmerkingen</label>
            <div class="col-sm-10"> 
              <textarea class="form-control" rows="3" name="opmerkingen-<?php echo $itemId; ?>" id="opmerkingen-<?php echo $itemId; ?>"><?php echo $opmerking; ?></textarea>
            </div>
          </div>
        </form>
        <h3>Details koper</h3>
        <p><b>Type koper: </b><?php echo $typeKoper; ?></p>
        <p><b>Naam: </b><?php echo $naamBieder; ?></p>
        <?php
        if($contactLeerling != "" && $contactLeerling != " ") {
         echo "<p><b>Contactleerling: </b>".$contactLeerling."</p>";  
        }
        ?>
        <p><b>Klas: </b><?php echo $klas; ?></p>
        <p><b>Telefoon: </b><?php echo $telefoon; ?></p>
        <p><b>Email: </b><?php echo $email; ?></p>

        <h3>Details item</h3>
        <p><b>Prijs: </b>€<?php echo $prijs; ?></p>
        <p><b>Beschrijving: </b><?php echo $beschrijving; ?></p>
        <p><b>Categorie: </b><?php echo $catNaam; ?></p>
        <p><img src="../img/<?php echo $itemId; ?>.jpg" class="itemImg" /></p>
        <div class="submitResult"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary saveBtn">Save changes</button>
      </div>
    </div>
  </div>
</div>
  <?php
}

?>
</table>

<p>
De totale opbrengst is €<?php echo $opbrengst;?>. Er zit momenteel €<?php echo $inKas; ?> in kas. 
  </p>
</div>

</body>
</html>