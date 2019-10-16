## 使用

```
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
$r = $obj->get('test.get',['data'=>'test get'], true);
var_dump($r);
```

## 使用(V2)
```
<?php
require './src/OpenInterfaceV2.php';
use OpenSystemInterface\OpenInterfaceV2;

$config = [
    'user_code' => 'J3ADP_XXXXX_XXXXX_XXXXX_XXXXX',             //开发者编号
    'app_token' => '5722ed62e91eb3c5fc8bfa30bfb3701d',          //开发者token
    'server' => 'http://baidu.com',    //入口URL
];

$obj = new OpenInterfaceV2($config);
// 方法 版本
$r = $obj->get('order.test', 'V1.1');
$r = json_decode($r, true);
if($r['status']){
    var_dump($r['data']);
}
```