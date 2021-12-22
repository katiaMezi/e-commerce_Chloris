
<!DOCTYPE html>
<html lang="fr">
   
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="Css/style.css">
    <link rel="stylesheet" type="application/octet-stream" href="Css/IndieFlower-Regular.ttf">
    <script src="https://kit.fontawesome.com/885507feb1.js" crossorigin="anonymous"></script>

<?php 
include("admin/cnx.php");

   session_start();
   include("infos.php");
   @$valider = $_POST["valider"];
   $erreur = "";
   if (isset($valider)) {
  
   $cnx = Cnx::connect();
   $verify = $cnx->prepare("select * from client where pseudo=? and password=? limit 1");
   $verify->execute(array($pseudo, $pass_crypt));
   $user = $verify->fetchAll();
   if (count($user) > 0) {
   $_SESSION["prenom_nom"] = ucfirst(strtolower($user[0]["prenom"])) .
   " "  .  strtoupper($user[0]["nom"]);
   $_SESSION["connecter"] = "yes";
   header("location:session.php");
   } else
   $erreur = "Mauvais login ou mot de passe!";
   }
   ?>
    
   <body  onLoad="document.fo.login.focus()">
   <h1 class="auth">Authentification</h1>
   <div  class="erreur"><?php  echo  $erreur  ?></div>
   <form class="login"  name="form"  method="post"  action="">
   <input  type="text"  name="pseudo"  placeholder="Votre pseudo"  /><br  />
   <input  type="password"  name="password"  placeholder="Mot de passe"  /><br  />
   <input  type="submit"  name="valider"  value="S'authentifier"  />
   <a  href="register.php">Créer votre Compte</a>
   </form>
   </body>
   </html>
  