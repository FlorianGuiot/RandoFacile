<?php
/**
 * Description de la class statut
 * 
 * 
 * @auteur F. Guiot
 */

class statut{

    private int $id;
    private string $libelle = "";


    /**
     * Constructeur de statut.
     */
    public function __construct(int $id = 0, string $libelle = "")
    {
        $this->id = $id;
        $this->libelle = $libelle;

    }

    /**
     * Retourne l'id du statut.
     */
    public function GetId(){

        return $this->id;

    }

    /**
     * Retourne le titre du statut.
     */
    public function GetLibelle(){

        return $this->libelle;

    }

}

?>