<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%team}}".
 *
 * @property int $id
 * @property string $name 团队名字
 * @property string $description 描述
 * @property string $create_time
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
            [['name'], 'required'],
            [['create_time'], 'safe'],
            [['name'], 'string', 'max' => 100],
            [['description'], 'string', 'max' => 200],
            [['name'], 'unique'],
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
}
