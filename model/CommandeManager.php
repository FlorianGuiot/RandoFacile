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
     * retourne le nombre de commandes passer par l'utilisateur en parametre
     *
     * @return array
     */
    public static function GetNbCommandeByUser($user){

        // Connexion bdd
        DbManager::getConnexion();
        // Affichage d'erreur en cas de non connexion à la base de données.
        if(DbManager::getConnexion() == null ){

            echo 'Erreur de connexion à la bdd.';

        }

        // Récupération du nombre de commandes.
        $idUser = $user->GetId();

        $sql = "select id nom FROM Commandes WHERE idUser = :id";
        $resultCommande=DbManager::$cnx->prepare($sql);
        $resultCommande->bindParam(':id', $idUser, PDO::PARAM_INT);
        $resultCommande->execute();


        //Retourne les commandes de l'utilisateur en parametre
        return $resultCommande->rowCount();

        
    }





    /**
     * GetCommandeByUser
     * retourne les commandes de l'utilisateur en parametre
     *
     * @return array
     */
    public static function GetCommandeByUser($user,$derniereCommande,$limiteCommande){

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

        $sql = "select C.id,adresse,ville,cp,idPays,P.libelle,P.abreviation, P.frais, prenom, nom FROM Commandes C JOIN pays P ON P.id = C.idPays WHERE idUser = :id ORDER BY C.id DESC  LIMIT :dernier , :limite";
        $resultCommande=DbManager::$cnx->prepare($sql);
        $resultCommande->bindParam(':id', $idUser, PDO::PARAM_INT);
        $resultCommande->bindParam(':dernier', $derniereCommande, PDO::PARAM_INT);
        $resultCommande->bindParam(':limite', $limiteCommande, PDO::PARAM_INT);
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
     * GetCommandeById
     * retourne la commande de l'id en parametre
     *
     * @return commande
     */
    public static function GetCommandeById($id){

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

        $sql = "select C.id,C.idUser,adresse,ville,cp,idPays,P.libelle,P.abreviation,P.frais,C.prenom AS Cprenom,C.nom AS Cnom,mail,mdp,dateNaissance,dateInscription,U.prenom AS prenomU,U.nom AS nomU FROM Commandes C JOIN pays P ON P.id = C.idPays JOIN utilisateurs U ON C.idUser = U.iduser WHERE C.id = :id";
        $resultCommande=DbManager::$cnx->prepare($sql);
        $resultCommande->bindParam(':id', $id, PDO::PARAM_INT);
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
            $sql = "select idStatut,date,S.libelle FROM statuts_commandes SC JOIN statut_commande S ON SC.idStatut = S.id WHERE idCommande = :idCommande ORDER BY date DESC";
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
            $laCommande = new commande($result_commande['id'],new utilisateur($result_commande['idUser'],$result_commande['nomU'],$result_commande['prenomU'],$result_commande['mail'],$result_commande['mdp'],new DateTime($result_commande['dateInscription']),new DateTime($result_commande['dateNaissance'])),$result_commande['adresse'],$result_commande['ville'],$result_commande['cp'],$lePays,$result_commande['Cnom'],$result_commande['Cprenom'],$lesStatuts);
            
        }

        


        // =============================================
        //
        // Etape 3
        // Récupération des détails de la commande.
        //
        // ==============================================

        //Récupération des produits de la commande:

        //Panier de la commande
        $lePanier = new panier();

        $sql = "select idProduit,qte FROM details_commande WHERE idCommande = :id";
        $resultDetails=DbManager::$cnx->prepare($sql);
        $resultDetails->bindParam(':id', $id, PDO::PARAM_INT);
        $resultDetails->execute();

        //Ajoute chaque produit au panier
        while($result_panier=$resultDetails->fetch()){
            
            
            $lePanier->AddProduit(ProduitsManager::getProduitParId($result_panier['idProduit']), $result_panier['qte']);

        }

        //Ajoute le panier a la commande
        $laCommande->SetDetailsCommande($lePanier);


        //Retourne les commandes de l'utilisateur en parametre
        return $laCommande;

        
    }






    /**
     * GetStatutParId
     * retourne le statut d'un id
     *
     * @return statut
     */
    public static function GetStatutParId($id){

        // Connexion bdd
        DbManager::getConnexion();
        // Affichage d'erreur en cas de non connexion à la base de données.
        if(DbManager::getConnexion() == null ){

            echo 'Erreur de connexion à la bdd.';

        }

        // Récupération du statut.
        $sql='SELECT id,libelle FROM statut_commande WHERE id = :id';
        $resultStatut=DbManager::$cnx->prepare($sql);
        $resultStatut->bindParam(':id', $id, PDO::PARAM_INT);
        $resultStatut->execute();
        $result_statut=$resultStatut->fetch();

        return new statut($result_statut['id'],$result_statut['libelle']);
    }






     /**
     * GetStatutParLibelle
     * retourne le statut d'un libelle
     *
     * @return statut
     */
    public static function GetStatutParLibelle($libelle){

        // Connexion bdd
        DbManager::getConnexion();
        // Affichage d'erreur en cas de non connexion à la base de données.
        if(DbManager::getConnexion() == null ){

            echo 'Erreur de connexion à la bdd.';

        }

        // Récupération du statut.
        $sql='SELECT id,libelle FROM statut_commande WHERE libelle = :libelle';
        $resultStatut=DbManager::$cnx->prepare($sql);
        $resultStatut->bindParam(':libelle', $libelle, PDO::PARAM_INT);
        $resultStatut->execute();
        $result_statut=$resultStatut->fetch();

        return new statut($result_statut['id'],$result_statut['libelle']);
    }









    /**
     * AddCommande
     * Ajoute une commande dans la base de donnée
     * retourne true si la commande est ajoutée
     * @return bool
     */
    public static function AddCommande($adresse,$ville,$cp,$idPays,$prenom,$nom,$idUser,$lePanier){

        // Connexion bdd
        DbManager::getConnexion();
        // Affichage d'erreur en cas de non connexion à la base de données.
        if(DbManager::getConnexion() == null ){

            echo 'Erreur de connexion à la bdd.';

        }

        $add = true;
        


        
        try{


            // =============================================
            //
            // Etape 1
            // Ajout de la commande.
            //
            // ==============================================

            $sql='INSERT INTO commandes (adresse, ville, cp, idPays, prenom, nom, idUser) VALUES (:adresse, :ville, :cp, :idPays, :prenom, :nom, :idUser)';

            $insertCommande = DbManager::$cnx->prepare($sql);
            $insertCommande->bindParam(':adresse', $adresse);
            $insertCommande->bindParam(':ville', $ville);
            $insertCommande->bindParam(':cp', $cp);
            $insertCommande->bindParam(':idPays', $idPays);
            $insertCommande->bindParam(':prenom', $prenom);
            $insertCommande->bindParam(':nom', $nom);
            $insertCommande->bindParam(':idUser', $idUser);

            // Exécution ! 
            $insertCommande->execute();

            //IdCommande
            $idCommande= DbManager::$cnx->lastInsertId();

            // =============================================
            //
            // Etape 2
            // Ajout du statut de la commande.
            //
            // ==============================================

            $idStatutPreparation = self::GetStatutParLibelle("En cours de préparation")->GetId();

            date_default_timezone_set('Europe/Paris');
            $dateDuJour = date('Y-m-d H:i:s', time()); //Date de la commande


            $sql='INSERT INTO statuts_commandes (idStatut, idCommande, date) VALUES (:idStatut, :idCommande, :date)';
            $insertStatut = DbManager::$cnx->prepare($sql);
            $insertStatut->bindParam(':idStatut', $idStatutPreparation);
            $insertStatut->bindParam(':idCommande', $idCommande);
            $insertStatut->bindParam(':date', $dateDuJour );

            // Exécution ! 
            $insertStatut->execute();




            // =============================================
            //
            // Etape 3
            // Ajout du details commande.
            //
            // ==============================================

            $sql = "INSERT INTO details_commande (idCommande, idProduit, qte) VALUES ";
            $bindSql = array();

            foreach($lePanier as $unP){

                if($sql[strlen($sql)-1] == ')'){

                    $sql .= ",";

                }

                array_push($bindSql, $idCommande);
                array_push($bindSql, $unP['produit']->GetId());
                array_push($bindSql, $unP['qte']);

                $sql .= "(?,?,?)";

            }

            $insertDetails = DbManager::$cnx->prepare($sql);

            // Exécution ! 
            $insertDetails->execute($bindSql);

            



            // =============================================
            //
            // Etape 4
            // Modifier la quantité en stock des produits
            //
            // ==============================================
           
            
            foreach($lePanier as $unP){

                $bindSqlUpdate = array();

                $sql = "UPDATE produit SET qte_stock = (qte_stock - ?) WHERE id = ?";

                array_push($bindSqlUpdate, $unP['qte']);
                array_push($bindSqlUpdate, $unP['produit']->GetId());

                $updateProduit = DbManager::$cnx->prepare($sql);

                // Exécution ! 
                $updateProduit->execute($bindSqlUpdate);

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