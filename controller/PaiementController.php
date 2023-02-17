<?php
require_once("PanierController.php");
use Number\Utils;

class PaiementController{

    
    /**
     * Valide le panier de l'utilisateur avant de le rediriger vers le paiement
     */
    public static function readAdresse(){
        
        $erreur = self::TestValiderPanier();
        
        
        if($erreur == ""){
            //Affichage de la page commande

            $params['page_name'] = "Commande";
            $params['valider'] = true;
            $user = UserManager::getUserById($_SESSION['iduser']);
            $lePanier = PanierController::GetPanier();
            $lePanierListe = $lePanier->GetPanier();
            $lesPays = PaysManager::GetLesPays();
            $frais_pays = "Aucun frais supplémentaires.";

            if($lesPays[0]->GetFrais() != 0){

                $frais_pays = $lesPays[0]->GetFrais();

            }
            
            /*
            ====================
            Affichage de la page
            ====================
            */
            require_once("./view/commande/adresse.php"); // Page adresse

        }else{

            $params['erreur_valider'] = $erreur;
            PanierController::read($params);

        }
        

    }

    /**
     * Test si l'utilisateur peut valider le panier
     */
    public static function TestValiderPanier(){
        
        $erreur = "";

        if(!isset($_SESSION['iduser'])){

            $erreur = "Vous devez etre connecté.";

        }
        else if(!isset($_POST['checkbox_CGV'])){

            $erreur = "Vous devez accepter les conditions générales de vente.";

        }

        if($erreur == ""){

            $lePanier = PanierController::GetPanier();
            $lePanierListe = $lePanier->GetPanier();

            if(count($lePanierListe) <= 0){

                $erreur = "Vous devez remplir votre panier avant de passer commande.";

            }
        }
        
        return $erreur;


    }


    /**
     * Valide l'adresse de l'utilisateur
     */
    public static function readPaiement(){
        
        $erreur = self::TestValiderAdresse();
        
        
        if($erreur == ""){
            //Affichage de la page paiemant 

            $params['page_name'] = "Paiement";
            $params['valider'] = true;
            $user = UserManager::getUserById($_SESSION['iduser']);
            $lePanier = PanierController::GetPanier();
            $lePanierListe = $lePanier->GetPanier();
            $lesPays = PaysManager::GetLesPays();

            //Trouve les frais de port du pays sélectionné précédemment
            $i = 0;
            $frais_pays = null;
            while($i < count($lesPays) && $frais_pays == null){

                if($_POST['paysSelect'] == $lesPays[$i]->GetId()){
                    
                    $frais_pays = $lesPays[$i]->GetFrais();
                    
                }
                
                $i++;
            }

            /*
            ====================
            Affichage de la page
            ====================
            */
            require_once("./view/commande/paiement.php"); // Page paiement

        }else{

            $params['erreur_valider'] = $erreur;
            PanierController::read($params);

        }
        

    }


     /**
     * Test si l'utilisateur peut valider son adresse
     */
    public static function TestValiderAdresse(){
        
        $erreur = self::TestValiderPanier(); // Test que l'utilisateur est bien connecté, panier non vide et qu'il a accepté CGV.

        if(!isset($_POST['prenom']) || empty(trim($_POST['prenom'])) || preg_match("/[0-9]/",$_POST['prenom'])){

            $erreur = "Vous devez saisir un prénom valide.";

        }elseif(!isset($_POST['nom']) || empty(trim($_POST['nom'])) || preg_match("/[0-9]/",$_POST['nom'])){

            $erreur = "Vous devez saisir un nom valide.";
            
        }elseif(!isset($_POST['ville']) || empty(trim($_POST['ville'])) || preg_match("/[0-9]/",$_POST['ville'])){

            $erreur = "Vous devez saisir un nom de ville valide.";
            
        }elseif(!isset($_POST['CP']) || empty(trim($_POST['CP'])) || !is_numeric($_POST['CP'])){

            $erreur = "Vous devez saisir un code postal valide.";
            
        }elseif(!isset($_POST['paysSelect']) || empty(trim($_POST['paysSelect']))){

            $erreur = "Vous devez saisir un pays valide.";
            
        }
        
        return $erreur;


    }


    /**
     * test si le paiement est valide ou non.
     * Si oui retourne vers la page de succès et ajoute la commande en BDD
     * Sinon retourne sur la page précédente avec une erreur
     */
    public static function testPaiement(){
        
        $erreur = self::TestValiderAdresse();
        $paiementValide = true;
        
        if($erreur == ""){

            //Information pour la page de succès
            $params['page_name'] = "Succès";
            $params['valider'] = true;

            
            date_default_timezone_set('Europe/Paris');
            $dateDuJour = date('Y-m-d H:i:s', time()); //Date du jour

            if($_POST['cbRadio'] == "CB"){
                
                if(empty($_POST['cvc'])){

                    $erreur = "Echec de paiement ";

                }else if(empty($_POST['numCarte'])){

                    $erreur = "Echec de paiement ";


                }// }else if($_POST['dateCarte'] < $dateDuJour){

                //     $erreur = "Echec de paiement ";

                // }
                
            

            }

            if($erreur != ""){

                $paiementValide = true;

            }

        }else{

            $paiementValide = false;

        }
        
        if($paiementValide == true){
            /*
            ====================
            Affichage de la page
            ====================
            */
            require_once("./view/commande/success.php"); // Page succès

        }else{

            
            $params['erreur_valider'] = $erreur;
            self::readPaiement($params);

        }

    }
}





?>