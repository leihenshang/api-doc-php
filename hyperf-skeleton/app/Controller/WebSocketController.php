<?php

declare(strict_types=1);

namespace App\Controller;

use Hyperf\Contract\OnCloseInterface;
use Hyperf\Contract\OnMessageInterface;
use Hyperf\Contract\OnOpenInterface;
use Hyperf\Di\Annotation\Inject;
use Hyperf\WebSocketServer\Context;
use Swoole\Http\Request;
use Swoole\Server;
use Swoole\Websocket\Frame;
use Swoole\WebSocket\Server as WebSocketServer;
use Hyperf\HttpServer\Contract\RequestInterface;

class WebSocketController implements OnMessageInterface, OnOpenInterface, OnCloseInterface
{
    /**
     * @Inject()
     * @var RequestInterface
     */
    public $req;


    public function onClose(Server $server, int $fd, int $reactorId): void
    {
        var_dump('closed');
    }

    public function onMessage(WebSocketServer $server, Frame $frame): void
    {
        $msg = 'Time: ' . date('Y-m-d H:i:s', time()) . ' ,Recv: ' . $frame->data;
//        $server->push($frame->fd, $msg);
        $this->broadcast($server,Context::get('ws-'.$frame->fd).'发送了,'.  $msg);
    }

    public function onOpen(WebSocketServer $server, Request $request ): void
    {
        Context::set('ws-'.$request->fd,$this->req->route('name'));
        $server->push($request->fd, 'Opened');
        $this->broadcast($server, '新用户'. Context::get('ws-'.$request->fd).'加入');
    }

    /**
     * 发送广播
     * @param WebSocketServer $server
     * @param string $msg
     */
    public function broadcast(WebSocketServer $server, string $msg): void
    {
        foreach ($server->connections as $fd) {
            // 需要先判断是否是正确的websocket连接，否则有可能会push失败
            if ($server->isEstablished($fd)) {
                $server->push($fd,'公共消息:' . $msg);
            }
        }
    }
}
