<?php
/**
 * 阿里短信发送
 * author； objui@qq.com
 * time: 2020/5/8
 */
namespace objui\phpsend;

use objui\phpsend\ISend;
use AlibabaCloud\Client\AlibabaCloud;
use AlibabaCloud\Client\Exception\ClientException;
use AlibabaCloud\Client\Exception\ServerException;

class AliPhone implements ISend
{
    private $config = [        
        'version'           => '2017-05-25',
        'action'            => 'SendSms',   
        'method'            => 'POST',      
        'scheme'            => 'http',      
        'product'           => 'Dysmsapi',  
        'signname'          => '',  
        'templatecode'      => '',
        'regionid'          => 'cn-hangzhou',                                                                                  
    ];
    private $accessKeyId;      
    private $accessKeySecret;  
          
    public function __construct(array $config = [])                                                                            
    {
        $config = array_change_key_case($config);
        $this->config = array_merge($this->config, $config);
        $this->accessKeyId = $config['accesskeyid'];
        $this->accessKeySecret = $config['accesskeysecret'];                             
        unset($config['accesskeyid']);
        unset($config['accesskeysecret']);
    }     
 
    public function send(array $data = [])
    {
        AlibabaCloud::accessKeyClient($this->accessKeyId, $this->accessKeySecret)
                        ->regionId($this->config['regionid'])
                        ->asDefaultClient();

        try {
            $code = $data['code'] ?: '';
            $phone = $data['phone'] ?: '';
            $result = AlibabaCloud::rpc()
                   ->product('Dysmsapi')
                // ->scheme('https') // https | http
                   ->version($this->config['version'])
                   ->action($this->config['action'])
                   ->method($this->config['method'])
                   ->options([
                       'query' => [
                           'PhoneNumbers' => $phone,
                           'SignName'     => $this->config['signname'],
                           'TemplateCode' => $this->config['templatecode'],
                           'TemplateParam'=> json_encode(['code'=>$code])
                       ],
                    ])->request();
            $result = $result->toArray();
            return $result;
        } catch (ClientException $e) {
            return $e->getErrorMessage();
        } catch (ServerException $e) {
            return $e->getErrorMessage();
        }

    }
}
