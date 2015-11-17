<?php
/**
 * @author Jenner <hypxm@qq.com>
 * @blog http://www.huyanping.cn
 * @license https://opensource.org/licenses/MIT MIT
 * @datetime: 2015/11/17 10:43
 */

namespace React\Multi\Socket;


use React\EventLoop\LoopInterface;

interface HandlerInterface
{
    /**
     * handle request
     *
     * @param $conn
     * @param LoopInterface $loop
     * @return mixed
     */
    public function handle($conn, LoopInterface $loop);
}