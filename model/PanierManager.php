<?php

/**
* Description de la class PanierManager
* Class qui gère les articles du panier de chaque utilisateur
*
* @auteur F. Guiot
*/

require_once("DbManager.php");
require_once("./class/Produit.php");
require_once("./class/Utilisateur.php");


class PanierManager {


    /**
     * GetPanierById
     * retourne un tableau correspondant à l'id en parametre
     *
     * @return array
     */
    public static function GetPanierById($idUser){

        // Connexion bdd
        DbManager::getConnexion();
        // Affichage d'erreur en cas de non connexion à la base de données.
        if(DbManager::getConnexion() == null ){

            echo 'Erreur de connexion à la bdd.';

        }

        $lePanier = new panier();

        // Récupération des lignes panier.
        $sql = "select idProduit,qte,DateAjout FROM Panier WHERE idUser = :id";
        $resultPanier=DbManager::$cnx->prepare($sql);
        $resultPanier->bindParam(':id', $idUser, PDO::PARAM_INT);
        $resultPanier->execute();

        while($result_panier=$resultPanier->fetch()){
            
            $lePanier->AddProduit(ProduitsManager::getProduitParId($result_panier['idProduit']), $result_panier['qte']);

        }
        
        
        return $lePanier;

        
    }


    /**
     * AddPanier
     * Ajoute un produit dans le panier de l'utilisateur
     * retourne true si le produit est ajouté
     * @return bool
     */
    public static function AddPanier($produit,$qte,$idUser,$date){

        // Connexion bdd
        DbManager::getConnexion();
        // Affichage d'erreur en cas de non connexion à la base de données.
        if(DbManager::getConnexion() == null ){

            echo 'Erreur de connexion à la bdd.';

        }

        $add = true;
        
        $idProduit = $produit->GetId();


        //Insert ou update du produit dans la table panier
        try{

            $sql='SELECT idProduit,idUser from panier WHERE idProduit = :idProduit AND idUser = :idUser';
            $insertUser = DbManager::$cnx->prepare($sql);
            $insertUser->bindParam(':idProduit', $idProduit);
            $insertUser->bindParam(':idUser', $idUser);

            // Exécution ! 
            $insertUser->execute();
            $insertUser->setFetchMode(PDO::FETCH_ASSOC);

            if($insertUser->rowCount() == 1){

                $sql='UPDATE panier SET qte = :qte WHERE idProduit = :idProduit AND idUser = :idUser';

                $insertUser = DbManager::$cnx->prepare($sql);
                $insertUser->bindParam(':idProduit', $idProduit);
                $insertUser->bindParam(':idUser', $idUser);
                $insertUser->bindParam(':qte', $qte);

                // Exécution ! 
                $insertUser->execute();

            

            }else{

                $sql='INSERT INTO panier (idProduit, idUser, qte, DateAjout) VALUES (:idProduit, :idUser, :qte, :DateAjout)';

                $insertUser = DbManager::$cnx->prepare($sql);
                $insertUser->bindParam(':idProduit', $idProduit);
                $insertUser->bindParam(':idUser', $idUser);
                $insertUser->bindParam(':qte', $qte);
                $insertUser->bindParam(':DateAjout', $date);

                // Exécution ! 
                $insertUser->execute();

            } 


        }catch(PDOException $e){

            $add = false;

        }



        return $add;

    }



    /**
     * RemovePanier
     * retire un produit du panier de l'utilisateur
     * retourne true si le produit est retiré
     * @return bool
     */
    public static function RemovePanier($produit,$idUser){

        // Connexion bdd
        DbManager::getConnexion();
        // Affichage d'erreur en cas de non connexion à la base de données.
        if(DbManager::getConnexion() == null ){

            echo 'Erreur de connexion à la bdd.';

        }

        $remove = true;
        
        $idProduit = $produit->GetId();


        //DELETE le produit de la table panier
        try{

            $sql='DELETE FROM PANIER WHERE idProduit = :idProduit AND idUser = :idUser';
            $removeProduct = DbManager::$cnx->prepare($sql);
            $removeProduct->bindParam(':idProduit', $idProduit);
            $removeProduct->bindParam(':idUser', $idUser);

            // Exécution ! 
            $removeProduct->execute();
            


        }catch(PDOException $e){

            $remove = false;

        }



        return $remove;

    }




}