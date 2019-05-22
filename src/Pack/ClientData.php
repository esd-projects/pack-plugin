<?php
/**
 * Created by PhpStorm.
 * User: 白猫
 * Date: 2019/5/5
 * Time: 13:42
 */

namespace ESD\Plugins\Pack;


use ESD\BaseServer\Server\Beans\ClientInfo;
use ESD\BaseServer\Server\Beans\Request;
use ESD\BaseServer\Server\Beans\Response;
use ESD\BaseServer\Server\Server;

class ClientData
{
    /**
     * @var string
     */
    protected $controllerName;

    /**
     * @var string
     */
    protected $requestMethod;
    /**
     * @var string
     */
    protected $methodName;

    /**
     * @var ClientInfo
     */
    protected $clientInfo;
    /**
     * @var Request
     */
    protected $request;

    /**
     * @var Response
     */
    protected $response;

    /**
     * @var int
     */
    protected $fd;

    /**
     * @var string
     */
    protected $path;

    /**
     * @var array
     */
    protected $params;

    /**
     * @var array
     */
    protected $data;


    /**
     * ClientData constructor.
     * @param $fd
     * @param $requestMethod
     * @param $path
     * @param $data
     */
    public function __construct($fd, $requestMethod, $path, $data)
    {
        $this->setPath($path);
        $this->setData($data);
        $this->setFd($fd);
        $this->setRequestMethod($requestMethod);
    }

    /**
     * @return string|null
     */
    public function getControllerName(): ?string
    {
        return $this->controllerName;
    }

    /**
     * @param string $controllerName
     */
    public function setControllerName(?string $controllerName): void
    {
        $this->controllerName = $controllerName;
    }

    /**
     * @return string|null
     */
    public function getMethodName(): ?string
    {
        if ($this->methodName != null) {
            return strtoupper($this->methodName);
        }
        return null;
    }

    /**
     * @param string $methodName
     */
    public function setMethodName(?string $methodName): void
    {
        $this->methodName = $methodName;
    }

    /**
     * @return string|null
     */
    public function getPath(): string
    {
        return $this->path;
    }

    /**
     * @param string $path
     */
    public function setPath(string $path): void
    {
        $this->path = "/" . trim($path, "/");
    }

    /**
     * @return array|null
     */
    public function getParams(): ?array
    {
        return $this->params;
    }

    /**
     * @param array|null $params
     */
    public function setParams(?array $params): void
    {
        $this->params = $params;
    }

    /**
     * @return mixed
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @param mixed
     */
    public function setData($data): void
    {
        $this->data = $data;
    }

    /**
     * @param Request $request
     */
    public function setRequest(Request $request): void
    {
        $this->request = $request;
    }

    /**
     * @return Request
     */
    public function getRequest(): ?Request
    {
        return $this->request;
    }

    /**
     * @return Response
     */
    public function getResponse(): ?Response
    {
        return $this->response;
    }

    /**
     * @param Response $response
     */
    public function setResponse(Response $response): void
    {
        $this->response = $response;
    }

    /**
     * @return ClientInfo
     */
    public function getClientInfo(): ClientInfo
    {
        return $this->clientInfo;
    }

    /**
     * @param int $fd
     */
    public function setFd(int $fd): void
    {
        $this->fd = $fd;
        if ($this->fd >= 0) {
            $this->clientInfo = Server::$instance->getClientInfo($fd);
        }
    }

    /**
     * @return string
     */
    public function getRequestMethod(): string
    {
        return strtoupper($this->requestMethod);
    }

    /**
     * @param string $requestMethod
     */
    public function setRequestMethod(string $requestMethod): void
    {
        $this->requestMethod = $requestMethod;
    }

    /**
     * udp专用
     * @param array $clientInfo
     */
    public function setUdpClientInfo(array $clientInfo): void
    {
        $this->clientInfo = new ClientInfo(
            [
                "server_port" => $clientInfo['port'],
                "remote_ip" => $clientInfo['address'],
            ]
        );
    }

    /**
     * @return int
     */
    public function getFd(): ?int
    {
        return $this->fd;
    }
}