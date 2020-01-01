<?php

namespace zikwall\m3uparse\parsers\freebesttv;

use zikwall\m3uparse\Aggregation;
use zikwall\m3uparse\base\BaseParse;
use zikwall\m3uparse\interfaces\IParse;

class FreeBestTv extends BaseParse implements IParse
{
    public $name = 'free_best_tv';

    public function parse(Aggregation $aggregation) : array
    {
        $sourceUrl = 'http://4pda.ru/pages/go/?u=http%3A%2F%2Ftopplay.do.am%2FFreeBestTV.m3u&e=84875135';
        $aggregation->downloadPlaylist($aggregation->getPlaylistUploadDirectory(), $this->name, $sourceUrl);

        $source = file_get_contents($aggregation->getPlaylistSource($this->name));
        $items = explode("#EXTINF:-1,", $source);
        $items = array_slice($items, 3);

        $playlist = [];

        foreach ($items as $item) {
            list($name, $url) = preg_split('/\r\n|\r|\n/', $item);

            //if ($this->isSSL($url) === false) {
                //continue;
            //}

            $playlist[] = [
                'name' => trim($name),
                'url'  => trim($url),
                'from' => $this->name,
                'ssl'  => $this->isSSL($url) ? 1 : 0
            ];
        }

        return $playlist;
    }

    public function channels() : array
    {
        return json_decode(file_get_contents(__DIR__ . "/{$this->name}.json"), true);
    }
}
