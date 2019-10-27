<?php

namespace zikwall\m3uparse;

class Helper
{
   public static function ROOT() : string
   {
       return dirname(dirname(dirname(dirname(dirname(__DIR__)))));
   }

   public static function getPlaylistUploadDir()
   {
       return self::ROOT() . '/uploads/playlists';
   }

   public static function getEpgUploadDir()
   {
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
