<?php

require_once(CORE_DIR  . "MY_Entity.php");

/**
* Classe entitée Jeu_Entity
*/

class Jeu_Details_Entity extends MY_Entity implements JsonSerializable {

    protected $id_jeu;
    protected $nom;
    protected $description;
    protected $date_sortie;
    protected $id_genre;
    protected $id_plateforme;
    protected $prix;
    protected $quantite;
    protected $id_pegi;
    protected $id_editeur;
    protected $nom_editeur;


    /**
    * Constructeur de la classe
    */

    public function __construct()
    {
        parent::__construct();
    }

    public static function mergeInOneArray($array){
        $new = array();
        foreach ($array as $key => $value) {
            if(array_key_exists($value->id_jeu - 1, $new)){

                $tmp = (array) $new[$value->id_jeu - 1]->id_genre;
                if(!in_array($value->id_genre, $tmp)){
                    array_push($tmp, $value->id_genre);
                }
                $new[$value->id_jeu - 1]->id_genre = $tmp;

                $tmp = (array) $new[$value->id_jeu - 1]->id_pegi;
                if(!in_array($value->id_pegi, $tmp)){
                    array_push($tmp, $value->id_pegi);
                }
                $new[$value->id_jeu - 1]->id_pegi = $tmp;
                
            } else {
                array_push($new, $value);
            }
        }
        return $new;
    }

    public function jsonSerialize() {
        return [
            'id_jeu' => $this->id_jeu,
            'nom' => $this->nom,
            'description' => $this->description,
            'date_sortie' => $this->date_sortie,
            'id_genre' => $this->id_genre,
            'id_plateforme' => $this->id_plateforme,
            'prix' => $this->prix,
            'quantite' => $this->quantite,
            'id_pegi' => $this->id_pegi,
            'id_editeur' => $this->id_editeur,
            'nom_editeur' => $this->nom_editeur,
        ];
    }

}

?>