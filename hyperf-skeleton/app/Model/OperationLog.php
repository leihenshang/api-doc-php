<?php

declare (strict_types=1);
namespace App\Model;

use Hyperf\DbConnection\Model\Model;
/**
 * @property int $id 
 * @property int $is_deleted 
 * @property string $create_time 
 * @property int $user_id 
 * @property string $action 
 * @property string $content 
 * @property int $object_id 
 * @property int $type 
 * @property int $project_id 
 */
class OperationLog extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'operation_log';
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
    protected $casts = ['id' => 'integer', 'is_deleted' => 'integer', 'user_id' => 'integer', 'object_id' => 'integer', 'type' => 'integer', 'project_id' => 'integer'];
}