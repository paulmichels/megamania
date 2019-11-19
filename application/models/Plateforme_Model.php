<?php
defined('BASEPATH') OR exit('No direct script access allowed');


require_once(ENTITIES_DIR  . "Plateforme_Entity.php");

class Plateforme_Model extends MY_Model {
    

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
        $this->setTable( "plateforme" );
        $this->setEntity( "Plateforme_Entity" );
    }


    /**
    * Insérer
    *
    * @param Plateforme_Entity $obj
    * @return bool
    */
    
    public function insertPlateforme($obj) {
        if(is_a($obj, $this->getEntity())){
            return $this->replace($obj);
        }
        return false;
    }


    /**
    * Modifier
    *
    * @param Plateforme_Entity $obj
    * @return bool
    */
    
    public function updatePlateforme($obj) {
        if ( isset( $obj->id ) ) {
            return $this->update( array( 'id'=>$obj->id ) , $obj );
        }
        return false;
    }


    /**
    * Supprimer
    *
    * @param Plateforme_Entity $obj
    * @return bool
    */
    
    public function deletePlateforme($obj) {
        if(is_a($obj, $this->getEntity())){
            return $this->delete( array( 'id'=>$obj->id ));
        }
        return false; 
    }


    /**
    * Retourne une enregistrement à partir de l'id
    *
    * @param int $id
    * @return Plateforme_Entity
    */
    
    public function getPlateforme( $id ) {
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
    * @return Plateforme_Entity
    */
    
    public function getPlateformeList() {
        $data = $this->read();
        if(empty($data)){
            $error = $this->db->error();
            return false;
        }
        return $data;
    }
}

?>