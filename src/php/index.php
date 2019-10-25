<?php

define('ROOT', dirname(dirname(__DIR__)));

require_once './parsers/Free.php';
require_once './parsers/FreeBestTv.php';
require_once 'Aggregation.php';
require_once 'Channels.php';

$agg = new Aggregation();

print_r(
    $agg->merge(Channels::merge(Channels::get('free'), Channels::get('free_best_tv')), new Free(), new FreeBestTv())
);