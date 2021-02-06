<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%database}}".
 *
 * @property int $id
 * @property string $address 数据库地址
 * @property int $port 端口号
 * @property string $username 用户名
 * @property string $password 密码
 * @property string $database_name 数据库名称
 * @property int $project_id 项目ID
 * @property int $is_deleted 是否删除 0 未删除 1 已删除
 * @property int $create_time 创建时间
 * @property int $update_time 修改时间
 * @property int $user_id 用户ID
 * @property int $type 数据库类型 1:mysql
 */
class Database extends BaseModel
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%database}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['address', 'port', 'username', 'password', 'database_name', 'project_id','user_id','type'], 'required'],
            [['port', 'project_id', 'is_deleted','user_id','type'], 'integer'],
            [['address', 'username', 'password', 'database_name'], 'string', 'max' => 50],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'address' => '数据库地址',
            'port' => '端口号',
            'username' => '用户名',
            'password' => '密码',
            'database_name' => '数据库名称',
            'project_id' => '项目ID',
            'is_deleted' => '是否删除 0 未删除 1 已删除',
            'create_time' => '创建时间',
            'update_time' => '删除时间',
            'user_id' => '用户ID',
            'type' => '数据库类型 1：mysql',
        ];
    }

    /**定义场景
     * @return array
     */
    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios[self::SCENARIO_CREATE] = ['address', 'port', 'username', 'password','database_name','project_id','type'];
        $scenarios[self::SCENARIO_DELETE] = ['id'];
        $scenarios[self::SCENARIO_UPDATE] = ['id','address', 'port', 'username', 'password', 'database_name', 'project_id','is_deleted','type'];
        $scenarios[self::SCENARIO_LIST] = [];
        return $scenarios;
    }


    /**数据库连接
     * @param $address
     * @param $port
     * @param $username
     * @param $password
     * @param $database_name
     * @return Yii\db\Connection
     */
    public static function connectDb($address,$port,$username,$password,$database_name)
    {
        $db = new yii\db\Connection([
            'dsn' => 'mysql:host='.$address.';port='.$port.';dbname='.$database_name,
            'username' => $username,
            'password' => $password,
            'charset' => 'utf8',
        ]);
        return $db;
    }


    /**创建方法
     * @return array|string
     */
    public function createData()
    {
        //同地址数据库是否重复
        $database = self::find()->where([
            'address' => $this->address,
            'port' => $this->port,
            'database_name' => $this->database_name,
            'is_deleted' => self::IS_DELETED['no']
        ])->one();

        if($database){
            return '同地址下数据库不能重复';
        }

        //测试是否能连接成功
        $db = $this::connectDb($this->address,$this->port,$this->username,$this->password,$this->database_name);

        try{
            $db->open();
        }catch (\Exception $exception){
            return '数据库连接失败：'.$exception->getMessage();
        }

        $this->user_id = UserInfo::$staticUserInfo->id;

        if (!$this->save()) {
            return '保存数据失败:' . current($this->getFirstErrors());
        }
        $db->close();

        return $this->toArray();
    }


    public function updateData($request)
    {
        $this->attributes = $request;

        $res = self::findOne($this->id);
        if (!$res) {
            return '没有找到数据';
        }
        $this->scenario = self::SCENARIO_UPDATE;

        //同地址数据库是否重复
        $database = self::find()->where([
            'address' => $this->address,
            'port' => $this->port,
            'database_name' => $this->database_name,
            'is_deleted' => self::IS_DELETED['no']
        ])->one();

        if($database){
            return '同地址下数据库不能重复';
        }

        //测试是否能连接成功
        $db = $this::connectDb($this->address,$this->port,$this->username,$this->password,$this->database_name);

        try{
            $db->open();
        }catch (\Exception $exception){
            return '数据库连接失败：'.$exception->getMessage();
        }

        $db->close();

        $res->attributes = $request;
        $res->update_time = date('Y-m-d H:i:s',time());

        if (!$res->save()) {
            return current($this->getFirstErrors());
        }

        return true;
    }

    /**
     * 数据列表
     * @param int $projectId
     * @param int $ps
     * @param int $cp
     * @param int $isDeleted
     * @param string $keyword
     * @return Database[]|array
     */
    public function dataList($projectId, $ps, $cp,$isDeleted = 0, $keyword = '')
    {
        $this->ps = $ps;
        $this->cp = $cp;

        $res = self::find()
            ->andWhere(['project_id' => intval($projectId)]);

        if ($isDeleted) {
            $res->andWhere(['is_deleted' => self::IS_DELETED['yes']]);
        } else {
            $res->andWhere(['is_deleted' => self::IS_DELETED['no']]);
        }

        if ($keyword) {
            $keyword = trim($keyword);
            $res->andWhere(['like','database_name','%'.$keyword.'%']);
        }

        $resCount = $res->count();
        $res = $res->limit($this->ps)->offset($this->offset)->all();

        return ['count' => $resCount, 'items' => $res];
    }


    public static function getTables($id)
    {
        $database = self::findOne(intval($id));

        if(!$database) {
            return '数据不存在';
        }

        $db = self::connectDb($database->address,$database->port,$database->username,$database->password,$database->database_name);
        $tables = $db->getSchema()->getTableNames();
        $data = [];
        if($tables) {
            foreach ($tables as $table) {
                $data[] = ['title' => $table];
            }
        }

        return $data;
    }


    /**
     * 删除数据
     * @return bool|mixed
     */
    public function del()
    {
        if (!$this->validate()) {
            return current($this->getFirstErrors());
        }

        $res = self::findOne($this->id);
        $res->is_deleted = self::IS_DELETED['yes'];
        if (!$res->save(false)) {
            return current($res->getFirstErrors());
        }

        return true;
    }
}