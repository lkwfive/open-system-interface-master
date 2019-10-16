<?php
require './src/OpenInterfaceV2.php';
use OpenSystemInterface\OpenInterfaceV2;

$config = [
    'user_code' => 'J3ADP_XXXXX_XXXXX_XXXXX_XXXXX',             //开发者编号
    'app_token' => '5722ed62e91eb3c5fc8bfa30bfb3701d',          //开发者token
    'server' => 'http://baidu.com',    //入口URL
];

// get
$obj = new OpenInterfaceV2($config);
// 方法 版本
$r = $obj->get('order.test', 'V1.1');
$r = json_decode($r, true);
if($r['status']){
    var_dump($r['data']);
}


// post
$param = [
    "sku"=> "abc",
];

$obj = new OpenInterfaceV2($config);
$r = $obj->post('order.addSpreadUserName', 'V1.1', $param);
var_dump($r);
