<?php

namespace zikwall\m3uparse;

use zikwall\m3uparse\parsers\IParse;

class Aggregation
{
    public function __construct(Configure $config = null)
    {
        if (!empty($config->root)) {
            Helper::setRoot($config->root);
        }

        if (!empty($config->playlistUploadDirectory)) {
            Helper::setPlaylistUploadDir($config->playlistUploadDirectory);
        }

        if (!empty($config->epgUploadDirectory)) {
            Helper::setEpgUploadDir($config->epgUploadDirectory);
        }
    }

    final public function merge($channels, IParse...$playlists)
    {
        $result = [];

        foreach ($playlists as $playlist) {
            $items = $playlist->parse();

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
                        'url'    => $item['url']
                    ];
                }
            }
        }

        return $result;
    }
}
