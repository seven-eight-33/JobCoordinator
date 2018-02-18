<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Confirm extends CI_Controller {

    const CONFIRM_START   = 1;	// 会員登録確認画面出力
    const CONFIRM_SUCCESS = 2;	// 入力チェック成功 → 会員登録完了画面へ
    const CONFIRM_ERROR   = 3;	// 入力チェック失敗 → エラーメッセージをセットして会員登録入力画面出力

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
            $res = self::CONFIRM_START;
        }else{
            if(!empty($this->session->userdata($this->config->item('sess_entry')))){
                $res = self::CONFIRM_SUCCESS;
            }else{
                $res = self::CONFIRM_ERROR;
            }
        }
        return $res;
    }

    protected function _mainprocess()
    {
        switch($this->viewType){
            case self::CONFIRM_START:
                $sex_list = $this->config->item('sex_list');
                $pref_list = $this->config->item('pref_list');

                $confData = $this->session->userdata($this->config->item('sess_entry'));
                $confData['sex_val'] = $sex_list[$confData['sex']];
                $confData['pref_val'] = $pref_list[$confData['pref']];
                $confData['password_val'] = $confData['mask_pass'];
                $this->viewData = $this->my_string->_myHtmlSanitize($confData);
                break;
            case self::CONFIRM_SUCCESS:
                switch($this->input->post('action')){
                    case 1:     // 登録ボタン押下
                        // 会員登録仮登録完了画面へ
                        redirect('entry/complete');
                        break;
                    case 2:     // 修正ボタン押下
                        // 会員登録入力画面へ
                        $this->session->set_userdata('fix_flg', '1');
                        redirect('entry/input');
                        break;
                    default:
                        break;
                }
                break;
            case self::CONFIRM_ERROR:
                // システムエラー → 入力画面へリダイレクト
                redirect('entry/input');
                break;
            default:
                break;
        }
    }

    protected function _main_view()
    {
        $device = $this->my_device->_get_user_device();
        $this->viewData['title'] = 'JobCoordinator-Entry';

        $this->load->view($device. '/common/header', $this->viewData);
        $this->load->view($device. '/entry/confirm', $this->viewData);
        $this->load->view($device. '/common/footer', $this->viewData);
    }

/********************* ↓ sub function ↓ *********************/
}
