<?php


Class Himodel extends CI_Model
{

	public function api_key()
	{
		$q = $this->db->get_where('iyh_users',['id_users' => $this->session->id_users]);
		$row = $q->row();
		return $row->api_key;
	}
	public function account_key()
	{
		$q = $this->db->get_where('iyh_users',['id_users' => $this->session->id_users]);
		$row = $q->row();
		return $row->account_key;
	}
}