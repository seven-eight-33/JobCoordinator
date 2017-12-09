<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login_lib {

    protected $CI;

    public function __construct()
    {
        $this->CI =& get_instance();
    }

    public function _login_check()
    {
        $res = false;
        $userData = $this->CI->modelUser->get_once_user($this->CI->input->post("login_id"));
        if(!empty($userData)){
            $pass_hash = $this->CI->form->_my_hash($this->input->post("password"), $userData->SALT, $userData->STRETCH);
            if($userData->PASSWORD == $pass_hash) $res = true;
        }

        if(!$res){
            $this->CI->form_validation->set_message("_login_check", "id または password を正しく入力してください。");
        }
        return $res;
    }

    public function _login_validation()
    {
        $config = [
            [
                'field' => 'login_id',
                'label' => 'id',
                'rules' => [
                    'required',
                    'max_length[20]',
                ],
                'errors' => [
                    'required'   => '%s を入力してください。',
                    'max_length' => '%s または password を正しく入力してください。',
                ]
            ],
            [
                'field' => 'password',
                'label' => 'password',
                'rules' => [
                    'required',
                    'max_length[20]',
                    ['_login_check', array($this, '_login_check')],
                ],
                'errors' => [
                    'required' => '%s を入力してください。',
                    'max_length' => 'id または %s を正しく入力してください。',
                ]
            ]
        ];
        $this->CI->form_validation->set_rules($config);
        return $this->CI->form_validation->run();
    }
}
