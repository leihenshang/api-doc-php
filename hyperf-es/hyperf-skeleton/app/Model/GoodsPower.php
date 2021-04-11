<?php

declare (strict_types=1);
namespace App\Model;

use Hyperf\DbConnection\Model\Model;
/**
 * @property int $id 
 * @property string $erp_code ERP编码
 * @property string $user_class 用户分类
 * @property string $area 区域
 * @property string $erp_id ERP编码
 * @property string $and_user_class 用户分类
 * @property string $and_area 区域
 * @property string $and_erp_id ERP编码
 * @property string $and_user_class2 
 * @property string $and_area2 
 * @property string $and_erp_id2 
 * @property string $not_user_class 用户分类
 * @property string $not_area 区域
 * @property string $not_erp_id ERP编码
 * @property string $and_not_user_class 用户分类
 * @property string $and_not_area 区域
 * @property string $and_not_erp_id ERP编码
 */
class GoodsPower extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'goods_power';
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
    protected $casts = ['id' => 'integer'];
}