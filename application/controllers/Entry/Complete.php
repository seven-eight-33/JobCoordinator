<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Complete extends CI_Controller {

    const COMPLETE_START   = 1;	// 会員仮登録完了画面出力
    const COMPLETE_SUCCESS = 2;	// 入力チェック成功 → 会員登録完了画面へ
    const COMPLETE_ERROR   = 3;	// 入力チェック失敗 → エラーメッセージをセットして会員登録入力画面出力

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
        if(!empty($this->session->userdata())){
            $res = self::COMPLETE_START;
        }else{
            $res = self::COMPLETE_ERROR;
        }
        return $res;
    }

    protected function _mainprocess()
    {
        switch($this->viewType){
            case self::COMPLETE_START:
                // DB に仮登録
                $inputData = $this->session->userdata();
                $inputData['unique_key'] = $this->my_string->_make_unique_key($this->modelUser->get_max_user_id() + 1);

                $resInsert = $this->modelUser->insert_user_data($inputData);
                if(empty($resInsert) || !$resInsert['res']) break;

                // サンクスメール送信
                $resMail = $this->entry_lib->_user_sendMail($inputData);

                // 管理者通知メール送信

                // セッションクリア
                $this->session->sess_destroy();
                break;
            case self::COMPLETE_ERROR:
                // システムエラー
                break;
            default:
                break;
        }
    }

    protected function _main_view()
    {
        $device = $this->my_device->_get_user_device();
        $this->viewData['title'] = 'JobCoordinator-Entry';

        $this->load->view($device. '/common/header',  $this->viewData);
        $this->load->view($device. '/entry/complete', $this->viewData);
        $this->load->view($device. '/common/footer',  $this->viewData);
    }

/********************* ↓ sub function ↓ *********************/
}
