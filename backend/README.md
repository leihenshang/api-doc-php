#### 概要
这个项目使用YII2框架

目录结构
-------------------

      assets/             contains assets definition
      commands/           contains console commands (controllers)
      config/             contains application configurations
      controllers/        contains Web controller classes
      mail/               contains view files for e-mails
      models/             contains model classes
      runtime/            contains files generated during runtime
      tests/              contains various tests for the basic application
      vendor/             contains dependent 3rd-party packages
      views/              contains view files for the Web application
      web/                contains the entry script and Web resources



需求
------------

PHP>=7.2


安装依赖
------------

```
composer istall -vv
```

配置
-------------

### 数据库

Edit the file `config/db.php` with real data, for example:

```php
return [
    'class' => 'yii\db\Connection',
    'dsn' => 'mysql:host=localhost;dbname=yii2basic',
    'username' => 'root',
    'password' => '1234',
    'charset' => 'utf8',
];
```

接口返回参数规定 
-------------

返回的数据是一个json对象，基本数据结构必含 data,code,msg
- data 数据是数据对象
    - `列表返回` `{"count":20,"items":[ itme1... , item2.... , ... ]}`
- msg 消息
- code 返回状态代码
     - 200 成功
     - 14  参数错误
     - 34  用户验证相关错误 
     - 22  数据相关错误 

成功
```json
{
 "data":null,
 "msg":"success",
 "code":200
}
```
失败
```json
{
 "data":null,
 "msg":"failed",
 "code":14
}
```