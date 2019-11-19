<?php

require_once(CORE_DIR  . "MY_Entity.php");

/**
* Classe entitée Utilisateur_Entity
*/

class Utilisateur_Entity extends MY_Entity {

    protected $id;
    protected $login;
    protected $mdp;
    protected $nom;
    protected $prenom;
    protected $adresse;
    protected $telephone;
    protected $date_inscription;
    protected $role_utilisateur;
    

    /**
    * Constructeur de la classe
    */

    public function __construct()
    {
        parent::__construct();
    }

}

?>