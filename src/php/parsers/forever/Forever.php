<?php

namespace zikwall\m3uparse\parsers\forever;

use zikwall\m3uparse\Aggregation;
use zikwall\m3uparse\base\BaseParse;
use zikwall\m3uparse\interfaces\IParse;

class Forever extends BaseParse implements IParse
{
    public $name = 'ForeverIPTV';

    public function parse(Aggregation $aggregation) : array
    {
        $sourceUrl = 'https://webhalpme.ru/if.m3u';
        $aggregation->downloadPlaylist($aggregation->getPlaylistUploadDirectory(), $this->name, $sourceUrl);

        $source = file_get_contents($aggregation->getPlaylistSource($this->name));

        $items = preg_split( "/(#EXTINF:0|#EXTINF:-1|#EXTINF:-1,)/", $source);
        $items = array_slice($items, 1);
        $playlist = [];

        foreach ($items as $item) {
            list($name, $url) = $count = preg_split('/\r\n|\r|\n/', $item);

            if (count($count) > 2 && !empty($count[2])) {
                if (isset($count[2])) {
                    $url = $count[2];
                }
            }

            if (strpos($name, ',') !== false) {
                $ex = explode(',', $name);
                $name = $ex[1];
            }

            $playlist[] = [
                'name' => trim($name),
                'url'  => trim($url),
                'from' => $this->name,
                'ssl'  => $this->isSSL($url) ? 1 : 0
            ];
        }

        return $playlist;
    }
}
