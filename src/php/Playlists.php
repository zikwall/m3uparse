<?php

namespace zikwall\m3uparse;

class Playlists
{
    const List = [
        'free' => 'free.m3u',
        'free_best_tv' => 'free_best_tv.m3u'
    ];

    public static function get(string $name, $ext = 'm3u') : string
    {
        if (!in_array($name, array_keys(self::List))) {
            return '';
        }

        return sprintf('%s/%s.%s', Helper::getPlaylistUploadDir(), $name, $ext);
    }
}
