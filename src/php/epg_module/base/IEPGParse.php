<?php

namespace zikwall\m3uparse\epg_module\base;

use zikwall\m3uparse\epg_module\EPGAgregation;

interface IEPGParse
{
    public function parse(EPGAgregation $EPGAgregation) : array;
}
