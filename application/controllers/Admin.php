<?php

Class Admin extends CI_Controller {

	protected $data;

	public function __construct() {
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

	    $this->data['segment'] = $this->uri->segment_array()[sizeof($this->uri->segment_array())];
		$this->data['utilisateur'] = $this->Utilisateur_Model->getUtilisateur('test@test.com');
        $this->data['reservation'] = $this->Reservation_Model->getReservationAsJeu($this->data['utilisateur']->login);
        $this->data['reservation_count'] = $this->Reservation_Model->countReservation($this->data['utilisateur']->login);
	}

	public function jeu(){
		$this->data['table'] = $this->Jeu_Details_Model->getJeuDetailsList();
		$this->load->view('admin', $this->data);
	}

	public function reservation(){
		$this->data['table'] = $this->Reservation_Model->getReservationList();
		$this->load->view('admin', $this->data);
	}

	public function editeur(){
		$this->data['table'] = $this->Editeur_Model->getEditeurList();
		$this->load->view('admin', $this->data);
	}

	public function genre(){
		$this->data['table'] = $this->Genre_Model->getGenreList();
		$this->load->view('admin', $this->data);
	}

	public function plateforme(){
		$this->data['table'] = $this->Plateforme_Model->getPlateformeList();
		$this->load->view('admin', $this->data);
	}

	public function pegi(){
		$this->data['table'] = $this->Pegi_Model->getPegiList();
		$this->load->view('admin', $this->data);
	}
}

?>