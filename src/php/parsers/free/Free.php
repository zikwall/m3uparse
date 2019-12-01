<?php

namespace zikwall\m3uparse\parsers\free;

use zikwall\m3uparse\Aggregation;
use zikwall\m3uparse\base\BaseParse;
use zikwall\m3uparse\Helper;
use zikwall\m3uparse\interfaces\IParse;
use zikwall\m3uparse\Playlists;

class Free extends BaseParse implements IParse
{
    public $name = 'free';

    public function parse(Aggregation $aggregation) : array
    {
        $sourceUrl = 'http://4pda.ru/pages/go/?u=http%3A%2F%2Fiptv2020.ucoz.net%2FFree.m3u&e=70709596';
        $aggregation->downloadPlaylist($aggregation->getPlaylistUploadDirectory(), $this->name, $sourceUrl);

        $source = file_get_contents($aggregation->getPlaylistSource($this->name));
        $items = explode("#EXTINF:-1,", $source);
        $items = array_slice($items, 3);
        $playlist = [];

        foreach ($items as $item) {
            list($name, $url) = preg_split('/\r\n|\r|\n/', $item);

            if ($this->isSSL($url) === false) {
                continue;
            }
            
            $playlist[] = [
                'name' => trim($name),
                'url'  => trim($url),
                'from' => $this->name
            ];
        }

        return $playlist;
    }

    public function channels() : array
    {
        return json_decode(file_get_contents(__DIR__. "/{$this->name}.json"), true);
    }
}
