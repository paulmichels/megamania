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
            if(!in_array($value->id_jeu, array_column($new, 'id_jeu'))){
                array_push($new, $value);
            } else {
                $newKey = array_search($value->id_jeu, array_column($new, 'id_jeu'));
                if(!is_array($new[$newKey]->id_genre)){
                    $new[$newKey]->id_genre = array(0=>$new[$newKey]->id_genre);
                } else if(!in_array($value->id_genre, $new[$newKey]->id_genre)){
                    array_push($new[$newKey]->id_genre, $value->id_genre);
                }

                if(!is_array($new[$newKey]->id_pegi)){
                    $new[$newKey]->id_pegi = array(0=>$new[$newKey]->id_pegi);
                } else if(!in_array($value->id_pegi, $new[$newKey]->id_pegi)){
                    array_push($new[$newKey]->id_pegi, $value->id_pegi);
                }
            }
        }
        return $new;
    }

    public function jsonSerialize() {

        $json = array(
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
            'nom_editeur' => $this->nom_editeur
        );
        return $json;
    }

}

?>