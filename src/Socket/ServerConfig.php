<?php
/**
 * Created by PhpStorm.
 * User: Jenner
 * Date: 2016/2/1
 * Time: 9:52
 */

namespace React\Multi\Socket;


use React\Multi\Socket\Dispatch\DispatchInterface;

class ServerConfig
{
    protected $host = "0.0.0.0";
    protected $port = 4020;
    protected $protocol = "tcp";
    /**
     * @var DispatchInterface
     */
    protected $dispatcher;

    const REACT_TCP = "tcp";
    const REACT_UDP = "udp";

    public function __construct(
        $host = "0.0.0.0",
        $port = 4020,
        $protocol = self::REACT_TCP)
    {
        $this->host = $host;
        $this->port = $port;
        $this->protocol = $protocol;
        $this->max_connections = 50000;
    }

    public function getConnectionString()
    {
        return $this->protocol . '://' . $this->host . ':' . $this->port;
    }

    /**
     * @return mixed
     */
    public function getMaxConnections()
    {
        return $this->max_connections;
    }

    /**
     * @param mixed $max_connections
     */
    public function setMaxConnections($max_connections)
    {
        $this->max_connections = $max_connections;
    }

    /**
     * @return string
     */
    public function getHost()
    {
        return $this->host;
    }

    /**
     * @param string $host
     */
    public function setHost($host)
    {
        $this->host = $host;
    }

    /**
     * @return int
     */
    public function getPort()
    {
        return $this->port;
    }

    /**
     * @param int $port
     */
    public function setPort($port)
    {
        $this->port = $port;
    }

    /**
     * @return string
     */
    public function getProtocol()
    {
        return $this->protocol;
    }

    /**
     * @param string $protocol
     */
    public function setProtocol($protocol)
    {
        $this->protocol = $protocol;
    }

    /**
     * @return DispatchInterface
     */
    public function getDispatcher()
    {
        return $this->dispatcher;
    }

    /**
     * @param DispatchInterface $dispatcher
     */
    public function setDispatcher($dispatcher)
    {
        $this->dispatcher = $dispatcher;
    }


}