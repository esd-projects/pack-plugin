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

class EofJsonPack extends AbstractPack
{
    use GetLogger;
    protected $last_data = null;
    protected $last_data_result = null;

    /**
     * 数据包编码
     * @param $buffer
     * @return string
     */
    public function encode(string $buffer)
    {
        return $buffer . $this->portConfig->getPackageEof();
    }

    /**
     * 数据包解码
     * @param $buffer
     * @return string
     */
    public function decode(string $buffer)
    {
        $data = str_replace($this->portConfig->getPackageEof(), '', $buffer);
        return $data;
    }

    /**
     * 数据包打包
     * @param $data
     * @param PortConfig $portConfig
     * @param string|null $topic
     * @return string
     */
    public function pack(string $data, PortConfig $portConfig, ?string $topic = null)
    {
        $this->portConfig = $portConfig;
        return $this->encode(json_encode($data, JSON_UNESCAPED_UNICODE));
    }

    /**
     * 数据包解包
     * @param int $fd
     * @param string $data
     * @param PortConfig $portConfig
     * @return mixed
     * @throws PackException
     * @throws \ESD\BaseServer\Server\Exception\ConfigException
     */
    public function unPack(int $fd, string $data, PortConfig $portConfig): ClientData
    {
        $this->portConfig = $portConfig;
        $value = json_decode($this->decode($data), true);
        if (empty($value)) {
            throw new PackException('json unPack 失败');
        }
        $clientData = new ClientData($fd, $portConfig->getBaseType(), $value['p'], $value);
        return $clientData;
    }
}