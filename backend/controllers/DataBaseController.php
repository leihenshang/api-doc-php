<?php

namespace app\controllers;

use app\behaviors\UserVerify;
use app\models\Database;
use Yii;

class DataBaseController extends BaseController
{

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['userVerify'] = [
            'class' => UserVerify::class,
            'actions' => ['*'],  //设置要验证的action,如果留空或者里边放入 * ，则所有的action都要执行验证
            'excludeAction' => [], //要排除的action,在此数组内的action不执行登陆状态验证,
            'projectPermission' => ['update', 'del', 'create']
        ];
        return $behaviors;
    }


    public function verbs()
    {
        $verbs = parent::verbs();
        $verbs['create'] = ['post'];
        $verbs['update'] = ['post'];
        $verbs['del'] = ['post'];
        $verbs['list'] = ['get'];
        $verbs['detail'] = ['get'];
        return $verbs;
    }

    /**
     * 创建数据
     * @return array
     */
    public function actionCreate()
    {
        $dataBase = new Database(['scenario' => Database::SCENARIO_CREATE]);
        $dataBase->attributes = Yii::$app->request->post();
        $res = $dataBase->createData();
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
        $dataBase = new Database(['scenario' => Database::SCENARIO_UPDATE]);
        $request = Yii::$app->request->post();
        $res = $dataBase->updateData($request);
        if (is_string($res)) {
            return $this->failed($res);
        }

        return $this->success($res);
    }

    /**
     * dataBase列表
     * @return array
     */
    public function actionList()
    {
        $projectId = Yii::$app->request->get('projectId', 0);
        $isDeleted = Yii::$app->request->get('isDeleted', 0);
        $keyword = Yii::$app->request->get('keyword', 0);
        if (!$projectId) {
            return ['code' => 22, 'msg' => '没有projectId'];
        }

        if (!is_numeric($isDeleted)) {
            return $this->failed('is_deleted参数错误');
        }

        $res = new Database(['scenario' => Database::SCENARIO_LIST]);
        $res = $res->dataList($projectId, Yii::$app->request->get('ps', 10), Yii::$app->request->get('cp', 1), $isDeleted, $keyword);
        return $this->success($res);
    }


    /**
     * 删除数据
     * @return array
     */
    public function actionDelete()
    {
        $dataBase = new Database(['scenario' => Database::SCENARIO_DELETE]);
        $dataBase->attributes = Yii::$app->request->post();
        $res = $dataBase->del();
        if (is_string($res)) {
            return $this->failed($res);
        }

        return $this->success();
    }


    /**返回指定数据库数据表列表
     * @return array
     */
    public function actionTables()
    {
        $id = Yii::$app->request->get('id', 0);
        if (!$id) {
            return ['code' => 22, 'msg' => '参数不全'];
        }

        $res = Database::getTables($id);

        if (is_string($res)) {
            return $this->failed($res);
        }

        return $this->success($res);

    }

    /**
     * 返回表结构
     * @return array
     * @throws \yii\base\NotSupportedException
     */
    public function actionSchemas()
    {
        $id = Yii::$app->request->get('id', 0);
        if (!$id) {
            return ['code' => 22, 'msg' => '参数不全'];
        }

        $res = Database::getSchemas($id);
        return $this->success($res);
    }


}
