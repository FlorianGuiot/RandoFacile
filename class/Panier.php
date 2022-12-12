<?php
use Number\Utils;
use Number\Utils\NombreFormatter;
/**
 * Description de la class Panier
 * 
 * 
 * @auteur F. Guiot
 */

class panier{

    protected array $panier = array();
    protected float $minFraisLivraison = 50; //Montant minimal pour avoir la livraison gratuite
    protected float $fraisLivraison = 10; //Frais de livraison

    /**
     * Constructeur de panier.
     */
    public function __construct()
    {


    }

    /**
     * Retourne le panier de l'utilisateur.
     * 
     * @return array
     */
    public function GetPanier(){

        return $this->panier;

    }

    /**
     * Ajoute un produit au panier.
     * 
     * @return void
     */
    public function AddProduit(produit $produit, int $qte){

        array_push($this->panier, [
                                    'produit' => $produit,
                                    'qte' => $qte

                                    ]);

    }

    /**
     * Retire un produit du panier cookies.
     * 
     * @return void
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
     * Retire tous les produits du panier.
     * 
     * @return void
     */
    public function RemoveProduitsAll(){

        //Remet le panier à 0
        $this->panier = array();

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

        if($total != 0){

            $total +=  $this->GetFraisLivraison();
            
        }

        return $total;

    }


    /**
     * GetPrixTotalHT()
     * Retourne le cout total HT du panier en float
     * 
     * @return float
     */
    public function GetPrixTotalHT(){
        
        $total = 0;

        foreach($this->panier as $unP){

            $total += $unP['produit']->CalculerMontantHT($unP['qte']);

        }

        if($total != 0){

            $total +=  $this->GetFraisLivraison();

        }
        

        return $total;

    }


    /**
     * GetPrixTotalHT()
     * Retourne le montant de la TVA du panier en float
     * 
     * @return float
     */
    public function GetMontantTVA(){

        $tva = $this->GetPrixTotal() - $this->GetPrixTotalHT();
        

        return $tva;

    }

    /**
     * GetFraisLivraison()
     * Retourne le montant des frais de livraison
     * 
     * @return float
     */
    public function GetFraisLivraison(){

        $frais = 0;

        $total = 0;

        foreach($this->panier as $unP){

            $total += $unP['produit']->CalculerMontant($unP['qte']);

        }

        if($total <= $this->minFraisLivraison){

           $frais += $this->fraisLivraison;
    
        }

        return $frais;

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


        $html = '<div class="d-flex justify-content-center m-2"><a href="index.php?controller=Panier&action=read" class="btn btn-primary">Mon panier</a></div>'. 
                '<div class="d-flex justify-content-center"><p>Total : '.NombreFormatter::GetNombreFormatFr($this->GetPrixTotal()).' €  TTC</p></div> <div class="panier-container">';

        foreach($this->panier as $unP){
            

            $html .= '<div id="'.$unP['produit']->GetId().'" class="dropdown-item lignePanier"><a class="lien " href="'.$unP['produit']->GetLienProduit().'"><img height="40" src="'.$unP['produit']->GetLiensImage()[0].'"> '.$unP['produit']->GetLibelle().'</a>'.
            '<div class="row mt-1">'.
            '<div class="col-6">'.
            '<input  id="qteProduitLignePanier" type="number"  class="form-control qteProduitLignePanier" value="'.$unP['qte'].'" max="'.$unP['produit']->GetQteEnStock().'" min="1">'.
            '</div>'.
            '<div class="col-6 overflow-hidden">'.
            '<button id="BtnRemoveLignePanier" class="btn btn-sm btn-danger BtnRemoveLignePanier"><i class="fa-solid fa-trash"></i></button>   '.NombreFormatter::GetNombreFormatFr($unP['produit']->CalculerMontant($unP['qte'])).'€'.
            '</div>'.
            '</div></div>';

        }
        
        $html .= "</div>";

        return $html;
    }



}

?>