<?php

use Date\Utils;


class ProduitController{

    /**
     * Affiche la page du produit
     */
    public static function read($params){

        //Le Produit à afficher
        $produit = ProduitsManager::getProduitParId($params['idProduit']);

        if($produit != null){

            $produit = self::SetNoteMoyenneProduit($produit); //Rajoute la note moyenne au produit
            
            //Commentaires du produit
            $lesCommentaires = ProduitsManager::getCommentairesProduit($produit);

            foreach($lesCommentaires as $unC){

                $produit->AddCommentaire($unC);

            }
            
            
            // Variables
            $params['page_name'] = $produit->GetLibelle();
            $page['produitExiste'] = true;
            $lePanier = PanierController::GetPanier();

            if(!isset($params['limiteCommentaires'])){

                $params['limiteCommentaires'] = 0;

            }

            $params['limiteCommentaires'] = self::GetLimiteCommentaires($params,$lesCommentaires);
            
            //Lien de retour à la recherche précedente 
            $page['lienRetour'] = self::GetLienPrecedent($params,$produit);
            $page['images'] = self::GetLienImagesSecondaires($params,$produit);

            

        }else{

            // Variables
            $params['page_name'] = "Erreur";
            $page['lienRetour'] = "";
            $page['images'] = "";
            $page['produitExiste'] = false;

        }
        


        
        
        /*
        ====================
        Affichage de la page
        ====================
        */
        require_once("./view/produit/produit.php"); // Page d'produit
    
    

    }


    /**
     * Retourne le lien de page precedement utilisé par l'utilisateur
     */
    public static function GetLienPrecedent($params,$produit){

        $lien = "<div class='lienRetourProduit'><a href='./index'>Accueil</a> > ";

        if(isset($params["recherche"])){

            $lien .= "<a href='index.php?controller=Recherche&action=read&recherche=".$params["recherche"]."'>".$params["recherche"]."</a> > <p class='pageActuelle'>".$produit->GetLibelle()."</p></div>";

        }else if(isset($params["idCateg"])){

            $categorie = ProduitsManager::getCategorieParId($params["idCateg"]);
            $lien .= "<a href='index.php?controller=Recherche&action=read&idCateg=".$params["idCateg"]."'>".$categorie->GetLibelle()."</a> > <p class='pageActuelle'>".$produit->GetLibelle()."</p></div>";

        }else{

            $lien = "";

        }

        return $lien;

    }


    /**
     * Retourne le code HTML des images secondaires 
     */
    public static function GetLienImagesSecondaires($params,$produit){

        $html = "";

        //Pour chaque lien d'image dans la liste "LiensImage" on rajoute le code HTML d'affichage.
        for($i = 1; $i <= count($produit->GetLiensImage()) - 1; $i++){


            $html .="<div class='col-4 d-flex justify-content-center'>
                    <img class='img-fluid produitImage' onclick='openImg(\"".$produit->GetLiensImage()[$i]."\",\"".$produit->GetLibelle()."\")' src='".$produit->GetLiensImage()[$i]."'>".
                    "</div>";
                

        }
        

        return $html;
    
    

    }


    /**
     * Ajoute la note moyenne a un produit
     */
    public static function SetNoteMoyenneProduit($produit){
    
        $produit->SetNoteMoyenne(ProduitsManager::getNoteMoyenneProduit($produit)); //Rajoute la note moyenne au produit

        return $produit;

    }


    /**
     * Retourne le nombre limite de commentaires a afficher
     * 
     */
    public static function GetLimiteCommentaires($params,$lesCommentaires){

        //Si la limite actuelle + 5 est supérieur au nombre de commentaires, la limite est = au nombre de commentaires
        if($params['limiteCommentaires'] + 5 > count($lesCommentaires)-1){

            $params['limiteCommentaires']  = count($lesCommentaires)-1;

        }else{
            //Dans le cas contraire, on rajoute 5 a la limite d'affichage
            $params['limiteCommentaires'] += 5;

        }
        
        return $params['limiteCommentaires'];

    }



