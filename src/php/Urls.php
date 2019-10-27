<?php

namespace zikwall\m3uparse;

class Urls
{
    const List = [
        'free' => 'free.m3u',
        'free_best_tv' => 'free_best_tv.m3u'
    ];

    public static function get(string $name) : string
    {
        if (!in_array($name, self::List)) {
            return '';
        }

        return sprintf('%s/plists/uploads/%s', dirname(dirname(__DIR__)), $name);
    }
}
