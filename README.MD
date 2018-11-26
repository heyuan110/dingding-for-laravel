给钉钉机器人发消息，最多可设置5个不同的机器人token，超简单！

1. 配置access_token

```
;设置机器人access_token，需要发到几个群就设置几个token
DINGDING_TOKEN=xxxxxxxxxxxx
DINGDING_TOKEN1=xxxxxxxxxxxx1
DINGDING_TOKEN2=xxxxxxxxxxxx2
DINGDING_TOKEN3=xxxxxxxxxxxx3
DINGDING_TOKEN4=xxxxxxxxxxxx4
```

2. demo

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

#### 升级注意事项

如果你之前是1.0.3版本，升级到1.0.4版本后需要更新配置文件，提前备份好`config/dingding.php`文件，执行下面命令：

`php artisan vendor:publish --provider="PatPat\DingDing\DingDingServiceProvider" --force`

完成！



