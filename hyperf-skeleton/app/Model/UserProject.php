<?php

declare (strict_types=1);
namespace App\Model;

use Hyperf\DbConnection\Model\Model;
/**
 * @property int $id 
 * @property int $user_id 
 * @property int $project_id 
 * @property int $is_leader 
 * @property int $is_deleted 
 * @property string $create_time 
 * @property int $permission 
 */
class UserProject extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'user_project';
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
    protected $casts = ['id' => 'integer', 'user_id' => 'integer', 'project_id' => 'integer', 'is_leader' => 'integer', 'is_deleted' => 'integer', 'permission' => 'integer'];
}