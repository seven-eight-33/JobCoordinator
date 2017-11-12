<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login_lib {

    public $form_validation = NULL;
    public $modelUser = NULL;
    public $input = NULL;

    public function lib_start($obj)
    {
        $this->form_validation = $obj['form_validation'];
        $this->modelUser = $obj['modelUser'];
        $this->input = $obj['input'];
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
                    'callback_login_check' => 'id または password を正しく入力してください。',
                ]
            ]
        ];
        $this->form_validation->set_rules($config);
        return $this->form_validation->run();
    }

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
}
