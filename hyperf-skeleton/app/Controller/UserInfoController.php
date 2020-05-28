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

use App\Middleware\CorsMiddleware;
use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\Middleware;
use Hyperf\HttpServer\Annotation\RequestMapping;
use Psr\Http\Message\ResponseInterface;

/**
 * Class UserInfoController
 * @package App\Controller
 * @Controller(prefix="user-info")
 */
class UserInfoController extends AbstractController
{
    /**
     * 属性列表
     * @return ResponseInterface
     * @Middleware(CorsMiddleware::class)
     * @RequestMapping(path="login",methods="post,get,OPTIONS")
     */
    public function login()
    {
        var_dump('test');
        $name = $this->request->input('name');
        return $this->toJson($name);
    }

}
