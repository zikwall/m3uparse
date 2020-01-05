<?php

namespace zikwall\m3uparse\epg_module\base;

use zikwall\m3uparse\epg_module\EPGAgregation;

class EPGParser implements IEPGParse
{
    public $name = 'unnamed';
    public $xmlName = 'unnamed_xml';

    public function parse(EPGAgregation $EPGAgregation): array
    {
        // TODO: Implement parse() method.
    }
}
