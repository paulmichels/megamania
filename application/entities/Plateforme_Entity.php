<?php

require_once(CORE_DIR  . "MY_Entity.php");

/**
* Classe entitée Plateforme_Entity
*/

class Plateforme_Entity extends MY_Entity {

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