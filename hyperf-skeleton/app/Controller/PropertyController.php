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
        $group = $this->request->input('group', false);
        $res = Property::query();
        if ($tag) {
            $res->where('tag', $tag);
        }

        $res = $res->get()->toArray();
        if (boolval($group) === true) {
            $key = array_unique(array_column($res, 'tag'));
            $key = array_combine($key, array_fill(0, count($key), []));
            foreach ($key as $k => &$item) {
                foreach ($res as $value) {
                    if ($k === $value['tag']) {
                        $item[] = $value;
                    }
                }
            }
            $res = $key;
        }

        return Helper::success($res);
    }
}
