<?php


class EspaceMembreController{

    /**
     * Affiche la page d'accueil
     */
    public static function read(){
        
        // Variables
        $params['page_name'] = "Espace membre";


        /*
        ====================
        Affichage de la page
        ====================
        */
        require_once("./view/utilisateur/espace_membre_menu.php"); // Page d'accueil
    
    

    }



}

?>