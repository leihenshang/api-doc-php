<?php

namespace app\models;

/**
 * This is the model class for table "{{%team}}".
 *
 * @property int $id
 * @property string $name 团队名字
 * @property string $description 描述
 * @property string $create_time
 * @property int $is_deleted 0正常1删除
 */
class Team extends BaseModel
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%team}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['id','required','on' => [self::SCENARIO_DELETE,self::SCENARIO_UPDATE]],
            [['name'], 'required','on' => self::SCENARIO_CREATE],
            [['create_time'], 'safe'],
            [['name'], 'string', 'max' => 100],
            [['description'], 'string', 'max' => 200],
            [['name'], 'unique','on' => [self::SCENARIO_CREATE]],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => '团队名字',
            'description' => '描述',
            'create_time' => 'Create Time',
        ];
    }

    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios[self::SCENARIO_CREATE] = ['name', 'description'];
        $scenarios[self::SCENARIO_UPDATE] = ['name', 'description','id'];
        $scenarios[self::SCENARIO_DELETE] = ['id'];
        return $scenarios;
    }

    public function createData()
    {
        $res =  $this->save();
        if(!$res){
            return current($this->getFirstErrors());
        }

        return true;
    }

    /**
     * 删除
     * @return bool|string
     */
    public function del()
    {
       $res =  self::findOne($this->id);
        if(!$res){
            return '没有找到数据';
        }

        $res->is_deleted = self::IS_DELETED['yes'];
        if($res->save(false)){
           return true;
        }

        return '删除失败';
    }

    /**
     * 更新数据
     * @param $request
     * @return bool|string
     */
    public function updateData($request)
    {
        $res =  self::findOne($this->id);
        if(!$res){
            return '没有找到数据';
        }

        $allow = ['description'];
        if(isset($request['name']) && $res->name != $request['name']){
            $allow = ['name','description'];
        }

        $res->attributes = $request;
        if($res->save(false,$allow)){
            return true;
        }

        return '更新失败';
    }

}
