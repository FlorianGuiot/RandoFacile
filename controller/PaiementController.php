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
    public static function readPaiement($params){
        
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
     * Test si l'adresse de l'utilisateur est correcte. Test si l'utilisateur est connecté et si son panier n'est pas vide.
     */
    public static function TestValiderAdresse(){
        
        $erreur = self::TestValiderPanier(); // Test que l'utilisateur est bien connecté, panier non vide et qu'il a accepté CGV.

        //Les pays disponibles
        $lesPays = PaysManager::GetLesPays();
        $lesPaysId = array();

        foreach($lesPays as $unP){

            array_push($lesPaysId, $unP->GetId());

        }

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
            
        }else if(!in_array($_POST['paysSelect'],$lesPaysId)){//Test si le pays sélectionné est bien dans la liste

            $erreur = "Vous devez saisir un pays valide.";

        } 
        
        return $erreur;


    }


    /**
     * test si les informations de paiement sont acceptable ou non.
     * Si oui retourne vers la page de succès et ajoute la commande en BDD
     * Sinon retourne sur la page précédente avec une erreur
     */
    public static function testPaiement(){
        
        //Test que l'utilisateur a le droit d'etre sur cette page
        $erreur = self::TestValiderAdresse();

        //Paiement non valide par défaut
        $paiementValide = false;


        $lePanier = PanierController::GetPanier();
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

        $montantPaiement = $lePanier->GetPrixTotal() + $frais_pays;






        if($_POST['cbRadio'] == "CB"){//CB : Test des informations par carte

            if(empty($_POST['cvc'])){

                $erreur = "Informations de paiement incomplètes.";

            }else if(empty($_POST['numCarte'])){

                $erreur = "Informations de paiement incomplètes.";


            }else if(empty($_POST['dateCarte'])){

                $erreur = "Informations de paiement incomplètes.";


            }else{//Si aucune erreur demande de paiement a la banque

                //Appel fictif a l'API de la banque
                $paiementValide = true;

                if(!$paiementValide){

                    $erreur = "Echec de paiement.";
                }
            }



        }else{//Paypal : Simplement besoin de se connecter a Paypal

           //Appel fictif a l'API de paypal
           $paiementValide = true;

           if(!$paiementValide){

               $erreur = "Echec de paiement.";
           }

        }

        
        
        //Si pas d'erreur : Affiche la page de succès et ajoute la commande
        if($paiementValide){


            //Ajoute la commande
            $add = CommandeManager::AddCommande(DbManager::nettoyer($_POST['adresse']),DbManager::nettoyer($_POST['ville']),DbManager::nettoyer($_POST['CP']),DbManager::nettoyer($_POST['paysSelect']),DbManager::nettoyer($_POST['prenom']),DbManager::nettoyer($_POST['nom']),$_SESSION['iduser'],$lePanier->GetPanier());

            if($add){

                //Vide le panier
                PanierManager::ClearPanier($_SESSION['iduser']);

                //Information pour la page de succès
                $params['page_name'] = "Succès";
                $params['valider'] = true;
                $params['user_email'] = UserManager::getUserById($_SESSION['iduser'])->GetEmail();
                /*
                ====================
                Affichage de la page
                ====================
                */
                require_once("./view/commande/success.php"); // Page succès

            }else{

                $params['erreur_valider'] = "Erreur lors du passage de la commande. Veuillez ressayer plus tard.";
                self::readPaiement($params);

            }
            

        }else{ //Sinon retour a la page de paiement avec le message d'erreur

            
            $params['erreur_valider'] = $erreur;
            self::readPaiement($params);

        }

    }
}





?>