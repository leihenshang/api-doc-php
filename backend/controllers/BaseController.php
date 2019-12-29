<?php

namespace app\controllers;

use app\models\UserInfo;
use yii\rest\Controller;

/**
 * Class BaseController
 * @property UserInfo $userInfo 通过用户验证行为类注入到基类中
 * @package app\controllers
 */
class BaseController extends Controller
{

    public function success($data = [], $msg = 'success', $code = 200)
    {
        return ['data' => $data, 'msg' => $msg, 'code' => $code];
    }

    public function failed($msg = 'failed', $code = 14, $data = [])
    {
        return $this->success($data, $msg, $code);
    }

}