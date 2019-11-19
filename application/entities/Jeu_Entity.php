<?php

require_once(CORE_DIR  . "MY_Entity.php");

/**
* Classe entitée Jeu_Entity
*/

class Jeu_Entity extends MY_Entity {

    protected $id;
    protected $date_sortie;
    protected $id_editeur;


    /**
    * Constructeur de la classe
    */

    public function __construct()
    {
        parent::__construct();
    }

}

?>