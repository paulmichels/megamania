<?php

require_once(CORE_DIR  . "MY_Entity.php");

/**
* Classe entitée Jeu_Entity
*/

class Jeu_Panier_Entity extends MY_Entity implements JsonSerializable {

    protected $id_jeu;
    protected $nom;
    protected $prix;
    protected $quantite;

    /**
    * Constructeur de la classe
    */

    public function __construct()
    {
        parent::__construct();
    }

    public function jsonSerialize() {

        $json = array(
            'id_jeu' => $this->id_jeu,
            'nom' => $this->nom,
            'prix' => $this->prix,
            'quantite' => $this->quantite,
        );
        return $json;
    }

}

?>