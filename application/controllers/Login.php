<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
//		$this->load->helper('url', 'form');
//		$this->load->library('form_validation');
		$this->load->model('User', 'modelUser', TRUE);
		$this->load->library('login_lib');
	}
/*
	public function login_check()
	{
		$userData = $this->modelUser->get_once_user($this->input->post("login_id"), $this->input->post("password"));
		if(!empty($userData)){
			return true;
		}else{
			$this->form_validation->set_message("login_check", "id または password を正しく入力してください。");
			return false;
		}
	}
*/
	public function index()
	{
		if(empty($this->input->post('action'))){
			$data['title'] = 'JobCoordinator-Login';
			$data['result'] = $this->modelUser->get_all_user();
			$this->load->view('header', $data);
			$this->load->view('login', $data);
			$this->load->view('footer', $data);
		}else{

			if($this->login_lib->login_validation()){
				redirect('mypage');
			}else{
				$data['title'] = 'JobCoordinator-Login';
				$this->load->view('header', $data);
				$this->load->view('login', $data);
				$this->load->view('footer', $data);
			}
/*
			$config = [
				[
					'field' => 'login_id',
					'label' => 'id',
					'rules' => 'required|max_length[20]',
					'errors' => [
						'required' => 'id を入力してください。',
						'max_length' => 'id または password を正しく入力してください。',
					]
				],
				[
					'field' => 'password',
					'label' => 'password',
					'rules' => 'required|max_length[20]|callback_login_check',
					'errors' => [
						'required' => 'password を入力してください。',
						'max_length' => 'id または password を正しく入力してください。',
						'callback_login_check' => 'id または password を正しく入力してください。',
					]
				]
			];
			$this->form_validation->set_rules($config);

			if($this->form_validation->run()){	//バリデーションエラーがなかった場合の処理
				redirect('mypage');
			}else{							//バリデーションエラーがあった場合の処理
				$data['title'] = 'JobCoordinator-Login';
				$this->load->view('header', $data);
				$this->load->view('login', $data);
				$this->load->view('footer', $data);
			}
*/
		}
	}
}
