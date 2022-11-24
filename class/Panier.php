<?php
/**
 * Description de la class Panier
 * 
 * 
 * @auteur F. Guiot
 */

class panier{

    private array $panier = array();


    /**
     * Constructeur de panier.
     */
    public function __construct()
    {


    }

    /**
     * Retourne le panier de l'utilisateur.
     */
    public function GetPanier(){

        return $this->panier;

    }

    /**
     * Ajoute un produit au panier.
     */
    public function AddProduit(produit $produit, int $qte){

        array_push($this->panier, [
                                    'produit' => $produit,
                                    'qte' => $qte

                                    ]);

    }


    /**
     * GetNbrProduits()
     * Retourne le nombre de produit dans le panier (sans prendre compte de la quantité)
     * 
     * @return int
     */
    public function GetNbrProduits(){
        
        return count($this->panier);

    }


    /**
     * GetPrixTotal()
     * Retourne le cout total du panier en float
     * 
     * @return float
     */
    public function GetPrixTotal(){
        
        $total = 0;

        foreach($this->panier as $unP){

            $total += $unP['produit']->CalculerMontant($unP['qte']);

        }

        return $total;

    }


    /**
     * EstDansLePanier($produit)
     * Retourne true si le produit mis en parametre se trouve dans le panier
     * 
     * @return bool
     */
    public function EstDansLePanier($produit){

        $estDansLePanier = true;

        if(!array_search($produit, $this->panier)){

            $estDansLePanier = false;
            
        }

        return $estDansLePanier;

    }



}

?>