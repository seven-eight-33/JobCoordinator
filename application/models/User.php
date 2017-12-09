<?php
class User extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
                $this->load->database();
    }

    public function get_all_user()
    {
        $query = $this->db->get('USER');
        return $query->result();
    }

    public function get_once_user($loginId)
    {
        $resData = array();
        $where = array(
                    'LOGIN_ID' => $loginId
                );
        $this->db->select('*');
        $this->db->from('USER');
        $this->db->where($where);
        $query = $this->db->get();
        $resDataTemp = $query->result('array');

        if(!empty($resDataTemp)){
            $resData = $resDataTemp[0];
        }

        return $resData;
    }

    public function get_max_user_id()
    {
        $this->db->select_max('ID');
        $query = $this->db->get('USER');
        $res = $query->result();
        return $res[0]->ID;
    }

    public function insert_user_data($data)
    {
        $res = array();
        if(!empty($data)){
            $insertData = array(
                            'LOGIN_ID'   => $data['user_id'],
                            'PASSWORD'   => $data['hash_pass'],
                            'USER_TYPE'  => '0',
                            'NAME1'      => $data['name1'],
                            'NAME2'      => $data['name2'],
                            'NAME1_KANA' => $data['name1_kana'],
                            'NAME2_KANA' => $data['name2_kana'],
                            'SEX'        => $data['sex'],
                            'ZIP1'       => $data['zip1'],
                            'ZIP2'       => $data['zip2'],
                            'PREF'       => $data['pref'],
                            'ADDRESS1'   => $data['address1'],
                            'ADDRESS2'   => $data['address2'],
                            'TEL1'       => $data['tel1'],
                            'TEL2'       => $data['tel2'],
                            'TEL3'       => $data['tel3'],
                            'MAIL'       => $data['mail'],
                            'SALT'       => $data['salt'],
                            'STRETCH'    => $data['stretch'],
                            'UNIQUE_KEY' => $data['unique_key'],
                          );

            $res['res'] = $this->db->insert('USER', $insertData);
            $res['insert_id'] = $this->db->insert_id();
        }
        return $res;
    }
}
