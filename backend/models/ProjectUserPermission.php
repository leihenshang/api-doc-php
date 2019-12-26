<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%project_user_permission}}".
 *
 * @property int $id
 * @property int $user_id
 * @property int $project_id
 * @property int $create
 * @property int $del
 * @property int $update
 * @property int $query
 */
class ProjectUserPermission extends BaseModel
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%project_user_permission}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'project_id', 'create', 'del', 'update', 'query'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'project_id' => 'Project ID',
            'create' => 'Create',
            'del' => 'Del',
            'update' => 'Update',
            'query' => 'Query',
        ];
    }
}
