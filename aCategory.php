<?php require_once("header.php"); ?>

<?php
$aCatDa = new tinekeDA();
$aCatResult = $aCatDa->query("SELECT categoryName,beschrijving FROM categories WHERE categoryId = '".$_GET["categoryId"]."'");
$aCatResult->setFetchMode(PDO::FETCH_ASSOC);
$aCatResult->bindColumn(1, $catName);
$aCatResult->bindColumn(2, $beschrijving);
$aCatResult->fetch();

$myDa = new tinekeDA();
$labels = array();

$labelRS = $myDa->query("SELECT labelId,label FROM labels");
$labelRS->setFetchMode(PDO::FETCH_ASSOC);
$labelRS->bindColumn(1, $labelCol);
$labelRS->bindColumn(2, $label);
while($labelRS->fetch()) {
    $labels[$labelCol] = $label;
}
?>

<div class="container-fluid">

<h1><?php echo $catName; ?></h1>
<?php
if(isset($beschrijving)){
    echo $beschrijving;
}
?>


<script type="text/javascript">  

function isSold(itemDiv){
	select = "#item" + itemDiv + "Div";
	$(select).find("div.jm-item-image").prepend('<img src="img/verkocht.png" class="sold" />'); 
	$(select).find("img.itemImage").removeClass("notSold");
	$(select).find("div.jm-item-button").removeClass("notSold");

}

$(document).ready(function(){
    $('.nav li').removeClass('active');
    $('#categories').addClass('active');

    $(".saveBtn").click(function(){
        var myModal = $(this).closest('.modal-content');
        
        $.ajax({
            type: "POST",
            url: "process.php",
            data: myModal.find('form').serialize(),
            success: function(msg){
                myModal.find('div.submitResult').html(msg); 
		myModal.find('div.submitResult').addClass('alert-warning');
		
                if(msg == 1) {
                    myModal.find('div.submitResult').html("Uw bestelling werd succesvol doorgegeven. Bedankt!");
		    myModal.find('div.submitResult').removeClass('alert-warning');
		    myModal.find('div.submitResult').addClass('alert-success');
		    isSold(myModal.find('input#itemId').attr('value'));	    
                }                        
            },
            error: function(){
                alert("failure during ajax.");
            }
        });
    });

    $("input[name=typeKoper]:radio").change(function() {
        if($(this).attr("value") == "leerling") {
            $(this).parent().parent().parent().find("input#naamBieder").parent().parent().find("label").html("Naam leerling");
            if ( $("input#klas", $(this).parent().parent().parent()).length ) {
                
            } else {
                $(this).parent().parent().parent().find("input#naamBieder").parent().parent().after('<div class="form-group"><label for="klas" class="control-label col-xs-3"><?php echo $labels["klas"]; ?></label><div class="col-xs-9"><input type="text" class="form-control" name="klas" id="klas" placeholder="klas"></div></div>');
                $('.modal-body form').bootstrapValidator('addField', "klas");
            }

            if ( $("input#contactLeerling", $(this).parent().parent().parent()).length ) {
                $(this).parent().parent().parent().find("input#contactLeerling").parent().parent().remove();
                

            } else {
            }



        }

        if($(this).attr("value") == "leerkracht") {
            $(this).parent().parent().parent().find("input#naamBieder").parent().parent().find("label").html("Naam leerkracht");
            if ( $("input#klas", $(this).parent().parent().parent()).length ) {
                $(this).parent().parent().parent().find("input#klas").parent().parent().remove();
            } else {

            }

            if ( $("input#contactLeerling", $(this).parent().parent().parent()).length ) {
                $(this).parent().parent().parent().find("input#contactLeerling").parent().parent().remove();
                
            } else {
            }

        }

        if($(this).attr("value") == "andere") {
            $(this).parent().parent().parent().find("input#naamBieder").parent().parent().find("label").html("Naam koper");
            if ( $("input#klas", $(this).parent().parent().parent()).length ) {
                
            } else {
                $(this).parent().parent().parent().find("input#naamBieder").parent().parent().after('<div class="form-group"><label for="klas" class="control-label col-xs-3"><?php echo $labels["klas"]; ?></label><div class="col-xs-9"><input type="text" class="form-control" name="klas" id="klas" placeholder="klas"></div></div>');
                $('.modal-body form').bootstrapValidator('addField', "klas");
            }

            if ( $("input#contactLeerling", $(this).parent().parent().parent()).length ) {
                
            } else {

                $(this).parent().parent().parent().find("input#naamBieder").parent().parent().after('<div class="form-group"><label for="contactLeerling" class="control-label col-xs-3"><?php echo $labels["contactLeerling"]; ?></label><div class="col-xs-9"><input type="text" class="form-control" name="contactLeerling" id="contactLeerling" placeholder="contactLeerling"></div></div>');
                $('.modal-body form').bootstrapValidator('addField', "contactLeerling");
                $(this).parent().parent().parent().find("input#naamBieder").parent().parent().find("label").html("Naam koper");
            }

        }
    });
    
});   
</script>

