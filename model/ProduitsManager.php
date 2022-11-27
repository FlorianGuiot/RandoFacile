<?php

/**
* Description de la class ProduitsManager
* Class qui gère les articles
*
* @auteur F. Guiot
*/

use Date\Utils\DateFormatter;

require_once("DbManager.php");
require_once("./class/Produit.php");


class ProduitsManager {

    //Requete de base permettant la récupération des produits
    static private string $requeteInfoProduits = 'SELECT distinct id,path_photo,path_photo_2,path_photo_3,path_photo_4,P.libelle,prix_vente_uht,resume,C.codecateg,C.libelle as libelleCateg,description,dateajout,qte_stock FROM produit P JOIN categories C ON C.codecateg = P.codecateg ';

    /**
     * getLesNouveautés
     * retourne une liste des 4 derniers articles
     *
     * @return array
     */
    public static function getLesNouveautes(){

        // Connexion bdd
        DbManager::getConnexion();
        // Affichage d'erreur en cas de non connexion à la base de données.
        if(DbManager::getConnexion() == null ){

            echo 'Erreur de connexion à la bdd.';

        }
        
        $lesProduits = array();

        //Requette SQL
        $sql=ProduitsManager::$requeteInfoProduits."ORDER BY dateajout DESC LIMIT 4";
        $result=DbManager::$cnx->prepare($sql);
        $result->execute();
        while($result_produit=$result->fetch()){

            array_push($lesProduits, new produit($result_produit['id'],$result_produit['libelle'],$result_produit['resume'],$result_produit['description'],$result_produit['path_photo'],$result_produit['path_photo_2'],$result_produit['path_photo_3'],$result_produit['path_photo_4'],$result_produit['dateajout'],$result_produit['qte_stock'],$result_produit['prix_vente_uht'], new categorie($result_produit['codecateg'],$result_produit['libelleCateg'])) );
        
        }

        return $lesProduits;

    }


    /**
     * getLesMotsRecherches
     * Explode la varible 'recherche' en une liste de mots et retourne les conditions de la requete SQL
     *
     * @return array
     */
    private static function getLesMotsRecherches($recherche, $sql){

        //Tableau contenant toutes les variables de la recherche
        $lesMotsDansLaRecherche = array();

        //Place tous les mots de la recherche dans un tableau
        $lesMotsRecherche = explode(" ", $recherche);

        // Si plusieurs mots recherchés
        if(count($lesMotsRecherche) > 1){
            
            $cpt = count($lesMotsRecherche)-1;

            while($cpt>=0){

                $unMot = "%".$lesMotsRecherche[$cpt]."%";

                if($cpt==0){ // Si il n'y a plus de mot dans la liste, cloturer la requette.
                    $sql=$sql. ' (P.libelle LIKE ? OR resume LIKE ?)';
                    array_push($lesMotsDansLaRecherche, $unMot);
                    array_push($lesMotsDansLaRecherche, $unMot);
                }
                else{ // Si il reste des mots dans la liste, ajouter un OR.
                    $sql=$sql. ' (P.libelle LIKE ? OR resume LIKE ? ) OR ';
                    array_push($lesMotsDansLaRecherche, $unMot);
                    array_push($lesMotsDansLaRecherche, $unMot);
                }

                $cpt--;
            }

        }// Un seul mot recherché
        else{
            
            $rechercheRequete = "%".$recherche."%";
            $sql=$sql." P.libelle LIKE ? OR resume LIKE ? ORDER BY dateajout DESC";
            array_push($lesMotsDansLaRecherche, $rechercheRequete);
            array_push($lesMotsDansLaRecherche, $rechercheRequete);
        }


        return array($sql,$lesMotsDansLaRecherche);

    }






