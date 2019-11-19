<?php

require_once(CORE_DIR  . "MY_Entity.php");

/**
* Classe entitée Genre_Entity
*/

class Genre_Entity extends MY_Entity {

    protected $id;
    protected $genre;


    /**
    * Constructeur de la classe
    */

    public function __construct()
    {
        parent::__construct();
    }

}

?>