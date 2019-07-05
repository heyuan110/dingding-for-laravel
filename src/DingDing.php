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
     * 推送文本消息到钉钉
     *
     * @param $text
     * @return array
     */
    public function pushText($text,$type=DingDingRobot::R0)
    {
        $curl = curl_init();
        $token = null;
        switch ($type){
            case DingDingRobot::R1:
                $token = Config::get('dingding.access_token1');
                break;
            case DingDingRobot::R2:
                $token = Config::get('dingding.access_token2');
                break;
            case DingDingRobot::R3:
                $token = Config::get('dingding.access_token3');
                break;
            case DingDingRobot::R4:
                $token = Config::get('dingding.access_token4');
                break;
        }
        if($token == null || $token == ''){
            $token = Config::get('dingding.access_token');
        }
        curl_setopt($curl, CURLOPT_URL,self::DingDing_URL.$token);
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