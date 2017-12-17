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
        $this->load->library('controllers/Entry/entry_lib');
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
            if($this->entry_lib->_input_validation()){
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
                break;
            case self::INPUT_SUCCESS:   // 確認画面へ
                // session 登録
                $userInput = array_merge($this->input->post(), $this->entry_lib->_make_pass($this->input->post('password')));
                $this->session->set_userdata($userInput);
                redirect('entry/confirm');
                break;
            case self::INPUT_ERROR:     // 入力エラー
                break;
            default:
                break;
        }
    }

    protected function _main_view()
    {
        $device = $this->my_device->_get_user_device();
        $this->viewData['title'] = 'JobCoordinator-Entry';
        $this->viewData['pref_list'] = $this->config->item('pref_list');

        $this->load->view($device. '/common/header', $this->viewData);
        $this->load->view($device. '/entry/input',   $this->viewData);
        $this->load->view($device. '/common/footer', $this->viewData);
    }

/********************* ↓ sub function ↓ *********************/
}
