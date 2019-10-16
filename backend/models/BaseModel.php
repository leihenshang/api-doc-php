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
    public $ps = 10;
    public $cp = 1;

    public function getOffset()
    {
        return ($this->cp - 1) * $this->ps;
    }
}