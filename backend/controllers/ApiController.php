<?php

namespace app\controllers;

use app\models\Api;
use Yii;

class ApiController extends BaseController
{

    public function actionTest()
    {
        $res = Api::find()->where(['id' => '1'])->one();
        return ['data' => $res];
    }

    /**
     * 创建数据
     * @return array
     */
    public function actionCreate()
    {
        $group = new Api(['scenario' => Api::SCENARIO_CREATE]);
        $group->attributes = Yii::$app->request->post();
        $res = $group->createData();
        if (is_string($res)) {
            return ['msg' => $res];
        }

        return ['data' => '成功'];
    }

    /**
     * 更新数据
     * @return array
     */
    public function actionUpdate()
    {
        $group = new Api(['scenario' => Api::SCENARIO_UPDATE]);
       $request = Yii::$app->request->post();
        $res = $group->updateData($request);
        if (is_string($res)) {
            return ['msg' => $res];
        }

        return ['data' => '成功'];
    }

    /**
     * 分组列表
     * @return array
     */
    public function actionList()
    {
        $res = Api::findAll(['is_deleted' => 0]);
        return ['data' => $res];
    }



    /**
     * 删除数据
     * @return array
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function actionDel()
    {
        $group = new Api(['scenario' => Api::SCENARIO_DEL]);
        $group->attributes = Yii::$app->request->post();
        $res = $group->del();
        if (is_string($res)) {
            return ['msg' => $res];
        }

        return ['data' => '成功'];
    }

}