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
        $target_id = $this->CI->input->post("login_id");
        $target_pass = $this->CI->input->post("password");
        if(empty($target_id) || empty($target_pass)) return true;

        $res = false;
        $userData = $this->CI->modelUser->get_once_user($target_id);
        if(!empty($userData)){
            $pass_hash = $this->CI->form->_my_hash($target_pass, $userData['SALT'], $userData['STRETCH']);
//            $pass_hash = $this->CI->my_string->_my_hash($target_pass, $userData['SALT'], $userData['STRETCH']);
            if($userData['PASSWORD'] == $pass_hash) $res = true;
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
                    'required'   => '%s を入力してください。',
                    'max_length' => 'id または %s を正しく入力してください。',
                ]
            ]
        ];
        $this->CI->form_validation->set_rules($config);
        return $this->CI->form_validation->run();
    }

    public function _create_magic_code($id, $mail)
    {
        if(empty($id) || empty($mail)) return false;
        $res = $this->CI->config->item('magic_code'). $id. $mail;
        for($i = 0; $i < $this->CI->config->item('magic_count'); $i++){
            $res = hash_hmac($this->CI->config->item('magic_type'), $res, false);
        }
        return $res;
    }

    public function _check_magic_code($magicCode, $id, $mail)
    {
        $res = false;
        if(!empty($magicCode) && !empty($id) && !empty($mail)){
            if($magicCode === $this->_create_magic_code($id, $mail)) $res = true;
        }
        return $res;
    }

    public function _is_logged_in($backUrl)
    {
        $user = $this->CI->session->userdata();
        if(isset($user['magic_code']) && !empty($user['magic_code']) && $this->_check_magic_code($user['magic_code'], $user['LOGIN_ID'], $user['MAIL'])){
            return true;
        }else{
            // 未ログイン
            // セッションにログイン後のURLをセット
            $setData['logged_in_back_url'] = $backUrl;
            $this->CI->session->set_userdata($setData);
            // ログイン画面にリダイレクト
            redirect('login');
        }
    }
}
