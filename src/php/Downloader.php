<?php

namespace zikwall\m3uparse;

trait Downloader
{
    public function download(string $path, string $newfname, string $url)
    {
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

    /**
     * Extracted only archive name format like: provider.xml.gz
     *
     * @param $newfname
     * @param int $buffer_size
     */
    public function extractGZXMLArchive($newfname, $buffer_size = 4096)
    {
        $out_file_name = str_replace('.gz', '', $newfname);
        $file = gzopen($newfname, 'rb');
        $out_file = fopen($out_file_name, 'wb');

        while(!gzeof($file)) {
            fwrite($out_file, gzread($file, $buffer_size));
        }

        fclose($out_file);
        gzclose($file);
    }

    public function downloadEPG(string $path, string $name, string $url, string $xmlFileName)
    {
        $newfname = $this->fullEPGArchName($path, $name);
        $xmlFileName = $this->fullEPGName($path, $xmlFileName);

        if (file_exists($xmlFileName)) {
            Debug::info(sprintf('EPG XMLfile: %s exist, delete...', $xmlFileName), 0);
            
            if (!unlink($xmlFileName)) {
                Debug::warn(PHP_EOL . sprintf('EPG XMLfile: %s is not delete!', $xmlFileName), 1);
            } else {
                echo ' -- DELETED!', PHP_EOL;
            }
        }

        if (file_exists($newfname)) {
            Debug::info(sprintf('EPG archive: %s exist, delete...', $newfname), 0);

            if (!unlink($newfname)) {
                Debug::warn(PHP_EOL . sprintf('EPG archive: %s is not delete!', $newfname), 1);
            } else {
                echo ' -- DELETED!', PHP_EOL;
            }
        }

        $this->download($path, $newfname, $url);
        $this->extractGZXMLArchive($newfname);
    }

    public function downloadPlaylist(string $path, string $name, string $url)
    {
        $newfname = $this->fullName($path, $name);

        if (file_exists($newfname)) {
            Debug::info(sprintf('[INFO] File: %s exist, delete...', $newfname), 0);
            unlink($newfname);

            if (file_exists($newfname)) {
                Debug::warn(PHP_EOL . sprintf('[WARN] File: %s is not delete!', $newfname), 1);
            } else {
                echo ' -- DELETED!', PHP_EOL;
            }
        }

        $this->download($path, $newfname, $url);
    }

    public function fullEPGName($path, $name) : string
    {
        return sprintf('%s/%s.xml',$path, $name);
    }

    public function fullEPGArchName($path, $name) : string
    {
        return sprintf('%s/%s',$path, $name);
    }

    public function fullName($path, $name) : string
    {
        return sprintf('%s/%s.m3u',$path, $name);
    }
}
