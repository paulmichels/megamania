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
        $this->setTable( "pegi_jeu" );
        $this->setEntity( "Pegi_Jeu_Entity" );
    }


    /**
    * Insérer
    *
    * @param Pegi_Jeu_Entity $obj
    * @return bool
    */
    
    public function insertPegiJeu($obj) {
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
    
    public function updatePegiJeu($obj) {
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
    
    public function deletePegiJeu($obj) {
        if(is_a($obj, $this->getEntity())){
            return $this->delete( array( 'id'=>$obj->id ));
        }
        return false; 
    }


    /**
    * Retourne une association pegi jeu
    *
    * @param int $id_pegi
    * @param int $id_jeu
    * @return Pegi_Jeu_Entity
    */
    
    public function getPegiJeu( $id_pegi, $id_jeu ) {
        $data = $this->read( array( 'id_pegi'=> $id_pegi, 'id_jeu'=>$id_jeu ) );
        if(empty($data)){
            $error = $this->db->error();
            return false;
        }
        return $data[0];
    }


    /**
    * Retourne la liste des jeux d'un pegi
    *
    * @param int $id_pegi
    * @return Pegi_Jeu_Entity
    */
    
    public function getPegiJeuByPegi( $id_pegi ) {
        $data = $this->read( array( 'id_pegi'=> $id_pegi ) );
        if(empty($data)){
            $error = $this->db->error();
            return false;
        }
        return $data;
    }


    /**
    * Retourne la liste des pegi d'un jeu
    *
    * @param int $id_jeu
    * @return Pegi_Jeu_Entity
    */
    
    public function getPegiJeuByJeu( $id_jeu ) {
        $data = $this->read( array( 'id_jeu'=> $id_jeu ) );
        if(empty($data)){
            $error = $this->db->error();
            return false;
        }
        return $data;
    }


    /**
    * Retourne la liste des enregistrements
    *
    * @return Pegi_Jeu_Entity
    */
    
    public function getPegiJeuList() {
        $data = $this->read();
        if(empty($data)){
            $error = $this->db->error();
            return false;
        }
        return $data;
    }
}

?>