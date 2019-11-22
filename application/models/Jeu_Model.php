<?php
defined('BASEPATH') OR exit('No direct script access allowed');


require_once(ENTITIES_DIR  . "Jeu_Entity.php");

class Jeu_Model extends MY_Model {
    

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
        $this->setTable( "jeu" );
        $this->setEntity( "Jeu_Entity" );
    }


    /**
    * Insérer
    *
    * @param Jeu_Entity $obj
    * @return bool
    */
    
    public function insertJeu($obj) {
        if(is_a($obj, $this->getEntity())){
            return $this->replace($obj);
        }
        return false;
    }


    /**
    * Modifier
    *
    * @param Jeu_Entity $obj
    * @return bool
    */
    
    public function updateJeu($obj) {
        if ( isset( $obj->id ) ) {
            return $this->update( array( 'id'=>$obj->id ) , $obj );
        }
        return false;
    }


    /**
    * Supprimer
    *
    * @param Jeu_Entity $obj
    * @return bool
    */
    
    public function deleteJeu($obj) {
        if(is_a($obj, $this->getEntity())){
            return $this->delete( array( 'id'=>$obj->id ));
        }
        return false; 
    }


    /**
    * Retourne une enregistrement à partir de l'id
    *
    * @param int $id
    * @return Jeu_Entity
    */
    
    public function getJeu( $id ) {
        $data = $this->read( array( 'id'=> $id ) );
        if(empty($data)){
            $error = $this->db->error();
            return false;
        }
        return $data[0];
    }


    /**
    * Retourne la liste des enregistrements
    *
    * @return Jeu_Entity
    */
    
    public function getJeuList() {
        $data = $this->read();
        if(empty($data)){
            $error = $this->db->error();
            return false;
        }
        return $data;
    }

    public function test(){
        $query = "SELECT * FROM JEU_DETAILS";
        return $this->db->query($query)->result_array();
    }
}

?>