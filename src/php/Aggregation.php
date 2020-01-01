<?php

namespace zikwall\m3uparse;

use zikwall\m3uparse\interfaces\IParse;

class Aggregation
{
    use Paths;
    use Downloader;

    /**
     * @var Playlists
     */
    public $playlists = null;
    /**
     * @var string
     */
    public $uploadFolder = '';
    /**
     * @var string
     */
    public $rootUploadDirectory = '';

    public function __construct(Configuration $configuration)
    {
        $this->uploadFolder = $configuration->uploadFolder;
        $this->rootUploadDirectory = $configuration->root;

        $this->ifNotExistNotExistCreateUpload();
    }

    final public function merge(IParse...$playlists)
    {
        $result = [];
        $channels = [];

        foreach ($playlists as $playlist) {
            $channels[] = $playlist->channels();
        }

        $channels = Channels::merge($channels);

        foreach ($playlists as $playlist) {
            $items = $playlist->parse($this);

            foreach ($items as $item) {
                foreach ($channels as $id => $channel) {
                    if (isset($result[$id])) {
                        continue;
                    }

                    if (!in_array($item['name'], $channel['various'])) {
                        continue;
                    }

                    $result[$id] = [
                        'epg_id' => $id,
                        'name'   => $item['name'],
                        'url'    => $item['url'],
                        'ssl'    => $item['ssl'],
                        'image'  => $channel['image'] ? sprintf('http://tv.zikwall.ru/images/logo/%s.png', $channel['image']) : '',
                        'use_origin' => $channel['useOrigin'] ? 1 : 0
                    ];
                }
            }
        }

        return $result;
    }
}
