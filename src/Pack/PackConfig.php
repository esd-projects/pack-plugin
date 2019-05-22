<?php
/**
 * Created by PhpStorm.
 * User: 白猫
 * Date: 2019/5/22
 * Time: 14:08
 */

namespace ESD\Plugins\Pack;


use ESD\BaseServer\Server\Config\PortConfig;
use ESD\Plugins\Pack\PackTool\LenJsonPack;
use ESD\Plugins\Pack\PackTool\NonJsonPack;

class PackConfig extends PortConfig
{
    /**
     * @var string
     */
    protected $packTool;

    public function buildConfig(): array
    {
        if ($this->isOpenWebsocketProtocol() && $this->packTool == null) {
            $this->packTool = NonJsonPack::class;
        } else if (!$this->isOpenHttpProtocol() && $this->packTool == null) {
            $this->packTool = LenJsonPack::class;
        }
        return parent::buildConfig();
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