<?php
/**
 * Description de la class categorie
 * 
 * 
 * @auteur F. Guiot
 */

class categorie{

    private int $id;
    private string $libelle = "";


    /**
     * Constructeur de categorie.
     */
    public function __construct(int $id = 0, string $libelle = "")
    {
        $this->id = $id;
        $this->libelle = $libelle;

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

}

?>