<?php

namespace app\controllers;

use yii\rest\Controller;

/**
 * Class BaseController
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