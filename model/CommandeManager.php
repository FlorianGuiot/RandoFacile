<?php

/**
* Description de la class CommandeManager
* Class qui gère les commandes
*
* @auteur F. Guiot
*/

require_once("DbManager.php");
require_once("./class/Produit.php");
require_once("./class/Utilisateur.php");
require_once("./class/Panier.php");
require_once("./class/Commande.php");


class CommandeManager {


    /**
     * GetCommandeByUser
     * retourne les commandes de l'utilisateur en parametre
     *
     * @return array
     */
    public static function GetCommandeByUser($user){

        // Connexion bdd
        DbManager::getConnexion();
        // Affichage d'erreur en cas de non connexion à la base de données.
        if(DbManager::getConnexion() == null ){

            echo 'Erreur de connexion à la bdd.';

        }

        //Les commandes retournées
        $lesCommandes = array();


        // =============================================
        //
        // Etape 1
        // Récupération des informations des commandes.
        //
        // ==============================================


        // Récupération des informations de commande.

        $idUser = $user->GetId();

        $sql = "select C.id,adresse,ville,cp,idPays,P.libelle,P.abreviation, P.frais, prenom, nom FROM Commandes C JOIN pays P ON P.id = C.idPays WHERE idUser = :id";
        $resultCommande=DbManager::$cnx->prepare($sql);
        $resultCommande->bindParam(':id', $idUser, PDO::PARAM_INT);
        $resultCommande->execute();

        //Pour chaque commandes
        while($result_commande=$resultCommande->fetch()){

            // =============================================
            //
            // Etape 2
            // Récupération des statuts de chaque commande.
            //
            // ==============================================
            
            $lesStatuts = array();


            //Récupération des statuts de la commande
            $sql = "select idStatut,date,S.libelle FROM statuts_commandes SC JOIN statut_commande S ON SC.idStatut = S.id WHERE idCommande = :idCommande";
            $resultStatut=DbManager::$cnx->prepare($sql);
            $resultStatut->bindParam(':idCommande', $result_commande['id'], PDO::PARAM_INT);
            $resultStatut->execute();

            //Ajoute tous les statuts de la commande dans un tableau
            while($result_statut=$resultStatut->fetch()){

                array_push($lesStatuts, [
                                            'statut' => new statut($result_statut['idStatut'],$result_statut['libelle']),
                                            'date' => $result_statut['date']

                                        ]);

            }


            //Le pays de livraison
            $lePays = new pays($result_commande['idPays'],$result_commande['libelle'],$result_commande['abreviation'],$result_commande['frais']);

            //Ajoute la commande a la liste des commandes
            array_push($lesCommandes, new commande($result_commande['id'],$user,$result_commande['adresse'],$result_commande['ville'],$result_commande['cp'],$lePays,$result_commande['nom'],$result_commande['prenom'],$lesStatuts));

        }

        


        // =============================================
        //
        // Etape 3
        // Récupération des détails de chaque commande.
        //
        // ==============================================

        //Récupération des produits pour chaque commandes:
        foreach($lesCommandes as $uneCommande){

            //Panier de la commande
            $lePanier = new panier();

            $idCommande = $uneCommande->GetId();

            $sql = "select idProduit,qte FROM details_commande WHERE idCommande = :id";
            $resultDetails=DbManager::$cnx->prepare($sql);
            $resultDetails->bindParam(':id', $idCommande, PDO::PARAM_INT);
            $resultDetails->execute();

            //Ajoute chaque produit au panier
            while($result_panier=$resultDetails->fetch()){
                
                
                $lePanier->AddProduit(ProduitsManager::getProduitParId($result_panier['idProduit']), $result_panier['qte']);
    
            }

            //Ajoute le panier a la commande
            $uneCommande->SetDetailsCommande($lePanier);

        }
        


        //Retourne les commandes de l'utilisateur en parametre
        return $lesCommandes;

        
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



    /**
     * ClearPanier
     * vide le panier de l'utilisateur
     * retourne true si le panier est vidé
     * @return bool
     */
    public static function ClearPanier($idUser){

        // Connexion bdd
        DbManager::getConnexion();
        // Affichage d'erreur en cas de non connexion à la base de données.
        if(DbManager::getConnexion() == null ){

            echo 'Erreur de connexion à la bdd.';

        }

        $remove = true;
        
        //DELETE les produits de la table panier
        try{

            $sql='DELETE FROM PANIER WHERE idUser = :idUser';
            $removeProduct = DbManager::$cnx->prepare($sql);
            $removeProduct->bindParam(':idUser', $idUser);

            // Exécution ! 
            $removeProduct->execute();
            


        }catch(PDOException $e){

            $remove = false;

        }



        return $remove;

    }





}