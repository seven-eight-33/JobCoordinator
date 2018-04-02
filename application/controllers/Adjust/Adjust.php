<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Adjust extends CI_Controller {

    const INPUT_START   = 1;	// 会員登録入力画面出力
    const INPUT_SUCCESS = 2;	// 入力チェック成功 → 会員登録確認画面へ
    const INPUT_ERROR   = 3;	// 入力チェック失敗 → エラーメッセージをセットして会員登録入力画面出力

    protected $viewType = 0;
    protected $viewData = NULL;
    protected $resData  = NULL;
    protected $mailData = NULL;

    public function __construct()
    {
        parent::__construct();
        $this->load->model('User', 'modelUser', TRUE);
        $this->load->library('developer/google/Calender_lib');
        $this->load->library('controllers/Adjust/adjust_lib');
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
                $mailData['name'] = 'test_duest';
                $mailData['mail'] = 'reon1022@gmail.com';
                $mailData['subject'] = 'test_subject';
                $mailData['bot_name'] = 'test_master のアシスタント ケイト';
                $this->resData = $this->calender_lib->_get_schedule();
                $mailData['schedule_data'] = '';
                foreach($this->resData as $data){
                    $mailData['schedule_data'] .= $data['start']. ':'. $data['summary']. '<br>\n';
                }
                // メール送信
                $resMail = $this->adjust_lib->_user_sendMail($mailData);
                $aaa = '000';
                if(!$resMail) $aaa = '111';
                var_dump($aaa);
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
        $this->viewData['title'] = 'JobCoordinator-Entry';
        $this->viewData['results'] = $this->resData;

        $this->load->view($device. '/common/header', $this->viewData);
        $this->load->view($device. '/test',          $this->viewData);
        $this->load->view($device. '/common/footer', $this->viewData);
    }

/********************* ↓ sub function ↓ *********************/
}
