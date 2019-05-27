<?php
/**
 * Created by PhpStorm.
 * User: 白猫
 * Date: 2019/5/22
 * Time: 14:08
 */

namespace ESD\Plugins\Pack;


use ESD\Core\Server\Config\PortConfig;
use ESD\Plugins\Pack\PackTool\LenJsonPack;
use ESD\Plugins\Pack\PackTool\NonJsonPack;

class PackConfig extends PortConfig
{
    /**
     * @var string
     */
    protected $packTool;

    /**
     * @throws \DI\DependencyException
     * @throws \DI\NotFoundException
     * @throws \ESD\Core\Plugins\Config\ConfigException
     */
    public function merge()
    {
        if ($this->isOpenWebsocketProtocol() && $this->packTool == null) {
            $this->packTool = NonJsonPack::class;
        } else if (!$this->isOpenHttpProtocol() && $this->packTool == null) {
            $this->packTool = LenJsonPack::class;
        }
        parent::merge();
    }

    /**
     * @return string
     */
    public function getPackTool(): ?string
    {
        return $this->packTool;
    }

    /**
     * @param string $packTool
     */
    public function setPackTool(string $packTool): void
    {
        $this->packTool = $packTool;
    }
}