<?php 
   require 'cnx.php';
   
   if(!empty($_GET['id']))
   {
       $id= checkInput($_GET['id']);
   }

   if(!empty($_POST)) //2eme passage
   {
       $id= checkInput($_POST['id']);
       //suppression item
       $db = Cnx::connect();
       $statement = $db->prepare("DELETE FROM articles WHERE id = ?");
       $statement->execute(array($id));

       Cnx::disconnect();
       header("Location: index.php");
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
       
    <h1><strong>Supprimer un article</strong></h1> 
   <br>  
        <div class="row">
            <form class="form" role="form" action="delete.php" method="post"> 
                <input type="hidden" name="id" value="<?php echo $id;//stockage id en cach ?>">
                <p class="alert alert-warning">Êtes-vous sûr de vouloir supprimer?</p>
                 <div class="form-actions">
            <button type="submit" class="btn btn-warning">Oui</button>
            <a class="btn btn-default" href="index.php">Non</a>
            
            
                  </div>
       
        
        </form>
        
        









</div>

    
       
    
    
  
   

         <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
         <script src="https://code.jquery.com/jquery-3.5.1.js" integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc=" crossorigin="anonymous"></script>
    <script src="js/script.js"></script>


</body>
</html> 