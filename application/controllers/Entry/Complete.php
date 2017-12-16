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
        $this->config->load('my_config');
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
//                $inputData['unique_key'] = $this->entry_lib->_make_unique_key($this->modelUser->get_max_user_id() + 1);
                $inputData['unique_key'] = $this->my_string->_make_unique_key($this->modelUser->get_max_user_id() + 1);


                $resInsert = $this->modelUser->insert_user_data($inputData);
                if(empty($resInsert) || !$resInsert['res']) break;

                // サンクスメール送信
//                $resMail = $this->_user_sendMail($inputData);
                $resMail = $this->entry_lib->_user_sendMail($inputData);

                // 管理者通知メール送信

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

    protected function _main_view()
    {
        $this->load->view('header', $this->viewData);
        $this->load->view('entry/complete', $this->viewData);
        $this->load->view('footer', $this->viewData);
    }

/********************* ↓ sub function ↓ *********************/
    // サンクスメール送信
/*    public function _user_sendMail($data)
    {
        $res = false;
        if(!empty($data)){
            $mailData = array(
                'name'       => $data['name1']. " ". $data['name2'],
                'unique_url' => $this->config->item('base_url'). 'entry/create?key='. $data['unique_key'],
            );
            $res = $this->entry_lib->_my_sendmail('template/mail/reg_user',
                                             $mailData,
                                             $this->config->item('reg_user_from_admin_mail'),
                                             $this->config->item('reg_user_from_admin_name'),
                                             $data['mail'],
                                             $this->config->item('reg_user_subject_user_temp'));
        }
        return $res;
    }
*/
}
