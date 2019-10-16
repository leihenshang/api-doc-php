<?php

namespace app\controllers;

use app\models\Project;
use Yii;

class ProjectController extends BaseController
{

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
        $project = new Project(['scenario' => Project::SCENARIO_UPDATE]);
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
        $res = $res->asArray()->all();
        $res = array_map(function ($a) {
            switch ($a['type']) {
                case Project::TYPE['web']['tag']:
                    $a['type'] = Project::TYPE['web']['desc'];
                    break;
                case Project::TYPE['pc']['tag']:
                    $a['type'] = Project::TYPE['pc']['desc'];
                    break;
                    default:
                    $a['type'] = '默认';
                    break;
            }
            return $a;
        }, $res);

        return ['data' => $res];
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

}