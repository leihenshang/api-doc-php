<?php

declare (strict_types=1);
namespace App\Model;

use Hyperf\DbConnection\Model\Model;
/**
 * @property int $id 
 * @property int $group_id 
 * @property int $project_id 
 * @property string $description 
 * @property int $is_deleted 
 * @property string $create_time 
 * @property string $update_time 
 * @property int $group_id_second 
 * @property string $protocol_type 
 * @property string $http_method_type 
 * @property string $url 
 * @property string $api_name 
 * @property string $object_name 
 * @property string $function_name 
 * @property string $develop_language 
 * @property string $http_request_header 
 * @property string $http_request_params 
 * @property string $http_return_type 
 * @property string $http_return_sample 
 * @property string $http_return_params 
 */
class Api extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'api';
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
    protected $casts = ['id' => 'integer', 'group_id' => 'integer', 'project_id' => 'integer', 'is_deleted' => 'integer', 'group_id_second' => 'integer'];
}