<?php

Class Blocker extends CI_Model{

    public function block_ip($ip)
    {
        $block = $this->db->get_where('iyh_blocker' , ['type' => 'ip'])->result();
        $true = 0;
        $false = 0;
        foreach($block as $bot)
        {
            $botip = $bot->content;
            if(preg_match("#".$botip."#",$ip))
            {
               $true++;
            }else{
                $false++;
            }
        }
        
        if($true > 0)
        {
           
            return true;
        }else{
           
            return false;
        }
        //return false;

    }
    public function block_host()
    {
        $block = $this->db->get_where('iyh_blocker' , ['type' => 'host'])->result();
            $true = 0;
        $false = 0;
        foreach($block as $bot)
        {
            $hostku = strtolower(@gethostbyaddr($_SERVER['REMOTE_ADDR']));
             if(substr_count($hostku,strtolower($bot->content)) > 0 )
             {
                $true++;
             }else{
                $false++;
             }
           //  return false;
    }
        
        if($true > 0)
        {
            return true;
        }else{
            return false;
        }
}
    public function block_agent()
    {
        $block = $this->db->get_where('iyh_blocker' , ['type' => 'agent'])->result();
            $true = 0;
        $false = 0;
        foreach($block as $bot)
        {
            $agentku=strtolower($_SERVER['HTTP_USER_AGENT']);
             if(substr_count($agentku,strtolower($bot->content)) > 0 )
    {
     $true++;
    }else{
        $false++;
        }
    }
        if($true > 0)
        {
            return true;
        }else{
            return false;
        }
   // return false;
    }

    public function stats($id,$status,$ip,$country,$ket)
    {
        $this->db->insert('iyh_stats',['id_link' => $id,
                                      'status' => $status,
                                      'device' => $this->agent->mobile(),
                                      'browser' => $this->agent->browser(),
                                      'platform' => $this->agent->platform(),
                                      'ip' => $ip,
                                      'country' => $country,
                                      'description' => $ket]);
    }
 public function httpGet($url){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        return $response;
    }
    public function antibot($ip){
        $apiget = $this->db->get_where('iyh_users',['id_users' => $this->session->id_users])->row();
        $api = $apiget->antibot_apikey;

      
        $respons    = $this->httpGet("https://antibot.pw/api/v2-blockers?ip=".$ip."&apikey=".$api."&ua=".urlencode($_SERVER['HTTP_USER_AGENT']));
        $json       = json_decode($respons,true);
        if($json['is_bot'] == 1 || $json['is_bot'] == true){
            return true;
        }else{
            return false;
        }
    }
 
}