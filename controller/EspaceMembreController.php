<?php
use Date\Utils;
use Date\Utils\DateFormatter;
use Number\Utils\NombreFormatter;


class EspaceMembreController{

    /**
     * Affiche la page d'accueil
     */
    public static function read(){
        
        // Variables
        $params['page_name'] = "Espace membre";

        $user = UserManager::getUserById($_SESSION['iduser']);

        /*
        ====================
        Affichage de la page
        ====================
        */
        require_once("./view/utilisateur/espace_membre_menu.php"); // Page d'accueil
    
    

    }


    /**
     * Affiche la page modifier informations
     */
    public static function readModifierInformations($params){
        
        // Variables
        $params['page_name'] = "Espace membre";

        $user = UserManager::getUserById($_SESSION['iduser']);

        /*
        ====================
        Affichage de la page
        ====================
        */
        require_once("./view/utilisateur/espace_membre_modifier_info.php"); 
    
    

    }




    /**
     * Affiche la page modifier mot de passe
     */
    public static function readModifierSecurite($params){
        
        // Variables
        $params['page_name'] = "Espace membre";

        $user = UserManager::getUserById($_SESSION['iduser']);

        /*
        ====================
        Affichage de la page
        ====================
        */
        require_once("./view/utilisateur/espace_membre_modifier_password.php"); 
    
    

    }



    /**
     * Affiche la page commandes 
     */
    public static function readCommandes($params){
        
        // Variables
        $params['page_name'] = "Mes commandes";
        $user = UserManager::getUserById($_SESSION['iduser']);
        define('LIMIT_COMMANDES', 5); //nbr max de commandes affichés par page
        $lienPage = SERVER_URL."/membre/commandes";
        $nbCommandes = CommandeManager::GetNbCommandeByUser($user);

        //Numero de page par défaut à 1
        if(!isset($params['numPage'])){

            $params['numPage'] = 1;

        }

        //Calcul du premier article de la page
        $derniereCommande = ($params['numPage'] * LIMIT_COMMANDES) - LIMIT_COMMANDES;

        $lesCommandes = CommandeManager::GetCommandeByUser($user,$derniereCommande,LIMIT_COMMANDES);


        /*
        ====================
        Affichage de la page
        ====================
        */
        require_once("./view/utilisateur/espace_membre_commandes.php"); 
    
    

    }







    /**
     * Affiche la page commandes 
     */
    public static function readLaCommande($params){
        
        // Variables
        $params['page_name'] = "Ma commande";
        $user = UserManager::getUserById($_SESSION['iduser']);



        $laCommande = CommandeManager::GetCommandeById($params['idCommande']);

        
        $lePanier = $laCommande->GetDetailsCommande()->GetPanier();
        $leStatut = $laCommande->GetLeStatut();
        $lesStatuts = $laCommande->GetLesStatuts();

        $dateFormatter = new DateFormatter($laCommande->GetDate());
        $dateCommande = $dateFormatter->GetDateEcrite();

        /*
        ====================
        Affichage de la page
        ====================
        */
        require_once("./view/utilisateur/espace_membre_commande_details.php"); 
    
    

    }



}

?>