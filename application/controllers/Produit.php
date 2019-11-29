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
        $this->load->model('Reservation_Model');    
        $this->load->model('Plateforme_Model');    
        $this->load->model('Utilisateur_Model');    
    }

	public function index()
	{
        $idProduit = $this->input->get('id');
        if($idProduit == null){
            redirect();
        } else {
            $data['produit'] = $this->Jeu_Details_Model->getJeuDetails($idProduit);
            $data['genre'] = $this->Genre_Model->getGenreList();
            $data['plateforme'] = $this->Plateforme_Model->getPlateformeList();
            $data['pegi'] = $this->Pegi_Model->getPegiList();
            $data['reservation'] = array();
            $data['photos'] = $this->getPhotos($data['produit']->nom);
            $data['utilisateur'] = $this->Utilisateur_Model->getUtilisateur('test@test.com');
            $data['reservation'] = $this->Reservation_Model->getReservationAsJeu($data['utilisateur']->login);
            $this->load->view('produit', $data);
        }
	}

    public function getPhotos($album){
        $data['photos'] = array_diff(scandir('assets/img/jeux/'.strtolower(str_replace(" ", "_", $album))), array('.', '..'));
        return $data['photos'];
    }

    public function book() {
        $data['reservation'] = $this->input->post('reservation');

        $reservation = new Reservation_Entity();
        $reservation->etat = $data['reservation']['etat'];
        $reservation->login_utilisateur = $data['reservation']['login_utilisateur'];
        $reservation->id_produit = $data['reservation']['id_produit'];

        echo json_encode(array(
            'response' => $this->Reservation_Model->insertQueryReservation($reservation),
            'message'=> 'OK '
        ));
    }
}
