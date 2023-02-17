<?php
/**
 * Description de la class pays
 * 
 * 
 * @auteur F. Guiot
 */

class pays{

    private int $id;
    private string $libelle = "";
    private string $abreviation = "";
    private float $frais = 0;



    /**
     * Constructeur de categorie.
     */
    public function __construct(int $id = 0, string $libelle = "", string $abreviation = "", float $frais = 0)
    {
        $this->id = $id;
        $this->libelle = $libelle;
        $this->abreviation = $abreviation;
        $this->frais = $frais;
    }

    /**
     * Retourne l'id du pays.
     */
    public function GetId(){

        return $this->id;

    }

    /**
     * Retourne le nom du pays.
     */
    public function GetLibelle(){

        return $this->libelle;

    }


    /**
     * Retourne l'abréviation du pays.
     */
    public function GetAbreviation(){

        return $this->abreviation;

    }


     /**
     * Retourne les frais de port supplémentaire du pays.
     */
    public function GetFrais(){

        return $this->frais;

    }

}

?>