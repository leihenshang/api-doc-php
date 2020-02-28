<?php

namespace app\controllers;

use app\behaviors\UserVerify;
use app\models\Api;
use Yii;
use yii\base\InvalidConfigException;

class ApiController extends BaseController
{

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['userVerify'] = [
            'class' => UserVerify::class,
            'actions' => ['*'],  //设置要验证的action,如果留空或者里边放入 * ，则所有的action都要执行验证
            'excludeAction' => [], //要排除的action,在此数组内的action不执行登陆状态验证
        ];
        return $behaviors;
    }

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
            return $this->failed($res);
        }

        return $this->success($res);
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
            return $this->failed($res);
        }

        return $this->success($res);
    }

    /**
     * api列表
     * @return array
     */
    public function actionList()
    {
        $projectId = Yii::$app->request->get('projectId', 0);
        $groupId = Yii::$app->request->get('groupId', 0);
        if (!$projectId) {
            return ['code' => 22, 'msg' => '没有projectId'];
        }

        $res = new Api(['scenario' => Api::SCENARIO_LIST]);
        $res = $res->dataList($projectId, Yii::$app->request->get('ps', 10), Yii::$app->request->get('cp', 1), $groupId);
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
            return $this->failed($res);
        }

        return ['data' => '成功'];
    }

    /**
     * 接口详情
     * @return (array|string|int)[]|(app\models\Api|null)[] 
     * @throws InvalidConfigException 
     */
    public function actionDetail()
    {
        $api = new Api(['scenario' => Api::SCENARIO_DETAIL]);
        $api->attributes = Yii::$app->request->get();
        $res = $api->detail();
        if (is_string($res)) {
            return $this->failed($res);
        }

        return ['data' => $res];
    }
}
