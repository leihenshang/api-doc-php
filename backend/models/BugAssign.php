<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%bug_assign}}".
 *
 * @property int $id
 * @property int $bug_id 项目id
 * @property int $from_user_id 来源用户
 * @property int $to_user_id 目标用户
 * @property string|null $comment 备注
 * @property int $status 1待解决2已解决3不处理
 * @property string $is_deleted 0正常1删除
 * @property string|null $create_time 创建时间
 * @property string|null $update_time
 */
class BugAssign extends BaseModel
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%bug_assign}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['bug_id'], 'required'],
            [['bug_id', 'from_user_id', 'to_user_id', 'status'], 'integer'],
            [['create_time', 'update_time'], 'safe'],
            [['comment'], 'string', 'max' => 1000],
            [['is_deleted'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'bug_id' => '项目id',
            'from_user_id' => '来源用户',
            'to_user_id' => '目标用户',
            'comment' => '备注',
            'status' => '1待解决2已解决3不处理',
            'is_deleted' => '0正常1删除',
            'create_time' => '创建时间',
            'update_time' => 'Update Time',
        ];
    }
}
