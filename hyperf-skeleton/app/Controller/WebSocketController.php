<?php

declare(strict_types=1);

namespace App\Controller;

use Hyperf\Contract\OnCloseInterface;
use Hyperf\Contract\OnMessageInterface;
use Hyperf\Contract\OnOpenInterface;
use Hyperf\Di\Annotation\Inject;
use Hyperf\Redis\Redis;
use Hyperf\WebSocketServer\Context;
use Swoole\Http\Request;
use Swoole\Server;
use Swoole\Websocket\Frame;
use Swoole\WebSocket\Server as WebSocketServer;
use Hyperf\HttpServer\Contract\RequestInterface;

class WebSocketController implements OnMessageInterface, OnOpenInterface, OnCloseInterface
{
    //1为系统消息 2为用户消息
    const MSG_TYPE = [
        'sys' => 1,
        'user' => 2,
    ];

    /**
     * @Inject()
     * @var Redis
     */
    public $redis;


    /**
     * @Inject()
     * @var RequestInterface
     */
    public $req;


    public function onClose(Server $server, int $fd, int $reactorId): void
    {
        Context::destroy(Context::get('ws-' . $fd));
        var_dump('closed', '退出', Context::get('ws-' . $fd));
    }

    public function onMessage(WebSocketServer $server, Frame $frame): void
    {
        $msg = $frame->data;
//        $server->push($frame->fd, $msg);
        $this->broadcast($server, $this->sendMsg(self::MSG_TYPE['user'], $msg, Context::get('ws-' . $frame->fd)),$frame->fd);
    }

    public function onOpen(WebSocketServer $server, Request $request): void
    {
        Context::set('ws-' . $request->fd, $this->req->route('name'));
        $this->broadcast($server, $this->sendMsg(self::MSG_TYPE['sys'], '新用户' . Context::get('ws-' . $request->fd) . '加入'));
    }

    /**
     * 发送广播
     * @param WebSocketServer $server
     * @param string $msg
     * @param int $jumpFd
     */
    public function broadcast(WebSocketServer $server, string $msg, int $jumpFd = 0): void
    {
        foreach ($server->connections as $fd) {

            if ($fd == $jumpFd) {
                continue;
            }

            // 需要先判断是否是正确的websocket连接，否则有可能会push失败
            if ($server->isEstablished($fd)) {
                $server->push($fd, $msg);
            }
        }
    }

    /**
     * 返回JSON形式的消息
     * @param int $type
     * @param string $msg
     * @param string $name
     * @return false|string
     */
    public function sendMsg(int $type, string $msg, string $name = '')
    {
        return json_encode([
            'type' => $type,
            'msg' => $msg,
            'name' => $name,
            'time' => date('Y-m-d H:i:s', time())
        ], JSON_UNESCAPED_UNICODE);
    }
}
