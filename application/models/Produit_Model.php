<?php
defined('BASEPATH') OR exit('No direct script access allowed');


require_once(ENTITIES_DIR  . "Produit_Entity.php");

class Produit_Model extends MY_Model {
    

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
        $this->setTable( "produit" );
        $this->setEntity( "Produit_Entity" );
    }


    /**
    * Insérer
    *
    * @param Produit_Entity $obj
    * @return bool
    */
    
    public function insertProduit($obj) {
        if(is_a($obj, $this->getEntity())){
            return $this->replace($obj);
        }
        return false;
    }


    /**
    * Modifier
    *
    * @param Produit_Entity $obj
    * @return bool
    */
    
    public function updateProduit($obj) {
        if ( isset( $obj->id ) ) {
            return $this->update( array( 'id'=>$obj->id ) , $obj );
        }
        return false;
    }


    /**
    * Supprimer
    *
    * @param Produit_Entity $obj
    * @return bool
    */
    
    public function deleteProduit($obj) {
        if(is_a($obj, $this->getEntity())){
            return $this->delete( array( 'id'=>$obj->id ));
        }
        return false; 
    }


    /**
    * Retourne une enregistrement à partir de l'id
    *
    * @param int $id
    * @return Produit_Entity
    */
    
    public function getProduit( $id ) {
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
    * @return Produit_Entity
    */
    
    public function getProduitList() {
        $data = $this->read();
        if(empty($data)){
            $error = $this->db->error();
            return false;
        }
        return $data;
    }
}

?>