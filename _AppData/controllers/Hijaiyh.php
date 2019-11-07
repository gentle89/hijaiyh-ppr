<?php
Class Hijaiyh extends CI_Controller{

    private $tiga;

    public function __construct()
    {
        
        parent::__construct();

        $this->load->model('himodel');
        $params = ['acc_key' => $this->himodel->account_key(),
                    'api_key' => $this->himodel->api_key()];
        $this->load->library('hiapi',$params);
        if(!$this->session->has_userdata('logged_in'))
        {
            redirect(base_url('auth/signin'));
        }
         $check = $this->db->get_where('iyh_users',['id_users' =>$this->session->id_users])->row();
        if($check->api_key == '' || empty($check->api_key) || $check->account_key =='' || empty($check->account_key))
        {
            redirect(base_url('activation'));
            exit;
        }else{
            if(!$this->session->has_userdata('api_checked')){

            $data = json_decode($this->hiapi->check_live($check->account_key,$check->api_key),true);
            if($data['status'] != 'live')
            {
                $this->db->update('iyh_users',['account_key' => '','api_key' => ''],['id_users' => $this->session->id_users]);
                redirect(base_url('activation'));
                exit;
            }else{
                $this->session->set_userdata(['api_checked' => 'live']);
            }

            }

        }
    }

    public function index()
    {
       

        redirect(base_url('hijaiyh/panel'));
    }

    public function panel()
    {
        $this->load->view('header');
       $this->load->view('panel');
       $this->load->view('footer');
    }
    public function createshort($param)
    {
        $short = sha1(md5(base64_encode($param)));
        $pendek = substr($short,0,6);
        return $pendek;
    }
    public function shortlink()
    {
        $this->load->view('header');
        $this->load->view('shortlink');
        $this->load->view('footer');

        if($this->uri->segment(3) == 'create')
        {
            $url = $this->input->post('url');
            if($this->input->post('custom') == '' || empty($this->input->post('custom'))){
            $short = "iyh".$this->createshort($url.date('dmY'));
            }else{
            $short = "iyh".$this->input->post('custom');
            }

            $blocker = json_encode($this->input->post('blocker'));
            $cloak = $this->input->post('cloak');

            $insert = $this->db->insert('iyh_link',['link' => $url,
                                                    'short' => $short,
                                                    'cloak' => $cloak,
                                                    'blocker' => $blocker,
                                                    'id_users' => $this->session->userdata('id_users')
                                                    ]);
            if($insert):
                redirect('hijaiyh/shortlink/all');
            else:
                echo "<script>alert('failed to create');window.location.href='".base_url()."';</script>";
            endif;
        }

        if($this->uri->segment(3) == 'update')
        {
            $url = $this->input->post('url');
            $short = "iyh".$this->input->post('custom');
            $blocker = json_encode($this->input->post('blocker'));
            $cloak = $this->input->post('cloak');

            $insert = $this->db->update('iyh_link',['link' => $url,
                                                    'short' => $short,
                                                    'cloak' => $cloak,
                                                    'blocker' => $blocker,
                                                    'id_users' => $this->session->userdata('id_users')
                                                    ] , ['id_link' => $this->uri->segment(4) ]);
            if($insert):
                redirect('hijaiyh/shortlink/all');
            else:
                echo "<script>alert('failed to update');window.location.href='".base_url()."';</script>";
            endif;
        }
    }

    public function profile()
    {
        $this->load->view('header');
        $this->load->view('profile');

        if($this->uri->segment(3) == 'save')
        {
            $user = $this->input->post('username');
            $email = $this->input->post('email');
            $oldpass = $this->input->post('old_password');
            $newpass = $this->input->post('new_password');

            if(sha1($oldpass) == $this->session->password)
            {
                $this->db->update('iyh_users', ['username' => $user , 'password' => sha1($newpass) , 'email' => $email],['id_users' => $this->session->id_users]);
            }else{
                echo "<script>alert('wrong old password');window.location.href='".base_url()."'; </script>";
                exit;
            }
        }
        $this->load->view('footer');
    }
    public function blockers()
    {
        $this->load->view('header');
        $this->load->view('blockers');
        $this->load->view('footer');

        if ($this->uri->segment(3) == 'add') {
            $bots = explode("\n",$this->input->post('bots'));
            $type= $this->input->post('type');

            foreach($bots as $bot)
            {
                $bot = strtolower($bot);
                $this->db->insert('iyh_blocker',['type' => $type , 'content' => $bot , 'author' => $this->session->username,'status' => 'accept']);
            }

            redirect(base_url('hijaiyh/blockers'));
        }
    }
}