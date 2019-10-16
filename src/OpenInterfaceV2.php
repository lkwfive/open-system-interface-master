<?php
namespace OpenSystemInterface;
/**
* 
*/
class OpenInterfaceV2
{
    public $info=[];//header info

    function __construct($config)
    {
        $this->user_code = $config['user_code'];
        $this->app_token = $config['app_token'];
        $this->server = $config['server'];
    }

    protected function curlGet($url, $timeout=30)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
        $content = curl_exec($ch);
        $this->info = curl_getinfo($ch);
        curl_close($ch);
        return $content;
    }

    protected function curlPost($url, $data, $timeout=30)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        $content = curl_exec($ch);
        $this->info = curl_getinfo($ch);
        curl_close($ch);
        return $content;
    }

    protected function createSign($paramArr) { 
        $str = ""; 
        ksort($paramArr); 
        foreach ($paramArr as $key => $val) { 
           if ($key !='' && $val !='') { 
               $str .=  $key.$val; 
           } 
        }
        $sign = strtoupper(md5($str.$this->app_token));
        return  $sign; 
    }

    /**
     * 内网开放系统不支持post
     */
    public function post($method, $v='1.0', $params=[])
    {
        $config = [
            'method' => $method,
            'v' => $v,
            'format' => 'json',
            'app_key' => $this->user_code,
            'protocol' => 'param3',
        ];
        $params = array_merge($config, $params);
        $sign = $this->createSign($params);
        $url = $this->server.http_build_query(['sign'=>$sign]);
        return $this->curlPost($url, $params);
    }

    public function get($method, $v='1.0', $params=[])
    {
        $config = [
            'method' => $method,
            'v' => $v,
            'format' => 'json',
            'app_key' => $this->user_code,
            'protocol' => 'param3',
        ];
        $params = array_merge($config, $params);
        $sign = $this->createSign($params);
        $params['sign'] = $sign;
        $url = $this->server.http_build_query($params);
        return $this->curlGet($url);
    }
}