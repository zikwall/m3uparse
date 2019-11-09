<?php

namespace zikwall\m3uparse\interfaces;

use zikwall\m3uparse\Aggregation;

interface IParse
{
    public function parse(Aggregation $aggregation);
    public function channels();
}
