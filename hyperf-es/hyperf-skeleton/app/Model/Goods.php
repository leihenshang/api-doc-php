<?php

declare (strict_types=1);
namespace App\Model;

use Hyperf\DbConnection\Model\Model;
/**
* @property int $id 
* @property string $name 商品名称
* @property string $note_tag 拼音字符
* @property string $erp_code ERP编码
* @property int $business_id 经营权限id
* @property int $child_business_id 子经营权限id
* @property int $class_business_id 分类经营权限id
* @property int $new_business_id 
* @property int $new_child_business_id 
* @property int $type_id 分类id
* @property int $control_drug 控销药id
* @property string $otc_type 处方分类,1OTC甲类,2OTC乙类,3处方,0无
* @property string $drug_attr 药品属性
* @property string $sale_area 销售区域
* @property string $user_types 查看权限
* @property int $produce_id 生产企业id
* @property int $brand_id 品牌id
* @property string $origin_place 原产地
* @property string $approval_number 批准文号
* @property string $standard 规格
* @property string $unit 单位
* @property string $unit_num 件装量
* @property int $agent_id 剂型id
* @property string $gmp_authen GMP认证
* @property string $gmp_report GMP报告
* @property int $stock_num 库存数量
* @property int $min_buy 最小购买数量
* @property string $is_discount 是否特惠,1是,0否
* @property string $is_presale 是否预售,1是,0否
* @property string $is_hosp_recom 是否医院
推荐,1是,0否
* @property string $is_recom 是否终端
推荐,1是,0否
* @property string $is_spread 是否挂网,1是,0否
* @property string $is_hot 是否热销,1是,0否
* @property string $is_ground 是否上架,1是,0否
* @property string $auto_ground_1 自动上架
* @property string $auto_ground_0 自动下架
* @property int $group_time_1 最后上架时间
* @property int $group_time_0 最后下架时间
* @property string $is_new 是否新品,1是,0否
* @property string $is_core 核心商品
* @property int $core_level 核心商品等级
* @property string $status 审核状态,2审核中,1通过,0不通过
* @property string $sync_hospital 医院同步
* @property string $sync_terminal 终端同步
* @property string $sync_hospital_price 医院同步价格
* @property string $sync_terminal_price 终端同步价格
* @property string $sync_stock 库存同步
* @property int $sync_stock_num 库存同步数量
* @property int $erp_stock 超然可销库存
* @property int $image 商品主图
* @property string $video 视频
* @property string $image_planes 商品位图
* @property string $brief 简介
* @property string $explain 说明书
* @property int $created_time 创建时间
* @property int $updated_time 修改时间
* @property string $is_valid 是否有效,1是,0否
* @property string $terminal_price 终端价格
* @property string $hospital_price 医院价格
* @property int $validity_time 效期
* @property int $sell_num 销量
* @property int $sell_user 销售客户
* @property string $blacklist 黑名单
* @property string $whitelist 白名单
* @property string $terminal_aegis_price 终端保护价
* @property string $hospital_aegis_price 医院保护价
* @property string $special_type 特殊类别
* @property string $special_min_type 特殊类别小类
* @property int $sort 排序
* @property int $star_level 星级
* @property int $integral 积分
* @property string $wms_barcode 条码
* @property string $factory 厂家等级
* @property int $buyer_id 采购id
* @property int $effect_id 功效id
* @property string $sync_permission 同步商品销售权限
* @property string $sell_point 卖点
* @property string $sync_business_price 商业最低售价
* @property string $business_price 商业保护价
* @property string $zhilbz 质量标准
* @property string $goods_code 商品编号
* @property string $shlv 税率
* @property int $store_business_id 
* @property string $is_care 
* @property string $ssxkcyr 上市许可持有人
* @property string $t_bargain_price 终端议价
* @property string $h_bargain_price 医院议价
* @property int $chinese_herb_tag 中药标签
*/
class Goods extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'goods';
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
    protected $casts = ['id' => 'integer', 'business_id' => 'integer', 'child_business_id' => 'integer', 'class_business_id' => 'integer', 'new_business_id' => 'integer', 'new_child_business_id' => 'integer', 'type_id' => 'integer', 'control_drug' => 'integer', 'produce_id' => 'integer', 'brand_id' => 'integer', 'agent_id' => 'integer', 'stock_num' => 'integer', 'min_buy' => 'integer', 'group_time_1' => 'integer', 'group_time_0' => 'integer', 'core_level' => 'integer', 'sync_stock_num' => 'integer', 'erp_stock' => 'integer', 'image' => 'integer', 'created_time' => 'integer', 'updated_time' => 'integer', 'validity_time' => 'integer', 'sell_num' => 'integer', 'sell_user' => 'integer', 'sort' => 'integer', 'star_level' => 'integer', 'integral' => 'integer', 'buyer_id' => 'integer', 'effect_id' => 'integer', 'store_business_id' => 'integer', 'chinese_herb_tag' => 'integer'];

    public $timestamps = false;
}