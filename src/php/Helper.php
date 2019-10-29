<?php

namespace zikwall\m3uparse;

class Helper
{
    private static $root = '';
    private static $playlistUploadDir = '';
    private static $epgUploadDir = '';

    public static function setRoot(string $root)
    {
        if (is_dir($root)) {
            self::$root = $root;
        }
    }

    public static function ROOT() : string
    {
        if (!empty(self::$root)) {
            return self::$root;
        }

        return dirname(dirname(dirname(dirname(dirname(__DIR__)))));
    }

    public static function setPlaylistUploadDir(string $newPlaylistDir) : void
    {
        if (is_dir($newPlaylistDir)) {
            self::$playlistUploadDir = $newPlaylistDir;
        }
    }

    public static function setEpgUploadDir(string $newEpgDir) : void
    {
        if(is_dir($newEpgDir)) {
            self::$epgUploadDir = $newEpgDir;
        }
    }

    public static function getPlaylistUploadDir() : string
    {
        if (!empty(self::$playlistUploadDir)) {
            return self::ROOT() . self::$playlistUploadDir;
        }

        return self::ROOT() . '/uploads/playlists';
    }

    public static function getEpgUploadDir() : string
    {
        if (!empty(self::$epgUploadDir)) {
            return self::$epgUploadDir;
        }

        return self::ROOT() . '/uploads/epg';
    }

    public static function download(string $path, string $name, string $url)
    {
        if (!is_dir($path)) {
            mkdir($path);
            chmod($path, 0755);
        }

        $newfname = sprintf('%s/%s.m3u',$path, $name);
        $file = fopen ($url, 'rb');
        if ($file) {
            $newf = fopen ($newfname, 'wb');
            if ($newf) {
                while(!feof($file)) {
                    fwrite($newf, fread($file, 1024 * 8), 1024 * 8);
                }
            }
        }

        if ($file) {
            fclose($file);
        }

        if ($newf) {
            fclose($newf);
        }
    }
}
