<?php include("./menu.php") ?>
<!DOCTYPE html>

<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href = "https://fonts.googleapis.com/css2? family = Indie + Flower & display = swap" rel = "stylesheet">     
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

    <link rel="stylesheet" href="./Css/style.css">
    <title>Les jardins de Chloris</title>
</head>
<body>





<div class="container-alim-fluid">
<h1 class="shop">Le coin shopping : Soins</h1>
<div class="row">


<?php 
require './admin/cnx.php';
$db = Cnx::connect();
$statement = $db->prepare('SELECT * FROM articles WHERE articles.categorie = 2');
$itemstwo = $statement->fetch();
$statement->execute(array($itemstwo));
while($itemstwo = $statement->fetch())
{
    echo ' 
    <div class="col-12 col-sm-6 ">
    <form action="Panier.php" id="article" method="post">
    <div class="thumbnail">
    <img src="./images/' . $itemstwo['imageArticle'] . '" alt="...">
    <div class="price">' . number_format ($itemstwo['prixUnitaire'], 2, '.', '').' €</div>
    <div class="caption">
    <h4>'. $itemstwo['designation'] . '</h4>
    <p> '. $itemstwo['description']. '</p>
    <h6><label for="quantite">Quantité:</label>
    <input type="number" id="quantite" name="quantite" min="0" max="15"></h6>
    <a href="#" class="btn-order" role="button"> <img src="./images/icons8-caddie-16.png"> Commander</a>
    </div>
    </div>
    </div>
    </form>'; 

}

?>


  <div class="row">
        <div class="footersoin ">
            <div class="copyalim col-6 ">Copyright ©2020 Les jardins de Chloris - Tous Droits Réservés</div> 
            <div class="footeralim col-6">  
            <img src="./images/logosev.svg" alt="logo" class="img-responsive img-fluid">
            </div>      
        </div>

    </div>
         <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
         <script src="https://code.jquery.com/jquery-3.5.1.js" integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc=" crossorigin="anonymous"></script>
   

<script src="js/script.js"></script>
</body>
</html> 
