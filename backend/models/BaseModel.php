<?php

namespace app\models;

use yii\db\ActiveRecord;

/**
 * 基础模型
 * Class BaseModel
 * @property int $ps
 * @property int $cp
 * @property int $offset
 * @package app\models
 */
class BaseModel extends ActiveRecord
{
    const IS_DELETED = ['yes' => 1, 'no' => 0];

    /**
     * @var int $ps 分页
     */
    public  $ps = 10;
    /**
     * @var int $cp 当前页
     */
    public  $cp = 1;


    public function getOffset()
    {
        return ($this->cp - 1) * $this->ps;
    }

}