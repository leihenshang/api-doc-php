<?php

namespace app\controllers;

use app\behaviors\UserVerify;
use app\models\BaseModel;
use app\models\Project;
use app\models\UserInfo;
use app\models\UserProject;
use Throwable;
use Yii;
use yii\db\StaleObjectException;

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
            return $this->failed($res);
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

        //如果用户不是管理员
        //1.获取用户可以使用的项目id
        //2.然后查询项目表返回项目
        if ($this->userInfo->type !== UserInfo::USER_TYPE['admin'][0]) {
            $res = UserProject::find()->alias('a')
                ->select('b.*')
                ->innerJoin('project b', 'a.project_id = b.id')
                ->where([
                    'b.is_deleted' => UserInfo::IS_DELETED['no'],
                    'a.is_deleted' => UserInfo::IS_DELETED['no'],
                    'a.user_id' => $this->userInfo->id
                ]);
            $resCount = $res->count();
            return $this->success(['count' => $resCount, 'res' => $res->asArray()->all()]);
        }


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
     * @throws Throwable
     * @throws StaleObjectException
     */
    public function actionDel()
    {
        if ($this->userInfo->type !== UserInfo::USER_TYPE['admin'][0]) {
            return $this->failed('非管理员不能执行删除');
        }

        $project = new Project(['scenario' => Project::SCENARIO_DEL]);
        $project->attributes = Yii::$app->request->post();
        $res = $project->del();
        if (is_string($res)) {
            return $this->failed($res);
        }

        return ['data' => '成功'];
    }

    /**
     * 获取项目用户列表
     * @return array
     */
    public function actionProjectUser()
    {
        $id = Yii::$app->request->get('id', null);
        if (!$id) {
            return $this->failed('获取id参数失败');
        }

        $res = UserProject::find()->alias('a')
            ->leftJoin('user_info b', 'a.user_id = b.id')
            ->select('b.*,a.id relation_id,a.permission,a.is_leader')
            ->where([
                'a.project_id' => $id,
                'a.is_deleted' => UserProject::IS_DELETED['no']
            ])
            //不显示根管理员
            ->andWhere(['<>', 'b.type', UserInfo::USER_TYPE['admin'][0]])
            ->asArray()->all();

        $res = array_map(function ($a) {
            if (isset($a['pwd'])) {
                $a['pwd'] = null;
            }
            return $a;
        }, $res);

        return $this->success($res);

    }

    /**
     * 为项目添加用户
     * @return array
     */
    public function actionAddUser()
    {
        $params = Yii::$app->request->post();
        $userProject = new UserProject(['scenario' => UserProject::SCENARIO_CREATE]);
        $userProject->attributes = $params;
        if (!$userProject->validate()) {
            return $this->failed(current($userProject->getFirstErrors()));
        }

        //检查重复添加
        $res = UserProject::find()->where([
            'user_id' => $userProject->user_id,
            'project_id' => $userProject->project_id,
            'is_deleted' => UserProject::IS_DELETED['no']
        ])->one();

        if ($res) {
            return $this->failed('请勿重复添加');
        }

        if (!$userProject->save(false)) {
            return $this->failed(current($userProject->getFirstErrors()));
        }

        return $this->success();
    }

    /**
     * 删除项目用户
     * @return array
     */
    public function actionDelUser()
    {
        $params = Yii::$app->request->post('ids', null);
        $ids = explode(',', $params);
        if (!$ids) {
            return $this->failed('失败');
        }

        $res = UserProject::updateAll(['is_deleted' => UserProject::IS_DELETED['yes']], ['Id' => $ids]);
        if ($res) {
            return $this->success();
        }

        return $this->failed('更新失败');
    }

    /**
     * 设置团队leader
     * @return array
     */
    public function actionSetLeader()
    {
        $userId = Yii::$app->request->post('userId', null);
        $projectId = Yii::$app->request->post('projectId', null);
        //判断只有管理员可知设置团队leader
        if ($this->userInfo->type != UserInfo::USER_TYPE['admin'][0]) {
            return $this->failed('非管理员禁止操作');
        }

        if (!$userId || !$projectId) {
            return $this->failed('必须传入userId以及projectId');
        }

        $userProject = UserProject::findOne(['user_id' => $userId, 'project_id' => $projectId]);
        if (!$userProject) {
            return $this->failed('没有找到要设置的用户');
        }

        $userProject->is_leader = UserProject::IS_LEADER['yes'];
        if (!$userProject->save()) {
            return $this->failed('设置团队leader失败');
        }

        return $this->success('成功');
    }

    /**
     * 退出项目
     * @return array
     */
    public function actionQuitProject()
    {
        $userId = Yii::$app->request->post('userId', null);
        $projectId = Yii::$app->request->post('projectId', null);

        if (!$userId || !$projectId) {
            return $this->failed('必须传入userId以及projectId');
        }

        //检查操作权限
        $checkRes = Project::checkUserProjectOperationPermission($this->userInfo, $projectId);
        if (!$checkRes) {
            return $this->failed('非管理员以及团队leader禁止操作');
        }

        $userProject = UserProject::find()->where([
            'user_id' => $userId,
            'is_deleted' => UserProject::IS_DELETED['no'],
            'project_id' => $projectId
        ])->one();
        if (!$userProject) {
            return $this->failed('没有找到要设置的用户');
        }

        $userProject->is_deleted = UserProject::IS_DELETED['yes'];
        if (!$userProject->save()) {
            return $this->failed('退出项目失败');
        }

        return $this->success([]);
    }


    /**
     * 设置权限
     * @return array
     */
    public function actionSetPermission()
    {
        $userId = Yii::$app->request->post('userId', null);
        $projectId = Yii::$app->request->post('projectId', null);
        $permission = Yii::$app->request->post('permission', null);

        if (!$userId || !$projectId || !$permission) {
            return $this->failed('必须传入userId以及projectId,permission');
        }

        $permissionRange = array_merge(array_column(UserProject::PERMISSION, 0), [6]);
        if (!in_array($permission, $permissionRange)) {
            return $this->failed('设置权限值不正确');
        }

        //检查操作权限
        $checkRes = Project::checkUserProjectOperationPermission($this->userInfo, $projectId);
        if (!$checkRes) {
            return $this->failed('非管理员以及团队leader禁止操作');
        }

        $userProject = UserProject::find()->where([
            'user_id' => $userId,
            'is_deleted' => UserProject::IS_DELETED['no'],
            'project_id' => $projectId
        ])->one();
        if (!$userProject) {
            return $this->failed('没有找到要设置的用户');
        }

        $userProject->permission = $permission;
        if (!$userProject->save()) {
            return $this->failed('设置权限失败');
        }

        return $this->success([]);
    }

    /**
     * 检查可操作权限
     * @return array
     */
    public function actionCheckOperationPermission()
    {
        $projectId = Yii::$app->request->post('projectId', null);

        if (!$projectId) {
            return $this->failed('必须传入projectId');
        }

        //检查操作权限
        $checkRes = Project::checkUserProjectOperationPermission($this->userInfo, $projectId);
        if (!$checkRes) {
            return $this->failed('非管理员以及团队leader禁止操作');
        }

        return $this->success($checkRes);
    }

    /**
     * 获取用户对项目的操作权限
     * @return array
     */
    public function actionGetProjectOperationPermission()
    {
        $projectId = Yii::$app->request->get('projectId', null);

        if (!$projectId) {
            return $this->failed('必须传入projectId');
        }

        if ($this->userInfo->type == UserInfo::USER_TYPE['admin'][0]) {
            return $this->success(4);
            return $this->success(UserProject::PERMISSION['read'][0] + UserProject::PERMISSION['write'][0]);
        }

        //检查操作权限
        $permission = UserProject::find()
            ->where(['userId' => $this->userInfo->id])
            ->where(['project_id' => $projectId])
            ->where(['is_deleted' => BaseModel::IS_DELETED['no']])->one();
        if (!$permission) {
            return $this->failed('获取用户-项目权限数据失败，不允许操作');
        }

        return $this->success($permission->permission);
    }

}