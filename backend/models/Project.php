<?php


namespace app\models;

use Throwable;
use yii\db\StaleObjectException;

/**
 * 项目模型
 * Class Project
 * @package app\models
 * @property string $title 标题
 * @property integer $id id
 */
class Project extends BaseModel
{
    const SCENARIO_CREATE = 'create';
    const SCENARIO_DEL = 'del';
    const SCENARIO_UPDATE = 'update';
    const SCENARIO_LIST = 'list';

    const TYPE = [
        'web' => ['tag' => 1, 'desc' => 'web'],
        'pc' => ['tag' => 2, 'desc' => 'pc'],
    ];

    public function rules()
    {
        return [
            [['ps', 'cp'], 'integer'],
            ['id', 'required'],
            ['id', 'number'],
            [['title', 'version', 'type'], 'required'],
            ['title', 'unique'],
            ['title', 'string', 'length' => [1, 100]],
            ['description', 'string', 'length' => [1, 100]],
        ];
    }

    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios[self::SCENARIO_CREATE] = ['title', 'description', 'version', 'type'];
        $scenarios[self::SCENARIO_DEL] = ['id'];
        $scenarios[self::SCENARIO_LIST] = ['ps', 'cp'];
        $scenarios[self::SCENARIO_UPDATE] = ['title', 'description', 'version', 'type'];
        return $scenarios;
    }

    public static function tableName()
    {
        return 'project';
    }

    /**
     * 创建数据
     * @return bool|mixed
     */
    public function createData()
    {
        if (!$this->validate()) {
            return current($this->getFirstErrors());
        }

        if (!$this->save()) {
            return current($this->getFirstErrors());
        }

        //记录操作日志
        OperationLog::createLog($this->id, UserInfo::$staticUserInfo->id, $this->id, OperationLog::ACTION['create'][0], '项目:' . $this->title, OperationLog::OBJECT_TYPE['project'][0]);


        return true;
    }

    /**
     * 编辑数据
     * @param array $request
     * @return bool|mixed
     */
    public function updateData($request)
    {
        $this->attributes = $request;
        if (!$this->validate()) {
            return current($this->getFirstErrors());
        }

        $res = self::findOne($this->id);
        if (!$res) {
            return '没有找到数据';
        }
        $this->scenario = self::SCENARIO_UPDATE;
        $res->attributes = $request;
        if (!$res->save()) {
            return current($this->getFirstErrors());
        }

        //记录操作日志
        OperationLog::createLog($this->id, UserInfo::$staticUserInfo->id, $this->id, OperationLog::ACTION['update'][0], '项目:' . $request['title'], OperationLog::OBJECT_TYPE['project'][0]);

        return true;
    }

    /**
     * 删除数据
     * @return bool|mixed
     * @throws Throwable
     * @throws StaleObjectException
     */
    public function del()
    {
        if (!$this->validate()) {
            return current($this->getFirstErrors());
        }

        $res = self::findOne($this->id);
        if (!$res->delete()) {
            return current($res->getFirstErrors());
        }

        //记录操作日志
        OperationLog::createLog($this->id, UserInfo::$staticUserInfo->id, $this->id, OperationLog::ACTION['delete'][0], '项目:' . $res->title, OperationLog::OBJECT_TYPE['project'][0]);
        return true;
    }

    /**
     * 检查用户项目操作权限
     * @param UserInfo $user
     * @param $projectId
     * @return bool
     * @throws
     */
    public static function checkUserProjectOperationPermission($user, $projectId)
    {
        //判断是否是团队leader
        $leaderInfo = UserProject::find()->where([
            'user_id' => $user->id,
            'is_leader' => UserProject::IS_LEADER['no'],
            'is_deleted' => UserProject::IS_DELETED['no'],
            'project_id' => $projectId
        ])->one();

        //如果不是根管理员，则要判断是否是团队Leader
        if (!$user->type != UserInfo::USER_TYPE['admin'][0]) {
            if (!$leaderInfo) {
                return false;
            }
        }

        return true;
    }

}