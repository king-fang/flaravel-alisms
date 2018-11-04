<?php

namespace Flaravel;

use Aliyun\Core\Config as AliyunConfig;
use Aliyun\Core\Profile\DefaultProfile;
use Aliyun\Core\DefaultAcsClient;
use Aliyun\Api\Sms\Request\V20170525\SendSmsRequest;

class FalismsSend implements AliSmsInterface
{
    private $signName;

    private $profile;

    private $request;

    private $acsClient;

    public function __construct()
    {
        AliyunConfig::load();
        $this->signName = config('alisms.sign');
        $this->profile = DefaultProfile::getProfile("cn-hangzhou", config('alisms.app_key'), config('alisms.app_secret'));
        DefaultProfile::addEndpoint("cn-hangzhou", "cn-hangzhou", "Dysmsapi", "dysmsapi.aliyuncs.com");
        $this->acsClient = new DefaultAcsClient($this->profile);
        $this->request = new SendSmsRequest();
    }

    public function code(string $mobile, string $driver, string $code = '')
    {
        $parms = $this->getParmJson($driver);
        $this->setRequest(self::SMS_CODE,$mobile,$parms,empty($code)?[]:['code'=>$code]);
        return $this->send();
    }

    public function notice(string $mobile, string $driver, array $product)
    {
        $parms = $this->getParmJson($driver);
        $this->setRequest(self::SMS_NOTICE,$mobile,$parms,$product);
        return $this->send();
    }


    public function drivers(string $method,string $mobile, string $driver, array $product)
    {
        $parms = $this->getParmJson($driver);
        $this->setRequest($method,$mobile,$parms,$product);
        return $this->send();
    }

    private function getParmJson($driver){
        $parms = config('alisms.json_params.'.$driver);
        if(empty($parms))
        {
            throw  new \InvalidArgumentException('No SMS template found.');
        }
        return $parms;
    }


    private function setRequest($method = 'code',$mobile,$parms,$product = [])
    {
        $this->request->setPhoneNumbers($mobile);
        $this->request->setSignName($this->signName);
        $this->request->setTemplateCode($parms['sms_code']);
        if($method == AliSmsInterface::SMS_CODE){
            $this->request->setTemplateParam(json_encode(array(
                "code"=> empty($product) ? $this->randString() : $product,
                "product"=>$parms['msg']
            ), JSON_UNESCAPED_UNICODE));
        }else if($method == AliSmsInterface::SMS_NOTICE)
        {
            $this->request->setTemplateParam(json_encode($product,JSON_UNESCAPED_UNICODE));
        }else{
            return false;
        }
    }

    private function send(){
        $acsResponse =  $this->acsClient->getAcsResponse($this->request);
        if($acsResponse && strtolower($acsResponse->Code) == 'ok')
        {
            return true;
        }
        return $acsResponse->Message;
    }

    /**
     * 产生随机数串
     * @param integer $len 随机数字长度
     * @return string
     */
    private function randString($len = 6)
    {
        $chars = str_repeat('0123456789', 3);
        // 位数过长重复字符串一定次数
        $chars = str_repeat($chars, $len);
        $chars = str_shuffle($chars);
        $str = substr($chars, 0, $len);
        return $str;
    }
}
