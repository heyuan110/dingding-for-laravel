给钉钉机器人发消息，最多可设置5个不同的机器人token，超简单！

## 更新

- 增加支持钉钉机器人加签的安全设置

## 配置

钉钉机器人最新增加了安全设置，有三种方式：自定义关键词，加签，IP地址。

**自定义关键词**：发送的消息里必须包含关键词，无需增加签名和时间戳

**加签**：增加hash256签名校验。第一步，把timestamp+"\n"+密钥当做签名字符串，
使用HmacSHA256算法计算签名，然后进行Base64 encode，最后再把签名参数再进行urlEncode，
得到最终的签名（需要使用UTF-8字符集）；第二步，把 timestamp和第一步得到的签名值拼接到URL中。
详细：https://ding-doc.dingtalk.com/doc#/serverapi2/qf2nxq

**IP地址**：设定后，发送消息和原来相同，也没增加校验，只有来自IP地址范围内的请求才会被正常处理

1. 配置access_token 和 secret

```
;设置机器人access_token，需要发到几个群就设置几个token和secret
DINGDING_TOKEN=xxxxxxxxxxxx
DINGDING_SECRET=xxxxx

DINGDING_TOKEN1=xxxxxxxxxxxx1
DINGDING_SECRET1=xxxxx1

DINGDING_TOKEN2=xxxxxxxxxxxx2
DINGDING_SECRET2=xxxxx2

DINGDING_TOKEN3=xxxxxxxxxxxx3
DINGDING_SECRET3=xxxxx3

DINGDING_TOKEN4=xxxxxxxxxxxx4
DINGDING_SECRET4=xxxxx4

```

注意：DINGDING_SECRET不是非必须项，只有机器人安全设置为加签才需要设置这个值，否则只需要设置DINGDING_TOKEN

## Demo

共有5个机器人access_token，可发到5个不同群

```
//默认发给R0
 $dingDing = new DingDing();
 $dingDing->pushText('hello world!');
 
//发给rebot1
$dingDing->pushText('hello world!'，DingDingRobot::R1);
$dingDing->pushText('hello world!'，DingDingRobot::R2);
$dingDing->pushText('hello world!'，DingDingRobot::R3);
$dingDing->pushText('hello world!'，DingDingRobot::R4);
```

## 升级注意事项

如果你之前是1.0.5版本，升级到1.0.6版本后需要更新配置文件，提前备份好`config/dingding.php`文件，执行下面命令：

`php artisan vendor:publish --provider="PatPat\DingDing\DingDingServiceProvider" --force`

完成！



