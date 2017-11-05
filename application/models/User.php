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
}
