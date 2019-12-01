<?php


namespace zikwall\m3uparse;


class Console
{
    public static function message(string $msg, ...$args) : string
    {
        return sprintf($msg, ...$args);
    }
    
    public static function info($msg, ...$args) : string
    {
        $msg = static::message($msg, $args);
        
        return '[INFO]: ' . $msg;
    }

    public static function warn($msg, ...$args) : string
    {
        $msg = static::message($msg, $args);

        return '[WARN]: ' . $msg;
    }
}
