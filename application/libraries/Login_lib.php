<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login_lib {

    protected $CI;
    public $input;

    public function __construct()
    {
        $CI =& get_instance();

        $this->CI->load->helper('url', 'form');
        $this->CI->load->library('form_validation');
        $this->CI->load->model('User', 'modelUser', TRUE);
    }

    public function login_check()
    {
        $userData = $this->CI->modelUser->get_once_user($this->input("login_id"), $this->input("password"));
        if(!empty($userData)){
            return true;
        }else{
            $this->CI->form_validation->set_message("login_check", "id または password を正しく入力してください。");
            return false;
        }
    }

    public function login_validation($params)
    {
        $this->input = $params;

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
        $this->CI->form_validation->set_rules($config);
        return $this->CI->form_validation->run();
    }

}
