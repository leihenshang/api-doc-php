<?php

declare (strict_types=1);
namespace App\Model;

use Hyperf\DbConnection\Model\Model;
/**
 * @property int $id 
 * @property int $is_deleted 
 * @property int $project_id 
 * @property int $user_id 
 * @property string $title 
 * @property string $content 
 * @property int $state 
 * @property int $group_id 
 * @property string $create_time 
 * @property string $update_time 
 * @property int $view_count 
 * @property int $like_count 
 */
class Doc extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'doc';
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
    protected $casts = ['id' => 'integer', 'is_deleted' => 'integer', 'project_id' => 'integer', 'user_id' => 'integer', 'state' => 'integer', 'group_id' => 'integer', 'view_count' => 'integer', 'like_count' => 'integer'];
}