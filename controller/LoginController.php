<?php


class LoginController{

    private static string $passwordPatern = '/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[!@#$%^&*]).{8,}$/';


    /**
     * Connexion
     */
    public static function connexion($params){

            
        
        /*
        ====================
        Test le mot de passe utilisateur
        ====================
        */

        // Test si le mail existe
        $user = UserManager::getUserByEmail($_POST['email']);

        $connexion = false;
        // Si l'utilisateur existe
        if($user != null){

            //Test le mot de passe, retourne true si valide
            $connexion = UserManager::testUserPassword($user,$_POST['password']);

            if($connexion==true){
                
                //Utilisateur connecté
                self::connexionNewSession($user);
                
            }
        }
        
        
        echo $connexion;

    }


    /**
     * ConnexionSession
     */ 
    public static function connexionNewSession($user){

        //Récupère le panier stocké dans les cookies
        $lePanier = PanierController::GetPanier();
        
        //Utilisateur connecté
        $_SESSION["iduser"] = $user->GetId();
        $_SESSION["email"] = $user->GetEmail();

        //Ajout du panier cookie au compte de l'utilisateur
        PanierController::SetPanier($lePanier);

        //Détruit le panier cookie
        $lePanier->RemoveProduitsAll();
        
    }





    /**
     * Procèdure de deconnexion
     */
    public static function disconnect($params){

        $user = UserManager::getUserByEmail($_SESSION["email"]);

        // Deconnexion
        session_unset();

        //Retourne le prénom de l'utilisateur.
        echo $user->GetPrenom();
    }



     /**
     * Procèdure de d'inscription
     * Retourne 0 Si passage à l'étape 2
     * Retourne une erreur Si mail déja existant
     * Retourne une erreur Si mot de passe non conforme
     * Retourne une erreur Si mots de passe non identiques
     * Retourne une erreur Si email non valide
     */
    public static function inscriptionEtape1($params){

        $erreur = "";

        /*
        ====================
        Test le mail et le mot de passe de l'utilisateur 
        ====================
        */



        //Test si le mail est bien un mail
        if(filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){

            // Test si le mail existe déja
            $user = UserManager::getUserByEmail($_POST['email']);


            //Si un utilisateur possede l'adresse email retourne erreur 1
            if($user != null){

                $erreur = "L'adresse email est déja utilisée.";
            
            //Si mot de passe non conforme retourne erreur 2
            }else if(!preg_match(self::$passwordPatern,$_POST['password'])){

                $erreur = "Le mot de passe n'est pas conforme.";
            
            //Si mots de passe non identiques retourne erreur 3
            }else if($_POST['password'] != $_POST['confpassword']){

                $erreur = "Les mots de passe ne sont pas les memes.";

            }
        
        //Email non valide
        }else{

            $erreur = "L'adresse email n'est pas au bon format.";

        }
        
        

        echo $erreur;
        return $erreur;


    }


    /**
     * Affiche l'étape 2 de l'inscription si aucune erreur de reçu
     */
    public static function ReadEtape2($params){

        // Variables
        $params['page_name'] = "Inscription";

        //Affichage de l'étape 2
        require_once("./view/register/register.php"); // Page étape 2
        
    }

    /**
     * Retourne true si la date reçu est inferieur à la date du jour 
     */
    public static function testDateNaissance($date){

        $dateValide = true;

        $date = new DateTime($date);
        $dateDuJour = new DateTime();
        
        if(preg_match("/-/",date_diff($date,$dateDuJour)->format('%R%d days'))){

            $dateValide = false;
        }
        
        return $dateValide;
    }


    /**
     * Procèdure de d'inscription de la deuxieme etape
     * Retourne les erreur de l'étape 1 avec en plus :
     * Retourne une erreur nom ou prénom trop court
     * Retourne une erreur si date de naissance non valide
     */
    public static function inscriptionEtape2($params){

        $erreur = self::inscriptionEtape1($params);

        //Si il n'y a pas d'erreur lors de la première étape
        if($erreur == ""){ 

            if(!isset($_POST['nom']) || strlen(trim($_POST['nom'])) <= 0 || !isset($_POST['prenom']) || strlen(trim($_POST['prenom'])) <= 0){

                $erreur = 'Nom ou prénom non rempli';

            }elseif(!self::testDateNaissance($_POST['dateNaissance'])){

                $erreur = 'Votre date de naissance est invalide';

            }else{

                //Inscrit l'utilisateur
                $params['nom'] = $_POST['nom'];
                $params['prenom'] = $_POST['prenom'];
                $params['dateNaissance'] = $_POST['dateNaissance'];
                $params['email'] = strtolower($_POST['email']);
                $params['password'] = $_POST['password'];

                if($params['dateNaissance'] == null){

                    $params['dateNaissance'] = "0000-00-00";

                }

                $add = self::CreateNewUser($params);

                //Si une erreur lors de l'ajout
                if(!$add){

                    $erreur = 'Un problème est survenu lors de la création de votre compte. Veuillez réessayer.';
                    
                }
            }

        }
        
        

        echo $erreur;
        

    }


