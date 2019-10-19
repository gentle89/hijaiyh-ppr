<?php

Class Blocker extends CI_Model{

    public function block_ip($ip)
    {
        $block = $this->db->get_where('iyh_blocker' , ['type' => 'ip'])->result();
        foreach($block as $bot)
        {
            if(preg_match("/".$bot."/i",$ip))
            {
                return true;
            }else{
                return false;
            }
        }

    }
    public function block_host($host)
    {
        $block = $this->db->get_where('iyh_blocker' , ['type' => 'host'])->result();
        foreach($block as $bot)
        {
            if(preg_match("/".strtolower($bot)."/i",strtolower($host)))
            {
                return true;
            }else{
                return false;
            }
        }
    }
    public function block_agent($agent)
    {
        $block = $this->db->get_where('iyh_blocker' , ['type' => 'agent'])->result();
        foreach($block as $bot)
        {
            if(preg_match("/".strtolower($bot)."/i",strtolower($agent)))
            {
                return true;
            }else{
                return false;
            }
        }
    }

    public function stats($id,$status,$ip,$country)
    {
        $this->db->insert('iyh_stats',['id_link' => $id,
                                      'status' => $status,
                                      'device' => $this->agent->mobile(),
                                      'browser' => $this->agent->browser(),
                                      'platform' => $this->agent->platform(),
                                      'ip' => $ip,
                                      'country' => $country]);
    }
 public function httpGet($url){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        return $response;
    }
    public function antibot(){
        $apiget = $this->db->get_where('iyh_users',['id_users' => $this->session->id_users])->row();
        $api = $apiget->antibot_apikey;

        $ip         = $this->userIP();
        $respons    = $this->httpGet("https://antibot.pw/api/v2-blockers?ip=".$this->userIP()."&apikey=".$api."&ua=".urlencode($_SERVER['HTTP_USER_AGENT']));
        $json       = json_decode($respons,true);
        if($json['is_bot'] == 1 || $json['is_bot'] == true){
            return true;
        }else{
            return false;
        }
    }
 
}