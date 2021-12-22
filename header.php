<!DOCTYPE html>
<html lang="fr">
   
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="Css/style.css">
    <link rel="stylesheet" type="application/octet-stream" href="Css/IndieFlower-Regular.ttf">
    <script src="https://kit.fontawesome.com/885507feb1.js" crossorigin="anonymous"></script>
  
    <div class="col-md-12">
        <div class="float-right mt-4">
        <div class="btn-group" id="dropdown" role="group" aria-label="Button group with nested dropdown">
                <button type="button"class="btn btn-light" >  Mon compte <i class="fas fa-home"></i></button>
                <div class="btn-group" role="group">
                    <button onclick ="myFunction()" id="dropbtn"   type="button" class="btn btn-light dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></button>
                    <div id="myDropdown" class="dropdown-content">
                        <a class="dropdown-item" href="register.php"> Créer un compte</a>
                        <a class="dropdown-item" href="login.php"> Connexion</a>      
                </div>
                </div> 
            </div>   
            <div class="btn-group"  role="group" aria-label="Button group with nested dropdown">
                <button type="button" class="btn btn-light"> Mon panier <i class="fa fa-shopping-cart"></i> </button>
                <div class="btn-group" role="group">
                    <button onclick ="myFunction2()" id="dropbtn2"   type="button" class="btn btn-light dropdown-toggle" data-toggle="dropdown2" aria-haspopup="true" aria-expanded="false"></button>
                    <div id="myDropdown2" class="dropdown-content2">
                        <a class="dropdown-item2" href="#"> Mon panier</a>
                        <a class="dropdown-item2" href="#"> Commander</a>      
                </div>
                </div>
            </div>
            
        </div>
    </div>
    <title>Les jardins de Chloris</title>
    <script src="js/script.js"></script>  
</head>

   