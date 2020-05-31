<?php

declare(strict_types=1);

namespace App\Controller;

use Hyperf\HttpServer\Annotation\AutoController;
use Hyperf\HttpServer\Contract\RequestInterface;
use Hyperf\HttpServer\Contract\ResponseInterface;
use Hyperf\View\RenderInterface;

/**
 * Class ChatController
 * @package App\Controller
 * @AutoController()
 */
class ChatController
{
    public function index(RequestInterface $request, ResponseInterface $response,RenderInterface $render)
    {
        return $render->render('index');
    }
}
