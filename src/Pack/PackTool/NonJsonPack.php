<?php
/**
 * Created by PhpStorm.
 * User: 白猫
 * Date: 16-7-15
 * Time: 下午2:43
 */

namespace ESD\Plugins\Pack\PackTool;

use ESD\BaseServer\Plugins\Logger\GetLogger;
use ESD\BaseServer\Server\Config\PortConfig;
use ESD\Plugins\Pack\ClientData;
use ESD\Plugins\EasyRoute\PackException;

class NonJsonPack implements IPack
{
    use GetLogger;

    /**
     * @param $data
     * @param PortConfig $portConfig
     * @param string|null $topic
     * @return false|string
     */
    public function pack(string $data, PortConfig $portConfig, ?string $topic = null)
    {
        return json_encode($data, JSON_UNESCAPED_UNICODE);
    }

    /**
     * @param int $fd
     * @param string $data
     * @param PortConfig $portConfig
     * @return ClientData
     * @throws PackException
     * @throws \ESD\BaseServer\Server\Exception\ConfigException
     */
    public function unPack(int $fd, string $data, PortConfig $portConfig): ClientData
    {
        $value = json_decode($data, true);
        if (empty($value)) {
            throw new PackException('json unPack 失败');
        }
        $clientData = new ClientData($fd, $portConfig->getBaseType(), $value['p'], $value);
        return $clientData;
    }

    public function encode(string $buffer)
    {
        return;
    }

    public function decode(string $buffer)
    {
        return;
    }
}