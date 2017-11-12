<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('User', 'modelUser', TRUE);
	}

	public function index()
	{
		$data['title'] = 'JobCoordinator-Login';

		

		$data['result'] = $this->modelUser->get_all_user();
		$this->load->view('header', $data);
		$this->load->view('login', $data);
		$this->load->view('footer', $data);
	}
}
