<?php
/**
 * Created by PhpStorm.
 * User: Jenner
 * Date: 2016/7/1
 * Time: 9:48
 */

require dirname(__DIR__) . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php';


class Handler implements \React\Multi\Socket\HandlerInterface {

    /**
     * handle request
     *
     * @param $conn
     * @param \React\EventLoop\LoopInterface $loop
     * @return mixed
     */
    public function handle($conn, \React\EventLoop\LoopInterface $loop)
    {
        var_dump(getmypid() . ":" . fread($conn, 1024));
        fwrite($conn, "HTTP/1.1 200 OK
Server: GitHub.com
Date: Fri, 01 Jul 2016 03:38:21 GMT
Content-Type: text/html; charset=utf-8\r\n\r\n");
    }
}

$config = new \React\Multi\Socket\ServerConfig();
$config->setDispatcher(new \React\Multi\Socket\Dispatch\CompetitionDispatch());


$server = new \React\Multi\Socket\Server($config, new Handler());
$server->start(1);