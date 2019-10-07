<?php


namespace app\models;

/**
 * 项目模型
 * Class Project
 * @package app\models
 * @property integer $id id
 * @property integer $group_id 组id
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

    public function rules()
    {
        return [
            [['id','data'],'required'],
            [['id','group_id','project_id','is_deleted'],'number'],
            ['description','string','length' => [1,500]]
        ];
    }

    public function scenarios()
    {
        $scenarios =  parent::scenarios();
        $scenarios[self::SCENARIO_CREATE] = ['data','group_id','description'];
        $scenarios[self::SCENARIO_DEL] = ['id'];
        $scenarios[self::SCENARIO_UPDATE] = ['data','id'];
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
        if(!$this->validate()){
            return current($this->getFirstErrors());
        }

        //验证json数据格式
        json_decode($this->data);
        if(json_last_error()){
            return json_last_error_msg();
        }

        if(!$this->save()){
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
        if(!$this->validate()){
            return current($this->getFirstErrors());
        }

        $res = self::findOne($this->id);
        if(!$res){
            return '没有找到数据';
        }

        $res->attributes = $request;
        if(!$res->save()){
            return current($this->getFirstErrors());
        }

        return true;
    }

    /**
     * 删除数据
     * @return bool|mixed
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function del()
    {
        if(!$this->validate()){
            return current($this->getFirstErrors());
        }

        $res = self::findOne($this->id);
        if(!$res->delete()){
            return current($res->getFirstErrors());
        }

        return true;
    }

    /**
     * 数据列表
     * @return Api[]|array
     */
    public function dataList()
    {
        $res = self::findAll(['is_deleted' => 0]);
        //解析json数据
       $res = array_map(function($a){
           $a->data = json_decode($a->data);
           return $a;
       },$res);
       return $res;
    }

    /**
     * api详情
     * @return Api|null
     */
    public function detail()
    {
        $res =  self::findOne($this->id);
        if($res) $res->data = json_decode($res->data);

        return $res;
    }
}