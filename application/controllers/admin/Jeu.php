<?php

Class Jeu extends CI_Controller {

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
		$this->load->view('jeu', $data);
	}

	public function create(){
		$form = $this->input->post();

		$editeur_list = $this->Editeur_Model->getEditeurList();

		$jeu_details_list = array();

		foreach ($form['genre'] as $keyGenre => $genre) {
			foreach ($form['pegi'] as $keyPegi => $pegi) {
				$jeu_details = new Jeu_Details_Entity();
				$jeu_details->id_jeu = 'DEFAULT';
				$jeu_details->nom = $form['nom'][0];
				$jeu_details->description = $form['description'][0];
				$jeu_details->date_sortie = $form['date_sortie'][0];
				$jeu_details->id_genre = $genre;
				$jeu_details->id_plateforme = $form['plateforme'][0];
				$jeu_details->prix = $pegi;
				$jeu_details->quantite = $form['quantite'][0];
				$jeu_details->id_pegi = $form['pegi'][0];
				$jeu_details->id_editeur = $form['editeur'][0];
				array_push($jeu_details_list, $jeu_details);
			}
		}

		foreach ($jeu_details_list as $key => $value) {
			$query = "INSERT INTO Jeu_Details VALUES(
				DEFAULT, 
				'".$value->nom."', 
				'".$value->description."', 
				'".$value->date_sortie."',
				".$value->id_genre.",
				".$value->id_plateforme.",
				".$value->prix.",
				".$value->quantite.",
				".$value->id_pegi.",
				".$value->id_editeur.",
				'".$editeur_list[$value->id_editeur]->nom."'
			)";
			$this->Jeu_Details_Model->manualQuery($query);
		}

        echo json_encode(array(
            'response' => $jeu_details,
            'message' => 'OK'
        ));
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