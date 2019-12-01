<?php

namespace zikwall\m3uparse\base;

abstract class BaseParse
{
    public $name = 'undefined';

    public function channels() : array
    {
        return [];
    }

    public function isSSL(string $url) : bool
    {
        return strpos($url, 'https') !== false;
    }
}
