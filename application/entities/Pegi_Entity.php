<?php

require_once(CORE_DIR  . "MY_Entity.php");

/**
* Classe entitée Pegi_Entity
*/

class Pegi_Entity extends MY_Entity {

    protected $id;
    protected $nom;


    /**
    * Constructeur de la classe
    */

    public function __construct()
    {
        parent::__construct();
    }

    public function getObjectVars(){
        return array(
            'id', 
            'nom'
        );
    }

}

?>