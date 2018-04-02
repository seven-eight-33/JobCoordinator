<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Adjust_lib {

    protected $CI;

    public function __construct()
    {
        $this->CI =& get_instance();
    }

    // ユーザーへメール送信
    public function _user_sendMail($data)
    {
        $res = false;
        if(!empty($data)){
            $mailData = array(
                'name'          => $data['name'],
                'bot_name'      => $data['bot_name'],
                'schedule_data' => $data['schedule_data'],
            );
            $res = $this->CI->my_mail->_my_sendmail('template/mail/adjust/send00',
                                                     $mailData,
                                                     $this->CI->config->item('adjust_from_admin_mail'),
                                                     $this->CI->config->item('adjust_from_admin_name'),
                                                     $data['mail'],
                                                     $data['subject']);
        }
        return $res;
    }

}
