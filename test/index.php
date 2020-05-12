<?php
require '../vendor/autoload.php';

use  objui\phpsend\Send;

$config = [
    'SignName'          => '签名',
    'TemplateCode'      => '模板编码',
    'AccessKeyID'       =>  '阿里后台获取AccessKeyID',
    'AccessKeySecret'   =>  '阿里后台获取AccessKeySecret'
];
$obj = new Send($config);
$data = [
    'phone' => '手机号',
    'code'  => '验证码'
];

$result = $obj->send($data);
var_dump($result);
