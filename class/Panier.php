<?php
/**
 * Description de la class Panier
 * 
 * 
 * @auteur F. Guiot
 */

class panier{

    protected array $panier = array();


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
     * Retire un produit du panier cookies.
     */
    public function RemoveProduit(produit $produit){

        //Supprime le produit du tableau panier
        foreach($this->panier as $unP){

            if($key = array_search($produit->GetId(),$this->panier) !== false){
                unset($this->panier[$key]);
            }
        }

    }


    /**
     * GetNbrProduits()
     * Retourne le nombre de produit dans le panier (sans prendre compte de la quantité)
     * 
     * @return int
     */
    public function GetNbrProduits(){
        
        $total = 0;

        foreach($this->panier as $unP){

            $total += $unP['qte'];
        }

        return $total;

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

        $estDansLePanier = false;

        foreach($this->panier as $unP){

            if($unP['produit']->GetId() == $produit->GetId()){
                $estDansLePanier = true;
            }
        }
        return $estDansLePanier;

    }



    /**
     * GetAffichagePanier()
     * Retourne le panier de l'utilisateur dans un code HTML
     * 
     * @return string
     */
    public function GetAffichagePanier(){


        $html = '<div class="d-flex justify-content-center m-2"><button id="BtnVoirLePanier" class="btn btn-primary">Voir le panier</button></div>'. 
                '<div class="d-flex justify-content-center"><p>Total : '.$this->GetPrixTotal().' €</p></div> <div class="panier-container">';

        foreach($this->panier as $unP){
            
            
            $html .= '<div id="'.$unP['produit']->GetId().'"><a class="dropdown-item lignePanier" href="#"><img height="40" src="'.$unP['produit']->GetLiensImage()[0].'"> '.$unP['produit']->GetLibelle().
            '<div class="row mt-1">'.
            '<div class="col-6">'.
            '<input  id="qteProduitLignePanier" type="number"  class="form-control qteProduitLignePanier" value="'.$unP['qte'].'" max="'.$unP['produit']->GetQteEnStock().'" min="1">'.
            '</div>'.
            '<div class="col-6">'.
            '<button id="BtnRemoveLignePanier" type="button" class="btn btn-danger BtnRemoveLignePanier"><i class="fa-solid fa-trash"></i></button>'.
            '</div>'.
            '</div></a></div>';

        }
        
        $html .= "</div>";

        return $html;
    }



}

?>