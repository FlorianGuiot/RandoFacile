<?php

/**
* Description de la class ProduitsManager
* Class qui gère les articles
*
* @auteur F. Guiot
*/

require_once("DbManager.php");
require_once("./class/Produit.php");


class UserManager {


    /**
     * getUserByEmail
     * retourne un objet utilisateur qui correspond à l'email placé en paramètre
     * retourne null si aucun utilisateur trouvé
     * @return utilisateur
     */
    public static function getUserByEmail($email){

        // Connexion bdd
        DbManager::getConnexion();
        // Affichage d'erreur en cas de non connexion à la base de données.
        if(DbManager::getConnexion() == null ){

            echo 'Erreur de connexion à la bdd.';

        }
        
        $user = null;

        //Requette SQL
        $sql='SELECT iduser,nom,prenom,mail,mdp,dateInscription,dateNaissance,admin FROM utilisateurs WHERE mail = :mail';
        $result=DbManager::$cnx->prepare($sql);
        $result->bindParam(':mail', $email, PDO::PARAM_STR);
        $result->execute();
        $result->setFetchMode(PDO::FETCH_ASSOC);

        if($result->rowCount() == 1){

            $result_user=$result->fetch();

            $user = new utilisateur($result_user['iduser'],$result_user['nom'],$result_user['prenom'],$result_user['mail'],
                                    $result_user['mdp'],new DateTime($result_user['dateInscription']),
                                    new DateTime($result_user['dateNaissance']),$result_user['admin']);

        }
        

        return $user;

    }


    /**
     * getUserById
     * retourne un objet utilisateur qui correspond à l'id placé en paramètre
     * retourne null si aucun utilisateur trouvé
     * @return utilisateur
     */
    public static function getUserById($id){

        // Connexion bdd
        DbManager::getConnexion();
        // Affichage d'erreur en cas de non connexion à la base de données.
        if(DbManager::getConnexion() == null ){

            echo 'Erreur de connexion à la bdd.';

        }
        
        $user = null;

        //Requette SQL
        $sql='SELECT iduser,nom,prenom,mail,mdp,dateInscription,dateNaissance,admin FROM utilisateurs WHERE iduser = :id';
        $result=DbManager::$cnx->prepare($sql);
        $result->bindParam(':id', $id, PDO::PARAM_STR);
        $result->execute();
        $result->setFetchMode(PDO::FETCH_ASSOC);

        if($result->rowCount() == 1){

            $result_user=$result->fetch();

            $user = new utilisateur($result_user['iduser'],$result_user['nom'],$result_user['prenom'],$result_user['mail'],
                                    $result_user['mdp'],new DateTime($result_user['dateInscription']),
                                    new DateTime($result_user['dateNaissance']),$result_user['admin']);

        }
        

        return $user;

    }


    /**
     * testUserPassword
     * decrypte le mot de passe utilisateur et verifie la correspondance avec celui placé en paramètre
     * retourne true si les mots de passe correspondent
     * @return bool
     */
    public static function testUserPassword(utilisateur $user, string $password){

        // Connexion bdd
        DbManager::getConnexion();
        // Affichage d'erreur en cas de non connexion à la base de données.
        if(DbManager::getConnexion() == null ){

            echo 'Erreur de connexion à la bdd.';

        }
        
        
        $passValid = false;
        $email = $user->GetEmail();

        //Requette SQL
        $sql='SELECT mdp FROM utilisateurs WHERE mail = :mail';
        $resultmdp=DbManager::$cnx->prepare($sql);
        $resultmdp->bindParam(':mail', $email, PDO::PARAM_STR);
        $resultmdp->execute();
        $resultmdp->setFetchMode(PDO::FETCH_ASSOC);
        $result_mdp=$resultmdp->fetch();

        if(password_verify($password,$result_mdp['mdp'])){

            $passValid = true;

        }
        

        return $passValid;

    }



    /**
     * AddUser
     * Ajoute un utilisateur en bdd
     * retourne true si l'utilisateur est ajouté
     * @return bool
     */
    public static function AddUser($nom,$prenom,$dateNaissance,$dateInscription,$email,$password){

        // Connexion bdd
        DbManager::getConnexion();
        // Affichage d'erreur en cas de non connexion à la base de données.
        if(DbManager::getConnexion() == null ){

            echo 'Erreur de connexion à la bdd.';

        }

        $add = true;
        
        //Insert de l'utilisateur dans la base de donnée
        try{

            $sql='INSERT INTO utilisateurs (mail, mdp, dateNaissance, dateInscription, prenom, nom) VALUES (:mail, :mdp, :dateNaissance, :dateInscription, :prenom, :nom)';

            $insertUser = DbManager::$cnx->prepare($sql);
            $insertUser->bindParam(':mail', $email);
            $insertUser->bindParam(':mdp', $password);
            $insertUser->bindParam(':dateNaissance', $dateNaissance);
            $insertUser->bindParam(':dateInscription', $dateInscription);
            $insertUser->bindParam(':prenom', $prenom);
            $insertUser->bindParam(':nom', $nom);

            // Exécution ! 
            $insertUser->execute();

        }catch(PDOException $e){

            $add = false;

        }



        return $add;

    }



    /**
     * UpdateUserInfo
     * Modifie les informations d'un utilisateur en bdd
     * retourne true si l'utilisateur est modifié
     * @return bool
     */
    public static function UpdateUserInfo($nom,$prenom,$dateNaissance,$email,$id){

        // Connexion bdd
        DbManager::getConnexion();
        // Affichage d'erreur en cas de non connexion à la base de données.
        if(DbManager::getConnexion() == null ){

            echo 'Erreur de connexion à la bdd.';

        }

        $add = true;
        
        //update de l'utilisateur dans la base de donnée
        try{

            $sql="UPDATE utilisateurs SET mail = :mail, dateNaissance = :dateNaissance, prenom = :prenom, nom = :nom WHERE iduser = :iduser";

            $updateUser = DbManager::$cnx->prepare($sql);
            $updateUser->bindParam(':mail', $email);
            $updateUser->bindParam(':dateNaissance', $dateNaissance);
            $updateUser->bindParam(':prenom', $prenom);
            $updateUser->bindParam(':nom', $nom);
            $updateUser->bindParam(':iduser', $id);

            // Exécution ! 
            $updateUser->execute();
            
        }catch(PDOException $e){

            $add = false;

        }



        return $add;

    }





    /**
     * UpdateUserPassword
     * Modifie le mot de passe d'un utilisateur en bdd
     * retourne true si l'utilisateur est modifié
     * @return bool
     */
    public static function UpdateUserPassword($password,$id){

        // Connexion bdd
        DbManager::getConnexion();
        // Affichage d'erreur en cas de non connexion à la base de données.
        if(DbManager::getConnexion() == null ){

            echo 'Erreur de connexion à la bdd.';

        }

        $add = true;
        
        //update de l'utilisateur dans la base de donnée
        try{

            $sql="UPDATE utilisateurs SET mdp = :mdp WHERE iduser = :iduser";

            $updateUser = DbManager::$cnx->prepare($sql);
            $updateUser->bindParam(':mdp', $password);
            $updateUser->bindParam(':iduser', $id);

            // Exécution ! 
            $updateUser->execute();
            
        }catch(PDOException $e){

            $add = false;

        }



        return $add;

    }



}