<?php


class RechercheController{

    /**
     * Affiche la page resultat de recherche
     */
    public static function read($params){

        
        // Variables

        define('LIMIT_PRODUITS', 8); //nbr max de produit affichés par page

        //Numero de page par défaut à 1
        if(!isset($params['numPage'])){

            $params['numPage'] = 1;

        }

        //Calcul du premier article de la page
        $lastProduit = ($params['numPage'] * LIMIT_PRODUITS) - LIMIT_PRODUITS;

        $params['page_name'] = "Les produits";

        //Recupère les articles
        if(isset($params['recherche'])){

            $lienPage = SERVER_URL."/recherche/".$params['recherche'];
            $lesProduits = ProduitsManager::getLesProduits($params['recherche'],-1,LIMIT_PRODUITS,$lastProduit);
            $nbrResultatsRecherche = ProduitsManager::getNbrProduitsRecherche($params['recherche'],-1);

        }else{

            $lienPage = SERVER_URL."/recherche/categorie/".$params['idCateg'];
            $lesProduits = ProduitsManager::getLesProduits(null,$params['idCateg'],LIMIT_PRODUITS,$lastProduit);
            $nbrResultatsRecherche = ProduitsManager::getNbrProduitsRecherche(null,$params['idCateg']);

        }

        

        /*
        ====================
        Affichage de la page
        ====================
        */
        require_once("./view/recherche/recherche.php"); // Page resultats de recherche
    
    

    }





}

?>