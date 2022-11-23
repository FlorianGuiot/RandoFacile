<?php

/**
* Description de la class ProduitsManager
* Class qui gère les articles
*
* @auteur F. Guiot
*/

require_once("DbManager.php");
require_once("./class/Produit.php");


class ProduitsManager {

    //Requete de base permettant la récupération des produits
    static private string $requeteInfoProduits = 'SELECT distinct id,path_photo,libelle,prix_vente_uht,resume,codecateg,description,dateajout,qte_stock FROM produit ';

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

            array_push($lesProduits, new produit($result_produit['id'],$result_produit['libelle'],$result_produit['resume'],$result_produit['description'],$result_produit['path_photo'],$result_produit['dateajout'],$result_produit['qte_stock'],$result_produit['prix_vente_uht'], self::getCategorieParId($result_produit['codecateg'])) );
        
        }

        return $lesProduits;

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
        $sql=$requeteInfoProduits;


        //Tableau contenant toutes les variables de la recherche
        $lesMotsDansLaRecherche = array();


        //Si c'est une recherche par categorie
        if($idCateg != -1){

            $sql.='WHERE codecateg = ? ORDER BY dateajout DESC';
            array_push($lesMotsDansLaRecherche, $idCateg);

        }

        //Si c'est une recherche
        if($recherche != null){
	
			$sql = $sql."WHERE";
            
            //Place tous les mots de la recherche dans un tableau
            $lesMotsRecherche = explode(" ", $recherche);

            // Si plusieurs mots recherchés
            if(count($lesMotsRecherche) > 1){
                
                $cpt = count($lesMotsRecherche)-1;

                while($cpt>=0){

                    $unMot = "%".$lesMotsRecherche[$cpt]."%";

                    if($cpt==0){ // Si il n'y a plus de mot dans la liste, cloturer la requette.
                        $sql=$sql. ' (libelle LIKE ? OR resume LIKE ?)';
                        array_push($lesMotsDansLaRecherche, $unMot);
                        array_push($lesMotsDansLaRecherche, $unMot);
                    }
                    else{ // Si il reste des mots dans la liste, ajouter un OR.
                        $sql=$sql. ' (libelle LIKE ? OR resume LIKE ? ) OR ';
                        array_push($lesMotsDansLaRecherche, $unMot);
                        array_push($lesMotsDansLaRecherche, $unMot);
                    }

                    $cpt--;
                }

            }// Un seul mot recherché
            else{
                
                $rechercheRequete = "%".$recherche."%";
                $sql=$sql." libelle LIKE ? OR resume LIKE ? ORDER BY dateajout DESC";
                array_push($lesMotsDansLaRecherche, $rechercheRequete);
                array_push($lesMotsDansLaRecherche, $rechercheRequete);
            }

        }
        


        // Requete SQL avec limite et premier article par page.
        $sql = $sql." LIMIT ".$lastProduit.", ".$limit;
        $resultPage=DbManager::$cnx->prepare($sql);
        //Execute la requete et remplace les "?" par les mots du tableau "lesMotsDansLaRecherche"
        $resultPage->execute($lesMotsDansLaRecherche);

        if($resultPage->rowCount() >= 1){ // Un ou plusieurs resultats.

            while($result_produit=$resultPage->fetch()){

                array_push($lesProduits, new produit($result_produit['id'],$result_produit['libelle'],$result_produit['resume'],$result_produit['description'],$result_produit['path_photo'],$result_produit['dateajout'],$result_produit['qte_stock'],$result_produit['prix_vente_uht'], self::getCategorieParId($result_produit['codecateg'])) );
            
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
        $sql='SELECT distinct id,path_photo,libelle,prix_vente_uht,resume,codecateg,description,dateajout,qte_stock FROM produit ';


        //Tableau contenant toutes les variables de la recherche
        $lesMotsDansLaRecherche = array();


        //Si c'est une recherche par categorie
        if($idCateg != -1){

            $sql.='WHERE codecateg = ? ORDER BY dateajout DESC';
            array_push($lesMotsDansLaRecherche, $idCateg);

        }



        //Si c'est une recherche
        if($recherche != null){

            $sql = $sql."WHERE";

            //Place tous les mots de la recherche dans un tableau
            $lesMotsRecherche = explode(" ", $recherche);

            // Si plusieurs mots recherchés
            if(count($lesMotsRecherche) > 1){
                
                $cpt = count($lesMotsRecherche)-1;

                while($cpt>=0){

                    $unMot = "%".$lesMotsRecherche[$cpt]."%";

                    if($cpt==0){ // Si il n'y a plus de mot dans la liste, cloturer la requette.
                        $sql=$sql. ' (libelle LIKE ? OR resume LIKE ?)';
                        array_push($lesMotsDansLaRecherche, $unMot);
                        array_push($lesMotsDansLaRecherche, $unMot);
                    }
                    else{ // Si il reste des mots dans la liste, ajouter un OR.
                        $sql=$sql. ' (libelle LIKE ? OR resume LIKE ? ) OR ';
                        array_push($lesMotsDansLaRecherche, $unMot);
                        array_push($lesMotsDansLaRecherche, $unMot);
                    }

                    $cpt--;
                }

            }// Un seul mot recherché
            else{
                $rechercheRequete = "%".$recherche."%";
                $sql=$sql." libelle LIKE ? OR resume LIKE ? ORDER BY dateajout DESC";
                array_push($lesMotsDansLaRecherche, $rechercheRequete);
                array_push($lesMotsDansLaRecherche, $rechercheRequete);
            }

        }


        $resultPage=DbManager::$cnx->prepare($sql);
        //Execute la requete et remplace les "?" par les mots du tableau "lesMotsDansLaRecherche"
        $resultPage->execute($lesMotsDansLaRecherche);

        return $resultPage->rowCount();

    }




    /**
     * getCategorieParId
     * retourne le libelle categorie d'une categorie
     *
     * @return string
     */
    public static function getCategorieParId($idCateg){

        // Récupération de la catégorie.
        if($idCateg != 0){

            $sql='SELECT libelle FROM categories WHERE codecateg = :categ';
            $resultcateg=DbManager::$cnx->prepare($sql);
            $resultcateg->bindParam(':categ', $idCateg, PDO::PARAM_INT);
            $resultcateg->execute();
            $result_categ=$resultcateg->fetch();

            return $result_categ['libelle'];

        }
    }

}