    /**
     * getLesProduits
     * retourne une liste de produit
     *
     * @return array
     */
    public static function getLesProduits($recherche,$idCateg = -1,$limit = 0, $lastProduit = 0){

        // Connexion bdd
        DbManager::getConnexion();
        // Affichage d'erreur en cas de non connexion à la base de données.
        if(DbManager::getConnexion() == null ){

            echo 'Erreur de connexion à la bdd.';

        }
        
        $lesProduits = array();

        //Requette SQL
        $sql=ProduitsManager::$requeteInfoProduits;


        //Tableau contenant toutes les variables de la recherche
        $lesMotsDansLaRecherche = array();


        //Si c'est une recherche par categorie
        if($idCateg != -1){

            $sql.='WHERE C.codecateg = ? ORDER BY dateajout DESC';
            array_push($lesMotsDansLaRecherche, $idCateg);

        }

        //Si c'est une recherche
        if($recherche != null){
	
			$sql = $sql."WHERE";
            

            //Explode la varible 'recherche' en une liste de mots et retourne les conditions de la requete SQL
            $getLesMotsRecherches = ProduitsManager::getLesMotsRecherches($recherche, $sql);

            //Récupération des conditions de recherche en fonction du nombre de mots
            $sql = $getLesMotsRecherches[0];

            //Récupération de la liste de mots presents dans la recherche
            $lesMotsDansLaRecherche  = $getLesMotsRecherches[1];

        }

        // Requete SQL avec limite et premier article par page.
        $sql = $sql." LIMIT ".$lastProduit.", ".$limit;

        $resultPage=DbManager::$cnx->prepare($sql);
        
        //Execute la requete et remplace les "?" par les mots du tableau "lesMotsDansLaRecherche"
        $resultPage->execute($lesMotsDansLaRecherche);

        if($resultPage->rowCount() >= 1){ // Un ou plusieurs resultats.

            while($result_produit=$resultPage->fetch()){

                $produit =  new produit($result_produit['id'],$result_produit['libelle'],$result_produit['resume'],$result_produit['description'],$result_produit['path_photo'],$result_produit['path_photo_2'],$result_produit['path_photo_3'],$result_produit['path_photo_4'],$result_produit['dateajout'],$result_produit['qte_stock'],$result_produit['prix_vente_uht'], new categorie($result_produit['codecateg'],$result_produit['libelleCateg']));
                $produit->SetNoteMoyenne(self::getNoteMoyenneProduit($produit)); //Rajoute la note moyenne au produit
                array_push($lesProduits, $produit);
            
            }
    
        }
        
		
        return $lesProduits;

    }



    /**
     * getNbrProduitsRecherche
     * retourne une liste de produit
     *
     * @return array
     */
    public static function getNbrProduitsRecherche($recherche,$idCateg = -1){

        // Connexion bdd
        DbManager::getConnexion();
        // Affichage d'erreur en cas de non connexion à la base de données.
        if(DbManager::getConnexion() == null ){

            echo 'Erreur de connexion à la bdd.';

        }
        

        //Requette SQL
        $sql=ProduitsManager::$requeteInfoProduits;


        //Tableau contenant toutes les variables de la recherche
        $lesMotsDansLaRecherche = array();


        //Si c'est une recherche par categorie
        if($idCateg != -1){

            $sql.='WHERE C.codecateg = ? ORDER BY dateajout DESC';
            array_push($lesMotsDansLaRecherche, $idCateg);

        }



        //Si c'est une recherche
        if($recherche != null){

            $sql = $sql."WHERE";

            //Explode la varible 'recherche' en une liste de mots et retourne les conditions de la requete SQL
            $getLesMotsRecherches = ProduitsManager::getLesMotsRecherches($recherche, $sql);

            //Récupération des conditions de recherche en fonction du nombre de mots
            $sql = $getLesMotsRecherches[0];

            //Récupération de la liste de mots presents dans la recherche
            $lesMotsDansLaRecherche  = $getLesMotsRecherches[1];

        }


        $resultPage=DbManager::$cnx->prepare($sql);
        //Execute la requete et remplace les "?" par les mots du tableau "lesMotsDansLaRecherche"
        $resultPage->execute($lesMotsDansLaRecherche);

        return $resultPage->rowCount();

    }




    /**
     * getCategorieParId
     * retourne la categorie d'un id
     *
     * @return categorie
     */
    public static function getCategorieParId($idCateg){

        // Connexion bdd
        DbManager::getConnexion();
        // Affichage d'erreur en cas de non connexion à la base de données.
        if(DbManager::getConnexion() == null ){

            echo 'Erreur de connexion à la bdd.';

        }

        // Récupération de la catégorie.
        if($idCateg != 0){

            $sql='SELECT codecateg,libelle FROM categories WHERE codecateg = :categ';
            $resultcateg=DbManager::$cnx->prepare($sql);
            $resultcateg->bindParam(':categ', $idCateg, PDO::PARAM_INT);
            $resultcateg->execute();
            $result_categ=$resultcateg->fetch();

            return new categorie($result_categ['codecateg'],$result_categ['libelle']);

        }
    }



