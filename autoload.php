<?php
    /**
     * Charge les class
     */

     //Model
     require_once __DIR__.'/model/DbManager.php';
     require_once __DIR__.'/model/UserManager.php';
     require_once __DIR__.'/model/ProduitsManager.php';
     require_once __DIR__.'/model/PanierManager.php';
     require_once __DIR__.'/model/PaysManager.php';
     require_once __DIR__.'/model/CommandeManager.php';

     //Classes metier
     require_once __DIR__.'/class/Produit.php';
     require_once __DIR__.'/class/Categorie.php';
     require_once __DIR__.'/class/Pays.php';
     require_once __DIR__.'/class/Commentaire.php';
     require_once __DIR__.'/class/Utilisateur.php';
     require_once __DIR__.'/class/Panier.php';
     require_once __DIR__.'/class/PanierCookies.php';
     require_once __DIR__.'/class/Statut.php';
     require_once __DIR__.'/class/Commande.php';
     

     //Classes utils
     require_once __DIR__.'/utils/DateFormatter.php';
     require_once __DIR__.'/utils/NombreFormatter.php';
     

?> 