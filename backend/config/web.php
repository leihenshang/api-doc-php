<?php

use yii\web\Response;

$params = require __DIR__ . '/params.php';
$db = require __DIR__ . '/db.php';

$config = [
    'id' => 'basic',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm' => '@vendor/npm-asset',
    ],
    'components' => [
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'uhytOYh89bz0CWcWImv5ZNITwejQKpN0',
            'parsers' => [
                'application/json' => 'yii\web\JsonParser',
            ]
        ],
        'response' => [
            'class' => 'yii\web\Response',
            'format' => Response::FORMAT_JSON,
            'on beforeSend' => function ($event) {
                //如果是gii 代码生成器则不进行格式化
                if (strstr(Yii::$app->request->getPathInfo(), 'gii') === false) {
                    $event->sender->headers->add('Access-Control-Allow-Origin', '*');
                    $event->sender->headers->add("Access-Control-Allow-Methods", "POST,GET");
                    $event->sender->headers->add("Access-Control-Allow-Headers", "x-requested-with,content-type");

                    $response = $event->sender;
                    //设置响应状态码为200
                    $response->statusCode = 200;
                    $response->format = Response::FORMAT_JSON;
                    $code = isset($response->data['code']) ? $response->data['code'] : 200;
                    $response->data = [
                        'code' => $code,
                        'msg' => isset($response->data['msg']) ? $response->data['msg'] : (isset($response->data['message']) ? $response->data['message'] : []),
                        'data' => !isset($response->data['data']) ? [] : $response->data['data'],
                    ];
                }
            }
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'identityClass' => 'app\models\User',
            'enableAutoLogin' => true,
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => true,
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'db' => $db,

        'urlManager' => [
            'enablePrettyUrl' => true,
            'enableStrictParsing' => true,
            'showScriptName' => false,
            'rules' => [
                '<controller>/<action>' => '<controller>/<action>',
            ],
        ],
    ],
    'params' => $params,
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];
}

return $config;