    /**
     * getProduitParId
     * retourne un objet produit
     *
     * @return produit
     */
    public static function getProduitParId($idProduit){

        // Connexion bdd
        DbManager::getConnexion();
        // Affichage d'erreur en cas de non connexion à la base de données.
        if(DbManager::getConnexion() == null ){

            echo 'Erreur de connexion à la bdd.';

        }
        
        $leProduit = null;
        // Récupération du produit.

        
        $sql = self::$requeteInfoProduits." WHERE id = :idProduit";
        $resultProduit=DbManager::$cnx->prepare($sql);
        $resultProduit->bindParam(':idProduit', $idProduit, PDO::PARAM_INT);
        $resultProduit->execute();

        if($resultProduit->rowCount() == 1){

            $result_produit=$resultProduit->fetch();

            try{

        
                $leProduit = new produit($result_produit['id'],$result_produit['libelle'],$result_produit['resume'],$result_produit['description'],$result_produit['path_photo'],$result_produit['path_photo_2'],$result_produit['path_photo_3'],$result_produit['path_photo_4'],$result_produit['dateajout'],$result_produit['qte_stock'],$result_produit['prix_vente_uht'], new categorie($result_produit['codecateg'],$result_produit['libelleCateg']));

            }
            catch(PDOException $e){

                echo "Erreur";
                
            }
        }
        
        return $leProduit;

        
    }



    /**
     * getNoteMoyenneProduit
     * retourne la note moyenne sur un produit
     *
     * @return float
     */
    public static function getNoteMoyenneProduit($produit){

        // Connexion bdd
        DbManager::getConnexion();
        // Affichage d'erreur en cas de non connexion à la base de données.
        if(DbManager::getConnexion() == null ){

            echo 'Erreur de connexion à la bdd.';

        }
        
        $idProduit = $produit->GetId();

        // Récupération de la moyenne.

        $sql = "SELECT AVG(note) as note FROM commentaire WHERE idProduit = :idProduit AND estVisible = 1 AND note IS NOT NULL";
        $resultProduit=DbManager::$cnx->prepare($sql);
        $resultProduit->bindParam(':idProduit', $idProduit, PDO::PARAM_INT);
        $resultProduit->execute();
        $result_Produit = $resultProduit->fetch();

        return $result_Produit['note'] ;

        
    }



    /**
     * getCommentairesProduit
     * retourne une liste d'objets commentaire
     *
     * @return array
     */
    public static function getCommentairesProduit($produit){

        // Connexion bdd
        DbManager::getConnexion();
        // Affichage d'erreur en cas de non connexion à la base de données.
        if(DbManager::getConnexion() == null ){

            echo 'Erreur de connexion à la bdd.';

        }
        
        $lesCommentaires = array();

        // Récupération des commentaires.
        $idProduit = $produit->GetId();
        $sql = "select idcom,iduser,idProduit,commentaire,note,dateCreation,dateLastModification FROM commentaire WHERE idProduit = :idProduit AND estVisible = 1 ORDER BY dateCreation DESC";
        $resultCommentaire=DbManager::$cnx->prepare($sql);
        $resultCommentaire->bindParam(':idProduit', $idProduit, PDO::PARAM_INT);
        $resultCommentaire->execute();

        while($result_commentaire=$resultCommentaire->fetch()){

            require_once(ROOT."/controller/ProduitController.php");
            require_once(ROOT."/model/UserManager.php");
            $user = UserManager::getUserById($result_commentaire['iduser']);
            $date = new DateTime($result_commentaire['dateCreation']);

            $dateFormatter = new DateFormatter($date);
            $heureEcrite = $dateFormatter->GetHeureEcrite();
            $dateEcrite = $dateFormatter->GetDateEcrite();

            $dateLastModification = null;

            if($result_commentaire['dateLastModification'] != null){
                $dateLastModification = new DateTime($result_commentaire['dateLastModification']);
            }
            
            array_push($lesCommentaires, new commentaire($result_commentaire['idcom'],$user,$result_commentaire['commentaire'],$result_commentaire['note'],$date, $dateEcrite,$heureEcrite, $produit, $dateLastModification));
        }
        
        return $lesCommentaires;

        
    }



