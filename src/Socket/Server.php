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
use React\Multi\Socket\Dispatch\DispatchInterface;

class Server
{
    protected $config;
    protected $handler;

    public function __construct(ServerConfig $config, HandlerInterface $handler)
    {
        $this->config = $config;
        $this->handler = $handler;
    }

    public function start($count = 1)
    {
        $loop = Factory::create();
        $server = stream_socket_server($this->config->getConnectionString());
        if($server === false){
            throw new \RuntimeException("create socket server failed");
        }

        $blocking = stream_set_blocking($server, 0);
        if($blocking === false){
            throw new \RuntimeException("stream_set_blocking failed");
        }
        $loop->addReadStream($server, function ($server) use ($loop) {
            $dispatcher = $this->config->getDispatcher();
            if ($dispatcher !== null && !$dispatcher->acquire($server, $loop)) {
                return;
            }
            $conn = stream_socket_accept($server);
            $dispatcher->release($server, $loop);
            $loop->addWriteStream($conn, function ($conn) use ($loop) {
                call_user_func(array($this->handler, 'handle'), $conn, $loop);
            });
            $loop->addReadStream($conn, function($conn) use ($loop) {
                var_dump(fread($conn, 1024));
            });
        });

        $master = new Master($loop, $count);
        $master->start();
    }
}