<?php include("./header.php");
include("./menu.php");
include("./infos.php");
?>
<?php
   session_start();
   if($_SESSION["connecter"]!="yes"){
      header("location:login.php");
      exit();
   }
   if(date("H")<18)
      $bienvenue="Bonjour et bienvenue ".
      $_SESSION["prenom_nom"].
      " dans votre espace personnel";
   else
      $bienvenue="Bonsoir et bienvenue ".
      $_SESSION["prenom_nom"].
      " dans votre espace personnel";
?>


  
<h2 class="session"><?php  echo  $bienvenue  ?></h2>
<a class="decnx"  href="deconnexion.php">Se déconnecter</a>


<?php include("./footer.php") ?>