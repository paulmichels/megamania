<?php
defined('BASEPATH') OR exit('No direct script access allowed');


require_once(ENTITIES_DIR  . "Jeu_Details_Entity.php");

class Jeu_Details_Model extends MY_Model {
    

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
        $this->setTable( "jeu_details" );
        $this->setEntity( "Jeu_Details_Entity" );
    }


    /**
    * Insérer
    *
    * @param Jeu_Details_Entity $obj
    * @return bool
    */
    
    public function insertJeuDetails($obj) {
        if(is_a($obj, $this->getEntity())){
            return $this->replace($obj);
        }
        return false;
    }


    /**
    * Modifier
    *
    * @param Jeu_Details_Entity $obj
    * @return bool
    */
    
    public function updateJeuDetails($obj) {
        if ( isset( $obj->id_jeu ) ) {
            return $this->update( array( 'id_jeu'=>$obj->id_jeu ) , $obj );
        }
        return false;
    }


    /**
    * Supprimer
    *
    * @param Jeu_Details_Entity $obj
    * @return bool
    */
    
    public function deleteJeuDetails($obj) {
        if(is_a($obj, $this->getEntity())){
            return $this->delete( array( 'id_jeu'=>$obj->id_jeu ));
        }
        return false; 
    }


    /**
    * Retourne une enregistrement à partir de l'id_jeu
    *
    * @param int $id_jeu
    * @return Jeu_Details_Entity
    */
    
    public function getJeuDetails( $id_jeu ) {
        $data = $this->read( array( 'id_jeu'=> $id_jeu ) );
        if(empty($data)){
            $error = $this->db->error();
            return false;
        }
        return Jeu_Details_Entity::mergeInOneArray($data)[0];
    }


    /**
    * Retourne la liste des enregistrements
    *
    * @return Jeu_Details_Entity
    */
    
    public function getJeuDetailsList($where = null) {
        $data = $this->read($where);
        if(empty($data)){
            $error = $this->db->error();
            return false;
        }
        return Jeu_Details_Entity::mergeInOneArray($data);
    }
}

?>