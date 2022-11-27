<?php
/**
 * Description de la class Produit
 * 
 * 
 * @auteur F. Guiot
 */

class produit{

    private int $id;
    private string $libelle = "Erreur";
    private string $resume;
    private string $description;
    private categorie $categorie;
    private string $date;
    private int $qte;
    private float $prix;
    private array $lesImages = array();
    private array $lesCommentaires = array();
    private ?float $noteMoyenne;
    


    /**
     * Constructeur de produit.
     */
    public function __construct(int $id = 0, string $libelle = "Erreur", string $resume = "", string $description = "", string $lienImage = null, string $lienImage2 = null, string $lienImage3 = null, string $lienImage4 = null, string $date = "", int $qte = 0, float $prix = 0, categorie $Categ = null)
    {
        $this->id = $id;
        $this->libelle = $libelle;
        $this->resume = $resume;
        $this->description = $description;
        $this->date = $date;
        $this->qte = $qte;
        $this->prix = $prix;
        
        $this->categorie = $Categ;
        array_push($this->lesImages, $lienImage,$lienImage2,$lienImage3,$lienImage4);
        


    }

    /**
     * Retourne l'id du produit.
     */
    public function GetId(){

        return $this->id;

    }

    /**
     * Retourne le titre du produit.
     */
    public function GetLibelle(){

        return $this->libelle;

    }

    /**
     * Retourne le resumé du produit.
     */
    public function GetResume(){

        return $this->resume;

    }

    /**
     * Retourne la description du produit.
     */
    public function GetDescription(){

        return $this->description;

    }

    /**
     * Retourne la note moyenne du produit.
     */
    public function GetNoteMoyenne(){

        return number_format((float)$this->noteMoyenne, 1, '.', '');

    }

    /**
     * Retourne un tableau les liens des images.
     */
    public function GetLiensImage(){

        return $this->lesImages;

    }


    /**
     * Retourne le libelle categorie.
     */
    public function GetCategorie(){

        return $this->categorie;

    }

    /**
     * Retourne la quantité en stock.
     */
    public function GetQteEnStock(){

        return $this->qte;

    }

    /**
     * Retourne le prix unitaire.
     */
    public function GetPrixUnitaire(){

        return $this->prix;

    }

    /**
     * Retourne la date d'ajout.
     */
    public function GetDateAjout(){

        return $this->date;

    }

    /**
     * Retourne les commentaires.
     */
    public function GetLesCommentaires(){

        return $this->lesCommentaires;

    }

    /**
     * Retourne le nombre de notes qu'a reçu le produit.
     */
    public function GetNbrNotes(){

        $nbr = 0;

        foreach($this->lesCommentaires as $unC){

            if($unC->GetNote() != null){
                $nbr ++;
            }
        }

        return $nbr;
    }


    /**
     * Retourne 1 si le produit est en stock, 0 si il reste moins de 11 produits en stock, -1 si le produit est en rupture de stock.
     */
    public function EstEnStock(){

        $retour = 1; // En Stock

        if($this->qte==0){ // Rupture de stock

            $retour = -1;

        }
        else if($this->qte<=10){ // Plus que 10 articles en stock

            $retour = 0;

        }


        return $retour;

    }


    /**
     * Retourne "en stock" vert, "en stock" organge, ou "rupture de stock" rouge
     */
    public function GetAffichageStock(){

        $html = "<span class='stockPlein'>En stock</span>"; // En Stock

        if($this->EstEnStock()==-1){ // Rupture de stock

            $html = "<span class='stockVide'>Rupture de stock</span>";

        }
        else if($this->EstEnStock()==0){ // Plus que 10 articles en stock

            $html = "<span class='stockMoyen'>En stock</span>";

        }


        return $html;

    }


    /**
     * Retourne le montant d'un produit pour une quantité hors taxe.
     */
    public function CalculerMontant($uneQuantite){

        return $this->prix * $uneQuantite;

    }


    /**
     * Ajoute une note moyenne au produit
     */
    public function SetNoteMoyenne($note){

        $this->noteMoyenne = $note;

    }


    /**
     * Ajoute un commentaire au produit
     */
    public function AddCommentaire($unCommentaire){

        array_push($this->lesCommentaires, $unCommentaire);

    }

}

?>