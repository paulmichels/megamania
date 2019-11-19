<?php

require_once(CORE_DIR  . "MY_Entity.php");

/**
* Classe entitée Genre_Jeu_Entity
*/

class Genre_Jeu_Entity extends MY_Entity {

    protected $id_genre;
    protected $id_jeu;


    /**
    * Constructeur de la classe
    */

    public function __construct()
    {
        parent::__construct();
    }

}

?>