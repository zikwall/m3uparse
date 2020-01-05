<?php

namespace zikwall\m3uparse\epgmodule;

use zikwall\m3uparse\Configuration;
use zikwall\m3uparse\Downloader;
use zikwall\m3uparse\epgmodule\base\IEPGParse;
use zikwall\m3uparse\Paths;

class EPGAgregation
{
    use Paths;
    use Downloader;

    public function __construct(Configuration $configuration)
    {
        ini_set('memory_limit', '512M');

        $this->uploadFolder = $configuration->uploadFolder;
        $this->rootUploadDirectory = $configuration->root;

        $this->ifNotExistNotExistCreateUpload();
    }

    final public function merge(array $availableChannels, IEPGParse... $epgParsers) : array
    {
        $eps = [];

        foreach ($epgParsers as $epgParser) {
            $epgs[$epgParser->getName()] = $epgParser->parse($this, $availableChannels);
        }

        return $epgs;
    }
}
