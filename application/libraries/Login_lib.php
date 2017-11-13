<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login_lib {

    protected $CI;

    public function __construct()
    {
        $this->CI =& get_instance();
    }

}
