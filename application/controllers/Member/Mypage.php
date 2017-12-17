<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mypage extends CI_Controller {

    const MYPAGE_START   = 1;	// マイページ画面出力

    protected $viewType = 0;
    protected $viewData = NULL;

    public function __construct()
    {
        parent::__construct();
        $this->load->model('User', 'modelUser', TRUE);
        $this->load->library('controllers/Login/login_lib');
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
            $res = self::MYPAGE_START;
        }else{
            // 各種対応画面indexをセット
        }
        return $res;
    }

    protected function _mainprocess()
    {
        switch($this->viewType){
            case self::MYPAGE_START:
                break;
            default:
                break;
        }
    }

    protected function _main_view()
    {
        $device = $this->my_device->_get_user_device();
        $this->viewData['title'] = 'JobCoordinator-MemberTop';

        $this->load->view($device. '/common/header', $this->viewData);
        $this->load->view($device. '/member/mypage', $this->viewData);
        $this->load->view($device. '/common/footer', $this->viewData);
    }

/********************* ↓ sub function ↓ *********************/
}
