<?php


class ErreurController{

    /**
     * Affiche la page erreur 404
     */
    public static function read404(){
        

        $params['page_name'] = "Erreur 404";
        /*
        ====================
        Affichage de la page
        ====================
        */
        require_once("./view/erreur/404.php"); // Page d'erreur
    
    

    }


}

?>