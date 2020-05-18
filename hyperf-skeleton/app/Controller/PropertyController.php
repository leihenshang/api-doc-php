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
use Hyperf\DbConnection\Db;

class PropertyController extends AbstractController
{
    public function index()
    {
        $tag = $this->request->input('tag');
        $sql = 'SELECT * FROM property';
        if(!$tag){
            $res = Db::select($sql);
        }else {
            $res = Db::select($sql.' WHERE tag = ?;',[$tag]);
        }

        return Helper::success($res);
    }
}
