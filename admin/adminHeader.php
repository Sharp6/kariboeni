<?php
$menuDa = new tinekeDA();
$menuResult = $menuDa->query("SELECT SUM(items.prijs) FROM biedingen LEFT JOIN items ON items.itemId = biedingen.itemId");
$menuResult->setFetchMode(PDO::FETCH_ASSOC);
$menuResult->bindColumn(1, $opbrengst);
$menuResult->fetch();
?>

<div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
      <div class="container">
      	
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="#">Kariboeni PopUp Store - Admin</a>

          <span class="navStatus">Opbrengst: €<?php echo $opbrengst; ?></span>
          
        </div>
        <div class="collapse navbar-collapse">
          <ul class="nav navbar-nav">
            <li class="active" id="items"><a href="index.php">Verkochte items</a></li>
            <?php //<li id="leerlingen"><a href="overviewLeerlingen.php">Overzicht per leerling</a></li>?>      
            <li id="categories"><a href="overviewCategories.php">Overzicht per categorie</a></li>
            <li id="voegToe"><a href="voegToe.php">Nieuw item toevoegen</a></li>
            
          </ul>



        </div><!--/.nav-collapse -->

      </div>


    </div>