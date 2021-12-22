<?php 
   require 'cnx.php';

   //premier passage récupération des infos
   if(!empty($_GET['id'])) 
   {
       $id = checkInput($_GET['id']);
   }

   $nameError = $descriptionError = $priceError = $categoryError =  $imageError = $name = $description = $price = $category = $image = "";
  
   if (!empty($_POST))
   {
       $name            = checkInput($_POST['designation']);
       $description     = checkInput($_POST['description']);
       $price           = checkInput($_POST['prixUnitaire']);
       $category        = checkInput($_POST['categorie']);
       $image           = checkInput($_FILES['imageArticle']['name']);
       $imagePath       = '../images/' . basename($image);
       $imageExtension  = pathinfo($imagePath, PATHINFO_EXTENSION);
       $isSuccess       = true;
      

       if(empty($name))
       {
           $nameError = 'Ce champs ne peut pas être vide';
           $isSuccess = false;
       }
       if(empty($description))
       {
           $descriptionError = 'Ce champs ne peut pas être vide';
           $isSuccess = false;
       }
       if(empty($price))
       {
           $priceError = 'Ce champs ne peut pas être vide';
           $isSuccess = false;
       }
       if(empty($category))
       {
           $categoryError = 'Ce champs ne peut pas être vide';
           $isSuccess = false;
       }
       if(empty($image))
       {
           $isImageUpdated = false;
       }
       else
       {
         $isImageUpdated = true;
         $isUploadSuccess = true;  
         if($imageExtension != "jpg" && $imageExtension != "png" && $imageExtension != "jpeg" && $imageExtension != "gif")
         {
             $imageError = "Les extensions autorisées sont : .jpg, .jpeg, .png et .gif";
             $isUploadSuccess = false;
         }
        if(file_exists($imagePath))
         {
             $imageError = "Le fichier existe déjà";
             $isUploadSuccess = false;
         }
         if($_FILES["imageArticle"]["size"] > 500000)
         {
             $imageError = "Le fichier ne doit pas dépasser les 500Kb";
             $isUploadSuccess = false;
         }
         if($isUploadSuccess)
         {
             if(!move_uploaded_file($_FILES["imageArticle"]["tmp_name"], $imagePath))
             {
                 $imageError = "Il y a eu une erreur lors de l'upload";
                 $isUploadSuccess = false;
             }
         }
       }
       if(($isSuccess && $isImageUpdated && $isUploadSuccess) || ($isSuccess && !$isImageUpdated))
       {
           $db = Cnx::connect();
           if($isImageUpdated)
           {
                $statement = $db->prepare("UPDATE articles SET designation = ?, description = ?, prixUnitaire = ?, categorie = ?, imageArticle = ? WHERE id = ?");
                $statement->execute(array($name, $description, $price, $category, $image, $id));
            } 
            else
            {
                $statement = $db->prepare("UPDATE articles SET designation = ?, description = ?, prixUnitaire = ?, categorie = ? WHERE id = ?");
                $statement->execute(array($name, $description, $price, $category, $id));
            }
            Cnx::disconnect();
            header("Location: index.php");
        }
        else if($isImageUpdated && !$isUploadSuccess)
        {
            $db = Cnx::connect();
            $statement = $db->prepare("SELECT * FROM articles WHERE id = ?");
            $statement->execute(array($id));
            $article = $statement->fetch();
            $image          = $article['imageArticle'];
            Cnx::disconnect();
           
        }
    }      
    else //récup des infos de l'article premier passage
    {
        $db = Cnx::connect();
        $statement = $db->prepare("SELECT * FROM articles WHERE id = ?");
        $statement->execute(array($id));
        $article = $statement->fetch();
        $name        =  $article['designation'];
        $description =  $article['description'];
        $price       =  $article['prixUnitaire'];
        $category    =  $article['categorie'];
        $image       =  $article['imageArticle'];
        
        Cnx::disconnect();
        
    }
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
       
    <h1><strong>Modifier un article</strong></h1> 
   
            
        <div class="row">

        <div class="col-sm-6">
        <form class="form" role="form" action="<?php echo 'update.php?id=' .$id;?>" role="form" method="post" enctype="multipart/form-data"> 
        <div class="form-group">
              <label for="designation">Nom:</label>
              <input type="text" class="form-control" id="designation" name="designation" placeholder="Nom" value="<?php echo $name; ?>" >
              <span class="help-inline"><?php echo $nameError; ?></span>
        </div>
           
        <div class="form-group">
              <label for="description">Description:</label>
              <input type="text" class="form-control" id="description" name="description" placeholder="Description" value="<?php echo $description; ?>" >
              <span class="help-inline"><?php echo $descriptionError; ?></span>
        </div>

        <div class="form-group">
              <label for="prixUnitaire">Prix: (en €)</label>
              <input type="number" step="0.01" class="form-control" id="prixUnitaire" name="prixUnitaire" placeholder="Prix" value="<?php echo $price; ?>" >
              <span class="help-inline"><?php echo $priceError; ?></span> 
        </div>

        <div class="form-group">
              <label for="categorieNom">Catégorie:</label>
              <select class="form-control" id="categorie" name="categorie">
                <?php $db = Cnx::connect();

                foreach($db->query('SELECT * FROM categories') as $row)
                {
                    if($row['categorieID'] == $category)
                        echo '<option selected ="selected" value="' . $row['categorieID'] . '">' . $row['categorieNom'] . '</option>';
                    else
                        echo '<option value="' . $row['categorieID'] . '">' . $row['categorieNom'] . '</option>';
                }
                Cnx::disconnect();
                
                ?>
              </select> 
              <span class="help-inline"><?php echo $categoryError; ?></span>
        </div>
        <div class="form-group">
        <label>Image: </label>
        <p><? echo $image;?></p>
        <label for="imageArticle">Sélectionner une nouvelle image:</label>
              <input type="file" id="imageArticle" name="imageArticle">
              <span class="help-inline"><?php echo $imageError; ?></span>
        </div>
            
        <div class="form-action">
            <button type="submit" class="btn btn-success" class="btn btn-primary"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil" viewBox="0 0 16 16">
<path d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168l10-10zM11.207 2.5L13.5 4.793 14.793 3.5 12.5 1.207 11.207 2.5zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293l6.5-6.5zm-9.761 5.175l-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325z"/>
</svg> Modifier</button>
            <a class="btn btn-primary" href="index.php"><svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor" class="bi bi-arrow-left-short" viewBox="0 0 16 16">
  <path fill-rule="evenodd" d="M12 8a.5.5 0 0 1-.5.5H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5H11.5a.5.5 0 0 1 .5.5z"/>
</svg> Retour</a>
            
            
        </div>
        </form>
        </div>
            
        
        <div class="col-sm-6 site">
                    <div class="thumbnail">
                        <img src="<?php echo '../images/'.$image;?>" alt="...">
                        <div class="price"><?php echo number_format((float)$price, 2, '.', ''). ' €';?></div>
                          <div class="caption">
                            <h4><?php echo $name;?></h4>
                            <p><?php echo $description;?></p>
                            
                          </div>
                    </div>
                </div>  
        









</div>

    
       
    
    
  
   

         <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
         <script src="https://code.jquery.com/jquery-3.5.1.js" integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc=" crossorigin="anonymous"></script>
    <script src="js/script.js"></script>


</body>
</html> 