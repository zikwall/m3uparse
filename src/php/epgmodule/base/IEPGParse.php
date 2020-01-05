<?php

namespace zikwall\m3uparse\epgmodule\base;

use zikwall\m3uparse\epgmodule\EPGAgregation;

interface IEPGParse
{
    public function getName() : string;
    public function getLimits() : array;
    public function setLimits(array $limits) : IEPGParse;
    public function parse(EPGAgregation $EPGAgregation, array $availableChannels) : array;
}
