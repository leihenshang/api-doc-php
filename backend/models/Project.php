<?php


namespace app\models;

/**
 * 项目模型
 * Class Project
 * @package app\models
 * @property string $title 标题
 */
class Project extends BaseModel
{

    public function rules()
    {
        return [
            ['title', 'required'],
            ['title','unique'],
            ['title', 'string', 'length' => [1, 100]],
            ['description', 'string', 'length' => [1, 100]],
        ];
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
        if(!$this->validate()){
            return current($this->getFirstErrors());
        }

        if(!$this->save()){
            return current($this->getFirstErrors());
        }

        return true;
    }


}