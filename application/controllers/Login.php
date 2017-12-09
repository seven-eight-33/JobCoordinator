<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

    const LOGIN_START = 1;		// ログイン画面出力
    const LOGIN_SUCCESS = 2;	// ログイン処理成功 → マイページTOPへ
    const LOGIN_ERROR = 3;		// ログイン処理失敗 → エラーメッセージをセットしてログイン画面出力

    public $viewType = 0;
    public $viewData = NULL;

    public function __construct()
    {
        parent::__construct();
        $this->load->helper('url', 'form');
        $this->load->library('form_validation');
        $this->load->model('User', 'modelUser', TRUE);
        $this->load->library('Form');
//        $this->load->library('login_lib');
    }

/********************* ↓ routes function ↓ *********************/
    public function index()
    {
        $this->viewType = $this->_preprocess();
        $this->_mainprocess();
        $this->_main_view();
    }

/********************* ↓ main function ↓ *********************/
    public function _preprocess()
    {
        $res = 0;
        if(empty($this->input->post('action'))){
            $res = self::LOGIN_START;
        }else{
            if($this->login_validation()){
                $res = self::LOGIN_SUCCESS;
            }else{
                $res = self::LOGIN_ERROR;
            }
        }
        return $res;
    }

    public function _mainprocess()
    {
        switch($this->viewType){
            case self::LOGIN_START:
                $this->viewData['title'] = 'JobCoordinator-Login';
                $this->viewData['result'] = $this->modelUser->get_all_user();
                break;
            case self::LOGIN_SUCCESS:
                // session 操作
                redirect('mypage');
                break;
            case self::LOGIN_ERROR:
                $this->viewData['title'] = 'JobCoordinator-Login';
                break;
            default:
                break;
        }
    }

    public function _main_view()
    {
        $this->load->view('header', $this->viewData);
        $this->load->view('login', $this->viewData);
        $this->load->view('footer', $this->viewData);
    }

/********************* ↓ sub function ↓ *********************/
    public function login_check()
    {
        $res = false;
//        $pass_hash = $this->form->_make_pass($this->input->post("password"));
        $userData = $this->modelUser->get_once_user($this->input->post("login_id"));
        if(!empty($userData)){

var_dump($userData);
exit;

            $pass_hash = $this->form->_my_hash($this->input->post("password"), $userData[0]['SALT'], $userData[0]['STRETCH']);
            if($userData[0]['PASSWORD'] == $pass_hash) $res = true;
        }

        if(!$res){
            $this->form_validation->set_message("login_check", "id または password を正しく入力してください。");
        }
        return $res;

/*
        if(!empty($userData)){
            return true;
        }else{
            $this->form_validation->set_message("login_check", "id または password を正しく入力してください。");
            return false;
        }
*/
    }

    public function login_validation()
    {
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
                ]
            ]
        ];
        $this->form_validation->set_rules($config);
        return $this->form_validation->run();
    }
}
