<?php

namespace app\controllers;

use app\behaviors\UserVerify;
use app\models\Api;
use app\models\Bug;
use Yii;

class BugController extends BaseController
{

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['userVerify'] = [
            'class' => UserVerify::class,
            'actions' => ['*'],  //设置要验证的action,如果留空或者里边放入 * ，则所有的action都要执行验证
            'excludeAction' => [], //要排除的action,在此数组内的action不执行登陆状态验证,
            'projectPermission' => ['update', 'del', 'create', 'restore']
        ];
        return $behaviors;
    }

    /**
     * 创建数据
     * @return array
     */
    public function actionCreate()
    {
        $bug = new Bug();
        $bug->attributes = Yii::$app->request->post();
        $res = $bug->save();
        if (!$res) {
            return $this->failed(current($bug->getFirstErrors()));
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
        $isDeleted = Yii::$app->request->get('isDeleted', 0);
        $keyword = Yii::$app->request->get('keyword', 0);
        if (!$projectId) {
            return ['code' => 22, 'msg' => '没有projectId'];
        }

        if (!is_numeric($isDeleted)) {
            return $this->failed('is_deleted参数错误');
        }

        $res = new Api(['scenario' => Api::SCENARIO_LIST]);
        $res = $res->dataList($projectId, Yii::$app->request->get('ps', 10), Yii::$app->request->get('cp', 1), $groupId, $isDeleted, $keyword);
        return $this->success($res);
    }


    /**
     * 删除
     * @return array
     */
    public function actionDelete()
    {
        $api = new Api(['scenario' => Api::SCENARIO_DEL]);
        $api->attributes = Yii::$app->request->post();
        $res = $api->del();
        if (is_string($res)) {
            return $this->failed($res);
        }

        return $this->success(null);
    }

    /**
     * 接口详情
     * @return array
     */
    public function actionDetail()
    {
        $api = new Api(['scenario' => Api::SCENARIO_DETAIL]);
        $api->attributes = Yii::$app->request->get();
        $res = $api->detail();
        if (is_string($res)) {
            return $this->failed($res);
        }

        return $this->success($res);
    }


}
