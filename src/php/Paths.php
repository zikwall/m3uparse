<?php


namespace zikwall\m3uparse;


trait Paths
{
    public function ifNotExistNotExistCreateUpload()
    {
        if (!is_dir($this->getUploadFolder())) {
            mkdir($this->getUploadFolder(), 0777);
        }
    }

    public function getPlaylistSource($name, $extention = 'm3u')
    {
        return sprintf("%s/{$name}.{$extention}", $this->getPlaylistUploadDirectory());
    }

    public function getEPGSource($name, $extention = 'xml')
    {
        return sprintf("%s/{$name}.{$extention}", $this->getEpgUploadDirectory());
    }

    public function getUploadFolder()
    {
        return sprintf('%s/%s', $this->rootUploadDirectory, $this->uploadFolder);
    }

    public function getPlaylistUploadDirectory()
    {
        return sprintf('%s/%s', $this->getUploadFolder(), 'playlists');
    }

    public function getEpgUploadDirectory()
    {
        return sprintf('%s/%s',  $this->getUploadFolder(), 'epg');
    }
}
