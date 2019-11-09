<?php

namespace zikwall\m3uparse;

class Configuration
{
    /**
     * @var string 
     */
    public $root = '';
    
    /**
     * @var string 
     */
    public $uploadFolder = '/uploads';

    /**
     * Configuration constructor.
     * @param string $rootDirectory
     * @param string $uploadFolder
     */
    public function __construct(string $rootDirectory = '', string $uploadFolder = '')
    {
        if ($rootDirectory == '') {
            $rootDirectory = dirname(dirname(dirname(dirname(dirname(__DIR__)))));
        }
        
        $this->root = $rootDirectory;
        
        if ($uploadFolder != '') {
            $this->uploadFolder = $uploadFolder;
        }
    }
}
