<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%bug}}".
 *
 * @property int $id
 * @property int $project_id 项目id
 * @property int $to_user_id 处理人id
 * @property string $title 标题
 * @property string $content 内容
 * @property string|null $comment 备注
 * @property int $status 1待解决2已解决3不处理
 * @property int $level 1不影响使用2一般3中等4严重5毁灭
 * @property string $is_deleted 0正常1删除
 * @property string|null $create_time 创建时间
 * @property string|null $update_time
 */
class Bug extends BaseModel
{

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%bug}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['project_id', 'title', 'content', 'level'], 'required'],
            [['project_id', 'to_user_id', 'status', 'level'], 'integer'],
            [['content'], 'string'],
            [['create_time', 'update_time'], 'safe'],
            [['title', 'is_deleted'], 'string', 'max' => 100],
            [['comment'], 'string', 'max' => 1000],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'project_id' => '项目id',
            'to_user_id' => '处理人id',
            'title' => '标题',
            'content' => '内容',
            'comment' => '备注',
            'status' => '1待解决2已解决3不处理',
            'level' => '1不影响使用2一般3中等4严重5毁灭',
            'is_deleted' => '0正常1删除',
            'create_time' => '创建时间',
            'update_time' => 'Update Time',
        ];
    }

    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios[self::SCENARIO_CREATE] = [
            'data', 'project_id', 'group_id', 'description', 'protocol_type',
            'http_method_type', 'url', 'api_name', 'object_name', 'function_name', 'develop_language',
            'http_request_header', 'http_request_params', 'http_return_type', 'http_return_sample', 'http_return_params'
        ];

        return $scenarios;
    }
}
