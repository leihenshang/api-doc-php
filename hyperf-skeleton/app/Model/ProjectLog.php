<?php

declare (strict_types=1);
namespace App\Model;

use Hyperf\DbConnection\Model\Model;
/**
 * @property int $id 
 * @property string $create_time 
 * @property int $is_deleted 
 * @property int $user_id 
 * @property string $action 
 * @property int $project_id 
 * @property string $description 
 */
class ProjectLog extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'project_log';
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
    protected $casts = ['id' => 'integer', 'is_deleted' => 'integer', 'user_id' => 'integer', 'project_id' => 'integer'];
}