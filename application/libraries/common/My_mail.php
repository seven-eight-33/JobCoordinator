<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class My_mail {

    protected $CI;

    public function __construct()
    {
        $this->CI =& get_instance();
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

}
