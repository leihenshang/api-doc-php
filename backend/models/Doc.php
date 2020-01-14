<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%doc}}".
 *
 * @property int $id id
 * @property int $is_deleted 0正常1删除
 * @property int $user_id
 * @property string $title 标题
 * @property string $content 文档内容
 * @property int $state 0正常1审核中2禁用
 * @property int $group_id
 * @property string $create_time
 * @property string $update_time
 * @property int $view_count
 * @property int $like_count
 */
class Doc extends BaseModel
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%doc}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['is_deleted', 'user_id', 'state', 'group_id', 'view_count', 'like_count'], 'integer'],
            [['title', 'content'], 'required'],
            [['content'], 'string'],
            [['create_time', 'update_time'], 'safe'],
            [['title'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'id',
            'is_deleted' => '0正常1删除',
            'user_id' => 'User ID',
            'title' => '标题',
            'content' => '文档内容',
            'state' => '0正常1审核中2禁用',
            'group_id' => 'Group ID',
            'create_time' => 'Create Time',
            'update_time' => 'Update Time',
            'view_count' => 'View Count',
            'like_count' => 'Like Count',
        ];
    }
}
