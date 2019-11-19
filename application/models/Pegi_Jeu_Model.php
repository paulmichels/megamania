<?php
defined('BASEPATH') OR exit('No direct script access allowed');


require_once(ENTITIES_DIR  . "Pegi_Jeu_Entity.php");

class Pegi_Jeu_Model extends MY_Model {
    

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
        $this->setTable( "Pegi_Jeu" );
        $this->setEntity( "Pegi_Jeu_Entity" );
    }


    /**
    * Insérer
    *
    * @param Pegi_Jeu_Entity $obj
    * @return bool
    */
    
    public function insertPegi_Jeu($obj) {
        if(is_a($obj, $this->getEntity())){
            return $this->replace($obj);
        }
        return false;
    }


    /**
    * Modifier
    *
    * @param Pegi_Jeu_Entity $obj
    * @return bool
    */
    
    public function updatePegi_Jeu($obj) {
        if ( isset( $obj->id ) ) {
            return $this->update( array( 'id'=>$obj->id ) , $obj );
        }
        return false;
    }


    /**
    * Supprimer
    *
    * @param Pegi_Jeu_Entity $obj
    * @return bool
    */
    
    public function deletePegi_Jeu($obj) {
        if(is_a($obj, $this->getEntity())){
            return $this->delete( array( 'id'=>$obj->id ));
        }
        return false; 
    }


    /**
    * Retourne une enregistrement à partir de l'id
    *
    * @param int $id
    * @return Pegi_Jeu_Entity
    */
    
    public function getPegi_Jeu( $id ) {
        $data = $this->read( array( 'Pegi_Jeu'=> $id ) );
        if(empty($data)){
            $error = $this->db->error();
            return false;
        }
        return $data[0];
    }


    /**
    * Retourne la liste des enregistrements
    *
    * @return Pegi_Jeu_Entity
    */
    
    public function getPegi_JeuList() {
        $data = $this->read();
        if(empty($data)){
            $error = $this->db->error();
            return false;
        }
        return $data;
    }
}

?>