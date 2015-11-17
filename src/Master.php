<?php
/**
 * @author Jenner <hypxm@qq.com>
 * @blog http://www.huyanping.cn
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
     * @var FixedPool
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
     */
    public function start($block = true)
    {
        $loop = $this->loop;
        $this->loop = new FixedPool(function () use ($loop) {
            $loop->run();
        }, $this->count);

        $this->pool->start();
        $this->pool->keep($block);
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