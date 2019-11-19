<?php

require_once(CORE_DIR  . "MY_Entity.php");

/**
* Classe entitée Pegi_Jeu_Entity
*/

class Pegi_Jeu_Entity extends MY_Entity {

    protected $id_pegi;
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