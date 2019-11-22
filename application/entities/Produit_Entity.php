<?php

require_once(CORE_DIR  . "MY_Entity.php");

/**
* Classe entitée Produit_Entity
*/

class Produit_Entity extends MY_Entity {

    protected $id;
    protected $nom;
    protected $description;


    /**
    * Constructeur de la classe
    */

    public function __construct()
    {
        parent::__construct();
    }

}

?>