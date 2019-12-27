<?php

namespace app\controllers;

use app\behaviors\UserVerify;
use app\models\Project;
use app\models\User;
use app\models\UserProject;
use Yii;

class ProjectController extends BaseController
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
        $res = Project::find()->where(['id' => '1'])->one();
        return ['data' => $res];
    }

    /**
     * 创建数据
     * @return array
     */
    public function actionCreate()
    {
        $project = new Project(['scenario' => Project::SCENARIO_CREATE]);
        $project->attributes = Yii::$app->request->post();
        $res = $project->createData();
        if (is_string($res)) {
            return ['code' => 22, 'msg' => $res];
        }

        return ['data' => '成功'];
    }

    /**
     * 更新数据
     * @return array
     */
    public function actionUpdate()
    {
        $project = new Project(['scenario' => Project::SCENARIO_DEL]);
        $request = Yii::$app->request->post();
        $res = $project->updateData($request);
        if (is_string($res)) {
            return ['msg' => $res];
        }

        return ['data' => '成功'];
    }

    /**
     * 项目列表
     * @return array
     */
    public function actionList()
    {
        $project = new Project(['scenario' => Project::SCENARIO_LIST]);
        $project->attributes = Yii::$app->request->get();
        $res = Project::find()->where(['is_deleted' => 0])->limit($project->ps)->offset($project->offset)->orderBy('create_time desc');
        $resCount = $res->count();
        /*        $res = array_map(function ($a) {
                    switch ($a['type']) {
                        case Project::TYPE['web']['tag']:
                            $a['typeDesc'] = Project::TYPE['web']['desc'];
                            break;
                        case Project::TYPE['pc']['tag']:
                            $a['typeDesc'] = Project::TYPE['pc']['desc'];
                            break;
                            default:
                            $a['typeDesc'] = '默认';
                            break;
                    }
                    return $a;
                }, $res);*/

        return ['data' => ['count' => $resCount, 'res' => $res->asArray()->all()]];
    }

    /**
     * 项目详情
     * @return array
     */
    public function actionDetail()
    {
        $id = Yii::$app->request->get('id', null);
        $res = Project::findOne($id);
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
        $project = new Project(['scenario' => Project::SCENARIO_DEL]);
        $project->attributes = Yii::$app->request->post();
        $res = $project->del();
        if (is_string($res)) {
            return ['msg' => $res];
        }

        return ['data' => '成功'];
    }

    /**
     * 为项目添加用户
     * @return array
     */
    public function actionAddUser()
    {
        $params = Yii::$app->request->post();
        $userProject  = new UserProject(['scenario' => UserProject::SCENARIO_CREATE]);
        $userProject->attributes = $params;
        if(!$userProject->validate()){
            return $this->failed(current($userProject->getFirstErrors()));
        }

        if(!$userProject->save(false)){
            return $this->failed(current($userProject->getFirstErrors()));
        }

        return $this->success();
    }

}