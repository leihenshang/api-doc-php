<?php
namespace app\controllers;

use Yii;

class UserController extends BaseController
{

    public function actionTest()
    {
        $res = Yii::$app->db->createCommand('SELECT * FROM userInfo;')->queryAll();
        return ['data' => $res];
    }
}