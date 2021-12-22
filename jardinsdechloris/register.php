
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
session_start();
include("infos.php");
@$valider = $_POST["inscrire"];
$erreur = "";
if (isset($valider)) {
if (empty($nom)) $erreur = "Le champs nom est obligatoire!";
elseif (empty($prenom)) $erreur = "Le chanmps prénom est obligatoire!";
elseif (empty($pseudo)) $erreur = "Le chanmps Pseudo est obligatoire!";
elseif (empty($password)) $erreur = "Le chanmps mot de passe est obligatoire!";
elseif ($password != $passwordConf) $erreur = "Mots de passe differents!";
else {
include("admin/cnx.php");
$cnx = Cnx::connect();
$verify_pseudo = $cnx->prepare("select clientID from client where pseudo=? limit 1");
$verify_pseudo->execute(array($pseudo));
$user_pseudo = $verify_pseudo->fetchAll();
if (count($user_pseudo) > 0)
$erreur = "Pseudo existe déjà!";
else {
$ins = $cnx->prepare("insert into client(nom,prenom,pseudo,password) values(?,?,?,?)");
if ($ins->execute(array($nom, $prenom, $pseudo, $password)))
header("location:login.php");
     }
   }
}
?>

<div class="inscription">Inscription</div>
<div  class="erreur"><?php  echo  $erreur  ?></div>
<form class="register"  name="fo"  method="post"  action="">
<input  type="text"  name="nom"  placeholder="Nom"  value="<?=  $nom  ?>"  /><br  />
<input  type="text"  name="prenom"  placeholder="Prénom"  value="<?=  $prenom  ?>"  /><br  />
<input  type="text"  name="pseudo"  placeholder="Votre Pseudo"  value="<?=  $pseudo  ?>"  /><br  />
<input  type="password"  name="password"  placeholder="Mot de passe"  /><br  />
<input  type="password"  name="passconf"  placeholder="Confirmer votre Mot de passe"  /><br  />
<input  type="submit"  name="inscrire"  value="S'inscrire"  />
<a  href="login.php">Déjà un compte</a>
</form>
