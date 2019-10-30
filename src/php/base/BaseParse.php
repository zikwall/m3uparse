<?php

namespace zikwall\m3uparse\base;

abstract class BaseParse
{
    private $channelListFilepath = '';
    private $playlistFilepath = '';

    public function setChannelList(string $path)
    {
        $this->channelListFilepath = $path;
    }

    public function setPlaylist(string $path)
    {
        $this->playlistFilepath = $path;
    }

    public function channels() : array
    {
        return [];
    }
}