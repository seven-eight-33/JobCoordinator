<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mypage extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('User', 'modelUser', TRUE);
	}

	public function index()
	{
		$data['title'] = 'JobCoordinator-Mypage';
		$data['result'] = $this->modelUser->get_all_user();
		$this->load->view('header', $data);
		$this->load->view('mypage', $data);
		$this->load->view('footer', $data);
	}
}
