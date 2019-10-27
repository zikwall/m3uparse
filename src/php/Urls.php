<?php

namespace zikwall\m3uparse;

class Urls
{
    const List = [
        'free' => 'http://4pda.ru/pages/go/?u=http%3A%2F%2Fiptv2020.ucoz.net%2FFree.m3u&e=70709596',
        'free_best_tv' => 'http://4pda.ru/pages/go/?u=http%3A%2F%2Ftopplay.do.am%2FFreeBestTV.m3u&e=84875135'
    ];

    public static function get(string $name) : string
    {
        if (!in_array($name, array_keys(self::List))) {
            return '';
        }

        return self::List[$name];
    }
}
