<?php
include './admin/cnx.php';
Cnx::connect();
session_start();
  
	 /* Si l'utilisateur a cliqué sur le bouton "Ajouter au panier" sur la page du produit, nous pouvons vérifier les données du formulaire.*/   
	 if (isset($_POST['quantite'], $_POST['submit']=='Commander') && is_numeric($_POST['quantite'])){   
	     /* Définissez les variables post afin que nous puissions les identifier facilement, assurez-vous également qu'elles sont entières.*/     
	     $quantite = (int)$_POST['quantite'];   
	     /* Préparez l'instruction SQL, nous vérifions essentiellement si le produit existe dans notre base de données.*/   
	     $stmt = $cnx->prepare('SELECT * FROM article WHERE id = ?');   
	     $stmt->execute([$_POST['quantite']]);   
	     /* Récupère le produit depuis la base de données et renvoie le résultat sous forme de tableau.*/   
	     $produit = $stmt->fetch(PDO::FETCH_ASSOC);   
	     // Vérifier si le produit existe (le tableau n'est pas vide)   
	     if ($produit && $quantite > 0) {   
	         /*Le produit existe dans la base de données, maintenant nous pouvons créer/mettre à jour la variable de session pour le panier.*/   
	         if (isset($_SESSION['panier']) && is_array($_SESSION['panier'])) {   
	             if (array_key_exists($quantite, $_SESSION['panier'])) {   
	                 // Le produit existe dans le panier, il suffit de mettre à jour la quantité.   
	                 $_SESSION['panier'][$produit_id] += $quantité;   
	             } else {   
	                 // Le produit n'est pas dans le panier, ajoutez-le   
	                 $_SESSION['panier'][$produit_id] = $quantité;   
	             }
	         } else {   
	             /* Il n'y a aucun produit dans le panier, ceci ajoutera le premier produit au panier.*/   
	             $_SESSION['panier'] = array($produit_id => $quantité);   
	         }
	     }   
	     // Empêcher la resoumission des formulaires...   
	     header('location: index.php?page=panier');   
	     exit;
	 }
   	

	   /* Retirez le produit du panier, vérifiez le paramètre "remove" de l'URL, c'est l'identifiant du produit, assurez-vous qu'il s'agit d'un numéro et vérifiez s'il est dans le panier.*/   
	 if (isset($_GET['remove']) && is_numeric($_GET['remove']) && isset($_SESSION['panier']) && isset($_SESSION['panier'][$_GET['remove']])) {   
        // Remove the produit from the shopping panier   
        unset($_SESSION['panier'][$_GET['remove']]);   
    }
     /* Mettre à jour les quantités de produits dans le panier si l'utilisateur clique sur le bouton "Mettre à jour" sur la page du panier d'achat*/   
	 if (isset($_POST['update']) && isset($_SESSION['panier'])) {   
        /* Boucle à travers les données postales afin de mettre à jour les quantités pour chaque produit du panier.*/   
        foreach ($_POST as $k => $v) {   
            if (strpos($k, 'quantité') !== false && is_numeric($v)) {   
                $id = str_replace('quantité-', '', $k);   
                $quantité = (int)$v;   
                // Effectuez toujours des contrôles et des validations   
                if (is_numeric($id) && isset($_SESSION['panier'][$id]) && $quantité > 0) {   
                    // Mise à jour de la nouvelle quantité   
                    $_SESSION['panier'][$id] = $quantité;   
                }
            }   
        }
        // Empêcher la re-soumission de formulaires...   
        header('location: index.php?page=panier');   
        exit;
    }
   /* Diriger l'utilisateur vers la page de commande s'il clique sur le bouton Passer la commande, le panier ne doit pas être vide.*/   
	 if (isset($_POST['placerCommade']) && isset($_SESSION['panier']) && !empty($_SESSION['panier'])) {   
        header('Location: index.php?page=placerCommade');   
        exit;
    }
   
	    /* Vérification de la variable de session pour les produits en panier*/   
	 $produits_in_panier = isset($_SESSION['panier']) ? $_SESSION['panier'] : array();   
	 $produits = array();   
	 $subtotal = 0.00;   
	 // S'il y a des produits dans le panier   
	 if ($produits_in_panier) {   
	     /* Il y a des produits dans le panier, nous devons donc sélectionner ces produits dans la base de données.*/   
	     /* Mettre les produits du panier dans un tableau de chaîne de caractères avec point d'interrogation, nous avons besoin que l'instruction SQL inclue  ( ?,?, ?,...etc).*/   
	     $array_to_question_marks = implode(',', array_fill(0, count($produits_in_panier), '?'));   
	     $stmt = $pdo->prepare('SELECT * FROM produits WHERE id IN (' . $array_to_question_marks . ')');   
	     /* Nous avons uniquement besoin des clés du tableau, pas des valeurs, les clés sont les identifiants des produits. */   
	     $stmt->execute(array_keys($produits_in_panier));   
	     /* Récupérer les produits de la base de données et retourner le résultat sous la forme d'un tableau.*/   
	     $produits = $stmt->fetchAll(PDO::FETCH_ASSOC);   
	     // Calculez le total partiel   
	     foreach ($produits as $produit) {   
	         $subtotal += (float)$produit['prix'] * (int)$produits_in_panier[$produit['id']];   
	     }
	 }  
	 ?>


	