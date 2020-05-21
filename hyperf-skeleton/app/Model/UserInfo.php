<?php

declare (strict_types=1);
namespace App\Model;

use Hyperf\DbConnection\Model\Model;
/**
 * @property int $id 
 * @property string $name 
 * @property string $pwd 
 * @property string $email 
 * @property int $is_deleted 
 * @property string $create_time 
 * @property int $type 
 * @property int $state 
 * @property string $mobile_number 
 * @property string $nick_name 
 * @property string $last_login_ip 
 * @property string $last_login_time 
 * @property string $user_face 
 * @property string $token 
 * @property string $token_expire_time 
 */
class UserInfo extends BaseModel
{
    //1普通用户2管理员
    const USER_TYPE =[
        'admin' => 2,
        'normal' => 1
    ];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'user_info';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [];
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = ['id' => 'integer', 'is_deleted' => 'integer', 'type' => 'integer', 'state' => 'integer'];
}