<?php
$itemsResult = $myDa->query("SELECT items.itemId, items.beschrijving, items.prijs, items.titel, biedingen.biedingId FROM items LEFT JOIN biedingen ON items.itemId = biedingen.itemId WHERE categoryId = '".$_GET["categoryId"]."'");
$itemsResult->setFetchMode(PDO::FETCH_ASSOC);
$itemsResult->bindColumn(1, $itemID);
$itemsResult->bindColumn(2, $itemDescription);
$itemsResult->bindColumn(3, $itemPrice);
$itemsResult->bindColumn(4, $itemTitle);
$itemsResult->bindColumn(5, $biedingId);

$rowCounter = 0;


while($itemsResult->fetch()){
    $rowCounter++;
    if($rowCounter == 5) {
        $rowCounter = 1;
    }
    if($rowCounter == 1){
        ?>
        <div class="row">
        <?php
        }
        ?>
        <div class="veilingItem col-md-3" id="item<?php echo $itemID; ?>Div">
            <div class="jm-item first">
                <div class="jm-item-wrapper">
                    <div class="jm-item-image">
                        <?php 
                            if(isset($biedingId)) {
                                ?><img src="img/verkocht.png" class="sold" /><?php
                            }
                            ?>
                        <img src="img/<?php echo $itemID; ?>.jpg" class="itemImage<?php if(!isset($biedingId)) { echo " notSold";}?>" alt="Afbeelding item <?php echo $itemID; ?>." />
                        <span class="jm-item-overlay"> </span>
                        <div class="jm-item-button<?php if(!isset($biedingId)) { echo " notSold";}?>"><a href="" class="btn btn-default" data-toggle="modal" data-target="#<?php echo $itemID; ?>Modal">Meer info</a></div>
                    </div>
                    <div class="jm-item-title"><?php echo $itemTitle; ?> - €<?php echo $itemPrice; ?></div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="<?php echo $itemID; ?>Modal" tabindex="-1" role="dialog" aria-labelledby="<?php echo $itemPrice; ?>Modal" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title" id="myModalLabel"><?php echo $itemTitle; ?> - €<?php echo $itemPrice; ?></h4>
                    </div>
                    <div class="modal-body">
                        <p>
                            
                            <img src="img/<?php echo $itemID; ?>.jpg" class="itemImage align-right" />
                            <?php echo $itemDescription; ?>
                        </p>
                        <div class="divForm">
                            <p class="formInstructions">
                                Gelieve aan te geven of u leerling of leerkracht bent, of selecteer "andere" om een bestelling te plaatsen die via een contact-leerling zal worden afgehaald.
                                Vul alle getoonde velden in om dit item te bestellen. 
                            </p>

                      
                            <form class="form-horizontal" id="<?php echo $itemID; ?>Form">
                                <div class="form-group buyerType">
                            <input type="hidden" name="itemId" id="itemId" value="<?php echo $itemID; ?>">

                            <label class="radio-inline">
                                <input type="radio" name="typeKoper" id="typeKoper1" value="leerling" checked="checked"> Leerling
                            </label>
                            <label class="radio-inline">
                                <input type="radio" name="typeKoper" id="typeKoper2" value="leerkracht"> Leerkracht
                            </label>
                            <label class="radio-inline">
                                <input type="radio" name="typeKoper" id="typeKoper3" value="andere"> Andere
                            </label></div>


                            <?php 
                            // Get all column names for biedingen tabel
                            $columns = array();
                            $rs = $myDa->query('SELECT * FROM biedingen LIMIT 0');
                            for ($i = 0; $i < $rs->columnCount(); $i++) {
                                $col = $rs->getColumnMeta($i);
                                $columns[] = $col['name'];
                            }
                            foreach($columns as $column) {
                                if($column != "itemId" && $column != "biedingId" && $column != "typeKoper" && $column != "contactLeerling"  && $column != "status" && $column != "opmerking" && $column != "betaald") {
                                    ?>
                                        <div class="form-group">
                                            <label for="<?php echo $column; ?>" class="control-label col-xs-3"><?php echo $labels[$column]; ?></label>
                                            <div class="col-xs-9">
                                                <input type="text" class="form-control" name="<?php echo $column; ?>" id="<?php echo $column; ?>" placeholder="<?php echo $labels[$column]; ?>">
                                            </div>
                                        </div>
                                    <?php    
                                    

                                    
                                } 
                            }
                            ?>

                            </form>
                        </div>

<script language="javascript">
// Form validation

// make sure the full set of fields are added
$("#<?php echo $itemID; ?>Form").append('<div class="form-group"><label for="contactLeerling" class="control-label col-xs-3">Contactleerling</label><div class="col-xs-9"><input type="text" class="form-control" name="contactLeerling" id="contactLeerling" placeholder="contactLeerling"></div></div>');


    $('#<?php echo $itemID; ?>Form').bootstrapValidator({
        message: 'This value is not valid',
        excluded: [':disabled'],
        live: 'enabled',
        feedbackIcons: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
        
        
        fields: {
            

            naamBieder: {
                message: 'The username is not valid',
                validators: {
                    notEmpty: {
                        message: 'The username is required and cannot be empty'
                    },
                    stringLength: {
                        min: 6,
                        max: 30,
                        message: 'The username must be more than 6 and less than 30 characters long'
                    }
                }
            }, 
            email: {
                validators: {
                    emailAddress: {
                        message: 'Dit is geen geldig email-adres'
                    },
                    notEmpty: {
                        message: 'Het is verplicht een e-mailadres op te geven'
                    }
                }

            },
            klas: {
                enabled: true,
                validators: {
                    notEmpty: {
                        message: 'De klas moet ingevuld worden'
                    }
                }

            }, 
            contactLeerling: {
                enabled: true,
                validators: {
                    notEmpty: {
                        message: 'De contactleerling moet ingevuld worden'
                    }
                }

            }, 
            telefoon: {
                validators: {
                    notEmpty: {
                        message: 'Het telefoonnummmer is een verplicht veld'
                    }
                }

            }
        }
    })

    .on('status.field.bv', function(e, data) {  
        var bootstrapValidator = $("#<?php echo $itemID; ?>Form").data('bootstrapValidator');

        if(bootstrapValidator.isValidContainer("#<?php echo $itemID; ?>Form") == true) {
            $("#<?php echo $itemID; ?>Modal button.saveBtn").removeClass("disabled");
        } else {
            $("#<?php echo $itemID; ?>Modal button.saveBtn").addClass("disabled");
        }
    })
    
    ;

    
// remove non-relevant fields
    $("input#contactLeerling").parent().parent().remove();

    $("#<?php echo $itemID; ?>Modal").on('shown.bs.modal', function() {
        $('.modal-body form').bootstrapValidator('resetForm', true);
    });

</script>

                       
                        <div class="submitResult alert"></div>
                            
                    </div>
            
                    <div class="modal-footer">             
                            <button type="button" class="btn btn-default" data-dismiss="modal">Sluit</button>
                            <button type="button" class="btn btn-success saveBtn disabled">Plaats bestelling</button>
                    </div>
                </div>
            </div>
        </div>

        <?php
        if($rowCounter == 4){
        ?>
        </div>
        <?php
        }
    }
    ?>
    </div> 


</div>
<?php require_once("footer.php"); ?>