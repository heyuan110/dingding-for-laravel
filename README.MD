给钉钉机器人发消息，最多可设置5个不同的机器人token，超简单！

## 一、更新

#### 1.0.6

- 支持安全设置为加签的钉钉机器人发送消息

## 二、配置

钉钉机器人最新增加了安全设置，有三种方式：自定义关键词，加签，IP地址。

**自定义关键词**：发送的消息里必须包含关键词，无需增加签名和时间戳

**加签**：增加hash256签名校验。第一步，把timestamp+"\n"+密钥当做签名字符串，
使用HmacSHA256算法计算签名，然后进行Base64 encode，最后再把签名参数再进行urlEncode，
得到最终的签名（需要使用UTF-8字符集）；第二步，把 timestamp和第一步得到的签名值拼接到URL中。
详细：https://ding-doc.dingtalk.com/doc#/serverapi2/qf2nxq

**IP地址**：设定后，发送消息和原来相同，也没增加校验，只有来自IP地址范围内的请求才会被正常处理

#### 1. 引入包

执行`composer require patpat/dingding-for-laravel`将包添加到项目。

也可以打开composer.json文件手动添加`patpat/dingding-for-laravel`包，再`composer update`。

#### 2. 拷贝配置文件

执行`php artisan vendor:publish --provider="PatPat\DingDing\DingDingServiceProvider" --force`将dingding.php配置文件拷贝到项目config目录。

#### 3. .env文件里配置DINGDING_TOKEN和DINGDING_SECRET

如果项目里只有一个机器人发送消息，只需要配置默认token和secret

```
DINGDING_TOKEN=xxxxxxxxxxxxxxxxxxxxxxxx
DINGDING_SECRET=xxxxxxxxxxxxxxxxxxxxxxxx
```

如果项目里有多个机器人发送消息，可增加token和secret配置，最多支持5个。

```
#DINGDING_TOKEN1=xxxxxxxxxxxxxxxxxxxxxxx1
#DINGDING_SECRET1=xxxxxxxxxxxxxxxxxxxxxxx1

#DINGDING_TOKEN2=xxxxxxxxxxxxxxxxxxxxxxx2
#DINGDING_SECRET2=xxxxxxxxxxxxxxxxxxxxxxx2

#DINGDING_TOKEN3=xxxxxxxxxxxxxxxxxxxxxxx3
#DINGDING_SECRET3=xxxxxxxxxxxxxxxxxxxxxxx3

#DINGDING_TOKEN4=xxxxxxxxxxxxxxxxxxxxxxx4
#DINGDING_SECRET4=xxxxxxxxxxxxxxxxxxxxxxx4

```

**注意**：DINGDING_SECRET不是必须项，只有机器人安全设置为加签才需要设置DINGDING_SECRET值。

## 三、使用

发送到默认机器人

```
 $dingDing = new DingDing();
 $dingDing->pushText('hello world!');
```

发送到指定机器人

 ```
//发给robot1
$dingDing->pushText('hello world!'，DingDingRobot::R1);

//发给robot2
$dingDing->pushText('hello world!'，DingDingRobot::R2);

//发给robot3
$dingDing->pushText('hello world!'，DingDingRobot::R3);

//发给robot4
$dingDing->pushText('hello world!'，DingDingRobot::R4);
```

## 四、升级注意事项

### 1.0.6

如果之前是1.0.5版本，升级到1.0.6版本需要更新配置文件，提前备份好`config/dingding.php`文件，执行下面命令：
`php artisan vendor:publish --provider="PatPat\DingDing\DingDingServiceProvider" --force`



