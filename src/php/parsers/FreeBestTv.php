<?php

namespace zikwall\m3uparse\parsers;

use zikwall\m3uparse\Helper;
use zikwall\m3uparse\Playlists;
use zikwall\m3uparse\Urls;

class FreeBestTv implements IParse
{
    public function parse()
    {
        $sourceUrl = 'http://4pda.ru/pages/go/?u=http%3A%2F%2Ftopplay.do.am%2FFreeBestTV.m3u&e=84875135';
        Helper::download(Helper::getPlaylistUploadDir(), 'free_best_tv', $sourceUrl);

        $source = file_get_contents(Playlists::get('free_best_tv'));
        $items = explode("#EXTINF:-1,", $source);
        $items = array_slice($items, 3);

        $playlist = [];

        foreach ($items as $item) {
            if (strpos($item, 'http') === false) {
                continue;
            }

            list($name, $url) = preg_split('/\r\n|\r|\n/', $item);

            $playlist[] = [
                'name' => trim($name),
                'url'  => trim($url),
                'from' => 'free_best_tv'
            ];
        }

        return $playlist;
    }
}
