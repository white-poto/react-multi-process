<?php
/**
 * @author Jenner <hypxm@qq.com>
 * @blog http://www.huyanping.cn
 * @license https://opensource.org/licenses/MIT MIT
 * @datetime: 2015/11/13 16:37
 */

namespace React\Multi;

use Jenner\SimpleFork\ParallelPool;
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
     * @var ParallelPool
     */
    protected $pool;

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
     *
     * @param bool $block
     * @param int $interval
     */
    public function start($block = true, $interval = 100)
    {
        $loop = $this->loop;
        $this->pool = new ParallelPool(function () use ($loop) {
            $loop->run();
        }, $this->count);

        $this->pool->start();
        $this->pool->keep($block, $interval);
    }

    /**
     * keep the sub processes count
     *
     * @param bool $block
     */
    public function keep($block = false)
    {
        $this->pool->keep($block);
    }

    /**
     * start new sub processes and shutdown old processes
     */
    public function reload()
    {
        $this->pool->reload();
    }
}