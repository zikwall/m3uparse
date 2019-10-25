<?php

require_once dirname(__DIR__) . '/Urls.php';
require_once 'IParse.php';

class FreeBestTv implements IParse
{
    public function parse()
    {
        $source = file_get_contents(Urls::List['free_best_tv']);
        $items = explode("#EXTINF:-1,", $source);
        $items = array_slice($items, 3);

        $playlist = [];

        foreach ($items as $item) {
            if (strpos($item, 'http') === false) {
                continue;
            }

            list($name, $url) = explode(PHP_EOL, $item);

            $playlist[] = [
                'name' => trim($name),
                'url'  => trim($url),
                'from' => 'free_best_tv'
            ];
        }

        return $playlist;
    }
}