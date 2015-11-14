<?php
/**
 * @author Jenner <hypxm@qq.com>
 * @license https://opensource.org/licenses/MIT MIT
 * @datetime: 2015/11/13 20:00
 */

require dirname(__DIR__) . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php';

$loop = React\EventLoop\Factory::create();

$server = stream_socket_server('tcp://127.0.0.1:4020');

sleep(100);
stream_set_blocking($server, 0);
$loop->addReadStream($server, function ($server) use ($loop) {
    $conn = stream_socket_accept($server);
    $data = "pid:" . getmypid() . PHP_EOL;
    $loop->addWriteStream($conn, function ($conn) use (&$data, $loop) {
        usleep(10);
        $written = fwrite($conn, $data);
        if ($written === strlen($data)) {
            fclose($conn);
            $loop->removeStream($conn);
        } else {
            $data = substr($data, 0, $written);
        }
    });
});

$master = new \React\Multi\Master($loop, 20);
$master->start();
