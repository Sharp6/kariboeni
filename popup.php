<?php require_once("header.php"); ?>
<script type="text/javascript">
$(document).ready(function () {
	$('.nav li').removeClass('active');
    $('#popup').addClass('active');
});
</script>
<h1>Pop-Up Store</h1>

<?php
$catDa = new tinekeDA();
$catResult = $catDa->query("SELECT categoryId, categoryName, beschrijving FROM categories");
$numberOfRows = $catResult->rowCount();
$catResult->setFetchMode(PDO::FETCH_ASSOC);
$catResult->bindColumn(1, $catId);
$catResult->bindColumn(2, $catName);
$catResult->bindColumn(3, $beschrijving);

$rowCounter = 0;
$counter = 0;
while($catResult->fetch()){
	$counter++;
	$rowCounter++;
    if($rowCounter == 4) {
        $rowCounter = 1;
    }
    if($rowCounter == 1){
        ?>
        <div class="row">
        <?php
    }
	
	if((($numberOfRows - $counter) < 2) && (($numberOfRows % 3) == 2)) {
		?>
		<div class="category col-md-6">
		<?php
	} else {
		?>	
		<div class="category col-md-4 col-sm-6">
		<?php
	}
	?>

    <div class="thumbnail">
      <img src="img/categories/<?php echo $catId; ?>.jpg" class="catImg" />
      <div class="caption">
        <h3><?php echo $catName; ?></h3>
        <?php if(isset($beschrijving)) {
        	echo "<p>".$beschrijving."</p>";
        }
        ?>
        <p><a href="aCategory.php?categoryId=<?php echo $catId; ?>" class="btn btn-default">Bekijk <?php echo $catName; ?></a></p>
      </div>
    </div>
	</div>

	<?php
    if($rowCounter == 3){
	    ?>
        </div>
        <?php
    }
    ?>
<?php
}
?>

<?php require_once("footer.php"); ?>