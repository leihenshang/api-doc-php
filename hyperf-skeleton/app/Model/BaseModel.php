<?php

declare (strict_types=1);

namespace App\Model;

use Hyperf\DbConnection\Model\Model;

class BaseModel extends Model
{
    const IS_DELETED = [
        'yes' => 1,
        'no' => 0
    ];
}