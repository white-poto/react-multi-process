<?php
/**
 * Created by PhpStorm.
 * User: Jenner
 * Date: 2016/2/1
 * Time: 9:59
 */

namespace React\Multi\Socket\Dispatch;


use Jenner\SimpleFork\Lock\FileLock;
use Jenner\SimpleFork\Lock\Semaphore;

class CompetitionDispatch implements DispatchInterface
{
    /**
     * @var Semaphore
     */
    protected $sem;
    protected $lock;

    public function __construct($lock_file = "/tmp/react-multi-process.lock")
    {
        $this->sem = FileLock::create($lock_file);
    }

    public function acquire($server, $loop)
    {
        $lock = $this->sem->acquire(false);
        if($lock) {
            return true;
        }
        return false;
    }

    public function release($server, $loop)
    {
        return $this->sem->release();
    }
}