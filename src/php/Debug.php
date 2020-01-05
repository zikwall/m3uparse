<?php


namespace zikwall\m3uparse;


class Debug
{
    public static function message(string $head, string $content, int $countBreaks = 1)
    {
        $breacks = '';

        if ($countBreaks > 0) {
            for ($i = 0; $i <= $countBreaks; $i++) {
                $breacks .= PHP_EOL;
            }
        }

        echo $head, ' ', $content, $breacks;
    }

    public static function info(string $content, int $countBreaks = 1)
    {
        static::message('[INFO] ', $content, $countBreaks);
    }

    public static function warn(string $content, int $countBreaks = 1)
    {
        static::message('[WARN] ', $content, $countBreaks);
    }

    public static function error(string $content, int $countBreaks = 1)
    {
        static::message('[ERROR] ', $content, $countBreaks);
    }
}
