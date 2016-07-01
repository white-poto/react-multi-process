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
        var_dump(fread($conn, 1));
        fwrite($conn, 'dddd');
    }
}

$config = new \React\Multi\Socket\ServerConfig();
$config->setDispatcher(new \React\Multi\Socket\Dispatch\CompetitionDispatch());


$server = new \React\Multi\Socket\Server($config, new Handler());
$server->start();