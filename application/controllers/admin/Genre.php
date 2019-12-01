<?php

Class Genre extends CI_Controller {

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


	}

	public function index(){
		$data['utilisateur'] = $this->Utilisateur_Model->getUtilisateur('test@test.com');
        $data['reservation'] = $this->Reservation_Model->getReservationAsJeu($data['utilisateur']->login);
        $data['reservation_count'] = $this->Reservation_Model->countReservation($data['utilisateur']->login);
		$data['jeu'] = $this->Jeu_Details_Model->getJeuDetailsList();
		$data['genre'] = $this->Genre_Model->getGenreList();
		$data['plateforme'] = $this->Plateforme_Model->getPlateformeList();
		$data['pegi'] = $this->Pegi_Model->getPegiList();
		$data['editeur'] = $this->Editeur_Model->getEditeurList();
		$this->load->view('genre', $data);
	}

	public function create(){
		$form = $this->input->post();
		
		$genre = new Genre_Entity();
		$genre->id = 'DEFAULT';
		$genre->nom = $form['nom'];

		$query = "INSERT INTO genre VALUES(".$genre->id.", '".$genre->nom."')";

		if($this->Genre_Model->manualQuery($query)){
	        echo json_encode(array(
	            'response' => true,
	            'message' => 'OK'
	        ));
		} else {
	        echo json_encode(array(
	            'response' => false,
	            'message' => 'OK'
	        ));
		}
	}

	public function edit(){
		$id = $this->input->post('id');

        echo json_encode(array(
            'response' => $id,
            'message' => 'OK'
        ));
	}

	public function delete(){
		$id = $this->input->post('id');

        echo json_encode(array(
            'response' => $id,
            'message' => 'OK'
        ));
	}
}

?>