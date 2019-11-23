<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Produit extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->model('Genre_Model');
        $this->load->model('Pegi_Model');
        $this->load->model('Jeu_Details_Model');    
    }

	public function index()
	{
        $idProduit = $this->input->get('id');
        if($idProduit == null){
            redirect();
        } else {
            $data['produit'] = $this->Jeu_Details_Model->getJeuDetails($idProduit);
            $data['genre'] = $this->Genre_Model->getGenreList();
            $data['pegi'] = $this->Pegi_Model->getPegiList();
            $data['reservation'] = array();
            $data['photos'] = $this->getPhotos($data['produit']->nom);
            $this->load->view('produit', $data);
        }
	}

    public function getPhotos($album){
        $data['photos'] = array_diff(scandir('assets/img/jeux/'.str_replace(" ", "_", $album)), array('.', '..'));
        return $data['photos'];
    }
}