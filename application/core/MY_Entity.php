<?php 
defined('BASEPATH') OR exit('No direct script access allowed');


class MY_Entity {

    /**
    * Constructeur
    */

    public function __construct()
    {

    }

    /**
    * Getters et setters
    **/

    public function __get($name) {
        return $this->$name;
    }

    public function __set($name, $value) {
        $this->$name = $value;
    }

    /**
    * Retourne les variables de la classe sous forme de tableau
    *
    * @return array
    */

    public function get_object_vars(){
        return get_object_vars($this);
    }

}

