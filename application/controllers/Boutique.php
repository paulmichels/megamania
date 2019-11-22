<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Boutique extends CI_Controller {

    public function __construct()
    {
            parent::__construct();
            $this->load->helper('url');
            $this->load->model('Jeu_Model');
            $this->load->model('Plateforme_Model');
            $this->load->model('Genre_Model');
            $this->load->model('Pegi_Model');
            $this->load->model('Editeur_Model');
            $this->load->model('Reservation_Model');
            $this->load->model('Produit_Model');
            $this->load->model('Utilisateur_Model');
            $this->load->model('Jeu_Details_Model');
    }

	public function index()
	{
		$data['plateforme'] = $this->Plateforme_Model->getPlateformeList();
		$data['genre'] = $this->Genre_Model->getGenreList();
		$data['editeur'] = $this->Editeur_Model->getEditeurList();
		$data['pegi'] = $this->Pegi_Model->getPegiList();
		$data['produit'] = $this->Produit_Model->getProduitList();
		$data['jeu'] = $this->Jeu_Details_Model->getJeuDetailsList();
		$data['reservation'] = array();
		$data['photos'] = $this->getAlbum();
		$this->load->view('boutique', $data);
	}

	public function search()
	{
		$plateforme = $this->input->post('plateforme');
		$genre = $this->input->post('genre');
		$editeur = $this->input->post('editeur');
		$prix = $this->input->post('prix');
		return json_encode('ok');
	}

	public function getAlbum(){
        $data['album'] = array_diff(scandir('assets/img/jeux/'), array('.', '..'));
        $data['photos']= array();
        foreach ($data['album'] as $key => $albumName) {
            $tmp = array_diff(scandir('assets/img/jeux/'.$albumName), array('.', '..'));
            $data['photos'][$albumName] = array();
            foreach ($tmp as $photo) {
        		array_push($data['photos'][$albumName], $photo);
            }
        }
        return $data['photos'];
	}
    
}
