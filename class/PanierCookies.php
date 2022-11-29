<?php
/**
 * Description de la class PanierCookie
 * 
 * 
 * @auteur F. Guiot
 */

class panierCookie extends panier{

    /**
     * Constructeur de panier.
     */
    public function __construct()
    {
        parent::__construct();

    }

    /**
     * Ajoute un produit au panier cookies.
     */
    public function AddProduit(produit $produit, int $qte){

        $idProduit = $produit->GetId();

        //Ligne du panier, 1 si celui est vide
        $nbrLignes = 0;

        //Verifie si le panier n'est pas vide
        if(isset($_COOKIE['panier'])){

            //Si le panier n'est pas vide, le prochain produit sera à la precedent + 1
            $nbrLignes = count($_COOKIE['panier']);

            //Verifie si le produit n'est pas déja dans le panier
            foreach($_COOKIE['panier'] as $name => $value){
    
                $ligne = json_decode($value, true);

                if(isset($ligne['idProduit'] )){

                    if($ligne['idProduit'] == $idProduit){

                        //La ligne ajouté sera celle du produit, ainsi il sera juste modifié
                        $nbrLignes = $name;
            
                    }
                    
                }
            }

        }

        
        
        //Ajoute le produit au panier
        $lignePanier = [
                            'idProduit' => $idProduit,
                            'qte' => $qte

                        ];

        $lignePanier = json_encode($lignePanier);
        setcookie("panier[".$nbrLignes."]",$lignePanier,time() + (86400 * 15), "/"); //Cookies valable 15 jours.

        //Ajoute le produit au panier
        parent::AddProduit($produit,$qte);

    }

    /**
     * Retire un produit du panier cookies.
     */
    public function RemoveProduit(produit $produit){

        $idProduit = $produit->GetId();

        //Supprimer le produit du panier cookie
        if(isset($_COOKIE['panier'])){

            foreach($_COOKIE['panier'] as $name => $value){
            
                $ligne = json_decode($value, true);

                if(isset($ligne['idProduit'] )){

                    if($ligne['idProduit'] == $idProduit){
                        
                        setcookie('panier['.$name.']', false, time() - 3600, '/');
                        unset($_COOKIE['panier'][$name]);
            
                    }

                }

            }

        }
        
        //Retire le produit du panier
        parent::RemoveProduit($produit);

    }

}

?>