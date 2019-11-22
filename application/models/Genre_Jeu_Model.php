<?php
defined('BASEPATH') OR exit('No direct script access allowed');


require_once(ENTITIES_DIR  . "Genre_Jeu_Entity.php");

class Genre_Jeu_Model extends MY_Model {
    

    /**
    * Constructeur
    *
    * Hérite et overidde le constructeur du parent
    * Défini la table à utiliser
    * Défini le nom de la classe entitée
    */

    public function __construct()
    {
        parent::__construct();
        $this->setTable( "genre_Jeu" );
        $this->setEntity( "Genre_Jeu_Entity" );
    }


    /**
    * Insérer
    *
    * @param Genre_Jeu_Entity $obj
    * @return bool
    */
    
    public function insertGenreJeu($obj) {
        if(is_a($obj, $this->getEntity())){
            return $this->replace($obj);
        }
        return false;
    }


    /**
    * Modifier
    *
    * @param Genre_Jeu_Entity $obj
    * @return bool
    */
    
    public function updateGenreJeu($obj) {
        if ( isset( $obj->id ) ) {
            return $this->update( array( 'id'=>$obj->id ) , $obj );
        }
        return false;
    }


    /**
    * Supprimer
    *
    * @param Genre_Jeu_Entity $obj
    * @return bool
    */
    
    public function deleteGenreJeu($obj) {
        if(is_a($obj, $this->getEntity())){
            return $this->delete( array( 'id'=>$obj->id ));
        }
        return false; 
    }


    /**
    * Retourne la liste des genre d'un jeu
    *
    * @param int $id_jeu
    * @return Genre_Jeu_Entity
    */
    
    public function getListGenreByJeu( $id_jeu ) {
        $data = $this->read( array( 'id_jeu'=> $id_jeu ) );
        if(empty($data)){
            $error = $this->db->error();
            return false;
        }
        return $data;
    }


    /**
    * Retourne la liste des jeux d'un genre
    *
    * @param int $id_genre
    * @return Genre_Jeu_Entity
    */
    
    public function getListJeubyGenre( $id_genre ) {
        $data = $this->read( array( 'id_genre'=> $id_genre ) );
        if(empty($data)){
            $error = $this->db->error();
            return false;
        }
        return $data;
    }


    /**
    * Retourne la liste des enregistrements
    *
    * @return Genre_Jeu_Entity
    */
    
    public function getGenreJeuList() {
        $data = $this->read();
        if(empty($data)){
            $error = $this->db->error();
            return false;
        }
        return $data;
    }
}

?>