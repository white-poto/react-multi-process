<?php
/**
 * @author Jenner <hypxm@qq.com>
 * @license https://opensource.org/licenses/MIT MIT
 * @datetime: 2015/11/13 16:37
 */

namespace React\Multi;

use Jenner\SimpleFork\FixedPool;
use React\EventLoop\LoopInterface;

class Master
{
    /**
     * @var LoopInterface
     */
    protected $loop;

    /**
     * @var int process count
     */
    protected $count;

    /**
     * @param LoopInterface $loop
     * @param int $count
     */
    public function __construct(LoopInterface $loop, $count = 10)
    {
        $this->loop = $loop;
        $this->count = $count;
    }

    /**
     * start multi loop
     */
    public function start()
    {
        $loop = $this->loop;
        $pool = new FixedPool(function () use ($loop) {
            $loop->run();
        }, $this->count);

        $pool->start();
        $pool->keep(true);
    }
}