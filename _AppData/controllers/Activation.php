<?php 

Class Activation extends CI_Controller{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('himodel');
		$params = ['acc_key' => $this->himodel->account_key(),
                    'api_key' => $this->himodel->api_key()];
        $this->load->library('hiapi',$params);

          $check = $this->db->get_where('iyh_users',['id_users' =>$this->session->id_users])->row();
        if(!empty($check->api_key) && !empty($check->account_key))
        {
               $data = json_decode($this->hiapi->check_live($check->account_key,$check->api_key),true);
            if($data['status'] != 'dead')
            {
          
                redirect(base_url('hijaiyh/panel'));
                exit;
            }
        }

        }

	
	public function index()
	{
		$this->load->view('activator');
	}

   
    public function check()
    {
    	$acc = $this->input->post('account');
    	$api = $this->input->post('signature');
        $setup = [CURLOPT_URL=>'https://hijaiyh.me/index.php/api_ppr/get/'.$acc.'/'.$api,
                  CURLOPT_USERAGENT=>'HijaIyh_App',
                  CURLOPT_RETURNTRANSFER=>true,
                  CURLOPT_SSL_VERIFYPEER=>false,
                  CURLOPT_SSL_VERIFYHOST=>false];
        $c = curl_init();
        curl_setopt_array($c,$setup);
        $resp = curl_exec($c);
        curl_close($c);
        $x['view'] = "<center><h1>";
        if(preg_match("/not found/",$resp))
        {
            $x['view'] .= "<div class='bg-warning text-dark spacer-small'>Request not found 1</div>";
        }elseif(preg_match("/status/",$resp))
        {
            $decode = json_decode($resp,TRUE);
            if($decode['status'] == 'dead')
            {
                $x['view'] .="<div class='bg-danger text-white spacer-small'>ACCOUNT KEY OR API KEY WAS WRONG !</div>";
            }elseif($decode['status'] == 'live')
            {
                $cdir = dirname(__DIR__).'/config/';

                $x['view'] .="<div class='bg-success text-white spacer-small'>SUCCESSFULLY ACTIVATED !</div>";
            
               	$this->db->update('iyh_users',['api_key' => $api ,'account_key' => $acc]);
            }
        }else{
            file_put_contents('log.txt',$resp);
            $x['view'] .= "<div class='bg-warning text-dark spacer-small'>Request not found 2</div>";
            
        }
        $x['view'] .="</h1></center>";
        //curl_close();
        $this->load->view('activator',$x);
        
    }
	

 }
