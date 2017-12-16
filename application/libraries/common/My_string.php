<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class My_string {

    public function __construct()
    {
    }

    /**
     * 処理概要 ：  記号のサニタイジングを行う<br />
     *
     * @param string $str 文字列
     * @return string $str サニタイズ後の文字列
     */
    public function _myHtmlspecialchars($str)
    {
        if ($str == "") return $str;

        $str = htmlspecialchars($str);

        $str = str_replace('$',  '&#36;',  $str);
        $str = str_replace('%',  '&#37;',  $str);
        $str = str_replace('\'', '&#39;',  $str);
        $str = str_replace('(',  '&#40;',  $str);
        $str = str_replace(')',  '&#41;',  $str);
        $str = str_replace('*',  '&#42;',  $str);
        $str = str_replace(',',  '&#44;',  $str);
        $str = str_replace('/',  '&#47;',  $str);
        $str = str_replace(':',  '&#58;',  $str);
        $str = str_replace('?',  '&#63;',  $str);
        $str = str_replace('|',  '&#124;', $str);
        $str = str_replace('\\', '&#92;',  $str);

        return $str;
    }

    public function _myHtmlSanitize($data)
    {
        if(empty($data)) return $data;

        if (is_array($data)) {
            return array_map(array($this, "_myHtmlSanitize"), $data);
        } else {
            return $this->_myHtmlspecialchars($data);
        }
    }

    // salt生成
    public function _make_salt()
    {
        return bin2hex(random_bytes(32));
    }

    // stretch回数生成
    public function _make_stretch()
    {
        return random_int(1, 99);
    }

    // 文字列マスク
    public function _make_str_mask($str, $mask = '*')
    {
        if(empty($str)) return $str;
        $res = mb_substr($str, 0, 1);
        for($i = 0; $i < mb_strlen($str) - 1; $i++){
            $res .= $mask;
        }
        return $res;
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

}
