<?php
require_once('../class.da.tinekeDA.php');
$myDa = new tinekeDA();
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

    <!-- Cropper CSS and JS -->
    <link  href="cropper/src/cropper.css" rel="stylesheet">
    <link rel="stylesheet" href="cropper/src/crop-avatar.css">

    <link href="css/admin.css" rel="stylesheet">

    </head>

  <body>

<script type="text/javascript">  
$(document).ready(function(){
	var $image = $(".bootstrap-modal-cropper img"),
    originalData = {};


    $(".saveBtn").click(function(){    
        $.ajax({
            type: "POST",
            url: "processData.php",
            data: $("#newItemForm").serialize() + "&imgUrl=" + $('#itemPicture').attr("src"),
            success: function(msg){
            	$('div#submitResult').html(msg);  
            	/*
                if(msg == 1) {
                    $('div#submitResult').html("Uw bestelling werd succesvol doorgegeven. Bedankt!");    
                } 
                */                       
            },
            error: function(){
                alert("failure");
            }
        });
    });    

    $('.nav li').removeClass('active');
    $('#voegToe').addClass('active');
});   
</script>
    <?php require_once("adminHeader.php"); ?>
  	<div class="container mainContainer">
  		<h1>Items toevoegen</h1>
      <p>
        Op deze pagina kunnen items toegevoegd worden aan de Kariboeni Popup Store. 
        De meeste gegevens worden in de voorziene velden ingevuld. 
        De categorie kan uit een lijst gekozen worden. 
        De foto kan worden aangepast door op de foto te klikken. 
        Een venster verschijnt dan waar een nieuwe foto geupload kan worden.
        Met het selectievenster kan een vierkante selectie gemaakt worden. 
        Klik in dat venster op save om de foto te selecteren.

        Eens alle gegevens in orde zijn, kunnen ze in de databank worden opgeslagen door op de knop "bewaar gegevens" te klikken.
        Als alles gelukt is, krijgt u hiervan een melding onder die knop.
      </p>
  		<form class="form-horizontal" id="newItemForm">
  			<?php 
            // Get all column names for items tabel
            $columns = array();
            $rs = $myDa->query('SELECT * FROM items LIMIT 0');
            for ($i = 0; $i < $rs->columnCount(); $i++) {
            	$col = $rs->getColumnMeta($i);
				$columns[] = $col['name'];
			}
			foreach($columns as $column) {
            	if($column != "itemId" && $column != "categoryId") {
            	?>
            		<div class="form-group">
                    	<label for="<?php echo $column; ?>" class="control-label col-xs-3"><?php echo $column; ?></label>
                      	<div class="col-xs-9">
                           	<input type="text" class="form-control" name="<?php echo $column; ?>" id="<?php echo $column; ?>" placeholder="<?php echo $column; ?>">
                        </div>
                     </div>
                <?php
            	}
            }
			?>
			<div class="form-group">
            	<label for="categoryId" class="control-label col-xs-3">categoryId</label>
            	<div class="col-xs-9">
            		<select class="form-control" name="categoryId" id="categoryId" placeholder="categoryId">
			<?php
			$catR = $myDa->query('SELECT categoryId, categoryName FROM categories');

			$catR->setFetchMode(PDO::FETCH_ASSOC);
			$catR->bindColumn(1, $catId);
			$catR->bindColumn(2, $catName);
			while($catR->fetch()) {
				?>
					<option value="<?php echo $catId; ?>"><?php echo $catName; ?></option>

				<?php
			}

			?>
					</select>
				</div>
			</div>


  		</form>
  		
  	</div>
  

  <div class="container" id="crop-avatar">

    <!-- Current avatar -->
    <div class="avatar-view" title="Verander de item-foto">
      <img src="cropper/img/picture.jpg" alt="Avatar" id="itemPicture" name="itemPicture">
    </div>

    <!-- Cropping modal -->
    <div class="modal fade" id="avatar-modal" tabindex="-1" role="dialog" aria-labelledby="avatar-modal-label" aria-hidden="true">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <form class="avatar-form" method="post" action="cropper/crop-avatar.php" enctype="multipart/form-data">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal">&times;</button>
              <h4 class="modal-title" id="avatar-modal-label">Verander de item-foto</h4>
            </div>
            <div class="modal-body">
              <div class="avatar-body">

                <!-- Upload image and data -->
                <div class="avatar-upload">
                  <input class="avatar-src" name="avatar_src" type="hidden">
                  <input class="avatar-data" name="avatar_data" type="hidden">
                  <label for="avatarInput">Upload een lokaal bestand</label>
                  <input class="avatar-input" id="avatarInput" name="avatar_file" type="file">
                </div>

                <!-- Crop and preview -->
                <div class="row">
                  <div class="col-md-9">
                    <div class="avatar-wrapper"></div>
                  </div>
                  <div class="col-md-3">
                    <div class="avatar-preview preview-lg"></div>
                    <div class="avatar-preview preview-md"></div>
                    <div class="avatar-preview preview-sm"></div>
                  </div>
                </div>
              </div>
            </div>
            <div class="modal-footer">
              <button class="btn btn-default" type="button" data-dismiss="modal">Close</button>
              <button class="btn btn-primary avatar-save" type="submit">Save</button>
            </div>
          </form>
        </div>
      </div>
    </div><!-- /.modal -->

    <!-- Loading state -->
    <div class="loading" tabindex="-1" role="img" aria-label="Loading"></div>
  </div>

  <div class="container">
    <button type="button" class="btn btn-success saveBtn">Bewaar gegevens</button>
    <div id="submitResult"></div>
    
  </div>


  <script src="cropper/src/cropper.js"></script>

  	<script src="cropper/src/crop-avatar.js"></script>
  </body>
  </html>