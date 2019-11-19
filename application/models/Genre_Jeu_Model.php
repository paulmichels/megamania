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
        $this->setTable( "Genre_Jeu" );
        $this->setEntity( "Genre_Jeu_Entity" );
    }


    /**
    * Insérer
    *
    * @param Genre_Jeu_Entity $obj
    * @return bool
    */
    
    public function insertGenre_Jeu($obj) {
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
    
    public function updateGenre_Jeu($obj) {
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
    
    public function deleteGenre_Jeu($obj) {
        if(is_a($obj, $this->getEntity())){
            return $this->delete( array( 'id'=>$obj->id ));
        }
        return false; 
    }


    /**
    * Retourne une enregistrement à partir de l'id
    *
    * @param int $id
    * @return Genre_Jeu_Entity
    */
    
    public function getGenre_Jeu( $id ) {
        $data = $this->read( array( 'Genre_Jeu'=> $id ) );
        if(empty($data)){
            $error = $this->db->error();
            return false;
        }
        return $data[0];
    }


    /**
    * Retourne la liste des enregistrements
    *
    * @return Genre_Jeu_Entity
    */
    
    public function getGenre_JeuList() {
        $data = $this->read();
        if(empty($data)){
            $error = $this->db->error();
            return false;
        }
        return $data;
    }
}

?>