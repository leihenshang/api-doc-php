<?php


namespace app\models;

/**
 * 项目模型
 * Class Project
 * @package app\models
 * @property string $title 名字
 * @property integer $id id
 * @property integer $p_id id
 * @property integer $project_id id
 * @property integer is_deleted id
 * @property string create_time id
 *
 */
class Api extends BaseModel
{
    const SCENARIO_CREATE = 'create';
    const SCENARIO_DEL = 'del';
    const SCENARIO_UPDATE = 'update';

    public function rules()
    {
        return [
            ['id','required'],
            [['id','p_id','project_id','is_deleted'],'number'],
            ['title', 'required'],
            ['title','unique'],
            ['title', 'string', 'length' => [1, 100]],
        ];
    }

    public function scenarios()
    {
        $scenarios =  parent::scenarios();
        $scenarios[self::SCENARIO_CREATE] = ['title'];
        $scenarios[self::SCENARIO_DEL] = ['id'];
        $scenarios[self::SCENARIO_UPDATE] = ['title','id'];
        return $scenarios;
    }

    public static function tableName()
    {
        return 'group';
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

}