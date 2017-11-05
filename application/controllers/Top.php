<?php
defined('BASEPATH') OR exit('No direct script access allowed');
//require_once APPPATH. 'models/User.php';

class Top extends CI_Controller {

//	$modelUser = NULL;

	public function __construct()
	{
		parent::__construct();
		//$modelUser = new User();
		$this->load->model('User', 'modelUser', TRUE);
	}

	public function index()
	{
//		$this->load->database();
//		$query = $this->db->get('USER');
		$userData = $this->modelUser->get_all_user();
		foreach ($userData as $row)
		{
			echo $row->NAME1;
		}
		$this->load->view('top');
	}
}
