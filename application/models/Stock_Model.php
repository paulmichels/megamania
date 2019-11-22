<?php
defined('BASEPATH') OR exit('No direct script access allowed');


require_once(ENTITIES_DIR  . "Stock_Entity.php");

class Stock_Model extends MY_Model {
    

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
        $this->setTable( "stock" );
        $this->setEntity( "Stock_Entity" );
    }


    /**
    * Insérer
    *
    * @param Stock_Entity $obj
    * @return bool
    */
    
    public function insertStock($obj) {
        if(is_a($obj, $this->getEntity())){
            return $this->replace($obj);
        }
        return false;
    }


    /**
    * Modifier
    *
    * @param Stock_Entity $obj
    * @return bool
    */
    
    public function updateStock($obj) {
        if ( isset( $obj->id ) ) {
            return $this->update( array( 'id'=>$obj->id ) , $obj );
        }
        return false;
    }


    /**
    * Supprimer
    *
    * @param Stock_Entity $obj
    * @return bool
    */
    
    public function deleteStock($obj) {
        if(is_a($obj, $this->getEntity())){
            return $this->delete( array( 'id'=>$obj->id ));
        }
        return false; 
    }


    /**
    * Retourne une enregistrement à partir de l'id
    *
    * @param int $id
    * @return Stock_Entity
    */
    
    public function getStock( $id ) {
        $data = $this->read( array( 'id'=> $id ) );
        if(empty($data)){
            $error = $this->db->error();
            return false;
        }
        return $data[0];
    }


    /**
    * Retourne un stock
    *
    * @param int $id_jeu
    * @param int $id_plateforme
    * @return Stock_Entity
    */
    
    public function getStockListByJeu( $id_jeu, $id_plateforme ) {
        $data = $this->read( array( 'id_jeu'=> $id_jeu, 'id_plateforme'=>$id_plateforme ) );
        if(empty($data)){
            $error = $this->db->error();
            return false;
        }
        return $data[0];
    }


    /**
    * Retourne une liste de stock d'un jeu
    *
    * @param int $id_jeu
    * @return Stock_Entity
    */
    
    public function getStockListByJeu( $id_jeu ) {
        $data = $this->read( array( 'id_jeu'=> $id_jeu ) );
        if(empty($data)){
            $error = $this->db->error();
            return false;
        }
        return $data;
    }


    /**
    * Retourne une liste de stock d'une plateforme
    *
    * @param int $id_plateforme
    * @return Stock_Entity
    */
    
    public function getStockListByPlateforme( $id_plateforme ) {
        $data = $this->read( array( 'id_plateforme'=> $id_plateforme ) );
        if(empty($data)){
            $error = $this->db->error();
            return false;
        }
        return $data;
    }


    /**
    * Retourne la liste des enregistrements
    *
    * @return Stock_Entity
    */
    
    public function getStockList() {
        $data = $this->read();
        if(empty($data)){
            $error = $this->db->error();
            return false;
        }
        return $data;
    }
}

?>