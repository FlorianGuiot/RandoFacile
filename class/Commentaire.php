<?php
/**
 * Description de la class commentaire
 * 
 * 
 * @auteur F. Guiot
 */

class commentaire{

    private int $id;
    private utilisateur $user;
    private string $commentaire;
    private ?int $note;
    private DateTime $date;
    private string $dateFormatee;
    private string $dateFormateeHeures;
    private produit $produit;
    private ?DateTime $dateLastModification;


    /**
     * Constructeur de Commentaire.
     */
    public function __construct(int $id = 0, utilisateur $user = null, string $commentaire = "", int $note = null, DateTime $date = null, string $dateFormatee = "",string $dateFormateeHeures = "", produit $produit = null, DateTime $dateLastModification = null)
    {
        $this->id = $id;
        $this->user = $user;
        $this->commentaire = $commentaire;
        $this->note = $note;
        $this->date = $date;
        $this->dateFormatee = $dateFormatee;
        $this->dateFormateeHeures = $dateFormateeHeures;
        $this->produit = $produit;
        $this->dateLastModification = $dateLastModification;

    }

    /**
     * Retourne l'id du commentaire.
     */
    public function GetId(){

        return $this->id;

    }

    /**
     * Retourne le commentaire (texte)
     */
    public function GetCommentaire(){

        return gzinflate($this->commentaire);

    }

    /**
     * Retourne la note
     */
    public function GetNote(){

        return $this->note;

    }

    /**
     * Retourne la date d'ajout
     */
    public function GetDate(){

        return $this->date;

    }

    /**
     * Retourne la date d'ajout au format : D dd M yyyy
     * Ex : Mercredi 09 janvier 2002
     */
    public function GetDateFormatee(){

        return $this->dateFormatee;

    }

    /**
     * Retourne l'heure et les minutes d'ajout au format : hh "h" mm
     */
    public function GetDateFormateeHeures(){

        return $this->dateFormateeHeures;

    }


    /**
     * Retourne l'auteur
     */
    public function GetUser(){

        return $this->user;

    }

    /**
     * Retourne le produit
     */
    public function GetProduit(){

        return $this->produit;

    }

    /**
     * Retourne la date de la dernière modification
     */
    public function GetDateLastModification(){

        return $this->dateLastModification;

    }

    /**
     * Retourne la date de la dernière modification écrite
     */
    public function GetDateLastModificationString(){

        return 'Modifié le '.$this->dateLastModification->format('d/m/Y');

    }


    /**
     * Retourne true si l'utilisateur peut modifier le commentaire
     */
    public function EstModifiable(){

        $estSupprimable = false;

        if(isset($_SESSION['iduser'])){


            $user = UserManager::getUserById($_SESSION['iduser']);

            if($_SESSION['iduser'] == $this->user->GetId() || $user->estAdmin()){

                $estSupprimable = true;
    
            }

        }
        

        return $estSupprimable;

    }


    /**
     * Retourne l'affichage de la note du commentaire
     */
    public function AffichageNote(){

        $html = "";

        //Si le commentaire contient une note
        if($this->note != null){

            for($i = 1; $i <= $this->note; $i++){

                $html .= '<span class="fa fa-star rating_checked"></span>';

            }
            for($i = 5; $i > $this->note; $i--){

                $html .= '<span class="fa fa-star rating_unchecked"></span>';

            }
        }
        return $html;

    }

}

?>