    /**
     * Retourne le nombre limite de commentaire a afficher
     * 
     */
    public static function PostCommentaire($params){

        //Message d'erreur retourné, si vide alors aucune erreur
        $erreur = "";

        //Verifie si l'utilisateur est connecté
        if(isset($_SESSION["iduser"])){

            $user = UserManager::getUserById($_SESSION["iduser"]);

            if(ProduitsManager::EstCommentaireSpam($user,DbManager::nettoyer($_POST["idProduit"]))){

                $erreur = "Vous devez attendre avant de resposter un commentaire.";

            }else{

                //Verifie la taille du commentaire
                if(strlen($_POST["commentaire"]) <= 1024){

                    $ipUser = $_SERVER['REMOTE_ADDR']; //Adresse IP de l'utilisateur

                    date_default_timezone_set('Europe/Paris');
                    $dateDuJour = date('Y-m-d H:i:s', time()); //Date du commentaire

                    //Post le commentaire en BDD
                    $estAdd = ProduitsManager::AddCommentaire($user,$ipUser,DbManager::nettoyer($_POST["commentaire"]),$dateDuJour,DbManager::nettoyer($_POST["idProduit"]),$_POST['note']);
                    
                    if(!$estAdd){
                        $erreur = "Un problème est survenu lors de l'ajout du commentaire.";
                    }
                //Message trop long
                }else{

                    $erreur = "Votre commentaire est trop long.";

                }

            }
            
        //Utilisateur non connecté
        }else{

            $erreur = "Connectez-vous pour laisser un commentaire.";

        }
        
        echo $erreur;
        

    }



    /**
     * Modifie un commentaire
     * 
     */
    public static function EditCommentaire($params){

        //Message d'erreur retourné, si vide alors aucune erreur
        $erreur = "";

        //Verifie si l'utilisateur est connecté
        if(isset($_SESSION["iduser"])){

            $user = UserManager::getUserById($_SESSION["iduser"]); // Utilisateur connecté
            $leCommentaire = ProduitsManager::GetCommentaireById($_POST['id']); // Commentaire à modifier

            //Si l'utilisateur connecté est l'auteur du commentaire ou est admin
            if(($leCommentaire->GetUser()->GetId() == $_SESSION["iduser"]) || $user->estAdmin()){

                //Verifie la taille du commentaire
                if(strlen($_POST["commentaire"]) <= 1024){

                    $ipUser = $_SERVER['REMOTE_ADDR']; //Adresse IP de l'utilisateur

                    date_default_timezone_set('Europe/Paris');
                    $dateDuJour = date('Y-m-d H:i:s', time()); //Date de modification

                    //Edit le commentaire en BDD
                    $estEdit = ProduitsManager::EditCommentaire($_POST['id'],$ipUser,DbManager::nettoyer($_POST["commentaire"]),$dateDuJour);

                    if(!$estEdit){
                        $erreur = "Un problème est survenu lors de la modification du commentaire.";
                    }

                //Message trop long
                }else{

                    $erreur = "Votre commentaire est trop long.";

                }
                
            }
            
        //Utilisateur non connecté
        }

        echo $erreur;
        

    }




    /**
     * Supprime un commentaire
     * Retourne true si commentaire supprimé
     */
    public static function SupprimerCommentaire($params){

        $estSuppr = false;

        //Si l'utilisateur est connecté
        if(isset($_SESSION['iduser'])){

            $leCommentaire = ProduitsManager::GetCommentaireById($_POST['id']); //Commentaire à supprimer
            $user = UserManager::getUserById($_SESSION["iduser"]); //Utilisateur connecté

            //Si l'utilisateur connecté est l'auteur du commentaire ou est admin
            if(($leCommentaire->GetUser()->GetId() == $_SESSION["iduser"]) || $user->estAdmin()){

                //Supprime le commentaire
                $estSuppr = ProduitsManager::SupprimerCommentaire($_POST['id']);
                
            }

        }
        
        $erreur = "";
        
        if(!$estSuppr){
            $erreur = 'Un problème est survenu lors de la suppression du commentaire.';
        }

        echo $erreur;

    }

}

?>