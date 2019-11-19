<?php

require_once(CORE_DIR  . "MY_Entity.php");

/**
* Classe entitée Stock_Entity
*/

class Stock_Entity extends MY_Entity {

    protected $id;
    protected $plateforme;
    protected $prix;
    protected $quantite;


    /**
    * Constructeur de la classe
    */

    public function __construct()
    {
        parent::__construct();
    }

}

?>