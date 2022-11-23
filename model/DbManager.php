<?php
/**
* Description de la class DbManager
* Class qui implémente toutes les fonctions d'accès à la base de données
*
* @auteur F. Guiot
*/

// attributs techniques d'accès à la bdd
const HOST = '127.0.0.1';
const PORT = '3307'; // 3306 ou 3307:MariaDB / 3308: MySQL
const DBNAME = 'db_ecommerce';
const CHARSET = 'utf8';
const LOGIN = 'root';
const MDP = '';

class DbManager {
     
    public static ?\PDO $cnx = null;
    
    /**
     * getConnexion
     * établit la connexion à la base de données
     *
     * @return void
     */
    public static function getConnexion(){

        if(self::$cnx == null){

            try {

                $dsn = 'mysql:host='.HOST.';port='.PORT.';dbname='.DBNAME.';charset='.CHARSET;
                self::$cnx = new PDO($dsn, LOGIN, MDP);
                self::$cnx->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            } catch (PDOException $e) {

                die('Erreur : '.$e->getMessage());    

            }
        }
        return self::$cnx;
    }
    

    /**
     * nettoyer
     * supprime les caractères spéciaux d'une variable
     *
     * @return void
     */
    public static function nettoyer($data){

        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);

        return $data;
    }


    
}

?>