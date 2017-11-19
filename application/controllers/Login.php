<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

    const LOGIN_START = 1;
    const LOGIN_SUCCESS = 2;
    const LOGIN_ERROR = 3;

    public $viewType = 0;
    public $viewData = NULL;

    public function __construct()
    {
        parent::__construct();
        $this->load->helper('url', 'form');
        $this->load->library('form_validation');
        $this->load->model('User', 'modelUser', TRUE);
//        $this->load->library('login_lib');
    }

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
        switch($this->$viewType){
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

    public function index()
    {
        $this->$viewType = $this->_preprocess();
        $this->_mainprocess();
        $this->_main_view();
/*
        if(empty($this->input->post('action'))){
            $data['title'] = 'JobCoordinator-Login';
            $data['result'] = $this->modelUser->get_all_user();
        }else{
            if($this->login_validation()){
                redirect('mypage');
            }else{
                $data['title'] = 'JobCoordinator-Login';
            }
        }

        $this->load->view('header', $data);
        $this->load->view('login', $data);
        $this->load->view('footer', $data);
*/
    }

/********************* ↓ サブファンクション ↓ *********************/
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
