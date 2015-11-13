<?php
/**
 * @author Jenner <hypxm@qq.com>
 * @license https://opensource.org/licenses/MIT MIT
 * @datetime: 2015/11/13 20:00
 */

require dirname(__DIR__) . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php';

$loop = React\EventLoop\Factory::create();

$server = stream_socket_server('tcp://127.0.0.1:8080');
stream_set_blocking($server, 0);
$loop->addReadStream($server, function ($server) use ($loop) {
    $conn = stream_socket_accept($server);
    $data = "hello world\r\n";
    $loop->addWriteStream($conn, function ($conn) use (&$data, $loop) {
        $written = fwrite($conn, $data);
        if ($written === strlen($data)) {
            fclose($conn);
            $loop->removeStream($conn);
        } else {
            $data = substr($data, 0, $written);
        }
    });
});

$master = new \React\Multi\Master($loop);
$master->start();
