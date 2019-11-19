<?php

require_once(CORE_DIR  . "MY_Entity.php");

/**
* Classe entitée Reservation_Entity
*/

class Reservation_Entity extends MY_Entity {

    protected $id;
    protected $date;
    protected $etat;
    protected $id_utilisateur;
    protected $id_produit;


    /**
    * Constructeur de la classe
    */

    public function __construct()
    {
        parent::__construct();
    }

}

?>