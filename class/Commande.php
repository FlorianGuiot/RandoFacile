<?php
/**
 * Description de la class commande
 * 
 * @auteur F. Guiot
 */

class commande{

    //id de la commande
    private int $id;

    //Utilisateur
    private utilisateur $user;
    //Statuts de la commande
    private array $lesStatuts;

    //Adresse
    private string $adresse;
    private string $ville;
    private string $cp;
    private pays $pays;
    private string $nom;
    private string $prenom;

    //Tableau contenant la commande
    private panier $detailsCommande;


    /**
     * Constructeur de commande.
     */
    public function __construct(int $id = 0, utilisateur $user = null, string $adresse = "", string $ville = "", string $cp = "", pays $pays = null, string $nom = "", string $prenom = "", array $lesStatuts = null)
    {
        $this->id = $id;
        $this->user = $user;
        $this->adresse = $adresse;
        $this->ville = $ville;
        $this->nom = $nom;
        $this->prenom = $prenom;
        $this->cp = $cp;
        $this->pays = $pays;
        $this->lesStatuts = $lesStatuts;

    }

    /**
     * Retourne l'id de la commande.
     */
    public function GetId(){

        return $this->id;

    }

    /**
     * Retourne l'utilisateur qui a passé la commande.
     */
    public function GetUser(){

        return $this->user;

    }

    /**
     * Retourne les statuts de la commande.
     */
    public function GetLesStatuts(){

        return $this->lesStatuts;

    }


    /**
     * Retourne le statut de la commande.
     */
    public function GetLeStatut(){

        $statutPlusRecent = $this->lesStatuts[0];

        foreach($this->lesStatuts as $unStatut){

            $recentDate = strtotime($statutPlusRecent['date']);
            $statutDate = strtotime($unStatut['date']);

            
            if($statutDate > $recentDate){

                $statutPlusRecent = $unStatut;
            }

            
        }

        return $statutPlusRecent;

    }


    /**
     * Retourne la date de la commande.
     */
    public function GetDate(){

        $statutPlusAncien = $this->lesStatuts[0];

        foreach($this->lesStatuts as $unStatut){

            $ancienneDate = strtotime($statutPlusAncien['date']);
            $statutDate = strtotime($unStatut['date']);

            
            if($statutDate < $ancienneDate){

                $statutPlusAncien = $unStatut;
            }

            
        }

        return new DateTime($statutPlusAncien['date']);

    }

    /**
     * Retourne l'adresse de livraison.
     */
    public function GetAdresse(){

        return $this->adresse;

    }

    /**
     * Retourne ville de livraison.
     */
    public function GetVille(){

        return $this->ville;

    }


    /**
     * Retourne le code postal de livraison.
     */
    public function GetCP(){

        return $this->cp;

    }


    /**
     * Retourne le pays de livraison.
     */
    public function GetPays(){

        return $this->pays;

    }


    /**
     * Retourne le nom de livraison.
     */
    public function GetNom(){

        return $this->nom;

    }


    /**
     * Retourne le prenom de livraison.
     */
    public function GetPrenom(){

        return $this->prenom;

    }


     /**
     * Retourne le panier details commande.
     */
    public function GetDetailsCommande(){

        return $this->detailsCommande;

    }


    /**
     * set le panier details commande.
     */
    public function SetDetailsCommande(panier $detailsCommande){

        $this->detailsCommande = $detailsCommande;

    }



}

?>