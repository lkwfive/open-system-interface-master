<?php
namespace OpenSystemInterface;
/**
* 
*/
class OpenInterface
{
    public $info=[];//header info

    function __construct($config)
    {
        $this->user = $config['user'];
        $this->token = $config['token'];
        $this->url = $config['url'];
        $this->url_local = $config['url_local'];
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

    protected function createSign($paramArr)
    {
        $token = $this->token;
        $str = $this->token;
        ksort($paramArr);
        foreach ($paramArr as $key => $val) {
           if ($key !='' && $val !='') {
               $str .= $key.$val;
           }
        }
        $sign = strtoupper(md5($str.$token));
        return $sign;
    }

    /**
     * 内网开放系统不支持post
     */
    // public function post($method, $params, $local=false)
    // {
    //     $config = [
    //         'v'         => '1.0',
    //         'username'  => $this->user,
    //         'method'    => $method,
    //     ];
    //     $params = array_merge($config, $params);
    //     $sign = $this->createSign($params);
    //     $params['sign'] = $sign;
    //     $url = $local ? $this->url_local : $this->url;
    //     $url = $url.http_build_query($params);
    //     return $this->curlPost($url, $params);
    // }

    public function get($method, $params=[], $local=false)
    {
        $config = [
            'v'         => '1.0',
            'username'  => $this->user,
            'method'    => $method,
        ];
        $params = array_merge($config, $params);
        $sign = $this->createSign($params);
        $params['sign'] = $sign;
        $url = $local ? $this->url_local : $this->url;
        $url = $url.http_build_query($params);
        return $this->curlGet($url);
    }
}