<?php

namespace zikwall\m3uparse\parsers\vasiliy78L;

use zikwall\m3uparse\Aggregation;
use zikwall\m3uparse\base\BaseParse;
use zikwall\m3uparse\Helper;
use zikwall\m3uparse\interfaces\IParse;
use zikwall\m3uparse\Playlists;

class Base extends BaseParse implements IParse
{
    public $name = 'base';

    public function parse(Aggregation $aggregation)
    {
        $sourceUrl = 'https://raw.githubusercontent.com/vasiliy78L/myIPTV/master/iptv.m3u';
        $aggregation->downloadPlaylist($aggregation->getPlaylistUploadDirectory(), $this->name, $sourceUrl);

        $source = file_get_contents($aggregation->getPlaylistSource($this->name));
        // разные делители
        $items = preg_split( "/(#EXTINF:0|#EXTINF:-1|#EXTINF:-1,)/", $source);
        $items = array_slice($items, 1);
        $playlist = [];

        foreach ($items as $item) {

            list($name, $url) = $count = preg_split('/\r\n|\r|\n/', $item);

            // различный формат данных
            if (count($count) >= 3) {
                // иногда встречается больше строк на 1 канал
                if (isset($count[3])) {
                    $url = $count[2];
                } elseif (isset($count[2]) && empty($count[2])) {
                    // бывает 3 элемента, но 3 пустой а ссылка находится во втором
                    $url = $count[1];
                }

                if (strpos($url, ' ') !== false) {
                    $url = explode(' ', $url)[0];
                }
            }

            // иногда встречается пробелы в ссылках
            if (strpos($name, ',') !== false) {
                $ex = explode(',', $name);
                $name = $ex[1];
            }

            $playlist[] = [
                'name' => trim($name),
                'url'  => trim($url),
                'from' => $this->name
            ];
        }

        return $playlist;
    }
}
