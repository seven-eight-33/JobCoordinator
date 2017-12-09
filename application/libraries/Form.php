<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Form {

    protected $CI;

    public function __construct()
    {
        $this->CI =& get_instance();
    }

    // 半角英数記号チェック
    public function _alpha_numeric_symbol()
    {
        $target = $this->CI->input->post("password");
        if(empty($target)) return true;
        if(preg_match("/^[!-~]+$/", $target)){
            return true;
        }else{
            $this->CI->form_validation->set_message("_alpha_numeric_symbol", "パスワード は半角英数記号で入力してください。");
            return false;
        }
    }

    // パスワードマスク
    public function _make_pass($target)
    {
        $result = array();
        if(!empty($target)){
            // パスワードマスク
            $result['mask_pass'] = mb_substr($target, 0, 1);
            for($i = 0; $i < mb_strlen($target) - 1; $i++){
                $result['mask_pass'] .= '*';
            }
            // salt生成
            $result['salt'] = bin2hex(random_bytes(32));
            // stretch生成
            $result['stretch'] = random_int(1, 99);
            // パスワードハッシュ化
            $result['hash_pass'] = $this->_my_hash($target, $result['salt'], $result['stretch']);

/*
            $result['hash_pass'] = hash_hmac('sha512', $result['salt']. $target, false);
            for($i = 0; $i < $result['stretch']; $i++){
                $result['hash_pass'] = hash_hmac('sha512', $result['hash_pass'], false);
            }
*/
        }
        return $result;
    }

    // パスワードハッシュ化
    public function _my_hash($base, $salt, $stretch = 0, $hash_type = 'sha512')
    {
        if(empty($base) || empty($salt)) return false;
        $res_pass = $salt. $base;
        for($i = 0; $i < $stretch; $i++){
            $res_pass = hash_hmac($hash_type, $res_pass, false);
        }
        return $res_pass;
    }
    
    // ユニークキー生成
    public function _make_unique_key($id)
    {
        return (!empty($id))? md5(uniqid($id. rand(),1)): '';
    }

    // メール送信
    public function _my_sendmail($tempPath, $data, $from, $fromName, $to, $subject, $encode = 'UTF-8')
    {
        $message = $this->CI->parser->parse($tempPath, $data, TRUE);

        $this->CI->email->from($from, mb_encode_mimeheader($fromName, $encode, 'B'));
        $this->CI->email->to($to);
        $this->CI->email->subject($subject);
        $this->CI->email->message($message);
        return $this->CI->email->send();
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
                ],
                'errors' => [
                    'required'    => '%s を入力してください。',
                    'max_length'  => '%s は255文字以下で入力してください。',
                    'valid_email' => '%s を正しく入力してください。',
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
