<?php  
	 // Vérification paramètre id  spécifié dans l'URL.  
	 if (isset($_GET['id'])) {  
	     //  Eviter injection SQL, préparation de l'instruction et exécution.  
	     $statement = $cnx->prepare('SELECT * FROM articles WHERE id = ?');  
	     $statement->execute([$_GET['id']]);  
	     /*  Récupérer l' article de la base de données et retourner le résultat sous forme de tableau.*/  
	     $article = $statement->fetch(PDO::FETCH_ASSOC);  
	     /* Vérifiez si l' article existe (le tableau n'est pas vide)*/  
	     if (!$articles) {  
	         /*Erreur simple à afficher si l'id de l article n'existe pas (le tableau est vide)*/  
	         exit('le produit n\'existe pas!');  
	     }
	 } else {  
	     //  Erreur simple à afficher si l'id n'a pas été spécifié.  
	     exit('le produit n\'existe pas!');  
	 }
	 ?>
     <?=template_header('articles')?>
	<div class="articles content-wrapper">
	    <img src="imgs/<?=$articles['imageArticle']?>" width="500" height="500" alt="<?=$articles['designation']?>">
	    <div>
	        <h1 class="name"><?=$articles['designation']?></h1>
	        <span class="price"> &dollar;<?=$articles['prixUnitaire']?>
	              <?php if ($articles['prixUnitaire'] > 0): ?>
	             <span class="prix"> &dollar;<?=$articles['prixUnitaire']?></span>
	             <?php endif; ?>
	         </span>
	         <form action="index.php?page=panier" method="post">
	             <input type="number" name="quantite" value="1" min="1" max="<?=$articles['quantite']?>" placeholder="Quantité" required>
	             <input type="hidden" name="articles_id" value="<?=$articles['id']?>">            <input type="submit" value="Ajouter au panier">
	         </form>
	         <div class="description">
	             <?=$articles['description']?>
	         </div>
	
	