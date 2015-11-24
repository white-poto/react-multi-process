<?php
/**
 * @author Jenner <hypxm@qq.com>
 * @blog http://www.huyanping.cn
 * @license https://opensource.org/licenses/MIT MIT
 * @datetime: 2015/11/17 10:23
 */

namespace React\Multi\Socket;

use React\EventLoop\Factory;
use React\Multi\Master;

class Server
{
    protected $port;
    protected $host;
    protected $dispatcher;
    protected $handler;

    public function __construct(HandlerInterface $handler, $port = 4020, $host = '0.0.0.0', DispatchInterface $dispatcher = null)
    {
        $this->host = $host;
        $this->port = $port;
        $this->dispatcher = $dispatcher;
        $this->handler = $handler;
    }

    public function start($count = 1)
    {
        $loop = Factory::create();
        $server = stream_socket_server("tcp://{$this->host}:{$this->port}");
        if($server === false){
            throw new \RuntimeException("create socket server failed");
        }

        $blocking = stream_set_blocking($server, 0);
        if($blocking === false){
            throw new \RuntimeException("stream_set_blocking failed");
        }
        $loop->addReadStream($server, function ($server) use ($loop) {
            if ($this->dispatcher !== null && !$this->dispatcher->enableAccept($loop)) {
                return;
            }
            $conn = stream_socket_accept($server);
            $loop->addWriteStream($conn, function ($conn) use ($loop) {
                call_user_func(array($this->handler, 'handle'), $conn, $loop);
            });
        });

        $master = new Master($loop, $count);
        $master->start();
    }
}