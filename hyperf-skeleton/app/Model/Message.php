<?php

declare (strict_types=1);
namespace App\Model;

use Hyperf\DbConnection\Model\Model;
/**
 * @property int $id 
 * @property int $is_deleted 
 * @property string $content 
 * @property int $send_type 
 * @property string $receive_source 
 * @property string $title 
 * @property string $expire_time 
 * @property string $create_time 
 * @property string $used_time 
 * @property int $is_used 
 * @property string $code 
 */
class Message extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'message';
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
    protected $casts = ['id' => 'integer', 'is_deleted' => 'integer', 'send_type' => 'integer', 'is_used' => 'integer'];
}