<?php


namespace app\models;

/**
 * 项目模型
 * Class Project
 * @package app\models
 * @property string $title 标题
 * @property integer $id id
 */
class Project extends BaseModel
{
    const SCENARIO_CREATE = 'create';
    const SCENARIO_DEL = 'del';
    const SCENARIO_UPDATE = 'update';
    const SCENARIO_LIST = 'list';

    const TYPE = [
       'web' => ['tag' => 1,'desc' => 'web'],
        'pc' => ['tag' => 2,'desc' => 'pc'],
    ];

    public function rules()
    {
        return [
            [['ps','cp'],'integer'],
            ['id', 'required'],
            ['id', 'number'],
            [['title', 'version', 'type'], 'required'],
            ['title', 'unique'],
            ['title', 'string', 'length' => [1, 100]],
            ['description', 'string', 'length' => [1, 100]],
        ];
    }

    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios[self::SCENARIO_CREATE] = ['title', 'description', 'version', 'type'];
        $scenarios[self::SCENARIO_DEL] = ['id'];
        $scenarios[self::SCENARIO_LIST] = ['ps','cp'];
        $scenarios[self::SCENARIO_UPDATE] = ['title', 'description','version','type'];
        return $scenarios;
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
        if (!$this->validate()) {
            return current($this->getFirstErrors());
        }

        if (!$this->save()) {
            return current($this->getFirstErrors());
        }

        return true;
    }

    /**
     * 编辑数据
     * @param array $request
     * @return bool|mixed
     */
    public function updateData($request)
    {
        $this->attributes = $request;
        if (!$this->validate()) {
            return current($this->getFirstErrors());
        }

        $res = self::findOne($this->id);
        if (!$res) {
            return '没有找到数据';
        }
        $this->scenario = self::SCENARIO_UPDATE;
        $res->attributes = $request;
        if (!$res->save()) {
            return current($this->getFirstErrors());
        }

        return true;
    }

    /**
     * 删除数据
     * @return bool|mixed
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function del()
    {
        if (!$this->validate()) {
            return current($this->getFirstErrors());
        }

        $res = self::findOne($this->id);
        if (!$res->delete()) {
            return current($res->getFirstErrors());
        }

        return true;
    }

}