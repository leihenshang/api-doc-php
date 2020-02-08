<?php

namespace app\models;

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
    //0正常1审核中2禁用
    const STATE = [
        'normal' => [0, '正常'],
        'audit' => [1, '审核中'],
        'disable' => [2, '禁用'],
    ];

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
            [['title', 'content'], 'required', 'on' => self::SCENARIO_CREATE],
            [['content'], 'string'],
            [['create_time', 'update_time'], 'safe'],
            [['title'], 'string', 'max' => 100],
            ['group_id', 'required', 'on' => self::SCENARIO_CREATE],
            ['id', 'integer'],
            ['id', 'required', 'on' => [self::SCENARIO_DELETE, self::SCENARIO_DETAIL]],

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

    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios[self::SCENARIO_CREATE] = ['group_id', 'title', 'content'];
        $scenarios[self::SCENARIO_DELETE] = ['id'];
        $scenarios[self::SCENARIO_CREATE] = ['id'];
        $scenarios[self::SCENARIO_UPDATE] = ['state', 'title', 'content', 'id'];
        return $scenarios;
    }

    public function createData()
    {
        if (!$this->save()) {
            return '保存数据失败:' . current($this->getFirstErrors());
        }

        return $this->toArray();
    }

    public function deleteData()
    {
        $res = self::findOne($this->id);
        if (!$res) {
            return '没有找到数据';
        }

        $res->is_deleted = self::IS_DELETED['yes'];
        if (!$res->save()) {
            return '删除数据失败:' . current($this->getFirstErrors());
        }

        return $this->toArray();
    }

    /**
     * 更新数据
     * @param $request
     * @return array|string
     */
    public function updateData($request)
    {
        $res = self::findOne($this->id);
        if (!$res) {
            return '没有找到数据';
        }

        $res->attributes = $request;
        if (empty($this->title) && empty($this->content)) {
            return '没有更新内容';
        }

        if ($res->save(false)) {
            return $res->toArray();
        }

        return '更新失败';
    }

    public function detail()
    {
        $res = self::findOne(['id' => $this->id, 'is_deleted' => self::IS_DELETED['no']]);
        if (!$res) {
            return '没有找到数据';
        }

        return $res;
    }

    public function dataList(int $groupId = 0, int $ps = 10, int $cp = 1)
    {
        $group = Group::findOne(['id' => $groupId, 'is_deleted' => self::IS_DELETED['no']]);
        if (!$group) {
            return '没有找到分组';
        }

        $where = [
            'group_id' => $groupId,
            'is_deleted' => self::IS_DELETED['no'],
            'state' => self::STATE['normal']
        ];

        $data = ['total' => 0, 'data' => []];
        $data['total'] = self::find()->where($where)->count();
        $data['data'] = self::find()->select('id,title,create_time,view_count,like_count,user_id')->where($where)->offset(($cp - 1) * $ps)->orderBy('id DESC')->limit($ps)->all();
        return $data;
    }
}