    /**
     * Modifie les informations de l'utilisateur
     */
    public static function ModifierProfil($params){

        $userAModifier = UserManager::getUserById($_SESSION['iduser']);
        $erreur='';

        //Test si le mail est bien un mail
        if(filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){

            // Test si le mail existe déja
            $user = UserManager::getUserByEmail($_POST['email']);


            //Si un utilisateur possede l'adresse email retourne erreur 1
            if($user != null && $user != $userAModifier){

                $erreur = "L'adresse email est déja utilisée.";
            
            }
        
        //Email non valide
        }else{

            $erreur = "L'adresse email n'est pas au bon format.";

        }



        //Si il n'y a pas d'erreur lors de la première étape
        if($erreur == ""){ 

            if(!isset($_POST['nom']) || strlen(trim($_POST['nom'])) <= 0 || !isset($_POST['prenom']) || strlen(trim($_POST['prenom'])) <= 0){

                $erreur = 'Nom ou prénom non rempli';

            }elseif(!self::testDateNaissance($_POST['dateNaissance'])){

                $erreur = 'Votre date de naissance est invalide';

            }else{

                //Update l'utilisateur

                $add = UserManager::UpdateUserInfo($_POST['nom'],$_POST['prenom'],$_POST['dateNaissance'],strtolower($_POST['email']),$userAModifier->GetId());

                //Si une erreur lors de l'ajout
                if(!$add){

                    $erreur = 'Un problème est survenu lors de la modification de votre compte. Veuillez réessayer plus tard.';
                    
                }
            }

        }
        
        require_once './controller/EspaceMembreController.php';

        if($erreur == ""){

            EspaceMembreController::read();

        }else{

            $params['erreur'] = $erreur;
            EspaceMembreController::readModifierInformations($params);
        }
    
        

    }




    /**
     * Modifie les informations de securité de l'utilisateur
     */
    public static function ModifierSecurite($params){

        $userAModifier = UserManager::getUserById($_SESSION['iduser']);
        $erreur='';


        if(!preg_match(self::$passwordPatern,$_POST['password'])){

            $erreur = "Le mot de passe n'est pas conforme.";
        
        //Si mots de passe non identiques retourne erreur 3
        }else if($_POST['password'] != $_POST['confpassword']){

            $erreur = "Les mots de passe ne sont pas les memes.";

        }


        //Si il n'y a pas d'erreur lors de la première étape
        if($erreur == ""){ 

            //Update le mot de passe de l'utilisateur

            $add = UserManager::UpdateUserPassword($_POST['password'],$userAModifier->GetId());

            //Si une erreur lors de l'ajout
            if(!$add){

                $erreur = 'Un problème est survenu lors de la modification de votre compte. Veuillez réessayer plus tard.';
                
            }

        }
        
        require_once './controller/EspaceMembreController.php';

        if($erreur == ""){

            EspaceMembreController::read();

        }else{

            $params['erreur'] = $erreur;
            EspaceMembreController::readModifierSecurite($params);
        }
    
        

    }



    /**
     * Ajoute un utilisateur dans la bdd
     * Connect l'utilisateur si aucune erreur
     * Retourne true si ajouté.
     */
    public static function CreateNewUser($params){
        

        //Date d'inscription
        $dateInscription = new DateTime();
        $dateInscription = $dateInscription->format('Y-m-d');
        
        //Hash du mot de passe
        $params['password'] = password_hash($params['password'], PASSWORD_BCRYPT);

        $add = UserManager::AddUser($params['nom'],$params['prenom'],$params['dateNaissance'],$dateInscription,$params['email'],$params['password']);

        if($add == true){
            
            $user = UserManager::getUserByEmail($params['email']);
            
            if($user != null){
                //Utilisateur connecté
                self::connexionNewSession($user);
            }else{
                $add = false;
            }
            
        }

        return $add;

    }


}