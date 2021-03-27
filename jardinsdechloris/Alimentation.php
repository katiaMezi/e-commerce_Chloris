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
    <h1 class="shop">Le coin shopping : Alimentation</h1>
    <div class="row">
    
<?php 
include './admin/cnx.php';
$db = Cnx::connect();
$statement = $db->prepare('SELECT * FROM articles WHERE articles.categorie = 1');
$itemsone = $statement->fetch();
$statement->execute(array($itemsone));
while($itemsone = $statement->fetch())
{
    echo ' 
    
    <div class="col-12 col-sm-6 col-md-4">
        <div class="thumbnail">
            <img src="./images/' . $itemsone['imageArticle'] . '" alt="...">
        <div class="price">' . number_format ($itemsone['prixUnitaire'], 2, '.', '').' €</div>
         <div class="caption">
             <h4>'. $itemsone['designation'] . '</h4>
             <p> '.$itemsone['description']. '</p>
                 <a href="#" class="btn-order" role="button"> <img src="./images/icons8-caddie-16.png"> Commander</a>
         </div>
        </div>
    </div>';


}

?>
    <div class="row">
        <div class="footerprod col-12">
            <div class="copyalim col-6 ">Copyright ©2020 Les jardins de Chloris - Tous Droits Réservés</div> 
            <div class="footeralim col-6">  
            <img src="./images/logosev.svg" alt="logo" class="img-responsive img-fluid">
            </div>      
        </div>

    </div>


    



    



         <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
         <script src="https://code.jquery.com/jquery-3.5.1.js" integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc=" crossorigin="anonymous"></script>
   




<script src="./js/script.js"></script>
</body>
</html> 
