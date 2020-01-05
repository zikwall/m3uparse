<?php

namespace zikwall\m3uparse\epgmodule\base;

use zikwall\m3uparse\Debug;
use zikwall\m3uparse\epgmodule\EPGAgregation;

class EPGParser implements IEPGParse
{
    /**
     * @var string
     */
    public $name = 'unnamed';
    /**
     * @var string
     */
    public $xmlName = 'unnamed_xml';
    /**
     * @var array
     */
    protected $limits = [];
    /**
     * @var bool
     */
    public $useLimitersByChannels = true;
    /**
     * @var bool 
     */
    public $useLocalLimiters = true;
    /**
     * @var \Closure
     */
    public $callback = null;
    /**
     * @var bool
     */
    public $useCallback = false;

    public function getName(): string
    {
        return $this->xmlName ?? $this->name;
    }

    public function initLimits() : IEPGParse
    {
        $rc = new \ReflectionClass(get_class($this));
        $location = dirname($rc->getFileName());

        if (file_exists(sprintf('%s/limiters.json', $location))) {
            Debug::info(sprintf('Use limiters from: %s/limiters.json', $location));

            $this->setLimits(json_decode(file_get_contents(sprintf('%s/limiters.json', $location)), true));
        }

        return $this;
    }

    public function useLimits(array $availableChannels)
    {
        $this->initLimits();

        if (count($availableChannels) === 1 && $availableChannels[0] === 'ALL') {
            $this->useLimitersByChannels = false;
        }
    }
    
    public function getLimits(): array
    {
        return $this->limits;
    }

    public function setLimits(array $limits) : IEPGParse
    {
        $this->limits = $limits;

        return $this;
    }

    public function useCallback(\Closure $callback) : IEPGParse
    {
        $this->callback = $callback;
        $this->useCallback = true;

        return $this;
    }

    public function resetCallback() : IEPGParse
    {
        $this->callback = null;
        $this->useCallback = false;

        return $this;
    }

    public function callCallback($currentEpgId, $availableChannels, $epgXMLObject)
    {

    }

    public function parse(EPGAgregation $EPGAgregation, array $availableChannels): array
    {
        Debug::info('Run dimmy parser');
    }
}
