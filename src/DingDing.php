<?php
/**
 * Created by patpat-packagist.
 * User: Bruce.He
 * Date: 20/08/2017
 * Time: 03:59
 */
namespace PatPat\DingDing;
use Illuminate\Support\Facades\Config;

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
    public function pushText($text)
    {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL,self::DingDing_URL.Config::get('dingding.access_token'));
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