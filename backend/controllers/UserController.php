<?php

namespace app\controllers;

use app\behaviors\UserVerify;
use app\models\UserInfo;
use Yii;
use yii\db\Query;

class UserController extends BaseController
{

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['userVerify'] = [
            'class' => UserVerify::class,
            'actions' => ['list'],  //设置要验证的action,如果留空或者里边放入 * ，则所有的action都要执行验证
            'excludeAction' => [], //要排除的action,在此数组内的action不执行登陆状态验证
        ];
        return $behaviors;
    }

    /**
     * 用户登陆
     *
     * @return array
     */
    public function actionLogin()
    {
        $params = Yii::$app->request->post();
        $user = new UserInfo(['scenario' => UserInfo::SCENARIO_LOGIN]);
        $user->attributes = $params;
        if (!$user->validate()) {
            return $this->failed(current($user->getFirstErrors()));
        }

        $userInfo = $user->login($user->name, $user->pwd);
        if (is_string($userInfo)) {
            return $this->failed($userInfo);
        }

        return $this->success($userInfo);
    }

    /**
     * 获取用户列表
     * @return array
     */
    public function actionList()
    {
        $params = Yii::$app->request->get();
        $user = new UserInfo(['scenario' => UserInfo::SCENARIO_QUERY]);
        $user->attributes = $params;
        if (!$user->validate()) {
            return $this->failed();
        }

        $projectId = $params['project_id'] ?? null;
        $res = UserInfo::find()->alias('a')->select('a.*');
        if (UserInfo::$staticUserInfo && UserInfo::$staticUserInfo->type == UserInfo::USER_TYPE['admin']) {
            $whereArr = ['a.is_deleted' => UserInfo::IS_DELETED['no']];
        } else {
            $whereArr = ['a.type' => UserInfo::USER_TYPE['normal'], 'a.state' => UserInfo::USER_STATE['normal'], 'a.is_deleted' => UserInfo::IS_DELETED['no']];
        }

        $res->where($whereArr);
        if ($user->keyword) {
            $res->andWhere(['or', ['like', 'a.nick_name', $user->keyword . '%', false], ['a.email' => $user->keyword], ['a.mobile_number' => $user->keyword]]);
        }

        //传入了项目id
        if ($projectId) {
            $query = (new Query())->select('user_id')
                ->where([
                    'and',
                    ['b.is_deleted' => UserInfo::IS_DELETED['no']],
                    ['b.project_id' => $projectId]
                ])->from('user_project b');

            $res->andWhere(['and',
                ['not in', 'a.id', $query]
            ]);
        }

        $res = $res->all();
        return $this->success($res);
    }

    /**
     * 用户注册
     *
     * @return array
     */
    public function actionReg()
    {
        /**
         * 1.昵称
         * 2.密码
         * 3.邮箱
         * 4.验证码
         */
        $params = Yii::$app->request->post();
        $user = new UserInfo(['scenario' => UserInfo::SCENARIO_REGISTER]);
        $user->attributes = $params;
        if (!$user->validate()) {
            return $this->failed(current($user->getFirstErrors()));
        }

        $userInfo = $user->reg();
        if (is_string($userInfo)) {
            return $this->failed($userInfo);
        }

        return $this->success($userInfo);
    }

    /**
     * 检查昵称是否重复
     * @param $keyword
     * @return array
     */
    public function actionCheckRepeat($keyword = null)
    {
        if (!$keyword) {
            return $this->failed('检查的值不能为空');
        }
        $res = UserInfo::findOne(['or', ['name' => $keyword], ['email' => $keyword], ['nick_name' => $keyword]]);
        if ($res) {
            return $this->success(['name' => $res->name, 'email' => $res->email, 'nick_name' => $res->nick_name]);
        }
        return $this->success([]);
    }

    /**
     * 更新用户状态
     * @return array
     */
    public function actionUpdateStatus()
    {
        $userId = Yii::$app->request->get('userId', null);
        $sate = Yii::$app->request->get('state', null);
        $is_deleted = Yii::$app->request->get('is_deleted', null);
        if (!$userId || !is_numeric($userId)) {
            return $this->failed('userId不能为空或userId错误');
        }

        if (!$is_deleted && !$sate) {
            return $this->failed('修改数据不能为空');
        }

        if (!is_numeric($is_deleted) && !is_numeric($sate)) {
            return $this->failed('修改值错误');
        }

        $arr = [];
        if (is_numeric($is_deleted)) {
            $arr['is_deleted'] = $is_deleted;
        }

        if (is_numeric($sate)) {
            $arr['sate'] = $sate;
        }

        $res = UserInfo::updateAll($arr, ['id' => $userId]);
        if($res){
            return $this->success([],'更新完成');
        }

        return $this->failed('更新失败');

    }

    /**
     * 设置http请求方法
     * @return array
     */
    public function verbs()
    {
        $verbs = parent::verbs();
        $verbs['login'] = ['post'];
        $verbs['reg'] = ['post'];
        return $verbs;
    }
}
