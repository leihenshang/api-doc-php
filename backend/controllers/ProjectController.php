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
        $project = new Project();
        $project->attributes = Yii::$app->request->post();
        $res = $project->createData();
        if (is_string($res)) {
            return ['msg' => $res];
        }

        return ['data' => '成功'];
    }

    /**
     * 列表
     * @return array
     */
    public function actionList()
    {
        $res = Project::findAll(['is_deleted' => 0]);
        return ['data' => $res ];
    }
}