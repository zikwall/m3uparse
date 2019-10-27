<?php

namespace zikwall\m3uparse\parsers;

use zikwall\m3uparse\Urls;

class Free implements IParse
{
    public function parse()
    {
        $source = file_get_contents(Urls::get('free'));
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
                'from' => 'free'
            ];
        }

        return $playlist;
    }
}
