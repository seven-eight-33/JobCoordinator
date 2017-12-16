<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MyCheck {

    public function __construct()
    {
    }

    // 半角英数記号チェック
    public function _alpha_numeric_symbol($target)
    {
        if(empty($target)) return false;
        return (preg_match("/^[!-~]+$/", $target))? true: false;
    }

}