    /**
     * getNbrNotes
     * retourne le nombre commentaire avec une note
     *
     * @return array
     */
    public static function getNbrNotes($produit){

        // Connexion bdd
        DbManager::getConnexion();
        // Affichage d'erreur en cas de non connexion à la base de données.
        if(DbManager::getConnexion() == null ){

            echo 'Erreur de connexion à la bdd.';

        }
        
        $lesCommentaires = array();

        // Récupération des commentaires.
        $idProduit = $produit->GetId();
        $sql = "select count(idCom) as nbrNotes FROM commentaire WHERE idProduit = :idProduit AND estVisible = 1 AND note IS NOT NULL";
        $resultCommentaire=DbManager::$cnx->prepare($sql);
        $resultCommentaire->bindParam(':idProduit', $idProduit, PDO::PARAM_INT);
        $resultCommentaire->execute();
        
        $result_commentaire=$resultCommentaire->fetch();

        return $result_commentaire['nbrNotes'];

        
    }


    /**
     * getNbrCommentaires
     * retourne le nombre de commentaires 
     *
     * @return array
     */
    public static function getNbrCommentaires($produit){

        // Connexion bdd
        DbManager::getConnexion();
        // Affichage d'erreur en cas de non connexion à la base de données.
        if(DbManager::getConnexion() == null ){

            echo 'Erreur de connexion à la bdd.';

        }
        
        $lesCommentaires = array();

        // Récupération des commentaires.
        $idProduit = $produit->GetId();
        $sql = "select count(idCom) as nbrCom FROM commentaire WHERE idProduit = :idProduit AND estVisible = 1";
        $resultCommentaire=DbManager::$cnx->prepare($sql);
        $resultCommentaire->bindParam(':idProduit', $idProduit, PDO::PARAM_INT);
        $resultCommentaire->execute();
        
        $result_commentaire=$resultCommentaire->fetch();

        return $result_commentaire['nbrCom'];

        
    }


    /**
     * GetCommentairesById
     * retourne un commentaire correspondant à l'id en parametre
     *
     * @return commentaire
     */
    public static function GetCommentaireById($id){

        // Connexion bdd
        DbManager::getConnexion();
        // Affichage d'erreur en cas de non connexion à la base de données.
        if(DbManager::getConnexion() == null ){

            echo 'Erreur de connexion à la bdd.';

        }


        // Récupération des commentaires.
        $sql = "select idcom,iduser,idProduit,commentaire,note,dateCreation,dateLastModification FROM commentaire WHERE idcom = :id";
        $resultCommentaire=DbManager::$cnx->prepare($sql);
        $resultCommentaire->bindParam(':id', $id, PDO::PARAM_INT);
        $resultCommentaire->execute();
        $result_commentaire=$resultCommentaire->fetch();

        require_once(ROOT."/controller/ProduitController.php");
        require_once(ROOT."/model/UserManager.php");
        $user = UserManager::getUserById($result_commentaire['iduser']);
        $date = new DateTime($result_commentaire['dateCreation']);

        $dateFormatter = new DateFormatter($date);
        $heureEcrite = $dateFormatter->GetHeureEcrite();
        $dateEcrite = $dateFormatter->GetDateEcrite();
        
        $dateLastModification = new DateTime($result_commentaire['dateLastModification']);
        $produit = self::getProduitParId($result_commentaire['idProduit']);
        $leCommentaire = new commentaire($result_commentaire['idcom'],$user,$result_commentaire['commentaire'],$result_commentaire['note'],$date,$dateEcrite ,$heureEcrite, $produit, $dateLastModification);
        
        
        return $leCommentaire;

        
    }



