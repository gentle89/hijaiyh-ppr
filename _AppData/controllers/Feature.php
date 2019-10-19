<?php

Class Feature extends CI_Controller{
	
	public function index()
	{
		$this->load->view('header');
		$this->load->view('feature/index');
		$this->load->view('footer');
	}

	public function antibot()
	{
		$this->load->view('header');
		$this->load->view('feature/antibot');
		$this->load->view('footer');

		if($this->uri->segment(3) == 'save')
		{
			$api  =$this->input->post('apikey');
			$this->db->update('iyh_users' ,['antibot_apikey' => $api] , ['id_users' => $this->session->id_users]);
			redirect(base_url('feature/antibot.html'));
		}elseif($this->uri->segment(3) == 'delete')
		{
			$api  = '';
			$this->db->update('iyh_users' ,['antibot_apikey' => $api] , ['id_users' => $this->session->id_users]);
			redirect(base_url('feature/antibot.html'));
		}
	}
}