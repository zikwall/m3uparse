<?php

namespace zikwall\m3uparse;

class Playlists
{
    private static $List = [
        'free' => 'free.m3u',
        'free_best_tv' => 'free_best_tv.m3u'
    ];

    public static function set(string $name, string $filename, string $ext = 'm3u') : void
    {
        if(!isset(self::$List[$name])) {
            self::$List[$name] = sprintf('%s.%s', $filename, $ext);
        }
    }

    public static function get(string $name, $ext = 'm3u') : string
    {
        if (!in_array($name, array_keys(self::$List))) {
            return '';
        }

        return sprintf('%s/%s', Helper::getPlaylistUploadDir(), self::$List[$name]);
    }
}
