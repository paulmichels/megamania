<?php

Class Login extends CI_Controller {

public function __construct() {
parent::__construct();
	$this->load->helper('form');
	$this->load->helper('url');
	$this->load->helper('security');
	$this->load->library('form_validation');
	$this->load->library('session');
	$this->load->model('Utilisateur_Model');
}

public function index() {
	$this->load->view('login');
}

public function user_registration_show() {
	$this->load->view('registration');
}

public function new_user_registration() {
	$this->form_validation->set_rules('username', 'Username', 'trim|required|xss_clean');
	$this->form_validation->set_rules('nom_value', 'nom', 'trim|required|xss_clean');
	$this->form_validation->set_rules('password', 'Password', 'trim|required|xss_clean');
	if ($this->form_validation->run() == FALSE) {
		$this->load->view('registration');
	} else {
		$data = array(
			'login' => $this->input->post('username'),
			'nom' => $this->input->post('nom_value'),
			'mdp' => $this->input->post('password')
		);
		$result = $this->Utilisateur_Model->registration_insert($data);
		if ($result == TRUE) {
			$data['message_display'] = 'Registration Successfully !';
			$this->load->view('login', $data);
		} else {
			$data['message_display'] = 'Username already exist!';
			$this->load->view('registration', $data);
		}
	}
}

public function user_login_process() {

	$this->form_validation->set_rules('username', 'Username', 'trim|required|xss_clean');
	$this->form_validation->set_rules('password', 'Password', 'trim|required|xss_clean');

	if ($this->form_validation->run() == FALSE) {
		if(isset($this->session->userdata['logged_in'])){
			$this->load->view('admin');
		}else{
			$this->load->view('login');
		}
	} else {
		$data = array(
			'username' => $this->input->post('username'),
			'password' => $this->input->post('password')
		);
		$result = $this->Utilisateur_Model->login($data);
		if ($result == TRUE) {

			$username = $this->input->post('username');
			$result = $this->Utilisateur_Model->read_user_information($username);
			if ($result != false) {
				$session_data = array(
					'username' => $result[0]->login,
					'nom' => $result[0]->nom,
				);
		// Add user data in session
			$this->session->set_userdata('logged_in', $session_data);
			$this->load->view('admin');
			}
		} else {
			$data = array(
				'error_message' => 'Invalid Username or Password'
			);
			$this->load->view('login', $data);
		}
	}
}

public function logout() {
	$sess_array = array(
		'username' => ''
	);
	$this->session->unset_userdata('logged_in', $sess_array);
	$data['message_display'] = 'Successfully Logout';
	$this->load->view('login', $data);
}

}

?>