<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->helper('url', 'form');
		$this->load->library('form_validation');
		$this->load->model('User', 'modelUser', TRUE);
	}

	public function login_check()
	{
		$userData = $this->modelUser->get_once_user($this->input->post("login_id"), $this->input->post("password"));
		return (!empty($userData))? true: false;
	}

	public function index()
	{
		if(empty($this->input->post('action'))){
			$data['title'] = 'JobCoordinator-Login';
			$data['result'] = $this->modelUser->get_all_user();
			$this->load->view('header', $data);
			$this->load->view('login', $data);
			$this->load->view('footer', $data);
		}else{
			$config = [
				[
					'field' => 'login_id',
					'label' => 'id',
					'rules' => 'required|max_length[20]',
					[
						'required' => 'id を入力してください。',
						'max_length' => 'id または password を正しく入力してください。',
					]
				],
				[
					'field' => 'password',
					'label' => 'password',
					'rules' => 'required|max_length[20]|callback_login_check',
					[
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

/*
			$data = $this->input->post();

			// バリデート
			$errMsg = '';
			if(empty($this->input->post('login_id'))){
				$errMsg = 'id を入力してください。';
			}elseif(mb_strlen($this->input->post('login_id')) > 20){
				$errMsg = 'id または password を正しく入力してください。';
			}

			if(empty($errMsg) && empty($this->input->post('password'))){
				$errMsg = 'password を入力してください。';
			}elseif(empty($errMsg) && mb_strlen($this->input->post('password')) > 20){
				$errMsg = 'id または password を正しく入力してください。';
			}

			// DBチェック
			if(empty($errMsg)){
				$userData = $this->modelUser->get_once_user($data['login_id'], $data['password']);
				if(!empty($userData)){
					// 成功 → マイページへ
					redirect('mypage');
				}else{
					$errMsg = 'id または password を正しく入力してください。';
				}
			}

			$data['title'] = 'JobCoordinator-Login';
			$data['errMsg'] = '<p class="error">'. $errMsg. '</p>';
			$this->load->view('header', $data);
			$this->load->view('login', $data);
			$this->load->view('footer', $data);
*/
		}
	}
}
