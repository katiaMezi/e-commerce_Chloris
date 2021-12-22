<?php
require 'cnx.php';

if(!empty($_GET['id']))
{
  $id = checkInput($_GET['id']);   
}

$db = Cnx::connect();
$statement = $db->prepare('SELECT articles.id, articles.designation, articles.description, articles.prixUnitaire, articles.imageArticle, categories.categorieNom as category FROM articles LEFT JOIN categories ON articles.categorie = categories.categorieID WHERE articles.id = ?');
$statement->execute(array($id));
$article = $statement->fetch();
Cnx::disconnect();

function checkInput($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
?> 

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href = "https://fonts.googleapis.com/css2? family = Indie + Flower & display = swap" rel = "stylesheet">     
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

    <link rel="stylesheet" href="Css/style.css">
  
    
    <title>Les jardins de Chloris</title>
</head>
     
   
    <body>
    <h1 class="text-logo">Les jardins de Chloris</h1>
    <div class="container admin">
        <div class="row">
        <div class="col-md-6">
            <h1><strong>Voir un article</strong></h1> 
            <br>
            <form>
              <div class="form-group">
              <label>Nom: </label><?php echo ' '.$article['designation']; ?>
              </div>
           
        
        <div class="form-group">
              <label>Description: </label><?php echo ' '.$article['description']; ?>
            
        </div>
        <div class="form-group">
              <label>Prix: </label><?php echo ' '.number_format((float) $article['prixUnitaire'],2,'.', '' ) . ' €'; ?>
             
        </div>
        <div class="form-group">
              <label>Catégorie: </label><?php echo ' '.$article['category']; ?>
        </div>
        <div class="form-group">
              <label>Image: </label><?php echo ' '.$article['imageArticle']; ?>
        </div>
            
            </form>
            <div class="form-actions">
            <a class="btn btn-primary" href="index.php"><svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor" class="bi bi-arrow-left-short" viewBox="0 0 16 16">
  <path fill-rule="evenodd" d="M12 8a.5.5 0 0 1-.5.5H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5H11.5a.5.5 0 0 1 .5.5z"/>
</svg> Retour</a>
            
            </div>
        </div>
        
        
        
        
        <div class="col-md-6">
          <div class="vignette">
          <img src="<?php echo '../images/' .$article['imageArticle'] ;?>" alt="">
          <div class="prixUnitaire"><?php echo ' '.number_format((float) $article['prixUnitaire'],2,'.', ''. '€' ); ?></div>
          <div class="legende">
                <h4><?php echo $article['designation']; ?></h4>
                <p><?php echo $article['description']; ?></p>
                
          </div>
          
          
          </div> 



        </div>
        

        </div>







    </div> 

     <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
     <script src="https://code.jquery.com/jquery-3.5.1.js" integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc=" crossorigin="anonymous"></script>
<script src="js/script.js"></script>
</div>
</body>
</html> 