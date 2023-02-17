<?php

/**
* Description de la class CommandeManager
* Class qui gère les commandes de l'utilisateur
*
* @auteur F. Guiot
*/

require_once("DbManager.php");
require_once("./class/Pays.php");
require_once("./class/Produit.php");
require_once("./class/Utilisateur.php");


class PaysManager {


    /**
     * GetLesPays
     * retourne la liste des pays sur lesquels il est possible de passer commande.
     *
     * @return array
     */
    public static function GetLesPays(){

        // Connexion bdd
        DbManager::getConnexion();
        // Affichage d'erreur en cas de non connexion à la base de données.
        if(DbManager::getConnexion() == null ){

            echo 'Erreur de connexion à la bdd.';

        }

        $lesPays = array();

        // Récupération des pays.
        $sql = "select id,libelle,abreviation,frais FROM pays";
        $resultPays=DbManager::$cnx->prepare($sql);
        $resultPays->execute();

        while($result_pays=$resultPays->fetch()){
            
            array_push($lesPays, new pays($result_pays['id'],$result_pays['libelle'],$result_pays['abreviation'],$result_pays['frais']));
        }
        
        
        return $lesPays;

        
    }


   



}