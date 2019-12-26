<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%team_user}}".
 *
 * @property int $id
 * @property int $team_id
 * @property int $user_id
 * @property int $is_leader
 */
class TeamUser extends BaseModel
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%team_user}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['team_id', 'user_id', 'is_leader'], 'integer'],
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
            'user_id' => 'User ID',
            'is_leader' => 'Is Leader',
        ];
    }
}
