<?php
/**
 * Created by patpat-packagist.
 * User: Bruce.He
 * Date: 20/08/2017
 * Time: 03:59
 */
namespace PatPat\DingDing;
use Illuminate\Support\Facades\Config;

class DingDingRobot
{
    //机器人群0，1，2，3，4，最多可以设置5个不同群
    const R0 = 0;
    const R1 = 1;
    const R2 = 2;
    const R3 = 3;
    const R4 = 4;
}

class DingDing
{
    const DingDing_URL='https://oapi.dingtalk.com/robot/send?access_token=';

    /**
     * Create a new confide instance.
     *
     * DingDing constructor.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * 对加签安全设置的机器人发消息签名，规则：https://ding-doc.dingtalk.com/doc#/serverapi2/qf2nxq
     * @param $secret
     * @return string
     */
    public function sign($secret){
        if($secret == null || $secret == '') {
            return '';
        }
        list($msec, $sec) = explode(' ', microtime());
        $timestamp = (float)sprintf('%.0f', (floatval($msec) + floatval($sec)) * 1000);
        $string_to_sign = $timestamp . "\n"  . $secret;
        $signature=hash_hmac('sha256',$string_to_sign,$secret,true);
        $urlencode_signature = urlencode(base64_encode($signature));
        return "timestamp=" . $timestamp . "&sign=" . $urlencode_signature;
    }

    /**
     * 推送文本消息到钉钉
     *
     * @param $text
     * @return array
     */
    public function pushText($text,$type=DingDingRobot::R0)
    {
        $curl = curl_init();
        $token = null;
        $secret = null;
        switch ($type){
            case DingDingRobot::R1:
                $secret = Config::get('dingding.secret1');
                $token = Config::get('dingding.access_token1');
                break;
            case DingDingRobot::R2:
                $secret = Config::get('dingding.secret2');
                $token = Config::get('dingding.access_token2');
                break;
            case DingDingRobot::R3:
                $secret = Config::get('dingding.secret3');
                $token = Config::get('dingding.access_token3');
                break;
            case DingDingRobot::R4:
                $secret = Config::get('dingding.secret4');
                $token = Config::get('dingding.access_token4');
                break;
        }
        if($token == null || $token == ''){
            $secret = Config::get('dingding.secret');
            $token = Config::get('dingding.access_token');
        }
        $url = self::DingDing_URL.$token;
        $sign=$this->sign($secret);
        if($sign != null && $sign != '') {
            $url = $url . "&" . $sign;
        }
        curl_setopt($curl, CURLOPT_URL,$url);
        $header = ['Content-Type:application/json'];
        curl_setopt ( $curl, CURLOPT_HTTPHEADER, $header );
        curl_setopt($curl, CURLOPT_HEADER, 0);  //设置头文件的信息作为数据流输出
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);  //设置获取的信息以文件流的形式返回，而不是直接输出。
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($this->TextData($text)));
        $http_status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        $data = curl_exec($curl);
        if(curl_errno($curl)){
            $error_info = 'Request Error:' . curl_error($curl);
            $result = ['status'=>$http_status,'msg'=>$error_info];
        }else{
            $return_data = json_decode($data,true);
            if($return_data['errcode']==0){
                $result = ['status'=>'200','msg'=>'ok'];
            }else{
                $result = ['status'=>'-1','msg'=>$return_data];
            }
        }
        curl_close($curl);
        return $result;
    }

    /**
     * 文本数据格式
     *
     * @param $text
     * @return array
     */
    private function textData($text)
    {
        return [
            'msgtype'=>"text",
            "text"=>[
                "content"=>$text,
            ]
        ];
    }
}