<?php

namespace app\controllers;

use app\models\Api;
use Yii;

class ApiController extends BaseController
{
    /**
     * 创建数据
     * @return array
     */
    public function actionCreate()
    {
        $api = new Api(['scenario' => Api::SCENARIO_CREATE]);
        $api->attributes = Yii::$app->request->post();
        $res = $api->createData();
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
        $api = new Api(['scenario' => Api::SCENARIO_UPDATE]);
       $request = Yii::$app->request->post();
        $res = $api->updateData($request);
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
        $res = new Api(['scenario' => Api::SCENARIO_LIST]);
        $res = $res->dataList();
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
        $api = new Api(['scenario' => Api::SCENARIO_DEL]);
        $api->attributes = Yii::$app->request->post();
        $res = $api->del();
        if (is_string($res)) {
            return ['msg' => $res];
        }

        return ['data' => '成功'];
    }

    public function actionDetail()
    {
        $api = new Api(['scenario' => Api::SCENARIO_DETAIL]);
        $api->attributes = Yii::$app->request->get();
        $res = $api->detail();
        if (is_string($res)) {
            return ['msg' => $res];
        }

        return ['data' => $res];
    }

}