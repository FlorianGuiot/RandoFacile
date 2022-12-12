<?php


class AccueilController{

    /**
     * Affiche la page d'accueil
     */
    public static function read(){
        
        // Variables
        $params['page_name'] = "Accueil";
        $lesNouveautés = ProduitsManager::getLesNouveautes();

        //Barre de recherche
        $recherche = '';
        if(isset($_GET['searchbutton'])){

            $recherche = $_GET['searchbar'];
            $recherche = DbManager::nettoyer($recherche);
            header('Location: index.php?controller=Recherche&action=read&recherche='.$recherche);
            
        }

        /*
        ====================
        Affichage de la page
        ====================
        */
        require_once("./view/accueil/accueil.php"); // Page d'accueil
    
    

    }



}

?>