<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Entry_lib {

    protected $CI;

    public function __construct()
    {
        $this->CI =& get_instance();
    }

    // パスワードマスク
    public function _make_pass($target)
    {
        $result = array();
        if(!empty($target)){
            // パスワードマスク
            $result['mask_pass'] = $this->CI->my_string->_make_str_mask($target);
            // salt生成
            $result['salt'] = $this->CI->my_string->_make_salt();
            // stretch生成
            $result['stretch'] = $this->CI->my_string->_make_stretch();
            // パスワードハッシュ化
            $result['hash_pass'] = $this->CI->my_string->_my_hash($target, $result['salt'], $result['stretch']);
        }
        return $result;
    }

    // ユーザーへサンクスメール送信
    public function _user_sendMail($data)
    {
        $res = false;
        if(!empty($data)){
            $mailData = array(
                'name'       => $data['name1']. " ". $data['name2'],
                'unique_url' => $this->CI->config->item('base_url'). 'entry/create/'. $data['unique_key'],
            );
            $res = $this->CI->my_mail->_my_sendmail('template/mail/reg_user',
                                                     $mailData,
                                                     $this->CI->config->item('reg_user_from_admin_mail'),
                                                     $this->CI->config->item('reg_user_from_admin_name'),
                                                     $data['mail'],
                                                     $this->CI->config->item('reg_user_subject_user_temp'));
        }
        return $res;
    }

    // ユニークキーチェック
    // ユニークキーを基に取得したユーザーデータを返却、エラーの場合はfalseを返却
    public function _check_unique_key($targetKey)
    {
        $resData = array();

        // 未入力チェック
        if(empty($targetKey)) return $resData;

        // 32桁チェック
        if(mb_strlen($targetKey) != 32) return $resData;

        // 半角英数チェック
        if(!ctype_alnum($targetKey)) return $resData;

        // DB存在チェック
        $resData = $this->CI->modelUser->get_user_by_ukey($targetKey);

        return $resData;
    }

    // 半角英数記号チェック
    public function _alpha_numeric_symbol()
    {
        $target = $this->CI->input->post("password");
        if(empty($target)) return true;
        if($this->CI->my_check->_alpha_numeric_symbol($target)){
            return true;
        }else{
            $this->CI->form_validation->set_message("_alpha_numeric_symbol", "パスワード は半角英数記号で入力してください。");
            return false;
        }
    }

    // 新規ユーザー登録の入力チェック
    public function _input_validation()
    {
        $config = [
            [
                'field'  => 'user_id',
                'label'  => 'ユーザーID',
                'rules'  => [
                    'required',
                    'min_length[6]',
                    'max_length[20]',
                    'alpha_dash',
                    'is_unique[USER.LOGIN_ID]',
                ],
                'errors' => [
                    'required'   => '%s を入力してください。',
                    'min_length' => '%s は半角6文字以上で入力してください。',
                    'max_length' => '%s は半角20文字以下で入力してください。',
                    'alpha_dash' => '%s は半角英数字で入力してください。',
                    'is_unique'  => '入力された %s は既に使用されています。別の %s を入力してください。',
                ]
            ],
            [
                'field'  => 'name1',
                'label'  => '氏名(姓)',
                'rules'  => [
                    'required',
                    'max_length[60]',
                ],
                'errors' => [
                    'required'   => '%s を入力してください。',
                    'max_length' => '%s は60文字以下で入力してください。',
                ]
            ],
            [
                'field'  => 'name2',
                'label'  => '氏名(名)',
                'rules'  => [
                    'required',
                    'max_length[60]',
                ],
                'errors' => [
                    'required'   => '%s を入力してください。',
                    'max_length' => '%s は60文字以下で入力してください。',
                ]
            ],
            [
                'field'  => 'name1_kana',
                'label'  => '氏名カナ(セイ)',
                'rules'  => [
                    'required',
                    'max_length[60]',
                ],
                'errors' => [
                    'required'   => '%s を入力してください。',
                    'max_length' => '%s は60文字以下で入力してください。',
                ]
            ],
            [
                'field'  => 'name2_kana',
                'label'  => '氏名カナ(メイ)',
                'rules'  => [
                    'required',
                    'max_length[60]',
                ],
                'errors' => [
                    'required'   => '%s を入力してください。',
                    'max_length' => '%s は60文字以下で入力してください。',
                ]
            ],
            [
                'field'  => 'sex',
                'label'  => '性別',
                'rules'  => [
                    'required',
                    'is_natural_no_zero',
                    'less_than[3]',
                ],
                'errors' => [
                    'required'           => '%s を入力してください。',
                    'is_natural_no_zero' => '%s を正しく入力してください。',
                    'less_than'          => '%s を正しく入力してください。',
                ]
            ],
            [
                'field'  => 'zip1',
                'label'  => '郵便番号(前)',
                'rules'  => [
                    'required',
                    'exact_length[3]',
                    'numeric',
                ],
                'errors' => [
                    'required'     => '%s を入力してください。',
                    'exact_length' => '%s は3桁で入力してください。',
                    'numeric'      => '%s は数字で入力してください。',
                ]
            ],
            [
                'field'  => 'zip2',
                'label'  => '郵便番号(後)',
                'rules'  => [
                    'required',
                    'exact_length[4]',
                    'numeric',
                ],
                'errors' => [
                    'required'     => '%s を入力してください。',
                    'exact_length' => '%s は4桁で入力してください。',
                    'numeric'      => '%s は数字で入力してください。',
                ]
            ],
            [
                'field'  => 'pref',
                'label'  => '都道府県',
                'rules'  => [
                    'required',
                    'is_natural_no_zero',
                    'less_than[48]',
                ],
                'errors' => [
                    'required'           => '%s を選択してください。',
                    'is_natural_no_zero' => '%s を選択してください。',
                    'less_than'          => '%s を正しく入力してください。',
                ]
            ],
            [
                'field'  => 'address1',
                'label'  => '住所(市区町村)',
                'rules'  => [
                    'required',
                    'max_length[255]'
                ],
                'errors' => [
                    'required'   => '%s を入力してください。',
                    'max_length' => '%s は255文字以下で入力してください。',
                ]
            ],
            [
                'field'  => 'address2',
                'label'  => '住所(番地、建物名)',
                'rules'  => [
                    'max_length[255]',
                ],
                'errors' => [
                    'max_length' => '%s は255文字以下で入力してください。',
                ]
            ],
            [
                'field'  => 'tel1',
                'label'  => '電話番号(前)',
                'rules'  => [
                    'required',
                    'max_length[3]',
                    'numeric',
                ],
                'errors' => [
                    'required'   => '%s を入力してください。',
                    'max_length' => '%s は3桁以下で入力してください。',
                    'numeric'    => '%s は数字で入力してください。',
                ]
            ],
            [
                'field'  => 'tel2',
                'label'  => '電話番号(中)',
                'rules'  => [
                    'required',
                    'max_length[4]',
                    'numeric',
                ],
                'errors' => [
                    'required'   => '%s を入力してください。',
                    'max_length' => '%s は4桁以下で入力してください。',
                    'numeric'    => '%s は数字で入力してください。',
                ]
            ],
            [
                'field'  => 'tel3',
                'label'  => '電話番号(後)',
                'rules'  => [
                    'required',
                    'max_length[4]',
                    'numeric',
                ],
                'errors' => [
                    'required'   => '%s を入力してください。',
                    'max_length' => '%s は4桁以下で入力してください。',
                    'numeric'    => '%s は数字で入力してください。',
                ]
            ],
            [
                'field'  => 'mail',
                'label'  => 'メールアドレス',
                'rules'  => [
                    'required',
                    'max_length[255]',
                    'valid_email',
//                    'is_unique[USER.MAIL]',
                ],
                'errors' => [
                    'required'    => '%s を入力してください。',
                    'max_length'  => '%s は255文字以下で入力してください。',
                    'valid_email' => '%s を正しく入力してください。',
//                    'is_unique'   => '入力された %s は既に登録されています。',
                ]
            ],
            [
                'field'  => 'mail_conf',
                'label'  => 'メールアドレス確認',
                'rules'  => [
                    'required',
                    'matches[mail]',
                ],
                'errors' => [
                    'required' => '%s を入力してください。',
                    'matches'  => 'メールアドレス と %s が一致しません。',
                ]
            ],
            [
                'field'  => 'password',
                'label'  => 'パスワード',
                'rules'  => [
                    'required',
                    'min_length[6]',
                    'max_length[255]',
                    ['_alpha_numeric_symbol', array($this, '_alpha_numeric_symbol')]
                ],
                'errors' => [
                    'required'   => '%s を入力してください。',
                    'min_length' => '%s は半角6文字以上で入力してください。',
                    'max_length' => '%s は半角255文字以下で入力してください。',
                ]
            ]
        ];

        $this->CI->form_validation->set_rules($config);
        return $this->CI->form_validation->run();
    }

}
