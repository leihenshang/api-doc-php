<?php

namespace app\models;

/**
 * This is the model class for table "{{%user_project}}".
 *
 * @property int $id
 * @property int $user_id
 * @property int $project_id
 * @property int $is_leader
 * @property int $is_deleted
 * @property string $create_time
 */
class UserProject extends BaseModel
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%user_project}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'project_id', 'is_leader'], 'integer'],
            [['user_id', 'project_id'], 'required']
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => '用户 ID',
            'project_id' => 'Project ID',
            'is_leader' => 'Is Leader',
        ];
    }

    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios[self::SCENARIO_CREATE] = ['user_id','project_id'];
        return $scenarios;
    }
}
