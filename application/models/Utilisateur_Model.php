<?php
defined('BASEPATH') OR exit('No direct script access allowed');


require_once(ENTITIES_DIR  . "Utilisateur_Entity.php");

class Utilisateur_Model extends MY_Model {
    

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
        $this->setTable( "utilisateur" );
        $this->setEntity( "Utilisateur_Entity" );
    }


    /**
    * Insérer
    *
    * @param Utilisateur_Entity $obj
    * @return bool
    */
    
    public function insertUtilisateur($obj) {
        if(is_a($obj, $this->getEntity())){
            return $this->replace($obj);
        }
        return false;
    }


    /**
    * Modifier
    *
    * @param Utilisateur_Entity $obj
    * @return bool
    */
    
    public function updateUtilisateur($obj) {
        if ( isset( $obj->login ) ) {
            return $this->update( array( 'login'=>$obj->login ) , $obj );
        }
        return false;
    }


    /**
    * Supprimer
    *
    * @param Utilisateur_Entity $obj
    * @return bool
    */
    
    public function deleteUtilisateur($obj) {
        if(is_a($obj, $this->getEntity())){
            return $this->delete( array( 'login'=>$obj->login ));
        }
        return false; 
    }


    /**
    * Retourne une enregistrement à partir du login
    *
    * @param int $login
    * @return Utilisateur_Entity
    */
    
    public function getUtilisateur( $login ) {
        $data = $this->read( array( 'login'=> $login ) );
        if(empty($data)){
            $error = $this->db->error();
            return false;
        }
        return $data[0];
    }


    /**
    * Retourne la liste des enregistrements
    *
    * @return Utilisateur_Entity
    */
    
    public function getUtilisateurList() {
        $data = $this->read();
        if(empty($data)){
            $error = $this->db->error();
            return false;
        }
        return $data;
    }
}

?>