<?php

namespace zikwall\m3uparse;

trait Downloader
{
    public function downloadPlaylist(string $path, string $name, string $url)
    {
        $newfname = $this->fullName($path, $name);

        if (file_exists($newfname)) {
            echo sprintf('[INFO] File: %s exist, delete...', $newfname);
            unlink($newfname);

            if (file_exists($newfname)) {
                echo PHP_EOL, sprintf('[WARN] File: %s is not delete!', $newfname), PHP_EOL;
            } else {
                echo ' -- DELETED!', PHP_EOL;
            }
        }

        if (!is_dir($path)) {
            mkdir($path);
            chmod($path, 0755);
        }

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

    public function fullName($path, $name) : string
    {
        return sprintf('%s/%s.m3u',$path, $name);
    }
}
