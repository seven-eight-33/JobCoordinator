<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Input extends CI_Controller {

    const INPUT_START   = 1;	// 会員登録入力画面出力
    const INPUT_SUCCESS = 2;	// 入力チェック成功 → 会員登録確認画面へ
    const INPUT_ERROR   = 3;	// 入力チェック失敗 → エラーメッセージをセットして会員登録入力画面出力

    protected $viewType = 0;
    protected $viewData = NULL;

    public function __construct()
    {
        parent::__construct();
        $this->load->model('User', 'modelUser', TRUE);
        $this->config->load('my_config');
        $this->load->library('Form');
    }

/********************* ↓ routes function ↓ *********************/
    public function index()
    {
        $this->viewType = $this->_preprocess();
        $this->_mainprocess();
        $this->_main_view();
    }

/********************* ↓ main function ↓ *********************/
    protected function _preprocess()
    {
        $res = 0;
        if(empty($this->input->post('action'))){
            $res = self::INPUT_START;
        }else{
            if($this->form->_input_validation()){
                $res = self::INPUT_SUCCESS;
            }else{
                $res = self::INPUT_ERROR;
            }
        }
        return $res;
    }

    protected function _mainprocess()
    {
        switch($this->viewType){
            case self::INPUT_START:     // 初期表示
                if($this->session->has_userdata('fix_flg') && $this->session->userdata('fix_flg') == 1){
                    // 確認画面からの画面遷移の場合(修正)入力値を復元させる
                    $_POST = $this->session->userdata();
                    $this->session->set_userdata('fix_flg', 0);
                }
                $this->viewData['title'] = 'JobCoordinator-Entry';
                $this->viewData['pref_list'] = $this->config->item('pref_list');
                break;
            case self::INPUT_SUCCESS:   // 確認画面へ
                // session 登録
                $userInput = array_merge($this->input->post(), $this->form->_make_pass($this->input->post('password')));
                $this->session->set_userdata($userInput);
                redirect('entry/confirm');
                break;
            case self::INPUT_ERROR:     // 入力エラー
                $this->viewData['title'] = 'JobCoordinator-Entry';
                $this->viewData['pref_list'] = $this->config->item('pref_list');
                break;
            default:
                break;
        }
    }

    protected function _main_view()
    {
        $this->load->view('header', $this->viewData);
        $this->load->view('entry/input', $this->viewData);
        $this->load->view('footer', $this->viewData);
    }

/********************* ↓ sub function ↓ *********************/
}
