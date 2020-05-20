<?php

declare (strict_types=1);
namespace App\Model;

use Hyperf\DbConnection\Model\Model;
/**
 * @property int $id 
 * @property int $p_id 
 * @property int $project_id 
 * @property string $title 
 * @property int $is_deleted 
 * @property string $create_time 
 * @property int $priority 
 * @property int $type 
 */
class Group extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'group';
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
    protected $casts = ['id' => 'integer', 'p_id' => 'integer', 'project_id' => 'integer', 'is_deleted' => 'integer', 'priority' => 'integer', 'type' => 'integer'];
}