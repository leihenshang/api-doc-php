<?php


namespace app\models;

use Throwable;
use yii\db\StaleObjectException;

/**
 * 项目模型
 * Class Project
 * @package app\models
 * @property integer $id id
 * @property integer $group_id 组id
 * @property integer $project_id 项目id
 * @property string $data 数据
 * @property string description 备注
 * @property integer is_deleted id
 * @property string create_time id
 *
 */
class Api extends BaseModel
{
    const SCENARIO_CREATE = 'create';
    const SCENARIO_DEL = 'del';
    const SCENARIO_UPDATE = 'update';
    const SCENARIO_LIST = 'list';
    const SCENARIO_DETAIL = 'detail';

    public static $defaultData = [
        'group' => '',//分组
        'protocol' => 'http',//协议
        'description' => '',//说明和备注
        'requestMethod' => 'GET', //http请求方法
        'returnDataType' => 1,  //返回值类型
        'url' => '/test/test/test/st', //http请求URL
        'name' => '', //接口名称
        'objectName' => '',//根对象名
        'functionName' => '',//程序内部方法名
        'developmentLanguage' => '',//接口开发语言
        'requestHeader' => [], //请求头
        'requestParams' => [], //请求参数
        'returnData' => [], //返回参数
        'returnDataSuccess' => '', //返回数据成功
        'returnDataFailed' => ''//返回数据失败
    ];

    public function rules()
    {
        return [
            [['id', 'data'], 'required'],
            ['data', function ($attribute, $params) {
                //格式验证
               json_decode($this->data,true);
                if (json_last_error()) {
                    $this->addError($attribute, json_last_error_msg());
                }
            }],
            [['id', 'group_id', 'project_id', 'is_deleted'], 'number'],
            [['group_id', 'project_id'], 'required', 'on' => self::SCENARIO_CREATE],
            ['description', 'string', 'length' => [1, 500]]
        ];
    }

    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios[self::SCENARIO_CREATE] = ['data', 'project_id', 'group_id', 'description'];
        $scenarios[self::SCENARIO_DEL] = ['id'];
        $scenarios[self::SCENARIO_UPDATE] = ['data', 'id'];
        $scenarios[self::SCENARIO_LIST] = [];
        $scenarios[self::SCENARIO_DETAIL] = ['id'];
        return $scenarios;
    }

    public static function tableName()
    {
        return 'api';
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

        //检查groupId和projectId的存在
        if(!Group::findOne($this->group_id)){
            return '组不存在';
        }

        if(!Project::findOne($this->project_id)){
            return '项目不存在';
        }

        if (!$this->save()) {
            return current($this->getFirstErrors());
        }

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

        //检查groupId和projectId的存在
        if(!Group::findOne($this->group_id)){
            return '组不存在';
        }

        if(!Project::findOne($this->project_id)){
            return '项目不存在';
        }

        $res->attributes = $request;
        if (!$res->save()) {
            return current($this->getFirstErrors());
        }

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

        return true;
    }

    /**
     * 数据列表
     * @param int $projectId
     * @param int $ps
     * @param int $cp
     * @param int $groupId
     * @return Api[]|array
     */
    public function dataList($projectId, $ps, $cp, $groupId = 0)
    {
        $this->ps = $ps;
        $this->cp = $cp;

        $res = self::find()
            ->where(['is_deleted' => self::IS_DELETED['no']])
            ->andWhere(['project_id' => $projectId])
            ->limit($this->ps)->offset($this->offset);

        if ($groupId) {
            $res->andWhere(['group_id' => $groupId]);
        }

        $resCount = $res->count();
        $res = $res->all();

        //解析json数据
        if ($resCount) {
            $res = array_map(function ($a) {
                $a->data = json_decode($a->data);
                return $a;
            }, $res);
        }

        return ['resCount' => $resCount, 'resItem' => $res];
    }

    /**
     * api详情
     * @return Api|null
     */
    public function detail()
    {
        $res = self::findOne($this->id);
        if ($res) $res->data = json_decode($res->data);

        return $res;
    }
}