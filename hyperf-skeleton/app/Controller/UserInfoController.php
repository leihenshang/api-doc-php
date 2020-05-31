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
use Hyperf\Di\Annotation\Inject;
use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\Middleware;
use Hyperf\HttpServer\Annotation\RequestMapping;
use Hyperf\Redis\Redis;
use Hyperf\WebSocketServer\Context;
use Psr\Http\Message\ResponseInterface;

/**
 * Class UserInfoController
 * @package App\Controller
 * @Controller(prefix="user-info")
 */
class UserInfoController extends AbstractController
{
    /**
     * @Inject()
     * @var Redis
     */
    public $redis;

    /**
     * 属性列表
     * @return ResponseInterface
     * @Middleware(CorsMiddleware::class)
     * @RequestMapping(path="login",methods="post,get")
     */
    public function login()
    {

        $name = $this->request->input('name');
        $saveKey = Context::get($name);;
        if($saveKey){
            return $this->failedToJson('登录失败,用户名已存在');
        }else {
            Context::set($name,'unknown');
        }
        return $this->toJson($name);
    }

}
