<?php
/**
 * @author Jenner <hypxm@qq.com>
 * @blog http://www.huyanping.cn
 * @license https://opensource.org/licenses/MIT MIT
 * @datetime: 2015/11/17 10:34
 */

namespace React\Multi\Socket;

interface DispatchInterface
{
    /**
     * check if the process can accept a con.
     *
     * @param $loop
     * @return bool if return false, this process will not accept the con.
     * when there are more then one processes accept the con, the operating system
     * will ensure that only one process will accept the con successfully.
     */
    public function enableAccept($loop);
}