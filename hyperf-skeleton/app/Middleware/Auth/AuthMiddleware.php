<?php

declare(strict_types=1);

namespace App\Middleware\Auth;

use App\Helper\Helper;
use App\Model\UserInfo;
use Hyperf\HttpServer\Contract\RequestInterface as HttpRequest;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use \Hyperf\HttpServer\Contract\ResponseInterface as HttpResponse;

class AuthMiddleware implements MiddlewareInterface
{
    /**
     * @var ContainerInterface
     */
    protected $container;

    /**
     * @var HttpResponse
     */
    protected $response;

    /**
     * @var HttpRequest
     */
    protected $request;

    public function __construct(ContainerInterface $container, HttpResponse $response, HttpRequest $request)
    {
        $this->container = $container;
        $this->response = $response;
        $this->request = $request;
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $isValidToken = false;
        $token = $this->request->input('token');
        if (!$token) {
            return $this->response->json(
                Helper::failed('token验证失败')
            );
        }

        $userInfo = UserInfo::query()->where([
            'token' => $token,
            'is_deleted' => UserInfo::IS_DELETED['no'],
            'type' => UserInfo::USER_TYPE['admin']
        ])
            ->where('token_expire_time', '>', date("Y-m-d H:i:s", time()))
            ->first();
        if ($userInfo) {
            $isValidToken = true;
            $request = $request->withAttribute('userInfo', $userInfo);
            $request = \Hyperf\Utils\Context::set(ServerRequestInterface::class, $request);
        }

        if ($isValidToken) {
            return $handler->handle($request);
        }

        return $this->response->json(
            Helper::failed('token验证失败')
        );

    }
}