    /**
     * AddCommentaire
     * Ajoute un commentaire dans la bdd
     *
     * @return estAdd
     */
    public static function AddCommentaire($user,$ipUser,$commentaire,$date,$idProduit,$note){

        // Connexion bdd
        DbManager::getConnexion();
        // Affichage d'erreur en cas de non connexion à la base de données.
        if(DbManager::getConnexion() == null ){

            echo 'Erreur de connexion à la bdd.';

        }

        $estAdd = true;

        //Compression du commentaire
        $commentaire = gzdeflate($commentaire, 9);
        $idUser = $user->GetId();
        try{

            $sql = "INSERT INTO commentaire (iduser, idProduit, dateCreation, commentaire, note, adresseIp) VALUES (:iduser, :idProduit, :dateCreation, :commentaire, :note, :ip)";
            $resultCommentaire=DbManager::$cnx->prepare($sql);
            $resultCommentaire->bindParam(':iduser', $idUser);
            $resultCommentaire->bindParam(':idProduit', $idProduit);
            $resultCommentaire->bindParam(':dateCreation', $date);
            $resultCommentaire->bindParam(':ip', $ipUser);
            $resultCommentaire->bindParam(':commentaire', $commentaire);
            $resultCommentaire->bindParam(':note', $note);
            $resultCommentaire->execute();

        }catch(PDOException $e){

            $estAdd = false;

        }

        return $estAdd;

        
    }




    /**
     * EstCommentaireSpam
     * Retourne true si l'utilisateur tente de spammer
     *
     * @return estSpam
     */
    public static function EstCommentaireSpam($user,$idProduit){

        // Connexion bdd
        DbManager::getConnexion();
        // Affichage d'erreur en cas de non connexion à la base de données.
        if(DbManager::getConnexion() == null ){

            echo 'Erreur de connexion à la bdd.';

        }

        $estSpam = false;
        $idUser = $user->GetId();


        $sql = "SELECT dateCreation FROM commentaire WHERE idUser = :iduser AND idProduit = :idProduit AND TIMESTAMPDIFF(MINUTE, dateCreation, NOW()) < 5";
        $resultCommentaire=DbManager::$cnx->prepare($sql);
        $resultCommentaire->bindParam(':iduser', $idUser);
        $resultCommentaire->bindParam(':idProduit', $idProduit);
        $resultCommentaire->execute();

        if($resultCommentaire->rowCount() >= 1){

            $estSpam = true;

        }



        return $estSpam;

        
    }



    /**
     * EditCommentaire
     * Modifie un commentaire dans la bdd
     *
     * @return bool
     */
    public static function EditCommentaire($idCommentaire,$ipUser,$commentaire,$date){

        // Connexion bdd
        DbManager::getConnexion();
        // Affichage d'erreur en cas de non connexion à la base de données.
        if(DbManager::getConnexion() == null ){

            echo 'Erreur de connexion à la bdd.';

        }

        $estEdit = true;

        //Compression du commentaire
        $commentaire = gzdeflate($commentaire, 9);
        try{

            $sql = "UPDATE commentaire SET dateLastModification = :date, commentaire = :commentaire, adresseIp = :ip WHERE idcom = :idcom";
            $resultCommentaire=DbManager::$cnx->prepare($sql);
            $resultCommentaire->bindParam(':idcom', $idCommentaire);
            $resultCommentaire->bindParam(':date', $date);
            $resultCommentaire->bindParam(':ip', $ipUser);
            $resultCommentaire->bindParam(':commentaire', $commentaire);
            $resultCommentaire->execute();

        }catch(PDOException $e){

            $estEdit = false;

        }

        return $estEdit;

        
    }


    /**
     * SupprimerCommentaire
     * Set un commentaire en invisible, il sera toujours en bdd mais non affiché.
     * Retourne true si le commentaire est supprimé
     *
     * @return bool
     */
    public static function SupprimerCommentaire($idCommentaire){

        // Connexion bdd
        DbManager::getConnexion();
        // Affichage d'erreur en cas de non connexion à la base de données.
        if(DbManager::getConnexion() == null ){

            echo 'Erreur de connexion à la bdd.';

        }

        $estSuppr = true;

        //Date de suppression
        $date = new DateTime();
        $date = $date->format('Y-m-d');

        try{
            //Met le commentaire en invisible et ajoute la date du jour
            $sql = "UPDATE commentaire SET estVisible = 0, dateSuppression = :date WHERE idCom = :idCommentaire";
            $resultCommentaire=DbManager::$cnx->prepare($sql);
            $resultCommentaire->bindParam(':idCommentaire', $idCommentaire);
            $resultCommentaire->bindParam(':date', $date);
            $resultCommentaire->execute();

        }catch(PDOException $e){

            $estSuppr = false;
        }



        return $estSuppr;

        
    }

}