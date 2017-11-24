<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Complete extends CI_Controller {

    const COMPLETE_START   = 1;	// 会員仮登録完了画面出力
    const COMPLETE_SUCCESS = 2;	// 入力チェック成功 → 会員登録完了画面へ
    const COMPLETE_ERROR   = 3;	// 入力チェック失敗 → エラーメッセージをセットして会員登録入力画面出力

    public $viewType = 0;
    public $viewData = NULL;

    public function __construct()
    {
        parent::__construct();
        $this->load->model('User', 'modelUser', TRUE);
        $this->config->load('my_config');
        $this->load->library('email');
        $this->load->library('parser');
//        $this->load->library('login_lib');
    }

    public function _preprocess()
    {
        $res = 0;
        if(!empty($this->session->userdata())){
            $res = self::COMPLETE_START;
        }else{
            $res = self::COMPLETE_ERROR;
        }
        return $res;
    }

    public function _mainprocess()
    {
        switch($this->viewType){
            case self::COMPLETE_START:
                // DB に仮登録
                $inputData = $this->session->userdata();
                $inputData['unique_key'] = $this->_make_unique_key($this->modelUser->get_max_user_id() + 1);


var_dump($this->session->userdata());
exit;



                $resInsert = $this->modelUser->insert_user_data($inputData);
                if(empty($resInsert) || !$resInsert['res']) break;

                // メール送信
                $mailData = array(
                    'name'       => $inputData['name1']. " ". $inputData['name2'],
                    'unique_url' => $this->config->item('base_url'). 'entry/create?key='. $inputData['unique_key'],
                );
                $message = $this->parser->parse('template/mail/reg_user', $mailData, TRUE);

                $this->email->from($this->config->item('reg_user_from_admin_mail'), mb_encode_mimeheader($this->config->item('reg_user_from_admin_name'), 'UTF-8', 'B'));
                $this->email->to($inputData['mail']);
                $this->email->subject($this->config->item('reg_user_subject_user_temp'));
                $this->email->message($message);
                $this->email->send();

                // セッションクリア
                $this->session->sess_destroy();
                break;
            case self::COMPLETE_ERROR:
                // システムエラー
                $this->viewData['title'] = 'JobCoordinator-Entry';
                break;
            default:
                break;
        }
    }

    public function _main_view()
    {
        $this->load->view('header', $this->viewData);
        $this->load->view('entry/complete', $this->viewData);
        $this->load->view('footer', $this->viewData);
    }

    public function index()
    {
        $this->viewType = $this->_preprocess();
        $this->_mainprocess();
        $this->_main_view();
    }

/********************* ↓ sub function ↓ *********************/
    // ユニークキー生成
    public function _make_unique_key($id)
    {
        return (!empty($id))? md5(uniqid($id. rand(),1)): '';
    }
}
