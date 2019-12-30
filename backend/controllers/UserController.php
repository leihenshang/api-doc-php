<?php

namespace app\controllers;

use app\models\UserInfo;
use Yii;

class UserController extends BaseController
{
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
        if(!$user->validate()){
            return $this->failed();
        }

        $res = UserInfo::find();
        $whereArr = ['type' => UserInfo::USER_TYPE['normal'],'state' => UserInfo::USER_STATE['normal'],'is_deleted' => UserInfo::IS_DELETED['no']];
        $res->where($whereArr);
        if($user->keyword){
            $res->andWhere(['or',['like','nick_name', $user->keyword.'%',false], ['email' => $user->keyword], ['mobile_number' => $user->keyword]]);
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
     * 设置http请求方法
     * @return array
     */
    public function verbs()
    {
        $verbs = parent::verbs();
        $verbs['login'] = ['post'];
        return $verbs;
    }


}