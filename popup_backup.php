<?php require_once("header.php"); ?>
<script type="text/javascript">
$(document).ready(function () {
	$('.nav li').removeClass('active');
    $('#popup').addClass('active');
});
</script>
<h1>Pop-Up Store</h1>

Alle categorieen.

<?php
$catDa = new tinekeDA();
$catResult = $catDa->query("SELECT categoryId, categoryName FROM categories");
$numberOfRows = $catResult->rowCount();
$catResult->setFetchMode(PDO::FETCH_ASSOC);
$catResult->bindColumn(1, $catId);
$catResult->bindColumn(2, $catName);

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
		<div class="category col-md-4">
		<?php
	}
	?>
		<div class="jm-item first">
			<div class="jm-item-wrapper">
				<div class="jm-item-image">
					<img src="img/categories/<?php echo $catId; ?>.jpg" class="itemImage notSold" />
					<span class="jm-item-overlay"> </span>
					<div class="jm-item-button notSold"><a href="aCategory.php?categoryId=<?php echo $catId; ?>" class="btn btn-default">Bekijk <?php echo $catName; ?></a></div>
				</div>
				<div class="jm-item-title"><?php echo $catName; ?></div>
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