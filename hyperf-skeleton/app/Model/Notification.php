<?php

declare (strict_types=1);
namespace App\Model;

use Hyperf\DbConnection\Model\Model;
/**
 * @property int $id 
 * @property string $title 
 * @property string $content 
 * @property int $send_type 
 * @property int $receiver 
 * @property string $create_time 
 * @property int $read 
 * @property int $is_deleted 
 */
class Notification extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'notification';
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
    protected $casts = ['id' => 'integer', 'send_type' => 'integer', 'receiver' => 'integer', 'read' => 'integer', 'is_deleted' => 'integer'];
}