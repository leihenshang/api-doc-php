<?php

namespace app\controllers;

use app\behaviors\UserVerify;
use app\models\UserInfo;
use Yii;
use yii\base\InvalidConfigException;

class UserController extends BaseController
{

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['userVerify'] = [
            'class' => UserVerify::class,
            'actions' => ['list', 'update-status', 'get-user-info', 'update-nickname', 'update-pwd'],  //设置要验证的action,如果留空或者里边放入 * ，则所有的action都要执行验证
            'excludeAction' => [], //要排除的action,在此数组内的action不执行登陆状态验证
            'projectPermission' => ['update-status','update-nickname','date-pwd']
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

        $res = UserInfo::find()->alias('a')->select('a.*');
        if (UserInfo::$staticUserInfo && UserInfo::$staticUserInfo->type == UserInfo::USER_TYPE['admin'][0]) {
            $whereArr = ['a.is_deleted' => UserInfo::IS_DELETED['no'], 'a.type' => UserInfo::USER_TYPE['normal'][0]];
        } else {
            $whereArr = ['a.type' => UserInfo::USER_TYPE['normal'][0], 'a.state' => UserInfo::USER_STATE['normal'][0], 'a.is_deleted' => UserInfo::IS_DELETED['no']];
        }

        $res->where($whereArr);
        if ($user->keyword) {
            $res->andWhere(['or',
                ['like', 'a.nick_name', $user->keyword . '%', false],
                ['like', 'a.email', $user->keyword . '%', false],
                ['like', 'a.name', $user->keyword . '%', false]
            ]);
        }

        $recordCount = $res->count();

        $res = $res->limit($user->ps)->offset(($user->cp - 1) * $user->ps)->all();
        return $this->success(['count' => $recordCount, 'list' => $res]);
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
     * @throws
     */
    public function actionCheckRepeat($keyword = null)
    {
        if (!$keyword) {
            return $this->failed('检查的值不能为空');
        }
        $res = UserInfo::checkReplayNickname($keyword);
        if ($res) {
            return $this->success(['name' => $res->name, 'email' => $res->email, 'nick_name' => $res->nick_name]);
        }
        return $this->success([]);
    }

    /**
     * 更新用户状态字段
     * @return array
     */
    public function actionUpdateStatus()
    {
        $userId = Yii::$app->request->post('userId', null);
        $sate = Yii::$app->request->post('state', null);
        $is_deleted = Yii::$app->request->post('is_deleted', null);
        if (!$userId || !is_numeric($userId)) {
            return $this->failed('userId不能为空或userId错误');
        }

        //不能更改自己
        if ($this->userInfo->id == $userId) {
            return $this->failed('不能对自己进行操作');
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
            $arr['state'] = $sate;
        }

        $res = UserInfo::updateAll($arr, ['id' => $userId]);
        if ($res) {
            return $this->success([], '更新完成');
        }

        return $this->failed('更新失败');
    }

    /**
     * 更新用户昵称
     * @return mixed
     * @throws InvalidConfigException
     */
    public function actionUpdateNickname()
    {
        $nickname = Yii::$app->request->post('nickname', null);
        $userId = Yii::$app->request->post('userId', null);
        if (!$nickname) {
            return $this->failed('昵称不能为空');
        }

        //检查昵称是否重复
        if (UserInfo::checkReplayNickname($nickname)) {
            return $this->failed('昵称重复');
        }
        if (is_numeric($userId)) {
            $res = UserInfo::updateAll(['nick_name' => $nickname], ['id' => $userId]);
        } else {
            $res = UserInfo::updateAll(['nick_name' => $nickname], ['id' => $this->userInfo->id]);
        }
        if ($res) {
            return $this->success([], '更新完成');
        }

        return $this->failed('更新失败');
    }

    /**
     * 更改用户密码
     * @return array
     * @throws
     */
    public function actionUpdatePwd()
    {
        $pwdSecond = Yii::$app->request->post('rePwd', '');
        if (!$pwdSecond) {
            return $this->failed('第二次新密码没有获取到');
        }

        $user = new UserInfo(['scenario' => UserInfo::SCENARIO_UPDATE_PWD]);
        $user->pwd = Yii::$app->request->post('oldPwd', '');
        $user->re_pwd = Yii::$app->request->post('newPwd', '');
        if (!$user->validate()) {
            return $this->failed(current($user->getFirstErrors()));
        }

        if ($user->re_pwd !== $pwdSecond) {
            return $this->failed('两次新密码输入不一致');
        }

        if ($user->pwd === $pwdSecond) {
            return $this->failed('密码没有更改');
        }

        //查找用户信息
        $res = UserInfo::findOne(['id' => $this->userInfo->id, 'pwd' => $user->pwd, 'is_deleted' => UserInfo::IS_DELETED['no']]);
        if (!$res) {
            return $this->failed('获取用户信息失败,可能是密码错误');
        }

        $res->pwd = $user->re_pwd;
        if (!$res->save()) {
            return $this->failed(current($user->getFirstErrors()));
        }

        return $this->success();
    }

    /**
     * 获取用户信息
     * @return (array|string|int)[]
     * @throws InvalidConfigException
     */
    public function actionGetUserInfo()
    {
        $userId = $this->userInfo->id;
        $res = UserInfo::findOne($userId);
        if ($res) {
            $res = $res->toArray();
            $res['state_text'] = 0;
            $res['type_text'] = 0;
            foreach (UserInfo::USER_TYPE as $value) {
                if ($res['type'] == $value[0]) {
                    $res['type_text'] = $value[1];
                }
            }

            foreach (UserInfo::USER_STATE as $value) {
                if ($res['state'] == $value[0]) {
                    $res['state_text'] = $value[1];
                }
            }
        }
        return $this->success($res);
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
