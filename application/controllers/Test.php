<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Test extends CI_Controller {

    const INPUT_START   = 1;	// 会員登録入力画面出力
    const INPUT_SUCCESS = 2;	// 入力チェック成功 → 会員登録確認画面へ
    const INPUT_ERROR   = 3;	// 入力チェック失敗 → エラーメッセージをセットして会員登録入力画面出力

    protected $viewType = 0;
    protected $viewData = NULL;
    protected $resData  = NULL;

    public function __construct()
    {
        parent::__construct();
        $this->load->model('User', 'modelUser', TRUE);
        $this->load->library('developer/google/calender_lib');
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
                $this->resData = $this->calender_lib->_get_schedule();
                var_dump($this->resData);
                exit;
                break;
            case self::INPUT_SUCCESS:   // 確認画面へ
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
        $this->viewData['title']     = 'JobCoordinator-Entry';

        $this->load->view($device. '/common/header', $this->viewData);
        $this->load->view($device. '/test',          $this->viewData);
        $this->load->view($device. '/common/footer', $this->viewData);
    }

/********************* ↓ sub function ↓ *********************/
}
