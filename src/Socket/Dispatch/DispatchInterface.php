<?php
/**
 * @author Jenner <hypxm@qq.com>
 * @blog http://www.huyanping.cn
 * @license https://opensource.org/licenses/MIT MIT
 * @datetime: 2015/11/17 10:34
 */

namespace React\Multi\Socket\Dispatch;

interface DispatchInterface
{
    /**
     * check if the process can accept a con.
     *
     * @param $server
     * @param $loop
     * @return bool if return false, this process will not accept the con.
     * when there are more then one processes accept the con, the operating system
     * will ensure that only one process will accept the con successfully.
     */
    public function acquire($server, $loop);

    /**
     * when the con is accept, the lock resource should be released
     *
     * @param $server
     * @param $loop
     * @return bool
     */
    public function release($server, $loop);
}