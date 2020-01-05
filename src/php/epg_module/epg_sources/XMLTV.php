<?php

namespace zikwall\m3uparse\epg_module\epg_source;

use zikwall\m3uparse\epg_module\base\EPGParser;
use zikwall\m3uparse\epg_module\EPGAgregation;

class XMLTV extends EPGParser
{
    public $name = 'ForeverIPTV';
    public $xmlName = 'xmltv';

    public function parse(EPGAgregation $EPGAgregation) : array
    {
        $sourceUrl = 'https://webhalpme.ru/if.m3u';
        $EPGAgregation->downloadEPG($EPGAgregation->getEpgUploadDirectory(), $this->name, $sourceUrl);

        $source = file_get_contents($EPGAgregation->getEPGSource($this->xmlName));
    }
}
