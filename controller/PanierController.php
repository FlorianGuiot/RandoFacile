<?php


class PanierController{

    /**
     * GetPanier()
     * Retourne le panier de l'utilisateur 
     * 
     * @return panier
     */
    public static function GetPanier(){

        

        //Si l'utilisateur est connecté -> on récupère le panier en base de donnée
        if(isset($_SESSION['iduser'])){

            $panier = new panier();

            $panier = PanierManager::GetPanierById($_SESSION['iduser']);


        } //Si l'utilisateur est déconnecté -> on récupère le panier depuis les cookies
        else{

            $panier = new panierCookie();

            if(isset($_COOKIE['panier'])){

                foreach($_COOKIE['panier'] as $name => $value){
        
                    $ligne = json_decode($value, true);

                    if(isset($ligne['idProduit'] )){

                        $produit = ProduitsManager::getProduitParId($ligne['idProduit']);

                        $panier->AddProduit($produit,(int)$ligne['qte']);
                        
                    }
                }



            }
        }

        return $panier;
    }


    /**
     * AddPanier($idProduit,$qte)
     * Ajoute un produit au panier de l'utilisateur dans la bdd
     * Retourne true si le produit est bien ajouté
     * 
     * @return int
     */
    public static function AddPanier(){

        $produit = ProduitsManager::getProduitParId($_POST['idProduit']);
        
        
        //Si l'utilisateur est connecté -> on ajoute le panier en base de donnée
        if(isset($_SESSION['iduser'])){

            date_default_timezone_set('Europe/Paris');
            $dateDuJour = date('Y-m-d H:i:s', time()); //Date de l'ajout dans le panier

            $add = PanierManager::AddPanier($produit,$_POST['qte'],$_SESSION['iduser'],$dateDuJour);


        } //Si l'utilisateur est déconnecté -> on ajoute le panier dans les cookies
        else{

            $lePanier = self::GetPanier();
            $lePanier->AddProduit($produit,$_POST['qte']);
            
            $add = true;

        }
        

        //Ajax ne peut recevoir de booleen, on remplace la valeur par un 1 ou un 0
        $retour = 0;

        if($add == true){

            $retour = 1;
        }

        echo $retour;
    }



    /**
     * RemovePanier($idProduit)
     * Retire un produit du panier de l'utilisateur dans la bdd
     * Retourne true si le produit est bien retiré
     * 
     * @return int
     */
    public static function RemovePanier(){
        
        $produit = ProduitsManager::getProduitParId($_POST['idProduit']);
        
        //Si l'utilisateur est connecté -> on ajoute le panier en base de donnée
        if(isset($_SESSION['iduser'])){


            $remove = PanierManager::RemovePanier($produit,$_SESSION['iduser']);


        } //Si l'utilisateur est déconnecté -> on ajoute le panier dans les cookies
        else{

            $lePanier = self::GetPanier();

            $lePanier->RemoveProduit($produit);

            $remove = true;
        }


        

        //Ajax ne peut recevoir de booleen, on remplace la valeur par un 1 ou un 0
        $retour = 0;

        if($remove == true){

            $retour = 1;
        }

        echo $retour;
    }



    /**
     * AffichagePanier()
     * Retourne le panier de l'utilisateur dans un code HTML ainsi que le nombre de produits dans le panier
     * 
     * @return json
     */
    public static function AffichagePanier(){

        $lePanier = self::GetPanier(); //Le panier de l'utilisateur

        $panierInfo = array();

        array_push($panierInfo, $lePanier->GetAffichagePanier()); //Le panier au format html
        array_push($panierInfo, $lePanier->GetNbrProduits()); //Le nombre de produit dans le panier

        echo json_encode($panierInfo);

    }



}

?>