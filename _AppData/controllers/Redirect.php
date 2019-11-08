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
            $b = json_decode($data->blocker,true);
            $ip = $this->userIP();
            $country = $this->ip2location_lib->getCountryName($ip);
            //print_r($b);
            if(array_key_exists('antibot',$b))
            {
                //antibot
          
                if($this->blocker->antibot($this->userIP()))
                {$this->blocker->stats($data->id_link,'antibot.pw_block',$ip,$country,'Block by antibot');
                    redirect($data->cloak);
                exit;
                }
            
            }


            // block robots.
            if($this->agent->is_robot())
            {
                $this->blocker->stats($data->id_link,'block',$ip,$country,'Block robots by ci');
                redirect($data->cloak);
                exit;
            }
            
            // blocker hijaiyh
            if(array_key_exists('ip',$b))
            {
                if($this->blocker->block_ip($this->userIP()))
                {$this->blocker->stats($data->id_link,'block',$ip,$country,'Block by IP from DB');
                    redirect($data->cloak);
                exit;
                }
            }
            if(array_key_exists('host',$b))
            {
                if($this->blocker->block_host())
                {$this->blocker->stats($data->id_link,'block',$ip,$country,'Block by Host from DB');
                    redirect($data->cloak);
                exit;
                }
            }
            if(array_key_exists('agent',$b))
            {
                if($this->blocker->block_agent())
                {$this->blocker->stats($data->id_link,'block',$ip,$country,'Block by Agent from DB');
                    redirect($data->cloak);
                exit;
                }
            }

            // end.

            // allow.
            $this->blocker->stats($data->id_link,'allow',$ip,$country,'Allowed:PPR');
            redirect($data->link);
        }else{
            echo "cari ap? ";
        }
    }
}
