<?php
require './src/OpenInterface.php';
use OpenSystemInterface\OpenInterface;

$config = [
    'url_local' => 'xxx',//开放系统内网地址
    'url'       => 'xxx',//开放系统外网地址
    'user'      => 'xxx',//开放系统用户名
    'token'     => 'xxx',//开放系统用户token
];

$obj = new OpenInterface($config);
// 参数分别为  方法 数据 是否走内网(默认走外网开放系统)
$r = $obj->get('datacenter.getRedisData',['key'=>'average_AM002128_BL_XL'], true);
$r = json_decode($r, true);
var_dump($r['data']['data']);
print_r(json_decode($r['data']['data'], true));