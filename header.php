<?php
require_once('class.da.tinekeDA.php');
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

    <script src="js/jquery-2.1.1.min.js"></script>
    <script src="js/bootstrap.min.js"></script>

    <title>Kariboeni PopUp Store</title>

    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- CSS and JS for bootstrap form validator -->
    
    <link rel="stylesheet" href="js/bootstrapvalidator/css/bootstrapValidator.min.css"/>
    <script type="text/javascript" src="js/bootstrapvalidator/js/bootstrapValidator.js"></script>
    
    <!-- Custom styles for this template -->
    <link href="kariboeni.css" rel="stylesheet">
    <link href="gallery.css" rel="stylesheet">

    <!-- Just for debugging purposes. Don't actually copy this line! -->
    <!--[if lt IE 9]><script src="../../assets/js/ie8-responsive-file-warning.js"></script><![endif]-->

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>

  <body>

    <div class="navbar navbar-default navbar-fixed-top" role="navigation">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="#">Kariboeni PopUp Store</a>
        </div>
        <div class="collapse navbar-collapse">
          <ul class="nav navbar-nav">
            <li class="active" id="home"><a href="index.php">Home</a></li>
            <li id="projecten"><a href="projecten.php">Projecten</a></li>
            <li id="popup"><a href="popup.php">Pop-up Store</a></li>
            <li class="dropdown" id="categories"><a href="#" class="dropdown-toggle" data-toggle="dropdown">Categorieën <span class="caret"></span></a>
              <ul class="dropdown-menu" role="menu">
              <?php
              $menuDa = new tinekeDA();
              $menuResult = $menuDa->query("SELECT categoryId, categoryName FROM categories");
              $menuResult->setFetchMode(PDO::FETCH_ASSOC);
              $menuResult->bindColumn(1, $catId);
              $menuResult->bindColumn(2, $catName);
              while($menuResult->fetch()){
              ?>
                <li><a href="aCategory.php?categoryId=<?php echo $catId; ?>">> <?php echo $catName; ?></a></li>
              <?php
              }
              ?>
              </ul>
            </li>
            
            
          </ul>
                  <div id="logoDiv">
          <img src="img/logo.png">
        </div>
        </div><!--/.nav-collapse -->

      </div>
    </div>

    <div class="container">

      <div class="starter-template">