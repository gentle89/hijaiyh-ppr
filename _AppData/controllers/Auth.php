<?php

Class Auth extends CI_Controller{

  

    public function index()
    {
        redirect(base_url('auth/signin'));
    }
    public function signin()
    {

        $this->load->view('signin');
    }
    public function iyhlogin()
    {
        $user = $this->input->post('username');
        $pass = $this->input->post('password');

        $cek = $this->db->get_where('iyh_users',['username' => $user , 'password' => sha1($pass)]);
        
        if($cek->num_rows() > 0)
        {
            $f = $cek->row();
            $this->session->set_userdata([
                'id_users' => $f->id_users,
                'email' => $f->email,
                'username' => $user , 
                'password' => sha1($pass) , 
                'logged_in' => $_SERVER['REMOTE_ADDR']]);
            redirect(base_url('hijaiyh/panel'));
        }else{
            redirect(base_url('auth/signin/error'));
        }
    }
    public function destroy()
    {
        //session_destroy();

        // or
        
        $this->session->sess_destroy();

        redirect(base_url('auth/signin'));
        
    }

    
}