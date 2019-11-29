<?php
defined('BASEPATH') OR exit('No direct script access allowed');


require_once(ENTITIES_DIR  . "Reservation_Entity.php");

class Reservation_Model extends MY_Model {
    

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
        $this->setTable( "reservation" );
        $this->setEntity( "Reservation_Entity" );
    }


    /**
    * Insérer
    *
    * @param Reservation_Entity $obj
    * @return bool
    */
    
    public function insertReservation($obj) {
        if(is_a($obj, $this->getEntity())){
            return $this->create($obj);
        }
        return false;
    }

    public function insertQueryReservation($query) {
        return $this->query_manual($query);
    }


    /**
    * Modifier
    *
    * @param Reservation_Entity $obj
    * @return bool
    */
    
    public function updateReservation($obj) {
        if ( isset( $obj->id ) ) {
            return $this->update( array( 'id'=>$obj->id ) , $obj );
        }
        return false;
    }


    /**
    * Supprimer
    *
    * @param Reservation_Entity $obj
    * @return bool
    */
    
    public function deleteReservation($obj) {
        if(is_a($obj, $this->getEntity())){
            return $this->delete( array( 'id'=>$obj->id ));
        }
        return false; 
    }


    /**
    * Retourne une enregistrement à partir de l'id
    *
    * @param int $id
    * @return Reservation_Entity
    */
    
    public function getReservation( $id ) {
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
    * @return Reservation_Entity
    */
    
    public function getReservationList() {
        $data = $this->read();
        if(empty($data)){
            $error = $this->db->error();
            return false;
        }
        return $data;
    }
}

?>