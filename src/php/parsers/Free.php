<?php

namespace zikwall\m3uparse\parsers;

use zikwall\m3uparse\base\BaseParse;
use zikwall\m3uparse\Helper;
use zikwall\m3uparse\interfaces\IParse;
use zikwall\m3uparse\Playlists;

class Free extends BaseParse implements IParse
{
    public function parse()
    {
        $sourceUrl = 'http://4pda.ru/pages/go/?u=http%3A%2F%2Fiptv2020.ucoz.net%2FFree.m3u&e=70709596';
        Helper::download(Helper::getPlaylistUploadDir(), 'free', $sourceUrl);

        $source = file_get_contents(Playlists::get('free'));
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
                'from' => 'free'
            ];
        }

        return $playlist;
    }

    public function channels() : array
    {
        return json_decode(file_get_contents(Helper::getChannelsDir() . '/free.json'), true);
    }
}
