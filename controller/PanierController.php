<?php


class PanierController{

    /**
     * GetPanier()
     * Retourne le panier de l'utilisateur dans un tableau associatif : Produit, Quantité
     * 
     * @return array
     */
    public static function GetPanier(){

        $panier = array();

        //Si l'utilisateur est connecté -> on récupère le panier en base de donnée
        if(isset($_SESSION['iduser'])){

            $panier = PanierManager::GetPanierById($_SESSION['iduser']);


        } //Si l'utilisateur est déconnecté -> on récupère le panier depuis les cookies
        else{


        }

        return $panier;
    }


    /**
     * GetAffichagePanier($panier)
     * Retourne le panier de l'utilisateur dans un code HTML
     * 
     * @return string
     */
    public static function GetAffichagePanier(array $panier){


        $html = '<div class="d-flex justify-content-center m-2"><button id="BtnVoirLePanier" class="btn btn-primary">Voir le panier</button></div>'. 
                '<div class="d-flex justify-content-center"><p>Total : '.self::GetPrixPanier($panier).' €</p></div>';

        foreach($panier as $unP){
            
            $html .= '<a class="dropdown-item" href="#"><img height="40" src="'.$unP['produit']->GetLiensImage()[0].'"> '.$unP['produit']->GetLibelle().'</a>';

        }
        

        return $html;
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
        array_push($panierInfo, self::GetAffichagePanier(self::GetPanier($lePanier))); //Le panier au format html
        array_push($panierInfo, self::GetNbrProduitsPanier($lePanier)); //Le nombre de produit dans le panier

        echo json_encode($panierInfo);

    }


    /**
     * GetNbrProduitPanier($panier)
     * Retourne le nombre de produit dans le panier (sans prendre compte de la quantité)
     * 
     * @return int
     */
    public static function GetNbrProduitsPanier(array $panier){
        
        return count($panier);

    }


    /**
     * EstDansLePanier($panier, $produit)
     * Retourne true si le produit mis en parametre se trouve dans le panier de l'utilisateur
     * 
     * @return bool
     */
    public static function EstDansLePanier(array $panier, $produit){

        $estDansLePanier = false;

        return $estDansLePanier;

    }

    /**
     * GetPrixPanier($panier)
     * Retourne le cout total du panier en float
     * 
     * @return float
     */
    public static function GetPrixPanier(array $panier){
        
        $total = 0;

        foreach($panier as $unP){

            $total += $unP['produit']->CalculerMontant($unP['qte']);

        }

        return $total;

    }



    /**
     * AffichagePanier()
     * Echo le panier de l'utilisateur dans un code HTML
     * 
     * @return array
     */
    public static function AffichageNbrProduitsPanier(){

        echo self::GetAffichagePanier(self::GetPanier());

    }


    /**
     * AddPanier($idProduit,$qte)
     * Ajoute un produit au panier de l'utilisateur dans la bdd
     * Retourne true si le produit est bien ajouté
     * 
     * @return int
     */
    public static function AddPanier(){

        date_default_timezone_set('Europe/Paris');
        $dateDuJour = date('Y-m-d H:i:s', time()); //Date de l'ajout dans le panier
        
        //Si l'utilisateur est connecté -> on ajoute le panier en base de donnée
        if(isset($_SESSION['iduser'])){

            $produit = ProduitsManager::getProduitParId($_POST['idProduit']);

            $add = PanierManager::AddPanier($produit,$_POST['qte'],$_SESSION['iduser'],$dateDuJour);


        } //Si l'utilisateur est déconnecté -> on ajoute le panier dans les cookies
        else{


        }
        

        //Ajax ne peut recevoir de booleen, on remplace la valeur par un 1 ou un 0
        $retour = 0;

        if($add = true){

            $retour = 1;
        }

        echo $retour;
    }



    



}

?>