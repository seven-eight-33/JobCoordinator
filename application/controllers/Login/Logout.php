<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Logout extends CI_Controller {

    // ログアウト機能は画面出力なし
    public function __construct()
    {
        parent::__construct();
    }

/********************* ↓ routes function ↓ *********************/
    public function index()
    {
        $this->_preprocess();
        $this->_mainprocess();
    }

/********************* ↓ main function ↓ *********************/
    protected function _preprocess()
    {
    }

    protected function _mainprocess()
    {
        // session に保持しているユーザーデータを削除する
        $this->login_lib->_my_logout();

        // TOP にリダイレクト
        redirect(base_url());
    }

    protected function _main_view()
    {
    }

/********************* ↓ sub function ↓ *********************/
}
