<?php

namespace zikwall\m3uparse;

trait Downloader
{
    public function downloadPlaylist(string $path, string $name, string $url)
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
