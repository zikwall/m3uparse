<?php

namespace zikwall\m3uparse\interfaces;

use zikwall\m3uparse\Aggregation;

interface IParse
{
    public function parse(Aggregation $aggregation) : array ;
    public function channels() : array;
    public function isSSL(string $url) : bool;
}
