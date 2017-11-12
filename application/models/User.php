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

		public function get_once_user($loginId, $password)
		{
			$where = array(
						'LOGIN_ID' => $loginId,
						'PASSWORD' => $password
					);
			$this->db->select('*');
			$this->db->from('USER');
			$this->db->where($where);
			$query = $this->db->get();

			return $query->result();
		}
}
