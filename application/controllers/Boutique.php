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
		$data['plateforme'] = $this->input->post('plateforme');
        $data['genre'] = $this->input->post('genre');
        $data['editeur'] = $this->input->post('editeur');
        $data['prix'] = $this->input->post('prix');

        $filter = array();

        $filter = 'prix >='.( (float) $data['prix']['prixMin']);
        $filter .= ' AND prix <='.( (float) $data['prix']['prixMax']);

        $i=0;
        foreach ($data['plateforme'] as $key => $value) {
            if($value=='true'){
                if($i == 0){
                    $filter .= ' AND (id_plateforme='.$key;
                    $i++;
                } else {
                    $filter .= ' OR id_plateforme='.$key;
                }
            }
        }

        if($i>0){
            $filter .= ')';
        }

        $i=0;
        foreach ($data['genre'] as $key => $value) {
            if($value=='true'){
                if($i == 0){
                    $filter .= ' AND (id_genre='.$key;
                    $i++;
                } else {
                    $filter .= ' OR id_genre='.$key;
                }
            }
        }

        if($i>0){
            $filter .= ')';
        }

        $i=0;
        foreach ($data['editeur'] as $key => $value) {
            if($value=='true'){
                if($i == 0){
                    $filter .= ' AND (id_editeur='.$key;
                    $i++;
                } else {
                    $filter .= ' OR id_editeur='.$key;
                }
            }
        }

        if($i>0){
            $filter .= ')';
        }

        echo json_encode(array(
            'response' => $this->Jeu_Details_Model->getJeuDetailsList($filter),
            'message' => 'OK'
        ));
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
