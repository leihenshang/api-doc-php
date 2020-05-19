<?php

declare(strict_types=1);
/**
 * This file is part of Hyperf.
 *
 * @link     https://www.hyperf.io
 * @document https://doc.hyperf.io
 * @contact  group@hyperf.io
 * @license  https://github.com/hyperf-cloud/hyperf/blob/master/LICENSE
 */

namespace App\Controller;

use App\Helper\Helper;
use App\Model\Property;
use Hyperf\DbConnection\Db;
use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\RequestMapping;

/**
 * Class PropertyController
 * @package App\Controller
 * @Controller()
 */
class PropertyController extends AbstractController
{
    /**
     * 属性列表
     * @return array
     * @RequestMapping(path="list",methods="get")
     */
    public function list()
    {
        $tag = $this->request->input('tag');
//        $sql = 'SELECT * FROM property';
//        if (!$tag) {
//            $res = Db::select($sql);
//        } else {
//            $res = Db::select($sql . ' WHERE tag = ?;', [$tag]);
//        }

       $res =  Property::query();
       if($tag){
        $res->where('tag',$tag);
       }

       $res = $res->get();

        return Helper::success($res);
    }
}
