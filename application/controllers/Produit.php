<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Produit extends CI_Controller {

    public function __construct()
    {
            parent::__construct();
            $this->load->helper('url');
            $this->load->model('produit_model');
            $this->load->model('jeu_model');
    }

	public function index()
	{
        $jeu = $this->jeu_model->getJeu($this->input->get("produit"));
        var_dump($jeu);
		$this->load->view('produit');
	}
    
}
