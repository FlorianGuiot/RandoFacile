<?php
/*
    Classe utilisateur
    utilisateur.php

    @Auteur : Florian

*/

class utilisateur{

    private int $id;
    private string $nom;
    private string $prenom;
    private string $email;
    private string $password;
    private DateTime $dateInscription;
    private ?\DateTime $dateNaissance;
    private bool $estAdmin;

    /**
     * Constructeur d'utilisateur.
     */
    public function __construct(int $id = -1, string $nom = "", string $prenom = "", string $email = "",string $password = "", DateTime $dateInscription = null, DateTime $dateNaissance = null, bool $estAdmin = false)
    {
        $this->id = $id;
        $this->nom = $nom;
        $this->prenom = $prenom;
        $this->email = $email;
        $this->password = $password;
        $this->dateInscription = $dateInscription;
        $this->dateNaissance = $dateNaissance;
        $this->estAdmin = $estAdmin;
        
    }

     /**
     * Retourne le id d'utilisateur.
     */
    public function GetId(){

        return $this->id;

    }

    /**
     * Retourne le nom d'utilisateur.
     */
    public function GetNom(){

        return $this->nom;

    }

    /**
     * Retourne le prenom d'utilisateur.
     */
    public function GetPrenom(){

        return $this->prenom;

    }

    /**
     * Retourne le mail de l'utilisateur.
     */
    public function GetEmail(){

        return $this->email;

    }

    /**
     * Retourne le mdp de l'utilisateur.
     */
    public function GetPassword(){

        return $this->password;

    }

    /**
     * Retourne la date inscription de l'utilisateur.
     */
    public function GetDateInscription(){

        return $this->dateInscription;

    }

    /**
     * Retourne la date inscription de l'utilisateur.
     */
    public function GetDateNaissance(){

        return $this->dateNaissance;

    }

    /**
     * Set le nom d'utilisateur.
     */
    public function SetNom(string $nom){

        $this->nom = $nom;

    }

    /**
     * Set le prenom d'utilisateur.
     */
    public function SetPrenom(string $prenom){

        $this->prenom = $prenom;

    }

    /**
     * Set le email d'utilisateur.
     */
    public function SetEmail(string $email){

        $this->email = $email;

    }

    /**
     * Set la date inscription d'utilisateur.
     */
    public function SetDateInscription(DateTime $dateInscription){

        $this->dateInscription = $dateInscription;

    }

    /**
     * Set la date naissance d'utilisateur.
     */
    public function SetDateNaissance(DateTime $dateNaissance){

        $this->dateNaissance = $dateNaissance;

    }


    /**
     * Retourne true si l'utilisateur est administrateur
     */
    public function estAdmin(){

        return $this->estAdmin;

    }

}
?>