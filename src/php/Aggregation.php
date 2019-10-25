<?php

require_once './parsers/IParse.php';

class Aggregation
{
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