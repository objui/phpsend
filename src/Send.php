<?php
/**
 * 短信发送
 * Author: objui@qq.com
 * Date: 2020/05/08
 */
namespace objui\phpsend;

class Send
{
    protected $config = [];
    protected static $obj;

    public function __construct(array $config = [])
    {
        $this->config = array_merge($this->config, array_change_key_case($config));
        $this->getInstance();
    }
    
    public function getInstance()
    {
        if(empty(self::$obj)){
            $type = $this->config['type'];
            switch($type){
                default:
                //阿里短信
                self::$obj = new AliPhone($this->config);
            }
        }
        return self::$obj;
    }

    public function send(array $data = [])
    {
          return self::$obj->send($data);
    }
}
