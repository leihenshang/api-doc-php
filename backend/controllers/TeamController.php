<?php

namespace app\controllers;

use app\behaviors\UserVerify;
use app\models\Api;
use app\models\Team;
use Throwable;
use Yii;
use yii\db\StaleObjectException;

class TeamController extends BaseController
{

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['userVerify'] = [
            'class' => UserVerify::class,
//            'actions' => ['*'],  //设置要验证的action,如果留空或者里边放入 * ，则所有的action都要执行验证
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
        $team = new Team(['scenario' => Team::SCENARIO_CREATE]);
        $team->attributes = Yii::$app->request->post();
        $res = $team->createData();
        if (is_string($res)) {
            return ['msg' => $res];
        }

        return $this->success();
    }

    /**
     * 更新数据
     * @return array
     */
    public function actionUpdate()
    {
        $team = new Team(['scenario' => Team::SCENARIO_UPDATE]);
        $request = Yii::$app->request->post();
        $team -> attributes = $request;
        if(!$team->validate()){
            return $this->failed(current($team->getFirstErrors()));
        }
        $res = $team->updateData($request);
        if (is_string($res)) {
            return ['msg' => $res];
        }

        return ['data' => '成功'];
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
     * @throws Throwable
     * @throws StaleObjectException
     */
    public function actionDel()
    {
        $team = new Team(['scenario' => Team::SCENARIO_DELETE]);
        $team->attributes = Yii::$app->request->post();
        if (!$team->validate()) {
            return $this->failed(current($team->getFirstErrors()));
        }

        $res = $team->del();
        if (is_string($res)) {
            return $this->failed($res);
        }

        return $this->success();
    }

    /**
     * 详情
     * @return array
     */
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