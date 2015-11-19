react-multi-process
=========================
multi process support to reactphp

Why use react-multi-process
-----------------------------
When we use `react/event-loop` to write async programs, we can not be sure 
that every module is a no-blocking module(sync mysql client...).  
So we use multi process to improve the performance of our sync program.

Import
-----------------------------
```shell
composer require jenner/react-multi-process
```

How to use it?
----------------------------------
So simple like:
```php
$loop = React\EventLoop\Factory::create();
$server = stream_socket_server('tcp://127.0.0.1:4020');
stream_set_blocking($server, 0);
$loop->addReadStream($server, function ($server) use ($loop) {
    $conn = stream_socket_accept($server);
    $data = "pid:" . getmypid() . PHP_EOL;
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

// the second param is the sub process count
$master = new \React\Multi\Master($loop, 20);
$master->start();
```
