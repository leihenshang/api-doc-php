<?php

namespace app\controllers;

use app\behaviors\UserVerify;
use app\models\Group;
use Yii;

class GroupController extends BaseController
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

    public function actionTest()
    {
        $res = Group::find()->where(['id' => '1'])->one();
        return ['data' => $res];
    }

    /**
     * 创建数据
     * @return array
     */
    public function actionCreate()
    {
        $group = new Group(['scenario' => Group::SCENARIO_CREATE]);
        $group->attributes = Yii::$app->request->post();
        $res = $group->createData();
        if (is_string($res)) {
            return ['msg' => $res,'code' => 22];
        }

        return ['data' => '成功'];
    }

    /**
     * 更新数据
     * @return array
     */
    public function actionUpdate()
    {
        $group = new Group(['scenario' => Group::SCENARIO_UPDATE]);
       $request = Yii::$app->request->post();
        $res = $group->updateData($request);
        if (is_string($res)) {
            return $this->failed($res);
        }

        return ['data' => '成功'];
    }

    /**
     * 分组列表
     * @return array
     */
    public function actionList()
    {
        $projectId = Yii::$app->request->get('projectId',0);
        $res = Group::findAll(['is_deleted' => 0,'project_id' => $projectId]);
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
        $group = new Group(['scenario' => Group::SCENARIO_DEL]);
        $group->attributes = Yii::$app->request->post();
        $res = $group->del();
        if (is_string($res)) {
            return $this->failed($res);
        }

        return ['data' => '成功'];
    }

}