<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%team_project}}".
 *
 * @property int $id
 * @property int $team_id
 * @property int $project_id
 * @property int $is_leader
 */
class TeamProject extends BaseModel
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%team_project}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['team_id', 'project_id', 'is_leader'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'team_id' => 'Team ID',
            'project_id' => 'Project ID',
            'is_leader' => 'Is Leader',
        ];
    }
}
