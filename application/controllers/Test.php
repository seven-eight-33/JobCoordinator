<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Top extends CI_Controller {

    const TOP_START = 1;	// トップ画面出力

    protected $viewType = 0;
    protected $viewData = NULL;

    public function __construct()
    {
        parent::__construct();
        $this->load->model('User', 'modelUser', TRUE);
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
    }

    protected function _mainprocess()
    {
        $this->viewData['result'] = $this->modelUser->get_all_user();
    }

    protected function _main_view()
    {
        $device = $this->my_device->_get_user_device();
        $this->viewData['title'] = 'JobCoordinator';

        $this->load->view($device. '/common/header', $this->viewData);
        $this->load->view($device. '/top',           $this->viewData);
        $this->load->view($device. '/common/footer', $this->viewData);
    }

/********************* ↓ sub function ↓ *********************/
}
