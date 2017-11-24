<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Confirm extends CI_Controller {

    const CONFIRM_START   = 1;	// 会員登録確認画面出力
    const CONFIRM_SUCCESS = 2;	// 入力チェック成功 → 会員登録完了画面へ
    const CONFIRM_ERROR   = 3;	// 入力チェック失敗 → エラーメッセージをセットして会員登録入力画面出力

    public $viewType = 0;
    public $viewData = NULL;

    public function __construct()
    {
        parent::__construct();
        $this->load->model('User', 'modelUser', TRUE);
        $this->config->load('my_config');
//        $this->load->library('login_lib');
    }

    public function _preprocess()
    {
        $res = 0;
        if(empty($this->input->post('action'))){
            $res = self::CONFIRM_START;
        }else{
//            $this->input->post($this->session->userdata());
//            if($this->_input_validation()){
            if(!empty($this->session->userdata())){
                $res = self::CONFIRM_SUCCESS;
            }else{
                $res = self::CONFIRM_ERROR;
            }
        }
        return $res;
    }

    public function _mainprocess()
    {
        switch($this->viewType){
            case self::CONFIRM_START:
                $this->viewData = $this->session->userdata();
                $this->viewData['title'] = 'JobCoordinator-Entry';
                $sex_list = $this->config->item('sex_list');
                $this->viewData['sex_val'] = $sex_list[$this->session->userdata('sex')];
                $pref_list = $this->config->item('pref_list');
                $this->viewData['pref_val'] = $pref_list[$this->session->userdata('pref')];
                $this->viewData['password_val'] = $this->session->userdata('mask_pass');
                break;
            case self::CONFIRM_SUCCESS:
                // session 操作
//                $this->session->set_userdata($this->session->userdata());
                redirect('entry/complete');
                break;
            case self::CONFIRM_ERROR:
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
        $this->load->view('entry/confirm', $this->viewData);
        $this->load->view('footer', $this->viewData);
    }

    public function index()
    {
        $this->viewType = $this->_preprocess();
        $this->_mainprocess();
        $this->_main_view();
    }

/********************* ↓ sub function ↓ *********************/
    // 半角英数記号チェック
    public function _alpha_numeric_symbol()
    {
        if(preg_match("/^[!-~]+$/", $this->input->post("password"))){
            return true;
        }else{
            $this->form_validation->set_message("_alpha_numeric_symbol", "パスワード は半角英数記号で入力してください。");
            return false;
        }
    }

    public function _input_validation()
    {
        $config = [
            [
                'field'  => 'user_id',
                'label'  => 'user_id',
                'rules'  => 'required|min_length[6]|max_length[20]|alpha_dash|is_unique[USER.LOGIN_ID]',
                'errors' => [
                    'required'   => 'ユーザーID を入力してください。',
                    'min_length' => 'ユーザーID は半角6文字以上で入力してください。',
                    'max_length' => 'ユーザーID は半角20文字以下で入力してください。',
                    'alpha_dash' => 'ユーザーID は半角英数字で入力してください。',
                    'is_unique'  => '入力された ユーザーID は既に使用されています。別の ユーザーID を入力してください。',
                ]
            ],
            [
                'field'  => 'name1',
                'label'  => 'name1',
                'rules'  => 'required|max_length[60]',
                'errors' => [
                    'required'   => '氏名(姓) を入力してください。',
                    'max_length' => '氏名(姓) は60文字以下で入力してください。',
                ]
            ],
            [
                'field'  => 'name2',
                'label'  => 'name2',
                'rules'  => 'required|max_length[60]',
                'errors' => [
                    'required'   => '氏名(名) を入力してください。',
                    'max_length' => '氏名(名) は60文字以下で入力してください。',
                ]
            ],
            [
                'field'  => 'name1_kana',
                'label'  => 'name1_kana',
                'rules'  => 'required|max_length[60]',
                'errors' => [
                    'required'   => '氏名カナ(セイ) を入力してください。',
                    'max_length' => '氏名カナ(セイ) は60文字以下で入力してください。',
                ]
            ],
            [
                'field'  => 'name2_kana',
                'label'  => 'name2_kana',
                'rules'  => 'required|max_length[60]',
                'errors' => [
                    'required'   => '氏名カナ(メイ) を入力してください。',
                    'max_length' => '氏名カナ(メイ) は60文字以下で入力してください。',
                ]
            ],
            [
                'field'  => 'sex',
                'label'  => 'sex',
                'rules'  => 'required|is_natural_no_zero|less_than[2]',
                'errors' => [
                    'required'           => '性別 を入力してください。',
                    'is_natural_no_zero' => '性別 を正しく入力してください。',
                    'less_than'          => '性別 を正しく入力してください。',
                ]
            ],
            [
                'field'  => 'zip1',
                'label'  => 'zip1',
                'rules'  => 'required|exact_length[3]|numeric',
                'errors' => [
                    'required'     => '郵便番号(前) を入力してください。',
                    'exact_length' => '郵便番号(前) は3桁で入力してください。',
                    'numeric'      => '郵便番号(前) は数字で入力してください。',
                ]
            ],
            [
                'field'  => 'zip2',
                'label'  => 'zip2',
                'rules'  => 'required|exact_length[4]|numeric',
                'errors' => [
                    'required'     => '郵便番号(後) を入力してください。',
                    'exact_length' => '郵便番号(後) は4桁で入力してください。',
                    'numeric'      => '郵便番号(後) は数字で入力してください。',
                ]
            ],
            [
                'field'  => 'address1',
                'label'  => 'address1',
                'rules'  => 'required|max_length[255]',
                'errors' => [
                    'required'   => '住所(市区町村) を入力してください。',
                    'max_length' => '住所(市区町村) は255文字以下で入力してください。',
                ]
            ],
            [
                'field'  => 'address2',
                'label'  => 'address2',
                'rules'  => 'max_length[255]',
                'errors' => [
                    'max_length' => '住所(番地、建物名) は255文字以下で入力してください。',
                ]
            ],
            [
                'field'  => 'tel1',
                'label'  => 'tel1',
                'rules'  => 'required|max_length[3]|numeric',
                'errors' => [
                    'required'   => '電話番号(前) を入力してください。',
                    'max_length' => '電話番号(前) は3桁以下で入力してください。',
                    'numeric'    => '電話番号(前) は数字で入力してください。',
                ]
            ],
            [
                'field'  => 'tel2',
                'label'  => 'tel2',
                'rules'  => 'required|max_length[4]|numeric',
                'errors' => [
                    'required'   => '電話番号(中) を入力してください。',
                    'max_length' => '電話番号(中) は4桁以下で入力してください。',
                    'numeric'    => '電話番号(中) は数字で入力してください。',
                ]
            ],
            [
                'field'  => 'tel3',
                'label'  => 'tel3',
                'rules'  => 'required|max_length[4]|numeric',
                'errors' => [
                    'required'   => '電話番号(後) を入力してください。',
                    'max_length' => '電話番号(後) は4桁以下で入力してください。',
                    'numeric'    => '電話番号(後) は数字で入力してください。',
                ]
            ],
            [
                'field'  => 'mail',
                'label'  => 'mail',
                'rules'  => 'required|max_length[255]|valid_email',
                'errors' => [
                    'required'    => 'メールアドレス を入力してください。',
                    'max_length'  => 'メールアドレス は255文字以下で入力してください。',
                    'valid_email' => 'メールアドレス を正しく入力してください。',
                ]
            ],
            [
                'field'  => 'mail_conf',
                'label'  => 'mail_conf',
                'rules'  => 'required|matches[mail]',
                'errors' => [
                    'required' => 'メールアドレス確認 を入力してください。',
                    'matches'  => 'メールアドレス と メールアドレス確認 が一致しません。',
                ]
            ],
            [
                'field'  => 'password',
                'label'  => 'password',
                'rules'  => 'required|min_length[6]|max_length[255]|callback__alpha_numeric_symbol',
                'errors' => [
                    'required'   => 'ユーザーID を入力してください。',
                    'min_length' => 'ユーザーID は半角6文字以上で入力してください。',
                    'max_length' => 'ユーザーID は半角255文字以下で入力してください。',
                ]
            ]
        ];
        $this->form_validation->set_rules($config);
        return $this->form_validation->run();
    }
}
